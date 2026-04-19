<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Fuji Checklist - <?php echo e($dailyFuji->created_at->format('Y-m-d')); ?></title>
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
        <h1>MACHINE DAILY ROUTINE INSPECTION CHECKLIST - FUJI</h1>
        <div style="font-size: 12px; color: #7f8c8d;">Print Date: <?php echo e(now()->format('Y-m-d H:i')); ?></div>
    </div>

    <!-- Information Grid 5 Columns -->
    <div class="info-grid" style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 1rem;">
        <!-- PRODUCTION SMT LINE -->
        <div class="info-item">
            <div class="info-label">PRODUCTION SMT LINE</div>
            <div><?php echo e($dailyFuji->masterLine->line_number ?? 'N/A'); ?></div>
        </div>

        <!-- GROUP -->
        <div class="info-item">
            <div class="info-label">GROUP</div>
            <div><?php echo e($dailyFuji->group); ?></div>
        </div>

        <!-- RUN TIME -->
        <div class="info-item">
            <div class="info-label">RUN TIME</div>
            <div>
                <span class="status-badge badge-success">
                    <?php echo e($dailyFuji->run_time ? $dailyFuji->run_time->format('H:i') : 'N/A'); ?>

                </span>
            </div>
        </div>

        <!-- STOP TIME -->
        <div class="info-item">
            <div class="info-label">STOP TIME</div>
            <div>
                <span class="status-badge badge-danger">
                    <?php echo e($dailyFuji->stop_time ? $dailyFuji->stop_time->format('H:i') : 'N/A'); ?>

                </span>
            </div>
        </div>

        <!-- STATUS -->
        <div class="info-item">
            <div class="info-label">STATUS</div>
            <div>
                <?php
                    $statusColor = match($dailyFuji->status) {
                        'Checked' => 'badge-success',
                        'On Progress' => 'badge-warning',
                        'Delay' => 'badge-danger',
                        'Holiday' => 'badge-secondary',
                        default => 'badge-secondary',
                    };
                ?>
                <span class="status-badge <?php echo e($statusColor); ?>"><?php echo e($dailyFuji->status); ?></span>
            </div>
        </div>

        <!-- APPROVAL -->
        <div class="info-item">
            <div class="info-label">APPROVAL</div>
            <div>
                <?php
                    $approvalColor = match($dailyFuji->approval) {
                        'Approved' => 'badge-success',
                        'Rejected' => 'badge-danger',
                        'Pending' => 'badge-warning',
                        default => 'badge-secondary',
                    };
                ?>
                <span class="status-badge <?php echo e($approvalColor); ?>">
                    <?php echo e(strtoupper($dailyFuji->approval ?? 'N/A')); ?>

                </span>
            </div>
        </div>

        <!-- APPROVED BY -->
        <div class="info-item">
            <div class="info-label">APPROVED BY</div>
            <div><?php echo e($dailyFuji->approvedBy->name ?? 'N/A'); ?></div>
        </div>

        <!-- CHECK BY -->
        <div class="info-item">
            <div class="info-label">CHECK BY</div>
            <div><?php echo e($dailyFuji->updater->name ?? 'N/A'); ?></div>
        </div>

        <!-- START INSPECTION DATE -->
        <div class="info-item">
            <div class="info-label">START INSPECTION</div>
            <div><?php echo e($dailyFuji->created_at->format('d F Y H:i')); ?></div>
        </div>

        <!-- FINISH INSPECTION DATE -->
        <div class="info-item">
            <div class="info-label">FINISH INSPECTION</div>
            <div><?php echo e($dailyFuji->updated_at->format('d F Y H:i')); ?></div>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->body_cover, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->body_cover)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->body_cover === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->body_cover === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->cylinder, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->cylinder)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->cylinder === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->cylinder === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->rail_and_magazine_pcb, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->rail_and_magazine_pcb)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->rail_and_magazine_pcb === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->rail_and_magazine_pcb === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Cover Magazine (1.b)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->cover_magazine, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->cover_magazine)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->cover_magazine === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->cover_magazine === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->brush, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->brush)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->brush === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->brush === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->air_presure, '0.45 - 0.54')); ?>">
                    <?php echo e(displayValue($dailyFuji->air_presure)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->air_presure && $dailyFuji->air_presure !== '-' && $dailyFuji->air_presure !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->air_presure);
                            $isOk = $value >= 0.45 && $value <= 0.54;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->air_presure === 'na' || $dailyFuji->air_presure === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Vacume Pressure Unitech (2.b)</td>
                <td class="item-standard">Standard: 0.45 - 0.54 Mpa (Unitech only)</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->vacume_presure_unitech, '0.45 - 0.54')); ?>">
                    <?php echo e(displayValue($dailyFuji->vacume_presure_unitech)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->vacume_presure_unitech && $dailyFuji->vacume_presure_unitech !== '-' && $dailyFuji->vacume_presure_unitech !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->vacume_presure_unitech);
                            $isOk = $value >= 0.45 && $value <= 0.54;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->vacume_presure_unitech === 'na' || $dailyFuji->vacume_presure_unitech === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Vacume Pressure Nix (2.c)</td>
                <td class="item-standard">Standard: 0.60 - 0.70 Mpa (N.I.X only)</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->vacume_presure_nix, '0.60 - 0.70')); ?>">
                    <?php echo e(displayValue($dailyFuji->vacume_presure_nix)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->vacume_presure_nix && $dailyFuji->vacume_presure_nix !== '-' && $dailyFuji->vacume_presure_nix !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->vacume_presure_nix);
                            $isOk = $value >= 0.60 && $value <= 0.70;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->vacume_presure_nix === 'na' || $dailyFuji->vacume_presure_nix === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">CLEANING UNIT 2</td>
            </tr>
            <tr>
                <td class="item-name">Vacume Brush (3)</td>
                <td class="item-standard">Standard: Rotation</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->vacume_brush, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->vacume_brush)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->vacume_brush === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->vacume_brush === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Cleaning Roller (4)</td>
                <td class="item-standard">Standard: Smooth rotation & Clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->cleaning_roller, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->cleaning_roller)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->cleaning_roller === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->cleaning_roller === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Ionizer (5)</td>
                <td class="item-standard">Standard: 5 Times to push cleaner</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->ionizer, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->ionizer)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->ionizer === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->ionizer === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Conveyor Setting (6)</td>
                <td class="item-standard">Standard: 40</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->conveyor_speed, '40')); ?>">
                    <?php echo e(displayValue($dailyFuji->conveyor_speed)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->conveyor_speed && $dailyFuji->conveyor_speed !== '-' && $dailyFuji->conveyor_speed !== 'na'): ?>
                        <span class="status-badge <?php echo e(floatval($dailyFuji->conveyor_speed) <= 40 ? 'status-checked' : ''); ?>">
                            <?php echo e(floatval($dailyFuji->conveyor_speed) <= 40 ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->conveyor_speed === 'na' || $dailyFuji->conveyor_speed === '-'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->ipa_solvent, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->ipa_solvent)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->ipa_solvent === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->ipa_solvent === 'na'): ?>
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
                <td class="item-name">Temperature Control (8)</td>
                <td class="item-standard">Standard: 23-27℃</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->temperature_control_1, '23-27')); ?>">
                    <?php echo e(displayValue($dailyFuji->temperature_control_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->temperature_control_1 && $dailyFuji->temperature_control_1 !== '-' && $dailyFuji->temperature_control_1 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->temperature_control_1);
                            $isOk = $value >= 23 && $value <= 27;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->temperature_control_1 === 'na' || $dailyFuji->temperature_control_1 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Humidity Control (8.a)</td>
                <td class="item-standard">Standard: 35% - 70%</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->humidity_control_1, '35-70')); ?>">
                    <?php echo e(displayValue($dailyFuji->humidity_control_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->humidity_control_1 && $dailyFuji->humidity_control_1 !== '-' && $dailyFuji->humidity_control_1 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->humidity_control_1);
                            $isOk = $value >= 35 && $value <= 70;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->humidity_control_1 === 'na' || $dailyFuji->humidity_control_1 === '-'): ?>
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
                <td class="item-name">Clamp Pressure (9)</td>
                <td class="item-standard">Standard: 0.20 ~ 0.4 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->clamp_presure, '0.20-0.40')); ?>">
                    <?php echo e(displayValue($dailyFuji->clamp_presure)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->clamp_presure && $dailyFuji->clamp_presure !== '-' && $dailyFuji->clamp_presure !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->clamp_presure);
                            $isOk = $value >= 0.20 && $value <= 0.40;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->clamp_presure === 'na' || $dailyFuji->clamp_presure === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Squeege Upper (10)</td>
                <td class="item-standard">Standard: 0.12 ~ (+/ 0.01) Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->squeege_upper, '0.11-0.13')); ?>">
                    <?php echo e(displayValue($dailyFuji->squeege_upper)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->squeege_upper && $dailyFuji->squeege_upper !== '-' && $dailyFuji->squeege_upper !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->squeege_upper);
                            $isOk = $value >= 0.11 && $value <= 0.13;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->squeege_upper === 'na' || $dailyFuji->squeege_upper === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Cleaning Solvent (11)</td>
                <td class="item-standard">Standard: 0.20 ~ (+/ 0.01) Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->cleaning_solvent, '0.19-0.21')); ?>">
                    <?php echo e(displayValue($dailyFuji->cleaning_solvent)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->cleaning_solvent && $dailyFuji->cleaning_solvent !== '-' && $dailyFuji->cleaning_solvent !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->cleaning_solvent);
                            $isOk = $value >= 0.19 && $value <= 0.21;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->cleaning_solvent === 'na' || $dailyFuji->cleaning_solvent === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure Meter (12)</td>
                <td class="item-standard">Standard: 0.50~ 0.55 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->air_presure_meter, '0.50-0.55')); ?>">
                    <?php echo e(displayValue($dailyFuji->air_presure_meter)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->air_presure_meter && $dailyFuji->air_presure_meter !== '-' && $dailyFuji->air_presure_meter !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->air_presure_meter);
                            $isOk = $value >= 0.50 && $value <= 0.55;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->air_presure_meter === 'na' || $dailyFuji->air_presure_meter === '-'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->air_presure_meter_parmi, '0.40-0.50')); ?>">
                    <?php echo e(displayValue($dailyFuji->air_presure_meter_parmi)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->air_presure_meter_parmi && $dailyFuji->air_presure_meter_parmi !== '-' && $dailyFuji->air_presure_meter_parmi !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->air_presure_meter_parmi);
                            $isOk = $value >= 0.40 && $value <= 0.50;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->air_presure_meter_parmi === 'na' || $dailyFuji->air_presure_meter_parmi === '-'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->capability_index, '>1.67')); ?>">
                    <?php echo e(displayValue($dailyFuji->capability_index)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->capability_index && $dailyFuji->capability_index !== '-' && $dailyFuji->capability_index !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->capability_index);
                            $isOk = $value > 1.67;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->capability_index === 'na' || $dailyFuji->capability_index === '-'): ?>
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
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure Supply (13)</td>
                <td class="item-standard">Standard: 0.49 ~ 0.54 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->air_presure_supply, '0.49-0.54')); ?>">
                    <?php echo e(displayValue($dailyFuji->air_presure_supply)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->air_presure_supply && $dailyFuji->air_presure_supply !== '-' && $dailyFuji->air_presure_supply !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->air_presure_supply);
                            $isOk = $value >= 0.49 && $value <= 0.54;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->air_presure_supply === 'na' || $dailyFuji->air_presure_supply === '-'): ?>
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
                <td class="item-name">Vaccuum Pump (13.a)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->vaccuum_pump_1, '-100--87')); ?>">
                    <?php echo e(displayValue($dailyFuji->vaccuum_pump_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->vaccuum_pump_1 && $dailyFuji->vaccuum_pump_1 !== '-' && $dailyFuji->vaccuum_pump_1 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->vaccuum_pump_1);
                            $isOk = $value >= -100 && $value <= -87;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->vaccuum_pump_1 === 'na' || $dailyFuji->vaccuum_pump_1 === '-'): ?>
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
                <td class="item-name">Box (13.b)</td>
                <td class="item-standard">Standard: No components</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->box_1, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->box_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->box_1 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->box_1 === 'na'): ?>
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
                <td class="item-name">Vaccuum Parameter (13.c)</td>
                <td class="item-standard">Standard: No Yellow initial (display)</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->vaccuum_parameter_1, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->vaccuum_parameter_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->vaccuum_parameter_1 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->vaccuum_parameter_1 === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->expire_date_1, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->expire_date_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->expire_date_1 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->expire_date_1 === 'na'): ?>
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
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure Supply (15)</td>
                <td class="item-standard">Standard: 0.49 ~ 0.54 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->air_presure_supply_2, '0.49-0.54')); ?>">
                    <?php echo e(displayValue($dailyFuji->air_presure_supply_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->air_presure_supply_2 && $dailyFuji->air_presure_supply_2 !== '-' && $dailyFuji->air_presure_supply_2 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->air_presure_supply_2);
                            $isOk = $value >= 0.49 && $value <= 0.54;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->air_presure_supply_2 === 'na' || $dailyFuji->air_presure_supply_2 === '-'): ?>
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
                <td class="item-name">Vaccuum Pump (15.a)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->vaccuum_pump_2, '-100--87')); ?>">
                    <?php echo e(displayValue($dailyFuji->vaccuum_pump_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->vaccuum_pump_2 && $dailyFuji->vaccuum_pump_2 !== '-' && $dailyFuji->vaccuum_pump_2 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->vaccuum_pump_2);
                            $isOk = $value >= -100 && $value <= -87;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->vaccuum_pump_2 === 'na' || $dailyFuji->vaccuum_pump_2 === '-'): ?>
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
                <td class="item-name">Box (15.b)</td>
                <td class="item-standard">Standard: No components</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->box_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->box_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->box_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->box_2 === 'na'): ?>
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
                <td class="item-name">Vaccuum Parameter (15.c)</td>
                <td class="item-standard">Standard: No Yellow initial (display)</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->vaccuum_parameter_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->vaccuum_parameter_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->vaccuum_parameter_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->vaccuum_parameter_2 === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->expire_date_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->expire_date_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->expire_date_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->expire_date_2 === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->abandonment, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->abandonment)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->abandonment === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->abandonment === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->fire_posibilty, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->fire_posibilty)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->fire_posibilty === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->fire_posibilty === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->rail_and_transfer_unit, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->rail_and_transfer_unit)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->rail_and_transfer_unit === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->rail_and_transfer_unit === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->n2_presure, '0.4-0.5')); ?>">
                    <?php echo e(displayValue($dailyFuji->n2_presure)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->n2_presure && $dailyFuji->n2_presure !== '-' && $dailyFuji->n2_presure !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->n2_presure);
                            $isOk = $value >= 0.4 && $value <= 0.5;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->n2_presure === 'na' || $dailyFuji->n2_presure === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Oxygen Density SEK (20)</td>
                <td class="item-standard">Standard: 1200~1800 ppm</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->oxygent_density_sek, '1200-1800')); ?>">
                    <?php echo e(displayValue($dailyFuji->oxygent_density_sek)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->oxygent_density_sek && $dailyFuji->oxygent_density_sek !== '-' && $dailyFuji->oxygent_density_sek !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->oxygent_density_sek);
                            $isOk = $value >= 1200 && $value <= 1800;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->oxygent_density_sek === 'na' || $dailyFuji->oxygent_density_sek === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Oxygen Density Special (20)</td>
                <td class="item-standard">Standard: 500~1000 ppm</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->oxygent_density_special, '500-1000')); ?>">
                    <?php echo e(displayValue($dailyFuji->oxygent_density_special)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->oxygent_density_special && $dailyFuji->oxygent_density_special !== '-' && $dailyFuji->oxygent_density_special !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->oxygent_density_special);
                            $isOk = $value >= 500 && $value <= 1000;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->oxygent_density_special === 'na' || $dailyFuji->oxygent_density_special === '-'): ?>
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
                <td class="item-name">Fire Possibility (20.a)</td>
                <td class="item-standard">Standard: No Paper, No plastic</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->fire_posibilty_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->fire_posibilty_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->fire_posibilty_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->fire_posibilty_2 === 'na'): ?>
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
                <td class="item-name">Air Pressure (20.b)</td>
                <td class="item-standard">Standard: 0.40 - 0.50 Mpa</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->air_presure_2, '0.40-0.50')); ?>">
                    <?php echo e(displayValue($dailyFuji->air_presure_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->air_presure_2 && $dailyFuji->air_presure_2 !== '-' && $dailyFuji->air_presure_2 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->air_presure_2);
                            $isOk = $value >= 0.40 && $value <= 0.50;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->air_presure_2 === 'na' || $dailyFuji->air_presure_2 === '-'): ?>
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
                <td class="item-name">Cylinder (21)</td>
                <td class="item-standard">Standard: Smooth and center</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->cylinder_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->cylinder_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->cylinder_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->cylinder_2 === 'na'): ?>
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
                <td class="item-name">Rail & Magazine PCB (21.a)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->rail_and_magazine_pcb_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->rail_and_magazine_pcb_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->rail_and_magazine_pcb_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->rail_and_magazine_pcb_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>
            <tr>
                <td class="item-name">Cover Magazine (21.b)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->cover_magazine_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->cover_magazine_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->cover_magazine_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->cover_magazine_2 === 'na'): ?>
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
                <td colspan="4">IONIZER POSITION</td>
            </tr>
            <tr>
                <td class="item-name">Angle & Filter (22)</td>
                <td class="item-standard">Standard: No dirt / no dust</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->angle_and_filter, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->angle_and_filter)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->angle_and_filter === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->angle_and_filter === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->lamp_indicator, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->lamp_indicator)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->lamp_indicator === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->lamp_indicator === 'na'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->temperature_chiller, '17-23')); ?>">
                    <?php echo e(displayValue($dailyFuji->temperature_chiller)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->temperature_chiller && $dailyFuji->temperature_chiller !== '-' && $dailyFuji->temperature_chiller !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->temperature_chiller);
                            $isOk = $value >= 17 && $value <= 23;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->temperature_chiller === 'na' || $dailyFuji->temperature_chiller === '-'): ?>
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
                <td class="item-name">Temperature Control (24)</td>
                <td class="item-standard">Standard: 300℃ ±10℃</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->temperature_control_3, '290-310')); ?>">
                    <?php echo e(displayValue($dailyFuji->temperature_control_3)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->temperature_control_3 && $dailyFuji->temperature_control_3 !== '-' && $dailyFuji->temperature_control_3 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->temperature_control_3);
                            $isOk = $value >= 290 && $value <= 310;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->temperature_control_3 === 'na' || $dailyFuji->temperature_control_3 === '-'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 13: CHIP MOUNTER 3 -->
            <tr class="wizard-header">
                <td colspan="4">13. CHIP MOUNTER 3</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">FAN UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Fan Unit 1 (25)</td>
                <td class="item-standard">Standard: Clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->fan_unit_1, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->fan_unit_1)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->fan_unit_1 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->fan_unit_1 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 14: CHIP MOUNTER 4 -->
            <tr class="wizard-header">
                <td colspan="4">14. CHIP MOUNTER 4</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">FAN UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Fan Unit 2 (26)</td>
                <td class="item-standard">Standard: Clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->fan_unit_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->fan_unit_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->fan_unit_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->fan_unit_2 === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 15: SPI 2 -->
            <tr class="wizard-header">
                <td colspan="4">15. SPI 2</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure (27)</td>
                <td class="item-standard">Standard: 0.40 - 0.50 Mpa (Kohyoung)</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->air_presure_3, '0.40-0.50')); ?>">
                    <?php echo e(displayValue($dailyFuji->air_presure_3)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->air_presure_3 && $dailyFuji->air_presure_3 !== '-' && $dailyFuji->air_presure_3 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->air_presure_3);
                            $isOk = $value >= 0.40 && $value <= 0.50;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->air_presure_3 === 'na' || $dailyFuji->air_presure_3 === '-'): ?>
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
                <td class="item-name">Temperature Control (28)</td>
                <td class="item-standard">Standard: 23-27℃</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->temperature_control_4, '23-27')); ?>">
                    <?php echo e(displayValue($dailyFuji->temperature_control_4)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->temperature_control_4 && $dailyFuji->temperature_control_4 !== '-' && $dailyFuji->temperature_control_4 !== 'na'): ?>
                        <?php
                            $value = floatval($dailyFuji->temperature_control_4);
                            $isOk = $value >= 23 && $value <= 27;
                        ?>
                        <span class="status-badge <?php echo e($isOk ? 'status-checked' : ''); ?>">
                            <?php echo e($isOk ? 'OK' : 'NOT OK'); ?>

                        </span>
                    <?php elseif($dailyFuji->temperature_control_4 === 'na' || $dailyFuji->temperature_control_4 === '-'): ?>
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
                <td class="item-value <?php echo e(getValueClass($dailyFuji->water_reservoirs, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->water_reservoirs)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->water_reservoirs === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->water_reservoirs === 'na'): ?>
                        <span class="status-badge status-na">N/A</span>
                    <?php else: ?>
                        <span style="color: #dc3545;">NOT CHECKED</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
            </tr>

            <!-- STEP 17: PCB CLEANER 2 -->
            <tr class="wizard-header">
                <td colspan="4">17. PCB CLEANER 2</td>
            </tr>
            
            <tr class="section-header">
                <td colspan="4">CLEANING UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Filter (29)</td>
                <td class="item-standard">Standard: Clean</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->filter, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->filter)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->filter === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->filter === 'na'): ?>
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
                <td class="item-name">Angle & Filter (30)</td>
                <td class="item-standard">Standard: No dirt / no dust</td>
                <td class="item-value <?php echo e(getValueClass($dailyFuji->angle_and_filter_2, 'checked')); ?>">
                    <?php echo e(displayValue($dailyFuji->angle_and_filter_2)); ?>

                </td>
                <td class="item-status">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($dailyFuji->angle_and_filter_2 === 'checked'): ?>
                        <span class="status-badge status-checked">OK</span>
                    <?php elseif($dailyFuji->angle_and_filter_2 === 'na'): ?>
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
</html><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\livewire\mtc\daily\fuji\daily-fuji-print.blade.php ENDPATH**/ ?>