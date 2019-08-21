<?php

namespace App\Http\Controllers;

use App\Articals;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Slug;

class ArticalsController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()){
            return DataTables::of(Articals::query())->make(true);
        }
        return view('admin.articals.index');
    }


    public function add(Request $request){
        if ($request->post()){
            $data = $request->all();
            $slug = new Slug();
            $data['slug'] = $slug->createSlug($request->title, 0, 'Articals');
            $artical = Articals::create($data);
            $artical->save();
            return redirect()->route('articals');
        }
        return view('admin.articals.add');
    }


    public function edit(Request $request, Articals $artical){
        if ($request->post()){
//            dd($request->all());
            $artical->title = $request->title;
            $artical->content = $request->content_body;
            $artical->save();
            return redirect()->route('articals');
        }
        return view('admin.articals.edit', compact('artical'));
    }

    public function delete(Request $request){
        Articals::find($request->id)->delete();
        return ['status' => 200];
    }
}
