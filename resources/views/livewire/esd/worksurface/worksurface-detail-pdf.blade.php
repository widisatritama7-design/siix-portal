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
        
        /* Font utama dengan dukungan Unicode penuh */
        body {
            font-family: 'DejaVu Sans', 'Arial', 'Segoe UI', 'Helvetica', sans-serif;
            font-size: 9pt;
            line-height: 1.3;
            margin: 15px;
            padding: 0;
        }
        
        .container {
            width: 100%;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 16pt;
            color: #1a56db;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        .report-info {
            margin-bottom: 15px;
            padding: 8px;
            background: #f3f4f6;
            border-radius: 5px;
            font-size: 8pt;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
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
            margin-top: 10px;
            font-size: 8pt;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        table.data-table th {
            background: #1a56db;
            color: white;
            padding: 6px 4px;
            text-align: center;
            border: 1px solid #ddd;
            font-weight: bold;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        table.data-table td {
            padding: 5px 4px;
            border: 1px solid #ddd;
            vertical-align: top;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
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
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        .badge-ok {
            color: #059669;
            font-weight: bold;
        }
        
        .badge-ng {
            color: #dc2626;
            font-weight: bold;
        }
        
        .text-center {
            text-align: center;
        }
        
        .text-left {
            text-align: left;
        }
        
        .text-uppercase {
            text-transform: uppercase;
        }
        
        .wrap-text {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }
        
        .col-no { width: 3%; }
        .col-register { width: 10%; }
        .col-area { width: 8%; }
        .col-location { width: 8%; }
        .col-layer { width: 5%; }
        .col-category { width: 8%; }
        .col-item { width: 8%; }
        .col-a1 { width: 8%; }
        .col-a1-sci { width: 8%; }
        .col-judge1 { width: 5%; }
        .col-a2 { width: 8%; }
        .col-judge2 { width: 5%; }
        .col-remarks { width: 10%; }
        .col-date { width: 7%; }
        .col-next-date { width: 7%; }
        .col-checked { width: 8%; }
        
        @page {
            size: A4 landscape;
            margin: 15px;
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
                            @if($area_filter)
                            <tr>
                                <td>Area Filter</td>
                                <td colspan="3">: {{ $area_filter }}</td>
                            </tr>
                            @endif
                            @if($location_filter)
                            <tr>
                                <td>Location Filter</td>
                                <td colspan="3">: {{ $location_filter }}</td>
                            </tr>
                            @endif
                            @if($item_filter)
                            <tr>
                                <td>Item Filter</td>
                                <td colspan="3">: {{ $item_filter }}</td>
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
                                    <span style="font-size: 7pt;">( {{ '_________________' }} )</span>
                                </td>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>CHECKED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( {{ '_________________' }} )</span>
                                </td>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>APPROVED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( {{ '_________________' }} )</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 10px; padding: 6px 8px; background: #e8f0fe; border-radius: 4px; font-size: 8pt; text-align: left; border-top: 1px solid #ddd;">
                <strong>STANDARD ESD OF WORKSURFACE TABLE, RACK AND TROLLEY</strong><br>
                <div style="margin-top: 4px;">
                    <div>• (A1) Mat Surface Point To Ground : < 1.00E+9 Ohm</div>
                    <div>• (A2) Mat Surface Static Field Voltage : < +/- 100 Volts</div>
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
                    <th class="col-category">Category</th>
                    <th class="col-item">Item</th>
                    <th class="col-a1-sci">A1 Result</th>
                    <th class="col-judge1">Judg</th>
                    <th class="col-a2">A2 Result</th>
                    <th class="col-judge2">Judg</th>
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
                    <td class="text-center">{{ $detail->worksurface->register_no ?? 'N/A' }}</td>
                    <td class="text-center">{{ $detail->worksurface->area ?? '-' }}</td>
                    <td class="text-center">{{ $detail->worksurface->location ?? '-' }}</td>
                    <td class="text-center text-uppercase">{{ $detail->worksurface->category ?? '-' }}</td>
                    <td class="text-center text-uppercase">{{ $detail->item ?? '-' }}</td>
                    <td class="text-center">{{ $detail->a1_scientific ?? '-' }}</td>
                    <td class="text-center">
                        <span class="{{ $detail->judgement_a1 == 'OK' ? 'badge-ok' : 'badge-ng' }}">
                            {{ $detail->judgement_a1 ?? '-' }}
                        </span>
                    </td>
                    <td class="text-center">
                        @php
                            $a2Value = $detail->a2;
                            if (is_numeric($a2Value)) {
                                echo number_format(floatval($a2Value), 2);
                            } else {
                                echo '-';
                            }
                        @endphp
                    </td>
                    <td class="text-center">
                        <span class="{{ $detail->judgement_a2 == 'OK' ? 'badge-ok' : 'badge-ng' }}">
                            {{ $detail->judgement_a2 ?? '-' }}
                        </span>
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
            QR-ADM-22-K014
        </div>
    </div>
</body>
</html>