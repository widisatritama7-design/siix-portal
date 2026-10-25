<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 8pt;
            line-height: 1.25;
            margin: 12px;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 15pt;
            color: #1a56db;
        }

        .report-info {
            margin-bottom: 12px;
            padding: 8px;
            background: #f3f4f6;
            border-radius: 5px;
            font-size: 7.5pt;
        }

        .report-info table {
            width: 100%;
        }

        .report-info td {
            padding: 2px 5px;
        }

        .report-info td:first-child {
            font-weight: bold;
            width: 100px;
        }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
            font-size: 6.5pt;
        }

        table.data-table th {
            background: #1a56db;
            color: white;
            padding: 5px 3px;
            text-align: center;
            border: 1px solid #ddd;
            font-weight: bold;
            font-size: 6pt;
            line-height: 1.15;
        }

        table.data-table td {
            padding: 4px 3px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }

        table.data-table tr:nth-child(even) {
            background: #f9fafb;
        }

        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 7pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
        }

        .badge-ok { color: #059669; font-weight: bold; }
        .badge-ng { color: #dc2626; font-weight: bold; }
        .badge-yes { color: #059669; font-weight: bold; }
        .badge-no  { color: #dc2626; font-weight: bold; }
        .badge-na  { color: #9ca3af; }

        .text-center { text-align: center; }
        .text-left { text-align: left; }

        .wrap-text {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }

        .col-no { width: 2.5%; }
        .col-nik { width: 6.5%; }
        .col-name { width: 8%; }
        .col-d1 { width: 6.5%; }
        .col-judge1 { width: 4%; }
        .col-d2 { width: 6.5%; }
        .col-judge2 { width: 4%; }
        .col-d3 { width: 6.5%; }
        .col-judge3 { width: 4%; }
        .col-d4 { width: 6.5%; }
        .col-judge4 { width: 4%; }
        .col-d5 { width: 6.5%; }
        .col-judge5 { width: 4%; }
        .col-d6 { width: 4.5%; }
        .col-remarks { width: 9%; }
        .col-date { width: 5.5%; }
        .col-next-date { width: 5.5%; }
        .col-checked { width: 7%; }

        @page {
            size: A4 landscape;
            margin: 12px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .footer {
                position: fixed;
                bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 80px; text-align: left; vertical-align: middle; border: none;">
                        <img src="{{ public_path('images/siix-logo.png') }}" alt="SIIX Logo" style="height: 50px; width: auto;">
                    </td>
                    <td style="text-align: center; vertical-align: middle; border: none;">
                        <h1 style="margin: 0;">{{ $title }}</h1>
                    </td>
                    <td style="width: 80px; text-align: right; vertical-align: middle; border: none;">
                        <img src="{{ public_path('images/esd-logo.png') }}" alt="ESD Logo" style="height: 50px; width: auto;">
                    </td>
                </tr>
            </table>
        </div>

        <div class="report-info">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 100px;">Print By</td>
                                <td>: {{ $generated_by }}</td>
                            </tr>
                            <tr>
                                <td>Print Date</td>
                                <td>: {{ $generated_at }}</td>
                            </tr>
                            @if($nik)
                            <tr>
                                <td>NIK Filter</td>
                                <td colspan="3">: {{ $nik }}</td>
                            </tr>
                            @endif
                            @if($name)
                            <tr>
                                <td>Name Filter</td>
                                <td colspan="3">: {{ $name }}</td>
                            </tr>
                            @endif
                            @if($date_from || $date_until)
                            <tr>
                                <td>Date Range</td>
                                <td colspan="3">:
                                    {{ $date_from ? \Carbon\Carbon::parse($date_from)->format('d M Y') : 'Start' }}
                                    to
                                    {{ $date_until ? \Carbon\Carbon::parse($date_until)->format('d M Y') : 'End' }}
                                </td>
                            </tr>
                            @endif
                            <tr>
                                <td>Total Records</td>
                                <td colspan="3">: {{ $details->count() }} Record(s)</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>PREPARED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( _________________ )</span>
                                </td>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>CHECKED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( _________________ )</span>
                                </td>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>APPROVED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( _________________ )</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 10px; padding: 6px 8px; background: #e8f0fe; border-radius: 4px; font-size: 7pt; text-align: left; border-top: 1px solid #ddd;">
                <strong>STANDARD ESD OF STATIC CONTROL GARMENT</strong>
                <div style="margin-top: 4px;">
                    <div>• (D1) Shirt Point To Point : &lt; 1.00E+11 Ohm</div>
                    <div>• (D2) Pants Point To Point : &lt; 1.00E+11 Ohm</div>
                    <div>• (D3) Cap Point To Point : &lt; 1.00E+11 Ohm</div>
                    <div>• (D4) Hijab Point To Point : &lt; 1.00E+11 Ohm</div>
                    <div>• (D5) Smock Point To Point : &lt; 1.00E+11 Ohm</div>
                    <div style="margin-top: 3px;"><strong>• (D6) Visual Inspection Checklist</strong></div>
                    <div style="padding-left: 12px;">(D-6.1) Garment ESD tidak robek, berlubang, atau rusak</div>
                </div>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th class="col-nik">NIK</th>
                    <th class="col-name">Name</th>
                    <th class="col-d1">D1</th>
                    <th class="col-judge1">Judg</th>
                    <th class="col-d2">D2</th>
                    <th class="col-judge2">Judg</th>
                    <th class="col-d3">D3</th>
                    <th class="col-judge3">Judg</th>
                    <th class="col-d4">D4</th>
                    <th class="col-judge4">Judg</th>
                    <th class="col-d5">D5</th>
                    <th class="col-judge5">Judg</th>
                    <th class="col-d6">D6.1</th>
                    <th class="col-remarks">Remarks</th>
                    <th class="col-date">Date</th>
                    <th class="col-next-date">Next Date</th>
                    <th class="col-checked">Checked By</th>
                </tr>
            </thead>
            <tbody>
                @forelse($details as $index => $detail)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center">{{ $detail->garment->nik ?? $detail->nik }}</td>
                    <td class="wrap-text">{{ $detail->garment->name ?? $detail->name }}</td>

                    {{-- D1 --}}
                    <td class="text-center">{{ $detail->d1_scientific ?? '-' }}</td>
                    <td class="text-center">
                        <span class="{{ $detail->judgement_d1 == 'OK' ? 'badge-ok' : 'badge-ng' }}">
                            {{ $detail->judgement_d1 ?? '-' }}
                        </span>
                    </td>

                    {{-- D2 --}}
                    <td class="text-center">{{ $detail->d2_scientific ?? '-' }}</td>
                    <td class="text-center">
                        <span class="{{ $detail->judgement_d2 == 'OK' ? 'badge-ok' : 'badge-ng' }}">
                            {{ $detail->judgement_d2 ?? '-' }}
                        </span>
                    </td>

                    {{-- D3 --}}
                    <td class="text-center">{{ $detail->d3_scientific ?? '-' }}</td>
                    <td class="text-center">
                        <span class="{{ $detail->judgement_d3 == 'OK' ? 'badge-ok' : 'badge-ng' }}">
                            {{ $detail->judgement_d3 ?? '-' }}
                        </span>
                    </td>

                    {{-- D4 --}}
                    <td class="text-center">{{ $detail->d4_scientific ?? '-' }}</td>
                    <td class="text-center">
                        <span class="{{ $detail->judgement_d4 == 'OK' ? 'badge-ok' : 'badge-ng' }}">
                            {{ $detail->judgement_d4 ?? '-' }}
                        </span>
                    </td>

                    {{-- D5 (NEW) --}}
                    <td class="text-center">{{ $detail->d5_scientific ?? '-' }}</td>
                    <td class="text-center">
                        @if($detail->judgement_d5)
                            <span class="{{ $detail->judgement_d5 == 'OK' ? 'badge-ok' : 'badge-ng' }}">
                                {{ $detail->judgement_d5 }}
                            </span>
                        @else
                            <span class="badge-na">-</span>
                        @endif
                    </td>

                    {{-- D6.1 (NEW) --}}
                    <td class="text-center">
                        @if($detail->d6_1 !== null)
                            <span class="{{ $detail->d6_1 ? 'badge-yes' : 'badge-no' }}">
                                {{ $detail->d6_1 ? 'Y' : 'N' }}
                            </span>
                        @else
                            <span class="badge-na">-</span>
                        @endif
                    </td>

                    <td class="wrap-text">{{ $detail->remarks ?? '-' }}</td>
                    <td class="text-center">{{ $detail->created_at ? $detail->created_at->format('d M Y') : '-' }}</td>
                    <td class="text-center">{{ $detail->next_date ? \Carbon\Carbon::parse($detail->next_date)->format('d M Y') : '-' }}</td>
                    <td class="wrap-text">{{ $detail->creator->name ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="18" class="text-center" style="padding: 20px;">
                        No data found for the selected filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer" style="font-weight: bold;">
            QR-ADM-22-K020
        </div>
    </div>
</body>
</html>