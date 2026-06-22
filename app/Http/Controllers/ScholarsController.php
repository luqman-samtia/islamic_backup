<?php

namespace App\Http\Controllers;

use Auth;
use App\Slug;
use App\User;
use DataTables;
use App\Student;
use App\Scholars;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ScholarsController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()){
            return DataTables::of(Scholars::query())->addColumn('image_complete_url', function($query){
                return ($query->image) ? asset('storage/'.$query->image) : null;
            })->make(true);
        }
        return view('admin.scholars.index');
    }


    public function add(Request $request){
        if ($request->post()){

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',  
                'phone' => 'required|min:11|unique:scholars,phone',
                'salary' => 'max:10',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $data = $request->except('image');
              // Add new fields to $data array
            $data['salary'] = $request->input('salary');
            $data['email'] = $request->input('email');
            $data['phone'] = $request->input('phone');
            $data['cnic'] = $request->input('cnic');
            $data['notes'] = $request->input('notes');
            $data['address'] = $request->input('address');
            // dd($data);
            // exit();
            if ($request->hasFile('image')){
                $path = $request->image->store('scholars/images');
                $data['image'] = $path;
            }
            $scholar = Scholars::create($data);

            
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'contact_no' => $request->input('phone'), 
                'is_verified' => 1, 
                'type' => 'scholar', 
            ]);
            return redirect()->route('scholars');
        }
        return view('admin.scholars.add');
    }

    public function edit(Request $request, Scholars $scholar){

        $user = User::where('email', $scholar->email)->first();
        if ($request->post()){

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users,email,' . ($user ? $user->id : 'NULL'),
                'password' => 'nullable|min:8',
                'phone' => 'required',
                'salary' => 'max:10',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $scholar->name = $request->name;
            $scholar->email = $request->email;
            $scholar->salary = $request->salary;
            $scholar->phone = $request->phone;
            $scholar->address = $request->address;
            $scholar->cnic = $request->cnic;
            $scholar->notes = $request->notes;
            $scholar->sort = $request->sort;
            if ($request->hasFile('image')){
                $path = $request->image->store('scholars/images');
                $scholar->image = $path;
            }
            $scholar->save();

             // Update User if exists
        if ($user) {
                $user->name       = $request->input('name');
                $user->email      = $request->input('email');
                $user->contact_no = $request->input('phone'); 
                
                if ($request->filled('password')) {
                    $user->password = Hash::make($request->input('password'));
                }
                $user->save();
            } else {
                User::create([
                    'name'        => $request->input('name'),
                    'email'       => $request->input('email'),
                    'password'    => Hash::make($request->input('password')),
                    'contact_no'  => $request->input('phone'), 
                    'is_verified' => 1, 
                    'type'        => 'scholar', 
                ]);
            }
            return redirect()->route('scholars');
        }
        return view('admin.scholars.edit', compact('scholar', 'user'));
    }
    // public function delete(Request $request){
    //     Scholars::find($request->id)->delete();
    //     return ['status' => 200];
    // }

    public function getStudents(Request $request){
        $user_email = Auth::user()->email;
        $scholar_id = Scholars::where('email', $user_email)->first()->id;
        if ($request->ajax()) {
            $query = User::where('scholar', $scholar_id)->where('type', 'student');

                if ($request->filled('student_id')) {
                    $query->where('id', $request->student_id);
                }
             return DataTables::of($query)
            ->addColumn('lessons_action', function($row) {
                return '
                    <a href="'.route('admin.lessons.entry', $row->id).'" class="btn btn-primary btn-xs" title="Lessons">
                        <i class="fa fa-book"></i> Lessons
                    </a>
                    <a href="'.route('admin.lessons.report').'?student_id='.$row->id.'" class="btn btn-default btn-xs" title="Report">
                        <i class="fa fa-file-text"></i> Report
                    </a>';
            })
            ->rawColumns(['lessons_action'])
            ->make(true);
        }
        return view('admin.scholars.students');
    }

    /**
 * Get students details - Title and Link with filters
 */
public function studentsDetails(Request $request){
    $user = Auth::user();
    
    if ($user->type === 'admin') {
        $studentUsers = User::where('type', 'student')->where('is_verified', 1)->pluck('id');
    } else {
        $user_email = $user->email;
        $scholar = Scholars::where('email', $user_email)->first();
        
        if (!$scholar) {
            return response()->json(['error' => 'Scholar not found'], 404);
        }

        $scholar_id = $scholar->id;
        $studentUsers = User::where('scholar', $scholar_id)
                           ->where('type', 'student')
                           ->pluck('id');
    }

    $query = Student::whereIn('user_id', $studentUsers)
                    ->select('id', 'user_id', 'title', 'link', 'created_at')
                    ->orderBy('created_at', 'desc');

    if ($request->has('year') && $request->year != '') {
        $query->whereYear('created_at', $request->year);
    }

    if ($request->has('month') && $request->month != '') {
        $query->whereMonth('created_at', $request->month);
    }

    if ($request->has('student_id') && $request->student_id != '') {
        $query->where('user_id', $request->student_id);
    }

    $studentsData = $query->get();

    $years = Student::whereIn('user_id', $studentUsers)
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');

    $students = User::whereIn('id', $studentUsers)
                    ->select('id', 'name')
                    ->orderBy('name')
                    ->get();

    $monthColors = [
        1 => '#FF6B6B',   
        2 => '#FF8E72',
        3 => '#FFA726',
        4 => '#FFD54F',
        5 => '#81C784',
        6 => '#64B5F6',
        7 => '#42A5F5',
        8 => '#7E57C2',
        9 => '#AB47BC',
        10 => '#EC407A',
        11 => '#29B6F6',
        12 => '#26C6DA'    
    ];

    return view('admin.scholars.students_details', compact('studentsData', 'years', 'students', 'monthColors'));
}
    public function delete(Request $request)
{
    $scholar = Scholars::find($request->id);

    if ($scholar) {
        $user = User::where('email', $scholar->email)->first();
        $scholar->delete();
        if ($user) {
            $user->delete();
        }

        return response()->json(['status' => 200, 'message' => 'Scholar and associated user deleted successfully']);
    }

    return response()->json(['status' => 404, 'message' => 'Scholar not found'], 404);
}

}
