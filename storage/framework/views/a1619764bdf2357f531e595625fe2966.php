<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Daily Check Report - Shift <?php echo e($shift); ?></title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f4f6f8;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        .email-wrapper {
            max-width: 720px;
            background: #ffffff;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            padding: 20px 25px;
            border: 1px solid #e5e8eb;
        }

        h2 {
            color: #1a73e8;
            font-size: 18px;
            margin: 0 0 8px 0;
            display: flex;
            align-items: center;
        }
        h2::before {
            content: "📋";
            margin-right: 6px;
        }

        p {
            margin: 4px 0;
            font-size: 13px;
        }

        .info {
            background: #f8faff;
            border-left: 4px solid #1a73e8;
            border-radius: 4px;
            padding: 10px 12px;
            margin: 12px 0;
            font-size: 13px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 13px;
        }

        th {
            background-color: #1a73e8;
            color: #fff;
            padding: 8px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #1a73e8;
        }

        td {
            border: 1px solid #e2e5e9;
            padding: 7px;
            text-align: center;
        }

        tr:nth-child(even) td {
            background: #f9fbfd;
        }

        .status {
            font-weight: 600;
        }
        .checked { color: #2e7d32; }     /* Green */
        .progress { color: #ff9800; }    /* Orange */
        .delay { color: #d32f2f; }       /* Red */

        .footer {
            font-size: 12px;
            color: #777;
            margin-top: 15px;
            border-top: 1px solid #eee;
            padding-top: 8px;
        }
    </style>
</head>
<body>
    <div class="email-wrapper">
        <h2>Daily Check Report - Shift <?php echo e($shift); ?></h2>
        <p><strong>🕒 Tanggal:</strong> <?php echo e($date->format('Y-m-d')); ?> (<?php echo e($timeRange); ?>)</p>

        <div class="info">
            <p>Silakan tinjau status masing-masing line di bawah ini. <br>Status dapat berupa:</p>
            ✅ <strong>Checked</strong> &nbsp;&nbsp;
            🟡 <strong>On Progress</strong> &nbsp;&nbsp;
            ⚠️ <strong>Delay</strong>
        </div>

        <table>
            <thead>
                <tr>
                    <th>📍 Location</th>
                    <th>🔢 Line Number</th>
                    <th>📌 Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                    <tr>
                        <td><?php echo e($row['location_name']); ?></td>
                        <td><?php echo e($row['line_number']); ?></td>
                        <td class="status
                            <?php if($row['status'] === 'Checked'): ?> checked
                            <?php elseif($row['status'] === 'On Progress'): ?> progress
                            <?php else: ?> delay <?php endif; ?>">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($row['status'] === 'Checked'): ?>
                                ✅ Checked
                            <?php elseif($row['status'] === 'On Progress'): ?>
                                🟡 On Progress
                            <?php else: ?>
                                ⚠️ Delay
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </td>
                    </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
        </table>

        <p class="footer">
            Dikirim otomatis oleh <strong>SEK Apps Notification</strong><br>
            Mohon tidak membalas email ini.
        </p>
    </div>
</body>
</html>
<?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/emails/mtc/daily-check-report.blade.php ENDPATH**/ ?>