<?php

namespace App\Http\Controllers;

use App\PaymentMethod;
use App\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;
use DataTables;

class PaymentsController extends Controller
{

    public function index(Request $request){
        if ($request->ajax()){
            return DataTables::of(PaymentMethod::query())->make(true);
        }
        return view('admin.payments.index');
    }


    public function add(Request $request){
        if ($request->post()){
            PaymentMethod::create($request->except('_token'));
            return redirect()->route('payments');
        }
        return view('admin.payments.add');
    }

    public function edit(Request $request, PaymentMethod $paymentMethod){
        if ($request->post()){
            $paymentMethod->title = $request->title;
            $paymentMethod->description = $request->description;
            $paymentMethod->save();
            return redirect()->route('payments');
        }
        return view('admin.payments.edit', compact('paymentMethod'));
    }
    public function delete(Request $request){
        PaymentMethod::find($request->id)->delete();
        return ['status' => 200];
    }
}
