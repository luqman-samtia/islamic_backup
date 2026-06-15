@extends('adminlte::page')

@section('title', 'Lessons Report')

@section('content_header')
    <h1>Lessons Report</h1>
@stop

@section('content')
@php $typeLabels = \App\StudentCourse::types(); @endphp
<div class="box box-primary">
    <div class="box-header with-border">
        <form method="GET" class="form-inline" action="{{ route('admin.lessons.report') }}">
            <select name="lesson_type" class="form-control">
                <option value="">All Types</option>
                @foreach(\App\StudentCourse::types() as $key => $label)
                    <option value="{{ $key }}" {{ request('lesson_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            @if($students->count() > 1)
            <select name="student_id" class="form-control">
                <option value="">All Students</option>
                @foreach($students as $s)
                    <option value="{{ $s->id }}" {{ request('student_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>
            @endif

            <select name="month" class="form-control">
                <option value="">Month</option>
                @foreach(\App\FeeRecord::$months as $n => $m)
                    <option value="{{ $n }}" {{ request('month') == $n ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
            </select>

            <input type="number" name="year" class="form-control" placeholder="Year" style="width:100px" value="{{ request('year') }}">

            <button class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
            <a href="{{ route('admin.lessons.report') }}" class="btn btn-default">Reset</a>
        </form>
    </div>

    <div class="box-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="bg-gray">
                    <th>#</th>
                    <th>Student</th>
                    <th>Type</th>
                    <th>Day & Date</th>
                    <th>Attendance</th>
                    <th>Course</th>
                    <th>Lesson</th>
                    <th>Page</th>
                    <th>From → To</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $r)
                @php
                    $lessonBits = array_filter([$r->para_name, $r->surah_name, $r->tehti_number, $r->select_lesson]);
                    $fromTo = ($r->ayat_from || $r->ayat_to)
                                ? trim(($r->ayat_from ?? '') . ' → ' . ($r->ayat_to ?? ''), ' →')
                                : trim(($r->line_from ?? '') . ' → ' . ($r->line_to ?? ''), ' →');
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ optional($r->user)->name }}</td>
                    <td><span class="label label-info">{{ $typeLabels[$r->lesson_type] ?? ucfirst($r->lesson_type) }}</span></td>
                    <td>
                        {{ $r->day }}<br>
                        <small>{{ $r->lesson_date ? \Carbon\Carbon::parse($r->lesson_date)->format('d-M-Y') : '' }}</small>
                    </td>
                    <td>{{ $r->attendance }}</td>
                    <td>{{ $r->course }}</td>
                    <td>{{ implode(' / ', $lessonBits) }}</td>
                    <td>{{ $r->page_number }}</td>
                    <td>{{ $fromTo }}</td>
                    <td>{{ $r->notes }}</td>
                </tr>
                @empty
                <tr><td colspan="10" class="text-center text-muted">No lessons found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop
