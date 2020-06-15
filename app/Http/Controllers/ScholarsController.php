<?php

namespace App\Http\Controllers;

use App\Scholars;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use DataTables;

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
            $data = $request->except('image');
            if ($request->hasFile('image')){
                $path = $request->image->store('scholars/images');
                $data['image'] = $path;
            }
            $scholar = Scholars::create($data);
            return redirect()->route('scholars');
        }
        return view('admin.scholars.add');
    }

    public function edit(Request $request, Scholars $scholar){
        if ($request->post()){
            $scholar->name = $request->name;
            $scholar->sort = $request->sort;
            if ($request->hasFile('image')){
                $path = $request->image->store('scholars/images');
                $scholar->image = $path;
            }
            $scholar->save();
            return redirect()->route('scholars');
        }
        return view('admin.scholars.edit', compact('scholar'));
    }
    public function delete(Request $request){
        Scholars::find($request->id)->delete();
        return ['status' => 200];
    }
}
