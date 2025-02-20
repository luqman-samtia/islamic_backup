@extends('adminlte::page')

@section('title', 'Edit Scholars')

@section('content_header')
    <h1>
        Edit Scholars
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-body">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $scholar->name }}" class="form-control" autocomplete="name" autofocus>
                            </div>
                            <div class="form-group">
                                <label>E-Mail</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email}}" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="If Update Enter Password">
                            </div>
                            <div class="form-group">
                                <label>Salary</label>
                                <input type="text" name="salary" value="{{ $scholar->salary }}" class="form-control" autocomplete="salary" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Phone</label>
                                <input type="text" name="phone" value="{{ $scholar->phone }}" class="form-control" autocomplete="phone" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" value="{{ $scholar->address }}" class="form-control" autocomplete="address" autofocus>
                            </div>
                            <div class="form-group">
                                <label>CNIC</label>
                                <input type="text" name="cnic" value="{{ $scholar->cnic }}" class="form-control" autocomplete="cnic" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Notes</label>
                                <input type="text" name="notes" value="{{ $scholar->notes }}" class="form-control" autocomplete="notes" autofocus>
                            </div>
                            <div class="form-group">
                                <label>Order</label>
                                <input type="number" name="sort" value="{{ $scholar->sort }}" class="form-control" min="0" autocomplete="sort" autofocus>
                            </div>
                            <div class="form-group">
                                <label> Edit Image </label>
                                <div class="d-flex">
                                    <img src="{{ asset('storage/'.$scholar->image) }}" style="width: 200px;"/>
                                    <input type="file"  class="form-control-file" id="image" name="image" >
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('scholars') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
@stop