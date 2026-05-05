
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>ESD QR Codes</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            background: white;
            padding: 15px;
        }

        /* HEADER */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }

        .header h1 {
            font-size: 16px;
            margin-bottom: 5px;
        }

        .header p {
            font-size: 10px;
            color: #666;
        }

        /* ======================================== */
        /* CONTAINER */
        /* ======================================== */
        .qr-container {
            display: flex;
            flex-direction: column;
            gap: 12px;
            width: 100%;
        }

        .qr-row {
            display: flex;
            flex-direction: row;
            gap: 12px;
            width: 100%;
        }

        /* ======================================== */
        /* CARD */
        /* ======================================== */
        .qr-card {
            border: 1px solid #000;
            background: white;
            page-break-inside: avoid;
            break-inside: avoid;
            padding: 2px 0;
        }

        .qr-card.card-gmb {
            width: 4.7cm;
            min-height: 1.6cm;
        }

        .qr-card.card-other {
            width: 6cm;
            min-height: 1.6cm;
        }

        /* TABLE */
        .card-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            height: 100%;
        }

        .card-table td {
            vertical-align: middle;
            padding: 0;
        }

        /* FLEX WRAPPER (INI KUNCI CENTER) */
        .cell-content {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
        }

        /* COLUMN WIDTH */
        .text-cell { width: 60%; padding: 0 4px; }
        .logo-cell { width: 20%; background-color: #facc15; }
        .qr-cell   { width: 20%; }

        /* TEXT */
        .register-text {
            font-weight: bold;
            text-transform: uppercase;
            word-break: break-word;
            text-align: center;
        }

        .card-gmb .register-text { font-size: 7px; }
        .card-other .register-text { font-size: 9px; }

        /* IMAGE */
        .logo-img,
        .qr-img {
            display: block;
            max-width: 100%;
        }

        .card-gmb .logo-img,
        .card-gmb .qr-img {
            max-height: 28px;
        }

        .card-other .logo-img,
        .card-other .qr-img {
            max-height: 36px;
        }

        /* FOOTER */
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 8px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 8px;
            position: fixed;
            bottom: 0;
            width: 100%;
            background: white;
        }

        /* PRINT */
        @media print {
            body {
                padding: 0;
                margin: 0;
            }

            .logo-cell {
                background-color: #facc15 !important;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }

            .qr-card {
                border: 1px solid #000 !important;
            }
        }
    </style>
</head>

<body>

<div class="header">
    <h1>ELECTROSTATIC DISCHARGE (ESD) QR CODES</h1>
    <p>Generated on: <?php echo e($date); ?> | Total QR Codes: <?php echo e($total); ?></p>
</div>

<div class="qr-container">
    <?php
        $cols = 4;
        $itemsCount = count($items);
        $rows = ceil($itemsCount / $cols);
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($row = 0; $row < $rows; $row++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
        <div class="qr-row">

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php for($col = 0; $col < $cols; $col++): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php
                    $index = ($row * $cols) + $col;
                ?>

                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index < $itemsCount): ?>
                    <?php
                        $item = $items[$index];
                        $isGmb = ($item['model'] == 'ground_monitor_box');
                        $cardClass = $isGmb ? 'card-gmb' : 'card-other';
                    ?>

                    <div class="qr-card <?php echo e($cardClass); ?>">
                        <table class="card-table">
                            <tr>
                                <!-- TEXT -->
                                <td class="text-cell">
                                    <div class="cell-content">
                                        <div class="register-text">
                                            <?php echo e($item['register_no']); ?>

                                        </div>
                                    </div>
                                </td>

                                <!-- LOGO -->
                                <td class="logo-cell">
                                    <div class="cell-content">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['logo_base64'])): ?>
                                            <img src="<?php echo e($item['logo_base64']); ?>" class="logo-img">
                                        <?php else: ?>
                                            <span style="font-size:7px;font-weight:bold;">ESD</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>

                                <!-- QR -->
                                <td class="qr-cell">
                                    <div class="cell-content">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($item['qr_base64'])): ?>
                                            <img src="<?php echo e($item['qr_base64']); ?>" class="qr-img">
                                        <?php else: ?>
                                            <span style="font-size:6px;">No QR</span>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                <?php else: ?>
                    <div style="width:6cm; visibility:hidden;"></div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

        </div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
</div>

<div class="footer">
    <p>ESD Safe - Quality Management System | This document is system generated</p>
</div>

</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/esd/print/qr-codes.blade.php ENDPATH**/ ?>