<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Result Patrol Report - {{ now()->format('Y-m-d') }}</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px 28px;
            color: #1a1a1a;
            background: #fff;
            font-size: 11px;
            line-height: 1.4;
        }

        /* ==================== HEADER ==================== */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-bottom: 3px solid #1e3a8a;
            width: 100%;
        }

        .header-left {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: left;
        }

        .company-text h1 {
            font-size: 18px;
            color: #1e3a8a;
            font-weight: bold;
            letter-spacing: 0.5px;
            line-height: 1;
            margin: 0;
        }

        .company-text p {
            font-size: 11px;
            color: #666;
            margin-top: 4px;
            line-height: 1;
            margin-bottom: 0;
        }

        .header-right {
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: right;
            font-size: 11px;
            color: #555;
        }

        .header-right strong {
            font-size: 15px;
            color: #1a1a1a;
            margin: 0;
            line-height: 1;
        }

        .header-right div {
            margin-top: 4px;
            line-height: 1;
        }

        /* ==================== TITLE ==================== */
        .report-title {
            text-align: center;
            margin: 16px 0 16px;
        }

        .report-title h2 {
            font-size: 18px;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 6px;
            border-bottom: 2px solid #e5e7eb;
            display: inline-block;
            min-width: 60%;
        }

        .report-title p {
            font-size: 11px;
            color: #6b7280;
            margin-top: 6px;
        }

        /* ==================== SUMMARY STATS ==================== */
        .summary-stats {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stat-box {
            flex: 1;
            padding: 10px 14px;
            border-radius: 6px;
            border-left: 4px solid;
            background: #f8fafc;
        }

        .stat-total   { border-left-color: #3b82f6; background: #eff6ff; }
        .stat-avg     { border-left-color: #22c55e; background: #f0fdf4; }
        .stat-overall { border-left-color: #f59e0b; background: #fffbeb; }

        .stat-label {
            font-size: 9px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .stat-value {
            font-size: 20px;
            font-weight: bold;
            line-height: 1.1;
        }
        .stat-total   .stat-value { color: #1e40af; }
        .stat-avg     .stat-value { color: #15803d; }
        .stat-overall .stat-value { color: #b45309; }

        /* ==================== TABLES ==================== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 6px 8px;
            vertical-align: top;
        }

        thead th {
            background: #1e3a8a;
            color: #fff;
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        tbody tr:nth-child(even) { background: #f9fafb; }

        /* ==================== BADGES ==================== */
        .badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
            color: #fff;
            text-align: center;
        }
        .badge-green { background: #22c55e; }

        /* ==================== PHOTOS ==================== */
        .photo {
            width: 60px;
            height: 45px;
            object-fit: cover;
            border: 1px solid #9ca3af;
            border-radius: 3px;
            display: block;
            margin-bottom: 2px;
        }

        .no-photo {
            font-size: 8px;
            color: #9ca3af;
            font-style: italic;
        }

        /* ==================== SIGNATURE ==================== */
        .signature-section {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            page-break-inside: avoid;
        }

        .signature-box {
            width: 30%;
            text-align: center;
            font-size: 11px;
        }

        .signature-box .role {
            color: #666;
            margin-bottom: 60px;
        }

        .signature-box .name {
            border-top: 1px solid #1a1a1a;
            padding-top: 4px;
            font-weight: bold;
        }

        /* ==================== FOOTER ==================== */
        .report-footer {
            margin-top: 30px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            font-size: 9px;
            color: #9ca3af;
            text-align: center;
        }

        /* ==================== PRINT ==================== */
        @media print {
            body { padding: 0; }
            @page { margin: 10mm; size: A4 landscape; }
            thead th, .badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>

    {{-- ==================== HELPER ==================== --}}
    @php
        /**
         * Bersihkan HTML:
         * - null / kosong / hanya tag (mis. <div><br></div>) → '-'
         * - ada isi → teks biasa (strip tags + decode entity)
         */
        $plainText = function ($html) {
            if ($html === null) return '-';
            $text = strip_tags($html);
            $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            $text = preg_replace('/\x{00A0}/u', ' ', $text); // ganti &nbsp; jadi spasi
            $text = trim(preg_replace('/\s+/u', ' ', $text));
            return $text === '' ? '-' : $text;
        };
    @endphp

    {{-- ==================== HEADER ==================== --}}
    <div class="report-header">
        <div class="header-left">
            <div class="company-text">
                <h1>PT. SIIX EMS INDONESIA</h1>
                <p>Production - Patrol Monitoring</p>
            </div>
        </div>
    </div>

    {{-- ==================== TITLE ==================== --}}
    <div class="report-title">
        <h2>Result Patrol Report</h2>
        <p>Production Line Inspection & Finding Analysis</p>
    </div>

    {{-- ==================== TABLE ==================== --}}
    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 7%;">Shift / Group</th>
                <th style="width: 10%;">Line</th>
                <th style="width: 8%;">Category</th>
                <th style="width: 12%;">Finding Result</th>
                <th style="width: 10%;">Feedback To</th>
                <th style="width: 10%;">Evidence</th>
                <th style="width: 12%;">Reason</th>
                <th style="width: 10%;">Evidence Action</th>
                <th style="width: 11%;">Action Taken</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rows as $i => $r)
                @php
                    $hasFindings = count($r->finding_patrol_items ?? []) > 0;
                    $findings = $hasFindings ? $r->finding_patrol_items : [null];
                    $rowCount = count($findings);
                @endphp

                @foreach($findings as $findingIndex => $f)
                    <tr>
                        {{-- Data Utama (Rowspan) --}}
                        @if($findingIndex === 0)
                            <td rowspan="{{ $rowCount }}" style="text-align: center; vertical-align: middle;">{{ $i + 1 }}</td>
                            <td rowspan="{{ $rowCount }}" style="text-align: center; vertical-align: middle;">{{ $r->shift }} / {{ $r->group }}</td>
                            <td rowspan="{{ $rowCount }}" style="vertical-align: middle;">
                                <strong>{{ $r->masterLine?->line_number ?? '-' }}</strong><br>
                                <span style="font-size: 9px; color: #6b7280;">{{ $r->masterLine?->location?->location_name ?? '-' }}</span>
                            </td>
                        @endif

                        {{-- Data Temuan --}}
                        @if($f)
                            <td>
                                @if(!empty($f['category_id']))
                                    {{ \App\Models\PROD\Patrol\CategoryPatrol::find($f['category_id'])?->category_name ?? $f['category_id'] }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>{{ $plainText($f['finding_result'] ?? null) }}</td>
                            <td>
                                @php
                                    $fb = $f['feedback_to'] ?? null;
                                    $fbIds = is_array($fb) ? $fb : ($fb ? [$fb] : []);
                                    $fbNames = collect($fbIds)
                                        ->map(function ($id) {
                                            $u = \App\Models\User::find($id);
                                            return $u?->name ?? $id;
                                        })
                                        ->filter()
                                        ->implode(', ');
                                @endphp
                                {{ $fbNames ?: '-' }}
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $ev = $f['evidence'] ?? [];
                                    $evList = is_array($ev) ? $ev : ($ev ? [$ev] : []);
                                @endphp
                                @if(count($evList) > 0)
                                    @foreach($evList as $photo)
                                        <img src="{{ $photo }}" class="photo" alt="Evidence" />
                                    @endforeach
                                @else
                                    <span class="no-photo">No Photo</span>
                                @endif
                            </td>
                            <td>{{ $plainText($f['reason'] ?? null) }}</td>
                            <td style="text-align: center;">
                                @php
                                    $eva = $f['evidence_action'] ?? [];
                                    $evaList = is_array($eva) ? $eva : ($eva ? [$eva] : []);
                                @endphp
                                @if(count($evaList) > 0)
                                    @foreach($evaList as $photo)
                                        <img src="{{ $photo }}" class="photo" alt="Action" />
                                    @endforeach
                                @else
                                    <span class="no-photo">No Photo</span>
                                @endif
                            </td>
                            <td>{{ $plainText($f['action'] ?? null) }}</td>
                        @else
                            {{-- Jika Aman (Tidak ada temuan) --}}
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;"><span class="badge badge-green">Safe</span></td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                            <td style="text-align: center;">-</td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="10" style="text-align: center; padding: 30px; color: #9ca3af;">
                        No data available for this report.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ==================== FOOTER ==================== --}}
    <div class="report-footer">
        Result Patrol Report — Generated automatically by SIIX Portal
    </div>

</body>
</html>