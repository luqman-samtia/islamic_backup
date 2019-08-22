<?php

namespace App\Http\Controllers;

use App\Articals;
use App\Mail\ContacMail;
use App\Quran;
use App\Resources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PublicController extends Controller
{
    public function index(){
        return view('site.index');
    }

    public function page($slug){
        $resource = Resources::with('children')->findBySlug($slug)->first();
        if(!$resource)
            abort(404);
        return view('site.page', compact('resource'));
    }

    public function contactUs(Request $request){
        if($request->post()){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required'
            ]);
            Mail::to($request->email)->send(new ContacMail($request));
            return redirect()->back()->with('success', 'Email has been sent to the team.');
        }
        return view('site.contact_us');
    }

    public function quran(){
        $quran = Quran::parent(null)->orderAsc('number')->get();
        return view('site.quran.index', compact('quran'));
    }

    public function quranSurat($slug){
        $data['surat'] = Quran::with(['children' => function($query){
            $query->orderAsc('number');
        }])->findBySlug($slug)->first();
        if(!$data['surat'])
            abort(404);
        return view('site.quran.surat', $data);
    }

    public function faq(){
        return view('site.faq');
    }

    public function charges(){
        return view('site.charges');
    }

    public function terms(){
        return view('site.terms');
    }

    public function artical($slug){
        $artical = Articals::findBySlug($slug)->first();
        $posts = Articals::orderBy('created_at','desc')->take(5)->get();
        return view('site.artical', compact('artical','posts'));
    }

    public function search(Request $request){
        $data['request'] = $request;
        $data['quran'] = Quran::parent(null)->get();
        $search = Quran::findBySlug($request->surat)->first()->children;
        $record = $search->filter(function($image) use ($request){
            if($request->page <= $image->number){
                return $image;
            }
            if($request->ayat_from >= $image->ayat_from && $request->ayat_to <= $image->ayat_to){
                return $image;
            }
            if($request->ayat_from >= $image->ayat_from){
                return $image;
            }
            if($request->ayat_to <= $image->ayat_to){
                return $image;
            }
        });
        /*if($request->ayat_from) {
            $search->whereHas('getParent', function ($query) use ($request) {
                $query->where('ayat_from', '>=', $request->ayat_from);
            });
        }*/
        /*if($request->ayat_to) {
            $search->whereHas('children', function ($query) use ($request) {
                $query->where('ayat_to', '<=', $request->ayat_to);
            });
        }

        if($request->page) {
            $search->whereHas('children', function ($query) use ($request) {
                $query->where('number', $request->number);
            });
        }*/
//        $data['search'] = $search->orderAsc('number')->get();
        dd($record);
        return view('site.search', $data);
    }
}
