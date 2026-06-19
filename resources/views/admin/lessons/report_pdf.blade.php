<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    * { font-family: DejaVu Sans, sans-serif; }
    body { color: #2d3748; font-size: 11px; margin: 0; }

    .academy-header {
        text-align: center;
        margin-bottom: 14px;
        padding-bottom: 10px;
    }
    .academy-header img {
        height: 60px;
        margin-bottom: 6px;
    }
    .academy-header .academy-name {
        font-size: 18px;
        font-weight: bold;
        color: #1a202c;
        margin: 2px 0;
    }
    .academy-header .academy-contact {
        font-size: 10px;
        color: #718096;
        margin-top: 3px;
    }

    .header {
        border-bottom: 3px solid #2c7be5; padding-bottom: 12px; margin-bottom: 18px;
    }
    .header h1 { margin: 0; font-size: 20px; color: #1a202c; }
    .header .sub { color: #718096; font-size: 12px; margin-top: 4px; }
    .meta-table { width: 100%; margin-bottom: 16px; border-collapse: collapse; }
    .meta-table td { padding: 4px 8px; font-size: 11px; }
    .meta-table .lbl { color: #718096; width: 90px; }
    .meta-table .val { color: #1a202c; font-weight: bold; }
    table.data { width: 100%; border-collapse: collapse; }
    table.data thead th {
        background: #2d3748; color: #fff; padding: 7px 6px; text-align: left;
        font-size: 10px; text-transform: uppercase; letter-spacing: .3px;
        font-weight: bold; border: 1px solid #2d3748;
    }
    table.data tbody td {
        padding: 6px; border: 1px solid #cbd5e0; font-size: 10.5px; vertical-align: top;
    }
    table.data tbody tr:nth-child(even) { background: #f7fafc; }
    .badge {
        background: #ebf4ff; color: #2c7be5; padding: 2px 7px; border-radius: 10px;
        font-size: 9px; font-weight: bold;
    }
    .muted { color: #a0aec0; }
    .footer {
        position: fixed; bottom: 0; left: 0; right: 0; text-align: center;
        color: #a0aec0; font-size: 9px; padding: 6px 0; border-top: 1px solid #e2e8f0;
    }
    .empty { text-align: center; color: #a0aec0; padding: 30px; }
</style>
</head>
<body>
    <div class="academy-header">
        <img src="{{ public_path('assets/images/logo1.png') }}" alt="Logo">
        <div class="academy-name">Taleem-ul-Quran Institute</div>
        <div class="academy-contact">
             {{ optional($info)->whatsapp1['value'] ?? '' }}
            &nbsp;|&nbsp;
           {{ optional($info)->email['value'] ?? '' }}
        </div>
    </div>

    <div class="header">
        <h1>Lessons Report</h1>
        <div class="sub">Student progress sheet</div>
    </div>

    <table class="meta-table">
        <tr>
            <td class="lbl">Student:</td>
            <td class="val">{{ $student->name }}</td>
            <td class="lbl">Period:</td>
            <td class="val">{{ $period }}</td>
        </tr>
        <tr>
            <td class="lbl">Email:</td>
            <td class="val">{{ $student->email }}</td>
            <td class="lbl">Total Lessons:</td>
            <td class="val">{{ $records->count() }}</td>
        </tr>
        <tr>
            <td class="lbl">Generated:</td>
            <td class="val">{{ \Carbon\Carbon::now()->format('d-M-Y h:i A') }}</td>
            <td class="lbl">Contact:</td>
            <td class="val">{{ $student->contact_no ?? '—' }}</td>
        </tr>
    </table>

    <table class="data">
        <thead>
            <tr>
                <th style="width:24px">#</th>
                <th>Type</th>
                <th>Day &amp; Date</th>
                <th>Attendance</th>
                <th>Course</th>
                <th>Lesson</th>
                <th>Page</th>
                <th>From &rarr; To</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @forelse($records as $i => $r)
                @php
                    $lessonBits = array_filter([$r->para_name, $r->surah_name, $r->tehti_number, $r->select_lesson]);
                    $fromTo = ($r->ayat_from || $r->ayat_to)
                                ? trim(($r->ayat_from ?? '') . ' → ' . ($r->ayat_to ?? ''), ' →')
                                : trim(($r->line_from ?? '') . ' → ' . ($r->line_to ?? ''), ' →');
                @endphp
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td><span class="badge">{{ $typeLabels[$r->lesson_type] ?? ucfirst($r->lesson_type) }}</span></td>
                    <td>
                        {{ $r->day }}<br>
                        <span class="muted">{{ $r->lesson_date ? \Carbon\Carbon::parse($r->lesson_date)->format('d-M-Y') : '' }}</span>
                    </td>
                    <td>{{ $r->attendance }}</td>
                    <td>{{ $r->course }}</td>
                    <td>{{ implode(' / ', $lessonBits) ?: '—' }}</td>
                    <td>{{ $r->page_number }}</td>
                    <td>{{ $fromTo ?: '—' }}</td>
                    <td>{{ $r->notes }}</td>
                </tr>
            @empty
                <tr><td colspan="9" class="empty">No lessons found for this period.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        {{ $student->name }} — {{ $period }} | Taleem-ul-Quran Institute
    </div>
</body>
</html>