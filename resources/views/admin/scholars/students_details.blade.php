@extends('adminlte::page')

@section('title', 'Students Details')

@section('content')
    <div class="container-fluid">
        <div class="row mb-4">
            <div class="col-md-12">
                <h3>Students Details</h3>
            </div>
        </div>

        <!-- Filters -->
        <div class="row ">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card ">
                    <div class="card-body">
                        <form method="GET" action="{{ route('scholars.studentsDetails') }}">
                            {{-- <div class="row"> --}}
                                <div class="col-md-3">
                                    <label>Select Student</label>
                                    <select name="student_id" class="form-control">
                                        <option value="">-- All Students --</option>
                                        @foreach($students as $student)
                                            <option value="{{ $student->id }}" {{ request('student_id') == $student->id ? 'selected' : '' }}>
                                                {{ $student->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Select Year</label>
                                    <select name="year" class="form-control">
                                        <option value="">-- All Years --</option>
                                        @foreach($years as $year)
                                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Select Month</label>
                                    <select name="month" class="form-control">
                                        <option value="">-- All Months --</option>
                                        <option value="1" {{ request('month') == 1 ? 'selected' : '' }}>January</option>
                                        <option value="2" {{ request('month') == 2 ? 'selected' : '' }}>February</option>
                                        <option value="3" {{ request('month') == 3 ? 'selected' : '' }}>March</option>
                                        <option value="4" {{ request('month') == 4 ? 'selected' : '' }}>April</option>
                                        <option value="5" {{ request('month') == 5 ? 'selected' : '' }}>May</option>
                                        <option value="6" {{ request('month') == 6 ? 'selected' : '' }}>June</option>
                                        <option value="7" {{ request('month') == 7 ? 'selected' : '' }}>July</option>
                                        <option value="8" {{ request('month') == 8 ? 'selected' : '' }}>August</option>
                                        <option value="9" {{ request('month') == 9 ? 'selected' : '' }}>September</option>
                                        <option value="10" {{ request('month') == 10 ? 'selected' : '' }}>October</option>
                                        <option value="11" {{ request('month') == 11 ? 'selected' : '' }}>November</option>
                                        <option value="12" {{ request('month') == 12 ? 'selected' : '' }}>December</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>&nbsp;</label>
                                    <button type="submit" class="btn btn-primary btn-block">Filter</button>
                                </div>
                            {{-- </div> --}}
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cards Display -->
        <div class="row">
            @if($studentsData->count() > 0)
                @foreach($studentsData->groupBy(function($item) { return $item->created_at->format('Y-m'); }) as $yearMonth => $items)
                    @php
                        $monthNumber = \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->month;
                        $monthColor = $monthColors[$monthNumber];
                    @endphp
                    <div class="col-md-12 mb-4">
                        <h5 class="mb-3" style="color: {{ $monthColor }}; font-weight: bold; padding-bottom: 10px; border-bottom: 3px solid {{ $monthColor }};">
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->format('F Y') }}
                        </h5>
                        <div class="row">
                            @foreach($items as $data)
                                <div class="col-md-3 mb-3">
                                    <div class="card" style="border: 2px solid {{ $monthColor }}; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; height: 100%; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 5px;">
                                        <div class="card-body" style="background: linear-gradient(135deg, rgba({{ substr($monthColor, 1, 2) }}, {{ substr($monthColor, 3, 2) }}, {{ substr($monthColor, 5, 2) }}, 0.1) 0%, rgba(255, 255, 255, 1) 100%);padding: 20px;">
                                            <div style="border-left: 4px solid {{ $monthColor }}; padding-left: 15px; height: 100%;">
                                                <h6 style="color: {{ $monthColor }}; margin-bottom: 15px; font-weight: bold; min-height: 10px;">
                                                    {{ \Str::limit($data->title, 60, '...') }}
                                                </h6>
                                                <a href="{{ $data->link }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm" 
                                                   style="background-color: {{ $monthColor }}; color: white; width: 100%; border: none; transition: all 0.3s ease;">
                                                    Open Link
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-md-12">
                    <div class="alert alert-info" role="alert">
                        <h5>No data found</h5>
                        <p>No students details available for selected filters.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
    </style>
@endsection