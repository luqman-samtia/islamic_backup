<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\AdminVerification;
use Illuminate\Support\Facades\Mail;
use App\Mail\StudentVerified;
use App\Mail\StudentDisable;
use App\User;
use App\Scholars;
use App\AdmissionForm;
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
        $validatedData['type'] = 'student';  
        $validatedData['is_verified'] = 0;   

        
            $user = User::create($validatedData);
             AdmissionForm::create([
                'user_id'        => $user->id,
                'student_name'   => $request->name,
                'father_name'    => $request->father_name,
                'age'            => $request->age,
                'course'         => $request->course,
                'phone_no'       => $request->contact_no,   
                'address'        => $request->address,
                'admission_date' => now()->toDateString(),
                'pic'            => $request->hasFile('pic')
                                        ? $request->file('pic')->store('admissions/images')
                                        : null,
            ]);
            \App\AdminNotification::create([
                    'user_id' => $user->id,
                    'type'    => 'registration',
                    'message' => 'New student has registered: ' . $user->name,
                    'is_read' => false,
                ]);
           
            // try {
            //     Mail::to('infotaleemulquraninstitute@gmail.com')->send(new AdminVerification($user));
            //     $successMessage = 'Registration successful! Waiting for admin approval.';
            // } catch (\Exception $e) {
            //     \Log::error('Mail sending failed: ' . $e->getMessage());
            //     $successMessage = 'Registration successful! However, we were unable to send an email notification to the admin.';
            // }
            // return response()->json(['message' => $successMessage]);
            try {
                $html = (new \App\Mail\AdminVerification($user))->render();

                $client = new \GuzzleHttp\Client();
                $client->post('https://api.resend.com/emails', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . env('RESEND_API_KEY'),
                        'Content-Type'  => 'application/json',
                    ],
                    'json' => [
                        'from'    => 'Taleem ul Quran <noreply@taleemulquraninstitute.com>',
                        'to'      => ['infotaleemulquraninstitute@gmail.com'],
                        'subject' => 'New Student Registration',
                        'html'    => $html,
                    ],
                ]);

                $successMessage = 'Registration successful! Waiting for admin approval.';
            } catch (\Exception $e) {
                \Log::error('Resend mail failed: ' . $e->getMessage());
                $successMessage = 'Registration successful! However, we were unable to send an email notification to the admin.';
            }

            return response()->json(['message' => $successMessage]);
        }
       
    }

    // ===== NOTIFICATION METHODS =====

    private function ensureAdmin()
    {
        if (Auth::user()->type !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    // List + unread count
    public function getAdminNotifications()
    {
        $this->ensureAdmin();

        $notifications = \App\AdminNotification::orderBy('created_at', 'desc')
            ->take(15)
            ->get()
            ->map(function ($n) {
                $admission = \App\AdmissionForm::where('user_id', $n->user_id)->first();

                $n->link = $admission
                    ? route('admin.admission.show', $admission->id)
                    : route('students'); 

                return $n;
            });

        return response()->json([
            'count'         => \App\AdminNotification::where('is_read', false)->count(),
            'notifications' => $notifications,
        ]);
    }
    // Single read
    public function markNotificationRead($id)
    {
        $this->ensureAdmin();

        $notif = \App\AdminNotification::find($id);
        if (!$notif) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $notif->is_read = 1;
        $notif->save();
        return response()->json(['success' => true]);
    }

    // All read
    public function markAllNotificationsRead()
    {
        $this->ensureAdmin();

        \App\AdminNotification::where('is_read', false)->update(['is_read' => true]);
        return response()->json(['success' => true]);
    }

    // Single delete
    public function deleteNotification($id)
    {
        $this->ensureAdmin();

        $notif = \App\AdminNotification::find($id);
        if (!$notif) {
            return response()->json(['error' => 'Not found'], 404);
        }
        $notif->delete();
        return response()->json(['success' => true]);
    }

    // Clear all
    public function clearAllNotifications()
    {
        $this->ensureAdmin();

        \App\AdminNotification::truncate();
        return response()->json(['success' => true]);
    }
    // Student login
    public function login(Request $request)
    {
        
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
            
        // try {
        //     Mail::to($user->email)->send(new StudentVerified($user));
        //     $successMessage = 'Student verified successfully!';
        // } catch (\Exception $e) {
        //     \Log::error('Mail sending failed: ' . $e->getMessage());
        //     $successMessage = 'Student verified successfully! However, we were unable to send an email notification';
        // }
         try {
                $this->sendResendMail($user->email, 'Account Verified', new StudentVerified($user));
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

        // try {
        //     Mail::to($user->email)->send(new StudentVerified($user));
        //     $successMessage = 'Student verified successfully!';
        // } catch (\Exception $e) {
            
        //     \Log::error('Mail sending failed: ' . $e->getMessage());
        //     $successMessage = 'Student verified successfully! However, we were unable to send an email notification';
        // }
        try {
                $this->sendResendMail($user->email, 'Account Verified', new StudentVerified($user));
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

 
        // try {
        //     Mail::to($user->email)->send(new StudentDisable($user));
        //     $successMessage = 'Student Disabled successfully!!';
        // } catch (\Exception $e) {
         
        //     \Log::error('Mail sending failed: ' . $e->getMessage());
        //     $successMessage = 'Student Disabled successfully!! However, we were unable to send an email notification';
        // }
        try {
            $this->sendResendMail($user->email, 'Account Disabled', new StudentDisable($user));
            $successMessage = 'Student Disabled successfully!!';
        } catch (\Exception $e) {
            \Log::error('Mail sending failed: ' . $e->getMessage());
            $successMessage = 'Student Disabled successfully!! However, we were unable to send an email notification';
        }

        return response()->json(['success' => $successMessage]);
    
    }
    /**
     * Resend API ke through email bhejne ka helper
     */
    private function sendResendMail($toEmail, $subject, $mailable)
    {
        $html = $mailable->render();

        $client = new \GuzzleHttp\Client();
        $client->post('https://api.resend.com/emails', [
            'headers' => [
                'Authorization' => 'Bearer ' . env('RESEND_API_KEY'),
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'from'    => 'Taleem ul Quran <noreply@taleemulquraninstitute.com>',
                'to'      => [$toEmail],
                'subject' => $subject,
                'html'    => $html,
            ],
        ]);
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

    // public function students(Request $request){
        
    //         if ($request->ajax()) {
        
    //             $data = DataTables::of(User::where('type', 'student')
    //             ->leftJoin('scholars', 'users.scholar', '=', 'scholars.id')
    //             ->leftJoin('admission_forms', 'users.id', '=', 'admission_forms.user_id')
    //             ->select('users.*', 'scholars.name as scholar_name','admission_forms.id as admission_form_id')
    //             )
    //             ->addColumn('scholar', function($row) {
    //                 return $row->scholar_name ?? 'No Scholar';
    //             })
    //             ->addColumn('password_action', function($row) {
    //                 return '<button type="button" data-id="'.$row->id.'" class="btn btn-warning btn-xs change-password">
    //                             <i class="fa fa-key"></i> Change Password
    //                         </button>';
    //             })
    //              ->addColumn('actions', function($row) {
    //                $admissionBtn = $row->admission_form_id 
    //                     ? '<a href="'.route('admin.admission.show', $row->admission_form_id).'" class="btn btn-info btn-xs" title="Admission Form">
    //                             <i class="fa fa-address-card"></i> Admission
    //                     </a>'
    //                     : '<button class="btn btn-secondary btn-xs" disabled title="Not Filled Yet">
    //                             <i class="fa fa-address-card"></i> No Form
    //                     </button>';

    //                 return $admissionBtn . '
    //                     <a href="'.route('admin.fees.manage', $row->id).'" class="btn btn-success btn-xs" title="Fee Records">
    //                         <i class="fa fa-money"></i> Fee
    //                     </a>
    //                     <a href="'.route('admin.lessons.courses', $row->id).'" class="btn btn-primary btn-xs" title="Manage Courses & Permissions">
    //                         <i class="fa fa-sliders"></i> Courses
    //                     </a>
    //                     <a href="'.route('admin.lessons.entry', $row->id).'" class="btn btn-default btn-xs" title="Lessons">
    //                         <i class="fa fa-book"></i> Lessons
    //                     </a>';
    //             })
    //             ->rawColumns(['password_action','actions'])
    //             ->make(true);
    
    //         \Log::info($data); 
            
    //         return $data;
    //         }
    //         $scholars = Scholars::pluck('name', 'id');
    //         return view('admin.students.index', compact('scholars'));
    // }
    // public function students(Request $request)
    // {
    //     if ($request->ajax()) {
    //         return DataTables::of(
    //             User::where('type', 'student')
    //                 ->leftJoin('scholars', 'users.scholar', '=', 'scholars.id')
    //                 ->leftJoin('admission_forms', 'users.id', '=', 'admission_forms.user_id')
    //                 ->select(
    //                     'users.*',
    //                     'scholars.name as scholar_name',
    //                     'admission_forms.id as admission_form_id',
    //                     'admission_forms.pic as admission_pic'
    //                 )
    //         )
    //         ->addColumn('scholar', function ($row) {
    //             return $row->scholar_name ?? 'No Scholar';
    //         })
    //         ->make(true);
    //     }
 
    //     $scholars = Scholars::pluck('name', 'id');
    //     return view('admin.students.index', compact('scholars'));
    // }
     public function students(Request $request)
    {
        if ($request->ajax()) {
 
            $query = User::where('type', 'student')
                ->leftJoin('scholars', 'users.scholar', '=', 'scholars.id')
                ->leftJoin('admission_forms', 'users.id', '=', 'admission_forms.user_id')
                ->select(
                    'users.*',
                    'scholars.name as scholar_name',
                    'admission_forms.id as admission_form_id',
                    'admission_forms.pic as admission_pic',
                    'admission_forms.student_name as admission_name'
                )
                ->orderBy('id','desc');
 
            $status = $request->input('status_filter');
            if ($status === 'verified') {
                $query->where('users.is_verified', 1);
            } elseif ($status === 'not_verified') {
                $query->where('users.is_verified', 0);
            }
 
            return DataTables::of($query)
                ->addColumn('scholar', function ($row) {
                    return $row->scholar_name ?? 'No Scholar';
                })
                ->editColumn('name', function ($row) {
                    return $row->admission_name ?: $row->name;
                })
                ->make(true);
        }
 
        $scholars = Scholars::pluck('name', 'id');
        return view('admin.students.index', compact('scholars'));
    }
 
    public function bulkDestroy(Request $request)
    {
        $ids = $request->input('ids', []);
 
        if (!is_array($ids) || count($ids) === 0) {
            return response()->json(['error' => 'No students selected.'], 422);
        }
 
        $ids = User::whereIn('id', $ids)->where('type', 'student')->pluck('id')->toArray();
 
        if (count($ids) === 0) {
            return response()->json(['error' => 'No valid students found.'], 422);
        }
 
        \DB::beginTransaction();
        try {
            foreach (['admission_forms', 'fee_records', 'student_courses', 'lesson_records'] as $table) {
                if (\Schema::hasTable($table)) {
                    \DB::table($table)->whereIn('user_id', $ids)->delete();
                }
            }
 
            User::whereIn('id', $ids)->delete();
 
            \DB::commit();
 
            return response()->json([
                'success' => count($ids) . ' student(s) deleted successfully.'
            ]);
        } catch (\Exception $e) {
            \DB::rollBack();
            return response()->json(['error' => 'Delete failed: ' . $e->getMessage()], 500);
        }
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
         public function removeScholar(Request $request)
        {
            $request->validate([
                'id' => 'required|exists:users,id',
            ]);

            $student = User::find($request->id);
            $student->scholar = null;
            $student->save();

            return response()->json(['success' => 'Scholar removed successfully.']);
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
    $studentId = $request->input('student_id');
    $studentItems = $request->input('student_items', []);

    // Get existing items
    $existingItems = Student::where('user_id', $studentId)->get();
    $existingIds = $existingItems->pluck('id')->toArray();
    $submittedIds = [];

    foreach ($studentItems as $item) {
        if (!empty($item['id']) && is_numeric($item['id']) && in_array((int)$item['id'], $existingIds)) {
            Student::where('id', $item['id'])->update([
                'type' => $item['type'] ?? 'Student',
                'title' => $item['title'],
                'link' => $item['link'],
                'created_at' => $item['created_at'],
            ]);
            $submittedIds[] = (int)$item['id'];
        } else {
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

//  public function forgotPasswordRequest(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'email' => 'required|email|exists:users,email',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 422);
//     }

//     $status = Password::sendResetLink(
//         $request->only('email')
//     );

//     if ($status === Password::RESET_LINK_SENT) {
//         return response()->json(['success' => true, 'message' => 'Password reset link sent to your email.']);
//     }

//     return response()->json(['error' => 'Unable to send reset link. Try again later.'], 500);
// }
// public function forgotPasswordRequest(Request $request)
// {
//     $validator = Validator::make($request->all(), [
//         'email' => 'required|email|exists:users,email',
//     ]);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 422);
//     }

//     $user = User::where('email', $request->email)->first();

//     $token = Password::createToken($user);

//     $resetUrl = url('/password/reset/' . $token . '?email=' . urlencode($user->email));

//     try {
//         $html = '<p>Click below to reset your password:</p>'
//             . '<p><a href="' . $resetUrl . '">Reset Password</a></p>'
//             . '<p>If you did not request this, ignore this email.</p>';

//         $client = new \GuzzleHttp\Client();
//         $client->post('https://api.resend.com/emails', [
//             'headers' => [
//                 'Authorization' => 'Bearer ' . env('RESEND_API_KEY'),
//                 'Content-Type'  => 'application/json',
//             ],
//             'json' => [
//                 'from'    => 'Taleem ul Quran <noreply@taleemulquraninstitute.com>',
//                 'to'      => [$user->email],
//                 'subject' => 'Reset Your Password',
//                 'html'    => $html,
//             ],
//         ]);

//         return response()->json(['success' => true, 'message' => 'Password reset link sent to your email.']);
//     } catch (\Exception $e) {
//         \Log::error('Resend reset mail failed: ' . $e->getMessage());
//         return response()->json(['error' => 'Unable to send reset link. Try again later.'], 500);
//     }
// }
    public function forgotPasswordRequest(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::where('email', $request->email)->first();

        $token = Password::createToken($user);

        // $resetUrl = url('/password/reset/' . $token . '?email=' . urlencode($user->email));
        $resetUrl = route('password.reset.form', ['token' => $token]) . '?email=' . urlencode($user->email);

        try {
            $html = $this->buildResetEmailHtml($user, $resetUrl);

            $client = new \GuzzleHttp\Client();
            $client->post('https://api.resend.com/emails', [
                'headers' => [
                    'Authorization' => 'Bearer ' . env('RESEND_API_KEY'),
                    'Content-Type'  => 'application/json',
                ],
                'json' => [
                    'from'    => 'Taleem ul Quran <noreply@taleemulquraninstitute.com>',
                    'to'      => [$user->email],
                    'subject' => 'Reset Your Password — Taleem ul Quran Institute',
                    'html'    => $html,
                ],
            ]);

            return response()->json(['success' => true, 'message' => 'Password reset link sent to your email.']);
        } catch (\Exception $e) {
            \Log::error('Resend reset mail failed: ' . $e->getMessage());
            return response()->json(['error' => 'Unable to send reset link. Try again later.'], 500);
        }
    }

    /**
     * Build professional HTML for the password reset email.
     */
    private function buildResetEmailHtml($user, $resetUrl)
    {
        $name = e($user->name ?? 'Student');
        $year = date('Y');

        return <<<HTML
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Your Password</title>
    </head>
    <body style="margin:0; padding:0; background-color:#f4f6f8; font-family:Arial, Helvetica, sans-serif;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f8; padding:30px 0;">
            <tr>
                <td align="center">
                    <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="max-width:600px; width:100%; background-color:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.06);">

                        <!-- Header -->
                        <tr>
                            <td style="background-color:#0b6e4f; padding:30px 40px; text-align:center;">
                                <h1 style="margin:0; color:#ffffff; font-size:22px; letter-spacing:0.5px;">Taleem ul Quran Institute</h1>
                                <p style="margin:6px 0 0; color:#cdeede; font-size:13px;">Knowledge • Guidance • Excellence</p>
                            </td>
                        </tr>

                        <!-- Body -->
                        <tr>
                            <td style="padding:40px;">
                                <h2 style="margin:0 0 16px; color:#1a1a1a; font-size:20px;">Reset Your Password</h2>
                                <p style="margin:0 0 16px; color:#444444; font-size:15px; line-height:1.6;">
                                    Assalam-o-Alaikum <strong>{$name}</strong>,
                                </p>
                                <p style="margin:0 0 24px; color:#444444; font-size:15px; line-height:1.6;">
                                    We received a request to reset the password for your account. Click the button below to set a new password. This link is valid for a limited time.
                                </p>

                                <!-- Button -->
                                <table role="presentation" cellpadding="0" cellspacing="0" style="margin:0 auto 28px;">
                                    <tr>
                                        <td align="center" style="border-radius:6px; background-color:#0b6e4f;">
                                            <a href="{$resetUrl}" target="_blank"
                                            style="display:inline-block; padding:14px 36px; color:#ffffff; font-size:15px; font-weight:bold; text-decoration:none; border-radius:6px;">
                                                Reset Password
                                            </a>
                                        </td>
                                    </tr>
                                </table>

                                <p style="margin:0 0 12px; color:#666666; font-size:13px; line-height:1.6;">
                                    If the button doesn't work, copy and paste this link into your browser:
                                </p>
                                <p style="margin:0 0 24px; word-break:break-all;">
                                    <a href="{$resetUrl}" style="color:#0b6e4f; font-size:13px;">{$resetUrl}</a>
                                </p>

                                <p style="margin:0; color:#999999; font-size:13px; line-height:1.6;">
                                    If you did not request a password reset, please ignore this email — your password will remain unchanged.
                                </p>
                            </td>
                        </tr>

                        <!-- Footer -->
                        <tr>
                            <td style="background-color:#f4f6f8; padding:24px 40px; text-align:center; border-top:1px solid #e6e9ec;">
                                <p style="margin:0 0 6px; color:#888888; font-size:12px;">
                                    © {$year} Taleem ul Quran Institute. All rights reserved.
                                </p>
                                <p style="margin:0; color:#aaaaaa; font-size:12px;">
                                    This is an automated message, please do not reply.
                                </p>
                            </td>
                        </tr>

                    </table>
                </td>
            </tr>
        </table>
    </body>
    </html>
HTML;
    }
// public function showResetForm(Request $request, $token)
// {
//     return redirect('/?token=' . $token . '&email=' . urlencode($request->email));
// }

public function showResetForm(Request $request, $token)
{
    return view('auth.reset-password', [
        'token' => $token,
        'email' => $request->email,
    ]);
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
