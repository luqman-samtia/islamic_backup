@extends('adminlte::page')

@section('title', 'Edit Surah')

@section('content_header')
    <h1>
        Edit Surah
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
                                <input type="text" name="title" value="{{ $quran->title }}" class="form-control" autocomplete="title" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Surah #</label>
                                <input type="number" name="number" min="1" class="form-control" placeholder="Enter Surah Number" required value="{{ $quran->number }}">
                            </div>
                            <div class="form-group">
                                <label>Para No #</label>
                                <input type="number" name="para_no" min="1" class="form-control" placeholder="Enter Para Number"  value="{{ $quran->para_no }}">
                            </div>
                            <div class="form-group">
                                <label> Image </label>
                                <div class="d-flex">
                                    @if($quran->image)
                                    <img src="{{ asset('storage/'.$quran->image) }}" style="width: 200px;"/>
                                    @endif
                                    <input type="file" class="form-control-file" id="image" name="image" >
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('quran') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop