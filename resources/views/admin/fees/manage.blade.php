@extends('adminlte::page')

@section('title', 'Manage Fee')

@section('content_header')
    <h1>Fee Sheet — {{ $student->name }}</h1>
@stop

@section('content')
<div class="box box-primary">
    <div class="box-header with-border">
        <form method="GET" class="form-inline" action="{{ route('admin.fees.manage', $student->id) }}">
            <label>Year:&nbsp;</label>
            <select name="year" class="form-control" onchange="this.form.submit()">
                @foreach($years as $y)
                    <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
            <a href="{{ route('admin.fees.index') }}" class="btn btn-default pull-right">Back to list</a>
        </form>
    </div>

    <form id="feeForm">
        <input type="hidden" name="user_id" value="{{ $student->id }}">
        <input type="hidden" name="year" value="{{ $year }}">
        <div class="box-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="bg-gray">
                        <th style="width:50px">#</th>
                        <th>Month</th>
                        <th>Monthly Fee</th>
                        <th>Received</th>
                        <th>Outstanding</th>
                        <th>Date</th>
                        <th>Proof</th>
                        <th style="width:130px">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rows as $i => $row)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td><b>{{ $row['month_name'] }}</b></td>
                        <td>
                            <input type="number" step="0.01" class="form-control monthly-fee"
                                   name="months[{{ $row['month'] }}][monthly_fee]" value="{{ $row['monthly_fee'] }}">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control received"
                                   name="months[{{ $row['month'] }}][received]" value="{{ $row['received'] }}">
                        </td>
                        <td>
                            <input type="number" step="0.01" class="form-control outstanding"
                                   name="months[{{ $row['month'] }}][outstanding]" value="{{ $row['outstanding'] }}" readonly>
                        </td>
                        <td>
                            <input type="date" class="form-control"
                                   name="months[{{ $row['month'] }}][paid_date]"
                                   value="{{ $row['paid_date'] ? \Carbon\Carbon::parse($row['paid_date'])->format('Y-m-d') : '' }}">
                        </td>
                        <td class="text-center">
                            @if($row['proof'])
                                <a href="{{ asset('storage/' . $row['proof']) }}" target="_blank" title="View payment proof">
                                    <img src="{{ asset('storage/' . $row['proof']) }}" alt="proof"
                                         style="height:40px;width:auto;border:1px solid #ddd;border-radius:3px">
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
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
                    <tr class="bg-gray">
                        <th colspan="2">Total</th>
                        <th id="totalFee">0</th>
                        <th id="totalReceived">0</th>
                        <th id="totalOutstanding">0</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="box-footer">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save Fee Sheet</button>
        </div>
    </form>
</div>
@stop

@section('css')
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function recalc() {
    var tf = 0, tr = 0, to = 0;
    $('#feeForm tbody tr').each(function () {
        var fee = parseFloat($(this).find('.monthly-fee').val()) || 0;
        var rec = parseFloat($(this).find('.received').val()) || 0;
        var out = Math.max(fee - rec, 0);
        $(this).find('.outstanding').val(out.toFixed(2));
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
