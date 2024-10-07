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
        <div class="col-md-4">
            <div class="box box-primary">
                <!-- /.box-body -->
                <form id="youtubeForm">
                    <div class="box-header with-border">
                        <h3 class="box-title">Youtube</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Youtube</label>
                            <input type="text" name="info[youtube][label]" class="form-control" placeholder="Enter Youtube" value="{{ @$info['youtube']['label'] }}">
                        </div>
                        <div class="form-group">
                            <label>Youtube</label>
                            <input type="text" name="info[youtube][value]" class="form-control" placeholder="Enter Youtube" value="{{ @$info['youtube']['value'] }}">
                        </div>
                    </div>
                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <!-- /.box -->
        </div>


        {{-- Dynamic Fileds for Footer --}}
        <div class="container">
            <form id="dynamicFooterForm" method="POST" action="{{route('information.update')}}">
                @csrf <!-- CSRF token for security -->
                <div id="dynamicFooterContainer" class="row">
                    @if(!empty($info->dynamic_footer_items))
                        @foreach($info->dynamic_footer_items as $index => $item)
                            <div class="col-md-4 footer-item-container" style="width:32% !important;">
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <input type="text" name="dynamic_footer_items[{{ $index }}][type]" value="{{ $item['type'] }}" class="form-control" placeholder="Enter Type">
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" name="dynamic_footer_items[{{ $index }}][title]" value="{{ $item['title'] }}" class="form-control" placeholder="Enter Title">
                                        </div>
                                        <div class="form-group">
                                            <label>Link</label>
                                            <input type="text" name="dynamic_footer_items[{{ $index }}][link]" value="{{ $item['link'] }}" class="form-control" placeholder="Enter Link">
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <button type="button" class="btn btn-danger remove-footer-item">Remove</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="box-footer" style="width:50%;margin:0px auto;text-align:center;">
                    <button type="button" id="addFooterItem" class="btn btn-secondary">Add Footer Item</button>
                    <button type="submit" class="btn btn-primary">Update All</button>
                </div>
            </form>
        </div>
        {{-- end box         --}}
        
    </div>
         {{-- Model Box --}}
         <!-- Bootstrap Modal --> 
        <!-- Modal Structure -->
        <div class="modal fade" id="updateSuccessModal" tabindex="-1" role="dialog" aria-labelledby="updateSuccessLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content animate__animated animate__fadeIn"> <!-- Add animate classes -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateSuccessLabel">Success</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Record updated successfully!
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
 {{-- end Model Box --}}

    <div class="rolesModal"></div>
@stop

@push('js')
    <script>
        $('#skype1Form, #skype2Form, #phone1Form, #phone2Form, #whatsapp1Form, #whatsapp2Form, #emailForm, #youtubeForm').submit(function (e) {
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


        // add Dynamic code

        let index = {{ !empty($info->dynamic_footer_items) ? count($info->dynamic_footer_items) : 0 }};

$('#addFooterItem').click(function () {
    // Create a new footer item container
    const newFooterItemContainer = `

        <div class="col-md-4 footer-item-container custom-col" style="width:31% !important;">
            <div class="box box-primary custom-box">
                <div class="box-header with-border">
                    <input type="text" name="dynamic_footer_items[${index}][type]" class="form-control" placeholder="Enter Type">
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" name="dynamic_footer_items[${index}][title]" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="dynamic_footer_items[${index}][link]" class="form-control" placeholder="Enter Link">
                    </div>
                </div>
                <div class="box-footer">
                    <button type="button" class="btn btn-danger remove-footer-item">Remove</button>
                </div>
            </div>
        </div>
        
    `;
    
    // Append the new container to dynamicFooterContainer
    $('#dynamicFooterContainer').append(newFooterItemContainer);
    index++;
});

// Remove dynamic footer item container
$(document).on('click', '.remove-footer-item', function () {
    $(this).closest('.footer-item-container').remove();
});

$('#dynamicFooterForm').submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "{{ route('information.update') }}",
        type: "POST",
        data: $(this).serialize(), // Serializes the form's elements
        success: function(response) {
            // alert('Update successful!');
            $('#updateSuccessModal').modal('show');
        },
        error: function(xhr) {
            alert('An error occurred: ' + xhr.responseText);
        }
    });
});
    </script>
@endpush