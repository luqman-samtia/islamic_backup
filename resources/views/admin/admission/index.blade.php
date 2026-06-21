@extends('adminlte::page')

@section('title', 'Admission Forms')

@section('content_header')
@stop

@section('content')
<div class="adm-list">

    {{-- ============ HEADER ============ --}}
    <div class="adm-head">
        <p class="adm-eyebrow">Administration</p>
        <h1 class="adm-title">Admission Forms</h1>
        <p class="adm-sub">All submitted student admission records. Search, review and manage individual forms.</p>
    </div>

    {{-- ============ TABLE CARD ============ --}}
    <div class="adm-card">
        <table id="admissionTable" class="adm-tbl" style="width:100%">
            <thead>
                <tr>
                    <th style="width:44px">#</th>
                    <th>Photo</th>
                    <th>Roll No</th>
                    <th>Student Name</th>
                    <th>Father Name</th>
                    <th>Course</th>
                    <th>Age</th>
                    <th class="th-r">Fee</th>
                    <th>Phone</th>
                    <th>Admission Date</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
@stop

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
.content-header{padding-top:10px}

.adm-list{
    --ink:#161A22;--muted:#6B7280;--faint:#9AA1AD;--line:#E9EBF0;--surface:#FFFFFF;
    --brand:#4F46E5;--brand-d:#4338CA;--soft:#F1F5F9;--bad:#BE123C;
    color:var(--ink);font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;-webkit-font-smoothing:antialiased;
}
.adm-list *{box-sizing:border-box}

/* header */
.adm-list .adm-head{margin-bottom:22px}
.adm-list .adm-eyebrow{font-size:11px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--brand);margin:0 0 6px}
.adm-list .adm-title{font-size:28px;font-weight:800;letter-spacing:-.02em;margin:0;line-height:1.1;color:var(--ink)}
.adm-list .adm-sub{margin:6px 0 0;color:var(--muted);font-size:13.5px}

/* card */
.adm-list .adm-card{background:var(--surface);border:1px solid var(--line);border-radius:18px;box-shadow:0 1px 3px rgba(16,24,40,.05);overflow:hidden}

/* DataTables wrapper + toolbar */
.adm-list .dataTables_wrapper{padding:18px 20px;overflow-x:auto;position:relative}
.adm-list .dataTables_length{float:left;margin-bottom:16px}
.adm-list .dataTables_filter{float:right;margin-bottom:16px}
.adm-list .dataTables_length label,.adm-list .dataTables_filter label{font-size:0;margin:0;color:var(--faint)}
.adm-list .dataTables_length select{appearance:none;-webkit-appearance:none;border:1px solid var(--line);
    background:#fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5'><path d='M6 9l6 6 6-6'/></svg>") no-repeat right 10px center;
    padding:8px 30px 8px 12px;border-radius:9px;font:600 13px 'Inter',sans-serif;color:var(--ink);cursor:pointer;height:auto}
.adm-list .dataTables_filter input{border:1px solid var(--line);
    background:#fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='%239AA1AD' stroke-width='2'><circle cx='11' cy='11' r='7'/><path d='M21 21l-4.3-4.3'/></svg>") no-repeat 12px center;
    padding:9px 14px 9px 36px;border-radius:10px;font:500 13.5px 'Inter',sans-serif;color:var(--ink);width:250px;margin:0;transition:.15s}
.adm-list .dataTables_filter input::placeholder{color:var(--faint)}
.adm-list .dataTables_filter input:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px rgba(79,70,229,.15)}

/* table */
.adm-list table.adm-tbl{width:100%;border-collapse:collapse;font-size:13px;margin:0;clear:both}
.adm-list table.adm-tbl thead th{background:#FAFBFC;text-align:left;font-size:10.5px;font-weight:600;letter-spacing:.04em;
    text-transform:uppercase;color:var(--faint);padding:11px 14px;border-top:1px solid var(--line);border-bottom:1px solid var(--line);white-space:nowrap;outline:none}
.adm-list table.adm-tbl thead th.th-r{text-align:right}
.adm-list table.adm-tbl thead th.th-action{text-align:right;min-width:110px}
.adm-list table.adm-tbl tbody td{padding:11px 14px;border-bottom:1px solid #F2F3F6;vertical-align:middle;color:var(--ink);white-space:nowrap}
.adm-list table.adm-tbl tbody tr{transition:background .12s}
.adm-list table.adm-tbl tbody tr:hover{background:#FAFAFE}
.adm-list table.adm-tbl tbody tr:last-child td{border-bottom:none}
.adm-list table.adm-tbl td.dataTables_empty{padding:34px 14px;text-align:center;color:var(--faint);white-space:normal}
.adm-list table.adm-tbl thead th.sorting,.adm-list table.adm-tbl thead th.sorting_asc,.adm-list table.adm-tbl thead th.sorting_desc{cursor:pointer;position:relative}
.adm-list table.adm-tbl thead .sorting:after{content:"\f0dc";font-family:'Font Awesome 5 Free','FontAwesome';font-weight:900;opacity:.25;margin-left:6px;font-size:10px}
.adm-list table.adm-tbl thead .sorting_asc:after{content:"\f0de";font-family:'Font Awesome 5 Free','FontAwesome';font-weight:900;opacity:.7;margin-left:6px;font-size:10px;color:var(--brand)}
.adm-list table.adm-tbl thead .sorting_desc:after{content:"\f0dd";font-family:'Font Awesome 5 Free','FontAwesome';font-weight:900;opacity:.7;margin-left:6px;font-size:10px;color:var(--brand)}

/* rendered cells */
.adm-list .adm-idx{color:var(--faint);font-variant-numeric:tabular-nums;font-weight:500}
.adm-list .adm-photo{height:40px;width:40px;border-radius:10px;object-fit:cover;border:1px solid var(--line);display:block}
.adm-list .adm-avatar{height:40px;width:40px;border-radius:10px;color:#fff;font-weight:700;font-size:13px;display:flex;align-items:center;justify-content:center;letter-spacing:.02em}
.adm-list .adm-roll{font-variant-numeric:tabular-nums;font-weight:600;background:var(--soft);color:#334155;padding:3px 9px;border-radius:7px;font-size:12px;white-space:nowrap}
.adm-list .adm-name{font-weight:600;color:var(--ink)}
.adm-list .adm-mut{color:var(--muted)}
.adm-list .adm-fee{font-variant-numeric:tabular-nums;font-weight:600}
.adm-list .adm-fee .cur{color:var(--faint);font-size:11px;margin-right:2px;font-weight:600}
.adm-list .adm-phone{display:inline-flex;align-items:center;gap:6px;font-variant-numeric:tabular-nums}
.adm-list .adm-phone i{color:var(--faint);font-size:12px}
.adm-list .adm-phone.muted{color:var(--faint)}
.adm-list td:last-child{text-align:right}

/* footer */
.adm-list .dataTables_info{float:left;font-size:12.5px;color:var(--faint);padding:16px 0 0}
.adm-list .dataTables_paginate{float:right;padding:16px 0 0;display:flex;gap:5px}
.adm-list .dataTables_paginate .paginate_button{display:inline-flex;align-items:center;justify-content:center;min-width:32px;height:32px;
    padding:0 10px;border:1px solid var(--line);border-radius:9px;font:600 13px 'Inter',sans-serif;color:var(--ink) !important;background:#fff;cursor:pointer;text-decoration:none;margin:0}
.adm-list .dataTables_paginate .paginate_button:hover{border-color:#cfd3dc;background:#FAFAFE}
.adm-list .dataTables_paginate .paginate_button.current,.adm-list .dataTables_paginate .paginate_button.current:hover{background:var(--brand);border-color:var(--brand);color:#fff !important}
.adm-list .dataTables_paginate .paginate_button.disabled,.adm-list .dataTables_paginate .paginate_button.disabled:hover{color:#CBD2DC !important;cursor:default;background:#fff;border-color:var(--line)}

/* processing */
.adm-list .dataTables_processing{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);background:var(--ink);color:#fff;
    font:600 12.5px 'Inter',sans-serif;padding:9px 16px;border-radius:10px;box-shadow:0 8px 24px rgba(16,24,40,.18);z-index:20;border:none}
.adm-list .dataTables_wrapper:after{content:"";display:block;clear:both}

@media(max-width:640px){
    .adm-list .adm-title{font-size:23px}
    .adm-list .dataTables_filter input{width:170px}
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(function () {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    var palette = ['#6366F1','#0EA5A4','#F59E0B','#EC4899','#10B981','#3B82F6','#8B5CF6','#EF4444','#14B8A6','#F97316'];
    function avatarColor(s){ var h=0; s=String(s||''); for(var i=0;i<s.length;i++) h=s.charCodeAt(i)+((h<<5)-h); return palette[Math.abs(h)%palette.length]; }
    function initials(s){ var p=String(s||'').trim().split(/\s+/); return ((p[0]?p[0][0]:'')+(p[1]?p[1][0]:'')).toUpperCase()||'–'; }
    function esc(s){ return $('<div>').text(s==null?'':s).html(); }
    function money(v){ var n=parseFloat(v); if(isNaN(n)) return esc(v); return n.toLocaleString('en-US'); }

    var table = $('#admissionTable').DataTable({
        processing: true,
        serverSide: true,
         scrollX: true,  
        ajax: '{{ route('admin.admission.index') }}',
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: '',
            searchPlaceholder: 'Search admissions…',
            lengthMenu: '_MENU_',
            info: 'Showing _START_ to _END_ of _TOTAL_ forms',
            infoEmpty: 'No forms to show',
            infoFiltered: '(filtered from _MAX_ total)',
            zeroRecords: 'No matching admission forms found',
            processing: 'Loading…',
            paginate: { previous: 'Prev', next: 'Next' }
        },
        columns: [
            { data: 'id', name: 'admission_forms.id', render: function (d) {
                return '<span class="adm-idx">' + esc(d) + '</span>';
            }},
            { data: 'pic_url', name: 'pic', orderable: false, searchable: false,
              render: function (d, type, row) {
                  if (d) return '<img class="adm-photo" src="' + d + '" alt="photo">';
                  return '<span class="adm-avatar" style="background:' + avatarColor(row.student_name) + '">' + esc(initials(row.student_name)) + '</span>';
              }},
            { data: 'roll_no', name: 'roll_no', render: function (d) {
                return d ? '<span class="adm-roll">' + esc(d) + '</span>' : '<span class="adm-mut">—</span>';
            }},
            { data: 'student_name', name: 'student_name', render: function (d) {
                return '<span class="adm-name">' + esc(d) + '</span>';
            }},
            { data: 'father_name', name: 'father_name', render: function (d) {
                return d ? '<span class="adm-mut">' + esc(d) + '</span>' : '<span class="adm-mut">—</span>';
            }},
            { data: 'course', name: 'course' },
            { data: 'age', name: 'age', render: function (d) {
                return '<span class="adm-mut">' + esc(d) + '</span>';
            }},
            { data: 'fee', name: 'fee', render: function (d) {
                return '<span class="adm-fee"><span class="cur">Rs</span>' + money(d) + '</span>';
            }},
            { data: 'phone_no', name: 'phone_no', render: function (d) {
                return d ? '<span class="adm-phone"><i class="fa fa-phone"></i> ' + esc(d) + '</span>' : '<span class="adm-phone muted">—</span>';
            }},
            { data: 'admission_date', name: 'admission_date', render: function (d) {
                return '<span class="adm-mut">' + esc(d) + '</span>';
            }},
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });

    $('#admissionTable').on('click', '.delete-admission', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this admission form?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#BE123C',
            confirmButtonText: 'Yes, delete'
        }).then(function (res) {
            if (res.isConfirmed) {
                $.post('{{ route('admin.admission.destroy') }}', { id: id }, function () {
                    table.ajax.reload();
                    Swal.fire('Deleted', 'Admission form removed.', 'success');
                });
            }
        });
    });
});
</script>
@stop