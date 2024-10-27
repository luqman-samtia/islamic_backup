@extends('adminlte::page')


@section('title', 'Student')

@section('content_header')
<!-- Add SweetAlert CSS and JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    <h1>
        Student Info
        {{-- <a href="" class="btn btn-sm btn-success pull-right"><i class="fa fa-plus"></i> New Scholars</a> --}}
    </h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-8 col-sm-12 col-lg-8">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-lg-4">
                    @if(!empty($studentData->title))
                    <div class="wdgt-box">
                      
                        <ul style=" display:flex;text-align:centr;justify-content:space-around;flex-direction:row;">        
                       
                                @foreach($studentData as $item)
                                <li  style="list-style: none;">
                                    <a style="list-style: none;background:green;margin-left:5px;" href="{{ $item['link'] }}" class="badge badge-success" target="_blank">{{ $item['title'] }}</a>
                                </li>
                                @endforeach
                               
                            </ul>
                    </div>
                    @else
                    <div>
                        <p>  No dynamic student data available.</p>
                    </div>
                  
                    @endif
                </div>
    </div>
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
                ajax: '{{ route('admin.student') }}',
                columns: [
                    { data: 'name' },
                    { data: 'email' },
                    { 
                        data: 'is_verified' ,
                        render:function(data){
                            if(data==0){
                            return '<span class="badge" style="background:red;">Not Verified</span>';
                        }
                        else{
                            return '<span class="badge" style="background:green;">Verified</span>';
                        }
                        }
                        

                    },
                    { 
                        data: 'created_at',
                        render: function(data, type, row) {
                            // Format the date using JavaScript's Date object
                            let date = new Date(data);
                            let day = date.getDate().toString().padStart(2, '0');
                            let month = (date.getMonth() + 1).toString().padStart(2, '0'); // Months are zero-indexed
                            let year = date.getFullYear();
                            
                            // Return only the date in DD-MM-YYYY format
                            return `${day}-${month}-${year}`;
                        }
                     },
                    {
                        data: 'id',
                        render: function(data) {
                            let deleteStudent = '{{ route('admin.student.destroy', ':id') }}';
                            deleteStudent = deleteStudent.replace(':id', data);
                            
                            return `
                    <button type="button" data-id="${data}" class="btn btn-danger btn-xs delete">
                        <i class="fa fa-trash-o"></i>
                    </button>
                    <button type="button" data-id="${data}" class="btn btn-primary btn-xs add-links">
                        <i class="fa fa-link"></i> Add Links
                    </button>
                `;
                        }
                    }
                ]
              
            });
      

        $(document).on('click', '.delete', function(){
    let id = $(this).attr('data-id');
    
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url : "{{ route('admin.student.destroy') }}",
                data: 'id='+id+"&_token={{ csrf_token() }}&parent=1",
                type: "post",
                success: function(output){
                    Swal.fire(
                        'Deleted!',
                        'The scholar has been deleted.',
                        'success'
                    );
                    datatable.ajax.reload();
                }
            });
        }
    });
});
$('.table').on('click', '.add-links', function() {
    // let studentId = $(this).data('id');
    let studentId = $(this).data('id'); // Get the student ID from the button
    // $('#dynamicStudentForm')[0].reset(); // Clear any previous data in the form
    // $('#dynamicStudentContainer').empty(); // Clear previous fields from container

    // // Set a hidden input with student ID for submission
    // $('#dynamicStudentContainer').append(`<input type="hidden" name="student_id" value="${studentId}">`);
    // Redirect to the add links page with studentId as a parameter
    window.location.href = '{{ route('admin.student.addLinks', ':id') }}'.replace(':id', studentId);
});
    </script>
    @endpush