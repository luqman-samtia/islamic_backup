<?php

namespace App\Http\Controllers;

use App\Information;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use DataTables;

class InformationController extends Controller
{

    public function index(Request $request){
        $data['info'] = Information::query()->first();
       
        return view('admin.information.index', $data);
    }

    public function update(Request $request)
    {
        // old code
        // $column = array_keys(request()->info);
        // $information = Information::query()->first();
        // if (!$information)
        //     $information = Information::create();

        // $information->{$column[0]} = request()->info[$column[0]];
        // $information->save();

        // echo json_encode('true');


        // new code 
         // Retrieve or create the Information record
         $information = Information::query()->first();
         if (!$information) {
             $information = Information::create();
         }
     
         // Check for dynamic footer items in the request
         if ($request->has('dynamic_footer_items')) {
             // Store the dynamic footer items as an array
             $information->dynamic_footer_items = $request->input('dynamic_footer_items');
         }
     
         // Save other existing fields if needed
         if ($request->has('info')) {
             $column = array_keys($request->info);
             $information->{$column[0]} = $request->info[$column[0]];
         }
     
         // Save all updates to the Information model
         $information->save();
     
         // Return a JSON response for success
         return response()->json(['success' => true]);
    }
}
