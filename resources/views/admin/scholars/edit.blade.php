@extends('adminlte::page')

@section('title', 'Edit Scholars')

@section('content_header')
    <h1>
        Edit Scholars
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-body">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $scholar->name }}" class="form-control" autocomplete="name" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Order</label>
                                <input type="number" name="sort" value="{{ $scholar->sort }}" class="form-control" min="0" autocomplete="sort" autofocus>
                            </div>
                            <div class="form-group">
                                <label> Edit Image </label>
                                <div class="d-flex">
                                    <img src="{{ asset('storage/'.$scholar->image) }}" style="width: 200px;"/>
                                    <input type="file"  class="form-control-file" id="image" name="image" >
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('scholars') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop