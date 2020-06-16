@extends('adminlte::page')

@section('title', 'Footer Information')

@section('content_header')
    <h1>
        Footer Information
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-body -->
                <form id="skype1Form">
                    <div class="box-header with-border">
                        <h3 class="box-title">Skype 1</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Profile Name</label>
                            <input type="text" name="info[skype1][label]" class="form-control" placeholder="Enter Skype Username" value="{{ @$info['skype1']['label'] }}">
                        </div>
                        <div class="form-group">
                            <label>Skype Name</label>
                            <input type="text" name="info[skype1][value]" class="form-control" placeholder="Enter Skype ID" value="{{ @$info['skype1']['value'] }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-body -->
                <form id="skype2Form">
                    <div class="box-header with-border">
                        <h3 class="box-title">Skype 2</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Profile Name</label>
                            <input type="text" name="info[skype2][label]" class="form-control" placeholder="Enter Skype Username" value="{{ @$info['skype2']['label'] }}">
                        </div>
                        <div class="form-group">
                            <label>Skype Name</label>
                            <input type="text" name="info[skype2][value]" class="form-control" placeholder="Enter Skype ID" value="{{ @$info['skype2']['value'] }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-body -->
                <form id="phone1Form">
                    <div class="box-header with-border">
                        <h3 class="box-title">Phone 1</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Phone 1</label>
                            <input type="text" name="info[phone1][label]" class="form-control" placeholder="Enter Phone 1" value="{{ @$info['phone1']['label'] }}">
                        </div>
                        <div class="form-group">
                            <label>Phone 1</label>
                            <input type="text" name="info[phone1][value]" class="form-control" placeholder="Enter Phone 1" value="{{ @$info['phone1']['value'] }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-body -->
                <form id="phone2Form">
                    <div class="box-header with-border">
                        <h3 class="box-title">Phone 2</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Phone 2</label>
                            <input type="text" name="info[phone2][label]" class="form-control" placeholder="Enter Phone 2" value="{{ @$info['phone2']['label'] }}">
                        </div>
                        <div class="form-group">
                            <label>Phone 2</label>
                            <input type="text" name="info[phone2][value]" class="form-control" placeholder="Enter Phone 2" value="{{ @$info['phone2']['value'] }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-body -->
                <form id="whatsapp1Form">
                    <div class="box-header with-border">
                        <h3 class="box-title">WhatsApp 1</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>WhatsApp 1</label>
                            <input type="text" name="info[whatsapp1][label]" class="form-control" placeholder="Enter WhatsApp Number" value="{{ @$info['whatsapp1']['label'] }}">
                        </div>
                        <div class="form-group">
                            <label>WhatsApp 1</label>
                            <input type="text" name="info[whatsapp1][value]" class="form-control" placeholder="Enter WhatsApp Number" value="{{ @$info['whatsapp1']['value'] }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-body -->
                <form id="whatsapp2Form">
                    <div class="box-header with-border">
                        <h3 class="box-title">WhatsApp 2</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>WhatsApp 2</label>
                            <input type="text" name="info[whatsapp2][label]" class="form-control" placeholder="Enter WhatsApp Number" value="{{ @$info['whatsapp2']['label'] }}">
                        </div>
                        <div class="form-group">
                            <label>WhatsApp 2</label>
                            <input type="text" name="info[whatsapp2][value]" class="form-control" placeholder="Enter WhatsApp Number" value="{{ @$info['whatsapp2']['value'] }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-body -->
                <form id="emailForm">
                    <div class="box-header with-border">
                        <h3 class="box-title">Email</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text" name="info[email][label]" class="form-control" placeholder="Enter Email" value="{{ @$info['email']['label'] }}">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="info[email][value]" class="form-control" placeholder="Enter Email" value="{{ @$info['email']['value'] }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="rolesModal"></div>
@stop

@push('js')
    <script>
        $('#skype1Form, #skype2Form, #phone1Form, #phone2Form, #whatsapp1Form, #whatsapp2Form, #emailForm').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: "{{ route('information.update') }}",
                data: $(this).serialize()+"&_token={{csrf_token()}}",
                type:"post",
                dataType:"json",
                success:function(r){
                    alert('Record Updated');
                }
            });
        })
    </script>
@endpush