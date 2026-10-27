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
            font-family: 'DejaVu Sans', 'Arial', sans-serif;
            font-size: 8pt;
            line-height: 1.25;
            margin: 12px;
            padding: 0;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 12px;
            border-bottom: 2px solid #333;
            padding-bottom: 8px;
        }

        .header h1 {
            margin: 0;
            font-size: 15pt;
            color: #1a56db;
        }

        .report-info {
            margin-bottom: 12px;
            padding: 8px;
            background: #f3f4f6;
            border-radius: 5px;
            font-size: 7.5pt;
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
            margin-top: 8px;
            font-size: 6.5pt;
        }

        table.data-table th {
            background: #1a56db;
            color: white;
            padding: 5px 3px;
            text-align: center;
            border: 1px solid #ddd;
            font-weight: bold;
            font-size: 6pt;
            line-height: 1.15;
        }

        table.data-table td {
            padding: 4px 3px;
            border: 1px solid #ddd;
            vertical-align: middle;
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

        .badge-ok { color: #059669; font-weight: bold; }
        .badge-ng { color: #dc2626; font-weight: bold; }

        .text-center { text-align: center; }
        .text-left { text-align: left; }

        .wrap-text {
            word-wrap: break-word;
            word-break: break-all;
            white-space: normal;
        }

        .col-no { width: 2%; }
        .col-register { width: 10%; }
        .col-s1 { width: 9%; }
        .col-judge1 { width: 4.5%; }
        .col-s2 { width: 9%; }
        .col-judge2 { width: 4.5%; }
        .col-s3 { width: 5%; }
        .col-remarks { width: 13%; }
        .col-date { width: 7.5%; }
        .col-next-date { width: 7.5%; }
        .col-created-by { width: 10%; }

        @page {
            size: A4 landscape;
            margin: 12px;
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
                                    <span style="font-size: 7pt;">( _________________ )</span>
                                </td>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>CHECKED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( _________________ )</span>
                                </td>
                                <td style="text-align: center; padding: 0 10px; width: 33%;">
                                    <strong>APPROVED BY</strong><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">&nbsp;</span><br>
                                    <span style="font-size: 7pt;">( _________________ )</span>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>

            <div style="margin-top: 10px; padding: 6px 8px; background: #e8f0fe; border-radius: 4px; font-size: 7pt; text-align: left; border-top: 1px solid #ddd;">
                <strong>STANDARD ESD OF SCISSORS</strong>
                <div style="margin-top: 4px;">
                    <div>• (S-1) Scissors Point To Point : ≥ 1.00E+4 - &lt; 1.00E+11 ohm</div>
                    <div>• (S-2) Scissors Static Voltage : &lt; 100 V</div>
                    <div style="margin-top: 3px;"><strong>• (S3) Visual Inspection Checklist</strong></div>
                    <div style="padding-left: 12px;">• (S-3.1) Handle/pegangan tidak rusak : YES</div>
                    <div style="padding-left: 12px;">• (S-3.2) Tidak terdapat modifikasi atau coating/material tambahan yang tidak sesuai : YES</div>
                </div>
            </div>
        </div>

        <table class="data-table">
            <thead>
                <tr>
                    <th class="col-no">#</th>
                    <th class="col-register">Register No</th>
                    <th class="col-s1">S-1 Result</th>
                    <th class="col-judge1">Judg</th>
                    <th class="col-s2">S-2 Result</th>
                    <th class="col-judge2">Judg</th>
                    <th class="col-s3">S-3.1</th>
                    <th class="col-s3">S-3.2</th>
                    <th class="col-remarks">Remarks</th>
                    <th class="col-date">Date</th>
                    <th class="col-next-date">Next Date</th>
                    <th class="col-created-by">Checked By</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td class="text-center"><?php echo e($index + 1); ?></td>
                    <td class="text-center"><?php echo e($detail->scissors->register_no ?? 'N/A'); ?></td>
                    
                    
                    <td class="text-center"><?php echo e($detail->s_1_scientific ?? '-'); ?></td>
                    
                    
                    <td class="text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail->judgement_s_1): ?>
                            <span class="<?php echo e($detail->judgement_s_1 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                                <?php echo e($detail->judgement_s_1); ?>

                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>

                    
                    <td class="text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail->s_2 !== null): ?>
                            <?php echo e(number_format((float)$detail->s_2, 2)); ?> V
                        <?php else: ?>
                            -
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>

                    
                    <td class="text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail->judgement_s_2): ?>
                            <span class="<?php echo e($detail->judgement_s_2 == 'OK' ? 'badge-ok' : 'badge-ng'); ?>">
                                <?php echo e($detail->judgement_s_2); ?>

                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>

                    
                    <td class="text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail->s_3_1 !== null): ?>
                            <span class="<?php echo e($detail->s_3_1 ? 'badge-ok' : 'badge-ng'); ?>">
                                <?php echo e($detail->s_3_1 ? 'Yes' : 'No'); ?>

                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>

                    
                    <td class="text-center">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($detail->s_3_2 !== null): ?>
                            <span class="<?php echo e($detail->s_3_2 ? 'badge-ok' : 'badge-ng'); ?>">
                                <?php echo e($detail->s_3_2 ? 'Yes' : 'No'); ?>

                            </span>
                        <?php else: ?>
                            -
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </td>

                    <td class="wrap-text"><?php echo e($detail->remarks ?? '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->created_at ? $detail->created_at->format('d M Y') : '-'); ?></td>
                    <td class="text-center"><?php echo e($detail->next_date ? \Carbon\Carbon::parse($detail->next_date)->format('d M Y') : '-'); ?></td>
                    <td class="wrap-text"><?php echo e($detail->creator->name ?? 'N/A'); ?></td>
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
            QR-ENG-26-K007
        </div>
    </div>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/esd/scissors/scissors-detail-pdf.blade.php ENDPATH**/ ?>