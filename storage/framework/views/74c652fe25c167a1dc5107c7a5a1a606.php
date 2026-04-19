<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Panasonic Checklist - <?php echo e($dailyPanasonic->created_at->format('Y-m-d')); ?></title>
    <style>
        @page {
            margin: 1cm;
            size: A4;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 11px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 16px;
            color: #2c3e50;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin-bottom: 15px;
            font-size: 10px;
        }
        
        .info-item {
            border: 1px solid #ddd;
            padding: 6px;
            border-radius: 3px;
            background: #f9f9f9;
        }
        
        .info-label {
            font-weight: bold;
            color: #7f8c8d;
            font-size: 9px;
        }
        
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }
        
        .checklist-table th {
            background-color: #34495e;
            color: white;
            padding: 6px 8px;
            text-align: left;
            font-size: 10px;
            border: 1px solid #2c3e50;
        }
        
        .checklist-table td {
            padding: 5px 8px;
            border: 1px solid #ddd;
            vertical-align: top;
            font-size: 10px;
        }
        
        .wizard-header {
            background-color: #3498db !important;
            font-weight: bold;
            font-size: 11px !important;
            color: #ffffff;
        }
        
        .section-header {
            background-color: #ecf0f1 !important;
            font-weight: bold;
        }
        
        .item-name {
            font-weight: 500;
            width: 25%;
        }
        
        .item-standard {
            width: 35%;
            color: #7f8c8d;
            font-style: italic;
        }
        
        .item-value {
            width: 20%;
            text-align: center;
            font-weight: bold;
        }
        
        .item-status {
            width: 20%;
            text-align: center;
        }
        
        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 10px;
            font-size: 9px;
            font-weight: bold;
        }

        .status-checked {
            background-color: #d4edda;
            color: #155724;
        }

        .status-na {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .badge-success { background-color: #28a745; color: #fff; }
        .badge-danger { background-color: #dc3545; color: #fff; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-secondary { background-color: #6c757d; color: #fff; }

        .table-header th {
            font-weight: bold;
            color: #000;
            background-color: #ffffff;
            border-bottom: 1px solid #b3acac;
            border-right: 2px solid #b3acac;
            border-left: 1px solid #b3acac;
            border-top: 1px solid #b3acac;
            padding: 12px 8px;
            text-transform: uppercase;
            font-size: 10px;
            text-align: center;
        }
        
        .value-ok {
            color: #28a745;
        }
        
        .value-not-ok {
            color: #dc3545;
        }
        
        .signature-area {
            margin-top: 20px;
            border-top: 1px solid #333;
            padding-top: 10px;
            font-size: 10px;
        }
        
        .signature-box {
            display: inline-block;
            width: 200px;
            text-align: center;
            margin: 0 15px;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            padding-bottom: 3px;
            margin-bottom: 5px;
        }
        
        .no-print {
            text-align: center;
            padding: 8px;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            .table-header th,
            .wizard-header,
            .section-header,
            .badge-success,
            .badge-danger,
            .badge-warning,
            .badge-secondary,
            .status-checked,
            .status-na {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="no-print">
        <button onclick="window.print()" style="padding: 6px 12px; background: #3498db; color: white; border: none; border-radius: 3px; cursor: pointer; font-size: 11px;">
            🖨️ Print Checklist
        </button>
        <button onclick="window.close()" style="padding: 6px 12px; background: #e74c3c; color: white; border: none; border-radius: 3px; cursor: pointer; margin-left: 8px; font-size: 11px;">
            ❌ Close
        </button>
    </div>

    <div class="header">
        <h1>MACHINE DAILY ROUTINE INSPECTION CHECKLIST - PANASONIC</h1>
        <div style="font-size: 12px; color: #7f8c8d;">Print Date: <?php echo e(now()->format('Y-m-d H:i')); ?></div>
    </div>

    <!-- Information Grid 5 Columns -->
    <div class="info-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;">
        <!-- PRODUCTION SMT LINE -->
        <div class="info-item">
            <div class="info-label">PRODUCTION SMT LINE</div>
            <div><?php echo e($dailyPanasonic->masterLine->line_number ?? 'N/A'); ?></div>
        </div>

        <!-- GROUP -->
        <div class="info-item">
            <div class="info-label">GROUP</div>
            <div><?php echo e($dailyPanasonic->group); ?></div>
        </div>

        <!-- RUN TIME -->
        <div class="info-item">
            <div class="info-label">RUN TIME</div>
            <div>
                <span class="status-badge badge-success">
                    <?php echo e($dailyPanasonic->run_time ? $dailyPanasonic->run_time->format('H:i') : 'N/A'); ?>

                </span>
            </div>
        </div>

        <!-- STOP TIME -->
        <div class="info-item">
            <div class="info-label">STOP TIME</div>
            <div>
                <span class="status-badge badge-danger">
                    <?php echo e($dailyPanasonic->stop_time ? $dailyPanasonic->stop_time->format('H:i') : 'N/A'); ?>

                </span>
            </div>
        </div>

        <!-- STATUS -->
        <div class="info-item">
            <div class="info-label">STATUS</div>
            <div>
                <?php
                    $statusColor = match($dailyPanasonic->status) {
                        'Checked' => 'badge-success',
                        'On Progress' => 'badge-warning',
                        'Delay' => 'badge-danger',
                        'Holiday' => 'badge-secondary',
                        default => 'badge-secondary',
                    };
                ?>
                <span class="status-badge <?php echo e($statusColor); ?>"><?php echo e($dailyPanasonic->status); ?></span>
            </div>
        </div>

        <!-- APPROVAL -->
        <div class="info-item">
            <div class="info-label">APPROVAL</div>
            <div>
                <?php
                    $approvalColor = match($dailyPanasonic->approval) {
                        'Approved' => 'badge-success',
                        'Rejected' => 'badge-danger',
                        'Pending' => 'badge-warning',
                        default => 'badge-secondary',
                    };
                ?>
                <span class="status-badge <?php echo e($approvalColor); ?>">
                    <?php echo e(strtoupper($dailyPanasonic->approval ?? 'N/A')); ?>

                </span>
            </div>
        </div>

        <!-- APPROVED BY -->
        <div class="info-item">
            <div class="info-label">APPROVED BY</div>
            <div><?php echo e($dailyPanasonic->approvedBy->name ?? 'N/A'); ?></div>
        </div>

        <!-- CHECK BY -->
        <div class="info-item">
            <div class="info-label">CHECK BY</div>
            <div><?php echo e($dailyPanasonic->updater->name ?? 'N/A'); ?></div>
        </div>

        <!-- START INSPECTION DATE -->
        <div class="info-item">
            <div class="info-label">START INSPECTION</div>
            <div><?php echo e($dailyPanasonic->created_at->format('d F Y H:i')); ?></div>
        </div>

        <!-- FINISH INSPECTION DATE -->
        <div class="info-item">
            <div class="info-label">FINISH INSPECTION</div>
            <div><?php echo e($dailyPanasonic->updated_at->format('d F Y H:i')); ?></div>
        </div>

    </div>

    <!-- Checklist Table -->
    <table class="checklist-table">
        <thead>
            <tr class="table-header">
                <th>INSPECTION ITEM</th>
                <th>STANDARD</th>
                <th>ACTUAL VALUE</th>
                <th>STATUS</th>
            </tr>
        </thead>
        <tbody>
            <?php
                function displayValue($value) {
                    if ($value === null || $value === '') return 'N/A';
                    if ($value === 'checked') return '✓';
                    if ($value === 'na') return '-';
                    return $value;
                }

                function getValueClass($value, $standard) {
                    if ($value === null || $value === '' || $value === 'na' || $value === '-') return '';
                    
                    if (is_numeric($value)) {
                        $numValue = floatval($value);
                        
                        // Standard dengan range (contoh: "0.45 - 0.54 Mpa")
                        if (preg_match('/(\d+\.?\d*)\s*-\s*(\d+\.?\d*)/', $standard, $matches)) {
                            $min = floatval($matches[1]);
                            $max = floatval($matches[2]);
                            return ($numValue >= $min && $numValue <= $max) ? 'value-ok' : 'value-not-ok';
                        }
                        
                        // Standard dengan lebih besar dari (contoh: "> 1.67")
                        if (preg_match('/>\s*(\d+\.?\d*)/', $standard, $matches)) {
                            $threshold = floatval($matches[1]);
                            return ($numValue > $threshold) ? 'value-ok' : 'value-not-ok';
                        }
                        
                        // Standard dengan lebih kecil dari (contoh: "<= 40")
                        if (preg_match('/<\s*=\s*(\d+\.?\d*)/', $standard, $matches)) {
                            $threshold = floatval($matches[1]);
                            return ($numValue <= $threshold) ? 'value-ok' : 'value-not-ok';
                        }
                    }
                    
                    return '';
                }
            ?>

            <!-- STEP 1: GENERAL -->
            <tr class="wizard-header">
                <td colspan="4">1. GENERAL</td>
            </tr>
            <tr class="section-header">
                <td colspan="4">ALL MACHINE BODY</td>
            </tr>
            <tr>
                <td class="item-name">Body Cover</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->body_cover, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->body_cover)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->body_cover === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->body_cover === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 2: LOADER -->
            <tr class="wizard-header">
                <td colspan="4">2. LOADER</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">PUSHER</td>
            </tr>
            <tr>
                <td class="item-name">Cylinder (1)</td>
                <td class="item-standard">Standard: Smooth and center</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->cylinder, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->cylinder)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->cylinder === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->cylinder === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">MAGAZINE</td>
            </tr>
            <tr>
                <td class="item-name">Rail & Magazine PCB (1.a)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->rail_and_magazine_pcb, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->rail_and_magazine_pcb)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->rail_and_magazine_pcb === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->rail_and_magazine_pcb === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Cover Magazine (1.b)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->cover_magazine, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->cover_magazine)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->cover_magazine === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->cover_magazine === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 3: PCB CLEANER -->
            <tr class="wizard-header">
                <td colspan="4">3. PCB CLEANER</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">CLEANING UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Brush (2)</td>
                <td class="item-standard">Standard: Rotation</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->brush, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->brush)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->brush === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->brush === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure (2.a)</td>
                <td class="item-standard">Standard: 0.45 - 0.54 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->air_presure, '0.45 - 0.54')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->air_presure)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->air_presure && $dailyPanasonic->air_presure !== '-' && $dailyPanasonic->air_presure !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->air_presure);
                            $isOk = $value >= 0.45 && $value <= 0.54;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->air_presure === 'na' || $dailyPanasonic->air_presure === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Vacume Pressure Unitech (2.b)</td>
                <td class="item-standard">Standard: 0.45 - 0.54 Mpa (Unitech only)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vacume_presure_unitech, '0.45 - 0.54')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vacume_presure_unitech)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vacume_presure_unitech && $dailyPanasonic->vacume_presure_unitech !== '-' && $dailyPanasonic->vacume_presure_unitech !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->vacume_presure_unitech);
                            $isOk = $value >= 0.45 && $value <= 0.54;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->vacume_presure_unitech === 'na' || $dailyPanasonic->vacume_presure_unitech === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Vacume Pressure Nix (2.c)</td>
                <td class="item-standard">Standard: 0.60 - 0.70 Mpa (N.I.X only)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vacume_presure_nix, '0.60 - 0.70')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vacume_presure_nix)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vacume_presure_nix && $dailyPanasonic->vacume_presure_nix !== '-' && $dailyPanasonic->vacume_presure_nix !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->vacume_presure_nix);
                            $isOk = $value >= 0.60 && $value <= 0.70;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->vacume_presure_nix === 'na' || $dailyPanasonic->vacume_presure_nix === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">CLEANING UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vacume Brush (3)</td>
                <td class="item-standard">Standard: Rotation</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vacume_brush, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vacume_brush)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vacume_brush === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->vacume_brush === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Cleaning Roller (4)</td>
                <td class="item-standard">Standard: Smooth rotation & Clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->cleaning_roller, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->cleaning_roller)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->cleaning_roller === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->cleaning_roller === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Ionizer (5)</td>
                <td class="item-standard">Standard: 5 Times to push cleaner</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->ionizer, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->ionizer)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->ionizer === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->ionizer === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Conveyor Setting (6)</td>
                <td class="item-standard">Standard: 40</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->conveyor_speed, '40')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->conveyor_speed)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->conveyor_speed && $dailyPanasonic->conveyor_speed !== '-' && $dailyPanasonic->conveyor_speed !== 'na'): ?>
                        <span class="status-badge <?php echo e(floatval($dailyPanasonic->conveyor_speed) <= 40 ? 'status-checked' : ''); ?>">
                            <?php echo e(floatval($dailyPanasonic->conveyor_speed) <= 40 ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->conveyor_speed === 'na' || $dailyPanasonic->conveyor_speed === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 4: PRINTING -->
            <tr class="wizard-header">
                <td colspan="4">4. PRINTING</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">CLEANING UNIT</td>
            </tr>
            <tr>
                <td class="item-name">IPA Solvent (7)</td>
                <td class="item-standard">Standard: Tank Minimal half</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->ipa_solvent, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->ipa_solvent)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->ipa_solvent === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->ipa_solvent === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">TEMPERATURE & HUMIDITY CONTROL UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Temperature Control 1 (8)</td>
                <td class="item-standard">Standard: 23-27℃</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->temperature_control_1, '23-27')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->temperature_control_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->temperature_control_1 && $dailyPanasonic->temperature_control_1 !== '-' && $dailyPanasonic->temperature_control_1 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->temperature_control_1);
                            $isOk = $value >= 23 && $value <= 27;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->temperature_control_1 === 'na' || $dailyPanasonic->temperature_control_1 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Humidity Control 1 (8.a)</td>
                <td class="item-standard">Standard: 35% - 70%</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->humidity_control_1, '35-70')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->humidity_control_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->humidity_control_1 && $dailyPanasonic->humidity_control_1 !== '-' && $dailyPanasonic->humidity_control_1 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->humidity_control_1);
                            $isOk = $value >= 35 && $value <= 70;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->humidity_control_1 === 'na' || $dailyPanasonic->humidity_control_1 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Clamp Pressure SP 60 (9)</td>
                <td class="item-standard">Standard: 0.20 ~ 0.40 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->clamp_presure_sp_60, '0.20-0.40')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->clamp_presure_sp_60)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->clamp_presure_sp_60 && $dailyPanasonic->clamp_presure_sp_60 !== '-' && $dailyPanasonic->clamp_presure_sp_60 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->clamp_presure_sp_60);
                            $isOk = $value >= 0.20 && $value <= 0.40;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->clamp_presure_sp_60 === 'na' || $dailyPanasonic->clamp_presure_sp_60 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Clamp Pressure SPG 2 (9.a)</td>
                <td class="item-standard">Standard: 0.20 ~ 0.45 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->clamp_presure_spg_2, '0.20-0.40')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->clamp_presure_spg_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->clamp_presure_spg_2 && $dailyPanasonic->clamp_presure_spg_2 !== '-' && $dailyPanasonic->clamp_presure_spg_2 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->clamp_presure_spg_2);
                            $isOk = $value >= 0.20 && $value <= 0.40;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->clamp_presure_spg_2 === 'na' || $dailyPanasonic->clamp_presure_spg_2 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Squeege SP 60 (10)</td>
                <td class="item-standard">Standard: 0.2 ~ (+/ 0.01) Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->squeege_sp_60, '0.19-0.21')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->squeege_sp_60)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->squeege_sp_60 && $dailyPanasonic->squeege_sp_60 !== '-' && $dailyPanasonic->squeege_sp_60 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->squeege_sp_60);
                            $isOk = $value >= 0.19 && $value <= 0.21;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->squeege_sp_60 === 'na' || $dailyPanasonic->squeege_sp_60 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Squeege SPG 2 (10.a)</td>
                <td class="item-standard">Standard: 0.12 ~ (+/ 0.01) Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->squeege_spg_2, '0.11-0.13')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->squeege_spg_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->squeege_spg_2 && $dailyPanasonic->squeege_spg_2 !== '-' && $dailyPanasonic->squeege_spg_2 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->squeege_spg_2);
                            $isOk = $value >= 0.11 && $value <= 0.13;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->squeege_spg_2 === 'na' || $dailyPanasonic->squeege_spg_2 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Cleaning Solvent (11)</td>
                <td class="item-standard">Standard: 0.20 ~ (+/ 0.01) Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->cleaning_solvent, '0.19-0.21')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->cleaning_solvent)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->cleaning_solvent && $dailyPanasonic->cleaning_solvent !== '-' && $dailyPanasonic->cleaning_solvent !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->cleaning_solvent);
                            $isOk = $value >= 0.19 && $value <= 0.21;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->cleaning_solvent === 'na' || $dailyPanasonic->cleaning_solvent === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure Meter (12)</td>
                <td class="item-standard">Standard: 0.50~ 0.55 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->air_presure_meter, '0.50-0.55')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->air_presure_meter)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->air_presure_meter && $dailyPanasonic->air_presure_meter !== '-' && $dailyPanasonic->air_presure_meter !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->air_presure_meter);
                            $isOk = $value >= 0.50 && $value <= 0.55;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->air_presure_meter === 'na' || $dailyPanasonic->air_presure_meter === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 5: SPI -->
            <tr class="wizard-header">
                <td colspan="4">5. SPI</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure Meter Parmi (12.a)</td>
                <td class="item-standard">Standard: 0.40 - 0.50 Mpa (PARMI)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->air_presure_meter_parmi, '0.40-0.50')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->air_presure_meter_parmi)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->air_presure_meter_parmi && $dailyPanasonic->air_presure_meter_parmi !== '-' && $dailyPanasonic->air_presure_meter_parmi !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->air_presure_meter_parmi);
                            $isOk = $value >= 0.40 && $value <= 0.50;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->air_presure_meter_parmi === 'na' || $dailyPanasonic->air_presure_meter_parmi === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">MEASUREMENT UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Capability Index (12.b)</td>
                <td class="item-standard">Standard: CpK for Masspro > 1.67</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->capability_index, '>1.67')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->capability_index)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->capability_index && $dailyPanasonic->capability_index !== '-' && $dailyPanasonic->capability_index !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->capability_index);
                            $isOk = $value > 1.67;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->capability_index === 'na' || $dailyPanasonic->capability_index === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 6: CHIP MOUNTER 1 -->
            <tr class="wizard-header">
                <td colspan="4">6. CHIP MOUNTER 1</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NG BOX</td>
            </tr>
            <tr>
                <td class="item-name">Box (13)</td>
                <td class="item-standard">Standard: No components</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->box, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->box)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->box === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->box === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">HEAD UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Parameter (13.a)</td>
                <td class="item-standard">Standard: No Yellow initial (display)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vaccuum_parameter, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vaccuum_parameter)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vaccuum_parameter === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->vaccuum_parameter === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NOZZLE CLEAN</td>
            </tr>
            <tr>
                <td class="item-name">Expire Date (14)</td>
                <td class="item-standard">Standard: No Expired</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->expire_date, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->expire_date)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->expire_date === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->expire_date === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NOZZLE UNIT (NPM)</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Pump (14.a)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa (NPM)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vaccuum_pump, '-100--87')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vaccuum_pump)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vaccuum_pump && $dailyPanasonic->vaccuum_pump !== '-' && $dailyPanasonic->vaccuum_pump !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->vaccuum_pump);
                            $isOk = $value >= -100 && $value <= -87;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->vaccuum_pump === 'na' || $dailyPanasonic->vaccuum_pump === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 7: CHIP MOUNTER 2 -->
            <tr class="wizard-header">
                <td colspan="4">7. CHIP MOUNTER 2</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NG BOX</td>
            </tr>
            <tr>
                <td class="item-name">Box 2 (15)</td>
                <td class="item-standard">Standard: No components</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->box_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->box_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->box_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->box_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">HEAD UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Parameter 2 (15.a)</td>
                <td class="item-standard">Standard: No Yellow initial (display)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vaccuum_parameter_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vaccuum_parameter_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vaccuum_parameter_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->vaccuum_parameter_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NOZZLE CLEAN</td>
            </tr>
            <tr>
                <td class="item-name">Expire Date (16)</td>
                <td class="item-standard">Standard: No Expired</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->expire_date_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->expire_date_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->expire_date_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->expire_date_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NOZZLE UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Pump 2 (16.a)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa (NPM)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vaccuum_pump_2, '-100--87')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vaccuum_pump_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vaccuum_pump_2 && $dailyPanasonic->vaccuum_pump_2 !== '-' && $dailyPanasonic->vaccuum_pump_2 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->vaccuum_pump_2);
                            $isOk = $value >= -100 && $value <= -87;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->vaccuum_pump_2 === 'na' || $dailyPanasonic->vaccuum_pump_2 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 8: REFLOW -->
            <tr class="wizard-header">
                <td colspan="4">8. REFLOW</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">VENTILATION DUCT</td>
            </tr>
            <tr>
                <td class="item-name">Abandonment (17)</td>
                <td class="item-standard">Standard: No Damage</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->abandonment, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->abandonment)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->abandonment === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->abandonment === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">SAFETY FIRE</td>
            </tr>
            <tr>
                <td class="item-name">Fire Possibility (17.a)</td>
                <td class="item-standard">Standard: No Paper, No plastic</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->fire_posibilty, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->fire_posibilty)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->fire_posibilty === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->fire_posibilty === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">RAIL</td>
            </tr>
            <tr>
                <td class="item-name">Rail & Transfer Unit (18)</td>
                <td class="item-standard">Standard: No jammed</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->rail_and_transfer_unit, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->rail_and_transfer_unit)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->rail_and_transfer_unit === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->rail_and_transfer_unit === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">N2 UNIT</td>
            </tr>
            <tr>
                <td class="item-name">N2 Pressure (19)</td>
                <td class="item-standard">Standard: 0.4MPa ~ 0.5MPa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->n2_presure, '0.4-0.5')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->n2_presure)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->n2_presure && $dailyPanasonic->n2_presure !== '-' && $dailyPanasonic->n2_presure !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->n2_presure);
                            $isOk = $value >= 0.4 && $value <= 0.5;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->n2_presure === 'na' || $dailyPanasonic->n2_presure === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Oxygen Density SEK (20)</td>
                <td class="item-standard">Standard: 1200~1800 ppm</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->oxygent_density_sek, '1200-1800')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->oxygent_density_sek)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->oxygent_density_sek && $dailyPanasonic->oxygent_density_sek !== '-' && $dailyPanasonic->oxygent_density_sek !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->oxygent_density_sek);
                            $isOk = $value >= 1200 && $value <= 1800;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->oxygent_density_sek === 'na' || $dailyPanasonic->oxygent_density_sek === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Oxygen Density Special (20)</td>
                <td class="item-standard">Standard: 500~1000 ppm</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->oxygent_density_special, '500-1000')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->oxygent_density_special)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->oxygent_density_special && $dailyPanasonic->oxygent_density_special !== '-' && $dailyPanasonic->oxygent_density_special !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->oxygent_density_special);
                            $isOk = $value >= 500 && $value <= 1000;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->oxygent_density_special === 'na' || $dailyPanasonic->oxygent_density_special === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">SAFETY FIRE</td>
            </tr>
            <tr>
                <td class="item-name">Fire Possibility 2 (20.a)</td>
                <td class="item-standard">Standard: No Paper, No plastic</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->fire_posibilty_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->fire_posibilty_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->fire_posibilty_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->fire_posibilty_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 9: AOI -->
            <tr class="wizard-header">
                <td colspan="4">9. AOI</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure 2 (20.b)</td>
                <td class="item-standard">Standard: 0.40 - 0.50 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->air_presure_2, '0.40-0.50')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->air_presure_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->air_presure_2 && $dailyPanasonic->air_presure_2 !== '-' && $dailyPanasonic->air_presure_2 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->air_presure_2);
                            $isOk = $value >= 0.40 && $value <= 0.50;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->air_presure_2 === 'na' || $dailyPanasonic->air_presure_2 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 10: UNLOADER -->
            <tr class="wizard-header">
                <td colspan="4">10. UNLOADER</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">PUSHER</td>
            </tr>
            <tr>
                <td class="item-name">Cylinder 2 (21)</td>
                <td class="item-standard">Standard: Smooth and center</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->cylinder_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->cylinder_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->cylinder_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->cylinder_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">MAGAZINE</td>
            </tr>
            <tr>
                <td class="item-name">Rail & Magazine PCB 2 (21.a)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->rail_and_magazine_pcb_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->rail_and_magazine_pcb_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->rail_and_magazine_pcb_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->rail_and_magazine_pcb_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Cover Magazine 2 (21.b)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->cover_magazine_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->cover_magazine_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->cover_magazine_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->cover_magazine_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 11: AOI TABLE -->
            <tr class="wizard-header">
                <td colspan="4">11. AOI TABLE</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">POSITION AND CLEAN</td>
            </tr>
            <tr>
                <td class="item-name">Angle & Filter (22)</td>
                <td class="item-standard">Standard: No dirt / no dust</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->angle_and_filter, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->angle_and_filter)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->angle_and_filter === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->angle_and_filter === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">WRISTRAP</td>
            </tr>
            <tr>
                <td class="item-name">Lamp Indicator (22.a)</td>
                <td class="item-standard">Standard: Function</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->lamp_indicator, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->lamp_indicator)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->lamp_indicator === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->lamp_indicator === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 12: REFLOW 2 -->
            <tr class="wizard-header">
                <td colspan="4">12. REFLOW 2</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">CHILLER</td>
            </tr>
            <tr>
                <td class="item-name">Temperature Chiller (23)</td>
                <td class="item-standard">Standard: 17-23℃</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->temperature_chiller, '17-23')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->temperature_chiller)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->temperature_chiller && $dailyPanasonic->temperature_chiller !== '-' && $dailyPanasonic->temperature_chiller !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->temperature_chiller);
                            $isOk = $value >= 17 && $value <= 23;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->temperature_chiller === 'na' || $dailyPanasonic->temperature_chiller === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">FLUX COLLECTION UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Temperature Control 3 (24)</td>
                <td class="item-standard">Standard: 300℃ ±10℃</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->temperature_control_3, '290-310')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->temperature_control_3)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->temperature_control_3 && $dailyPanasonic->temperature_control_3 !== '-' && $dailyPanasonic->temperature_control_3 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->temperature_control_3);
                            $isOk = $value >= 290 && $value <= 310;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->temperature_control_3 === 'na' || $dailyPanasonic->temperature_control_3 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 13: CHIP MOUNTER 1 (BACK) -->
            <tr class="wizard-header">
                <td colspan="4">13. CHIP MOUNTER 1 (BACK)</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure Supply (25)</td>
                <td class="item-standard">Standard: 0.49 ~ 0.54 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->air_presure_supply, '0.49-0.54')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->air_presure_supply)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->air_presure_supply && $dailyPanasonic->air_presure_supply !== '-' && $dailyPanasonic->air_presure_supply !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->air_presure_supply);
                            $isOk = $value >= 0.49 && $value <= 0.54;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->air_presure_supply === 'na' || $dailyPanasonic->air_presure_supply === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NG BOX</td>
            </tr>
            <tr>
                <td class="item-name">Box 3 (25.a)</td>
                <td class="item-standard">Standard: No components</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->box_3, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->box_3)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->box_3 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->box_3 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NOZZLE UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Pump 3 (25.b)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa (CM 402/CM 602)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vaccuum_pump_3, '-100--87')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vaccuum_pump_3)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vaccuum_pump_3 && $dailyPanasonic->vaccuum_pump_3 !== '-' && $dailyPanasonic->vaccuum_pump_3 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->vaccuum_pump_3);
                            $isOk = $value >= -100 && $value <= -87;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->vaccuum_pump_3 === 'na' || $dailyPanasonic->vaccuum_pump_3 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 14: CHIP MOUNTER 2 (BACK) -->
            <tr class="wizard-header">
                <td colspan="4">14. CHIP MOUNTER 2 (BACK)</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure Supply 2 (26)</td>
                <td class="item-standard">Standard: 0.49 ~ 0.54 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->air_presure_supply_2, '0.49-0.54')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->air_presure_supply_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->air_presure_supply_2 && $dailyPanasonic->air_presure_supply_2 !== '-' && $dailyPanasonic->air_presure_supply_2 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->air_presure_supply_2);
                            $isOk = $value >= 0.49 && $value <= 0.54;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->air_presure_supply_2 === 'na' || $dailyPanasonic->air_presure_supply_2 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NG BOX</td>
            </tr>
            <tr>
                <td class="item-name">Box 4 (26.a)</td>
                <td class="item-standard">Standard: No components</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->box_4, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->box_4)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->box_4 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->box_4 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">NOZZLE UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Pump 4 (26.b)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa (CM 402/CM 602)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->vaccuum_pump_4, '-100--87')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->vaccuum_pump_4)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->vaccuum_pump_4 && $dailyPanasonic->vaccuum_pump_4 !== '-' && $dailyPanasonic->vaccuum_pump_4 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->vaccuum_pump_4);
                            $isOk = $value >= -100 && $value <= -87;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->vaccuum_pump_4 === 'na' || $dailyPanasonic->vaccuum_pump_4 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 15: SPI (BACK) -->
            <tr class="wizard-header">
                <td colspan="4">15. SPI (BACK)</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure 3 (27)</td>
                <td class="item-standard">Standard: 0.40 - 0.50 Mpa (Kohyoung)</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->air_presure_3, '0.40-0.50')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->air_presure_3)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->air_presure_3 && $dailyPanasonic->air_presure_3 !== '-' && $dailyPanasonic->air_presure_3 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->air_presure_3);
                            $isOk = $value >= 0.40 && $value <= 0.50;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->air_presure_3 === 'na' || $dailyPanasonic->air_presure_3 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 16: PRINTER -->
            <tr class="wizard-header">
                <td colspan="4">16. PRINTER</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">TEMPERATURE CONTROL UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Temperature Control 4 (28)</td>
                <td class="item-standard">Standard: 23-27℃</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->temperature_control_4, '23-27')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->temperature_control_4)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->temperature_control_4 && $dailyPanasonic->temperature_control_4 !== '-' && $dailyPanasonic->temperature_control_4 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyPanasonic->temperature_control_4);
                            $isOk = $value >= 23 && $value <= 27;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyPanasonic->temperature_control_4 === 'na' || $dailyPanasonic->temperature_control_4 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">SWITCH WATER LEVEL</td>
            </tr>
            <tr>
                <td class="item-name">Water Reservoirs (28.a)</td>
                <td class="item-standard">Standard: Function, No Damage</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->water_reservoirs, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->water_reservoirs)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->water_reservoirs === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->water_reservoirs === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 17: PCB CLEANER (BACK) -->
            <tr class="wizard-header">
                <td colspan="4">17. PCB CLEANER (BACK)</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">CLEANING UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Filter (29)</td>
                <td class="item-standard">Standard: Clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->filter, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->filter)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->filter === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->filter === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 18: IONIZER -->
            <tr class="wizard-header">
                <td colspan="4">18. IONIZER</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">POSITION AND CLEAN</td>
            </tr>
            <tr>
                <td class="item-name">Angle & Filter 2 (30)</td>
                <td class="item-standard">Standard: No dirt / no dust</td>
                <td class="item-value <?php echo e(getValueClass($dailyPanasonic->angle_and_filter_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyPanasonic->angle_and_filter_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyPanasonic->angle_and_filter_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyPanasonic->angle_and_filter_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

        </tbody>
    </table>

    <div class="footer">
        Generated by System on <?php echo e(now()->format('Y-m-d H:i')); ?> ( QR-ENG-13-K023 )
    </div>
</body>
</html><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\livewire\mtc\daily\panasonic\daily-panasonic-print.blade.php ENDPATH**/ ?>