<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Session;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = 'admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // protected function redirectTo()
    // {
    //     if (Auth::user()->type === 'admin') {
    //         return '/admin/home'; // Redirect admin to their home
    //     } 
    //     else{
    //             // return '<script> alert("You are not authorized to access this area.")</script>'; 
    //             return redirect()->back()->with('error', 'You are not authorized to access this area.');

    //     }
    
       
    // }
    protected function authenticated(Request $request, $user)
    {
        // Check the user type
        if ($user->type === 'admin') {
            // Allow access and proceed to the intended route
            return redirect()->intended($this->redirectTo);
        } elseif ($user->type === 'student') {
            // Log the user out and return back with an error message
            Auth::logout();
            Session::flash('error', 'You are not authorized to access this area.'); // Flash error message
            return redirect()->back(); // Redirect back to the previous page
        }

        // Handle other user types if necessary
        Auth::logout();
        Session::flash('error', 'You are not authorized to access this area.'); // Flash error message
        return redirect()->back(); // Redirect back to the previous page
    }
}
