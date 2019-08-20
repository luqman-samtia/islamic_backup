<?php

namespace App\Http\Controllers;

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
        $quran = Quran::parent(null)->orderAsc('created_at')->get();
        return view('site.quran.index', compact('quran'));
    }

    public function quranSurat($slug){
        $data['surat'] = Quran::with('children')->findBySlug($slug)->first();
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

}
