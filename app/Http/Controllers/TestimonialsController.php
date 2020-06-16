<?php

namespace App\Http\Controllers;

use App\Testimonials;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use DataTables;

class TestimonialsController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()){
            return DataTables::of(Testimonials::query())->addColumn('image_complete_url', function($query){
                return ($query->image) ? asset('storage/'.$query->image) : null;
            })->make(true);
        }
        return view('admin.testimonials.index');
    }


    public function add(Request $request){
        if ($request->post()){
            $data = $request->except('image');
            if ($request->hasFile('image')){
                $path = $request->image->store('testimonials/images');
                $data['image'] = $path;
            }
            $scholar = Testimonials::create($data);
            return redirect()->route('testimonials');
        }
        return view('admin.testimonials.add');
    }

    public function edit(Request $request, Testimonials $testimonial){
        if ($request->post()){
            $testimonial->name = $request->name;
            $testimonial->description = $request->description;
            if ($request->hasFile('image')){
                $path = $request->image->store('testimonials/images');
                $testimonial->image = $path;
            }
            $testimonial->save();
            return redirect()->route('testimonials');
        }
        return view('admin.testimonials.edit', compact('testimonial'));
    }
    public function delete(Request $request){
        Testimonials::find($request->id)->delete();
        return ['status' => 200];
    }
}
