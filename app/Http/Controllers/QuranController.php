<?php

namespace App\Http\Controllers;

use App\Quran;
use App\Resources;
use Illuminate\Http\Request;

class QuranController extends Controller
{

    public function index()
    {
        return view('admin.quran.index');
    }

    public function add(Request $request, Quran $quran){
        if ($request->post()){
            $data = $request->all();
            if ($request->hasFile('image')){
                $path = $request->image->store('quran/images');
                $data['image'] = $path;
            }
            $quran = Quran::create($data);
            $quran->save();
            return redirect()->route('quran');
        }
        return view('admin.quran.add');
    }
}
