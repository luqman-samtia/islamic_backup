@extends('adminlte::page')

@section('title', 'Lessons Report')

@section('content_header')
    <h1 class="report-title"><i class="fa fa-graduation-cap"></i> Lessons Report</h1>
@stop

@section('content')
@php
    $totalLessons   = $records->count();
    $uniqueStudents = $records->pluck('user_id')->unique()->count();
    $latest         = optional($records->sortByDesc('lesson_date')->first())->lesson_date;

    // helper: pretty value for a column key (real column ya extra JSON se)
    $cellVal = function ($r, $key) {
        $v = $r->{$key} ?? null;
        if (($v === null || $v === '') && !empty($r->extra) && is_array($r->extra)) {
            $v = $r->extra[$key] ?? null;
        }
        if ($key === 'lesson_date') {
            return $v ? \Carbon\Carbon::parse($v)->format('d-M-Y') : '';
        }
        return $v;
    };
@endphp

{{-- ===== Summary cards ===== --}}
<div class="row stat-row">
    <div class="col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon bg-blue"><i class="fa fa-book"></i></div>
            <div class="stat-info">
                <span class="stat-num">{{ $totalLessons }}</span>
                <span class="stat-label">Total Lessons</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6">
        <div class="stat-card">
            <div class="stat-icon bg-green"><i class="fa fa-users"></i></div>
            <div class="stat-info">
                <span class="stat-num">{{ $uniqueStudents }}</span>
                <span class="stat-label">Students</span>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="stat-card">
            <div class="stat-icon bg-purple"><i class="fa fa-calendar"></i></div>
            <div class="stat-info">
                <span class="stat-num">{{ $latest ? \Carbon\Carbon::parse($latest)->format('d M Y') : '—' }}</span>
                <span class="stat-label">Latest Lesson</span>
            </div>
        </div>
    </div>
</div>

{{-- ===== Filter card ===== --}}
<div class="report-card">
    <div class="report-card-head">
        <form method="GET" class="filter-bar" action="{{ route('admin.lessons.report') }}">
            <select name="lesson_type" class="form-control">
                <option value="">All Types</option>
                @foreach($typeLabels as $key => $label)
                    <option value="{{ $key }}" {{ request('lesson_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>

            <select name="student_id" id="studentSelect" class="form-control">
                <option value="">All Students</option>
                @foreach($students as $s)
                    <option value="{{ $s->id }}" {{ request('student_id') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>
                @endforeach
            </select>

            <select name="month" class="form-control">
                <option value="">Month</option>
                @foreach(\App\FeeRecord::$months as $n => $m)
                    <option value="{{ $n }}" {{ request('month') == $n ? 'selected' : '' }}>{{ $m }}</option>
                @endforeach
            </select>

            <input type="number" name="year" class="form-control year-input" placeholder="Year" value="{{ request('year') }}">

            <button class="btn btn-primary"><i class="fa fa-filter"></i> Filter</button>
            <a href="{{ route('admin.lessons.report') }}" class="btn btn-default">Reset</a>

            <a href="#" id="downloadPdf" class="btn btn-danger pull-right">
                <i class="fa fa-file-pdf-o"></i> Download PDF
            </a>
        </form>
    </div>
</div>

{{-- ===== One table per lesson type (dynamic columns) ===== --}}
@forelse($grouped as $type => $g)
<div class="report-card type-block">
    <div class="type-head">
        <span class="type-badge"><i class="fa fa-book"></i> {{ $typeLabels[$type] ?? ucfirst($type) }}</span>
        <span class="type-count">{{ $g['records']->count() }} lessons</span>
    </div>

    <div class="report-card-body table-responsive">
        <table class="table modern-table">
            <thead>
                <tr >
                    <th style="width:42px;color: #ffff !important;">#</th>
                    <th style = "color: #ffff !important;">Student</th>
                    @foreach($g['columns'] as $col)
                        <th style = "color: #ffff !important;">{{ $col['label'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @forelse($g['records'] as $i => $r)
                <tr>
                    <td class="muted">{{ $i + 1 }}</td>
                    <td>
                        <div class="student-cell">
                            <span class="avatar">{{ strtoupper(substr(optional($r->user)->name ?? '?', 0, 1)) }}</span>
                            <span>{{ optional($r->user)->name }}</span>
                        </div>
                    </td>
                    @foreach($g['columns'] as $col)
                        @php
                            $key = $col['key'];
                            $val = $cellVal($r, $key);
                            $att = ($key === 'attendance') ? strtolower(trim($val ?? '')) : null;
                        @endphp
                        <td class="{{ $key === 'notes' ? 'notes-cell' : '' }}">
                            @if($key === 'attendance')
                                @if($att)
                                    <span class="pill {{ str_contains($att,'present') || str_contains($att,'haz') ? 'pill-green' : (str_contains($att,'absent') || str_contains($att,'ghair') ? 'pill-red' : 'pill-gray') }}">
                                        {{ $val }}
                                    </span>
                                @else <span class="muted">—</span> @endif
                            @elseif($key === 'lesson_date')
                                {{ $val ?: '—' }}
                                @if($r->day)<br><small class="muted">{{ $r->day }}</small>@endif
                            @else
                                {{ ($val !== null && $val !== '') ? $val : '—' }}
                            @endif
                        </td>
                    @endforeach
                </tr>
                @empty
                <tr>
                    <td colspan="{{ count($g['columns']) + 2 }}" class="empty-state">
                        <i class="fa fa-inbox"></i><br>No lessons found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@empty
<div class="report-card">
    <div class="report-card-body">
        <div class="empty-state"><i class="fa fa-inbox"></i><br>No lessons found.</div>
    </div>
</div>
@endforelse
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
.report-title i { color:#2c7be5; }
.stat-row { margin-bottom: 5px; }
.stat-card {
    background:#fff; border:1px solid #e2e8f0; border-radius:12px; padding:18px 20px;
    display:flex; align-items:center;
    box-shadow:0 2px 12px rgba(0,0,0,.06); margin-bottom:18px;
}
.stat-icon {
    width:52px; height:52px; border-radius:12px; display:flex; align-items:center;
    justify-content:center; color:#fff; font-size:22px; margin-right:15px; flex-shrink:0;
}
.bg-blue{background:linear-gradient(135deg,#2c7be5,#1a68d1);}
.bg-green{background:linear-gradient(135deg,#2dce89,#26af74);}
.bg-purple{background:linear-gradient(135deg,#8965e0,#7048c5);}
.stat-info{display:flex;flex-direction:column;}
.stat-num{font-size:22px;font-weight:700;color:#2d3748;line-height:1.1;}
.stat-label{font-size:12px;color:#718096;text-transform:uppercase;letter-spacing:.5px;font-weight:700;}

.report-card{background:#fff;border-radius:12px;box-shadow:0 2px 12px rgba(0,0,0,.06);overflow:hidden;margin-bottom:18px;}
.report-card-head{padding:18px 20px;}
.filter-bar{display:flex;flex-wrap:wrap;gap:10px;align-items:center;}
.filter-bar .form-control{width:auto;border-radius:8px;height:38px;}
.filter-bar .year-input{width:90px;}
.filter-bar .btn{border-radius:8px;height:38px;}
.filter-bar .pull-right{margin-left:auto;}

.type-block .type-head{
    display:flex;align-items:center;justify-content:space-between;
    padding:14px 20px;border-bottom:1px solid #edf2f7;background:#fafbfc;
}
.type-badge{display:inline-flex;align-items:center;gap:8px;font-size:14px;font-weight:800;color:#243240;}
.type-badge i{color:#2c7be5;}
.type-count{font-size:12px;color:#a0aec0;font-weight:600;}

.modern-table{margin:0;border-collapse:separate;border-spacing:0;}
.modern-table thead th{
    background:#2d3748;color:#fff;font-size:11px;text-transform:uppercase;font-weight:700;
    letter-spacing:.4px;border:1px solid #2d3748;padding:12px 14px;white-space:nowrap;
}
.modern-table tbody td{
    padding:12px 14px;border:1px solid #e2e8f0;vertical-align:middle;font-size:13px;
}
.modern-table tbody tr:hover td{background:#f7faff;}
.muted{color:#a0aec0;}
.notes-cell{max-width:220px;color:#4a5568;}

.student-cell{display:flex;align-items:center;gap:9px;white-space:nowrap;}
.avatar{
    width:30px;height:30px;border-radius:50%;background:#2c7be5;color:#fff;
    display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:700;flex-shrink:0;
}
.pill{display:inline-block;padding:3px 10px;border-radius:20px;font-size:11px;font-weight:600;}
.pill-green{background:#e6f9f1;color:#1a9f6c;}
.pill-red{background:#fdecec;color:#d9534f;}
.pill-gray{background:#edf2f7;color:#718096;}
.empty-state{text-align:center;color:#cbd5e0;padding:40px;font-size:14px;}
.empty-state i{font-size:34px;margin-bottom:8px;display:block;}

.filter-bar .select2-container{min-width:220px;}
.filter-bar .select2-container .select2-selection--single{
    height:38px;border:1px solid #d2d6de;border-radius:8px;display:flex;align-items:center;
}
.filter-bar .select2-container--default .select2-selection--single .select2-selection__arrow{
    height:36px;
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    $('#studentSelect').select2({
        placeholder: 'Search student...',
        allowClear: true,
        width: '220px'
    });
});

$('#downloadPdf').on('click', function (e) {
    e.preventDefault();
    var studentId = $('#studentSelect').val();
    if (!studentId) {
        Swal.fire('Select Student', 'Please select a student to generate the PDF report.', 'info');
        return;
    }
    var params = $('.filter-bar').serialize();
    window.location.href = '{{ route('admin.lessons.report.pdf') }}?' + params;
});
</script>
@stop