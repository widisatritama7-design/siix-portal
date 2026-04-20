<!DOCTYPE html>
<html>
<head>
    <title>OVERDUE Submission Alert</title>
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
            background-color: #fff3cd;
            padding: 20px;
            border-radius: 5px;
            border-left: 5px solid #ffc107;
            margin-bottom: 20px;
        }
        .urgent {
            color: #856404;
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
            background-color: #fff3cd;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f8f9fa;
        }
        .overdue-badge {
            background-color: #dc3545;
            color: white;
            padding: 4px 8px;
            border-radius: 3px;
            font-size: 12px;
            font-weight: bold;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #dc3545;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2 class="urgent">🚨 OVERDUE SUBMISSION ALERT</h2>
        </div>
        
        <p>Dear Team,</p>
        
        <p class="urgent">Berikut adalah daftar submission yang sudah di Receive dan<strong>SUDAH MELEWATI DUE DATE</strong> dan masih menunggu distribusi:</p>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Description</th>
                    <th>Department</th>
                    <th>PIC</th>
                    <th>Due Date</th>
                    <th>Days Overdue</th>
                </tr>
            </thead>
            <tbody>
                @foreach($submissions as $index => $submission)
                @php
                    $daysOverdue = now()->startOfDay()->diffInDays($submission->due_date->startOfDay());
                @endphp
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="uppercase"><strong>{{ strtoupper($submission->description) }}</strong></td>
                        <td>{{ $submission->dept }}</td>
                        <td>{{ $submission->pic }}</td>
                        <td>{{ $submission->due_date->format('d M Y') }}</td>
                        <td>
                            <span class="overdue-badge">
                                ⏰ {{ $daysOverdue }} hari
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Total: {{ count($submissions) }} OVERDUE submission</strong></p>
        
        <a href="https://portal.siix-ems.co.id/mainMenu/submissions?activeTab=Waiting+Distribute" class="btn">
            Lihat Semua Submission
        </a>
        
        <p class="urgent"><strong>PENTING:</strong> Submission di atas sudah melewati due date. Silakan segera ditindaklanjuti!</p>
        
        <div class="footer">
            <p>Terima kasih,<br>
            <strong>SIIX EMS System</strong></p>
        </div>
    </div>
</body>
</html>