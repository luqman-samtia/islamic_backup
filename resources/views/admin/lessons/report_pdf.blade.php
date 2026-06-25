<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
    * { font-family: 'amiri', sans-serif; }
    body { color: #2d3748; font-size: 16px; margin: 0; }

    .academy-header {
        text-align: center;
        margin-bottom: 14px;
        padding-bottom: 10px;
    }
    .academy-header img { height: 60px; margin-bottom: 6px; }
    .academy-header .academy-name {
        font-size: 20px; font-weight: bold; color: #1a202c; margin: 2px 0;
    }
    .academy-header .academy-contact {
        font-size: 14px; color: #718096; margin-top: 3px;
    }

    .header { border-bottom: 3px solid #2c7be5; padding-bottom: 12px; margin-bottom: 18px; }
    .header h1 { margin: 0; font-size: 22px; color: #1a202c; }
    .header .sub { color: #718096; font-size: 16px; margin-top: 4px; font-weight: bold; }

    .meta-table { width: 100%; margin-bottom: 16px; border-collapse: collapse; }
    .meta-table td { padding: 4px 8px; font-size: 16px; }
    .meta-table .lbl { color: #718096; width: 90px; font-weight: bold; }
    .meta-table .val { color: #1a202c; font-weight: bold; }

    /* per-type section */
    .type-section { margin-bottom: 20px; }
    .type-title {
        background: #ebf4ff; color: #2c7be5; font-weight: bold; font-size: 12px;
        padding: 6px 10px; border-radius: 4px; margin-bottom: 6px;
    }

    table.data { width: 100%; border-collapse: collapse; }
    table.data thead th {
        background: #2d3748; color: #fff; padding: 7px 6px; text-align: left;
        font-size: 11px; text-transform: uppercase; letter-spacing: .3px;
        font-weight: bold; border: 1px solid #2d3748;
    }
   table.data tbody td {
        padding: 8px 6px; border: 1px solid #cbd5e0; font-size: 13px; font-weight: bold; vertical-align: top;
    }
    table.data tbody tr:nth-child(even) { background: #f7fafc; }
    .muted { color: #a0aec0; }
    .footer {
        position: fixed; bottom: 0; left: 0; right: 0; text-align: center;
        color: #a0aec0; font-size: 14px; padding: 6px 0; border-top: 1px solid #e2e8f0;
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

    @php
        // $cellVal = function ($r, $key) {
        //     $v = $r->{$key} ?? null;
        //     if ($key === 'lesson_date') {
        //         return $v ? \Carbon\Carbon::parse($v)->format('d-M-Y') : '';
        //     }
        //     return $v;
        // };
        // $cellVal = function ($r, $key) {
        //     $v = $r->{$key} ?? null;
        //     if (($v === null || $v === '') && !empty($r->extra) && is_array($r->extra)) {
        //         $v = $r->extra[$key] ?? null;
        //     }
        //     if ($key === 'lesson_date') {
        //         return $v ? \Carbon\Carbon::parse($v)->format('d-M-Y') : '';
        //     }
        //     return $v;
        // };
        $cellVal = function ($r, $key) {
        $v = $r->{$key} ?? null;
        if (($v === null || $v === '') && !empty($r->extra) && is_array($r->extra)) {
            $v = $r->extra[$key] ?? null;
        }
        if ($key === 'lesson_date') {
            return $v ? \Carbon\Carbon::parse($v)->format('d-M-Y') : '';
        }
        return $v;
    };

    $rtlKeys = ['para_name', 'surah_name'];

    @endphp

    @forelse($grouped as $type => $g)
        <div class="type-section">
            <div class="type-title">{{ $typeLabels[$type] ?? ucfirst($type) }} ({{ $g['records']->count() }})</div>
            <table class="data" style="width:100%;">
                 @php
                    $dataCount = max(count($g['columns']), 1);
                    $colW = round(94 / $dataCount, 2); 
                @endphp
                <thead>
                    <tr>
                        <th style="width:6%;">#</th>
                       @foreach($g['columns'] as $col)
                            <th style="width: {{ $colW }}%;">{{ $col['label'] }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @forelse($g['records'] as $i => $r)
                    <tr>
                        <td class="muted" style="width:6%;">{{ $i + 1 }}</td>
                        {{-- <td>
                            <div class="student-cell">
                                <span class="avatar">{{ strtoupper(substr(optional($r->user)->name ?? '?', 0, 1)) }}</span>
                                <span>{{ optional($r->user)->name }}</span>
                            </div>
                        </td> --}}
                        {{-- @foreach($g['columns'] as $col)
                            @php
                                $key = $col['key'];
                                $val = $cellVal($r, $key);
                                $att = ($key === 'attendance') ? strtolower(trim($val ?? '')) : null;
                            @endphp
                            <td class="{{ $key === 'notes' ? 'notes-cell' : '' }}">
                                @if($key === 'attendance')
                                    @if($att)
                                        <span class="pill {{ str_contains($att,'present') || str_contains($att,'haz') ? 'pill-green' : (str_contains($att,'absent') || str_contains($att,'ghair') ? 'pill-red' : 'pill-gray') }}">
                                            {{ $val }}
                                        </span>
                                    @else <span class="muted">—</span> @endif
                                @elseif($key === 'lesson_date')
                                    {{ $val ?: '—' }}
                                    @if($r->day)<br><small class="muted">{{ $r->day }}</small>@endif
                                @else
                                    {{ ($val !== null && $val !== '') ? $val : '—' }}
                                @endif
                            </td>
                        @endforeach --}}
                    @foreach($g['columns'] as $col)
                        @php
                            $key = $col['key'];
                            $val = $cellVal($r, $key);
                            $att = ($key === 'attendance') ? strtolower(trim($val ?? '')) : null;
                            $isRtl = in_array($key, $rtlKeys);
                        @endphp
                        <td @if($isRtl) dir="rtl" lang="ar" style="font-size: 12px;width: {{ $colW }}%;" @endif class="{{ $key === 'notes' ? 'notes-cell' : '' }}">
                            @if($key === 'attendance')
                                @if($att)
                                    <span class="pill {{ str_contains($att,'present') || str_contains($att,'haz') ? 'pill-green' : (str_contains($att,'absent') || str_contains($att,'ghair') ? 'pill-red' : 'pill-gray') }}">
                                        {{ $val }}
                                    </span>
                                @else <span class="muted">—</span> @endif
                            @elseif($key === 'lesson_date')
                                {{ $val ?: '—' }}
                                @if($r->day)<br><small class="muted">{{ $r->day }}</small>@endif
                            @else
                                {{ ($val !== null && $val !== '') ? $val : '—' }}
                            @endif
                        </td>
                    @endforeach
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ count($g['columns']) + 1 }}" class="empty-state">
                            <i class="fa fa-inbox"></i><br>No lessons found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @empty
        <table class="data">
            <tbody>
                <tr><td class="empty">No lessons found for this period.</td></tr>
            </tbody>
        </table>
    @endforelse

    <div class="footer">
        {{ $student->name }} — {{ $period }} | Taleem-ul-Quran Institute
    </div>
</body>
</html>