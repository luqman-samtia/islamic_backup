@extends('adminlte::page')

@section('title', 'Edit Testimonials')

@section('content_header')
    <h1>
        Edit Testimonials
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
                                <input type="text" name="name" value="{{ $testimonial->name }}" class="form-control" autocomplete="name" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <input type="text" name="description" value="{{ $testimonial->description }}" class="form-control" autocomplete="description" autofocus>
                            </div>
                            <div class="form-group">
                                <label> Edit Image </label>
                                <div class="d-flex">
                                    <img src="{{ asset('storage/'.$testimonial->image) }}" style="width: 200px;"/>
                                    <input type="file"  class="form-control-file" id="image" name="image" >
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('testimonials') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop