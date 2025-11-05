@extends('adminlte::page')

@section('title', 'Edit Testimonial')

@section('content_header')
    <h1>
        Edit {{ $isFeedback ? 'Feedback' : 'Testimonial' }}
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ $isFeedback ? 'Edit Feedback' : 'Edit Testimonial' }}</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">{{ $isFeedback ? 'Feedback Title' : 'Name' }}</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" 
                                   value="{{ $isFeedback ? $model->title : $model->name }}" required>
                        </div>

                        <div class="form-group">
                            <label for="description">{{ $isFeedback ? 'Feedback' : 'Description' }}</label>
                            <textarea class="form-control" id="description" name="description" rows="5" 
                                      placeholder="Enter description" required>{{ $isFeedback ? $model->feedback : $model->description }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            @if($model->image)
                                <div class="mt-2">
                                    <small class="text-muted">Current image:</small>
                                    <br>
                                    <img src="{{ asset('storage/' . $model->image) }}" style="width: 100px; height: 100px; margin-top: 10px;" alt="Current Image">
                                </div>
                            @endif
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('testimonials') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop