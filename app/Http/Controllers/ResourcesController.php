<?php

namespace App\Http\Controllers;

use App\Resources;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use DataTables;

class ResourcesController extends Controller
{

    public function resource(Request $request, Resources $resource)
    {
        if ($request->ajax()){
            return DataTables::of(Resources::parent($resource->id))->addColumn('image_complete_url', function($query){
                return ($query->image) ? asset('storage/'.$query->image) : null;
            })->make(true);
        }
        return view('admin.resources.resources', compact('resource'));
    }


    public function index(Request $request){
        if ($request->ajax()){
            return DataTables::of(Resources::whereNull('parent_id'))->addColumn('image_complete_url', function($query){
                return ($query->image) ? asset('storage/'.$query->image) : null;
            })->make(true);
        }
        return view('admin.resources.index');
    }


    public function add(Request $request){
        if ($request->post()){
            $data = $request->all();
            if ($request->hasFile('image')){
                $path = $request->image->store('resources/images');
                $data['image'] = $path;
            }
            $data['slug'] = Slug::createSlug($request->title, 0, 'Resources');
            $resource = Resources::create($data);
            $resource->save();
            return redirect()->route('resources');
        }
        return view('admin.resources.add');
    }


    public function resourceAdd(Request $request, Resources $resource){
        if ($request->post()){
            $data = $request->all();
            if ($request->hasFile('image')){
                $path = $request->image->store('resources/'.$resource->id.'/');
                $data['image'] = $path;
            }
            $data['parent_id'] = $resource->id;
            $resourceChild = Resources::create($data);
            $resourceChild->save();
            return redirect()->route('resources.resources', $resource->id);
        }
        return view('admin.resources.child.add', compact('resource'));
    }


    public function edit(Request $request, Resources $resource){
        if ($request->post()){
            $resource->title = $request->title;
            if ($request->hasFile('image')){
                $path = $request->image->store('resources/images');
                $resource->image = $path;
            }
            $resource->save();
            return redirect()->route('resources');
        }
        return view('admin.resources.edit', compact('resource'));
    }

    public function resourceEdit(Request $request, Resources $resource, Resources $childResource){
        if ($request->post()){
            $childResource->title = $request->title;
            $childResource->number = $request->number;
            if ($request->hasFile('image')){
                $path = $request->image->store('resources/images');
                $childResource->image = $path;
            }
            $childResource->save();
            return redirect()->route('resources.resources',$childResource->parent_id);
        }
        return view('admin.resources.child.edit', compact('resource', 'childResource'));
    }


    public function delete(Request $request){
        Resources::find($request->id)->delete();
        return ['status' => 200];
    }
}
