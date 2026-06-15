@extends('adminlte::page')

@section('title', 'My Fee Report')

@section('content_header')
    <h1>My Fee Report</h1>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <form method="GET" class="form-inline" action="{{ route('fees.my-report') }}">
            <label>Year:&nbsp;</label>
            <select name="year" class="form-control" onchange="this.form.submit()">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <div class="box-body table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr class="bg-gray">
                    <th>#</th>
                    <th>Month</th>
                    <th>Monthly Fee</th>
                    <th>Received</th>
                    <th>Outstanding</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Payment Proof</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rows as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><b>{{ $row['month_name'] }}</b></td>
                    <td>{{ number_format($row['monthly_fee'], 0) }}</td>
                    <td>{{ number_format($row['received'], 0) }}</td>
                    <td>
                        @if($row['outstanding'] > 0)
                            <span class="label label-danger">{{ number_format($row['outstanding'], 0) }}</span>
                        @else
                            <span class="label label-success">0</span>
                        @endif
                    </td>
                    <td>{{ $row['paid_date'] ? \Carbon\Carbon::parse($row['paid_date'])->format('d-M-Y') : '—' }}</td>
                    <td>
                        @if($row['status'] === 'received')
                            <span class="label label-success"><i class="fa fa-check"></i> Received</span>
                        @elseif($row['status'] === 'rejected')
                            <span class="label label-danger">Rejected</span>
                        @elseif($row['proof'])
                            <span class="label label-warning">Pending Review</span>
                        @else
                            <span class="label label-default">Not Submitted</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($row['proof'])
                            <a href="{{ asset('storage/' . $row['proof']) }}" target="_blank">
                                <img src="{{ asset('storage/' . $row['proof']) }}" alt="proof"
                                     style="height:38px;width:auto;border:1px solid #ddd;border-radius:3px">
                            </a>
                        @endif
                        @if($row['status'] !== 'received')
                            <button class="btn btn-xs btn-primary upload-proof-btn"
                                    data-month="{{ $row['month'] }}" data-year="{{ $year }}">
                                <i class="fa fa-upload"></i> {{ $row['proof'] ? 'Re-upload' : 'Upload' }}
                            </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="bg-gray">
                    <th colspan="2">Total</th>
                    <th>{{ number_format($totalFee, 0) }}</th>
                    <th>{{ number_format($totalReceived, 0) }}</th>
                    <th>{{ number_format($totalOutstanding, 0) }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        <small class="text-muted">
            <i class="fa fa-info-circle"></i>
            Apni fee jama karwa kar uski transaction screenshot upload karein.
            Admin verify kar ke status <b>Received</b> kar dega.
        </small>
    </div>
</div>

{{-- hidden file input used by all upload buttons --}}
<input type="file" id="proofFile" accept="image/*" style="display:none">
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
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
