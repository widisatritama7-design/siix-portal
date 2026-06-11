<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uniform Request Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
            padding: 10px;
            border-top: 1px solid #eee;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f0f8ff;
            width: 30%;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-pending {
            background-color: #fef3c7;
            color: #d97706;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .items-table th {
            background-color: #f0f8ff;
            text-align: center;
        }
        .items-table td {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #1e40af;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <?php echo e($isUpdate ? 'Uniform Request Updated' : 'New Uniform Request Created'); ?>

        </div>
        <div class="content">
            <p>Dear <strong>Admin & Costing Team</strong>,</p>
            
            <p>A uniform request has been <?php echo e($isUpdate ? 'updated' : 'created'); ?> with the following details:</p>
            
            <h3>Request Details</h3>
            <table>
                <tr>
                    <th>Request Number</th>
                    <td><?php echo e($request->request_number); ?></td>
                </tr>
                <tr>
                    <th>Prepared By</th>
                    <td><?php echo e($request->created_by); ?></td>
                </tr>
                <tr>
                    <th>Created Date</th>
                    <td><?php echo e($request->created_at ? $request->created_at->format('d M Y H:i') : '-'); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge badge-pending">Pending</span>
                    </td>
                </tr>
            </table>
            
            <p>You can view the complete request details by clicking the link below:</p>
            <p>
                <a href="https://portal.siix-ems.co.id/prod/uniform/request/show/<?php echo e($request->id); ?>" class="btn">
                    View Request Details
                </a>
            </p>
            <p>Please check it for the feedback process.</p>
            
            <p>Thank you,</p>
            <p>Best Regards,<br>Web Portal SIIX EMS Indonesia</p>
        </div>
        <div class="footer">
            <p>This is an automated notification from SIIX Uniform Request System.</p>
            <p>&copy; <?php echo e(date('Y')); ?> SIIX - All rights reserved.</p>
        </div>
    </div>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/emails/prod/uniform-request-created.blade.php ENDPATH**/ ?>