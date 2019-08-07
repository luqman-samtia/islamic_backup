<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index(){
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function add(Request $request){
        if ($request->post()){
            $data = $request->all();
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            $user->assignRole('Normal');
            return redirect()->route('users');
        }
        return view('admin.users.add');
    }

    public function role(Request $request, User $user){
        if($request->ajax()){
            $roles = Role::where('name', '!=', 'SuperAdmin')->get();
            $html = view('admin.users._roles', compact(['roles', 'user']))->render();
            return ['html' => $html];
        }
        if($request->post()){
            $user->syncRoles($request->role);
            return redirect()->route('users');
        }
    }

    public function edit(Request $request, User $user){
        if ($request->post()){
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->password)
                $user->password = Hash::make($request->password);
            $user->save();
            return redirect()->route('users');
        }
        return view('admin.users.edit', compact('user'));
    }

    public function delete(User $user){
        $user->delete();
        return redirect()->route('users');
    }
}
