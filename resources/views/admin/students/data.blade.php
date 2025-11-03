@extends('adminlte::page')

@section('title', 'Student')

@section('content_header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <h1>Student Info</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-lg-12">
            
            <!-- Filters -->
          
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('information.student-data.show') }}" style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <select name="year" class="form-control" style="max-width: 150px;">
                            <option value="">-- All Years --</option>
                            @foreach($years as $year)
                                <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                    {{ $year }}
                                </option>
                            @endforeach
                        </select>

                        <select name="month" class="form-control" style="max-width: 150px;">
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

                        <button type="submit" class="btn btn-primary" style="max-width: 120px;">Filter</button>
                    </form>
                </div>
            </div>
           

            <!-- Cards Display -->
            @if($studentData->count() > 0)
                @foreach($studentData->groupBy(function($item) { return $item->created_at->format('Y-m'); }) as $yearMonth => $items)
                    @php
                        $monthNumber = \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->month;
                        $monthColor = $monthColors[$monthNumber];
                    @endphp
                    
                    <div class="mb-4">
                        <h5 style="color: {{ $monthColor }}; font-weight: bold; padding-bottom: 10px; border-bottom: 3px solid {{ $monthColor }};">
                            {{ \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->format('F Y') }}
                        </h5>
                        
                        <div class="row mt-3">
                            @foreach($items as $data)
                                <div class="col-md-3 mb-3">
                                    <div class="wdgt-box" style="border: 2px solid {{ $monthColor }}; border-radius: 8px; overflow: hidden; transition: all 0.3s ease; height: 100%;margin-bottom: 5px;">
                                        <div style="background: linear-gradient(135deg, rgba({{ substr($monthColor, 1, 2) }}, {{ substr($monthColor, 3, 2) }}, {{ substr($monthColor, 5, 2) }}, 0.1) 0%, rgba(255, 255, 255, 1) 100%); padding: 20px;">
                                            <div style="border-left: 4px solid {{ $monthColor }}; padding-left: 15px;">
                                                <h6 style="color: {{ $monthColor }}; margin-bottom: 15px; font-weight: bold; min-height: 10px;">
                                                    {{ \Str::limit($data->title, 50, '...') }}
                                                </h6>
                                                <a href="{{ $data->link }}" 
                                                   target="_blank" 
                                                   class="btn btn-sm" 
                                                   style="background-color: {{ $monthColor }}; color: white; width: 100%; border: none; display: block;">
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
                <div class="alert alert-info" role="alert">
                    <h5>No Data Found</h5>
                    <p>No student data available for the selected filters.</p>
                </div>
            @endif
        </div>
    </div>

    <style>
        .wdgt-box:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
            transform: translateY(-5px);
        }
    </style>
@stop