@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row">
        <div class="col-md-6 col-12 col-sm-12">
            <h1>Dashboard</h1>
        </div>
        <div class="col-md-6 col-12 col-sm-12 text-right">
            <h3>Welcome - {{Auth::user()->name}}</h3>
        </div>
       

    </div>
@stop

@section('content')
    <div class="row">
        @if (Auth::check() && Auth::user()->type=='student')
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    {{-- <h3>{{ $resources }}</h3> --}}

                    <p>Student Info</p>
                </div>
              
                <a href="{{route('information.student-data.show')}}" class="small-box-footer">
                    GO TO <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    {{-- <h3>{{ $surah }}</h3> --}}

                    <p>Update Password</p>
                </div>
               
                <a href="{{route('student.update-password')}}" class="small-box-footer">
                    GO TO <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @elseif (Auth::check() && Auth::user()->type=='scholar')
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    {{-- <h3>{{ $resources }}</h3> --}}

                    <p>View Student</p>
                </div>
              
                <a href="{{route('scholars.students')}}" class="small-box-footer">
                    GO TO <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @else
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $resources }}</h3>

                    <p>Islamic Resources</p>
                </div>
                <div class="icon">
                    <i class="fa fa-list"></i>
                </div>
                <a href="{{ route('resources') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $surah }}</h3>

                    <p>Total Surah's</p>
                </div>
                <div class="icon">
                    <i class="fa fa-book"></i>
                </div>
                <a href="{{ route('quran') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $articles }}</h3>

                    <p>Total Articles</p>
                </div>
                <div class="icon">
                    <i class="fa fa-file"></i>
                </div>
                <a href="{{ route('articals') }}" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
        @endif
        <!-- ./col -->
        
        <!-- ./col -->
        {{--<div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <h3>65</h3>

                    <p>Unique Visitors</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">
                    More info <i class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>--}}
        <!-- ./col -->
    </div>
@stop