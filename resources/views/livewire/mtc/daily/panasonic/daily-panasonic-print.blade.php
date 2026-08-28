<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Panasonic Checklist - {{ $dailyPanasonic->created_at->format('Y-m-d') }}</title>
    <style>
        @page {
            margin: 0.8cm;
            size: A4 portrait;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.3;
            color: #333;
            margin: 0;
            padding: 0;
            font-size: 9px;
        }
        
        .header {
            text-align: center;
            border-bottom: 3px double #333;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 14px;
            color: #2c3e50;
            letter-spacing: 1px;
        }
        
        .header .sub-title {
            font-size: 10px;
            color: #7f8c8d;
            margin-top: 2px;
        }
        
        .info-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 6px;
            margin-bottom: 10px;
            font-size: 8px;
        }
        
        .info-item {
            border: 1px solid #ddd;
            padding: 4px 6px;
            border-radius: 3px;
            background: #f9f9f9;
            text-align: center;
        }
        
        .info-label {
            font-weight: bold;
            color: #7f8c8d;
            font-size: 7px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .info-value {
            font-weight: 600;
            font-size: 9px;
            margin-top: 1px;
        }
        
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
            font-size: 8px;
        }
        
        .checklist-table th {
            background-color: #34495e;
            color: white;
            padding: 4px 6px;
            text-align: center;
            font-size: 7px;
            border: 1px solid #2c3e50;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .checklist-table td {
            padding: 4px 6px;
            border: 1px solid #ddd;
            vertical-align: middle;
            font-size: 8px;
        }
        
        .wizard-header {
            background-color: #3498db !important;
            font-weight: bold;
            font-size: 9px !important;
            color: #ffffff;
        }
        .wizard-header td {
            background-color: #3498db !important;
            color: #ffffff !important;
            font-weight: bold;
            padding: 4px 8px;
        }
        
        .section-header {
            background-color: #ecf0f1 !important;
            font-weight: bold;
        }
        .section-header td {
            background-color: #ecf0f1 !important;
            font-weight: bold;
            padding: 3px 8px;
        }
        
        .item-name {
            font-weight: 500;
            width: 22%;
        }
        
        .item-standard {
            width: 30%;
            color: #555;
            font-style: italic;
            font-size: 7.5px;
        }
        
        .item-value {
            width: 18%;
            text-align: center;
            font-weight: bold;
            font-size: 9px;
        }
        
        .item-status {
            width: 15%;
            text-align: center;
        }
        
        .status-badge {
            display: inline-block;
            padding: 1px 8px;
            border-radius: 8px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .status-ok {
            background-color: #d4edda;
            color: #155724;
        }

        .status-na {
            background-color: #e2e3e5;
            color: #383d41;
        }

        .status-not-ok {
            background-color: #f8d7da;
            color: #721c24;
        }

        .status-not-checked {
            background-color: #fff3cd;
            color: #856404;
        }

        .badge-success { background-color: #28a745; color: #fff; }
        .badge-danger { background-color: #dc3545; color: #fff; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-secondary { background-color: #6c757d; color: #fff; }

        .value-ok {
            color: #28a745;
        }
        
        .value-not-ok {
            color: #dc3545;
        }
        
        .footer {
            text-align: left;
            font-size: 7px;
            color: #95a5a6;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            margin-top: 10px;
        }
        
        .footer .qr-code {
            font-size: 8px;
            font-weight: bold;
            color: #2c3e50;
        }
        
        .no-print {
            text-align: center;
            padding: 8px;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        
        @media print {
            .no-print {
                display: none;
            }
            .wizard-header td,
            .section-header td,
            .table-header th,
            .status-ok,
            .status-na,
            .status-not-ok,
            .status-not-checked,
            .badge-success,
            .badge-danger,
            .badge-warning,
            .badge-secondary {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .info-item {
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
            ✕ Close
        </button>
    </div>

    <div class="header">
        <h1>MACHINE DAILY ROUTINE INSPECTION CHECKLIST - PANASONIC</h1>
        <div class="sub-title">Print Date: {{ now()->format('Y-m-d H:i') }}</div>
    </div>

    <!-- Information Grid 5 Columns -->
    <div class="info-grid">
        <div class="info-item">
            <div class="info-label">PRODUCTION SMT LINE</div>
            <div class="info-value">{{ $dailyPanasonic->masterLine->line_number ?? 'N/A' }}</div>
        </div>

        <div class="info-item">
            <div class="info-label">GROUP</div>
            <div class="info-value">{{ $dailyPanasonic->group }}</div>
        </div>

        <div class="info-item">
            <div class="info-label">RUN TIME</div>
            <div class="info-value">
                <span class="status-badge badge-success">
                    {{ $dailyPanasonic->run_time ? $dailyPanasonic->run_time->format('H:i') : '-' }}
                </span>
            </div>
        </div>

        <div class="info-item">
            <div class="info-label">STOP TIME</div>
            <div class="info-value">
                <span class="status-badge badge-danger">
                    {{ $dailyPanasonic->stop_time ? $dailyPanasonic->stop_time->format('H:i') : '-' }}
                </span>
            </div>
        </div>

        <div class="info-item">
            <div class="info-label">STATUS</div>
            <div class="info-value">
                @php
                    $statusColor = match($dailyPanasonic->status) {
                        'Checked' => 'badge-success',
                        'On Progress' => 'badge-warning',
                        'Delay' => 'badge-danger',
                        'Holiday' => 'badge-secondary',
                        default => 'badge-secondary',
                    };
                @endphp
                <span class="status-badge {{ $statusColor }}">{{ $dailyPanasonic->status }}</span>
            </div>
        </div>

        <div class="info-item">
            <div class="info-label">APPROVAL</div>
            <div class="info-value">
                @php
                    $approvalColor = match($dailyPanasonic->approval) {
                        'Approved' => 'badge-success',
                        'Rejected' => 'badge-danger',
                        'Pending' => 'badge-warning',
                        default => 'badge-secondary',
                    };
                @endphp
                <span class="status-badge {{ $approvalColor }}">
                    {{ strtoupper($dailyPanasonic->approval ?? 'N/A') }}
                </span>
            </div>
        </div>

        <div class="info-item">
            <div class="info-label">APPROVED BY</div>
            <div class="info-value">{{ $dailyPanasonic->approvedBy->name ?? '-' }}</div>
        </div>

        <div class="info-item">
            <div class="info-label">CHECK BY</div>
            <div class="info-value">{{ $dailyPanasonic->updater->name ?? $dailyPanasonic->creator->name ?? '-' }}</div>
        </div>

        <div class="info-item">
            <div class="info-label">START INSPECTION</div>
            <div class="info-value">{{ $dailyPanasonic->created_at->format('d/m/Y H:i') }}</div>
        </div>

        <div class="info-item">
            <div class="info-label">FINISH INSPECTION</div>
            <div class="info-value">{{ $dailyPanasonic->updated_at->format('d/m/Y H:i') }}</div>
        </div>
    </div>

    <!-- Checklist Table -->
    <table class="checklist-table">
        <thead>
            <tr>
                <th style="width:22%; text-align: center; white-space: nowrap;">INSPECTION ITEM</th>
                <th style="width:30%; text-align: center; white-space: nowrap;">STANDARD</th>
                <th style="width:18%; text-align: center; white-space: nowrap;">ACTUAL VALUE</th>
                <th style="width:15%; text-align: center; white-space: nowrap;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @php
                function displayPanasonicValue($value) {
                    if ($value === null || $value === '') return '-';
                    if ($value === 'checked') return '✓';
                    if ($value === 'na') return 'N/A';
                    if ($value === 'on') return 'ON';
                    if ($value === 'off') return 'OFF';
                    return $value;
                }

                function getPanasonicValueClass($value, $standard) {
                    if ($value === null || $value === '' || $value === 'na' || $value === '-') return '';
                    
                    if (is_numeric($value)) {
                        $numValue = floatval($value);
                        
                        if (preg_match('/(\d+\.?\d*)\s*-\s*(\d+\.?\d*)/', $standard, $matches)) {
                            $min = floatval($matches[1]);
                            $max = floatval($matches[2]);
                            return ($numValue >= $min && $numValue <= $max) ? 'value-ok' : 'value-not-ok';
                        }
                        
                        if (preg_match('/>\s*(\d+\.?\d*)/', $standard, $matches)) {
                            $threshold = floatval($matches[1]);
                            return ($numValue > $threshold) ? 'value-ok' : 'value-not-ok';
                        }
                        
                        if (preg_match('/<\s*=\s*(\d+\.?\d*)/', $standard, $matches)) {
                            $threshold = floatval($matches[1]);
                            return ($numValue <= $threshold) ? 'value-ok' : 'value-not-ok';
                        }
                    }
                    
                    return '';
                }

                function getPanasonicStatusBadge($value) {
                    if ($value === null || $value === '') {
                        return '<span class="status-badge status-not-checked">Not Checked</span>';
                    }
                    
                    if ($value === 'checked' || $value === 'on') {
                        return '<span class="status-badge status-ok">OK</span>';
                    }
                    
                    if ($value === 'off') {
                        return '<span class="status-badge status-not-ok">NOT OK</span>';
                    }
                    
                    if ($value === 'na' || $value === '-') {
                        return '<span class="status-badge status-na">N/A</span>';
                    }
                    
                    if (is_numeric($value)) {
                        return '<span class="status-badge status-ok">OK</span>';
                    }
                    
                    return '<span class="status-badge status-not-checked">Not Checked</span>';
                }

                function getPanasonicNumericStatus($value, $min, $max) {
                    if ($value === null || $value === '' || $value === 'na' || $value === '-') {
                        return 'status-na';
                    }
                    $numValue = floatval($value);
                    if ($min !== null && $max !== null) {
                        return ($numValue >= $min && $numValue <= $max) ? 'status-ok' : 'status-not-ok';
                    }
                    return 'status-ok';
                }

                function getPanasonicNumericStatusBadge($value, $min, $max) {
                    $class = getPanasonicNumericStatus($value, $min, $max);
                    $text = $class === 'status-ok' ? 'OK' : ($class === 'status-na' ? 'N/A' : 'NOT OK');
                    return '<span class="status-badge ' . $class . '">' . $text . '</span>';
                }
            @endphp

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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->body_cover) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->body_cover) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Lamp Alarm & Change Model</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->lamp_alarm_change_model) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->lamp_alarm_change_model) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->cylinder) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->cylinder) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">MAGAZINE</td>
            </tr>
            <tr>
                <td class="item-name">Rail & Magazine PCB (1.a)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->rail_and_magazine_pcb) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->rail_and_magazine_pcb) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Cover Magazine (1.b)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->cover_magazine) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->cover_magazine) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->brush) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->brush) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure (2.a)</td>
                <td class="item-standard">Standard: 0.45 - 0.54 Mpa</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->air_presure, '0.45 - 0.54') }}">
                    {{ displayPanasonicValue($dailyPanasonic->air_presure) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->air_presure, 0.45, 0.54) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Vacume Pressure Unitech (2.b)</td>
                <td class="item-standard">Standard: 0.45 - 0.54 Mpa (Unitech only)</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->vacume_presure_unitech, '0.45 - 0.54') }}">
                    {{ displayPanasonicValue($dailyPanasonic->vacume_presure_unitech) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->vacume_presure_unitech, 0.45, 0.54) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Vacume Pressure Nix (2.c)</td>
                <td class="item-standard">Standard: 0.60 - 0.70 Mpa (N.I.X only)</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->vacume_presure_nix, '0.60 - 0.70') }}">
                    {{ displayPanasonicValue($dailyPanasonic->vacume_presure_nix) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->vacume_presure_nix, 0.60, 0.70) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">CLEANING UNIT 2</td>
            </tr>
            <tr>
                <td class="item-name">Vacume Brush (3)</td>
                <td class="item-standard">Standard: Rotation</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->vacume_brush) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->vacume_brush) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Cleaning Roller (4)</td>
                <td class="item-standard">Standard: Smooth rotation & Clean</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->cleaning_roller) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->cleaning_roller) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Ionizer (5)</td>
                <td class="item-standard">Standard: 5 Times to push cleaner</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->ionizer) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->ionizer) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Conveyor Setting (6)</td>
                <td class="item-standard">Standard: ≤ 40</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->conveyor_speed, '<= 40') }}">
                    {{ displayPanasonicValue($dailyPanasonic->conveyor_speed) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->conveyor_speed, null, 40) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->ipa_solvent) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->ipa_solvent) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">TEMPERATURE & HUMIDITY CONTROL UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Temperature Control (8)</td>
                <td class="item-standard">Standard: 23-27℃</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->temperature_control_1, '23-27') }}">
                    {{ displayPanasonicValue($dailyPanasonic->temperature_control_1) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->temperature_control_1, 23, 27) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Humidity Control (8.a)</td>
                <td class="item-standard">Standard: 35% - 70%</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->humidity_control_1, '35-70') }}">
                    {{ displayPanasonicValue($dailyPanasonic->humidity_control_1) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->humidity_control_1, 35, 70) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">REGULATOR UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Clamp Pressure SP-60 (9)</td>
                <td class="item-standard">Standard: 0.20 ~ 0.4 Mpa</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->clamp_presure_sp_60, '0.20-0.40') }}">
                    {{ displayPanasonicValue($dailyPanasonic->clamp_presure_sp_60) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->clamp_presure_sp_60, 0.20, 0.40) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Clamp Pressure SPG-2 (9.a)</td>
                <td class="item-standard">Standard: 0.20 ~ 0.45 Mpa</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->clamp_presure_spg_2, '0.20-0.40') }}">
                    {{ displayPanasonicValue($dailyPanasonic->clamp_presure_spg_2) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->clamp_presure_spg_2, 0.20, 0.40) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Squeege SP-60 (10)</td>
                <td class="item-standard">Standard: 0.2 ~ (+/ 0.01) Mpa</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->squeege_sp_60, '0.19-0.21') }}">
                    {{ displayPanasonicValue($dailyPanasonic->squeege_sp_60) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->squeege_sp_60, 0.19, 0.21) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Squeege SPG-2 (10.a)</td>
                <td class="item-standard">Standard: 0.12 ~ (+/ 0.01) Mpa</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->squeege_spg_2, '0.11-0.13') }}">
                    {{ displayPanasonicValue($dailyPanasonic->squeege_spg_2) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->squeege_spg_2, 0.11, 0.13) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Cleaning Solvent (11)</td>
                <td class="item-standard">Standard: 0.20 ~ (+/ 0.01) Mpa</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->cleaning_solvent, '0.19-0.21') }}">
                    {{ displayPanasonicValue($dailyPanasonic->cleaning_solvent) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->cleaning_solvent, 0.19, 0.21) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Air Pressure Meter (12)</td>
                <td class="item-standard">Standard: 0.50~ 0.55 Mpa</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->air_presure_meter, '0.50-0.55') }}">
                    {{ displayPanasonicValue($dailyPanasonic->air_presure_meter) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->air_presure_meter, 0.50, 0.55) !!}</td>
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
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->air_presure_meter_parmi, '0.40-0.50') }}">
                    {{ displayPanasonicValue($dailyPanasonic->air_presure_meter_parmi) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->air_presure_meter_parmi, 0.40, 0.50) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">MEASUREMENT UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Capability Index (12.b)</td>
                <td class="item-standard">Standard: CpK for Masspro > 1.67</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->capability_index, '>1.67') }}">
                    {{ displayPanasonicValue($dailyPanasonic->capability_index) }}
                </td>
                <td class="item-status">
                    @if($dailyPanasonic->capability_index !== null && $dailyPanasonic->capability_index !== '' && $dailyPanasonic->capability_index !== 'na' && $dailyPanasonic->capability_index !== '-')
                        @php $isOk = floatval($dailyPanasonic->capability_index) > 1.67; @endphp
                        <span class="status-badge {{ $isOk ? 'status-ok' : 'status-not-ok' }}">{{ $isOk ? 'OK' : 'NOT OK' }}</span>
                    @else
                        <span class="status-badge status-na">N/A</span>
                    @endif
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->box) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->box) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">HEAD UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Parameter (13.a)</td>
                <td class="item-standard">Standard: No Yellow initial (display)</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->vaccuum_parameter) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->vaccuum_parameter) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">NOZZLE CLEAN</td>
            </tr>
            <tr>
                <td class="item-name">Expire Date (14)</td>
                <td class="item-standard">Standard: No Expired</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->expire_date) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->expire_date) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">NOZZLE UNIT (NPM)</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Pump (14.a)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa (NPM)</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->vaccuum_pump, '-100--87') }}">
                    {{ displayPanasonicValue($dailyPanasonic->vaccuum_pump) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->vaccuum_pump, -100, -87) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->box_2) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->box_2) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">HEAD UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Parameter 2 (15.a)</td>
                <td class="item-standard">Standard: No Yellow initial (display)</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->vaccuum_parameter_2) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->vaccuum_parameter_2) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">NOZZLE CLEAN</td>
            </tr>
            <tr>
                <td class="item-name">Expire Date (16)</td>
                <td class="item-standard">Standard: No Expired</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->expire_date_2) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->expire_date_2) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">NOZZLE UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Pump 2 (16.a)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa (NPM)</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->vaccuum_pump_2, '-100--87') }}">
                    {{ displayPanasonicValue($dailyPanasonic->vaccuum_pump_2) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->vaccuum_pump_2, -100, -87) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->abandonment) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->abandonment) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">SAFETY FIRE</td>
            </tr>
            <tr>
                <td class="item-name">Fire Possibility (17.a)</td>
                <td class="item-standard">Standard: No Paper, No plastic</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->fire_posibilty) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->fire_posibilty) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Flashlight (17.b)</td>
                <td class="item-standard">Standard: On</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->flashlight) }}</td>
                <td class="item-status">
                    @if($dailyPanasonic->flashlight === 'on' || $dailyPanasonic->flashlight === 'na' || $dailyPanasonic->flashlight === '-')
                        <span class="status-badge status-ok">OK</span>
                    @elseif($dailyPanasonic->flashlight === 'off')
                        <span class="status-badge status-not-ok">NOT OK</span>
                    @else
                        <span class="status-badge status-not-checked">Not Checked</span>
                    @endif
                </td>
            </tr>

            <tr class="section-header">
                <td colspan="4">RAIL</td>
            </tr>
            <tr>
                <td class="item-name">Rail & Transfer Unit (18)</td>
                <td class="item-standard">Standard: No jammed</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->rail_and_transfer_unit) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->rail_and_transfer_unit) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">N2 UNIT</td>
            </tr>
            <tr>
                <td class="item-name">N2 Pressure (19)</td>
                <td class="item-standard">Standard: 0.4MPa ~ 0.5MPa</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->n2_presure, '0.4-0.5') }}">
                    {{ displayPanasonicValue($dailyPanasonic->n2_presure) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->n2_presure, 0.4, 0.5) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Oxygen Density SEK (20)</td>
                <td class="item-standard">Standard: 1200~1800 ppm</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->oxygent_density_sek, '1200-1800') }}">
                    {{ displayPanasonicValue($dailyPanasonic->oxygent_density_sek) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->oxygent_density_sek, 1200, 1800) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Oxygen Density Special (20)</td>
                <td class="item-standard">Standard: 500~1000 ppm</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->oxygent_density_special, '500-1000') }}">
                    {{ displayPanasonicValue($dailyPanasonic->oxygent_density_special) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->oxygent_density_special, 500, 1000) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">SAFETY FIRE</td>
            </tr>
            <tr>
                <td class="item-name">Fire Possibility 2 (20.a)</td>
                <td class="item-standard">Standard: No Paper, No plastic</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->fire_posibilty_2) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->fire_posibilty_2) !!}</td>
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
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->air_presure_2, '0.40-0.50') }}">
                    {{ displayPanasonicValue($dailyPanasonic->air_presure_2) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->air_presure_2, 0.40, 0.50) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->cylinder_2) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->cylinder_2) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">MAGAZINE</td>
            </tr>
            <tr>
                <td class="item-name">Rail & Magazine PCB 2 (21.a)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->rail_and_magazine_pcb_2) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->rail_and_magazine_pcb_2) !!}</td>
            </tr>
            <tr>
                <td class="item-name">Cover Magazine 2 (21.b)</td>
                <td class="item-standard">Standard: No Dust and clean</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->cover_magazine_2) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->cover_magazine_2) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->angle_and_filter) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->angle_and_filter) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">WRISTRAP</td>
            </tr>
            <tr>
                <td class="item-name">Lamp Indicator (22.a)</td>
                <td class="item-standard">Standard: Function</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->lamp_indicator) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->lamp_indicator) !!}</td>
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
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->temperature_chiller, '17-23') }}">
                    {{ displayPanasonicValue($dailyPanasonic->temperature_chiller) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->temperature_chiller, 17, 23) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">FLUX COLLECTION UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Temperature Control 3 (24)</td>
                <td class="item-standard">Standard: 300℃ ±10℃</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->temperature_control_3, '290-310') }}">
                    {{ displayPanasonicValue($dailyPanasonic->temperature_control_3) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->temperature_control_3, 290, 310) !!}</td>
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
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->air_presure_supply, '0.49-0.54') }}">
                    {{ displayPanasonicValue($dailyPanasonic->air_presure_supply) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->air_presure_supply, 0.49, 0.54) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">NG BOX</td>
            </tr>
            <tr>
                <td class="item-name">Box 3 (25.a)</td>
                <td class="item-standard">Standard: No components</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->box_3) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->box_3) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">NOZZLE UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Pump 3 (25.b)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa (CM 402/CM 602)</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->vaccuum_pump_3, '-100--87') }}">
                    {{ displayPanasonicValue($dailyPanasonic->vaccuum_pump_3) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->vaccuum_pump_3, -100, -87) !!}</td>
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
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->air_presure_supply_2, '0.49-0.54') }}">
                    {{ displayPanasonicValue($dailyPanasonic->air_presure_supply_2) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->air_presure_supply_2, 0.49, 0.54) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">NG BOX</td>
            </tr>
            <tr>
                <td class="item-name">Box 4 (26.a)</td>
                <td class="item-standard">Standard: No components</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->box_4) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->box_4) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">NOZZLE UNIT</td>
            </tr>
            <tr>
                <td class="item-name">Vaccuum Pump 4 (26.b)</td>
                <td class="item-standard">Standard: -87 ~ -100 Kpa (CM 402/CM 602)</td>
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->vaccuum_pump_4, '-100--87') }}">
                    {{ displayPanasonicValue($dailyPanasonic->vaccuum_pump_4) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->vaccuum_pump_4, -100, -87) !!}</td>
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
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->air_presure_3, '0.40-0.50') }}">
                    {{ displayPanasonicValue($dailyPanasonic->air_presure_3) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->air_presure_3, 0.40, 0.50) !!}</td>
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
                <td class="item-value {{ getPanasonicValueClass($dailyPanasonic->temperature_control_4, '23-27') }}">
                    {{ displayPanasonicValue($dailyPanasonic->temperature_control_4) }}
                </td>
                <td class="item-status">{!! getPanasonicNumericStatusBadge($dailyPanasonic->temperature_control_4, 23, 27) !!}</td>
            </tr>

            <tr class="section-header">
                <td colspan="4">SWITCH WATER LEVEL</td>
            </tr>
            <tr>
                <td class="item-name">Water Reservoirs (28.a)</td>
                <td class="item-standard">Standard: Function, No Damage</td>
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->water_reservoirs) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->water_reservoirs) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->filter) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->filter) !!}</td>
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
                <td class="item-value">{{ displayPanasonicValue($dailyPanasonic->angle_and_filter_2) }}</td>
                <td class="item-status">{!! getPanasonicStatusBadge($dailyPanasonic->angle_and_filter_2) !!}</td>
            </tr>

        </tbody>
    </table>

    <div class="footer">
        <span class="qr-code">QR-ENG-13-K023-017</span> | 
        Generated by System on {{ now()->format('Y-m-d H:i') }}
    </div>
</body>
</html>