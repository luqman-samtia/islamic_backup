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

    public function update()
    {
        $column = array_keys(request()->info);
        $information = Information::query()->first();
        if (!$information)
            $information = Information::create();

        $information->{$column[0]} = request()->info[$column[0]];
        $information->save();

        echo json_encode('true');
    }
}
