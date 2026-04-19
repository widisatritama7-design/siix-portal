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
            font-size: 9pt;
            line-height: 1.3;
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
            font-size: 8pt;
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
            font-size: 7pt;
        }
        
        table.data-table th {
            background: #1a56db;
            color: white;
            padding: 6px 4px;
            text-align: center;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        
        table.data-table td {
            padding: 5px 4px;
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
        
        .text-left {
            text-align: left;
        }
        
        .wrap-text {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }
        
        .col-no { width: 3%; }
        .col-nik { width: 8%; }
        .col-name { width: 10%; }
        .col-d1 { width: 8%; }
        .col-judge1 { width: 5%; }
        .col-d2 { width: 8%; }
        .col-judge2 { width: 5%; }
        .col-d3 { width: 8%; }
        .col-judge3 { width: 5%; }
        .col-d4 { width: 8%; }
        .col-judge4 { width: 5%; }
        .col-remarks { width: 10%; }
        .col-date { width: 6%; }
        .col-next-date { width: 6%; }
        .col-checked { width: 8%; }
        
        @page {
            size: A4 landscape;
            margin: 15px;
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
            ?</table>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($nik): ?>
                            <tr>
                                <td>NIK Filter</td>
                                <td colspan="3">: <?php echo e($nik); ?></td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($name): ?>
                            <tr>
                                <td>Name Filter</td>
                                <td colspan="3">: <?php echo e($name); ?></td>
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
                        ?</table>
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
            <div style="margin-top: 10px; padding-top: 8px; border-top: 1px solid #ddd; font-size: 8pt; text-align: left;">
                <strong>STANDARD ESD OF STATIC CONTROL GARMENT</strong><br>
                <div style="margin-top: 5px; font-size: 7.5pt;">
                    <div>( D1 ) Shirt Point To Point : < 1.00E+11 Ohm</div>
                    <div>( D2 ) Pants Point To Point : < 1.00E+11 Ohm</div>
                    <div>( D3 ) Cap Point To Point : < 1.00E+11 Ohm</div>
                    <div>( D4 ) Hijab Point To Point : < 1.00E+11 Ohm</div>
                </div>
            </div>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th class="col-nik">NIK</th>
                    <th class="col-name">Name</th>
                    <th class="col-d1">Shirt (D1)</th>
                    <th class="col-judge1">Judg</th>
                    <th class="col-d2">Pants (D2)</th>
                    <th class="col-judge2">Judg</th>
                    <th class="col-d3">Cap (D3)</th>
                    <th class="col-judge3">Judg</th>
                    <th class="col-d4">Hijab (D4)</th>
                    <th class="col-judge4">Judg</th>
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
                    <td class="text-center"><?php echo e($detail->garment->nik ?? $detail->nik); ?></td>
                    <td class="wrap-text"><?php echo e($detail->garment->name ?? $detail->name); ?></td>
                    <td class="text-center"><?php echo e($detail->d1_scientific ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_d1 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_d1 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center"><?php echo e($detail->d2_scientific ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_d2 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_d2 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center"><?php echo e($detail->d3_scientific ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_d3 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_d3 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center"><?php echo e($detail->d4_scientific ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($detail->judgement_d4 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                            <?php echo e($detail->judgement_d4 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="wrap-text"><?php echo e($detail->remarks ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->created_at ? $detail->created_at->format('d M Y') : '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->next_date ? \Carbon\Carbon::parse($detail->next_date)->format('d M Y') : '-'); ?></td>
                    <td class="wrap-text"><?php echo e($detail->creator->name ?? 'N/A'); ?></td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="15" class="text-center" style="padding: 20px;">
                        No data found for the selected filters.
                    </td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
        
        <div class="footer" style="font-weight: bold;">
            QR-ADM-22-K020
        </div>
    </div>
</body>
</html><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\livewire\esd\garment\garment-detail-pdf.blade.php ENDPATH**/ ?>