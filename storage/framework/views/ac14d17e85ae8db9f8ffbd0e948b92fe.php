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
        
        /* Font utama dengan dukungan Unicode penuh */
        body {
            font-family: 'DejaVu Sans', 'Arial', 'Segoe UI', 'Helvetica', sans-serif;
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
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        .report-info {
            margin-bottom: 15px;
            padding: 8px;
            background: #f3f4f6;
            border-radius: 5px;
            font-size: 8pt;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
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
            font-size: 8pt;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        table.data-table th {
            background: #1a56db;
            color: white;
            padding: 6px 4px;
            text-align: center;
            border: 1px solid #ddd;
            font-weight: bold;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        table.data-table td {
            padding: 5px 4px;
            border: 1px solid #ddd;
            vertical-align: top;
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
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
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
        }
        
        .badge-good {
            color: #059669;
            font-weight: bold;
        }
        
        .badge-not-good {
            color: #dc2626;
            font-weight: bold;
        }
        
        .badge-connected {
            color: #059669;
            font-weight: bold;
        }
        
        .badge-not-connected {
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
        .col-area { width: 10%; }
        .col-location { width: 10%; }
        .col-v1 { width: 8%; }
        .col-v2 { width: 8%; }
        .col-v3 { width: 6%; }
        .col-judge-v3 { width: 8%; }
        .col-v4 { width: 8%; }
        .col-remarks { width: 15%; }
        .col-check-by { width: 10%; }
        .col-date { width: 8%; }
        .col-next-date { width: 8%; }
        
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($area_filter): ?>
                            <tr>
                                <td>Area Filter</td>
                                <td colspan="3">: <?php echo e($area_filter); ?></td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($location_filter): ?>
                            <tr>
                                <td>Location Filter</td>
                                <td colspan="3">: <?php echo e($location_filter); ?></td>
                            </tr>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($judgement_filter): ?>
                            <tr>
                                <td>Judgement V3 Filter</td>
                                <td colspan="3">: <?php echo e($judgement_filter); ?></td>
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
            <div style="margin-top: 10px; padding: 6px 8px; background: #e8f0fe; border-radius: 4px; font-size: 8pt; text-align: left; border-top: 1px solid #ddd;">
                <strong>STANDARD ESD PATROL CHECK SHEET</strong><br>
                <div style="margin-top: 4px;">
                    <div>• <strong>V-1 Grounding System Check:</strong> Ensure there is no damage or disconnected cable connections</div>
                    <div>• <strong>V-2 ESD Protection Equipment Verification:</strong> Ensure ionizers and continuous monitors are in good and effective condition</div>
                    <div>• <strong>V-3 Humidity Check:</strong> Ensure the humidity level in the EPA area is within the standard range of 35% - 65%</div>
                    <div>• <strong>V-4 ESD Measuring Instrument Testing:</strong> Ensure the equipment functions properly and accurately according to SW-ZZ-052</div>
                    <div>• <strong>Frequency:</strong> Daily 08:00 - 09:00</div>
                </div>
            </div>
        </div>
        
        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th class="col-area">Area</th>
                    <th class="col-location">Location</th>
                    <th class="col-v1">V1</th>
                    <th class="col-v2">V2</th>
                    <th class="col-v3">V3</th>
                    <th class="col-judge-v3">Judgement V3</th>
                    <th class="col-v4">V4</th>
                    <th class="col-remarks">Remarks</th>
                    <th class="col-check-by">Checked By</th>
                    <th class="col-date">Date</th>
                    <th class="col-next-date">Next Date</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $patrol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td class="text-center"><?php echo e($patrol->area ?? 'N/A'); ?></td>
                    <td class="text-center"><?php echo e($patrol->location ?? '-'); ?></td>
                    <td class="text-center">
                        <span class="<?php echo e($patrol->v_1 == 'Connected' ? 'badge-connected' : 'badge-not-connected'); ?>">
                            <?php echo e($patrol->v_1 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center">
                        <span class="<?php echo e($patrol->v_2 == 'Good' ? 'badge-good' : 'badge-not-good'); ?>">
                            <?php echo e($patrol->v_2 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center">
                        <?php
                            $v3Value = $patrol->v_3;
                            if (is_numeric($v3Value)) {
                                echo number_format(floatval($v3Value), 2);
                            } else {
                                echo '-';
                            }
                        ?>
                    </td>
                    <td class="text-center">
                        <span class="<?php echo e($patrol->judgement_v3 == 'Good' ? 'badge-good' : 'badge-not-good'); ?>">
                            <?php echo e($patrol->judgement_v3 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="text-center">
                        <span class="<?php echo e($patrol->v_4 == 'Good' ? 'badge-good' : 'badge-not-good'); ?>">
                            <?php echo e($patrol->v_4 ?? '-'); ?>

                        </span>
                    </td>
                    <td class="wrap-text"><?php echo e($patrol->remarks ?? '-'); ?></td>
                    <td class="wrap-text"><?php echo e($patrol->creator->name ?? 'N/A'); ?></td>
                    <td class="text-center"><?php echo e($patrol->created_at ? $patrol->created_at->format('d M Y') : '-'); ?></td>
                    <td class="text-center"><?php echo e($patrol->next_date ? \Carbon\Carbon::parse($patrol->next_date)->format('d M Y') : '-'); ?></td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="12" class="text-center" style="padding: 20px;">
                        No data found for the selected filters.
                    </td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>
        
        <div class="footer" style="font-weight: bold;">
            QR-ADM-24-K063
        </div>
    </div>
</body>
</html><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\livewire\esd\patrol\patrol-pdf.blade.php ENDPATH**/ ?>