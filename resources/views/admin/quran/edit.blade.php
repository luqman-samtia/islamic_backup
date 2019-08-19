@extends('adminlte::page')

@section('title', 'Edit Resources')

@section('content_header')
    <h1>
        Edit Resources
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
                                <label>Title</label>
                                <input type="text" name="title" value="{{ $resource->title }}" class="form-control" autocomplete="title" autofocus>
                            </div>
                            <div class="form-group">
                                <label> Edit Image </label>
                                <div class="d-flex">
                                    <img src="{{ asset('storage/'.$resource->image) }}" style="width: 200px;"/>
                                    <input type="file" , class="form-control-file" id="image" name="image" >
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('resources') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop