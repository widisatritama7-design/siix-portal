<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Master Sample Expired Reminder</title>
</head>
<body style="margin:0; padding:0; background:#f4f6f9; font-family: Arial, Helvetica, sans-serif; color:#333;">
    <div style="max-width:600px; margin:24px auto; background:#fff; border-radius:8px; overflow:hidden; box-shadow:0 2px 8px rgba(0,0,0,0.08);">

        <!-- Header -->
        <div style="background:#dc3545; color:#fff; padding:24px 30px;">
            <h1 style="margin:0; font-size:20px;">Master Sample Expired Reminder</h1>
            <p style="margin:6px 0 0; font-size:13px; opacity:.9;">
                Periode: <strong><?php echo e($periodLabel); ?></strong>
            </p>
        </div>

        <!-- Content -->
        <div style="padding:28px 30px;">
            <p style="font-size:14px; line-height:1.6; margin:0 0 16px;">
                Yth. Tim Quality,
            </p>

            <p style="font-size:14px; line-height:1.6; margin:0 0 16px;">
                Berdasarkan pengecekan otomatis sistem, terdapat
                <strong style="color:#dc3545; font-size:16px;"><?php echo e($total); ?> master sample</strong>
                yang akan <strong>expired pada bulan <?php echo e($periodLabel); ?></strong>.
            </p>

            <div style="background:#fff3cd; border-left:4px solid #ffc107; padding:14px 18px; border-radius:4px; margin:20px 0; font-size:13.5px; line-height:1.5;">
                Detail lengkap seluruh sample terlampir dalam file PDF pada email ini.
                Mohon segera lakukan tindak lanjut (perpanjangan / update status / penggantian sample).
            </div>

            <p style="font-size:13.5px; line-height:1.6; margin:20px 0 8px;">
                <strong>Ringkasan:</strong>
            </p>
            <ul style="font-size:13.5px; line-height:1.7; margin:0 0 20px; padding-left:20px;">
                <li>Total sample expired bulan ini: <strong><?php echo e($total); ?> item</strong></li>
                <li>File terlampir: <code style="background:#f1f3f5; padding:2px 6px; border-radius:3px; font-size:12px;">master-sample-expired-<?php echo e(now()->format('Y-m')); ?>.pdf</code></li>
                <li>Dikirim otomatis setiap <strong>Senin pukul 08:00 WIB</strong></li>
            </ul>

            <p style="font-size:13.5px; line-height:1.6; margin:0;">
                Terima kasih atas perhatian dan tindak lanjutnya.
            </p>
        </div>

        <!-- Footer -->
        <div style="padding:16px 30px; font-size:11px; color:#888; border-top:1px solid #eee; text-align:center; background:#fafbfc;">
            Email otomatis dari Sistem Master Sample Management — mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/emails/prod/expired-master-sample.blade.php ENDPATH**/ ?>