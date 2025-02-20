@extends('adminlte::page')

@section('title', 'Add Scholars')

@section('content_header')
    <h1>
        Add Scholars
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-body">
                     {{-- Display Validation Errors --}}
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
                                <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                            </div>
                            <div class="form-group">
                                <label>E-Mail</label>
                                <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                            </div>
                            <div class="form-group">
                                <label>Salary</label>
                                <input type="number" name="salary" class="form-control" placeholder="Enter Salary" required>
                            </div>
                            <div class="form-group">
                                <label>Phone </label>
                                <input type="text" name="phone" class="form-control" placeholder="Enter Phone" required>
                            </div>
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address" required>
                            </div>
                            <div class="form-group">
                                <label>CNIC</label>
                                <input type="text" name="cnic" class="form-control" placeholder="Enter CNIC" required>
                            </div>
                            <div class="form-group">
                                <label>Notes</label>
                                <input type="text" name="notes" class="form-control" placeholder="Enter Notes" required>
                            </div>
                            <div class="form-group">
                                <label>Order</label>
                                <input type="number" name="sort" class="form-control" min="0" value="0" placeholder="Enter Order" required>
                            </div>
                            <div class="form-group">
                                <label> Upload Image </label>

                                <input type="file" class="form-control-file" id="image" name="image">
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
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