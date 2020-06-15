<?php

namespace App\Http\Controllers;

use App\Articals;
use App\Mail\ContacMail;
use App\Media;
use App\Quran;
use App\Resources;
use App\Scholars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class PublicController extends Controller
{
    public function __construct() {
        $resources = \App\Resources::parent(null)->get();
        $articles = \App\Articals::all();
        $media = \App\Media::whereNull('parent_id')->get();
        View::share ( 'resources', $resources);
        View::share ( 'articles', $articles);
        View::share('media', $media);
    }

    public function index(){
        $posts = Articals::orderBy('created_at','desc')->take(6)->get();
        $scholars = Scholars::orderBy('sort')->get();
        return view('site.index', compact('posts','scholars'));
    }

    public function page($slug){
        $resource = Resources::with(['children' => function($relation){
            if (request()->page)
                $relation->where('number', request()->page);
            $relation->orderBy('number', 'asc');
        }])->findBySlug($slug)->first();
        if(!$resource)
            abort(404);

        if (request()->page){
            $prev = Resources::where('number', '<', request()->page)->where('parent_id', $resource->id)->orderBy('number','desc')->first();
            $next = Resources::where('number', '>', request()->page)->where('parent_id', $resource->id)->orderBy('number')->first();
        }
        return view('site.page', [
            'resource' => $resource,
            'next' => @$next,
            'prev' => @$prev
        ]);
    }

    public function contactUs(Request $request){
        if($request->post()){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'subject' => 'required',
                'message' => 'required'
            ]);
            Mail::to('hafizhabib5651@gmail.com')->send(new ContacMail($request));
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

        $prev = Quran::where('id', '<', $data['surat']->id)->whereNull('parent_id')->orderBy('id','desc')->first();
        $next = Quran::where('id', '>', $data['surat']->id)->whereNull('parent_id')->orderBy('id')->first();

        $data['prev'] = $prev;
        $data['next'] = $next;

        return view('site.quran.surat', $data);
    }

    public function quranSuratPage($slug, $page){

        $data['surat'] = Quran::whereHas('getParent', function($q) use ($slug){
            $q->where('slug', $slug);
        })->with('getParent')->whereNotNull('parent_id')->where('number', $page)->first();

        if(!$data['surat'])
            abort(404);

        $prev = Quran::where('id', '<', $data['surat']->id)->where('parent_id', $data['surat']->parent_id)->orderBy('id','desc')->first();
        $next = Quran::where('id', '>', $data['surat']->id)->where('parent_id', $data['surat']->parent_id)->orderBy('id')->first();

        $data['prev'] = $prev;
        $data['next'] = $next;

        return view('site.quran.suratpage', $data);
    }

    public function faq(){
        return view('site.faq');
    }

    public function charges(){
        return view('site.charges');
    }

    public function media($slug){
        $query = Media::with(['children' => function ($q) {
            if (request()->q)
                $q->where('title', "like" ,"%".request()->q."%")->orWhere('description', "like" ,"%".request()->q."%");
        }]);
        $data['islamicmedia'] = $query->findBySlug($slug)->first();

        if(!$data['islamicmedia'])
            abort(404);
        return view('site.media', $data);
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
        $url = request()->all();
        $search = DB::table('quran')->select('surat.*')
            ->join('quran as surat', 'surat.parent_id', '=', 'quran.id');
        if (!$request->page) {
            $search->where('quran.slug', $request->surat);
            if($request->ayat_from){
                $search->whereRaw("({$request->ayat_from} between surat.ayat_from and surat.ayat_to OR {$request->ayat_from} <= surat.ayat_to)");
            }
            if($request->ayat_to){
                $search->WhereRaw("({$request->ayat_to} between surat.ayat_from and surat.ayat_to OR {$request->ayat_to} >= surat.ayat_to)");
            }
        }
        if($request->page){
            $prev = DB::table('quran')->whereNotNull('parent_id')->where('number', $request->page - 1)->count();
            $next = DB::table('quran')->whereNotNull('parent_id')->where('number', $request->page + 1)->count();
            if ($prev) {
                $url['page'] = $request->page - 1;
                $data['previous'] = http_build_query($url);
            }
            if ($next) {
                $url['page'] = $request->page + 1;
                $data['next'] = http_build_query($url);
            }
            $search->where('surat.number', $request->page);
        }

        $data['search'] = $search->orderBy('number', 'asc')->get();
        return view('site.search', $data);
    }
}
