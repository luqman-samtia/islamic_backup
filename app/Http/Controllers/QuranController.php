<?php

namespace App\Http\Controllers;

use App\Quran;
use App\Resources;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuranController extends Controller
{


    public function quran(Request $request, Quran $quran)
    {
        if ($request->ajax()){
            return DataTables::of(Quran::parent($quran->id))->addColumn('image_complete_url', function($query){
                return ($query->image) ? asset('storage/'.$query->image) : null;
            })->make(true);
        }
        return view('admin.quran.quran', compact('quran'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()){
            return DataTables::of(Quran::whereNull('parent_id'))->addColumn('image_complete_url', function($query){
                return ($query->image) ? asset('storage/'.$query->image) : null;
            })->make(true);
        }
        return view('admin.quran.index', compact('quran'));
    }


    public function add(Request $request, Quran $quran)
    {
        if ($request->post()) {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $path = $request->image->store('quran/images');
                $data['image'] = $path;
            }
            $quran = Quran::create($data);
            $quran->save();
            return redirect()->route('quran');
        }
        return view('admin.quran.add');
    }

    public function quranAdd(Request $request, Quran $quran){
        if ($request->post()){
            $data = $request->all();
            if ($request->hasFile('image')){
                $path = $request->image->store('resources/'.$quran->id.'/');
                $data['image'] = $path;
            }
            $data['parent_id'] = $quran->id;
            $quranChild = Quran::create($data);
            $quranChild->save();
            return redirect()->route('quran.quran', $quran->id);
        }
        return view('admin.quran.surah.add', compact('quran'));
    }


    public function edit(Request $request, Quran $quran)
    {
        if ($request->post()) {
            $quran->title = $request->title;
            if ($request->hasFile('image')) {
                $path = $request->image->store('quran/images');
                $quran->image = $path;
            }
            $quran->save();
            return redirect()->route('quran');
        }
        return view('admin.quran.edit', compact('quran'));
    }


    public function quranEdit(Request $request, Quran $quran, Quran $childQuran){
        if ($request->post()){
            $childQuran->title = $request->title;
            if ($request->hasFile('image')){
                $path = $request->image->store('quran/images');
                $childQuran->image = $path;
            }
            $childQuran->save();
            return redirect()->route('quran.quran',$childQuran->parent_id);
        }
        return view('admin.quran.surah.edit', compact('quran', 'childQuran'));
    }


    public function delete(Request $request){
        Quran::find($request->id)->delete();
        return ['status' => 200];
    }
}