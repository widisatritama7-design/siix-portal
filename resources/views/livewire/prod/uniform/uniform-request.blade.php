<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Uniform Request - {{ $request->request_number }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            margin: 15px;
            position: relative;
            min-height: 100vh;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            font-size: 18px;
            text-transform: uppercase;
        }
        .header .sub {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
            font-size: 10px;
        }
        .info-table td {
            padding: 4px 8px;
            vertical-align: top;
        }
        .info-table .label {
            font-weight: bold;
            width: 130px;
        }
        .info-table .value {
            font-weight: normal;
        }
        .info-table .status-badge {
            display: inline-block;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-open { background: #e5e7eb; color: #4b5563; }
        .status-onprocess { background: #fef3c7; color: #d97706; }
        .status-checked { background: #d1fae5; color: #065f46; }
        .status-approved { background: #d1fae5; color: #065f46; }
        .status-completed { background: #dbeafe; color: #1e40af; }
        .status-signed { background: #e0e7ff; color: #3730a3; }
        .status-waiting { background: #e5e7eb; color: #4b5563; }
        .status-na { background: #e5e7eb; color: #6b7280; }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 7.5px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 3px 4px;
            text-align: left;
            vertical-align: middle;
        }
        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .data-table .text-center { text-align: center; }
        .data-table .text-left { text-align: left; }
        
        .signature {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }
        .signature td {
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
        }
        .signature .label {
            font-weight: normal;
            font-size: 9px;
            margin-bottom: 10px;
            display: block;
        }
        .signature .signature-name {
            font-weight: bold;
            font-size: 10px;
            margin: 8px 0 3px 0;
        }
        .signature .signature-line {
            border-bottom: 1px solid #000;
            width: 80%;
            margin: 0 auto;
            height: 25px;
        }
        .signature .signature-position {
            font-size: 8px;
            margin-top: 3px;
        }
        .signature .signature-datetime {
            font-size: 8px;
            color: #888;
        }
        
        .footer-legend {
            margin-top: 20px;
            font-size: 8px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }
        .footer {
            position: absolute;
            bottom: 15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
            color: #999;
        }
        .content-wrapper {
            min-height: calc(100vh - 50px);
            padding-bottom: 30px;
        }
        .badge-manual {
            display: inline-block;
            background: #fef3c7;
            color: #d97706;
            font-size: 6px;
            padding: 1px 4px;
            border-radius: 8px;
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
        .text-muted {
            color: #6b7280;
        }
        .text-success {
            color: #065f46;
        }
        .text-danger {
            color: #991b1b;
        }
        .text-warning {
            color: #d97706;
        }
        .text-info {
            color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <!-- HEADER -->
        <div class="header">
            <h2>UNIFORM REQUEST</h2>
            <div class="sub">Request #: {{ $request->request_number }}</div>
            <div class="sub">Printed: {{ $date }}</div>
        </div>

        <!-- INFO TABLE -->
        <table class="info-table">
            <tr>
                <td class="label">Request Number</td>
                <td class="value">: {{ $request->request_number }}</td>
                <td class="label" style="width: 120px;">Total Employee</td>
                <td class="value">: {{ $totalEmployee }} Employee(s)</td>
            </tr>
            <tr>
                <td class="label">Prepared By</td>
                <td class="value">: {{ $request->created_by }}</td>
                <td class="label">Date</td>
                <td class="value">: {{ $request->created_at ? $request->created_at->format('d M Y H:i') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Admin Feedback</td>
                <td class="value">
                    <span class="status-badge status-{{ strtolower(str_replace(' ', '', $adminStatus['status'])) }}">
                        {{ $adminStatus['status'] }}
                    </span>
                </td>
                <td class="label">Verification</td>
                <td class="value">
                    <span class="status-badge status-{{ strtolower(str_replace(' ', '', $verificationStatus['status'])) }}">
                        {{ $verificationStatus['status'] }}
                    </span>
                </td>
            </tr>
            <tr>
                <td class="label">Costing Feedback</td>
                <td class="value">
                    <span class="status-badge status-{{ strtolower(str_replace(' ', '', $costingStatus['status'])) }}">
                        {{ $costingStatus['status'] }}
                    </span>
                </td>
                <td class="label">Signature</td>
                <td class="value">
                    <span class="status-badge status-{{ strtolower(str_replace(' ', '', $signatureStatus['status'])) }}">
                        {{ $signatureStatus['status'] }}
                    </span>
                </td>
            </tr>
        </table>

        <!-- EMPLOYEE DETAILS TABLE -->
        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 10px; text-align: center;">#</th>
                    <th style="width: 35px; text-align: center;">NIK</th>
                    <th style="width: 70px;">Name</th>
                    <th style="width: 55px; text-align: center;">Department</th>
                    <th style="width: 40px;">Item Code</th>
                    <th style="width: 80px;">Description</th>
                    <th style="width: 28px;">Size</th>
                    <th style="width: 18px; text-align: center;">Qty</th>
                    <th style="width: 30px;">Group</th>
                    <th style="width: 50px;">Request Date</th>
                    <th style="width: 55px;">Reason</th>
                    <th style="width: 45px;">Remarks</th>
                    <th style="width: 55px;">Admin Feedback</th>
                    <th style="width: 65px;">Verification</th>
                    <th style="width: 65px;">Costing Feedback</th>
                    <th style="width: 75px;">Signature</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td class="text-center">{{ $item['no'] }}</td>
                    <td class="text-center">
                        {{ $item['nik'] }}
                        @if($item['is_manual'])
                        @endif
                    </td>
                    <td>{{ $item['name'] }}</td>
                    <td class="text-center">{{ $item['department'] }}</td>
                    <td class="text-center">{{ $item['item_code'] }}</td>
                    <td>{{ $item['description'] }}</td>
                    <td class="text-center">{{ $item['size'] }}</td>
                    <td class="text-center">{{ $item['qty'] }}</td>
                    <td class="text-center">{{ $item['group'] }}</td>
                    <td class="text-center">{{ $item['request_date'] }}</td>
                    <td>{{ $item['reason'] }}</td>
                    <td>{{ $item['remarks'] ?? '-' }}</td>
                    <td class="text-center">
                        {{ $item['admin_feedback'] }}
                        @if($item['admin_feedback_datetime'])
                            <br><span class="text-muted" style="font-size: 6px;">
                                {{ \Carbon\Carbon::parse($item['admin_feedback_datetime'])->format('d/m/Y H:i') }}
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item['is_manual'])
                            <span style="color: #6b7280; font-weight: bold;">N/A</span>
                        @elseif($item['verification_status'] == 'approved')
                            <span style="color: #065f46; font-weight: bold;">Approved</span>
                            @if($item['verification_datetime'])
                                <br><span class="text-muted" style="font-size: 6px;">
                                    {{ \Carbon\Carbon::parse($item['verification_datetime'])->format('d/m/Y H:i') }}
                                </span>
                            @endif
                            @if($item['verification_by'] && $item['verification_by'] != '-')
                                <br><span class="text-muted" style="font-size: 6px;">{{ $item['verification_by'] }}</span>
                            @endif
                        @elseif($item['verification_status'] == 'rejected')
                            <span style="color: #991b1b; font-weight: bold;">Rejected</span>
                            @if($item['verification_datetime'])
                                <br><span class="text-muted" style="font-size: 6px;">
                                    {{ \Carbon\Carbon::parse($item['verification_datetime'])->format('d/m/Y H:i') }}
                                </span>
                            @endif
                            @if($item['verification_by'] && $item['verification_by'] != '-')
                                <br><span class="text-muted" style="font-size: 6px;">{{ $item['verification_by'] }}</span>
                            @endif
                            @if($item['verification_note'] && $item['verification_note'] != '-')
                                <br><span class="text-muted" style="font-size: 6px;">note: {{ $item['verification_note'] }}</span>
                            @endif
                        @else
                            <span style="color: #6b7280;">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        {{ $item['costing_feedback'] }}
                        @if($item['costing_feedback_datetime'])
                            <br><span class="text-muted" style="font-size: 6px;">
                                {{ \Carbon\Carbon::parse($item['costing_feedback_datetime'])->format('d/m/Y H:i') }}
                            </span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item['digital_signature'])
                            <span style="color: #3730a3; font-weight: bold;">Signed</span>
                            @if($item['signature_datetime'])
                                <br><span class="text-muted" style="font-size: 6px;">
                                    {{ \Carbon\Carbon::parse($item['signature_datetime'])->format('d/m/Y H:i') }}
                                </span>
                            @endif
                            @if($item['signature_name'] && $item['signature_name'] != '-')
                                <br><span class="text-muted" style="font-size: 6px;">{{ $item['signature_name'] }}</span>
                            @endif
                        @elseif($item['verification_status'] == 'rejected')
                            <span style="color: #6b7280; font-weight: bold;">N/A</span>
                        @else
                            <span style="color: #6b7280;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="16" class="text-center" style="padding: 20px;">No items found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="footer-legend">
            <span style="font-size: 8px;">
                <strong>Note:</strong> This document is generated automatically from SIIX Uniform Request System
            </span>
        </div>
    </div>
</body>
</html>