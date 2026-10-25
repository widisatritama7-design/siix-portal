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
            font-family: 'DejaVu Sans', 'Arial', 'Segoe UI', 'Helvetica', sans-serif;
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
        .text-uppercase { text-transform: uppercase; }

        .wrap-text {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }

        .col-no { width: 2.5%; }
        .col-register { width: 8%; }
        .col-area { width: 6.5%; }
        .col-location { width: 6.5%; }
        .col-type { width: 5%; }
        .col-spec { width: 5%; }
        .col-line { width: 4.5%; }
        .col-e1 { width: 6%; }
        .col-judge { width: 4.5%; }
        .col-e2 { width: 3.5%; }
        .col-remarks { width: 10%; }
        .col-date { width: 6.5%; }
        .col-next-date { width: 6.5%; }
        .col-checked { width: 8%; }

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
                            @if($register_filter)
                            <tr>
                                <td>Register No</td>
                                <td colspan="3">: {{ $register_filter }}</td>
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
                <strong>STANDARD ESD OF SOLDERING</strong>
                <div style="margin-top: 4px;">
                    <div>• (E1) Tip Solder To Ground : &lt; 10 Ohm</div>
                    <div style="margin-top: 3px;"><strong>• (E2) Visual Inspection Checklist</strong></div>
                    <div style="padding-left: 12px;">(E-2.1) Kabel power terpasang dan tidak longgar</div>
                    <div style="padding-left: 12px;">(E-2.2) Soldering tip dalam kondisi baik dan tidak rusak</div>
                    <div style="padding-left: 12px;">(E-2.3) Grounding connection terpasang dengan benar</div>
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
                    <th class="col-e1">E1 Result</th>
                    <th class="col-judge">Judg</th>
                    <th class="col-e2">E2.1</th>
                    <th class="col-e2">E2.2</th>
                    <th class="col-e2">E2.3</th>
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
                    <td class="text-center">{{ $detail->soldering->register_no ?? 'N/A' }}</td>
                    <td class="text-center">{{ $detail->soldering->area ?? '-' }}</td>
                    <td class="text-center">{{ $detail->soldering->location ?? '-' }}</td>
                    <td class="text-center">
                        @php
                            $e1Value = $detail->e1;
                            if (is_numeric($e1Value)) {
                                echo number_format(floatval($e1Value), 2);
                            } else {
                                echo '-';
                            }
                        @endphp
                    </td>
                    <td class="text-center">
                        <span class="{{ $detail->judgement == 'OK' ? 'badge-ok' : 'badge-ng' }}">
                            {{ $detail->judgement ?? '-' }}
                        </span>
                    </td>

                    {{-- E2.1 --}}
                    <td class="text-center">
                        @if($detail->e2_1 !== null)
                            <span class="{{ $detail->e2_1 ? 'badge-yes' : 'badge-no' }}">
                                {{ $detail->e2_1 ? 'Yes' : 'No' }}
                            </span>
                        @else
                            <span class="badge-na">-</span>
                        @endif
                    </td>

                    {{-- E2.2 --}}
                    <td class="text-center">
                        @if($detail->e2_2 !== null)
                            <span class="{{ $detail->e2_2 ? 'badge-yes' : 'badge-no' }}">
                                {{ $detail->e2_2 ? 'Yes' : 'No' }}
                            </span>
                        @else
                            <span class="badge-na">-</span>
                        @endif
                    </td>

                    {{-- E2.3 --}}
                    <td class="text-center">
                        @if($detail->e2_3 !== null)
                            <span class="{{ $detail->e2_3 ? 'badge-yes' : 'badge-no' }}">
                                {{ $detail->e2_3 ? 'Yes' : 'No' }}
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
                    <td colspan="16" class="text-center" style="padding: 20px;">
                        No data found for the selected filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer" style="font-weight: bold;">
            QR-ADM-22-K022
        </div>
    </div>
</body>
</html>