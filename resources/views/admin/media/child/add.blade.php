@extends('adminlte::page')

@section('title', 'Add '. $media->title)

@section('content_header')
    <h1>
        Add {{ $media->title }}
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
                                <input type="text" name="title" class="form-control" placeholder="Enter Title" required>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter Description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label> Upload Video URL </label>
                                <input type="url" class="form-control" placeholder="Enter Video URL" id="video_id" name="video_id" required>
                                <div class="alert-danger">
                                    @error('video_id')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('media') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop