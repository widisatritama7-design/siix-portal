<!DOCTYPE html>
<html>
<head>
    <title>Due Submission Reminder</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #d1ecf1;
            padding: 20px;
            border-radius: 5px;
            border-left: 5px solid #17a2b8;
            margin-bottom: 20px;
        }
        .info {
            color: #0c5460;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #d1ecf1;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f5f5f5;
        }
        .days-left {
            font-weight: bold;
        }
        .today {
            color: #ff9800;
        }
        .overdue {
            color: #f44336;
        }
        .upcoming {
            color: #4caf50;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #17a2b8;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin: 20px 0;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
        }
        .uppercase {
            text-transform: uppercase;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .badge-today {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-upcoming {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-overdue {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="info">📋 Due Submission Reminder</h2>
        </div>
        
        <p>Dear Team,</p>
        
        <p>Berikut adalah daftar submission yang masih menunggu receive:</p>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>PIC</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $index => $submission)
                    @php
                        $daysLeft = now()->startOfDay()->diffInDays($submission->due_date->startOfDay(), false);
                        if ($daysLeft == 0) {
                            $daysText = 'Hari ini';
                            $badgeClass = 'badge-today';
                            $icon = '🟡';
                        } elseif ($daysLeft > 0) {
                            $daysText = "$daysLeft hari lagi";
                            $badgeClass = 'badge-upcoming';
                            $icon = '🟢';
                        } else {
                            $daysText = "Terlambat " . abs($daysLeft) . " hari";
                            $badgeClass = 'badge-overdue';
                            $icon = '🔴';
                        }
                    @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="uppercase"><strong>{{ strtoupper($submission->description) }}</strong></td>
                        <td>{{ $submission->dept }}</td>
                        <td>{{ $submission->pic }}</td>
                        <td>{{ $submission->due_date->format('d M Y') }}</td>
                        <td><span class="status-badge {{ $badgeClass }}">{{ $icon }} {{ $daysText }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Total: {{ count($submissions) }} submission</strong></p>
        
        <a href="https://portal.siix-ems.co.id/mainMenu/submissions?activeTab=Due+This+Week" class="btn">
            Lihat Semua Submission
        </a>
        
        <p>Silakan segera melakukan distribusi untuk submission di atas.</p>
        
        <div class="footer">
            <p>Terima kasih,<br>
            <strong>SIIX EMS System</strong></p>
        </div>
    </div>
</body>
</html>