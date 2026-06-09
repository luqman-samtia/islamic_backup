@extends('adminlte::page')

@section('title', 'Add ' . $quran->title)

@section('content_header')
    <h1>
        Add {{ $quran->title }}
        <div class="pull-right">
            {{-- Previous Surah Button --}}
            @if(isset($prevSurah) && $prevSurah)
                <a href="{{ route('quran.child.add', $prevSurah->id) }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-arrow-left"></i> Previous Surah
                </a>
            @endif

            {{-- Next Surah Button --}}
            @if(isset($nextSurah) && $nextSurah)
                <a href="{{ route('quran.child.add', $nextSurah->id) }}" class="btn btn-sm btn-info">
                    Next Surah <i class="fa fa-arrow-right"></i>
                </a>
            @endif
        </div>
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
                                <label>Page #</label>
                                <input type="number" name="number" min="1" class="form-control"
                                    placeholder="Enter Page Number" required>
                            </div>
                            <div class="form-group">
                                <label for="para_no">Para Number</label>
                                <select name="para_no" id="para_no" class="form-control" required>
                                    <option value="">-- Select Para --</option>
                                    @foreach ($paras as $number => $para)
                                        <option value="{{ $number }}">
                                             {{ $para }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="form-group">
                                <label>Ayat From</label>
                                <input type="number" name="ayat_from" min="1" class="form-control" placeholder="Ayat From " required>
                            </div>
                            <div class="form-group">
                                <label>Ayat To</label>
                                <input type="number" name="ayat_to" min="1" class="form-control" placeholder="Ayat To" required>
                            </div> --}}
                            <div class="form-group">
                                <label> Upload Image </label>

                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('quran.quran', $quran->id) }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop
