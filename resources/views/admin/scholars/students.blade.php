@extends('adminlte::page')

@section('title', 'Students')

@section('content_header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    {{-- Select2 for searchable dropdown --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
        :root {
            --brand: #4f46e5;
            --brand-dark: #4338ca;
            --brand-light: #eef2ff;
            --ink: #1e293b;
            --muted: #64748b;
            --line: #e2e8f0;
            --bg: #f8fafc;
        }

        .content-wrapper { background: var(--bg) !important; }

        .page-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 4px;
        }
        .page-head h1 {
            font-size: 26px;
            font-weight: 700;
            color: var(--ink);
            margin: 0;
            letter-spacing: -0.5px;
        }
        .page-head .sub {
            font-size: 13px;
            color: var(--muted);
            margin-top: 2px;
        }
        .page-head .head-icon {
            width: 48px; height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--brand), #7c3aed);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            box-shadow: 0 8px 20px -6px rgba(79,70,229,.5);
        }
        .head-left { display: flex; align-items: center; gap: 14px; }
    </style>
@stop

@section('content')

    {{-- ===== Header ===== --}}
    <div class="page-head">
        <div class="head-left">
            <div class="head-icon"><i class="fa fa-graduation-cap"></i></div>
            <div>
                <h1>My Students</h1>
                <div class="sub">Manage and review your assigned students</div>
            </div>
        </div>
    </div>

    {{-- ===== Search / Filter Bar ===== --}}
    <div class="card-premium" style="margin-top:18px;">
        <div class="filter-row">
            <div class="filter-field">
                <label>Search Student</label>
                <select id="studentSearch" class="form-control">
                    <option value="">All Students</option>
                </select>
            </div>
            <div class="filter-action">
                <button id="resetFilter" class="btn-ghost"><i class="fa fa-rotate-left"></i> Reset</button>
            </div>
            <div class="filter-stat">
                <span class="stat-num" id="studentCount">0</span>
                <span class="stat-label">Students</span>
            </div>
        </div>
    </div>

    {{-- ===== Table ===== --}}
    <div class="card-premium" style="margin-top:18px;">
        <div class="table-wrap">
            <table class="table premium-table" style="width:100%">
                <thead>
                <tr>
                    <th>Student Name</th>
                    <th class="text-right">Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="rolesModal"></div>

    <style>
        .card-premium {
            background: #fff;
            border: 1px solid var(--line);
            border-radius: 18px;
            box-shadow: 0 4px 20px -8px rgba(15,23,42,.08);
            padding: 22px 24px;
        }

        /* Filter bar */
        .filter-row {
            display: flex;
            align-items: flex-end;
            gap: 18px;
            flex-wrap: wrap;
        }
        .filter-field { flex: 1; min-width: 240px; }
        .filter-field label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: var(--muted);
            margin-bottom: 7px;
        }
        .filter-action { padding-bottom: 1px; }
        .btn-ghost {
            border: 1px solid var(--line);
            background: #fff;
            color: var(--muted);
            border-radius: 10px;
            padding: 9px 16px;
            font-size: 14px;
            font-weight: 500;
            transition: .15s;
            height: 40px;
        }
        .btn-ghost:hover { background: var(--brand-light); color: var(--brand); border-color: var(--brand); }

        .filter-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: var(--brand-light);
            border-radius: 12px;
            padding: 6px 22px;
            min-width: 90px;
            align-self: stretch;
        }
        .filter-stat .stat-num { font-size: 24px; font-weight: 700; color: var(--brand); line-height: 1; }
        .filter-stat .stat-label { font-size: 11px; color: var(--brand-dark); text-transform: uppercase; letter-spacing: .5px; margin-top: 4px; }

        /* Select2 custom look */
        .select2-container--default .select2-selection--single {
            height: 40px;
            border: 1px solid var(--line);
            border-radius: 10px;
            display: flex;
            align-items: center;
            padding: 0 6px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px; color: var(--ink); font-size: 14px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow { height: 38px; }
        .select2-dropdown {
            border: 1px solid var(--line);
            border-radius: 12px;
            box-shadow: 0 10px 30px -8px rgba(15,23,42,.18);
            overflow: hidden;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: var(--brand); color: #fff;
        }
        .select2-search--dropdown .select2-search__field {
            border: 1px solid var(--line); border-radius: 8px; padding: 7px 10px;
        }
        .select2-container { width: 100% !important; }

        /* Premium table */
        .table-wrap { overflow-x: auto; }
        .premium-table { margin: 0; border-collapse: separate; border-spacing: 0; }
        .premium-table thead th {
            background: transparent;
            border: none;
            border-bottom: 2px solid var(--line);
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
            padding: 12px 14px;
        }
        .premium-table tbody td {
            border: none;
            border-bottom: 1px solid var(--line);
            padding: 16px 14px;
            vertical-align: middle;
            color: var(--ink);
            font-size: 14.5px;
        }
        .premium-table tbody tr { transition: background .15s; }
        .premium-table tbody tr:hover { background: var(--brand-light); }

        .student-cell { display: flex; align-items: center; gap: 12px; }
        .avatar {
            width: 38px; height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--brand), #7c3aed);
            color: #fff;
            display: flex; align-items: center; justify-content: center;
            font-weight: 600; font-size: 15px;
            flex-shrink: 0;
        }
        .student-name { font-weight: 600; }

        .btn-pill {
            border-radius: 9px;
            padding: 7px 14px;
            font-size: 13px;
            font-weight: 600;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: .15s;
            margin-left: 6px;
            text-decoration: none;
        }
        .btn-lesson { background: var(--brand); color: #fff; }
        .btn-lesson:hover { background: var(--brand-dark); color: #fff; }
        .btn-report { background: #fff; color: var(--ink); border: 1px solid var(--line); }
        .btn-report:hover { background: #f1f5f9; color: var(--ink); }

        /* DataTables tweaks */
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--brand) !important; border-color: var(--brand) !important;
            color: #fff !important; border-radius: 8px;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            border-radius: 8px; padding: 5px 12px;
        }
        .dataTables_wrapper .dataTables_filter input,
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--line); border-radius: 8px; padding: 5px 10px;
        }
        .dataTables_wrapper .dataTables_info { color: var(--muted); font-size: 13px; }

        @media (max-width: 600px) {
            .filter-stat { display: none; }
        }
    </style>
@stop

@push('js')
    <script>
        var datatable = $('.premium-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{!! route('scholars.students') !!}',
                data: function (d) {
                    d.student_id = $('#studentSearch').val();
                }
            },
            columns: [
                {
                    data: 'name',
                    render: function (data) {
                        var initial = data ? data.trim().charAt(0).toUpperCase() : '?';
                        return '<div class="student-cell">' +
                                    '<div class="avatar">' + initial + '</div>' +
                                    '<span class="student-name">' + data + '</span>' +
                                '</div>';
                    }
                },
                {
                    data: 'lessons_action',
                    name: 'lessons_action',
                    orderable: false,
                    searchable: false,
                    className: 'text-right',
                    render: function (data, type, row) {
                        return '<a href="{{ url('admin/lessons/entry') }}/' + row.id + '" class="btn-pill btn-lesson"><i class="fa fa-book"></i> Lessons</a>' +
                               '<a href="{{ route('admin.lessons.report') }}?student_id=' + row.id + '" class="btn-pill btn-report"><i class="fa fa-file-text"></i> Report</a>';
                    }
                }
            ],
            order: [[0, 'asc']],
            dom: "<'row'<'col-sm-6'l><'col-sm-6'>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            language: {
                lengthMenu: "Show _MENU_",
                info: "Showing _START_ to _END_ of _TOTAL_ students"
            },
            drawCallback: function (settings) {
                $('#studentCount').text(settings._iRecordsTotal || 0);
            }
        });

        // ===== Populate searchable dropdown from the table's own data =====
        function loadStudentOptions() {
            $.get('{!! route('scholars.students') !!}', {
                draw: 1, start: 0, length: 1000,
                'columns[0][data]': 'name'
            }, function (res) {
                var data = res.data || [];
                var $sel = $('#studentSearch');
                $sel.find('option:not(:first)').remove();
                data.forEach(function (row) {
                    $sel.append(new Option(row.name, row.id));
                });
            });
        }
        loadStudentOptions();

        $('#studentSearch').select2({
            placeholder: 'Search student...',
            allowClear: true
        });

        $('#studentSearch').on('change', function () {
            datatable.ajax.reload();
        });

        $('#resetFilter').on('click', function () {
            $('#studentSearch').val('').trigger('change');
        });

        // ===== Delete (kept from original) =====
        $(document).on('click', '.delete', function () {
            let id = $(this).attr('data-id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('scholars.delete') }}",
                        data: 'id=' + id + "&_token={{ csrf_token() }}&parent=1",
                        type: "post",
                        success: function (output) {
                            Swal.fire('Deleted!', 'The scholar has been deleted.', 'success');
                            datatable.ajax.reload();
                        }
                    });
                }
            });
        });
    </script>
@endpush