<?php

namespace App\Http\Controllers;

use App\Scholars;
use App\User;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use DataTables;
use Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
        // dd($user);
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
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'contact' => $request->input('phone'),
            ]);

            if ($request->filled('password')) {
                $user->update([
                    'password' => Hash::make($request->input('password'))
                ]);
            }
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
        // dd($scholar_id);
        if ($request->ajax()) {
            return DataTables::of(
                User::where('scholar', $scholar_id)->where('type', 'student')
            )->make(true);
        }
        return view('admin.scholars.students');
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
