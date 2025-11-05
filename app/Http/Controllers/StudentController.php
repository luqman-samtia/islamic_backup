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
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\ResetsPasswords;

class StudentController extends Controller
{
     // Register new student
     public function register(Request $request){
        $code = $request->input('country_code');             
        $raw = ltrim($request->input('contact_raw'), '0');   

        $formattedContact = "($code) $raw";                  
        $request->merge([
            'contact_no' => $formattedContact
        ]);
        if ($request->post()){
            
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
           
        ]);

       
        $validatedData['password'] = Hash::make($request->password);
        $validatedData['type'] = 'student';  // Set type to 'student'
        $validatedData['is_verified'] = 0;   // Mark as not verified

        
            $user = User::create($validatedData);
          
           
            try {
                Mail::to('luqmansamtia617@gmail.com')->send(new AdminVerification($user));
                $successMessage = 'Registration successful! Waiting for admin approval.';
            } catch (\Exception $e) {
                // Log the error for debugging
                \Log::error('Mail sending failed: ' . $e->getMessage());
                $successMessage = 'Registration successful! However, we were unable to send an email notification to the admin.';
            }
            return response()->json(['message' => $successMessage]);
        }
       
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

        $loginType = $request->login_type;
        $user = User::where('email', $request->email)->first();
         if ($user->type !== $loginType) {
            return response()->json([
                'error' => 'You are not authorized to login as ' . $loginType . '. Your account type is ' . $user->type . '.'
            ], 403);
        }
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
        
        // Mail::to($user->email)->send(new StudentVerified($user));
    
        try {
            Mail::to($user->email)->send(new StudentVerified($user));
            $successMessage = 'Student verified successfully!';
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            $successMessage = 'Student verified successfully! However, we were unable to send an email notification';
        }
        return response()->json(['success' => $successMessage]);

    }


    public function adminVerifyStudent(Request $request){
    $user = User::find($request->id);
    
    if (!$user) {
        return response()->json(['error' => 'Student not found!'], 404);
    }

    if ($user->is_verified == 1) {
        return response()->json(['error' => 'Student is already verified!'], 400);
    }
        $user->is_verified = 1;
        $user->save();

        try {
            Mail::to($user->email)->send(new StudentVerified($user));
            $successMessage = 'Student verified successfully!';
        } catch (\Exception $e) {
            
            \Log::error('Mail sending failed: ' . $e->getMessage());
            $successMessage = 'Student verified successfully! However, we were unable to send an email notification';
        }
    
        return redirect()->route('site')->with('success', $successMessage);
   
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

 
        try {
            Mail::to($user->email)->send(new StudentDisable($user));
            $successMessage = 'Student Disabled successfully!!';
        } catch (\Exception $e) {
         
            \Log::error('Mail sending failed: ' . $e->getMessage());
            $successMessage = 'Student Disabled successfully!! However, we were unable to send an email notification';
        }

        return response()->json(['success' => $successMessage]);
    
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
                ->addColumn('password_action', function($row) {
                    return '<button type="button" data-id="'.$row->id.'" class="btn btn-warning btn-xs change-password">
                                <i class="fa fa-key"></i> Change Password
                            </button>';
                })
                ->rawColumns(['password_action'])
                ->make(true);
    
            \Log::info($data); 
            
            return $data;
            }
            $scholars = Scholars::pluck('name', 'id');
            return view('admin.students.index', compact('scholars'));
    }

    public function updateDates(Request $request, $id)
    {
        $request->validate([
            'created_at' => 'required|date_format:Y-m-d',
            'leave_date' => 'nullable|date_format:Y-m-d',
        ]);

        try {
            $student = User::findOrFail($id);
            
            $student->created_at = $request->created_at;
            $student->leave_date = $request->leave_date ?: null;
            $student->save();

            return response()->json([
                'success' => 'Student dates updated successfully!'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Change student password
     */
    public function changeStudentPassword(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'new_password' => 'required|min:8|confirmed'
        ]);

        $user = User::find($request->student_id);

        if ($user->type !== 'student') {
            return response()->json(['error' => 'Invalid user'], 403);
        }

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return response()->json(['success' => 'Password updated successfully']);
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

    //     public function update(Request $request)
    // {
    //     $studentId =  $request->input('student_id');
        
    //     $studentItems = $request->input('student_items', []);

    //     foreach ($studentItems as $item) {
    //         Student::updateOrCreate([         
    //           'user_id'=>$studentId,
    //         'type' => $item['type'],
    //         'title' => $item['title'],
    //         'link' => $item['link'],
    //         'created_at' => $item['created_at'],
    //     ]);
    //     }

    //      return response()->json(['success' => true]);
    // }
  public function update(Request $request)
{
    $studentId = $request->input('student_id');
    $studentItems = $request->input('student_items', []);

    // Get existing items
    $existingItems = Student::where('user_id', $studentId)->get();
    $existingIds = $existingItems->pluck('id')->toArray();
    $submittedIds = [];

    foreach ($studentItems as $item) {
        // Check if this is an existing record (has an id that exists in DB)
        if (!empty($item['id']) && is_numeric($item['id']) && in_array((int)$item['id'], $existingIds)) {
            // Update existing record
            Student::where('id', $item['id'])->update([
                'type' => $item['type'] ?? 'Student',
                'title' => $item['title'],
                'link' => $item['link'],
                'created_at' => $item['created_at'],
            ]);
            $submittedIds[] = (int)$item['id'];
        } else {
            // Create new record (id is null or doesn't exist)
            $newRecord = Student::create([         
                'user_id' => $studentId,
                'type' => $item['type'] ?? 'Student',
                'title' => $item['title'],
                'link' => $item['link'],
                'created_at' => $item['created_at'],
            ]);
            $submittedIds[] = $newRecord->id;
        }
    }

    // Delete records that were not submitted (removed items)
    Student::where('user_id', $studentId)
        ->whereNotIn('id', $submittedIds)
        ->delete();

    return response()->json(['success' => true]);
}
    
    public function removeStudentItem(Request $request){
        $itemId = $request->input('item_id'); 
    
        $studentItem = Student::find($itemId);
    
        if ($studentItem) {
            $studentItem->delete();
            return response()->json(['success' => true, 'message' => 'Item deleted successfully']);
        } else {
            return response()->json(['success' => true, 'message' => 'Item not found, but treated as deleted'], 200);
        }
    }

   public function StudentDataShow(Request $request){
    $student_id = Auth::user()->id;
    
    $query = Student::where('user_id', $student_id)
                    ->select('id', 'user_id', 'title', 'link', 'created_at')
                    ->orderBy('created_at', 'desc');

    if ($request->has('year') && $request->year != '') {
        $query->whereYear('created_at', $request->year);
    }

    if ($request->has('month') && $request->month != '') {
        $query->whereMonth('created_at', $request->month);
    }
    
    $studentData = $query->get();

    $years = Student::where('user_id', $student_id)
                    ->selectRaw('YEAR(created_at) as year')
                    ->distinct()
                    ->orderBy('year', 'desc')
                    ->pluck('year');

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
 $studentDate = User::where('id', $student_id)
                    ->select('id', 'created_at', 'leave_date')
                    ->orderBy('created_at', 'desc')
                    ->first();
    return view('admin.students.data', compact('studentData', 'years', 'monthColors', 'studentDate'));
}

    public function StudentUpdatePassword(Request $request){
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

    if (!Hash::check($request->current_password, $user->password)) {
        return response()->json(['error' => 'Current password is incorrect.'], 400);
    }

    $user->password = Hash::make($request->new_password);
    $user->save();

    return response()->json(['success' => true, 'message' => 'Password updated successfully.']);

    }
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

    public function addFeedback(Request $request){
        if ($request->post()){
            $data = $request->except('image');
            $data['user_id'] = auth()->id();
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

    public function submitFeedback(Request $request)
 {
    $request->validate([
        'title' => 'required|string|min:1|max:30',
        'feedback' => 'required|string|max:1000',
    ]);

    $feedback = Feedback::where('user_id', Auth::id())->first();
    $message = '';

    if ($feedback) {
        $feedback->update([
            'title' => $request->title,
            'feedback' => $request->feedback,
        ]);
        $message = 'Feedback updated successfully';
    } else {
        $feedback = Feedback::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'feedback' => $request->feedback,
        ]);
        $message = 'Feedback submitted successfully';
    }

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
   
    if ($feedback) {
        
        if ($request->ajax()) {
            $feedbacks = Feedback::where('user_id', $id)->get();
    
    
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

 public function forgotPasswordRequest(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email|exists:users,email',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $status = Password::sendResetLink(
        $request->only('email')
    );

    if ($status === Password::RESET_LINK_SENT) {
        return response()->json(['success' => true, 'message' => 'Password reset link sent to your email.']);
    }

    return response()->json(['error' => 'Unable to send reset link. Try again later.'], 500);
}
public function showResetForm(Request $request, $token)
{
    return redirect('/?token=' . $token . '&email=' . urlencode($request->email));
}

public function submitResetPassword(Request $request)
{
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:6',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->save();
        }
    );

    if ($status === Password::PASSWORD_RESET) {
        return response()->json(['success' => true, 'message' => 'Password updated successfully. You can now log in.']);
    } else {
        return response()->json(['error' => __($status)], 500);
    }
}

}
