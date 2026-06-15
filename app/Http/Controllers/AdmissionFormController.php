<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use DataTables;
use App\AdmissionForm;
use Illuminate\Http\Request;

class AdmissionFormController extends Controller
{
   
    // Show the logged-in student's admission form (create or edit)
    public function studentForm()
    {
        $user = Auth::user();
        $form = AdmissionForm::where('user_id', $user->id)->first();

        return view('admin.admission.student_form', compact('form', 'user'));
    }

    // Save / update the logged-in student's own admission form
    public function studentStore(Request $request)
    {
        $request->validate([
            'student_name'   => 'required|string|max:255',
            'father_name'    => 'nullable|string|max:255',
            'course'         => 'nullable|string|max:255',
            'age'            => 'nullable|string|max:20',
            'phone_no'       => 'nullable|string|max:30',
            'admission_date' => 'nullable|date',
            'address'        => 'nullable|string|max:1000',
            'pic'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $form = AdmissionForm::firstOrNew(['user_id' => $user->id]);

        // Fields the student is allowed to fill
        $form->user_id        = $user->id;
        $form->student_name   = $request->student_name;
        $form->father_name    = $request->father_name;
        $form->course         = $request->course;
        $form->age            = $request->age;
        $form->phone_no       = $request->phone_no;
        $form->admission_date = $request->admission_date;
        $form->address        = $request->address;

        if ($request->hasFile('pic')) {
            $form->pic = $request->file('pic')->store('admissions/images');
        }

        $form->save();

        return response()->json([
            'success' => true,
            'message' => 'Admission form saved successfully!',
        ]);
    }

    /* =========================================================
     |  ADMIN SIDE
     |=========================================================*/

    // Admin list of all admission forms (DataTables)
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = AdmissionForm::query()
                ->leftJoin('users', 'admission_forms.user_id', '=', 'users.id')
                ->select('admission_forms.*', 'users.email as user_email');

            return DataTables::of($query)
                ->addColumn('pic_url', function ($row) {
                    return $row->pic ? asset('storage/' . $row->pic) : null;
                })
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('admin.admission.show', $row->id) . '" class="btn btn-info btn-xs">
                                <i class="fa fa-eye"></i> View
                            </a>
                            <button data-id="' . $row->id . '" class="btn btn-danger btn-xs delete-admission">
                                <i class="fa fa-trash"></i> Delete
                            </button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.admission.index');
    }

    // Admin view / edit a single admission form (full fields incl. roll_no & fee)
    public function show($id)
    {
        $form = AdmissionForm::with('user')->findOrFail($id);
        return view('admin.admission.show', compact('form'));
    }

    // Admin update (can edit everything, including roll_no and fee)
    public function adminUpdate(Request $request, $id)
    {
        $request->validate([
            'student_name'   => 'required|string|max:255',
            'roll_no'        => 'nullable|string|max:50',
            'fee'            => 'nullable|string|max:50',
            'father_name'    => 'nullable|string|max:255',
            'course'         => 'nullable|string|max:255',
            'age'            => 'nullable|string|max:20',
            'phone_no'       => 'nullable|string|max:30',
            'admission_date' => 'nullable|date',
            'address'        => 'nullable|string|max:1000',
            'pic'            => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $form = AdmissionForm::findOrFail($id);
        $form->fill($request->only([
            'roll_no', 'student_name', 'father_name', 'course',
            'age', 'fee', 'phone_no', 'admission_date', 'address',
        ]));

        if ($request->hasFile('pic')) {
            $form->pic = $request->file('pic')->store('admissions/images');
        }

        $form->save();

        return response()->json([
            'success' => true,
            'message' => 'Admission form updated successfully!',
        ]);
    }

    public function destroy(Request $request)
    {
        $form = AdmissionForm::find($request->id);
        if ($form) {
            $form->delete();
            return response()->json(['status' => 200, 'message' => 'Deleted successfully']);
        }
        return response()->json(['status' => 404, 'message' => 'Not found'], 404);
    }
}
