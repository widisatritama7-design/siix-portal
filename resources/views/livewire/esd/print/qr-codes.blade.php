{{-- resources/views/livewire/esd/print/qr-codes.blade.php --}}
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
    <p>Generated on: {{ $date }} | Total QR Codes: {{ $total }}</p>
</div>

<div class="qr-container">
    @php
        $cols = 4;
        $itemsCount = count($items);
        $rows = ceil($itemsCount / $cols);
    @endphp

    @for($row = 0; $row < $rows; $row++)
        <div class="qr-row">

            @for($col = 0; $col < $cols; $col++)
                @php
                    $index = ($row * $cols) + $col;
                @endphp

                @if($index < $itemsCount)
                    @php
                        $item = $items[$index];
                        $isGmb = ($item['model'] == 'ground_monitor_box');
                        $cardClass = $isGmb ? 'card-gmb' : 'card-other';
                    @endphp

                    <div class="qr-card {{ $cardClass }}">
                        <table class="card-table">
                            <tr>
                                <!-- TEXT -->
                                <td class="text-cell">
                                    <div class="cell-content">
                                        <div class="register-text">
                                            {{ $item['register_no'] }}
                                        </div>
                                    </div>
                                </td>

                                <!-- LOGO -->
                                <td class="logo-cell">
                                    <div class="cell-content">
                                        @if(!empty($item['logo_base64']))
                                            <img src="{{ $item['logo_base64'] }}" class="logo-img">
                                        @else
                                            <span style="font-size:7px;font-weight:bold;">ESD</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- QR -->
                                <td class="qr-cell">
                                    <div class="cell-content">
                                        @if(!empty($item['qr_base64']))
                                            <img src="{{ $item['qr_base64'] }}" class="qr-img">
                                        @else
                                            <span style="font-size:6px;">No QR</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>

                @else
                    <div style="width:6cm; visibility:hidden;"></div>
                @endif

            @endfor

        </div>
    @endfor
</div>

<div class="footer">
    <p>ESD Safe - Quality Management System | This document is system generated</p>
</div>

</body>
</html>