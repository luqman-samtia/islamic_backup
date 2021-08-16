@extends('adminlte::page')

@section('title', 'Payment Methods')

@section('content_header')
    <h1>
        Payment Methods
        <a href="{{ route('payments.add') }}" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Payment Method</a>
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">
                <div class="box-body table-responsive">
                    <table class="table table-hover table-striped table-bordered">
                        <thead>
                        <tr>
                            <td>Title</td>
                            <td>Description</td>
                            <td>Action</td>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
        </div>
    </div>
    <div class="rolesModal"></div>
@stop

@push('js')
    <script>
        // $(function() {
            var datatable = $('.table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!! route('payments') !!}',
                columns: [
                    { data: 'title' },
                    { data: 'description' },
                    {
                        data: 'id',
                        render: function(data){
                            let edit = '{{ route('payments.edit', ':id') }}';
                            edit = edit.replace(':id', data);
                            let deletePayments = '{{ route('payments.delete', ':id') }}';
                            deletePayments = deletePayments.replace(':id', data);
                            return '<a href="'+edit+'" class="btn btn-success btn-xs"><i class="fa fa-pencil"></i></a> ' +
                                '<button type="button" data-id="'+data+'" class="btn btn-danger btn-xs delete"><i class="fa fa-trash-o"></i></button> ';
                        }
                    },
                ],
                order: [[2, 'asc']]
            });
        // });
        $(document).on('click', '.delete', function(){
            let id = $(this).attr('data-id');
            $.ajax({
                url : "{{ route('payments.delete') }}",
                data: 'id='+id+"&_token={{ csrf_token() }}",
                type:"post",
                success: function(output){
                    datatable.ajax.reload();
                }
            });
        })
    </script>
    @endpush
