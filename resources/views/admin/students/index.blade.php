@extends('adminlte::page')

@section('title', 'Students')

@section('css')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    /* keep popups visible — multiple Bootstrap versions clash on .fade opacity */
    .cursor-pointer { cursor: pointer !important; }
    .modal { z-index: 1050 !important; opacity: 1 !important; }

    /* ===================== Student table redesign ===================== */
    .students-box { border-top: 3px solid #3c8dbc; border-radius: 6px; overflow: visible; }

    .students-toolbar {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px; padding: 14px 16px; border-bottom: 1px solid #f0f2f3;
    }
    .students-toolbar h3 { margin: 0; font-size: 18px; font-weight: 600; color: #2c3e50; }
    .students-count {
        background: #3c8dbc; color: #fff; border-radius: 20px; padding: 2px 11px;
        font-size: 12px; font-weight: 600; margin-left: 6px;
    }
    .legend { font-size: 11px; color: #95a5a6; display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
    .legend span { display: inline-flex; align-items: center; gap: 4px; }

    .tb-group { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; }

    /* status filter (segmented) */
    .status-filter { display: inline-flex; border: 1px solid #dfe4e7; border-radius: 8px; overflow: hidden; }
    .status-filter .sf-btn {
        border: none; background: #fff; color: #5a6a72; font-size: 12px; font-weight: 600;
        padding: 5px 14px; cursor: pointer; transition: background .15s, color .15s; border-right: 1px solid #eef1f3;
    }
    .status-filter .sf-btn:last-child { border-right: none; }
    .status-filter .sf-btn:hover { background: #f3f6f8; }
    .status-filter .sf-btn.active { background: #3c8dbc; color: #fff; }

    /* bulk delete button */
    .btn-bulk-del {
        border: none; background: #dc3545; color: #fff; font-size: 13px; font-weight: 600;
        padding: 7px 16px; border-radius: 8px; cursor: pointer; transition: background .15s, box-shadow .15s;
    }
    .btn-bulk-del:hover:not(:disabled) { background: #c82333; box-shadow: 0 3px 8px rgba(220,53,69,.3); }
    .btn-bulk-del:disabled { background: #e7b9bd; cursor: not-allowed; }

    /* legend strip */
    .students-legend { padding: 8px 16px; border-bottom: 1px solid #f0f2f3; font-size: 11px; color: #95a5a6; display: flex; gap: 14px; flex-wrap: wrap; }
    .students-legend span { display: inline-flex; align-items: center; gap: 4px; }

    /* selection */
    .sel-col { width: 38px; text-align: center; }
    .row-check, #checkAll { width: 16px; height: 16px; cursor: pointer; vertical-align: middle; }
    #studentsTable tbody tr.selected-row { background: #fff7f7; }
    #studentsTable tbody tr.selected-row:hover { background: #fff0f0; }

    #studentsTable thead th {
        background: #f7f9fa; color: #7b8a8b; font-weight: 600; font-size: 11.5px;
        text-transform: uppercase; letter-spacing: .4px; border-bottom: 2px solid #ecf0f1;
        padding: 12px 10px; white-space: nowrap;
    }
    #studentsTable tbody td { vertical-align: middle; padding: 10px; border-bottom: 1px solid #f2f4f5; }
    #studentsTable tbody tr:hover { background: #f9fbfd; }

    /* identity */
    .stu-cell { display: flex; align-items: center; gap: 10px; }
    .stu-ava {
        width: 40px; height: 40px; border-radius: 50%; object-fit: cover; flex: 0 0 40px;
        display: inline-flex; align-items: center; justify-content: center; font-weight: 700;
        color: #fff; font-size: 15px; box-shadow: 0 1px 3px rgba(0,0,0,.18);
    }
    .stu-info { display: flex; flex-direction: column; line-height: 1.35; min-width: 0; }
    .stu-name { font-weight: 600; color: #2c3e50; font-size: 14px; }
    .stu-mail { font-size: 12px; color: #97a3a9; max-width: 220px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    /* scholar */
    .sch-cell { cursor: pointer; display: inline-flex; align-items: center; gap: 6px; }
    .sch-badge { background: #eaf3fb; color: #2c7fc0; border-radius: 14px; padding: 3px 11px; font-size: 12px; font-weight: 600; }
    .sch-none { color: #b0b8bf; font-size: 12px; }
    .sch-pen { opacity: 0; color: #95a5a6; font-size: 11px; transition: opacity .15s; }
    .sch-cell:hover .sch-pen { opacity: 1; }

    /* contact */
    .contact { color: #5a6a72; font-size: 13px; white-space: nowrap; }
    .contact i { color: #c3cace; margin-right: 3px; }
    .muted { color: #cfd6da; }

    /* status pill */
    .pill { display: inline-block; border-radius: 20px; padding: 3px 12px; font-size: 11px; font-weight: 700; white-space: nowrap; }
    .pill-on  { background: #e6f7ed; color: #1f9d57; }
    .pill-off { background: #fdeaea; color: #e04444; }

    /* dates */
    .dt-cell { display: flex; flex-direction: column; gap: 4px; }
    .dt-pill {
        cursor: pointer; font-size: 11px; border-radius: 5px; padding: 2px 8px; font-weight: 600;
        display: inline-flex; align-items: center; gap: 4px; transition: transform .1s; width: fit-content;
    }
    .dt-pill:hover { transform: translateX(2px); }
    .dt-in     { background: #eef4fb; color: #3a7bbf; }
    .dt-out    { background: #fdeeee; color: #d9534f; }
    .dt-active { background: #fff6e6; color: #e0962a; }

    /* icon button groups */
    .qa-group, .act-group { display: flex; gap: 5px; justify-content: center; flex-wrap: nowrap; }
    .qa-btn, .act-btn {
        width: 30px; height: 30px; border-radius: 7px; display: inline-flex; align-items: center;
        justify-content: center; font-size: 13px; border: none; cursor: pointer; color: #fff;
        text-decoration: none; transition: transform .15s, box-shadow .15s;
    }
    .qa-btn:hover, .act-btn:hover { transform: translateY(-2px); box-shadow: 0 3px 8px rgba(0,0,0,.18); color: #fff; }

    .qa-admission { background: #17a2b8; }
    .qa-fee       { background: #28a745; }
    .qa-courses   { background: #6f42c1; }
    .qa-lessons   { background: #fd7e14; }
    .qa-empty     { background: #e1e6e9; color: #aab2b7 !important; cursor: not-allowed; }
    .qa-empty:hover { transform: none; box-shadow: none; }

    .act-btn      { background: #8795a1; }
    .act-verify   { background: #28a745; }
    .act-disable  { background: #f0ad4e; }
    .act-delete   { background: #dc3545; }

    /* DataTables chrome */
    .dataTables_wrapper .dataTables_filter input { border-radius: 20px; border: 1px solid #e0e6e8; padding: 5px 14px; outline: none; }
    .dataTables_wrapper .dataTables_filter input:focus { border-color: #3c8dbc; }
    .dataTables_wrapper .dataTables_length select { border-radius: 6px; padding: 3px 6px; }

    @media (max-width: 768px) {
        .stu-mail { max-width: 130px; }
        .legend { display: none; }
    }
</style>
@stop

@section('content_header')
    <h1>Student List</h1>
@stop

@section('content')

{{-- ========================= MODALS ========================= --}}

<!-- Update Dates Modal -->
<div class="modal fade" id="updateDatesModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Student Dates</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateDatesForm">
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="date_student_id">
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" class="form-control" id="date_student_name" readonly>
                    </div>
                    <div class="form-group">
                        <label for="created_at">Join Date (In)</label>
                        <input type="date" class="form-control" name="created_at" id="created_at" required>
                    </div>
                    <div class="form-group">
                        <label for="leave_date">Leave Date (Out)</label>
                        <input type="date" class="form-control" name="leave_date" id="leave_date">
                        <small class="text-muted">Leave empty if student is still active</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Dates</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Scholar Assignment Modal -->
<div class="modal fade" id="assignScholarModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Assign Scholar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="assignScholarForm">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" id="student_name" readonly>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" id="student_email" readonly>
                    </div>
                    <div class="form-group">
                        <label for="scholar">Assign Scholar</label>
                        <select class="form-control" name="scholar" id="scholar">
                            <option value="">Select Scholar</option>
                            @foreach($scholars as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                     <button type="button" class="btn btn-danger pull-left" id="removeScholarBtn" style="margin-right:auto;">
                        <i class="fa fa-user-times"></i> Remove Scholar
                    </button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Student Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="changePasswordForm">
                <div class="modal-body">
                    <input type="hidden" name="student_id" id="student_id">
                    <div class="form-group">
                        <label>Student Name</label>
                        <input type="text" class="form-control" id="student_name_display" readonly>
                    </div>
                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" class="form-control" name="new_password" id="new_password" required>
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" name="new_password_confirmation" id="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button id="change-password" type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Feedback Modal -->
<div class="modal fade" id="feedbackModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Student Feedback</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Student Name:</strong> <span id="studentName"></span></p>
                <p><strong>Feedback Title:</strong> <span id="feedbackTitle"></span></p>
                <p><strong>Feedback Message:</strong></p>
                <p id="feedbackMessage"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- ========================= TABLE ========================= --}}
<div class="box students-box">
    <div class="students-toolbar">
        <div class="tb-group">
            <h3>Students <span class="students-count" id="stuCount">0</span></h3>
            <div class="status-filter" role="group" aria-label="Filter by status">
                <button type="button" class="sf-btn active" data-val="">All</button>
                <button type="button" class="sf-btn" data-val="verified">Verified</button>
                <button type="button" class="sf-btn" data-val="not_verified">Not Verified</button>
            </div>
        </div>
        <div class="tb-group">
            <button id="deleteSelected" class="btn-bulk-del" disabled>
                <i class="fa fa-trash"></i> Delete Selected (<span id="selCount">0</span>)
            </button>
        </div>
    </div>
    <div class="students-legend">
        <span><i class="fa fa-id-card-o" style="color:#17a2b8"></i> Admission</span>
        <span><i class="fa fa-money" style="color:#28a745"></i> Fee</span>
        <span><i class="fa fa-sliders" style="color:#6f42c1"></i> Courses</span>
        <span><i class="fa fa-book" style="color:#fd7e14"></i> Lessons</span>
    </div>
    <div class="box-body table-responsive">
        <table id="studentsTable" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th class="sel-col"><input type="checkbox" id="checkAll" title="Select all on this page"></th>
                    <th>Student</th>
                    <th>Email</th>
                    <th>Scholar</th>
                    <th>Contact</th>
                    <th>Status</th>
                    <th>Enrollment</th>
                    <th class="text-center">Quick Access</th>
                    <th class="text-center">Manage</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div class="rolesModal"></div>
@stop

@push('js')
<script>
    /* ---- route templates (placeholders replaced per row) ---- */
    var URL_ADMISSION = "{{ route('admin.admission.show', '__AID__') }}";
    var URL_FEE       = "{{ route('admin.fees.manage', '__ID__') }}";
    var URL_COURSES   = "{{ route('admin.lessons.courses', '__ID__') }}";
    var URL_LESSONS   = "{{ route('admin.lessons.entry', '__ID__') }}";
    var URL_FEEDBACK  = "{{ route('admin.feedback.show', '__ID__') }}";
    var URL_LINKS     = "{{ route('admin.student.addLinks', '__ID__') }}";
    var STORAGE       = "{{ asset('storage') }}";

    /* ---- small helpers ---- */
    function avatarColor(str) {
        var colors = ['#6c5ce7','#0984e3','#00b894','#e17055','#d63031','#e84393','#e1a72a','#00b8a9','#636e72','#2d8cf0'];
        var h = 0, s = str || '';
        for (var i = 0; i < s.length; i++) { h = s.charCodeAt(i) + ((h << 5) - h); }
        return colors[Math.abs(h) % colors.length];
    }
    function initials(str) {
        if (!str) return '?';
        var p = String(str).trim().split(/\s+/);
        return (p[0].charAt(0) + (p[1] ? p[1].charAt(0) : '')).toUpperCase();
    }
    function fmtDate(d) {
        if (!d || d === 'null' || d === '') return null;
        var dt = new Date(d);
        if (isNaN(dt.getTime())) return null;
        var y = dt.getFullYear(), m = String(dt.getMonth() + 1).padStart(2, '0'), da = String(dt.getDate()).padStart(2, '0');
        return y + '-' + m + '-' + da;
    }

    /* ---- column renderers ---- */
    function studentCell(name, type, row) {
        if (type !== 'display') return name;
        var avatar = row.admission_pic
            ? '<img src="' + STORAGE + '/' + row.admission_pic + '" class="stu-ava" alt="">'
            : '<span class="stu-ava" style="background:' + avatarColor(name) + '">' + initials(name) + '</span>';
        return '<div class="stu-cell">' + avatar +
               '<div class="stu-info"><span class="stu-name">' + (name || '') + '</span>' +
               '<span class="stu-mail" title="' + (row.email || '') + '">' + (row.email || '') + '</span></div></div>';
    }
    function scholarCell(d, type, row) {
        if (type !== 'display') return d;
        var inner = (!d || d === 'No Scholar')
            ? '<span class="sch-none"><i class="fa fa-user-o"></i> No Scholar</span>'
            : '<span class="sch-badge">' + d + '</span>';
        return '<span class="sch-cell assign-scholar" data-id="' + row.id + '" title="Assign / change scholar">' +
               inner + ' <i class="fa fa-pencil sch-pen"></i></span>';
    }
    function contactCell(d, type) {
        if (type !== 'display') return d;
        return d ? '<span class="contact"><i class="fa fa-phone"></i> ' + d + '</span>' : '<span class="muted">—</span>';
    }
    function statusCell(d, type) {
        if (type !== 'display') return d;
        return (d == 0) ? '<span class="pill pill-off">Not Verified</span>' : '<span class="pill pill-on">Verified</span>';
    }
    function enrollmentCell(d, type, row) {
        if (type !== 'display') return d;
        var inD = fmtDate(d) || '—';
        var out = fmtDate(row.leave_date);
        var attrs = 'data-id="' + row.id + '" data-name="' + (row.name || '') + '" data-in="' + (d || '') + '" data-out="' + (row.leave_date || '') + '"';
        var inPill = '<span class="edit-dates dt-pill dt-in" ' + attrs + ' title="Edit dates"><i class="fa fa-sign-in"></i> ' + inD + '</span>';
        var outPill = out
            ? '<span class="edit-dates dt-pill dt-out" ' + attrs + ' title="Edit dates"><i class="fa fa-sign-out"></i> ' + out + '</span>'
            : '<span class="edit-dates dt-pill dt-active" ' + attrs + ' title="Still active — click to set leave date">Active</span>';
        return '<div class="dt-cell">' + inPill + outPill + '</div>';
    }
    function quickAccessCell(id, type, row) {
        if (type !== 'display') return id;
        var adm = row.admission_form_id
            ? '<a href="' + URL_ADMISSION.replace('__AID__', row.admission_form_id) + '" class="qa-btn qa-admission" title="Admission form"><i class="fa fa-id-card-o"></i></a>'
            : '<span class="qa-btn qa-empty" title="Admission form not filled yet"><i class="fa fa-id-card-o"></i></span>';
        return '<div class="qa-group">' + adm +
               '<a href="' + URL_FEE.replace('__ID__', id) + '" class="qa-btn qa-fee" title="Fee records"><i class="fa fa-money"></i></a>' +
               '<a href="' + URL_COURSES.replace('__ID__', id) + '" class="qa-btn qa-courses" title="Courses & permissions"><i class="fa fa-sliders"></i></a>' +
               '<a href="' + URL_LESSONS.replace('__ID__', id) + '" class="qa-btn qa-lessons" title="Lessons"><i class="fa fa-book"></i></a></div>';
    }
    function manageCell(id, type, row) {
        if (type !== 'display') return id;
        var vd = (row.is_verified == 0)
            ? '<button class="act-btn act-verify verify_student" data-id="' + id + '" title="Verify student"><i class="fa fa-check"></i></button>'
            : '<button class="act-btn act-disable unverify_student" data-id="' + id + '" title="Disable student"><i class="fa fa-ban"></i></button>';
        return '<div class="act-group">' +
               '<button class="act-btn change-password" data-id="' + id + '" title="Change password"><i class="fa fa-key"></i></button>' +
            //    '<button class="act-btn add-links" data-id="' + id + '" title="Add class links"><i class="fa fa-link"></i></button>' +
               '<button class="act-btn show-feedback" data-id="' + id + '" title="Show feedback"><i class="fa fa-comments"></i></button>' +
               vd +
               '<button class="act-btn act-delete delete" data-id="' + id + '" title="Delete student"><i class="fa fa-trash"></i></button></div>';
    }

    /* ---- DataTable ---- */
    var currentStatus = '';          // status filter value
    var selectedIds   = new Set();   // bulk-delete selection (persists across pages)

    var datatable = $('#studentsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('admin.student') }}',
            data: function (d) { d.status_filter = currentStatus; }
        },
        order: [[1, 'asc']],
        columns: [
            { data: 'id',          orderable: false, searchable: false, className: 'sel-col',
              render: function (id) { return '<input type="checkbox" class="row-check" value="' + id + '">'; } },
            { data: 'name',        orderable: true,  searchable: true,  render: studentCell },
            { data: 'email',       visible: false,   searchable: true,  orderable: false },
            { data: 'scholar',     orderable: false, searchable: false, render: scholarCell },
            { data: 'contact_no',  orderable: true,  searchable: true,  render: contactCell },
            { data: 'is_verified', orderable: true,  searchable: false, render: statusCell },
            { data: 'created_at',  orderable: true,  searchable: false, render: enrollmentCell },
            { data: 'id',          orderable: false, searchable: false, className: 'text-center', render: quickAccessCell },
            { data: 'id',          orderable: false, searchable: false, className: 'text-center', render: manageCell }
        ],
        drawCallback: function () {
            $('#stuCount').text(this.api().page.info().recordsTotal);
            // re-apply selection state after every redraw (pagination/search/sort)
            $('#studentsTable tbody .row-check').each(function () {
                var on = selectedIds.has(String(this.value));
                $(this).prop('checked', on);
                $(this).closest('tr').toggleClass('selected-row', on);
            });
            updateCheckAllState();
            updateBulkButton();
        }
    });

    /* ---- status filter ---- */
    $(document).on('click', '.sf-btn', function () {
        $('.sf-btn').removeClass('active');
        $(this).addClass('active');
        currentStatus = $(this).data('val') || '';
        datatable.ajax.reload();
    });

    /* ---- multiple delete: selection ---- */
    $(document).on('change', '.row-check', function () {
        var id = String(this.value);
        if (this.checked) { selectedIds.add(id); } else { selectedIds.delete(id); }
        $(this).closest('tr').toggleClass('selected-row', this.checked);
        updateCheckAllState();
        updateBulkButton();
    });

    $(document).on('change', '#checkAll', function () {
        var on = this.checked;
        $('#studentsTable tbody .row-check').each(function () {
            this.checked = on;
            var id = String(this.value);
            if (on) { selectedIds.add(id); } else { selectedIds.delete(id); }
            $(this).closest('tr').toggleClass('selected-row', on);
        });
        updateBulkButton();
    });

    function updateCheckAllState() {
        var boxes = $('#studentsTable tbody .row-check');
        $('#checkAll').prop('checked', boxes.length > 0 && boxes.filter(':checked').length === boxes.length);
    }
    function updateBulkButton() {
        var n = selectedIds.size;
        $('#selCount').text(n);
        $('#deleteSelected').prop('disabled', n === 0);
    }

    /* ---- multiple delete: action ---- */
    $(document).on('click', '#deleteSelected', function () {
        if (selectedIds.size === 0) return;
        var ids = Array.from(selectedIds);
        Swal.fire({
            title: 'Delete ' + ids.length + ' student' + (ids.length > 1 ? 's' : '') + '?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete them!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: "{{ url('admin/student/bulk-delete') }}",
                    method: 'POST',
                    data: { ids: ids },
                    success: function (response) {
                        selectedIds.clear();
                        Swal.fire('Deleted!', (response && response.success) || 'Selected students deleted.', 'success');
                        datatable.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Swal.fire('Error!', (xhr.responseJSON && xhr.responseJSON.error) || 'Delete failed.', 'error');
                    }
                });
            }
        });
    });

    /* ---- edit dates (delegated) ---- */
    $(document).on('click', '.edit-dates', function () {
        editDates($(this).data('id'), $(this).data('name'), String($(this).data('in')), String($(this).data('out')));
    });

    function editDates(studentId, studentName, createdAt, leaveDate) {
        $('#date_student_id').val(studentId);
        $('#date_student_name').val(studentName);

        if (createdAt) {
            var c = new Date(createdAt);
            if (!isNaN(c.getTime())) {
                $('#created_at').val(c.getFullYear() + '-' + String(c.getMonth() + 1).padStart(2, '0') + '-' + String(c.getDate()).padStart(2, '0'));
            }
        }
        if (leaveDate && leaveDate !== 'null' && leaveDate !== '') {
            var l = new Date(leaveDate);
            if (!isNaN(l.getTime())) {
                $('#leave_date').val(l.getFullYear() + '-' + String(l.getMonth() + 1).padStart(2, '0') + '-' + String(l.getDate()).padStart(2, '0'));
            }
        } else {
            $('#leave_date').val('');
        }
        $('#updateDatesModal').modal('show');
    }

    $('#updateDatesForm').on('submit', function (e) {
        e.preventDefault();
        var studentId = $('#date_student_id').val();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/admin/student/' + studentId + '/update-dates',
            method: 'POST',
            data: { created_at: $('#created_at').val(), leave_date: $('#leave_date').val() },
            success: function (response) {
                $('#updateDatesModal').modal('hide');
                Swal.fire('Success!', response.success || 'Dates updated successfully!', 'success');
                datatable.ajax.reload(null, false);
            },
            error: function (xhr) {
                Swal.fire('Error!', (xhr.responseJSON && xhr.responseJSON.error) || 'Error occurred', 'error');
            }
        });
    });

    /* ---- change password ---- */
    $(document).on('click', '.change-password', function () {
        var studentId = $(this).data('id');
        $.ajax({
            url: '/admin/student/' + studentId,
            method: 'GET',
            success: function (data) {
                $('#student_id').val(data.id);
                $('#student_name_display').val(data.name);
                $('#new_password').val('');
                $('#new_password_confirmation').val('');
                $('#changePasswordModal').modal('show');
            }
        });
    });

    $('#changePasswordForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '{{ route('admin.student.changePassword') }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#changePasswordModal').modal('hide');
                Swal.fire('Success!', response.success, 'success');
                datatable.ajax.reload(null, false);
            },
            error: function (xhr) {
                Swal.fire('Error!', (xhr.responseJSON && xhr.responseJSON.error) || 'Error occurred', 'error');
            }
        });
    });

    /* ---- delete ---- */
    $(document).on('click', '.delete', function () {
        var id = $(this).attr('data-id');
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.student.destroy') }}",
                    data: 'id=' + id + "&_token={{ csrf_token() }}&parent=1",
                    type: "post",
                    success: function () {
                        Swal.fire('Deleted!', 'The student has been deleted.', 'success');
                        datatable.ajax.reload(null, false);
                    }
                });
            }
        });
    });

    /* ---- verify ---- */
    $(document).on('click', '.verify_student', function () {
        var sid = $(this).attr('data-id');
        $.ajax({
            url: "{{ url('admin/check-student-status') }}/" + sid,
            type: "GET",
            success: function (response) {
                if (response.is_verified) {
                    Swal.fire('Error!', 'This student is already verified!', 'error');
                } else {
                    Swal.fire({
                        title: 'Are you sure to verify student?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, verify it!'
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('admin/verify/student') }}/" + sid,
                                type: "GET",
                                success: function (response) {
                                    Swal.fire('Success!', response.success, 'success');
                                    datatable.ajax.reload(null, false);
                                },
                                error: function (xhr) {
                                    Swal.fire('Error!', (xhr.responseJSON && xhr.responseJSON.error) || 'Something went wrong!', 'error');
                                }
                            });
                        }
                    });
                }
            },
            error: function (xhr) {
                Swal.fire('Error!', (xhr.responseJSON && xhr.responseJSON.error) || 'Something went wrong!', 'error');
            }
        });
    });

    /* ---- disable ---- */
    $(document).on('click', '.unverify_student', function () {
        var sid = $(this).attr('data-id');
        $.ajax({
            url: "{{ url('admin/check-student-disable') }}/" + sid,
            type: "GET",
            success: function (response) {
                if (response.is_verified) {
                    Swal.fire('Error!', 'This student is already disabled!', 'error');
                } else {
                    Swal.fire({
                        title: 'Are you sure to disable student?',
                        text: "This action cannot be undone!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, disable it!'
                    }).then(function (result) {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ url('admin/disable/student') }}/" + sid,
                                type: "GET",
                                success: function (response) {
                                    Swal.fire('Success!', response.success, 'success');
                                    datatable.ajax.reload(null, false);
                                },
                                error: function (xhr) {
                                    Swal.fire('Error!', (xhr.responseJSON && xhr.responseJSON.error) || 'Something went wrong!', 'error');
                                }
                            });
                        }
                    });
                }
            },
            error: function (xhr) {
                Swal.fire('Error!', (xhr.responseJSON && xhr.responseJSON.error) || 'Something went wrong!', 'error');
            }
        });
    });

    /* ---- feedback (navigate) ---- */
    $(document).on('click', '.show-feedback', function () {
        window.location.href = URL_FEEDBACK.replace('__ID__', $(this).data('id'));
    });

    /* ---- add links (navigate) ---- */
    $(document).on('click', '.add-links', function () {
        window.location.href = URL_LINKS.replace('__ID__', $(this).data('id'));
    });

    /* ---- assign scholar ---- */
    $(document).on('click', '.assign-scholar', function () {
        var studentId = $(this).data('id');
        $.ajax({
            url: '/admin/student/' + studentId,
            method: 'GET',
            success: function (data) {
                $('#id').val(data.id);
                $('#student_name').val(data.name);
                $('#student_email').val(data.email);
                $('#scholar').val(data.scholar || '');
                $('#removeScholarBtn').toggle(!!data.scholar);
                $('#assignScholarModal').modal('show');
            }
        });
    });

    $('#assignScholarForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '{{ route('admin.student.assign-scholar') }}',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                $('#assignScholarModal').modal('hide');
                Swal.fire('Success!', response.success, 'success');
                datatable.ajax.reload(null, false);
            },
            error: function () {
                Swal.fire('Error!', 'An error occurred while assigning the scholar.', 'error');
            }
        });
    });

    /* ---- remove scholar ---- */
    $(document).on('click', '#removeScholarBtn', function () {
        var studentId = $('#id').val();
        if (!studentId) return;

        Swal.fire({
            title: 'Remove assigned scholar?',
            text: "This student will have no scholar.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, remove it!'
        }).then(function (result) {
            if (result.isConfirmed) {
                $.ajax({
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    url: '{{ route('admin.student.remove-scholar') }}',
                    method: 'POST',
                    data: { id: studentId },
                    success: function (response) {
                        $('#assignScholarModal').modal('hide');
                        Swal.fire('Removed!', response.success, 'success');
                        datatable.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        Swal.fire('Error!', (xhr.responseJSON && xhr.responseJSON.error) || 'An error occurred.', 'error');
                    }
                });
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush