@extends('adminlte::page')

@section('title', 'Fee Records')

@section('content_header')
@stop

@section('content')
<div class="fee-admin">

    {{-- ============ HEADER ============ --}}
    <div class="fa-head">
        <p class="fa-eyebrow">Administration</p>
        <h1 class="fa-title">Fee Records</h1>
        <p class="fa-sub">All enrolled students. Search, review and manage individual fee statements.</p>
    </div>

    {{-- ============ TABLE CARD ============ --}}
    <div class="fa-card">
        <table id="feeStudentsTable" class="fa-tbl" style="width:100%">
            <thead>
                <tr>
                    {{-- <th style="width:48px">#</th> --}}
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th class="th-action">Action</th>
                </tr>
            </thead>
        </table>
    </div>

</div>
@stop

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
.content-header{padding-top:10px}

.fee-admin{
    --ink:#161A22;--muted:#6B7280;--faint:#9AA1AD;--line:#E9EBF0;--surface:#FFFFFF;
    --brand:#4F46E5;--brand-d:#4338CA;--soft:#F1F5F9;
    color:var(--ink);font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    -webkit-font-smoothing:antialiased;
}
.fee-admin *{box-sizing:border-box}

/* header */
.fee-admin .fa-head{margin-bottom:22px}
.fee-admin .fa-eyebrow{font-size:11px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--brand);margin:0 0 6px}
.fee-admin .fa-title{font-size:28px;font-weight:800;letter-spacing:-.02em;margin:0;line-height:1.1;color:var(--ink)}
.fee-admin .fa-sub{margin:6px 0 0;color:var(--muted);font-size:13.5px}

/* card */
.fee-admin .fa-card{background:var(--surface);border:1px solid var(--line);border-radius:18px;
    box-shadow:0 1px 3px rgba(16,24,40,.05);overflow:hidden}

/* DataTables wrapper + toolbar */
.fee-admin .dataTables_wrapper{padding:18px 20px}
.fee-admin .dataTables_length{float:left;margin-bottom:16px}
.fee-admin .dataTables_filter{float:right;margin-bottom:16px;position:relative}
.fee-admin .dataTables_length label,
.fee-admin .dataTables_filter label{font-size:0;margin:0;color:var(--faint)}
.fee-admin .dataTables_length select{
    appearance:none;-webkit-appearance:none;border:1px solid var(--line);
    background:#fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5'><path d='M6 9l6 6 6-6'/></svg>") no-repeat right 10px center;
    padding:8px 30px 8px 12px;border-radius:9px;font:600 13px 'Inter',sans-serif;color:var(--ink);cursor:pointer;height:auto}
.fee-admin .dataTables_filter input{
    border:1px solid var(--line);
    background:#fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='15' height='15' viewBox='0 0 24 24' fill='none' stroke='%239AA1AD' stroke-width='2'><circle cx='11' cy='11' r='7'/><path d='M21 21l-4.3-4.3'/></svg>") no-repeat 12px center;
    padding:9px 14px 9px 36px;border-radius:10px;font:500 13.5px 'Inter',sans-serif;color:var(--ink);width:260px;margin:0;transition:.15s}
.fee-admin .dataTables_filter input::placeholder{color:var(--faint)}
.fee-admin .dataTables_filter input:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px rgba(79,70,229,.15)}

/* table */
.fee-admin table.fa-tbl{width:100%;border-collapse:collapse;font-size:13.5px;margin:0;clear:both}
.fee-admin table.fa-tbl thead th{background:#FAFBFC;text-align:left;font-size:11px;font-weight:600;letter-spacing:.05em;
    text-transform:uppercase;color:var(--faint);padding:11px 16px;border-top:1px solid var(--line);
    border-bottom:1px solid var(--line);white-space:nowrap;outline:none}
.fee-admin table.fa-tbl thead th.th-action{text-align:right}
.fee-admin table.fa-tbl tbody td{padding:12px 16px;border-bottom:1px solid #F2F3F6;vertical-align:middle;color:var(--ink)}
.fee-admin table.fa-tbl tbody tr{transition:background .12s}
.fee-admin table.fa-tbl tbody tr:hover{background:#FAFAFE}
.fee-admin table.fa-tbl tbody tr:last-child td{border-bottom:none}
.fee-admin table.fa-tbl td.dataTables_empty{padding:34px 16px;text-align:center;color:var(--faint)}
/* sort arrows */
.fee-admin table.fa-tbl thead th.sorting,
.fee-admin table.fa-tbl thead th.sorting_asc,
.fee-admin table.fa-tbl thead th.sorting_desc{cursor:pointer;position:relative}
.fee-admin table.fa-tbl thead .sorting:after{content:"\f0dc";font-family:'Font Awesome 5 Free','FontAwesome';font-weight:900;
    opacity:.25;margin-left:7px;font-size:10px}
.fee-admin table.fa-tbl thead .sorting_asc:after{content:"\f0de";font-family:'Font Awesome 5 Free','FontAwesome';font-weight:900;
    opacity:.7;margin-left:7px;font-size:10px;color:var(--brand)}
.fee-admin table.fa-tbl thead .sorting_desc:after{content:"\f0dd";font-family:'Font Awesome 5 Free','FontAwesome';font-weight:900;
    opacity:.7;margin-left:7px;font-size:10px;color:var(--brand)}

/* rendered cells */
.fee-admin .fa-idx{color:var(--faint);font-variant-numeric:tabular-nums;font-weight:500}
.fee-admin .cellname{display:flex;align-items:center;gap:10px}
.fee-admin .avatar{flex:0 0 32px;height:32px;width:32px;border-radius:50%;color:#fff;font-size:12px;font-weight:700;
    display:flex;align-items:center;justify-content:center;letter-spacing:.02em}
.fee-admin .cellname b{font-weight:600;color:var(--ink)}
.fee-admin .cellmail{color:var(--muted);text-decoration:none;font-weight:500}
.fee-admin .cellmail:hover{color:var(--brand-d);text-decoration:underline}
.fee-admin .cellphone{color:var(--ink);font-variant-numeric:tabular-nums;display:inline-flex;align-items:center;gap:7px}
.fee-admin .cellphone i{color:var(--faint);font-size:12px}
.fee-admin .cellphone.muted{color:var(--faint)}
.fee-admin td:last-child{text-align:right}

/* footer: info + pagination */
.fee-admin .dataTables_info{float:left;font-size:12.5px;color:var(--faint);padding:16px 0 0}
.fee-admin .dataTables_paginate{float:right;padding:16px 0 0;display:flex;gap:5px}
.fee-admin .dataTables_paginate .paginate_button{display:inline-flex;align-items:center;justify-content:center;
    min-width:32px;height:32px;padding:0 10px;border:1px solid var(--line);border-radius:9px;font:600 13px 'Inter',sans-serif;
    color:var(--ink) !important;background:#fff;cursor:pointer;text-decoration:none;margin:0}
.fee-admin .dataTables_paginate .paginate_button:hover{border-color:#cfd3dc;background:#FAFAFE}
.fee-admin .dataTables_paginate .paginate_button.current,
.fee-admin .dataTables_paginate .paginate_button.current:hover{background:var(--brand);border-color:var(--brand);color:#fff !important}
.fee-admin .dataTables_paginate .paginate_button.disabled,
.fee-admin .dataTables_paginate .paginate_button.disabled:hover{color:#CBD2DC !important;cursor:default;background:#fff;border-color:var(--line)}

/* processing indicator */
.fee-admin .dataTables_processing{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);
    background:var(--ink);color:#fff;font:600 12.5px 'Inter',sans-serif;padding:9px 16px;border-radius:10px;
    box-shadow:0 8px 24px rgba(16,24,40,.18);z-index:20;border:none}

.fee-admin .dataTables_wrapper:after{content:"";display:block;clear:both}

@media(max-width:640px){
    .fee-admin .fa-title{font-size:23px}
    .fee-admin .dataTables_filter input{width:170px}
}
</style>
@stop

@section('js')
<script>
$(function () {
    // deterministic avatar color from a name
    var palette = ['#6366F1','#0EA5A4','#F59E0B','#EC4899','#10B981','#3B82F6','#8B5CF6','#EF4444','#14B8A6','#F97316'];
    function avatarColor(str){
        var h = 0; str = String(str || '');
        for (var i = 0; i < str.length; i++) h = str.charCodeAt(i) + ((h << 5) - h);
        return palette[Math.abs(h) % palette.length];
    }
    function initials(str){
        var p = String(str || '').trim().split(/\s+/);
        return ((p[0] ? p[0][0] : '') + (p[1] ? p[1][0] : '')).toUpperCase() || '–';
    }
    function esc(s){ return $('<div>').text(s == null ? '' : s).html(); }

    $('#feeStudentsTable').DataTable({
        processing: true,
        serverSide: true,
         scrollX: true,  
        ajax: '{{ route('admin.fees.index') }}',
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        language: {
            search: '',
            searchPlaceholder: 'Search students…',
            lengthMenu: '_MENU_',
            info: 'Showing _START_ to _END_ of _TOTAL_ students',
            infoEmpty: 'No students to show',
            infoFiltered: '(filtered from _MAX_ total)',
            zeroRecords: 'No matching students found',
            processing: 'Loading…',
            paginate: { previous: 'Prev', next: 'Next' }
        },
        columns: [
            // { data: 'id', name: 'id', render: function (d) {
            //     return '<span class="fa-idx">' + esc(d) + '</span>';
            // }},
            { data: 'name', name: 'name', render: function (d) {
                return '<div class="cellname"><span class="avatar" style="background:' + avatarColor(d) + '">'
                     + esc(initials(d)) + '</span><b>' + esc(d) + '</b></div>';
            }},
            { data: 'email', name: 'email', render: function (d) {
                return d ? '<a class="cellmail" href="mailto:' + esc(d) + '">' + esc(d) + '</a>'
                         : '<span class="cellphone muted">—</span>';
            }},
            { data: 'contact_no', name: 'contact_no', render: function (d) {
                return d ? '<span class="cellphone"><i class="fa fa-phone"></i> ' + esc(d) + '</span>'
                         : '<span class="cellphone muted">—</span>';
            }},
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@stop