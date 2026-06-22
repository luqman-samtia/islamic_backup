<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use DataTables;
use App\FeeRecord;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FeeRecordController extends Controller
{
    /* =========================================================
     |  ADMIN SIDE
     |=========================================================*/

    // List of students to pick from (DataTables) for fee management
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = User::where('type', 'student')->select('id', 'name', 'email', 'contact_no');

            return DataTables::of($query)
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.fees.manage', $row->id) . '" class="btn btn-primary btn-xs">
                                <i class="fa fa-money"></i> Manage Fee
                            </a>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.fees.index');
    }

    // Show the 12-month fee sheet for one student for a given year
    public function manage(Request $request, $id)
    {
        $student = User::where('type', 'student')->findOrFail($id);
        $year    = $request->input('year', date('Y'));

        // Build a row for every month, filling existing data
        $existing = FeeRecord::where('user_id', $id)->where('year', $year)
            ->get()->keyBy('month');

        $rows = [];
        foreach (FeeRecord::$months as $num => $name) {
            $rec = $existing->get($num);
            $rows[] = [
                'month'       => $num,
                'month_name'  => $name,
                'monthly_fee' => $rec->monthly_fee ?? 0,
                'received'    => $rec->received ?? 0,
                'outstanding' => $rec->outstanding ?? 0,
                'paid_date'   => optional($rec)->paid_date,
                'proof'       => optional($rec)->proof,
                'status'      => $rec->status ?? 'pending',
            ];
        }

        // Year dropdown range
        $years = range(date('Y') + 1, 2022);

        return view('admin.fees.manage', compact('student', 'rows', 'year', 'years'));
    }

    // Save all 12 months for a student/year at once
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'year'    => 'required|integer',
            'months'  => 'required|array',
        ]);

        foreach ($request->months as $month => $data) {
            $monthlyFee  = (float) ($data['monthly_fee'] ?? 0);
            $received    = (float) ($data['received'] ?? 0);
            // Auto-calc outstanding if not supplied
            $outstanding = isset($data['outstanding']) && $data['outstanding'] !== ''
                ? (float) $data['outstanding']
                : max($monthlyFee - $received, 0);

            FeeRecord::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'year'    => $request->year,
                    'month'   => (int) $month,
                ],
                [
                    'monthly_fee' => $monthlyFee,
                    'received'    => $received,
                    'outstanding' => $outstanding,
                    'paid_date'   => $data['paid_date'] ?? null,
                    'status'      => in_array(($data['status'] ?? null), array_keys(FeeRecord::$statuses))
                                        ? $data['status']
                                        : 'pending',
                    // NOTE: 'proof' intentionally NOT set here so the admin's
                    // save never wipes a screenshot the student uploaded.
                ]
            );
        }

        return response()->json([
            'success' => true,
            'message' => 'Fee record saved successfully!',
        ]);
    }

    /* =========================================================
     |  STUDENT SIDE  (view own fee report - read only)
     |=========================================================*/

    // public function myFees(Request $request)
    // {
    //     $user = Auth::user();
    //     $year = $request->input('year', date('Y'));

    //     $existing = FeeRecord::where('user_id', $user->id)->where('year', $year)
    //         ->get()->keyBy('month');

    //     $rows = [];
    //     $totalFee = $totalReceived = $totalOutstanding = 0;
    //     foreach (FeeRecord::$months as $num => $name) {
    //         $rec = $existing->get($num);
    //         $fee = $rec->monthly_fee ?? 0;
    //         $rcv = $rec->received ?? 0;
    //         $out = $rec->outstanding ?? 0;
    //         $totalFee += $fee; $totalReceived += $rcv; $totalOutstanding += $out;
    //         $rows[] = [
    //             'month'       => $num,
    //             'month_name'  => $name,
    //             'monthly_fee' => $fee,
    //             'received'    => $rcv,
    //             'outstanding' => $out,
    //             'paid_date'   => optional($rec)->paid_date,
    //             'proof'       => optional($rec)->proof,
    //             'status'      => $rec->status ?? 'pending',
    //         ];
    //     }

    //     $years = FeeRecord::where('user_id', $user->id)
    //         ->selectRaw('DISTINCT year')->orderBy('year', 'desc')->pluck('year');
    //     if ($years->isEmpty()) $years = collect([date('Y')]);

    //     return view('admin.fees.my_fees', compact(
    //         'rows', 'year', 'years', 'totalFee', 'totalReceived', 'totalOutstanding'
    //     ));
    // }
    public function myFees(Request $request)
    {
        $user = Auth::user();
        $year = $request->input('year', date('Y'));

        $existing = FeeRecord::where('user_id', $user->id)->where('year', $year)
            ->get()->keyBy('month');

        $rows = [];
        $totalFee = $totalReceived = $totalOutstanding = $totalAdvance = 0;  
        foreach (FeeRecord::$months as $num => $name) {
            $rec = $existing->get($num);
            $fee = $rec->monthly_fee ?? 0;
            $rcv = $rec->received ?? 0;

            $out     = max($fee - $rcv, 0);
            $advance = max($rcv - $fee, 0);         

            $totalFee += $fee; $totalReceived += $rcv;
            $totalOutstanding += $out;
            $totalAdvance += $advance;          

            $rows[] = [
                'month'       => $num,
                'month_name'  => $name,
                'monthly_fee' => $fee,
                'received'    => $rcv,
                'outstanding' => $out,
                'advance'     => $advance,          
                'paid_date'   => optional($rec)->paid_date,
                'proof'       => optional($rec)->proof,
                'status'      => $rec->status ?? 'pending',
            ];
        }

        $years = FeeRecord::where('user_id', $user->id)
            ->selectRaw('DISTINCT year')->orderBy('year', 'desc')->pluck('year');
        if ($years->isEmpty()) $years = collect([date('Y')]);

        return view('admin.fees.my_fees', compact(
            'rows', 'year', 'years', 'totalFee', 'totalReceived', 'totalOutstanding', 'totalAdvance'
        ));
    }

    // Student uploads a payment screenshot for one month -> status back to pending
    public function uploadProof(Request $request)
    {
        $request->validate([
            'year'  => 'required|integer',
            'month' => 'required|integer|min:1|max:12',
            'proof' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $user = Auth::user();

        $rec = FeeRecord::firstOrNew([
            'user_id' => $user->id,
            'year'    => $request->year,
            'month'   => (int) $request->month,
        ]);

        $rec->proof  = $request->file('proof')->store('fees/proofs');
        $rec->status = 'pending';   // awaiting admin verification
        $rec->save();

        return response()->json([
            'success' => true,
            'message' => 'Payment proof uploaded. Waiting for admin to verify.',
            'proof_url' => asset('storage/' . $rec->proof),
        ]);
    }
    public function deleteProof(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'year'    => 'required|integer',
            'month'   => 'required|integer|min:1|max:12',
        ]);

        $rec = FeeRecord::where('user_id', $request->user_id)
            ->where('year', $request->year)
            ->where('month', (int) $request->month)
            ->first();

        if ($rec && $rec->proof) {
            Storage::delete($rec->proof);   
            $rec->proof = null;
            $rec->save();
        }

        return response()->json(['success' => true, 'message' => 'Proof deleted.']);
    }

    public function replaceProof(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'year'    => 'required|integer',
            'month'   => 'required|integer|min:1|max:12',
            'proof'   => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $rec = FeeRecord::firstOrNew([
            'user_id' => $request->user_id,
            'year'    => $request->year,
            'month'   => (int) $request->month,
        ]);

        if ($rec->proof) {
            Storage::delete($rec->proof); 
        }

        $rec->proof = $request->file('proof')->store('fees/proofs');
        $rec->save();

        return response()->json([
            'success'   => true,
            'message'   => 'Proof updated.',
            'proof_url' => asset('storage/' . $rec->proof),
        ]);
    }
}
