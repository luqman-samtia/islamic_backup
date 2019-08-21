<?php

namespace App\Http\Controllers;

use App\Articals;
use App\Quran;
use App\Resources;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['resources'] = Resources::parent(null)->count();
        $data['surah'] = Quran::parent(null)->count();
        $data['articles'] = Articals::count();
        return view('home', $data);
    }

    public function emails()
    {
        return view('home');
    }

    public function pages()
    {
        return view('home');
    }
}
