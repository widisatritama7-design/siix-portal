<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo e($title); ?></title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            font-size: 8pt;
            line-height: 1.2;
            margin: 15px;
            padding: 0;
        }
        
        .container {
            width: 100%;
            margin: 0 auto;
        }
        
        .header {
            text-align: center;
            margin-bottom: 15px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 16pt;
            color: #1a56db;
        }
        
        .report-info {
            margin-bottom: 15px;
            padding: 8px;
            background: #f3f4f6;
            border-radius: 5px;
            font-size: 7pt;
        }
        
        .report-info table {
            width: 100%;
        }
        
        .report-info td {
            padding: 2px 5px;
        }
        
        .report-info td:first-child {
            font-weight: bold;
            width: 100px;
        }
        
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 6.5pt;
        }
        
        table.data-table th {
            background: #1a56db;
            color: white;
            padding: 5px 3px;
            text-align: center;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        
        table.data-table td {
            padding: 4px 3px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        table.data-table tr:nth-child(even) {
            background: #f9fafb;
        }
        
        .footer {
            margin-top: 15px;
            text-align: center;
            font-size: 7pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            position: fixed;
            bottom: 10px;
            left: 0;
            right: 0;
        }
        
        .badge-ok {
            color: #059669;
            font-weight: bold;
        }
        
        .badge-ng {
            color: #dc2626;
            font-weight: bold;
        }
        
        .text-center {
            text-align: center;
        }
        
        .wrap-text {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }
        
        .col-no { width: 2%; }
        .col-register { width: 6%; }
        .col-area { width: 5%; }
        .col-location { width: 5%; }
        .col-pm1 { width: 4%; }
        .col-pm2 { width: 4%; }
        .col-pm3 { width: 4%; }
        .col-c1b { width: 5%; }
        .col-judge1b { width: 3%; }
        .col-c2b { width: 5%; }
        .col-judge2b { width: 3%; }
        .col-c3b { width: 5%; }
        .col-judge3b { width: 3%; }
        .col-c1 { width: 5%; }
        .col-judge1 { width: 3%; }
        .col-c2 { width: 5%; }
        .col-judge2 { width: 3%; }
        .col-c3 { width: 5%; }
        .col-judge3 { width: 3%; }
        .col-remarks { width: 7%; }
        .col-date { width: 5%; }
        .col-next-date { width: 5%; }
        .col-checked { width: 6%; }
        
        @page {
            size: A4 landscape;
            margin: 10px;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .footer {
                position: fixed;
                bottom: 0;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <table style="width: 100%; border: none;">
                <tr>
                    <td style="width: 80px; text-align: left; vertical-align: middle; border: none;">
                        <img src="<?php echo e(public_path('images/siix-logo.png')); ?>" alt="SIIX Logo" style="height: 50px; width: auto;">
                    </td>
                    <td style="text-align: center; vertical-align: middle; border: none;">
                        <h1 style="margin: 0;"><?php echo e($title); ?></h1>
                    </td>
                    <td style="width: 80px; text-align: right; vertical-align: middle; border: none;">
                        <img src="<?php echo e(public_path('images/esd-logo.png')); ?>" alt="ESD Logo" style="height: 50px; width: auto;">
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="report-info">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 100px;">Print By</td>
                                <td>: <?php echo e($generated_by); ?></td>
                            </tr>
                            <tr>
                                <td>Print Date</td>
                                <td>: <?php echo e($generated_at); ?></td>
                            </tr>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($register_no): ?>
                            <tr>
                                <td>Register No Filter</td>
                                <td colspan="3">: <?php echo e($register_no); ?></td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($date_from || $date_until): ?>
                            <tr>
                                <td>Date Range</td>
                                <td colspan="3">: 
                                    <?php echo e($date_from ? \Carbon\Carbon::parse($date_from)->format('d M Y') : 'Start'); ?> 
                                    to 
                                    <?php echo e($date_until ? \Carbon\Carbon::parse($date_until)->format('d M Y') : 'End'); ?>

                                </td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <tr>
                                <td>Total Records</td>
                                <td colspan="3">: <?php echo e($details->count()); ?> Record(s)</td>
                            </tr>
                        </table>
                    </td>
                    <td style="width: 50%; vertical-align: top;">
                        <table style="width: 100%;">
                            <tr>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>PREPARED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( <?php echo e('_________________'); ?> )</span>
                                </td>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>CHECKED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( <?php echo e('_________________'); ?> )</span>
                                </td>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>APPROVED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( <?php echo e('_________________'); ?> )</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <div style="margin-top: 10px; padding: 6px 8px; background: #e8f0fe; border-radius: 4px; font-size: 7pt; text-align: left; border-top: 1px solid #ddd;">
                <strong>STANDARD ESD OF IONIZER</strong><br>
                <div style="margin-top: 4px;">
                    <div>• (PM 1) Check H.V light flashing condition. If the indicator is flashing, record as NG and perform inspection immediately.</div>
                    <div>• (PM 2) Check and clean the discharge electrode needle. Result: OK / NG.</div>
                    <div>• (PM 3) Clean up filter and fan. Perform verification after PM (Preventive Maintenance).</div>
                    <div>• (C1) Measure Charge Decay Time (+), from 1,000V to 100V &lt; 8.0 seconds.</div>
                    <div>• (C2) Measure Charge Decay Time (-), from 1,000V to 100V &lt; 8.0 seconds.</div>
                    <div>• (C3) Measure Offset Voltage, voltage swing within ±35V in 30 seconds.</div>
                </div>
            </div>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th class="col-register">Register No</th>
                    <th class="col-area">Area</th>
                    <th class="col-location">Location</th>
                    <th class="col-pm1">PM 1</th>
                    <th class="col-pm2">PM 2</th>
                    <th class="col-pm3">PM 3</th>
                    <th class="col-c1b">C1 Before</th>
                    <th class="col-judge1b">Jdg</th>
                    <th class="col-c2b">C2 Before</th>
                    <th class="col-judge2b">Jdg</th>
                    <th class="col-c3b">C3 Before</th>
                    <th class="col-judge3b">Jdg</th>
                    <th class="col-c1">C1</th>
                    <th class="col-judge1">Jdg</th>
                    <th class="col-c2">C2</th>
                    <th class="col-judge2">Jdg</th>
                    <th class="col-c3">C3</th>
                    <th class="col-judge3">Jdg</th>
                    <th class="col-remarks">Remarks</th>
                    <th class="col-date">Date</th>
                    <th class="col-next-date">Next Date</th>
                    <th class="col-checked">Checked By</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td class="text-center"><?php echo e($detail->ionizer->register_no ?? 'N/A'); ?></td>
                    <td class="wrap-text"><?php echo e($detail->ionizer->area ?? 'N/A'); ?></td>
                    <td class="wrap-text"><?php echo e($detail->ionizer->location ?? 'N/A'); ?></td>
                    <td class="text-center"><?php echo e($detail->pm_1 ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->pm_2 ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->pm_3 ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->c1_before ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_c1_before == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_c1_before ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center"><?php echo e($detail->c2_before ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_c2_before == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_c2_before ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center"><?php echo e($detail->c3_before ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_c3_before == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_c3_before ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center"><?php echo e($detail->c1 ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_c1 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_c1 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center"><?php echo e($detail->c2 ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_c2 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_c2 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center"><?php echo e($detail->c3 ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_c3 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_c3 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="wrap-text"><?php echo e($detail->remarks ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->created_at ? $detail->created_at->format('d M Y') : '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->next_date ? \Carbon\Carbon::parse($detail->next_date)->format('d M Y') : '-'); ?></td>
                    <td class="wrap-text"><?php echo e($detail->creator->name ?? 'N/A'); ?></td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="23" class="text-center" style="padding: 20px;">
                        No data found for the selected filters.
                    </td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
        
        <div class="footer" style="font-weight: bold;">
            QR-ADM-22-K017
        </div>
    </div>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/esd/ionizer/ionizer-detail-pdf.blade.php ENDPATH**/ ?>