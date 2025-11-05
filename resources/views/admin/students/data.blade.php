@extends('adminlte::page')

@section('title', 'Student')

@section('content_header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
@stop

@section('content')
<div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 30px;">
    <div>
        <h1>Student Info</h1>
    </div>
    <div style="text-align: right;">
        <div style="margin-bottom: 10px;">
            <p style="margin: 0; font-size: 14px; color: #666;">Student joined : </p>
            <strong>{{ $studentDate->created_at->format('F j, Y') }}</strong>
        </div>
        <div>
            <p style="margin: 0; font-size: 14px; color: #666;">Leave Date :</p>
            @if ($studentDate->leave_date)
                <strong>{{ \Carbon\Carbon::parse($studentDate->leave_date)->format('F j, Y') }}</strong>
            @else
                <strong>N/A</strong>
            @endif
        </div>
    </div>
</div>

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

                    <button type="submit" class="btn btn-primary" style="max-width: 120px;">Filter</button>
                </form>
            </div>
        </div>

        <!-- Cards Display -->
        @if($studentData->count() > 0)
            @php
                $grouped = $studentData->groupBy(function($item) { 
                    return $item->created_at->format('Y-m'); 
                });
                
                $sortedMonths = $grouped->keys()->sort()->values()->toArray();
                $monthChunks = array_chunk($sortedMonths, 4);
            @endphp

            @foreach($monthChunks as $monthRow)
                <div class="row mb-5">
                    @foreach($monthRow as $yearMonth)
                        @php
                            $monthNumber = \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->month;
                            $monthColor = $monthColors[$monthNumber];
                            $items = $grouped[$yearMonth];
                            $monthName = \Carbon\Carbon::createFromFormat('Y-m', $yearMonth)->format('F Y');
                        @endphp
                        
                        <div class="col-md-3 col-sm-6 col-lg-3 mb-4">
                            <h5 style="color: {{ $monthColor }}; font-weight: bold; padding-bottom: 10px; border-bottom: 3px solid {{ $monthColor }}; margin-bottom: 15px;">
                                {{ $monthName }}
                            </h5>

                            <div style="display: flex; flex-direction: column; gap: 12px;">
                                @foreach($items->sortBy('created_at') as $data)
                                    <div class="wdgt-box" style="border: 2px solid {{ $monthColor }}; border-radius: 8px; overflow: hidden; transition: all 0.3s ease;">
                                        <div style="background: linear-gradient(135deg, rgba({{ substr($monthColor, 1, 2) }}, {{ substr($monthColor, 3, 2) }}, {{ substr($monthColor, 5, 2) }}, 0.1) 0%, rgba(255, 255, 255, 1) 100%); padding: 15px;">
                                            <div style="border-left: 4px solid {{ $monthColor }}; padding-left: 12px;">
                                                <h6 style="color: {{ $monthColor }}; margin-bottom: 12px; font-weight: bold; font-size: 13px; min-height: 40px; display: flex; align-items: center;">
                                                    {{ \Str::limit($data->title, 50, '...') }}
                                                </h6>
                                                <a href="{{ $data->link }}" 
                                                target="_blank" 
                                                class="btn btn-sm" 
                                                style="background-color: {{ $monthColor }}; color: white; width: 100%; border: none; display: block; text-decoration: none; font-size: 12px;">
                                                    Open Link
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
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
    .wdgt-box {
        cursor: pointer;
    }
    
    .wdgt-box:hover {
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
        transform: translateY(-3px);
    }
</style>
@stop