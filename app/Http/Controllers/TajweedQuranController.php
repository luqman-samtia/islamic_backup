<?php

namespace App\Http\Controllers;

use App\Slug;
use App\TajweedQuran;
use Illuminate\Http\Request;
use App\Constants\QuranParas;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class TajweedQuranController extends Controller
{
    public function quran(Request $request, TajweedQuran $quran)
    {
        if ($request->ajax()){
            return DataTables::of(TajweedQuran::parent($quran->id))->addColumn('image_complete_url', function($query){
                return ($query->image) ? asset('storage/'.$query->image) : null;
            })
             ->addColumn('paraName', function($row){
                return QuranParas::getParaName($row->para_no);
            })->make(true);
        }
        return view('admin.tajweed-quran.quran', compact('quran'));
    }

    public function index(Request $request)
    {
        if ($request->ajax()){
            return DataTables::of(TajweedQuran::whereNull('parent_id'))->addColumn('image_complete_url', function($query){
                return ($query->image) ? asset('storage/'.$query->image) : null;
            })->make(true);
        }
        return view('admin.tajweed-quran.index');
    }


    public function add(Request $request)
    {
        if ($request->post()) {
            $data = $request->all();
            if ($request->hasFile('image')) {
                $path = $request->image->store('tajweed-quran/images');
                $data['image'] = $path;
            }
            $data['slug'] = Slug::createSlug($request->title, 0, 'Quran');
            $quran = TajweedQuran::create($data);
            $quran->save();
            return redirect()->route('tajweed.quran');
        }
        return view('admin.tajweed-quran.add');
    }

    public function quranAdd(Request $request, TajweedQuran $quran){
        if ($request->post()){
            $data = $request->all();
            if ($request->hasFile('image')){
                $path = $request->image->store('tajweed-quran/resources/'.$quran->id);
                $data['image'] = $path;
            }
            $data['parent_id'] = $quran->id;
            $quranChild = TajweedQuran::create($data);
            $quranChild->save();
            return redirect()->route('tajweed.quran.quran', $quran->id);
        }
         $paras = QuranParas::getParas();
        return view('admin.tajweed-quran.surah.add', compact('quran', 'paras'));
    }


    public function edit(Request $request, TajweedQuran $quran)
    {
        if ($request->post()) {
            $quran->title = $request->title;
            $quran->number = $request->number;
//            $quran->ayat_from = $request->ayat_from;
//            $quran->ayat_to = $request->ayat_to;
            if ($request->hasFile('image')) {
                Storage::delete($quran->image);
                $path = $request->image->store('tajweed-quran/images');
                $quran->image = $path;
            }
            $quran->save();
            return redirect()->route('tajweed.quran');
        }
        return view('admin.tajweed-quran.edit', compact('quran'));
    }


    public function quranEdit(Request $request, TajweedQuran $quran, TajweedQuran $childQuran){
        if ($request->post()){
            $childQuran->title = $request->title;
            $childQuran->number = $request->number;
            $childQuran->ayat_from = $request->ayat_from;
            $childQuran->ayat_to = $request->ayat_to;
            $childQuran->para_no = $request->para_no;
            if ($request->hasFile('image')){
                Storage::delete($childQuran->image);
                $path = $request->image->store('tajweed-quran/resources/'.$quran->id);
                $childQuran->image = $path;
            }
            $childQuran->save();
            return redirect()->route('tajweed.quran.quran',$childQuran->parent_id);
        }
        $paras = QuranParas::getParas();
        return view('admin.tajweed-quran.surah.edit', compact('quran', 'childQuran', 'paras'));
    }


    public function delete(Request $request){
        TajweedQuran::find($request->id)->delete();
        return ['status' => 200];
    }
}
