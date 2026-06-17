@extends('adminlte::page')

@section('title', 'Manage Fee')

@section('content_header')
@stop

@section('content')
@php
    $parts   = preg_split('/\s+/', trim($student->name));
    $fsIni   = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? '', 0, 1)) ?: '–';
    $fsPal   = ['#6366F1','#0EA5A4','#F59E0B','#EC4899','#10B981','#3B82F6','#8B5CF6','#EF4444','#14B8A6','#F97316'];
    $fsColor = $fsPal[abs(crc32($student->name)) % count($fsPal)];
@endphp

<div class="fee-sheet">

    {{-- ============ HEADER ============ --}}
    <div class="fs-head">
        <div class="fs-id">
            <span class="fs-av" style="background:{{ $fsColor }}">{{ $fsIni }}</span>
            <div>
                <p class="fs-eyebrow">Administration · Fee Sheet</p>
                <h1 class="fs-title">{{ $student->name }}</h1>
                <p class="fs-sub">Edit monthly fees, payments and verification status for {{ $year }}.</p>
            </div>
        </div>
        <form method="GET" action="{{ route('admin.fees.manage', $student->id) }}" class="fs-ctrl">
            <select name="year" class="fs-select" onchange="this.form.submit()">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <a href="{{ route('admin.fees.index') }}" class="fs-back"><i class="fa fa-arrow-left"></i> Back to list</a>
        </form>
    </div>

    {{-- ============ FEE SHEET ============ --}}
    <form id="feeForm">
        <input type="hidden" name="user_id" value="{{ $student->id }}">
        <input type="hidden" name="year" value="{{ $year }}">

        <div class="fs-card">
            <div class="fs-tablewrap">
                <table class="fs-tbl">
                    <thead>
                        <tr>
                            <th style="width:44px">#</th>
                            <th>Month</th>
                            <th class="r">Monthly Fee</th>
                            <th class="r">Received</th>
                            <th class="r">Outstanding</th>
                            <th>Date</th>
                            <th class="c">Proof</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rows as $i => $row)
                        <tr>
                            <td class="fs-idx">{{ $i + 1 }}</td>
                            <td class="fs-month">{{ $row['month_name'] }}</td>
                            <td class="r">
                                <input type="number" step="0.01" class="form-control monthly-fee"
                                       name="months[{{ $row['month'] }}][monthly_fee]" value="{{ $row['monthly_fee'] }}">
                            </td>
                            <td class="r">
                                <input type="number" step="0.01" class="form-control received"
                                       name="months[{{ $row['month'] }}][received]" value="{{ $row['received'] }}">
                            </td>
                            <td class="r">
                                <input type="number" step="0.01" class="form-control outstanding"
                                       name="months[{{ $row['month'] }}][outstanding]" value="{{ $row['outstanding'] }}" readonly>
                            </td>
                            <td>
                                <input type="date" class="form-control fs-date"
                                       name="months[{{ $row['month'] }}][paid_date]"
                                       value="{{ $row['paid_date'] ? \Carbon\Carbon::parse($row['paid_date'])->format('Y-m-d') : '' }}">
                            </td>
                            <td class="c proof-cell">
                                <div class="fs-proof">
                                    @if($row['proof'])
                                        <a href="{{ asset('storage/' . $row['proof']) }}" target="_blank" title="View payment proof">
                                            <img src="{{ asset('storage/' . $row['proof']) }}" alt="proof">
                                        </a>
                                        <button type="button" class="fs-icbtn del delete-proof"
                                                data-month="{{ $row['month'] }}" title="Delete proof">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    @else
                                        <span class="fs-dash">—</span>
                                    @endif

                                    <label class="fs-icbtn up" title="Replace / upload proof">
                                        <i class="fa fa-upload"></i>
                                        <input type="file" class="replace-proof" data-month="{{ $row['month'] }}"
                                               accept="image/*" style="display:none">
                                    </label>
                                </div>
                            </td>
                            <td>
                                <select class="form-control fee-status" name="months[{{ $row['month'] }}][status]">
                                    @foreach(\App\FeeRecord::$statuses as $sKey => $sLabel)
                                        <option value="{{ $sKey }}" {{ $row['status'] == $sKey ? 'selected' : '' }}>{{ $sLabel }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="lbl">Total</td>
                            <td class="r"><span class="cur">Rs</span><span id="totalFee">0</span></td>
                            <td class="r ok"><span class="cur ok">Rs</span><span id="totalReceived">0</span></td>
                            <td class="r bad"><span class="cur bad">Rs</span><span id="totalOutstanding">0</span></td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="fs-foot">
                <span class="fs-hint"><i class="fa fa-info-circle"></i> Outstanding is calculated automatically as fee minus received.</span>
                <button type="submit" class="fs-save"><i class="fa fa-save"></i> Save Fee Sheet</button>
            </div>
        </div>
    </form>

</div>
@stop

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
.content-header{padding-top:10px}

.fee-sheet{
    --ink:#161A22;--muted:#6B7280;--faint:#9AA1AD;--line:#E9EBF0;--surface:#FFFFFF;
    --brand:#4F46E5;--brand-d:#4338CA;--ok:#047857;--bad:#BE123C;--bad-bg:#FFF1F2;--bad-br:#FAD1D7;
    color:var(--ink);font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;-webkit-font-smoothing:antialiased;
}
.fee-sheet *{box-sizing:border-box}

/* header */
.fee-sheet .fs-head{display:flex;align-items:center;justify-content:space-between;gap:20px;margin-bottom:22px;flex-wrap:wrap}
.fee-sheet .fs-id{display:flex;align-items:center;gap:14px}
.fee-sheet .fs-av{flex:0 0 48px;height:48px;width:48px;border-radius:14px;color:#fff;font-weight:700;font-size:17px;
    display:flex;align-items:center;justify-content:center;letter-spacing:.02em}
.fee-sheet .fs-eyebrow{font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--brand);margin:0 0 4px}
.fee-sheet .fs-title{font-size:25px;font-weight:800;letter-spacing:-.02em;margin:0;line-height:1.05;color:var(--ink)}
.fee-sheet .fs-sub{margin:4px 0 0;color:var(--muted);font-size:13px}
.fee-sheet .fs-ctrl{display:flex;align-items:center;gap:10px;margin:0}
.fee-sheet .fs-select{appearance:none;-webkit-appearance:none;border:1px solid var(--line);
    background:#fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5'><path d='M6 9l6 6 6-6'/></svg>") no-repeat right 12px center;
    padding:9px 34px 9px 14px;border-radius:10px;font:600 14px 'Inter',sans-serif;color:var(--ink);cursor:pointer;height:auto}
.fee-sheet .fs-select:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px rgba(79,70,229,.15)}
.fee-sheet .fs-back{display:inline-flex;align-items:center;gap:7px;border:1px solid var(--line);background:#fff;color:var(--muted);
    font:600 13px 'Inter',sans-serif;padding:9px 14px;border-radius:10px;text-decoration:none;transition:.15s}
.fee-sheet .fs-back:hover{border-color:#cfd3dc;color:var(--ink)}

/* card + table */
.fee-sheet .fs-card{background:var(--surface);border:1px solid var(--line);border-radius:18px;box-shadow:0 1px 3px rgba(16,24,40,.05);overflow:hidden}
.fee-sheet .fs-tablewrap{overflow-x:auto}
.fee-sheet table.fs-tbl{width:100%;border-collapse:collapse;font-size:13px;margin:0}
.fee-sheet table.fs-tbl thead th{background:#FAFBFC;text-align:left;font-size:11px;font-weight:600;letter-spacing:.05em;
    text-transform:uppercase;color:var(--faint);padding:11px 14px;border-bottom:1px solid var(--line);white-space:nowrap}
.fee-sheet table.fs-tbl thead th.r{text-align:right}
.fee-sheet table.fs-tbl thead th.c{text-align:center}
.fee-sheet table.fs-tbl tbody td{padding:9px 14px;border-bottom:1px solid #F2F3F6;vertical-align:middle;color:var(--ink)}
.fee-sheet table.fs-tbl tbody td.r{text-align:right}
.fee-sheet table.fs-tbl tbody td.c{text-align:center}
.fee-sheet table.fs-tbl tbody tr:last-child td{border-bottom:none}
.fee-sheet .fs-idx{color:var(--faint);font-weight:500;font-variant-numeric:tabular-nums}
.fee-sheet .fs-month{font-weight:600;white-space:nowrap}

/* inputs (override AdminLTE/Bootstrap) */
.fee-sheet .form-control{height:auto;border:1px solid var(--line);border-radius:9px;padding:8px 11px;
    font:500 13px 'Inter',sans-serif;color:var(--ink);background:#fff;box-shadow:none;transition:.15s;display:inline-block}
.fee-sheet .form-control:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(79,70,229,.15);outline:none}
.fee-sheet input.monthly-fee,.fee-sheet input.received,.fee-sheet input.outstanding{
    text-align:right;font-variant-numeric:tabular-nums;font-weight:600;width:108px}
.fee-sheet input.outstanding{background:#F7F8FB;color:var(--muted);cursor:default}
.fee-sheet input.outstanding.has-due{color:var(--bad);background:var(--bad-bg);border-color:var(--bad-br)}
.fee-sheet input.fs-date{width:150px;font-weight:500}
.fee-sheet select.fee-status{width:152px;appearance:none;-webkit-appearance:none;cursor:pointer;font-weight:600;
    background:#fff url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5'><path d='M6 9l6 6 6-6'/></svg>") no-repeat right 10px center;padding-right:30px}

/* proof cell */
.fee-sheet .fs-proof{display:flex;align-items:center;justify-content:center;gap:7px}
.fee-sheet .fs-proof img{height:38px;width:38px;object-fit:cover;border-radius:8px;border:1px solid var(--line);cursor:zoom-in;display:block;transition:.15s}
.fee-sheet .fs-proof img:hover{transform:scale(1.06);box-shadow:0 4px 12px rgba(16,24,40,.18)}
.fee-sheet .fs-dash{color:var(--faint)}
.fee-sheet .fs-icbtn{height:30px;width:30px;display:inline-flex;align-items:center;justify-content:center;border-radius:8px;
    border:1px solid var(--line);background:#fff;cursor:pointer;font-size:12px;color:var(--muted);margin:0;transition:.15s}
.fee-sheet .fs-icbtn.del{color:var(--bad)}
.fee-sheet .fs-icbtn.del:hover{background:var(--bad-bg);border-color:var(--bad-br)}
.fee-sheet .fs-icbtn.up:hover{background:#EEF0FB;border-color:#C7CCF7;color:var(--brand-d)}

/* totals */
.fee-sheet table.fs-tbl tfoot td{padding:14px;background:#FAFBFC;border-top:2px solid var(--line);font-weight:700;
    font-variant-numeric:tabular-nums;font-size:14px;color:var(--ink)}
.fee-sheet table.fs-tbl tfoot td.ok{color:var(--ok)}
.fee-sheet table.fs-tbl tfoot td.bad{color:var(--bad)}
.fee-sheet table.fs-tbl tfoot .lbl{font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:var(--faint);font-weight:600}
.fee-sheet table.fs-tbl tfoot .cur{font-size:11px;font-weight:600;margin-right:3px;color:var(--faint)}
.fee-sheet table.fs-tbl tfoot .cur.ok{color:var(--ok)}
.fee-sheet table.fs-tbl tfoot .cur.bad{color:var(--bad)}

/* footer */
.fee-sheet .fs-foot{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:16px 20px;
    border-top:1px solid var(--line);background:#FCFCFD;flex-wrap:wrap}
.fee-sheet .fs-hint{font-size:12.5px;color:var(--faint)}
.fee-sheet .fs-hint i{margin-right:4px}
.fee-sheet .fs-save{display:inline-flex;align-items:center;gap:8px;background:var(--brand);color:#fff;border:none;
    font:600 13.5px 'Inter',sans-serif;padding:10px 18px;border-radius:10px;cursor:pointer;transition:.15s}
.fee-sheet .fs-save:hover{background:var(--brand-d)}
.fee-sheet .fs-save:active{transform:translateY(1px)}

@media(max-width:640px){
    .fee-sheet .fs-title{font-size:21px}
    .fee-sheet .fs-foot{justify-content:stretch}
    .fee-sheet .fs-save{width:100%;justify-content:center}
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    var feeUserId = {{ $student->id }};
    var feeYear   = {{ $year }};

    // Delete proof
    $(document).on('click', '.delete-proof', function () {
        var month = $(this).data('month');
        Swal.fire({
            title: 'Delete proof?',
            text: 'This will permanently remove the payment proof for this month. Are you sure?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#BE123C',
            confirmButtonText: 'Yes, delete'
        }).then(function (r) {
            if (!r.isConfirmed) return;
            $.ajax({
                url: '{{ route('admin.fees.proof.delete') }}',
                method: 'POST',
                data: { user_id: feeUserId, year: feeYear, month: month },
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function (res) {
                    Swal.fire('Deleted', res.message, 'success').then(function(){ location.reload(); });
                },
                error: function () { Swal.fire('Error', 'Could not delete.', 'error'); }
            });
        });
    });

    // Replace / edit proof
    $(document).on('change', '.replace-proof', function () {
        var file = this.files[0];
        if (!file) return;
        var fd = new FormData();
        fd.append('user_id', feeUserId);
        fd.append('year', feeYear);
        fd.append('month', $(this).data('month'));
        fd.append('proof', file);
        $.ajax({
            url: '{{ route('admin.fees.proof.replace') }}',
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) {
                Swal.fire('Updated', res.message, 'success').then(function(){ location.reload(); });
            },
            error: function () { Swal.fire('Error', 'Could not update.', 'error'); }
        });
    });

    function recalc() {
        var tf = 0, tr = 0, to = 0;
        $('#feeForm tbody tr').each(function () {
            var fee = parseFloat($(this).find('.monthly-fee').val()) || 0;
            var rec = parseFloat($(this).find('.received').val()) || 0;
            var out = Math.max(fee - rec, 0);
            var $out = $(this).find('.outstanding');
            $out.val(out.toFixed(2)).toggleClass('has-due', out > 0);
            tf += fee; tr += rec; to += out;
        });
        $('#totalFee').text(tf.toFixed(2));
        $('#totalReceived').text(tr.toFixed(2));
        $('#totalOutstanding').text(to.toFixed(2));
    }
    $(document).on('input', '.monthly-fee, .received', recalc);
    $(recalc);

    // When admin marks a month "Received", default the received amount to the monthly fee
    $(document).on('change', '.fee-status', function () {
        if ($(this).val() !== 'received') return;
        var tr  = $(this).closest('tr');
        var rec = parseFloat(tr.find('.received').val()) || 0;
        var fee = parseFloat(tr.find('.monthly-fee').val()) || 0;
        if (rec === 0 && fee > 0) {
            tr.find('.received').val(fee.toFixed(2));
            recalc();
        }
    });

    $('#feeForm').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '{{ route('admin.fees.store') }}',
            method: 'POST',
            data: $(this).serialize(),
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            success: function (res) { Swal.fire('Saved', res.message, 'success'); },
            error: function () { Swal.fire('Error', 'Could not save.', 'error'); }
        });
    });
</script>
@stop