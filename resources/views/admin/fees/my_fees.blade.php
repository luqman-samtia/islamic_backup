@extends('adminlte::page')

@section('title', 'My Fee Report')

@section('content_header')
@stop

@section('content')
@php
    $totalMonths = count($rows);
@endphp

<div class="fee-report">

    {{-- ============ HEADER ============ --}}
    <div class="fr-head">
        <div>
            <p class="fr-eyebrow">Fee Statement</p>
            <h1 class="fr-title">My Fee Report</h1>
            <p class="fr-sub">Monthly dues, payments and verification status for {{ $year }}.</p>
        </div>
        <form method="GET" action="{{ route('fees.my-report') }}" class="fr-year">
            <label for="yearSelect">Year</label>
            <select name="year" id="yearSelect" class="fr-select" onchange="this.form.submit()">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </form>
    </div>

    {{-- ============ OUTSTANDING BALANCE ============ --}}
    <div class="fr-outstanding {{ $totalOutstanding > 0 ? 'has-due' : 'clear' }}">
        @if($totalOutstanding > 0)
            <div class="ic"><i class="fa fa-exclamation-circle"></i></div>
            <div class="body">
                <p class="lbl">Outstanding Balance</p>
                <div class="amt fee-num"><span class="cur">Rs</span>{{ number_format($totalOutstanding, 0) }}</div>
                <p class="sub">Total amount due for {{ $year }}. Please clear your pending dues.</p>
            </div>
        @else
            <div class="ic"><i class="fa fa-check-circle"></i></div>
            <div class="body">
                <p class="lbl">Outstanding Balance</p>
                <div class="amt fee-num"><span class="cur">Rs</span>0</div>
                <p class="sub">You're all caught up for {{ $year }}. Nothing is due.</p>
            </div>
        @endif
    </div>

    {{-- ============ STATEMENT TABLE ============ --}}
    <div class="fr-card">
        <div class="fr-cardhd">
            <h2>Monthly Breakdown</h2>
            <span class="cnt">{{ $totalMonths }} months · {{ $year }}</span>
        </div>

        <div class="fr-tablewrap">
            <table class="fr-tbl">
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Month</th>
                        <th class="r">Monthly Fee</th>
                        <th class="r">Received</th>
                        <th class="r">Outstanding</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th class="c">Payment Proof</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $i => $row)
                    <tr>
                        <td class="fr-idx">{{ $i + 1 }}</td>
                        <td class="fr-month">{{ $row['month_name'] }}</td>
                        <td class="r fr-amt">{{ number_format($row['monthly_fee'], 0) }}</td>
                        <td class="r fr-amt {{ $row['received'] > 0 ? 'paid' : 'muted' }}">
                            {{ number_format($row['received'], 0) }}
                        </td>
                        <td class="r">
                            @if($row['outstanding'] > 0)
                                <span class="fr-amt due">{{ number_format($row['outstanding'], 0) }}</span>
                            @else
                                <span class="fr-amt muted">0</span>
                            @endif
                        </td>
                        <td class="fr-date">
                            {{ $row['paid_date'] ? \Carbon\Carbon::parse($row['paid_date'])->format('d-M-Y') : '—' }}
                        </td>
                        <td>
                            @if($row['status'] === 'received')
                                <span class="pill ok"><i class="fa fa-check"></i> Received</span>
                            @elseif($row['status'] === 'rejected')
                                <span class="pill bad"><i class="fa fa-times"></i> Rejected</span>
                            @elseif($row['proof'])
                                <span class="pill warn"><i class="fa fa-hourglass-half"></i> Pending Review</span>
                            @else
                                <span class="pill neu">Not Submitted</span>
                            @endif
                        </td>
                        <td class="c">
                            <div class="fr-proof">
                                @if($row['proof'])
                                    <a href="{{ asset('storage/' . $row['proof']) }}" target="_blank" title="View proof">
                                        <img class="fr-thumb" src="{{ asset('storage/' . $row['proof']) }}" alt="proof">
                                    </a>
                                @endif
                                @if($row['status'] !== 'received')
                                    <button type="button"
                                            class="fr-up upload-proof-btn {{ $row['proof'] ? '' : 'solid' }}"
                                            data-month="{{ $row['month'] }}" data-year="{{ $year }}">
                                        <i class="fa fa-upload"></i> {{ $row['proof'] ? 'Re-upload' : 'Upload' }}
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        {{-- <td colspan="2" class="lbl">Total</td> --}}
                        {{-- <td class="r fr-amt">{{ number_format($totalFee, 0) }}</td> --}}
                        {{-- <td class="r fr-amt" style="color:var(--ok)">{{ number_format($totalReceived, 0) }}</td> --}}
                        {{-- <td class="r fr-amt" style="color:var(--bad)">{{ number_format($totalOutstanding, 0) }}</td> --}}
                        {{-- <td colspan="3"></td> --}}
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- ============ CALLOUT ============ --}}
    <div class="fr-note">
        <span class="ic"><i class="fa fa-info"></i></span>
        <div>
            After paying your fee, upload the transaction screenshot here.
            Once the admin verifies it, the status will be marked as <b>Received</b>.
        </div>
    </div>

</div>

{{-- hidden file input used by all upload buttons --}}
<input type="file" id="proofFile" accept="image/*" style="display:none">
@stop

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
/* hide default content-header gap when empty */
.content-header{padding-top:10px}

.fee-report{
    --ink:#161A22;--muted:#6B7280;--faint:#9AA1AD;--line:#E9EBF0;--surface:#FFFFFF;
    --brand:#4F46E5;--brand-d:#4338CA;
    --ok:#047857;--ok-bg:#ECFDF5;--ok-br:#A7F3D0;
    --warn:#B45309;--warn-bg:#FFFBEB;--warn-br:#FDE68A;
    --bad:#BE123C;--bad-bg:#FFF1F2;--bad-br:#FECDD3;
    --neu:#475569;--neu-bg:#F1F5F9;
    color:var(--ink);font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;
    -webkit-font-smoothing:antialiased;
}
.fee-report *{box-sizing:border-box}
.fee-report .fee-num{font-variant-numeric:tabular-nums;font-feature-settings:"tnum" 1}

/* header */
.fee-report .fr-head{display:flex;align-items:flex-end;justify-content:space-between;gap:24px;margin-bottom:22px;flex-wrap:wrap}
.fee-report .fr-eyebrow{font-size:11px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--brand);margin:0 0 6px}
.fee-report .fr-title{font-size:28px;font-weight:800;letter-spacing:-.02em;margin:0;line-height:1.1;color:var(--ink)}
.fee-report .fr-sub{margin:6px 0 0;color:var(--muted);font-size:13.5px}
.fee-report .fr-year{display:flex;align-items:center;gap:10px;margin:0}
.fee-report .fr-year label{font-size:12px;font-weight:600;color:var(--faint);text-transform:uppercase;letter-spacing:.06em;margin:0}
.fee-report .fr-select{
    appearance:none;-webkit-appearance:none;border:1px solid var(--line);background:var(--surface)
    url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236B7280' stroke-width='2.5'><path d='M6 9l6 6 6-6'/></svg>") no-repeat right 12px center;
    padding:9px 34px 9px 14px;border-radius:10px;font:600 14px 'Inter',sans-serif;color:var(--ink);cursor:pointer;
    box-shadow:0 1px 2px rgba(16,24,40,.04);transition:.15s;height:auto}
.fee-report .fr-select:hover{border-color:#cfd3dc}
.fee-report .fr-select:focus{outline:none;border-color:var(--brand);box-shadow:0 0 0 3px rgba(79,70,229,.15)}

/* outstanding balance card */
.fee-report .fr-outstanding{display:flex;align-items:center;gap:18px;background:var(--surface);
    border:1px solid var(--line);border-radius:16px;padding:20px 24px;margin-bottom:18px;
    box-shadow:0 1px 2px rgba(16,24,40,.04);position:relative;overflow:hidden}
.fee-report .fr-outstanding:before{content:"";position:absolute;left:0;top:0;bottom:0;width:5px}
.fee-report .fr-outstanding.has-due:before{background:var(--bad)}
.fee-report .fr-outstanding.clear:before{background:var(--ok)}
.fee-report .fr-outstanding .ic{flex:0 0 52px;height:52px;width:52px;border-radius:14px;display:flex;
    align-items:center;justify-content:center;font-size:22px}
.fee-report .fr-outstanding.has-due .ic{background:var(--bad-bg);color:var(--bad)}
.fee-report .fr-outstanding.clear .ic{background:var(--ok-bg);color:var(--ok)}
.fee-report .fr-outstanding .lbl{font-size:11.5px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;
    color:var(--faint);margin:0 0 4px}
.fee-report .fr-outstanding .amt{font-size:32px;font-weight:800;letter-spacing:-.025em;line-height:1}
.fee-report .fr-outstanding.has-due .amt{color:var(--bad)}
.fee-report .fr-outstanding.clear .amt{color:var(--ok)}
.fee-report .fr-outstanding .amt .cur{font-size:15px;font-weight:600;margin-right:4px;letter-spacing:0;opacity:.7}
.fee-report .fr-outstanding .sub{margin:6px 0 0;font-size:13px;color:var(--muted)}

/* table card */
.fee-report .fr-card{background:var(--surface);border:1px solid var(--line);border-radius:18px;overflow:hidden;
    box-shadow:0 1px 3px rgba(16,24,40,.05)}
.fee-report .fr-cardhd{padding:16px 22px;border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between}
.fee-report .fr-cardhd h2{margin:0;font-size:15px;font-weight:700;letter-spacing:-.01em;color:var(--ink)}
.fee-report .fr-cardhd .cnt{font-size:12px;color:var(--faint);font-weight:500}
.fee-report .fr-tablewrap{overflow-x:auto}
.fee-report table.fr-tbl{width:100%;border-collapse:collapse;font-size:13.5px;margin:0}
.fee-report table.fr-tbl thead th{background:#FAFBFC;text-align:left;font-size:11px;font-weight:600;letter-spacing:.05em;
    text-transform:uppercase;color:var(--faint);padding:11px 16px;border-bottom:1px solid var(--line);white-space:nowrap}
.fee-report table.fr-tbl thead th.r,.fee-report table.fr-tbl tbody td.r{text-align:right}
.fee-report table.fr-tbl thead th.c,.fee-report table.fr-tbl tbody td.c{text-align:center}
.fee-report table.fr-tbl tbody td{padding:13px 16px;border-bottom:1px solid #F2F3F6;vertical-align:middle;color:var(--ink)}
.fee-report table.fr-tbl tbody tr{transition:background .12s}
.fee-report table.fr-tbl tbody tr:hover{background:#FAFAFE}
.fee-report table.fr-tbl tbody tr:last-child td{border-bottom:none}
.fee-report .fr-idx{color:var(--faint);font-variant-numeric:tabular-nums;font-weight:500}
.fee-report .fr-month{font-weight:600;color:var(--ink)}
.fee-report .fr-amt{font-variant-numeric:tabular-nums;font-weight:600}
.fee-report .fr-amt.due{color:var(--bad)}
.fee-report .fr-amt.paid{color:var(--ok)}
.fee-report .fr-amt.muted{color:var(--faint);font-weight:500}
.fee-report .fr-date{color:var(--muted);font-variant-numeric:tabular-nums;white-space:nowrap}

.fee-report .pill{display:inline-flex;align-items:center;gap:6px;font-size:11.5px;font-weight:600;padding:4px 11px;
    border-radius:99px;border:1px solid;white-space:nowrap;letter-spacing:.01em}
.fee-report .pill i{font-size:9px}
.fee-report .pill.ok{color:var(--ok);background:var(--ok-bg);border-color:var(--ok-br)}
.fee-report .pill.warn{color:var(--warn);background:var(--warn-bg);border-color:var(--warn-br)}
.fee-report .pill.bad{color:var(--bad);background:var(--bad-bg);border-color:var(--bad-br)}
.fee-report .pill.neu{color:var(--neu);background:var(--neu-bg);border-color:#E2E8F0}

.fee-report .fr-proof{display:flex;align-items:center;gap:8px;justify-content:flex-end}
.fee-report .fr-thumb{height:34px;width:34px;object-fit:cover;border-radius:8px;border:1px solid var(--line);transition:.15s;cursor:zoom-in;display:block}
.fee-report .fr-thumb:hover{transform:scale(1.06);box-shadow:0 4px 12px rgba(16,24,40,.18)}
.fee-report .fr-up{display:inline-flex;align-items:center;gap:6px;border:1px solid var(--line);background:#fff;color:var(--brand-d);
    font:600 12px 'Inter',sans-serif;padding:6px 12px;border-radius:9px;cursor:pointer;transition:.15s;white-space:nowrap;line-height:1.4}
.fee-report .fr-up:hover{background:var(--brand);color:#fff;border-color:var(--brand)}
.fee-report .fr-up.solid{background:var(--brand);color:#fff;border-color:var(--brand)}
.fee-report .fr-up.solid:hover{background:var(--brand-d)}

/* totals row */
.fee-report table.fr-tbl tfoot td{padding:14px 16px;background:#FAFBFC;border-top:2px solid var(--line);font-weight:700;color:var(--ink)}
.fee-report table.fr-tbl tfoot .lbl{font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:var(--faint);font-weight:600}
.fee-report table.fr-tbl tfoot .fr-amt{font-size:14px}

/* callout */
.fee-report .fr-note{display:flex;gap:12px;align-items:flex-start;margin-top:16px;padding:14px 16px;
    background:#F6F7FB;border:1px solid var(--line);border-radius:12px;font-size:12.5px;color:var(--muted);line-height:1.55}
.fee-report .fr-note .ic{flex:0 0 28px;height:28px;width:28px;border-radius:8px;background:#EEF0FB;color:var(--brand);
    display:flex;align-items:center;justify-content:center;font-size:13px}
.fee-report .fr-note b{color:var(--ink);font-weight:600}

@media(max-width:760px){
    .fee-report .fr-title{font-size:23px}
    .fee-report .fr-outstanding .amt{font-size:27px}
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
var PROOF_MONTH = null, PROOF_YEAR = null;

$(document).on('click', '.upload-proof-btn', function () {
    PROOF_MONTH = $(this).data('month');
    PROOF_YEAR  = $(this).data('year');
    $('#proofFile').val('').click();   // open the picker
});

$('#proofFile').on('change', function () {
    if (!this.files.length || !PROOF_MONTH) return;

    var fd = new FormData();
    fd.append('month', PROOF_MONTH);
    fd.append('year', PROOF_YEAR);
    fd.append('proof', this.files[0]);

    $.ajax({
        url: '{{ route('fees.upload-proof') }}',
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        beforeSend: function () {
            Swal.fire({ title: 'Uploading...', didOpen: function(){ Swal.showLoading(); }, allowOutsideClick: false });
        },
        success: function (res) {
            Swal.fire('Uploaded', res.message, 'success').then(function () { location.reload(); });
        },
        error: function (xhr) {
            var msg = (xhr.responseJSON && (xhr.responseJSON.message || (xhr.responseJSON.errors && Object.values(xhr.responseJSON.errors).flat().join('\n')))) || 'Could not upload.';
            Swal.fire('Error', msg, 'error');
        }
    });
});
</script>
@stop