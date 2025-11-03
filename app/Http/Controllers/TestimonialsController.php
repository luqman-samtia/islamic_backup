<?php

namespace App\Http\Controllers;

use App\Slug;
use DataTables;
use App\Feedback;
use App\Testimonials;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;

class TestimonialsController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()){
            // Create a unified query using UNION
            $testimonials = Testimonials::select(
                'id',
                'name',
                'description',
                'image',
                'created_at',
                'updated_at',
                DB::raw("'testimonial' as source_type")
            );

            $feedbacks = Feedback::select(
                'id',
                'title as name',
                'feedback as description',
                'image',
                'created_at',
                'updated_at',
                DB::raw("'feedback' as source_type")
            )->unionAll($testimonials);

            return DataTables::of($feedbacks)
                ->addColumn('image_complete_url', function($query){
                    return ($query->image) ? asset('storage/'.$query->image) : null;
                })
                ->addColumn('source_type', function($query){
                    return ucfirst($query->source_type);
                })
                ->make(true);
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
