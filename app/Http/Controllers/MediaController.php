<?php

namespace App\Http\Controllers;

use App\Media;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use DataTables;

class MediaController extends Controller
{

    public function media(Request $request, Media $media)
    {
        if ($request->ajax()){
            return DataTables::of(Media::parent($media->id))->addColumn('image_complete_url', function($query){
                return ($query->video_id) ? asset('storage/'.$query->video_id) : null;
            })->make(true);
        }
        return view('admin.media.media', compact('media'));
    }

    public function index(Request $request){
        if ($request->ajax()){
            return DataTables::of(Media::whereNull('parent_id'))->addColumn('video_complete_url', function($query){
                return ($query->video_id) ? asset('storage/'.$query->video_id) : null;
            })->make(true);
        }
        return view('admin.media.index');
    }

    public function add(Request $request){
        if ($request->post()){
            $data = $request->all();
            if ($request->hasFile('video_id')){
                $path = $request->video_id->store('media/images');
                $data['video_id'] = $path;
            }
            $data['slug'] = Slug::createSlug($request->title, 0, 'Media');
            $media = Media::create($data);
            $media->save();
            return redirect()->route('media');
        }
        return view('admin.media.add');
    }

    public function mediaAdd(Request $request, Media $media){
        if ($request->post()){
            $request->validate([
                'video_id' => [
                    'required',
                    function($attribute, $value, $fail){
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value, $match);
                        if (!@$match['1']){
                            $fail("Youtube url is invalid");
                        }
                    }
                ]
            ]);
            $data = $request->all();
            if ($request->hasFile('video_id')){
                $path = $request->video_id->store('media/'.$media->id.'/');
                $data['video_id'] = $path;
            }
            $data['parent_id'] = $media->id;
            $mediaChild = Media::create($data);
            $mediaChild->save();
            return redirect()->route('media.media', $media->id);
        }
        return view('admin.media.child.add', compact('media'));
    }

    public function edit(Request $request, Media $media){
        if ($request->post()){
            $media->title = $request->title;
            $media->description = $request->description;
            if ($request->hasFile('video_id')){
                $path = $request->video_id->store('media/images');
                $media->video_id = $path;
            }
            $media->save();
            return redirect()->route('media');
        }
        return view('admin.media.edit', compact('media'));
    }

    public function mediaEdit(Request $request, Media $media, Media $childMedia){
        if ($request->post()){
            $request->validate([
                'video_id' => [
                    'required',
                    function($attribute, $value, $fail){
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $value, $match);
                        if (!@$match['1']){
                            $fail("Youtube url is invalid");
                        }
                    }
                ]
            ]);
            $childMedia->title = $request->title;
            $childMedia->description = $request->description;
            $childMedia->video_id = $request->video_id;
            $childMedia->save();
            return redirect()->route('media.media',$childMedia->parent_id);
        }
        return view('admin.media.child.edit', compact('media','childMedia'));
    }
    public function delete(Request $request){
        Media::find($request->id)->delete();
        return ['status' => 200];
    }
}
