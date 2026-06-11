<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Comelate Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f9f9f9;
        }
        .header {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #004085;
            margin-bottom: 10px;
        }
        .content {
            font-size: 12px;
        }
        .footer {
            margin-top: 15px;
            font-size: 11px;
            color: #777;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: center;
            font-size: 11px;
            white-space: nowrap;
        }
        th {
            background: rgb(27, 216, 112);
            color: white;
        }
        .signature {
            margin-top: 15px;
            font-size: 12px;
            font-weight: bold;
        }
        .company-info {
            font-size: 11px;
            color: #555;
            margin-top: 8px;
            text-align: left;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            Comelate Notification
        </div>

        <div class="content">
            <p>Dear Mr./Mrs.</p>
            <p><strong><?php echo e($is_hod ? $hod_name : 'Good Day'); ?></strong></p>
            <p>Hereby we share an employee comelate report as below:</p>

            <table>
                <thead>
                    <tr>
                        <th>NIK</th>
                        <th>Name</th>
                        <th>Dept</th>
                        <th>Shift</th>
                        <th>Reason</th>
                        <th>Security</th>
                        <th>Date</th>
                        <th>Time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo e($comelate->employee?->nik ?? $comelate->nik); ?></td>
                        <td><?php echo e($comelate->employee?->name ?? $comelate->name); ?></td>
                        <td><?php echo e($comelate->department); ?></td>
                        <td><?php echo e(match($comelate->shift) {
                            'NS' => 'Non Shift',
                            '1' => 'Shift 1',
                            '2' => 'Shift 2',
                            '3' => 'Shift 3',
                            default => $comelate->shift ?? '-',
                        }); ?></td>
                        <td><?php echo e($comelate->alasan_terlambat); ?></td>
                        <td><?php echo e($comelate->nama_security); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($comelate->tanggal)->format('d M Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($comelate->jam)->format('H:i')); ?></td>
                    </tr>
                </tbody>
            </table>

            <p>Thank you.</p>

            <div class="signature">
                Best Regards,<br>
                Admin Dept.
            </div>

            <div class="company-info">
                PT. SIIX EMS INDONESIA <br>
                Jl. Maligi VIII Lot S-4, Kawasan Industri KIIC <br>
                Teluk Jambe Barat, Karawang (41361) <br>
                Tel : (021) 89114685 Ext: 262
            </div>
        </div>

        <div class="footer">
            This email was sent automatically, please do not reply to this email.
        </div>
    </div>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/emails/hr/comelate.blade.php ENDPATH**/ ?>