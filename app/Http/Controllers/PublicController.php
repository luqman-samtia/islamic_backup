<?php

namespace App\Http\Controllers;

use App\Media;
use App\Quran;
use App\Articals;
use App\Feedback;
use App\Scholars;
use App\Resources;
use App\TajweedQuran;
use App\Testimonials;
use App\PaymentMethod;
use App\Mail\ContacMail;
use Illuminate\Http\Request;
use App\Constants\QuranParas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class PublicController extends Controller
{
    public function __construct() {
        $resources = \App\Resources::parent(null)->get();
        $articles = \App\Articals::all();
        $media = \App\Media::whereNull('parent_id')->get();
        View::share('resources', $resources);
        View::share('articles', $articles);
        View::share('media', $media);
    }

    public function index(){
        $posts = Articals::orderBy('created_at','desc')->take(6)->get();
        $scholars = Scholars::orderBy('sort')->get();
        $testimonials = Testimonials::orderBy('created_at','desc')->get();
        $feedbacks = Feedback::orderBy('created_at','desc')->get();
        return view('site.index', compact('posts','scholars','testimonials','feedbacks'));
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

    /**
     * Display Quran Index with Surahs
     */
    // public function quran()
    // {
    //     $quran = Quran::whereNull('parent_id')->orderBy('number', 'asc')->get();
    //     return view('site.quran.index', compact('quran'));
    // }

    // /**
    //  * Get Para List via AJAX
    //  */
    // public function quranParaList()
    // {
        
    //     $paraIds = Quran::whereNotNull('para_no')
    //                     ->whereNotNull('parent_id')
    //                     ->groupBy('para_no')
    //                     ->selectRaw('MIN(id) as id')
    //                     ->pluck('id');

    //     $paras = Quran::whereIn('id', $paraIds)
    //                   ->orderBy('para_no', 'asc')
    //                   ->get();

    //     if (request()->ajax()) {
    //         return view('site.quran.para_list', compact('paras'));
    //     }
    //     return view('site.quran.index', compact('paras'));
    // }

    // /**
    //  * Display Para Show Page (Like Surah)
    //  */
    // public function quranParaShow($para_no)
    // {
    //     // Validate para number
    //     if ($para_no < 1 || $para_no > 30) {
    //         abort(404);
    //     }

    //     // Get first page of this para for reference
    //     $para_info = Quran::where('para_no', $para_no)
    //                       ->whereNotNull('parent_id')
    //                       ->orderBy('id', 'asc')
    //                       ->first();

    //     if (!$para_info) {
    //         abort(404);
    //     }

    //     // Get all pages in this para
    //     $pages = Quran::where('para_no', $para_no)
    //                   ->whereNotNull('parent_id')
    //                   ->with('getParent')
    //                   ->orderBy('number', 'asc')
    //                   ->get();
    //     // Get prev/next para
    //     $prev = Quran::where('para_no', '<', $para_no)
    //                  ->whereNotNull('para_no')
    //                  ->whereNotNull('parent_id')
    //                  ->orderBy('para_no', 'desc')
    //                  ->value('para_no');

    //     $next = Quran::where('para_no', '>', $para_no)
    //                  ->whereNotNull('para_no')
    //                  ->whereNotNull('parent_id')
    //                  ->orderBy('para_no', 'asc')
    //                  ->value('para_no');

    //     return view('site.quran.para_show', [
    //         'para_no' => $para_no,
    //         'para_info' => $para_info,
    //         'pages' => $pages,
    //         'prev' => $prev,
    //         'next' => $next
    //     ]);
    // }

    // /**
    //  * Display Surah with all its pages
    //  */
    // public function quranSurat($slug){
    //     $data['surat'] = Quran::with(['children' => function($query){
    //         $query->orderBy('number', 'asc');
    //     }])->findBySlug($slug)->first();

    //     if(!$data['surat'])
    //         abort(404);

    //     $prev = Quran::where('id', '<', $data['surat']->id)->whereNull('parent_id')->orderBy('id','desc')->first();
    //     $next = Quran::where('id', '>', $data['surat']->id)->whereNull('parent_id')->orderBy('id')->first();

    //     $data['prev'] = $prev;
    //     $data['next'] = $next;

    //     return view('site.quran.surat', $data);
    // }

    // /**
    //  * Display specific page of Surah
    //  */
    // public function quranSuratPage($slug, $page){

    //     $data['surat'] = Quran::whereHas('getParent', function($q) use ($slug){
    //         $q->where('slug', $slug);
    //     })->with('getParent')->whereNotNull('parent_id')->where('number', $page)->first();

    //     if(!$data['surat'])
    //         abort(404);

    //     $prev = Quran::where('id', '<', $data['surat']->id)->where('parent_id', $data['surat']->parent_id)->orderBy('id','desc')->first();
    //     $next = Quran::where('id', '>', $data['surat']->id)->where('parent_id', $data['surat']->parent_id)->orderBy('id')->first();

    //     $data['prev'] = $prev;
    //     $data['next'] = $next;

    //     return view('site.quran.suratpage', $data);
    // }
public function quran()
{
    $quran = Quran::whereNull('parent_id')->orderBy('number', 'asc')->get();
    return view('site.quran.index', compact('quran'));
}

public function quranParaList()
{
    $paraIds = Quran::whereNotNull('para_no')
                    ->whereNotNull('parent_id')
                    ->groupBy('para_no')
                    ->selectRaw('MIN(id) as id')
                    ->pluck('id');

    $paras = Quran::whereIn('id', $paraIds)
                  ->orderBy('para_no', 'asc')
                  ->get()
                  ->map(function($para) {
                      $para['para_name'] = QuranParas::getParaName($para->para_no);
                      return $para;
                  });

        if (request()->ajax()) {
            return response()->json($paras);
        }
        
        return view('site.quran.para_list', compact('paras'));
}

public function quranParaShow($para_no)
{
    if ($para_no < 1 || $para_no > 30) {
        abort(404);
    }

    $para_name = QuranParas::getParaName($para_no);
    $para_info = Quran::where('para_no', $para_no)
                      ->whereNotNull('parent_id')
                      ->orderBy('id', 'asc')
                      ->first();

    if (!$para_info) {
        return back()->with('error', 'No para information found for this para.');
    }

    $pages = Quran::where('para_no', $para_no)
                  ->whereNotNull('parent_id')
                  ->with('getParent')
                  ->orderBy('number', 'asc')
                  ->get();
    if ($pages->isEmpty()) {
        return back()->with('error', 'No pages found for this para.');
    }
    $prev = Quran::where('para_no', '<', $para_no)
                 ->whereNotNull('para_no')
                 ->whereNotNull('parent_id')
                 ->orderBy('para_no', 'desc')
                 ->value('para_no');

    $next = Quran::where('para_no', '>', $para_no)
                 ->whereNotNull('para_no')
                 ->whereNotNull('parent_id')
                 ->orderBy('para_no', 'asc')
                 ->value('para_no');

     $allParas = [];
    for ($i = 1; $i <= 30; $i++) {
        $allParas[] = [
            'para_no' => $i,
            'para_name' => QuranParas::getParaName($i)
        ];
    }

    return view('site.quran.para_show', [
        'para_name' => $para_name,
        'para_no' => $para_no,
        'para_info' => $para_info,
        'pages' => $pages,
        'prev' => $prev,
        'next' => $next,
        'allParas' => $allParas 
    ]);
}

public function quranSurat($slug)
{
    $quran = Quran::whereNull('parent_id')->orderBy('number', 'asc')->get();
    
    $surat = Quran::with(['children' => function($query){
        $query->orderBy('number', 'asc');
    }])->where('slug', $slug)->first(); 

    if(!$surat)
        abort(404);

    $prev = Quran::where('id', '<', $surat->id)->whereNull('parent_id')->orderBy('id','desc')->first();
    $next = Quran::where('id', '>', $surat->id)->whereNull('parent_id')->orderBy('id')->first();

    return view('site.quran.surat', compact('surat', 'prev', 'next', 'quran'));
}

public function quranSuratPage($slug, $page)
{
    $surat = Quran::whereHas('getParent', function($q) use ($slug){
        $q->where('slug', $slug);
    })->with('getParent')->whereNotNull('parent_id')->where('number', $page)->first();

    if(!$surat)
        abort(404);

    $prev = Quran::where('id', '<', $surat->id)->where('parent_id', $surat->parent_id)->orderBy('id','desc')->first();
    $next = Quran::where('id', '>', $surat->id)->where('parent_id', $surat->parent_id)->orderBy('id')->first();

    return view('site.quran.suratpage', compact('surat', 'prev', 'next'));
}
    public function tajweedQuran(){
        $quran = TajweedQuran::parent(null)->orderAsc('number')->get();
        return view('site.tajweed-quran.index', compact('quran'));
    }

    public function tajweedQuranSurat($slug){
        $data['surat'] = TajweedQuran::with(['children' => function($query){
            $query->orderAsc('number');
        }])->findBySlug($slug)->first();

        if(!$data['surat'])
            abort(404);

        $prev = TajweedQuran::where('id', '<', $data['surat']->id)->whereNull('parent_id')->orderBy('id','desc')->first();
        $next = TajweedQuran::where('id', '>', $data['surat']->id)->whereNull('parent_id')->orderBy('id')->first();

        $data['prev'] = $prev;
        $data['next'] = $next;

        return view('site.tajweed-quran.surat', $data);
    }

    public function tajweedQuranSuratPage($slug, $page){

        $data['surat'] = TajweedQuran::whereHas('getParent', function($q) use ($slug){
            $q->where('slug', $slug);
        })->with('getParent')->whereNotNull('parent_id')->where('number', $page)->first();

        if(!$data['surat'])
            abort(404);

        $prev = TajweedQuran::where('id', '<', $data['surat']->id)->where('parent_id', $data['surat']->parent_id)->orderBy('id','desc')->first();
        $next = TajweedQuran::where('id', '>', $data['surat']->id)->where('parent_id', $data['surat']->parent_id)->orderBy('id')->first();

        $data['prev'] = $prev;
        $data['next'] = $next;

        return view('site.tajweed-quran.suratpage', $data);
    }

    public function faq(){
        return view('site.faq');
    }

    public function charges(){
        $data['paymentMethods'] = PaymentMethod::all();
        return view('site.charges', $data);
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

    /**
     * Search functionality for Quran
     */
    public function search(Request $request){
    $data['request'] = $request;
    $data['quran'] = Quran::parent(null)->get();
    $url = request()->all();
    $surat = Quran::find($request->page);

    $data['parent_surat'] = null;
    $data['parent_slug'] = null;
    
    $search = DB::table('quran')->select('surat.*')
        ->join('quran as surat', 'surat.parent_id', '=', 'quran.id');
        
    $parent = DB::table('quran')
        ->join('quran as surat', 'surat.parent_id', '=', 'quran.id')
        ->select('quran.title', 'quran.slug')
        ->where('quran.slug', $request->surat)
        ->first();

    if (!$request->page) {
        if ($request->surat) {
            $search->where('quran.slug', $request->surat);
            
            if ($parent) {
                $data['parent_surat'] = $parent->title;
                $data['parent_slug'] = $parent->slug;
            }
        }
              
    }
      if ($request->para_no) {
            $search->where('surat.para_no', $request->para_no);
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
        if ($parent) {
            $data['parent_surat'] = $parent->title;
            $data['parent_slug'] = $parent->slug;
        }
        
        $search->where('surat.number', $request->page);
        
        if ($request->para_no) {
            $search->where('surat.para_no', $request->para_no);
        }
    }

    $data['search'] = $search->orderBy('number', 'asc')->get();
    
    if ($data['search']->isEmpty()) {
        $data['error'] = 'No results found for your search.';
    }
    
    return view('site.search', $data)->with('surat', $surat);
}

    /**
     * Search functionality for Tajweed Quran
     */
     public function tajweedQuranSearch(Request $request){
    $data['request'] = $request;
    $data['quran'] = TajweedQuran::parent(null)->get();
    $url = request()->all();
    $surat = Quran::find($request->page);

    $data['parent_surat'] = null;
    $data['parent_slug'] = null;
    
    $search = DB::table('tajweed_quran')->select('surat.*')
        ->join('tajweed_quran as surat', 'surat.parent_id', '=', 'tajweed_quran.id');
        
    $parent = DB::table('tajweed_quran')
        ->join('tajweed_quran as surat', 'surat.parent_id', '=', 'tajweed_quran.id')
        ->select('tajweed_quran.title', 'tajweed_quran.slug')
        ->where('tajweed_quran.slug', $request->surat)
        ->first();
//     if($request->page){
    
//     $search->where('surat.number', $request->page);
    
//     if ($request->para_no) {
//         $search->where('surat.para_no', $request->para_no);
//     }
// }
    if (!$request->page) {
        $search->where('tajweed_quran.slug', $request->surat);
        
        if ($request->para_no) {
            $search->where('surat.para_no', $request->para_no);
        }
        
        if ($parent) {
            $data['parent_surat'] = $parent->title;
            $data['parent_slug'] = $parent->slug;
        }
    }
    
    if($request->page){
        $prev = DB::table('tajweed_quran')->whereNotNull('parent_id')->where('number', $request->page - 1)->count();
        $next = DB::table('tajweed_quran')->whereNotNull('parent_id')->where('number', $request->page + 1)->count();
        
        if ($prev) {
            $url['page'] = $request->page - 1;
            $data['previous'] = http_build_query($url);
        }
        if ($next) {
            $url['page'] = $request->page + 1;
            $data['next'] = http_build_query($url);
        }
        if ($parent) {
            $data['parent_surat'] = $parent->title;
            $data['parent_slug'] = $parent->slug;
        }
        
        $search->where('surat.number', $request->page);
        
        // Add para_no filter for page search as well
        if ($request->para_no) {
            $search->where('surat.para_no', $request->para_no);
        }
    }

    $data['search'] = $search->orderBy('number', 'asc')->get();
    
    if ($data['search']->isEmpty()) {
        $data['error'] = 'No results found for your search.';
    }
    
    return view('site.tajweed-quran.search', $data);
}

}