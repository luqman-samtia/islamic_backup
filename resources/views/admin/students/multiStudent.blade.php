@extends('adminlte::page')

@section('title', 'Footer Information')

@section('content_header')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

    <h1>
        Add Student Information
    </h1>
@stop

@section('content')
    <div class="row">
      
        
       


        {{-- Dynamic Fileds for Footer --}}
        {{-- <div class="container"> --}}
            

            <hr> <!-- Separator between forms -->
          
            <!-- Student Form -->
            <form id="dynamicStudentForm" method="POST" action="{{ route('admin.student.update') }}" class="container-fluid">
                @csrf
                <div id="dynamicStudentContainer" class="row">
                    <!-- Dynamic student items will be added here -->
                   
                    
                    {{-- @if(!empty($info->student_items  )) --}}
                        @foreach($info as $index => $item)
                            <div class="col-md-4 student-item-container" style="">
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <input type="hidden" name="student_items[{{$index}}][type]" value="Student" class="form-control">
                                        <input type="hidden" name="student_id" value="{{$student_id}}" class="form-control">

                                        <h3 class="box-title">Student</h3>
                                    </div>
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input type="text" id="titleField" name="student_items[{{$index}}][title]" value="{{ $item['title'] }}" class="form-control" placeholder="Enter Title">
                                        </div>
                                        <div class="form-group">
                                            <label>Link</label>
                                            <input type="text" id="linkField" name="student_items[{{$index}}][link]" value="{{ $item['link'] }}" class="form-control" placeholder="Enter Link">
                                        </div>
                                        
                                    </div>
                                    <div class="box-footer">
                                        <button type="button" data-id="{{ $item->id }}" class="btn btn-danger remove-student-item">Remove</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    {{-- @endif --}}
                   
                </div>
                <div class="box-footer text-center">
                    <button type="button" id="addStudentItem" class="btn btn-info">Add Student Item</button>
                    <button type="submit" class="btn btn-success">Submit Students</button>
                </div>
            </form>
        {{-- </div> --}}
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
       
                //  COde for Students 
                let studentIndex = {{ !empty($info) ? count($info) : 0 }};
                var studentId = "{{ $student_id }}";
// Add new student item
$('#addStudentItem').click(function () {
    const newStudentItemContainer = `
        <div class="col-md-4 student-item-container">
            <div class="box box-info">
                <div class="box-header with-border">
                    <input type="hidden" name="student_items[${studentIndex}][type]" value="Student" class="form-control">
                    <input type="hidden" name="student_id" value="${studentId}" class="form-control">

                    <h3 class="box-title">Student</h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label>Title</label>
                        <input type="text" id="titleField" name="student_items[${studentIndex}][title]" class="form-control" placeholder="Enter Title">
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" id="linkField" name="student_items[${studentIndex}][link]" class="form-control" placeholder="Enter Link">
                    </div>
                    
                </div>
                <div class="box-footer">
                    <button type="button" data-id="${studentIndex}" class="btn btn-danger remove-student-item">Remove</button>
                </div>
            </div>
        </div>`;
    
    $('#dynamicStudentContainer').append(newStudentItemContainer);
    studentIndex++;
});
// Ajax student item
$('#dynamicStudentForm').submit(function (e) {
    e.preventDefault();
    
    let hasError = false;
    
    // Loop through each dynamically added footer item to validate
    $('#dynamicStudentContainer .student-item-container').each(function () {
        const title = $(this).find('#titleField').val();
        const link = $(this).find('#linkField').val();
        
        if (!title || !link) {
            Swal.fire(
                'Error!',
                'Title and link fields cannot be empty.',
                'error'
            );
            hasError = true;
            return false; // Break out of each loop if validation fails
        }
    });
    
    // If there was a validation error, stop the submission
    if (hasError) return;

    // Use FormData to handle the submission
    const formData = new FormData(this);

    $.ajax({
        url: "{{ route('admin.student.update') }}",
        type: "POST",
        data: formData,
        contentType: false, // Important: Required when using FormData
        processData: false, // Important: Required when using FormData
        success: function(response) {
            Swal.fire(
                'Success!',
                'The Student information has been updated.',
                'success'
            );
        },
        error: function(xhr) {
            Swal.fire(
                'Error!',
                'An error occurred: ' + xhr.responseText,
                'error'
            );
        }
    });
});



    // Remove Student
    // Add event listener to remove button
//     $(document).on('click', '.remove-student-item', function() {
//     // Get the parent container of the remove button
//     var parentContainer = $(this).closest('.student-item-container');
//     var studentId = $(this).data('id');
//     // Get the index of the parent container
//     var currentIndex = parentContainer.index();
    
//     // Make an AJAX request to remove the item from the array column
//     $.ajax({
//         type: 'POST',
//         url: '/admin/student/remove-student-item/' + studentId, // URL of the PHP script that handles the removal
//         data: { index: currentIndex },
//         headers: {
//         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     },
//         success: function(response) {
//             // Remove the parent container from the DOM
//             parentContainer.remove();
            
//             // Decrement the index
//             index--;
//         }
//     });
// });
// $(document).on('click', '.remove-student-item', function() {
//     var itemId = $(this).data('id'); // This should hold the ID of the student item
//     var parentContainer = $(this).closest('.student-item-container');
//     $.ajax({
//         type: 'POST',
//         url: '/admin/student/remove-student-item',
//         data: {
//             item_id: itemId,
//         },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(response) {
//             if (response.success) {
//                 Swal.fire(
//                 'Success!',
//                 'The footer information has been updated.',
//                 'success'
//             );
//                 // Optionally remove the item from the DOM
                
//                 // $(this).closest('.student-item-container').remove();
//                 parentContainer.remove();
//             }
//         },
//         error: function(xhr) {
//             alert(xhr.responseJSON.message);
//         }
//     });
// });

$(document).on('click', '.remove-student-item', function() {
    var itemId = $(this).data('id'); // This should hold the ID of the student item
    var parentContainer = $(this).closest('.student-item-container');
    $.ajax({
        type: 'POST',
        url: '/admin/student/remove-student-item',
        data: {
            item_id: itemId,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            // Remove the item from the DOM regardless of response
            parentContainer.remove();
            Swal.fire(
                'Success!',
                'The Student has been deleted.',
                'success'
            );
        },
        error: function(xhr) {
            alert(xhr.responseJSON.message);
        }
    });
});

    </script>
@endpush