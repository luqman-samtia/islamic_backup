<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index(){
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function add(Request $request){
        if ($request->post()){
            Permission::create(['name' => $request->name]);
            return redirect()->route('permissions');
        }
        return view('admin.permissions.add');
    }

    public function edit(Request $request, Permission $permission){
        if ($request->post()){
            $permission->name = $request->name;
            $permission->save();
            return redirect()->route('permissions');
        }
        return view('admin.permissions.edit', compact('permission'));
    }

    public function roles(Request $request, Permission $permission){
        if($request->ajax()) {
            $roles = Role::where('name', '!=', 'SuperAdmin')->get();
            $html = view('admin.permissions._roles', compact(['permission', 'roles']))->render();
            return ['html' => $html];
        }
        if ($request->post()){
            $permission->syncRoles($request->roles);
            return redirect()->route('permissions');
        }
    }

    public function delete(Permission $permission){
        $permission->delete();
        return redirect()->route('permissions');
    }
}
