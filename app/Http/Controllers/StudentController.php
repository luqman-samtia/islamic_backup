<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\AdminVerification;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentVerified;
use App\Mail\StudentDisable;
use App\User;
use App\Scholars;
use Hash;
use Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Cookie;
use DataTables;
use Illuminate\Support\Facades\Log;
use App\Information;
use App\Feedback;
use App\Student;

class StudentController extends Controller
{
     // Register new student
     public function register(Request $request){
        if ($request->post()){
              // Validate the input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',  
            'password' => 'required|string|min:8|confirmed',  
            'contact_no' => 'required|min:11|unique:users',  
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'contact_no.required' => 'The contact field is required.',
            'email.unique' => 'This email is already registered.',
            'contact_no.unique' => 'This contact is already registered.',
            'password.required' => 'The password field is required.',
            'password.confirmed' => 'Passwords do not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'contact_no.min' => 'Contact must be at least 11 characters.',
            'password.string' => 'Password must be string.',
            // 'image.required' => 'The image field is required.',
            // 'image.image' => 'The file must be an image.',
            // 'image.mimes' => 'Only jpeg, png, jpg, and gif formats are allowed.',
            // 'image.max' => 'Image size must not exceed 2MB.',
        ]);

       
        $validatedData['password'] = Hash::make($request->password);
        $validatedData['type'] = 'student';  // Set type to 'student'
        $validatedData['is_verified'] = 0;   // Mark as not verified

        // Handle the image upload
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imageName = time() . '.' . $image->getClientOriginalExtension();
        //     // Move the image to storage/app/public/images/students
        //     $image->storeAs('images/students', $imageName, 'public');
        //     $validatedData['image'] = $imageName; // Store image name in the database
        // }
            $user = User::create($validatedData);
          
            // Send email to admin for verification
            Mail::to('luqmansamtia617@gmail.com')->send(new AdminVerification($user));
            
            return response()->json(['message' => 'Registration successful! Waiting for admin approval.']);
        }
        // return view('student.register');
    }

    // Student login
    public function login(Request $request)
    {
        // Validate the input data
        $validatedData = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (!$user) {
            return response()->json(['error' => 'This email is not found in our database.'], 404);
        }
        if ($user->type === 'student' && !$user->is_verified) {
            return response()->json(['error' => 'Your account is not verified by the admin yet.'], 403);
        }
        if (Auth::attempt($request->only('email', 'password'))) {
            return response()->json(['success' => true, 'message' => 'Login successful'], 200);
        }
    
        return response()->json(['error' => 'Invalid password.'], 401);
    }
    
    public function verifyStudent($id){
        $user = User::find($id);
        $user->is_verified = 1; 
        $user->save();
        
        Mail::to($user->email)->send(new StudentVerified($user));
    
        return redirect()->route('site')->with('success', 'Student verified successfully!');
    }


    public function adminVerifyStudent(Request $request){
    $user = User::find($request->id);
    
    if (!$user) {
        return response()->json(['error' => 'Student not found!'], 404);
    }

    if ($user->is_verified == 1) {
        return response()->json(['error' => 'Student is already verified!'], 400);
    }
    // if ($user) {
        $user->is_verified = 1;
        $user->save();

        Mail::to($user->email)->send(new StudentVerified($user));

        return response()->json(['success' => 'Student verified successfully!']);
    // }

    // return response()->json(['error' => 'Student not found!'], 404);
    }
    public function adminDisableStudent(Request $request){
    $user = User::find($request->id);
    
    if (!$user) {
        return response()->json(['error' => 'Student not found!'], 404);
    }

    if ($user->is_verified == 0) {
        return response()->json(['error' => 'Student is already Disble!'], 400);
    }
        $user->is_verified = 0;
        $user->save();

        Mail::to($user->email)->send(new StudentDisable($user));

        return response()->json(['success' => 'Student Disabled successfully!']);
    
    }
   
    public function checkStudentStatus($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['error' => 'Student not found!'], 404);
        }
    
        return response()->json(['is_verified' => $user->is_verified == 1]);
    }
    public function checkStudentDisable($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(['error' => 'Student not found!'], 404);
        }
    
        return response()->json(['is_verified' => $user->is_verified == 0]);
    }

    public function logout(Request $request)
{
   
    if (Auth::check()) {
        Auth::logout(); 

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        session()->flash('success', 'Logout successful!');
          return response()->json(['success' => true, 'redirect' => route('site')]);
    }

    
    return redirect()->back()->with('message', 'You are not authorized to log out.');
}

        public function students(Request $request){

            if ($request->ajax()) {
        
                $data = DataTables::of(User::where('type', 'student')
                ->leftJoin('scholars', 'users.scholar', '=', 'scholars.id')
                ->select('users.*', 'scholars.name as scholar_name')
                )
                ->addColumn('scholar', function($row) {
                    return $row->scholar_name ?? 'No Scholar';
                })
                ->make(true);
    
            \Log::info($data); // Log the data to check its structure
            return $data;
            }
            $scholars = Scholars::pluck('name', 'id');
            // $students = User::where('type','student');
            return view('admin.students.index', compact('scholars'));
        }
        public function getStudent($id)
        {
            $student = User::where('id', $id)->where('type', 'student')->firstOrFail();
            return response()->json($student);
        }

        // Assign scholars to students
        public function assignScholar(Request $request)
        {
            $request->validate([
                'id' => 'required|exists:users,id',
                'scholar' => 'required|exists:scholars,id',
            ]);

            $student = User::find($request->id);
            $student->scholar = $request->scholar;
            $student->save();

            return response()->json(['success' => 'Scholar assigned successfully.']);
        }
        public function students_destroy(Request $request){

            User::find($request->id)->delete();
            return ['status' => 200];
            return view('admin.students.index');
        }





        // Multi Student section
        public function showAddLinksForm(Request $request, $id){

            $data['student_id'] = $id;
         

            $data['info'] = Student::where('user_id',$id)->get();
           
            return view('admin.students.multiStudent', $data);
        }

        public function update(Request $request)
    {
        $studentId =  $request->input('student_id');
        
        $studentItems = $request->input('student_items', []);

        foreach ($studentItems as $item) {
            // Using updateOrCreate to add or update each link entry based on student_id and title
            Student::updateOrCreate([         
              'user_id'=>$studentId,
            'type' => $item['type'],
            'title' => $item['title'],
            'link' => $item['link'],
        ]);
        }

         // Return a JSON response for success
         return response()->json(['success' => true]);
    }
    
    public function removeStudentItem(Request $request){
        // Get the ID of the student item to delete
        $itemId = $request->input('item_id'); // This should be the ID of the record
    
        // Find the specific student item
        $studentItem = Student::find($itemId);
    
        if ($studentItem) {
            $studentItem->delete();
            return response()->json(['success' => true, 'message' => 'Item deleted successfully']);
        } else {
            // Optionally, you can log this event or handle it differently
            return response()->json(['success' => true, 'message' => 'Item not found, but treated as deleted'], 200);
        }
    }

    public function StudentDataShow(){
        $student_id = Auth::user()->id;
        $studentData = Student::where('user_id',$student_id)->get();
            // dd($studentData[0]->link);
        return view('admin.students.data',compact('studentData'));
    }

    public function StudentUpdatePassword(Request $request){
      // Validate the input data for password update
      $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|string|min:8|confirmed',
    ], [
        'current_password.required' => 'Please enter your current password.',
        'new_password.required' => 'Please enter a new password.',
        'new_password.min' => 'New password must be at least 8 characters long.',
        'new_password.confirmed' => 'New password confirmation does not match.',
    ]);

    $user = Auth::user();

    // Check if the current password is correct
    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['error' => 'Current password is incorrect.'], 400);
    }

    // Update the password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['success' => true, 'message' => 'Password updated successfully.']);

    }

//     public function showFeedback()
//  {
//     $feedback = Feedback::where('user_id', Auth::id())->first();
//     return view('admin.students.feedback.index', compact('feedback'));
//  }

        public function showFeedback(Request $request)
        {
            if ($request->ajax()) {
                return DataTables::of(
                    Feedback::where('user_id', Auth::id())
                )->addColumn('image_complete_url', function($query) {
                    return ($query->image) ? asset('storage/'.$query->image) : null;
                })->make(true);
            }

            return view('admin.students.feedback.index');
        }

//  new add feedback
    public function addFeedback(Request $request){
        if ($request->post()){
            $data = $request->except('image');
            $data['user_id'] = auth()->id();
            // dd($data['user_id']);
            if ($request->hasFile('image')){
                $path = $request->image->store('testimonials/images');
                $data['image'] = $path;
            }
            $scholar = Feedback::create($data);
            return redirect()->route('student.feedback.submit');
        }
        return view('admin.students.feedback.add');
    }

    public function editFeedback(Request $request, Feedback $testimonial){
        if ($request->post()){
            $testimonial->title = $request->title;
            $testimonial->feedback = $request->feedback;
            if ($request->hasFile('image')){
                $path = $request->image->store('testimonials/images');
                $testimonial->image = $path;
            }
            $testimonial->save();
            return redirect()->route('student.feedback.submit');
        }
        return view('admin.students.feedback.edit', compact('testimonial'));
    }

    public function deleteFeedback(Request $request){
        Feedback::find($request->id)->delete();
        return ['status' => 200];
    }

    // End Feedback Methpds



    public function submitFeedback(Request $request)
 {
    $request->validate([
        'title' => 'required|string|min:1|max:30',
        'feedback' => 'required|string|max:1000',
    ]);

    // Retrieve feedback for the authenticated user, if it exists
    $feedback = Feedback::where('user_id', Auth::id())->first();
    $message = '';

    if ($feedback) {
        // Update existing feedback
        $feedback->update([
            'title' => $request->title,
            'feedback' => $request->feedback,
        ]);
        $message = 'Feedback updated successfully';
    } else {
        // Create new feedback entry
        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'feedback' => $request->feedback,
        ]);
        $message = 'Feedback submitted successfully';
    }

    // Return success response with feedback data for immediate display
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => [
            'title' => $feedback->title,
            'feedback' => $feedback->feedback,
        ]
    ]);
}

public function getFeedback(Request $request, $id)
{
    $feedback = Feedback::where('user_id', $id)->first();
    // dd( $student);
    // die;
    if ($feedback) {
        
        // $student = User::where('id',$id)->first(); 
        // return response()->json([
        //     'success' => true,
        //     'data' => [
        //         'student_name' => $student->name,
        //         'title' => $feedback->title,
        //         'feedback' => $feedback->feedback,
        //     ],
        // ]);
        if ($request->ajax()) {
            $feedbacks = Feedback::where('user_id', $id)->get();
            
            // if ($feedbacks->isEmpty()) {
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Feedback not added by student yet',
            //     ], 404);
            // }
    
            return DataTables::of($feedbacks)
                ->addColumn('image_complete_url', function($query) {
                    return ($query->image) ? asset('storage/' . $query->image) : null;
                })->make(true);
        }
        return view('admin.students.feedback.index', compact('student'));

    } else {
        return response()->json(['success' => false, 'message' => 'Feedback not added by student yet'], 404);
    }
   
}

public function showStudentFeedbacks(Request $request, $id)
{
    if ($request->ajax()) {
        $feedbacks = Feedback::where('user_id', $id)->get();
        
        if ($feedbacks->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Feedback not added by student yet',
            ], 404);
        }

        return DataTables::of($feedbacks)
            ->addColumn('image_complete_url', function($query) {
                return ($query->image) ? asset('storage/' . $query->image) : null;
            })->make(true);
    }

    $student = User::findOrFail($id);

    return view('admin.students.feedback.admin_index', compact('student'));
}



}
