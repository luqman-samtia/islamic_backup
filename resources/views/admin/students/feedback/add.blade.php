@extends('adminlte::page')

@section('title', 'Add Feedback')

@section('content_header')
    <h1>
        Add Feedback
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
                                <input type="text" name="title" class="form-control" placeholder="Enter Name" required>
                            </div>
                            <div class="form-group">
                                <label for="description" class="form-label">Description</label>
                                <textarea id="description" name="feedback" class="form-control" rows="4" placeholder="Enter Description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label> Upload Image </label>

                                <input type="file" class="form-control-file" id="image" name="image" required>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('student.feedback.submit') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop