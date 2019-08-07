<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(){
        $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }

    public function add(Request $request){
        if ($request->post()){
            Role::create(['name' => $request->name]);
            return redirect()->route('roles');
        }
        return view('admin.roles.add');
    }

    public function edit(Request $request, Role $role){
        if ($request->post()){
            $role->name = $request->name;
            $role->save();
            return redirect()->route('roles');
        }
        return view('admin.roles.edit', compact('role'));
    }

    public function permissions(Request $request, Role $role){
        if($request->ajax()) {
            $permissions = Permission::all();
            $html = view('admin.roles._permissions', compact(['permissions', 'role']))->render();
            return ['html' => $html];
        }
        if ($request->post()){
            $role->syncPermissions($request->permissions);
            return redirect()->route('roles');
        }
    }

    public function delete(Role $role){
        $role->delete();
        return redirect()->route('roles');
    }
}
