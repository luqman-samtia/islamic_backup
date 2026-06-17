@extends('adminlte::page')

@section('title', 'Admission Form')

@section('content_header')
@stop

@section('content')
@php
    $parts   = preg_split('/\s+/', trim($form->student_name));
    $aeIni   = strtoupper(substr($parts[0] ?? '', 0, 1) . substr($parts[1] ?? '', 0, 1)) ?: '–';
    $aePal   = ['#6366F1','#0EA5A4','#F59E0B','#EC4899','#10B981','#3B82F6','#8B5CF6','#EF4444','#14B8A6','#F97316'];
    $aeColor = $aePal[abs(crc32($form->student_name)) % count($aePal)];
@endphp

<div class="adm-form">

    {{-- ============ HEADER ============ --}}
    <div class="ae-head">
        <span class="ae-av" style="background:{{ $aeColor }}">{{ $aeIni }}</span>
        <div>
            <p class="ae-eyebrow">Administration · Admission Form</p>
            <h1 class="ae-title">{{ $form->student_name }}</h1>
            <p class="ae-sub">Review and update this student's admission details.</p>
        </div>
    </div>

    <form id="admissionEditForm" enctype="multipart/form-data">
        <div class="ae-grid">

            {{-- ===== DETAILS ===== --}}
            <div class="ae-card">
                <div class="ae-cardhd">Student Details</div>
                <div class="ae-cardbd">
                    <div class="ae-fields">
                        <div class="ae-fld">
                            <label class="ae-lbl">Student Name <span class="req">*</span></label>
                            <input type="text" name="student_name" class="form-control" value="{{ $form->student_name }}" required>
                        </div>
                        <div class="ae-fld">
                            <label class="ae-lbl">Roll No</label>
                            <input type="text" name="roll_no" class="form-control" value="{{ $form->roll_no }}" placeholder="Assigned by admin">
                        </div>
                        <div class="ae-fld">
                            <label class="ae-lbl">Father Name</label>
                            <input type="text" name="father_name" class="form-control" value="{{ $form->father_name }}">
                        </div>
                        <div class="ae-fld">
                            <label class="ae-lbl">Course</label>
                            <input type="text" name="course" class="form-control" value="{{ $form->course }}">
                        </div>
                        <div class="ae-fld">
                            <label class="ae-lbl">Phone No</label>
                            <input type="text" name="phone_no" class="form-control" value="{{ $form->phone_no }}">
                        </div>
                        <div class="ae-fld">
                            <label class="ae-lbl">Admission Date</label>
                            <input type="date" name="admission_date" class="form-control"
                                   value="{{ $form->admission_date ? \Carbon\Carbon::parse($form->admission_date)->format('Y-m-d') : '' }}">
                        </div>
                        <div class="ae-fld">
                            <label class="ae-lbl">Age</label>
                            <input type="text" name="age" class="form-control" value="{{ $form->age }}">
                        </div>
                        <div class="ae-fld">
                            <label class="ae-lbl">Fee</label>
                            <input type="text" name="fee" class="form-control" value="{{ $form->fee }}" placeholder="Assigned by admin">
                        </div>
                        <div class="ae-fld full">
                            <label class="ae-lbl">Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ $form->address }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="ae-cardft">
                    <button type="submit" class="ae-save"><i class="fa fa-save"></i> Update</button>
                    <a href="{{ route('admin.admission.index') }}" class="ae-back"><i class="fa fa-arrow-left"></i> Back</a>
                </div>
            </div>

            {{-- ===== PHOTO + META ===== --}}
            <div class="ae-card">
                <div class="ae-cardhd">Photo</div>
                <div class="ae-cardbd">
                    <div class="ae-photo">
                        <img id="aePreview" src="{{ $form->pic ? asset('storage/'.$form->pic) : '' }}"
                             alt="photo" style="{{ $form->pic ? '' : 'display:none' }}">
                        <span id="aePlaceholder" class="ae-photo-ph" style="background:{{ $aeColor }};{{ $form->pic ? 'display:none' : '' }}">{{ $aeIni }}</span>
                    </div>

                    <label class="ae-upload" title="Upload a new photo">
                        <i class="fa fa-upload"></i> <span id="aeUploadText">Change photo</span>
                        <input type="file" id="aePic" name="pic" accept="image/*" style="display:none">
                    </label>

                    <div class="ae-meta">
                        <div class="ae-meta-row">
                            <i class="fa fa-envelope-o"></i>
                            <div>
                                <div class="k">Login Email</div>
                                <div class="v">{{ optional($form->user)->email ?: '—' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
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

.adm-form{
    --ink:#161A22;--muted:#6B7280;--faint:#9AA1AD;--line:#E9EBF0;--surface:#FFFFFF;
    --brand:#4F46E5;--brand-d:#4338CA;--soft:#F4F6FA;--bad:#BE123C;
    color:var(--ink);font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;-webkit-font-smoothing:antialiased;
}
.adm-form *{box-sizing:border-box}

/* header */
.adm-form .ae-head{display:flex;align-items:center;gap:14px;margin-bottom:22px}
.adm-form .ae-av{flex:0 0 48px;height:48px;width:48px;border-radius:14px;color:#fff;font-weight:700;font-size:17px;
    display:flex;align-items:center;justify-content:center;letter-spacing:.02em}
.adm-form .ae-eyebrow{font-size:11px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;color:var(--brand);margin:0 0 4px}
.adm-form .ae-title{font-size:25px;font-weight:800;letter-spacing:-.02em;margin:0;line-height:1.05;color:var(--ink)}
.adm-form .ae-sub{margin:4px 0 0;color:var(--muted);font-size:13px}

/* layout */
.adm-form .ae-grid{display:grid;grid-template-columns:1fr 340px;gap:18px;align-items:start}
.adm-form .ae-card{background:var(--surface);border:1px solid var(--line);border-radius:18px;box-shadow:0 1px 3px rgba(16,24,40,.05);overflow:hidden}
.adm-form .ae-cardhd{padding:15px 22px;border-bottom:1px solid var(--line);font-size:14px;font-weight:700;letter-spacing:-.01em;color:var(--ink)}
.adm-form .ae-cardbd{padding:20px 22px}

/* fields */
.adm-form .ae-fields{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.adm-form .ae-fld{display:flex;flex-direction:column;gap:6px;min-width:0}
.adm-form .ae-fld.full{grid-column:span 2}
.adm-form .ae-lbl{font-size:11.5px;font-weight:600;letter-spacing:.03em;text-transform:uppercase;color:var(--faint)}
.adm-form .ae-lbl .req{color:var(--bad);margin-left:2px}
.adm-form .form-control{height:auto;border:1px solid var(--line);border-radius:10px;padding:9px 12px;
    font:500 13.5px 'Inter',sans-serif;color:var(--ink);background:#fff;box-shadow:none;width:100%;transition:.15s}
.adm-form .form-control::placeholder{color:#B8BEC9}
.adm-form .form-control:focus{border-color:var(--brand);box-shadow:0 0 0 3px rgba(79,70,229,.15);outline:none}
.adm-form textarea.form-control{resize:vertical;min-height:64px}

/* footer */
.adm-form .ae-cardft{padding:16px 22px;border-top:1px solid var(--line);background:#FCFCFD;display:flex;gap:10px;flex-wrap:wrap}
.adm-form .ae-save{display:inline-flex;align-items:center;gap:8px;background:var(--brand);color:#fff;border:none;
    font:600 13.5px 'Inter',sans-serif;padding:10px 18px;border-radius:10px;cursor:pointer;transition:.15s}
.adm-form .ae-save:hover{background:var(--brand-d)}
.adm-form .ae-save:active{transform:translateY(1px)}
.adm-form .ae-back{display:inline-flex;align-items:center;gap:7px;border:1px solid var(--line);background:#fff;color:var(--muted);
    font:600 13px 'Inter',sans-serif;padding:10px 16px;border-radius:10px;text-decoration:none;transition:.15s}
.adm-form .ae-back:hover{border-color:#cfd3dc;color:var(--ink)}

/* photo */
.adm-form .ae-photo{aspect-ratio:4/5;border-radius:14px;background:var(--soft);border:1px solid var(--line);
    overflow:hidden;display:flex;align-items:center;justify-content:center;margin-bottom:14px}
.adm-form .ae-photo img{width:100%;height:100%;object-fit:cover;display:block}
.adm-form .ae-photo-ph{height:90px;width:90px;border-radius:50%;display:flex;align-items:center;justify-content:center;
    color:#fff;font-weight:700;font-size:38px;letter-spacing:.02em}
.adm-form .ae-upload{display:flex;align-items:center;justify-content:center;gap:8px;width:100%;border:1px dashed #C7CCDA;
    background:#fff;color:var(--brand-d);font:600 13px 'Inter',sans-serif;padding:10px;border-radius:10px;cursor:pointer;transition:.15s;margin:0}
.adm-form .ae-upload:hover{background:#F5F6FF;border-color:var(--brand)}

/* meta */
.adm-form .ae-meta{margin-top:16px;border-top:1px solid var(--line);padding-top:14px}
.adm-form .ae-meta-row{display:flex;align-items:flex-start;gap:10px}
.adm-form .ae-meta-row i{color:var(--faint);font-size:14px;margin-top:2px}
.adm-form .ae-meta .k{color:var(--faint);font-weight:600;font-size:10.5px;text-transform:uppercase;letter-spacing:.04em;margin-bottom:1px}
.adm-form .ae-meta .v{color:var(--ink);font-weight:500;font-size:13px;word-break:break-all}

@media(max-width:860px){
    .adm-form .ae-grid{grid-template-columns:1fr}
}
@media(max-width:520px){
    .adm-form .ae-fields{grid-template-columns:1fr}
    .adm-form .ae-fld.full{grid-column:span 1}
    .adm-form .ae-title{font-size:21px}
}
</style>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Live preview of a newly selected photo
$('#aePic').on('change', function () {
    var f = this.files && this.files[0];
    if (!f) return;
    var reader = new FileReader();
    reader.onload = function (e) {
        $('#aePreview').attr('src', e.target.result).show();
        $('#aePlaceholder').hide();
        $('#aeUploadText').text('Change photo');
    };
    reader.readAsDataURL(f);
});

$('#admissionEditForm').on('submit', function (e) {
    e.preventDefault();
    var fd = new FormData(this);
    $.ajax({
        url: '{{ route('admin.admission.update', $form->id) }}',
        method: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        success: function (res) {
            Swal.fire('Success', res.message, 'success').then(function(){ location.reload(); });
        },
        error: function (xhr) {
            var msg = 'Something went wrong.';
            if (xhr.status === 422) msg = Object.values(xhr.responseJSON.errors).flat().join('\n');
            Swal.fire('Error', msg, 'error');
        }
    });
});
</script>
@stop