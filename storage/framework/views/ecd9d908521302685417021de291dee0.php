<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($isUpdate ? 'Uniform Request Updated' : 'New Uniform Request Created'); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        .header {
            background-color: #4F46E5;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px 8px 0 0;
            margin: -20px -20px 20px -20px;
        }
        .header h2 {
            margin: 0;
            font-size: 20px;
        }
        .content {
            padding: 20px;
        }
        .info-box {
            background-color: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .info-row {
            display: flex;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }
        .info-row:last-child {
            border-bottom: none;
        }
        .info-label {
            width: 130px;
            font-weight: 600;
            color: #4b5563;
        }
        .info-value {
            flex: 1;
            color: #1f2937;
        }
        .status-pending {
            background-color: #FEF3C7;
            color: #D97706;
            padding: 4px 12px;
            border-radius: 20px;
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
        }
        .button {
            display: inline-block;
            background-color: #4F46E5;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 8px;
            margin: 20px 0;
            font-weight: 600;
        }
        .button:hover {
            background-color: #4338CA;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
        .icon {
            font-size: 48px;
            text-align: center;
            margin-bottom: 10px;
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
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2><?php echo e($isUpdate ? 'Uniform Request Updated' : 'New Uniform Request Created'); ?></h2>
        </div>
        
        <div class="content">
            <p>Dear <strong>Admin & Costing Team</strong>,</p>
            
            <p>A uniform request has been <strong><?php echo e($isUpdate ? 'updated' : 'created'); ?></strong> with the following details:</p>
            
            <div class="info-box">
                <div class="info-row">
                    <div class="info-label">Request Number</div>
                    <div class="info-value"><strong><?php echo e($request->request_number); ?></strong></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Prepared By</div>
                    <div class="info-value"><?php echo e($request->created_by ?? 'System'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Created Date</div>
                    <div class="info-value"><?php echo e($request->created_at ? $request->created_at->format('d M Y H:i') : '-'); ?></div>
                </div>
                <div class="info-row">
                    <div class="info-label">Status</div>
                    <div class="info-value">
                        <span class="status-pending">⏳ Pending</span>
                    </div>
                </div>
            </div>
            
            <p>You can view the complete request details by clicking the link below:</p>
            
            <div class="text-center">
                <a href="<?php echo e(route('prod.uniform.request.show', $request->id)); ?>" class="button">
                    🔍 View Request Details
                </a>
            </div>
            
            <p>Please check it for the feedback process.</p>
            
            <p>Thank you,</p>
            <p><strong>Best Regards,</strong><br>Web Portal SIIX EMS Indonesia</p>
        </div>
        
        <div class="footer">
            <p>&copy; <?php echo e(date('Y')); ?> SIIX EMS Indonesia. All rights reserved.</p>
            <p>This is an automated message, please do not reply to this email.</p>
        </div>
    </div>
</body>
</html><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/emails/prod/uniform-request-created.blade.php ENDPATH**/ ?>