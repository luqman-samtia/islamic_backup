@extends('adminlte::page')

@section('title', 'Edit '. $childMedia->title)

@section('content_header')
    <h1>
        Edit {{ $childMedia->title }}
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
                                <input type="text" name="title" value="{{ $childMedia->title }}" class="form-control" autocomplete="title" autofocus>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="description" class="form-control" rows="4" placeholder="Enter Description" autofocus>{{ $childMedia->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label> Edit Video URL </label>
                                <input type="url" name="video_id" value="{{ $childMedia->video_id }}" class="form-control" placeholder="Edit Video URL" autofocus>
                                <div class="alert-danger">
                                    @error('video_id')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('media.media',$childMedia->parent_id) }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop