@extends('adminlte::page')

@section('title', 'Edit '. $childResource->title)

@section('content_header')
    <h1>
        Edit {{ $childResource->title }}
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
                                <input type="text" name="title" value="{{ $childResource->title }}" class="form-control" autocomplete="title" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Page #</label>
                                <input type="number" name="number" min="1" class="form-control" required value="{{ $childResource->number }}">
                            </div>
                            <div class="form-group">
                                <label> Edit Image </label>
                                <div class="d-flex">
                                    <img src="{{ asset('storage/'.$childResource->image) }}" style="width: 200px;"/>
                                    <input type="file" , class="form-control-file" id="image" name="image" >
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('resources.resources',$childResource->parent_id) }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop