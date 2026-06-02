{{-- resources/views/pdf/absence-control-report-simple.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Attendance Control</title>
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
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            font-size: 16px;
        }
        .header h3 {
            margin: 5px 0 0 0;
            font-size: 12px;
            font-weight: normal;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            font-size: 10px;
        }
        .info-table td {
            padding: 5px;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 120px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }
        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .data-table td.text-left {
            text-align: left;
        }
        .data-table .bg-red {
            background-color: #ffe6e6;
        }
        .data-table .bg-green {
            background-color: #e6ffe6;
        }
        .data-table .bg-blue {
            background-color: #e6f3ff;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 9px;
        }
        .summary-table th, .summary-table td {
            border: 1px solid #000;
            padding: 6px;
            text-align: center;
            vertical-align: middle;
        }
        .summary-table th {
            background-color: #e0e0e0;
            font-weight: bold;
        }
        .signature {
            width: 100%;
            margin-top: 30px;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .signature td {
            text-align: center;
            vertical-align: top;
            padding: 0 10px;
        }
        .signature .label {
            font-weight: normal;
            margin-bottom: 15px;
            font-size: 9px;
        }
        .signature .signature-name {
            font-weight: bold;
            font-size: 10px;
            margin: 8px 0 5px 0;
        }
        .signature .signature-line {
            border-bottom: 1px solid #000;
            width: 80%;
            margin: 0 auto;
        }
        .signature .signature-position {
            font-size: 8px;
            margin-top: 5px;
            font-weight: normal;
        }
        .signature .signature-datetime {
            font-size: 7px;
            color: #888;
            margin: 2px 0 8px 0;
        }
        .footer {
            position: fixed;
            bottom: 15px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .bold {
            font-weight: bold;
        }
        hr {
            margin: 10px 0;
        }
        .content-wrapper {
            min-height: calc(100vh - 50px);
            padding-bottom: 30px;
        }
        .bg-red-soft {
            background-color: #ffe6e6;
        }
        .bg-green-soft {
            background-color: #e6ffe6;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="header">
            <h2>EMPLOYEE ATTENDANCE CONTROL REPORT</h2>
            <h3>Period: {{ $startDate }} s/d {{ $endDate }}</h3>
            <hr>
        </div>

        <table class="info-table">
            <tr>
                <td>Print Date</td>
                <td>: {{ $printedAt }}</td>
                <td style="width: 150px;"></td>
                <td style="width: 100px;"></td>
            </tr>
            <tr>
                <td>Department</td>
                <td>: {{ $departmentString }}</td>
            </tr>
            <tr>
                <td>Group</td>
                <td>: {{ $groupString }}</td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 20px;">NO</th>
                    <th style="width: 40px;">NIK</th>
                    <th style="width: 150px;">NAME</th>
                    <th style="width: 70px;">STATUS</th>
                    <th style="width: 80px;">DOJ</th>
                    <th style="width: 60px;">GROUP</th>
                    <th style="width: 40px;">SD</th>
                    <th style="width: 40px;">IJ</th>
                    <th style="width: 40px;">A</th>
                    <th style="width: 40px;">CK</th>
                    <th style="width: 40px;">CT</th>
                    <th style="width: 50px;">TOTAL DATE</th>
                    <th style="width: 50px;">PRESENT</th>
                    <th style="width: 60px;">RATIO %</th>
                </tr>
            </thead>
            <tbody>
                @forelse($employeeData as $employee)
                <tr>
                    <td class="text-center">{{ $employee['no'] }}</td>
                    <td class="text-left">{{ $employee['nik'] }}</td>
                    <td class="text-left">{{ $employee['name'] }}</td>
                    <td class="text-center">{{ $employee['status'] }}</td>
                    <td class="text-center">{{ $employee['doj'] }}</td>
                    <td class="text-center">{{ $employee['group'] }}</td>
                    
                    {{-- SD - merah hanya jika ada value > 0 --}}
                    <td @class([
                        'bg-red-soft' => $employee['absence']['SD'] > 0,
                        'bg-red' => $employee['absence']['SD'] > 0
                    ])>{{ $employee['absence']['SD'] > 0 ? $employee['absence']['SD'] : '-' }}</td>
                    
                    {{-- IJ - merah hanya jika ada value > 0 --}}
                    <td @class([
                        'bg-red-soft' => $employee['absence']['IJ'] > 0,
                    ])>{{ $employee['absence']['IJ'] > 0 ? $employee['absence']['IJ'] : '-' }}</td>
                    
                    {{-- A - merah hanya jika ada value > 0 --}}
                    <td @class([
                        'bg-red-soft' => $employee['absence']['A'] > 0,
                    ])>{{ $employee['absence']['A'] > 0 ? $employee['absence']['A'] : '-' }}</td>
                    
                    {{-- CK - merah hanya jika ada value > 0 --}}
                    <td @class([
                        'bg-red-soft' => $employee['absence']['CK'] > 0,
                    ])>{{ $employee['absence']['CK'] > 0 ? $employee['absence']['CK'] : '-' }}</td>
                    
                    {{-- CT - merah hanya jika ada value > 0 --}}
                    <td @class([
                        'bg-red-soft' => $employee['absence']['CT'] > 0,
                    ])>{{ $employee['absence']['CT'] > 0 ? $employee['absence']['CT'] : '-' }}</td>
                    
                    <td class="bg-blue">{{ $employee['total_dates'] }}</td>
                    
                    {{-- PRESENT - merah jika tidak sesuai dengan TOTAL DATE --}}
                    <td @class([
                        'bg-green-soft' => $employee['total_present'] == $employee['total_dates'],
                        'bg-red-soft' => $employee['total_present'] < $employee['total_dates'],
                    ])>{{ $employee['total_present'] }}</td>
                    
                    {{-- RATIO - merah jika < 100, hijau jika >= 100 --}}
                    <td @class([
                        'bg-green-soft' => $employee['ratio'] >= 100,
                        'bg-red-soft' => $employee['ratio'] < 100,
                    ])>
                        {{ number_format($employee['ratio'], 2) }}%
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="14" class="text-center">Tidak ada data</td>
                </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="background-color: #e0e0e0; font-weight: bold;">
                    <td colspan="6" class="text-right">TOTAL</td>
                    
                    {{-- SD TOTAL - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft' => $grandTotals['SD'] > 0,
                    ])>{{ $grandTotals['SD'] > 0 ? $grandTotals['SD'] : '-' }}</td>
                    
                    {{-- IJ TOTAL - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft' => $grandTotals['IJ'] > 0,
                    ])>{{ $grandTotals['IJ'] > 0 ? $grandTotals['IJ'] : '-' }}</td>
                    
                    {{-- A TOTAL - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft' => $grandTotals['A'] > 0,
                    ])>{{ $grandTotals['A'] > 0 ? $grandTotals['A'] : '-' }}</td>
                    
                    {{-- CK TOTAL - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft' => $grandTotals['CK'] > 0,
                    ])>{{ $grandTotals['CK'] > 0 ? $grandTotals['CK'] : '-' }}</td>
                    
                    {{-- CT TOTAL - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft' => $grandTotals['CT'] > 0,
                    ])>{{ $grandTotals['CT'] > 0 ? $grandTotals['CT'] : '-' }}</td>
                    
                    <td class="bg-blue">{{ $grandTotals['total_dates'] }}</td>
                    
                    {{-- PRESENT TOTAL - merah jika tidak sesuai dengan TOTAL DATE --}}
                    <td @class([
                        'bg-green-soft' => $grandTotals['total_present'] == $grandTotals['total_dates'],
                        'bg-red-soft' => $grandTotals['total_present'] < $grandTotals['total_dates'],
                    ])>{{ $grandTotals['total_present'] }}</td>
                    
                    {{-- RATIO TOTAL - merah jika < 100, hijau jika >= 100 --}}
                    <td @class([
                        'bg-green-soft' => $grandTotals['ratio'] >= 100,
                        'bg-red-soft' => $grandTotals['ratio'] < 100,
                    ])>
                        {{ number_format($grandTotals['ratio'], 2) }}%
                    </td>
                </tr>
            </tfoot>
        </table>

        <!-- RINGKASAN AKUMULASI -->
        <table class="summary-table">
            <thead>
                <tr>
                    <th>SD</th>
                    <th>IJ</th>
                    <th>A</th>
                    <th>CK</th>
                    <th>CT</th>
                    <th>TOTAL EMPLOYEES</th>
                    <th>TOTAL DATE</th>
                    <th>TOTAL PRESENT</th>
                    <th>RATIO %</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    {{-- SD - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft bold' => $grandTotals['SD'] > 0,
                        'bold' => $grandTotals['SD'] == 0
                    ])>{{ $grandTotals['SD'] > 0 ? $grandTotals['SD'] : '-' }}</td>
                    
                    {{-- IJ - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft bold' => $grandTotals['IJ'] > 0,
                        'bold' => $grandTotals['IJ'] == 0
                    ])>{{ $grandTotals['IJ'] > 0 ? $grandTotals['IJ'] : '-' }}</td>
                    
                    {{-- A - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft bold' => $grandTotals['A'] > 0,
                        'bold' => $grandTotals['A'] == 0
                    ])>{{ $grandTotals['A'] > 0 ? $grandTotals['A'] : '-' }}</td>
                    
                    {{-- CK - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft bold' => $grandTotals['CK'] > 0,
                        'bold' => $grandTotals['CK'] == 0
                    ])>{{ $grandTotals['CK'] > 0 ? $grandTotals['CK'] : '-' }}</td>
                    
                    {{-- CT - merah hanya jika > 0 --}}
                    <td @class([
                        'bg-red-soft bold' => $grandTotals['CT'] > 0,
                        'bold' => $grandTotals['CT'] == 0
                    ])>{{ $grandTotals['CT'] > 0 ? $grandTotals['CT'] : '-' }}</td>
                    
                    <td class="bold">{{ $grandTotals['total_employees'] }}</td>
                    <td class="bold">{{ $grandTotals['total_dates'] }}</td>
                    
                    {{-- Total Hadir - merah jika tidak sesuai --}}
                    <td @class([
                        'bold' => true,
                        'bg-green-soft' => $grandTotals['total_present'] == $grandTotals['total_dates'],
                        'bg-red-soft' => $grandTotals['total_present'] < $grandTotals['total_dates'],
                    ])>{{ $grandTotals['total_present'] }}</td>
                    
                    {{-- Ratio % - merah jika < 100, hijau jika >= 100 --}}
                    <td @class([
                        'bold' => true,
                        'bg-green-soft' => $grandTotals['ratio'] >= 100,
                        'bg-red-soft' => $grandTotals['ratio'] < 100,
                    ])>
                        {{ number_format($grandTotals['ratio'], 2) }}%
                    </td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="footer">
        Attendance Control Report - Generated by {{ $printedBy }} at {{ $printedAt }}
    </div>
</body>
</html>