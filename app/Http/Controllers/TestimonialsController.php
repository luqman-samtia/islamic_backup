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
            // Get search parameter
            $search = $request->input('search.value', '');

            // Build both queries separately with search applied BEFORE union
            $testimonialQuery = Testimonials::select(
                'id',
                'name',
                'description',
                'image',
                'created_at',
                'updated_at',
                DB::raw("'testimonial' as source_type")
            );

            $feedbackQuery = Feedback::select(
                'id',
                'title as name',
                'feedback as description',
                'image',
                'created_at',
                'updated_at',
                DB::raw("'feedback' as source_type")
            );

            // Apply search to both queries
            if (!empty($search)) {
                $testimonialQuery->where(function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                      ->orWhere('description', 'LIKE', "%{$search}%");
                });

                $feedbackQuery->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                      ->orWhere('feedback', 'LIKE', "%{$search}%");
                });
            }

            // Combine queries
            $query = $feedbackQuery->unionAll($testimonialQuery);

            return DataTables::of(DB::table(DB::raw("({$query->toSql()}) as combined"))
                    ->mergeBindings($query->getQuery()))
                ->addColumn('image_complete_url', function($row){
                    return ($row->image) ? asset('storage/'.$row->image) : null;
                })
                ->addColumn('source_type', function($row){
                    return ucfirst($row->source_type);
                })
                ->rawColumns(['image_complete_url'])
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

    public function edit(Request $request, $id, $sourceType = 'testimonial'){
        $model = $this->getModelBySource($id, $sourceType);

        if (!$model) {
            return redirect()->route('testimonials')->with('error', 'Record not found');
        }

        if ($request->post()){
            if ($sourceType === 'feedback') {
                $model->title = $request->name;
                $model->feedback = $request->description;
            } else {
                $model->name = $request->name;
                $model->description = $request->description;
            }

            if ($request->hasFile('image')){
                $path = $request->image->store('testimonials/images');
                $model->image = $path;
            }
            
            $model->save();
            return redirect()->route('testimonials')->with('success', 'Record updated successfully');
        }

        $data = [
            'model' => $model,
            'sourceType' => $sourceType,
            'isTestimonial' => $sourceType === 'testimonial',
            'isFeedback' => $sourceType === 'feedback'
        ];

        if ($sourceType === 'testimonial') {
            $data['testimonial'] = $model;
        } else {
            $data['feedback'] = $model;
        }

        return view('admin.testimonials.edit', $data);
    }

    public function delete(Request $request){
        $id = $request->id;
        $sourceType = $request->source_type ?? 'testimonial';

        $model = $this->getModelBySource($id, $sourceType);

        if (!$model) {
            return response()->json(['status' => 404, 'message' => 'Record not found'], 404);
        }

        $model->delete();
        return response()->json(['status' => 200, 'message' => 'Record deleted successfully']);
    }

    /**
     * Helper method to get the appropriate model instance based on source type
     * 
     * @param int $id
     * @param string $sourceType 'testimonial' or 'feedback'
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    private function getModelBySource($id, $sourceType = 'testimonial')
    {
        if ($sourceType === 'feedback') {
            return Feedback::find($id);
        }
        
        return Testimonials::find($id);
    }
}