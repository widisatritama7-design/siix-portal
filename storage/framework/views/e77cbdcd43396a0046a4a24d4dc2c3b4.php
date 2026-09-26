<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blind Test Report - <?php echo e(now()->format('Y-m-d')); ?></title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 24px 32px;
            color: #1a1a1a;
            background: #fff;
            font-size: 12px;
            line-height: 1.4;
        }

        /* ==================== HEADER ==================== */
        .report-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 12px;
            margin-bottom: 16px;
            border-bottom: 3px solid #1e3a8a;
        }

        .report-header .company {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .report-header .company-text h1 {
            font-size: 16px;
            color: #1e3a8a;
            font-weight: bold;
            letter-spacing: 0.5px;
        }

        .report-header .company-text p {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
        }

        .report-header .meta {
            text-align: right;
            font-size: 10px;
            color: #555;
        }

        .report-header .meta strong {
            display: block;
            font-size: 12px;
            color: #1a1a1a;
            margin-bottom: 2px;
        }

        /* ==================== TITLE ==================== */
        .report-title {
            text-align: center;
            margin: 16px 0 12px;
        }

        .report-title h2 {
            font-size: 18px;
            color: #1a1a1a;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 6px;
            border-bottom: 1px solid #ddd;
            display: inline-block;
            min-width: 60%;
        }

        .report-title p {
            font-size: 11px;
            color: #666;
            margin-top: 6px;
        }

        /* ==================== FILTER INFO ==================== */
        .filter-info {
            display: flex;
            flex-wrap: wrap;
            gap: 8px 20px;
            font-size: 11px;
            color: #333;
            margin-bottom: 12px;
            padding: 8px 12px;
            background: #f8fafc;
            border-left: 3px solid #4472C4;
            border-radius: 3px;
        }

        .filter-info .label { color: #666; }
        .filter-info .value { color: #1a1a1a; font-weight: bold; }

        /* ==================== SUMMARY STATS ==================== */
        .summary-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 16px;
        }

        .stat-box {
            padding: 12px 16px;
            border-radius: 6px;
            border-left: 4px solid;
            background: #f8fafc;
        }

        .stat-box.stat-total   { border-left-color: #3b82f6; background: #eff6ff; }
        .stat-box.stat-avg     { border-left-color: #22c55e; background: #f0fdf4; }
        .stat-box.stat-overall { border-left-color: #f59e0b; background: #fffbeb; }

        .stat-box .stat-label {
            font-size: 10px;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .stat-box .stat-value {
            font-size: 22px;
            font-weight: bold;
            line-height: 1.1;
        }

        .stat-box.stat-total   .stat-value { color: #1e40af; }
        .stat-box.stat-avg     .stat-value { color: #15803d; }
        .stat-box.stat-overall .stat-value { color: #b45309; }

        .stat-box .stat-sub {
            font-size: 10px;
            color: #6b7280;
            margin-top: 2px;
        }

        /* ==================== TABLES ==================== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            font-size: 11px;
        }

        th, td {
            border: 1px solid #d1d5db;
            padding: 6px 10px;
            vertical-align: middle;
            white-space: nowrap;
        }

        thead th {
            background: #4472C4;
            color: #fff;
            text-align: center;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            padding: 8px 6px;
        }

        tbody tr:nth-child(even) { background: #f9fafb; }
        tbody tr:hover { background: #eff6ff; }

        td.center { text-align: center; }
        td.right  { text-align: right; }
        td.bold   { font-weight: bold; }
        td.muted  { color: #6b7280; }

        tfoot tr {
            background: #fef3c7;
            font-weight: bold;
            border-top: 2px solid #f59e0b;
        }

        tfoot td {
            padding: 8px 10px;
            font-size: 11px;
        }

        /* ==================== BADGES ==================== */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: bold;
            color: #fff;
            min-width: 45px;
            text-align: center;
        }
        .badge-red     { background: #ef4444; }
        .badge-orange  { background: #f97316; }
        .badge-yellow  { background: #eab308; color: #422006; }
        .badge-lime    { background: #84cc16; }
        .badge-green   { background: #22c55e; }
        .badge-emerald { background: #10b981; }
        .badge-gray    { background: #9ca3af; }
        .badge-blue    { background: #3b82f6; }
        .badge-purple  { background: #8b5cf6; }

        /* ==================== SECTION BOX ==================== */
        .section-box {
            border: 1px solid #d1d5db;
            border-radius: 6px;
            padding: 14px 18px;
            background: #fff;
            margin-top: 20px;
            page-break-inside: avoid;
        }

        .section-box h3 {
            font-size: 12px;
            margin-bottom: 12px;
            padding-bottom: 6px;
            border-bottom: 2px solid #4472C4;
            color: #1e3a8a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ==================== DISTRIBUTION TABLE ==================== */
        .distribution-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
            font-size: 11px;
            table-layout: fixed;
        }

        .distribution-table th,
        .distribution-table td {
            white-space: nowrap;
            padding: 7px 10px;
        }

        .distribution-table th:nth-child(1),
        .distribution-table td:nth-child(1) { width: 20%; text-align: center; }

        .distribution-table th:nth-child(2),
        .distribution-table td:nth-child(2) { width: 25%; text-align: center; }

        .distribution-table th:nth-child(3),
        .distribution-table td:nth-child(3) { width: 25%; text-align: center; }

        .distribution-table th:nth-child(4),
        .distribution-table td:nth-child(4) { width: 30%; text-align: left; }

        /* ==================== BAR VISUAL ==================== */
        .bar-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bar-track {
            flex: 1;
            height: 8px;
            background: #e5e7eb;
            border-radius: 4px;
            overflow: hidden;
            min-width: 40px;
        }

        .bar-fill {
            height: 100%;
            border-radius: 4px;
            transition: width 0.3s;
        }

        .bar-fill-0    { background: #ef4444; }
        .bar-fill-20   { background: #f97316; }
        .bar-fill-40   { background: #eab308; }
        .bar-fill-60   { background: #84cc16; }
        .bar-fill-80   { background: #22c55e; }
        .bar-fill-100  { background: #10b981; }

        .bar-label {
            font-size: 10px;
            color: #6b7280;
            min-width: 35px;
            text-align: right;
            font-weight: bold;
        }

        /* ==================== CHART SECTION ==================== */
        .chart-layout {
            display: grid;
            grid-template-columns: 320px 1fr;
            gap: 24px;
            align-items: center;
        }

        .chart-wrapper {
            position: relative;
            height: 260px;
            width: 260px;
            margin: 0 auto;
        }

        /* Custom Legend */
        .custom-legend {
            display: grid;
            grid-template-columns: 1fr;
            gap: 8px;
        }

        .legend-item {
            display: grid;
            grid-template-columns: 20px 60px 1fr 70px;
            align-items: center;
            gap: 10px;
            padding: 8px 12px;
            border-radius: 6px;
            background: #f9fafb;
            border-left: 4px solid transparent;
            font-size: 11px;
            white-space: nowrap;
        }

        .legend-item.legend-red     { border-left-color: #ef4444; }
        .legend-item.legend-orange  { border-left-color: #f97316; }
        .legend-item.legend-yellow  { border-left-color: #eab308; }
        .legend-item.legend-lime    { border-left-color: #84cc16; }
        .legend-item.legend-green   { border-left-color: #22c55e; }
        .legend-item.legend-emerald { border-left-color: #10b981; }

        .legend-color {
            width: 14px;
            height: 14px;
            border-radius: 3px;
        }

        .legend-color.color-red     { background: #ef4444; }
        .legend-color.color-orange  { background: #f97316; }
        .legend-color.color-yellow  { background: #eab308; }
        .legend-color.color-lime    { background: #84cc16; }
        .legend-color.color-green   { background: #22c55e; }
        .legend-color.color-emerald { background: #10b981; }

        .legend-range {
            font-weight: bold;
            color: #1a1a1a;
        }

        .legend-count {
            color: #374151;
        }

        .legend-pct {
            text-align: right;
            font-weight: bold;
            color: #1e3a8a;
        }

        /* ==================== FOOTER ==================== */
        .report-footer {
            margin-top: 30px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            font-size: 10px;
            color: #666;
        }

        /* ==================== SIGNATURE ==================== */
        .signature-section {
            margin-top: 40px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            font-size: 11px;
        }

        .signature-box .role {
            color: #666;
            margin-bottom: 60px;
        }

        .signature-box .name {
            border-top: 1px solid #1a1a1a;
            padding-top: 4px;
            font-weight: bold;
            color: #1a1a1a;
        }

        /* ==================== PRINT ==================== */
        @media print {
            body {
                padding: 0;
                font-size: 10px;
            }
            .no-print { display: none !important; }

            thead th {
                background: #4472C4 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            tfoot tr {
                background: #fef3c7 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .badge,
            .legend-color,
            .bar-fill,
            .stat-box {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .legend-item {
                background: #f9fafb !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .section-box {
                page-break-inside: avoid;
            }

            @page {
                margin: 12mm 10mm;
                size: A4;
            }
        }

        /* ==================== PRINT BUTTON ==================== */
        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 22px;
            background: #4472C4;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(68, 114, 196, 0.4);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s;
            z-index: 100;
        }
        .print-btn:hover {
            background: #3661a8;
            box-shadow: 0 6px 16px rgba(68, 114, 196, 0.5);
            transform: translateY(-1px);
        }
    </style>
</head>
<body>

    <button class="print-btn no-print" onclick="window.print()">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <polyline points="6 9 6 2 18 2 18 9"></polyline>
            <path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"></path>
            <rect x="6" y="14" width="12" height="8"></rect>
        </svg>
        Print / Save PDF
    </button>

    
    <div class="report-header">
        <div class="company">
            <div class="company-text">
                <h1>PT. SIIX EMS INDONESIA</h1>
                <p>Quality Assurance / Quality Control</p>
            </div>
        </div>
        <div class="meta">
            <strong>BLIND TEST REPORT</strong>
            <div>Printed: <?php echo e(now()->format('d M Y, H:i')); ?></div>
            <div>Doc. No: BT-RPT-<?php echo e(now()->format('Ymd')); ?></div>
        </div>
    </div>

    
    <div class="report-title">
        <h2>Blind Test Result Report</h2>
        <p>Per-employee aggregated performance</p>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(array_filter($filterInfo)): ?>
    <div class="filter-info">
        <span><span class="label">Filter Applied:</span></span>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterInfo['dateFrom']): ?>
            <span class="label">From:</span> <span class="value"><?php echo e(\Carbon\Carbon::parse($filterInfo['dateFrom'])->format('d M Y')); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterInfo['dateUntil']): ?>
            <span class="label">Until:</span> <span class="value"><?php echo e(\Carbon\Carbon::parse($filterInfo['dateUntil'])->format('d M Y')); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterInfo['year']): ?>
            <span class="label">Year:</span> <span class="value"><?php echo e($filterInfo['year']); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterInfo['month']): ?>
            <span class="label">Month:</span> <span class="value"><?php echo e(\Carbon\Carbon::create()->month((int)$filterInfo['month'])->format('F')); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterInfo['department']): ?>
            <span class="label">Department:</span> <span class="value"><?php echo e($filterInfo['department']); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($filterInfo['section'])): ?>
            <span class="label">Section:</span> <span class="value"><?php echo e($filterInfo['section']); ?></span>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 80px;">NIK</th>
                <th>Name</th>
                <th style="width: 120px;">Department</th>
                <th style="width: 70px;">Section</th>
                <th style="width: 70px;">Percobaan</th>
                <th style="width: 50px;">Fail</th>
                <th style="width: 50px;">Pass</th>
                <th style="width: 70px;">Total Soal</th>
                <th style="width: 90px;">Percentage</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <tr>
                <td class="center muted"><?php echo e($index + 1); ?></td>
                <td class="bold"><?php echo e($item['nik']); ?></td>
                <td><?php echo e($item['name']); ?></td>
                <td class="muted"><?php echo e($item['department']); ?></td>
                <td class="center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['section']) && $item['section'] !== '-'): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = explode(',', $item['section']); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                            <span class="badge badge-blue" style="margin-right: 2px;"><?php echo e(trim($sec)); ?></span>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                    <?php else: ?>
                        <span class="muted">-</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="center">
                    <?php
                        $attempt = $item['attempt'] ?? 1;
                        $maxAttempt = $item['max_attempt'] ?? 2;
                        $attemptBadge = $attempt > 1 ? 'purple' : 'gray';
                    ?>
                    <span class="badge badge-<?php echo e($attemptBadge); ?>"><?php echo e($attempt); ?> / <?php echo e($maxAttempt); ?></span>
                </td>
                <td class="center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['fail_count'] > 0): ?>
                        <span style="color: #dc2626; font-weight: bold;"><?php echo e($item['fail_count']); ?></span>
                    <?php else: ?>
                        <span class="muted">0</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="center">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($item['pass_count'] > 0): ?>
                        <span style="color: #16a34a; font-weight: bold;"><?php echo e($item['pass_count']); ?></span>
                    <?php else: ?>
                        <span class="muted">0</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>
                <td class="center bold"><?php echo e($item['total_soal']); ?></td>
                <td class="center">
                    <?php
                        $pct = $item['percentage'];
                        $badge = $pct >= 80 ? 'green' : ($pct >= 60 ? 'lime' : ($pct >= 40 ? 'yellow' : ($pct >= 20 ? 'orange' : 'red')));
                    ?>
                    <span class="badge badge-<?php echo e($badge); ?>"><?php echo e($pct); ?>%</span>
                </td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="10" class="center muted" style="padding: 30px;">
                    No data available for the selected filters
                </td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->isNotEmpty()): ?>
        <tfoot>
            <tr>
                <td colspan="6" class="right">TOTAL (<?php echo e($totalRecords); ?> employees)</td>
                <td class="center"><?php echo e(number_format($totalFail)); ?></td>
                <td class="center"><?php echo e(number_format($totalPass)); ?></td>
                <td class="center"><?php echo e(number_format($totalSoal)); ?></td>
                <td class="center"><?php echo e($overallPercentage); ?>%</td>
            </tr>
        </tfoot>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </table>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->isNotEmpty()): ?>
    <div class="section-box">
        <h3>Percentage Distribution</h3>
        <?php
            $badges = [0=>'red', 20=>'orange', 40=>'yellow', 60=>'lime', 80=>'green', 100=>'emerald'];
        ?>
        <table class="distribution-table">
            <thead>
                <tr>
                    <th>Range</th>
                    <th>Count</th>
                    <th>% of Total</th>
                    <th>Visual</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $distribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pct => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $pctOfTotal = $totalRecords > 0 ? round(($count / $totalRecords) * 100, 1) : 0;
                ?>
                <tr>
                    <td>
                        <span class="badge badge-<?php echo e($badges[$pct] ?? 'gray'); ?>"><?php echo e($pct); ?>%</span>
                    </td>
                    <td class="bold"><?php echo e($count); ?> orang</td>
                    <td class="bold"><?php echo e($pctOfTotal); ?>%</td>
                    <td>
                        <div class="bar-wrapper">
                            <div class="bar-track">
                                <div class="bar-fill bar-fill-<?php echo e($pct); ?>" style="width: <?php echo e($pctOfTotal); ?>%;"></div>
                            </div>
                            <span class="bar-label"><?php echo e($pctOfTotal); ?>%</span>
                        </div>
                    </td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td>TOTAL</td>
                    <td class="bold"><?php echo e($totalRecords); ?> orang</td>
                    <td class="bold">100%</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->isNotEmpty()): ?>
    <div class="section-box">
        <h3>Distribution Chart</h3>
        <div class="chart-layout">
            
            <div class="chart-wrapper">
                <canvas id="printChart"></canvas>
            </div>

            
            <div class="custom-legend">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $distribution; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pct => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $pctOfTotal = $totalRecords > 0 ? round(($count / $totalRecords) * 100, 1) : 0;
                    $colorKey = $badges[$pct] ?? 'gray';
                ?>
                <div class="legend-item legend-<?php echo e($colorKey); ?>">
                    <div class="legend-color color-<?php echo e($colorKey); ?>"></div>
                    <div class="legend-range"><?php echo e($pct); ?>%</div>
                    <div class="legend-count"><?php echo e($count); ?> orang</div>
                    <div class="legend-pct"><?php echo e($pctOfTotal); ?>%</div>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($data->isNotEmpty()): ?>
    <div class="signature-section">
        <div class="signature-box">
            <div class="role">Prepared by,</div>
            <div class="name"><?php echo e(auth()->user()?->name ?? '_______________'); ?></div>
        </div>
        <div class="signature-box">
            <div class="role">Checked by,</div>
            <div class="name">_______________</div>
        </div>
        <div class="signature-box">
            <div class="role">Approved by,</div>
            <div class="name">_______________</div>
        </div>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div class="report-footer">
        <span>Blind Test Report — Generated automatically by SIIX Portal</span>
    </div>

    
    <script>
        const distribution = <?php echo json_encode($distribution, 15, 512) ?>;
        const total = Object.values(distribution).reduce((a, b) => a + b, 0);

        if (total > 0) {
            const ctx = document.getElementById('printChart');
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: Object.keys(distribution).map(k => k + '%'),
                    datasets: [{
                        data: Object.values(distribution),
                        backgroundColor: ['#ef4444', '#f97316', '#eab308', '#84cc16', '#22c55e', '#10b981'],
                        borderColor: '#fff',
                        borderWidth: 3,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    animation: false,
                    cutout: '62%',
                    plugins: {
                        legend: { display: false },
                        tooltip: { enabled: false }
                    }
                }
            });
        }
    </script>
</body>
</html><?php /**PATH D:\laragon\www\siix-portal\resources\views/livewire/qaqc/blind-test/print.blade.php ENDPATH**/ ?>