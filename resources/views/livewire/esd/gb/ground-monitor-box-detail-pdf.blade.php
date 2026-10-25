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
        .col-register { width: 10%; }
        .col-area { width: 8%; }
        .col-location { width: 8%; }
        .col-g1 { width: 4.5%; }
        .col-g2 { width: 4.5%; }
        .col-g3 { width: 4.5%; }
        .col-remarks { width: 13%; }
        .col-date { width: 7%; }
        .col-next-date { width: 7%; }
        .col-checked { width: 9%; }

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
                            @if($register_no)
                            <tr>
                                <td>Register No Filter</td>
                                <td colspan="3">: {{ $register_no }}</td>
                            </tr>
                            @endif
                            @if($area)
                            <tr>
                                <td>Area Filter</td>
                                <td colspan="3">: {{ $area }}</td>
                            </tr>
                            @endif
                            @if($location)
                            <tr>
                                <td>Location Filter</td>
                                <td colspan="3">: {{ $location }}</td>
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
                <strong>STANDARD ESD OF GROUND MONITOR BOX / CONTINUOUS MONITOR</strong>
                <div style="margin-top: 4px;">
                    <div>• (G1) Check with Decade Resistance Box with Selector 1M, LED will light Green on Constant Monitor (indicating YES) If Not NO</div>
                    <div>• (G2) Check with Decade Resistance Box with Selector 35M, LED will light up Red on Constant Monitor (indicating YES) If not NO</div>
                    <div style="margin-top: 3px;"><strong>• (G-3) Visual Inspection Checklist</strong></div>
                    <div style="padding-left: 12px;">(G-3.1) Kabel grounding dan connection point terpasang</div>
                    <div style="padding-left: 12px;">(G-3.2) Alarm/indicator tidak menunjukkan kondisi abnormal (Selalu Menyala Merah atau Hijau)</div>
                </div>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th class="col-register">Register No</th>
                    <th class="col-area">Area</th>
                    <th class="col-location">Location</th>
                    <th class="col-g1">G1</th>
                    <th class="col-g2">G2</th>
                    <th class="col-g3">G-3.1</th>
                    <th class="col-g3">G-3.2</th>
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
                    <td class="text-center">{{ $detail->groundMonitorBox->register_no ?? 'N/A' }}</td>
                    <td class="wrap-text">{{ $detail->groundMonitorBox->area ?? 'N/A' }}</td>
                    <td class="wrap-text">{{ $detail->groundMonitorBox->location ?? 'N/A' }}</td>
                    <td class="text-center">
                        <span class="{{ $detail->g_3 == 'YES' ? 'badge-yes' : 'badge-no' }}">
                            {{ $detail->g_3 ?? '-' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="{{ $detail->g_4 == 'YES' ? 'badge-yes' : 'badge-no' }}">
                            {{ $detail->g_4 ?? '-' }}
                        </span>
                    </td>

                    {{-- G-3.1 --}}
                    <td class="text-center">
                        @if($detail->g_3_1 !== null)
                            <span class="{{ $detail->g_3_1 ? 'badge-yes' : 'badge-no' }}">
                                {{ $detail->g_3_1 ? 'Yes' : 'No' }}
                            </span>
                        @else
                            <span class="badge-na">-</span>
                        @endif
                    </td>

                    {{-- G-3.2 --}}
                    <td class="text-center">
                        @if($detail->g_3_2 !== null)
                            <span class="{{ $detail->g_3_2 ? 'badge-yes' : 'badge-no' }}">
                                {{ $detail->g_3_2 ? 'Yes' : 'No' }}
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
                    <td colspan="12" class="text-center" style="padding: 20px;">
                        No data found for the selected filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer" style="font-weight: bold;">
            QR-ADM-22-K018
        </div>
    </div>
</body>
</html>