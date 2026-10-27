<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Master Sample Expired Report</title>
    <style>
        @page { margin: 20px 22px; }
        * { box-sizing: border-box; }
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10.5px;
            color: #222;
            margin: 0;
        }

        /* Header */
        .header {
            border-bottom: 3px solid #dc3545;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header h1 {
            font-size: 17px;
            margin: 0 0 4px 0;
            color: #dc3545;
        }
        .header .subtitle {
            font-size: 11px;
            color: #555;
        }
        .header .meta {
            float: right;
            text-align: right;
            font-size: 9.5px;
            color: #666;
            margin-top: -34px;
        }

        /* Summary Box */
        .summary {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px 14px;
            margin-bottom: 14px;
            font-size: 11px;
            border-radius: 3px;
        }
        .summary strong { color: #856404; }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
        }
        thead th {
            background: #343a40;
            color: #fff;
            text-align: left;
            padding: 8px 7px;
            font-size: 10px;
            font-weight: bold;
            border: 1px solid #2c3136;
        }
        tbody td {
            padding: 7px;
            border: 1px solid #dee2e6;
            vertical-align: top;
            line-height: 1.35;
        }
        tbody tr:nth-child(even) td {
            background: #f8f9fa;
        }
        td.center { text-align: center; }
        td.nowrap { white-space: nowrap; }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 8px;
            font-size: 9px;
            font-weight: bold;
            white-space: nowrap;
        }
        .badge-danger  { background: #f8d7da; color: #721c24; }
        .badge-warning { background: #fff3cd; color: #856404; }
        .badge-info    { background: #d1ecf1; color: #0c5460; }

        /* Footer */
        .footer {
            position: fixed;
            bottom: -10px;
            left: 0;
            right: 0;
            font-size: 8.5px;
            color: #888;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 6px;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #28a745;
            font-size: 12px;
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <h1>Master Sample Expired Report</h1>
        <div class="subtitle">
            Periode: <strong><?php echo e($periodLabel); ?></strong> &nbsp;|&nbsp; Total: <strong><?php echo e($total); ?> item</strong>
        </div>
        <div class="meta">
            Generated: <?php echo e($generatedAt); ?><br>
            Sistem Master Sample Management
        </div>
    </div>

    <!-- Summary -->
    <div class="summary">
        Terdapat <strong><?php echo e($total); ?></strong> master sample yang akan expired pada bulan
        <strong><?php echo e($periodLabel); ?></strong>. Mohon segera lakukan tindak lanjut.
    </div>

    <!-- Table -->
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($total === 0): ?>
        <div class="empty">✅ Tidak ada master sample yang expired bulan ini.</div>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th style="width: 28px;">#</th>
                <th style="width: 18%;">Model Name</th>
                <th style="width: 12%;">Customer</th>
                <th style="width: 10%;">Name / MC</th>
                <th style="width: 22%;">Rack</th>
                <th style="width: 10%;">Expired Date</th>
                <th style="width: 10%;">Sisa Hari</th>
                <th style="width: 10%;">Status</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $samples; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sample): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $expired = \Carbon\Carbon::parse($sample->expired_date)->startOfDay();
                    $diff = \Carbon\Carbon::today()->diffInDays($expired, false);
                    if ($diff < 0) {
                        $badgeClass = 'badge-danger';
                        $label = 'Overdue ' . abs($diff) . ' hari';
                    } elseif ($diff === 0) {
                        $badgeClass = 'badge-danger';
                        $label = 'Hari ini';
                    } elseif ($diff <= 7) {
                        $badgeClass = 'badge-warning';
                        $label = $diff . ' hari';
                    } else {
                        $badgeClass = 'badge-info';
                        $label = $diff . ' hari';
                    }
                ?>
                <tr>
                    <td class="center"><?php echo e($i + 1); ?></td>
                    <td><strong><?php echo e($sample->model_name); ?></strong></td>
                    <td><?php echo e($sample->customer); ?></td>
                    <td><?php echo e($sample->name_or_mc); ?></td>
                    <td><?php echo e($sample->rack_label ?? '-'); ?></td>
                    <td class="nowrap"><?php echo e(\Carbon\Carbon::parse($sample->expired_date)->format('d M Y')); ?></td>
                    <td class="center"><span class="badge <?php echo e($badgeClass); ?>"><?php echo e($label); ?></span></td>
                    <td class="center"><?php echo e($sample->status ?? 'ACTIVE'); ?></td>
                </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
        </tbody>
    </table>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    <!-- Footer -->
    <div class="footer">
        Dokumen digenerate otomatis oleh Sistem Master Sample Management pada <?php echo e($generatedAt); ?>.
    </div>

</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/emails/prod/expired-master-sample-pdf.blade.php ENDPATH**/ ?>