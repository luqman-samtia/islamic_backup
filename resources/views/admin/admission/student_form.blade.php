@extends('adminlte::page')

@section('title', 'My Admission Form')

@section('content_header')
@stop

@section('content')
@php
    $displayName = $form->student_name ?? $user->name;
    $parts   = preg_split('/\s+/', trim($displayName));
    $maIni   = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? '', 0, 1)) ?: '–';
    $maPal   = ['#6366F1','#0EA5A4','#F59E0B','#EC4899','#10B981','#3B82F6','#8B5CF6','#EF4444','#14B8A6','#F97316'];
    $maColor = $maPal[abs(crc32($displayName)) % count($maPal)];
    $hasPic  = isset($form) && $form->pic;
    $rollNo  = $form->roll_no ?? null;
    $feeVal  = $form->fee ?? null;

    // Form pehle se submit ho chuka hai? to locked (student edit nahi kar sakta)
    $isLocked = isset($form) && $form->exists;
@endphp

<div class="my-adm">

    {{-- ============ HEADER ============ --}}
    <div class="ma-head">
        <span class="ma-av" style="background:{{ $maColor }}">{{ $maIni }}</span>
        <div>
            <p class="ma-eyebrow">Admission</p>
            <h1 class="ma-title">My Admission Form</h1>
            <p class="ma-sub">
                @if($isLocked)
                    Your form has been submitted. It is now locked — contact the admin for any changes.
                @else
                    Fill in your details. Roll No and Fee are assigned by the admin. You can submit only once.
                @endif
            </p>
        </div>
    </div>

    @if($isLocked)
        <div class="ma-locked-banner">
            <i class="fa fa-lock"></i>
            <span>This form is submitted and locked. You cannot edit it. Please contact the admin if you need to make changes.</span>
        </div>
    @endif

    <form id="myAdmissionForm" enctype="multipart/form-data">
        <fieldset {{ $isLocked ? 'disabled' : '' }} style="border:none;padding:0;margin:0;min-width:0;">
        <div class="ma-grid">

            {{-- ===== DETAILS ===== --}}
            <div class="ma-card">
                <div class="ma-cardhd">Your Details</div>
                <div class="ma-cardbd">
                    <div class="ma-fields">
                        <div class="ma-fld">
                            <label class="ma-lbl">Student Name <span class="req">*</span></label>
                            <input type="text" name="student_name" class="form-control" value="{{ $form->student_name ?? $user->name }}" required>
                        </div>
                        <div class="ma-fld">
                            <label class="ma-lbl">Father Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ $form->father_name ?? '' }}">
                        </div>
                        <div class="ma-fld">
                            <label class="ma-lbl">Course</label>
                            <input type="text" name="course" class="form-control" value="{{ $form->course ?? '' }}">
                        </div>
                        <div class="ma-fld">
                            <label class="ma-lbl">Phone No</label>
                            <input type="text" name="phone_no" class="form-control" value="{{ $form->phone_no ?? $user->contact_no }}">
                        </div>
                        <div class="ma-fld">
                            <label class="ma-lbl">Age</label>
                            <input type="text" name="age" class="form-control" value="{{ $form->age ?? '' }}">
                        </div>
                        <div class="ma-fld">
                            <label class="ma-lbl">Admission Date</label>
                            <input type="date" name="admission_date" class="form-control"
                                   value="{{ isset($form->admission_date) ? \Carbon\Carbon::parse($form->admission_date)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="ma-fld full">
                            <label class="ma-lbl">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ $form->address ?? '' }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="ma-cardft">
                    @if($isLocked)
                        <span class="ma-hint"><i class="fa fa-lock"></i> Your form is submitted and locked. Contact the admin for any changes.</span>
                    @else
                        <button type="submit" class="ma-save"><i class="fa fa-save"></i> Save My Form</button>
                        <span class="ma-hint"><i class="fa fa-info-circle"></i> Fields marked * are required.</span>
                    @endif
                </div>
            </div>

            {{-- ===== PHOTO + ASSIGNED INFO ===== --}}
            <div class="ma-card">
                <div class="ma-cardhd">My Photo</div>
                <div class="ma-cardbd">
                    <div class="ma-photo">
                        <img id="maPreview" src="{{ $hasPic ? asset('storage/'.$form->pic) : '' }}"
                             alt="photo" style="{{ $hasPic ? '' : 'display:none' }}">
                        <span id="maPlaceholder" class="ma-photo-ph" style="background:{{ $maColor }};{{ $hasPic ? 'display:none' : '' }}">{{ $maIni }}</span>
                    </div>

                    @if(!$isLocked)
                        <label class="ma-upload" title="Upload a photo">
                            <i class="fa fa-upload"></i> <span>{{ $hasPic ? 'Change photo' : 'Upload photo' }}</span>
                            <input type="file" id="maPic" name="pic" accept="image/*" style="display:none">
                        </label>
                        <p class="ma-uploadnote">JPG or PNG, a clear front-facing photo works best.</p>
                    @endif

                    <div class="ma-assigned">
                        <p class="ma-assigned-hd">Assigned by admin</p>
                        <div class="ma-fact">
                            <span class="k">Roll No</span>
                            <span class="v {{ $rollNo ? '' : 'pending' }}">{{ $rollNo ?: 'Not assigned yet' }}</span>
                        </div>
                        <div class="ma-fact">
                            <span class="k">Fee</span>
                            <span class="v {{ $feeVal ? '' : 'pending' }}">{{ $feeVal !== null && $feeVal !== '' ? 'Rs '.number_format((float)$feeVal, 0) : 'Not assigned yet' }}</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        </fieldset>
    </form>

</div>
@stop

@section('css')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
.content-header{padding-top:10px}

.my-adm{
    --ink:#161A22;--muted:#6B7280;--faint:#9AA1AD;--line:#E9EBF0;--surface:#FFFFFF;
    --brand:#4F46E5;--brand-d:#4338CA;--soft:#F4F6FA;--bad:#BE123C;--warn:#B45309;--warn-bg:#FFFBEB;--warn-br:#FDE68A;
    color:var(--ink);font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;-webkit-font-smoothing:antialiased;
}
.my-adm *{box-sizing:border-box}

/* header */
.my-adm .ma-head{display:flex;align-items:center;gap:14px;margin-bottom:22px}
.my-adm .ma-av{flex:0 0 48px;height:48px;width:48px;border-radius:14px;color:#fff;font-weight:700;font-size:17px;
    display:flex;align-items:center;justify-content:center;letter-spacing:.02em}
.my-adm .ma-eyebrow{font-size:11px;font-weight:700;letter-spacing:.16em;text-transform:uppercase;color:var(--brand);margin:0 0 4px}
.my-adm .ma-title{font-size:25px;font-weight:800;letter-spacing:-.02em;margin:0;line-height:1.05;color:var(--ink)}
.my-adm .ma-sub{margin:4px 0 0;color:var(--muted);font-size:13px}

/* locked banner */
.my-adm .ma-locked-banner{display:flex;align-items:center;gap:10px;background:var(--warn-bg);border:1px solid var(--warn-br);
    color:var(--warn);font-size:13px;font-weight:600;padding:11px 16px;border-radius:12px;margin-bottom:18px}
.my-adm .ma-locked-banner i{font-size:15px}

/* layout */
.my-adm .ma-grid{display:grid;grid-template-columns:1fr 340px;gap:18px;align-items:start}
.my-adm .ma-card{background:var(--surface);border:1px solid var(--line);border-radius:18px;box-shadow:0 1px 3px rgba(16,24,40,.05);overflow:hidden}
.my-adm .ma-cardhd{padding:15px 22px;border-bottom:1px solid var(--line);font-size:14px;font-weight:700;letter-spacing:-.01em;color:var(--ink)}
.my-adm .ma-cardbd{padding:20px 22px}

/* fields */
.my-adm .ma-fields{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.my-adm .ma-fld{display:flex;flex-direction:column;gap:6px;min-width:0}
.my-adm .ma-fld.full{grid-column:span 2}
.my-adm .ma-lbl{font-size:11.5px;font-weight:600;letter-spacing:.03em;text-transform:uppercase;color:var(--faint)}
.my-adm .ma-lbl .req{color:var(--bad);margin-left:2px}
.my-adm .form-control{height:auto;border:1px solid var(--line);border-radius:10px;padding:9px 12px;
    font:500 13.5px 'Inter',sans-serif;color:var(--ink);background:#fff;box-shadow:none;width:100%;transition:.15s}
.my-adm .form-control::placeholder{color:#B8BEC9}
.my-adm .form-control:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(79,70,229,.15);outline:none}
.my-adm textarea.form-control{resize:vertical;min-height:64px}
/* disabled (locked) look */
.my-adm fieldset:disabled .form-control{background:#F6F7F9;color:#7A828E;cursor:not-allowed}

/* footer */
.my-adm .ma-cardft{padding:16px 22px;border-top:1px solid var(--line);background:#FCFCFD;display:flex;align-items:center;gap:14px;flex-wrap:wrap}
.my-adm .ma-save{display:inline-flex;align-items:center;gap:8px;background:var(--brand);color:#fff;border:none;
    font:600 13.5px 'Inter',sans-serif;padding:10px 18px;border-radius:10px;cursor:pointer;transition:.15s}
.my-adm .ma-save:hover{background:var(--brand-d)}
.my-adm .ma-save:active{transform:translateY(1px)}
.my-adm .ma-hint{font-size:12.5px;color:var(--faint)}
.my-adm .ma-hint i{margin-right:4px}

/* photo */
.my-adm .ma-photo{aspect-ratio:4/5;border-radius:14px;background:var(--soft);border:1px solid var(--line);
    overflow:hidden;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
.my-adm .ma-photo img{width:100%;height:100%;object-fit:cover;display:block}
.my-adm .ma-photo-ph{height:90px;width:90px;border-radius:50%;display:flex;align-items:center;justify-content:center;
    color:#fff;font-weight:700;font-size:38px;letter-spacing:.02em}
.my-adm .ma-upload{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;border:1px dashed #C7CCDA;
    background:#fff;color:var(--brand-d);font:600 13px 'Inter',sans-serif;padding:10px;border-radius:10px;cursor:pointer;transition:.15s;margin:0}
.my-adm .ma-upload:hover{background:#F5F6FF;border-color:var(--brand)}
.my-adm .ma-uploadnote{margin:8px 0 0;font-size:11.5px;color:var(--faint);text-align:center}

/* assigned info */
.my-adm .ma-assigned{margin-top:18px;border-top:1px solid var(--line);padding-top:14px}
.my-adm .ma-assigned-hd{margin:0 0 10px;font-size:10.5px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--faint)}
.my-adm .ma-fact{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:7px 0}
.my-adm .ma-fact + .ma-fact{border-top:1px dashed var(--line)}
.my-adm .ma-fact .k{font-size:12.5px;color:var(--muted);font-weight:500}
.my-adm .ma-fact .v{font-size:13.5px;font-weight:700;color:var(--ink);font-variant-numeric:tabular-nums}
.my-adm .ma-fact .v.pending{font-size:11.5px;font-weight:600;color:var(--warn);background:var(--warn-bg);
    border:1px solid var(--warn-br);padding:3px 9px;border-radius:99px}

@media(max-width:860px){
    .my-adm .ma-grid{grid-template-columns:1fr}
}
@media(max-width:520px){
    .my-adm .ma-fields{grid-template-columns:1fr}
    .my-adm .ma-fld.full{grid-column:span 1}
    .my-adm .ma-title{font-size:21px}
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Live preview of a newly selected photo
$('#maPic').on('change', function () {
    var f = this.files && this.files[0];
    if (!f) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#maPreview').attr('src', e.target.result).show();
        $('#maPlaceholder').hide();
    };
    reader.readAsDataURL(f);
});

$('#myAdmissionForm').on('submit', function (e) {
    e.preventDefault();
    var form = this;

    // Confirm before final submit — student ko clearly bata dein ke edit nahi hoga
    Swal.fire({
        title: 'Submit your admission form?',
        html: 'Please double-check all your details.<br><br>' +
              '<b>Once submitted, you will not be able to edit this form.</b><br>' +
              'For any changes afterwards, you will need to contact the admin.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#4F46E5',
        cancelButtonColor: '#6B7280',
        confirmButtonText: 'Yes, submit it',
        cancelButtonText: 'Review again',
        reverseButtons: true
    }).then(function (result) {
        if (!result.isConfirmed) return;

        var fd = new FormData(form);
        $.ajax({
            url: '{{ route('admission.my-form.store') }}',
            method: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            beforeSend: function(){ Swal.fire({title:'Submitting...', didOpen:()=>Swal.showLoading(), allowOutsideClick:false}); },
            success: function (res) {
                Swal.fire('Submitted!', (res.message || 'Your admission form has been submitted and is now locked.'), 'success')
                    .then(function(){ location.reload(); });
            },
            error: function (xhr) {
                var msg = 'Something went wrong.';
                if (xhr.status === 422) msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
                else if (xhr.status === 403 && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
                Swal.fire('Error', msg, 'error');
            }
        });
    });
});
</script>
@stop