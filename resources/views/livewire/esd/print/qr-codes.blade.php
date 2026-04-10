<?php
// FILE: livewire/esd/print/qr-codes.blade.php
// VERSI TANPA FLEXBOX - PAKAI TABLE
?>

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
            padding: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #333;
        }
        
        .header h1 {
            font-size: 18px;
            margin-bottom: 5px;
        }
        
        .header p {
            font-size: 11px;
            color: #666;
        }
        
        /* PAKAI TABLE LAYOUT - PALING AMAN UNTUK DOMPDF */
        .qr-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        
        .qr-table td {
            padding: 5px;
            vertical-align: top;
            width: 25%; /* 4 kolom */
        }
        
        .qr-card {
            border: 1px solid #000;
            background: white;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        
        .card-content {
            width: 100%;
            display: table;
            table-layout: fixed;
        }
        
        .card-text {
            display: table-cell;
            vertical-align: middle;
            padding: 8px;
            background: white;
        }
        
        .card-logo {
            display: table-cell;
            vertical-align: middle;
            width: 55px;
            background: #facc15;
            text-align: center;
            padding: 5px;
        }
        
        .card-qr {
            display: table-cell;
            vertical-align: middle;
            width: 65px;
            background: white;
            text-align: center;
            padding: 5px;
            border-left: 1px solid #ddd;
        }
        
        .register-text {
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
            line-height: 1.3;
            word-wrap: break-word;
        }
        
        /* GMB specific */
        .card-gmb .register-text {
            font-size: 8px;
        }
        
        .logo-img {
            max-width: 48px;
            max-height: 48px;
        }
        
        .qr-img {
            max-width: 55px;
            max-height: 55px;
        }
        
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            position: fixed;
            bottom: 0;
            width: 100%;
            background: white;
        }
        
        @media print {
            .card-logo {
                background-color: #facc15 !important;
                print-color-adjust: exact;
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>ELECTROSTATIC DISCHARGE (ESD) QR CODES</h1>
        <p>Generated on: {{ $date }} | Total QR Codes: {{ $total }}</p>
    </div>
    
    <table class="qr-table" cellpadding="0" cellspacing="0">
        @php
            $cols = 4;
            $itemsCount = count($items);
        @endphp
        
        @for($i = 0; $i < $itemsCount; $i += $cols)
            <tr>
                @for($j = 0; $j < $cols && ($i + $j) < $itemsCount; $j++)
                    @php
                        $item = $items[$i + $j];
                        $isGmb = ($item['model'] == 'ground_monitor_box');
                        $cardClass = $isGmb ? 'card-gmb' : 'card-other';
                    @endphp
                    <td align="left" valign="top">
                        <div class="qr-card {{ $cardClass }}">
                            <div class="card-content">
                                <div class="card-text">
                                    <div class="register-text">{{ $item['register_no'] }}</div>
                                </div>
                                <div class="card-logo">
                                    @if(!empty($item['logo_base64']))
                                        <img src="{{ $item['logo_base64'] }}" class="logo-img" alt="ESD Logo">
                                    @else
                                        <span style="font-size: 10px;">ESD</span>
                                    @endif
                                </div>
                                <div class="card-qr">
                                    @if(!empty($item['qr_base64']))
                                        <img src="{{ $item['qr_base64'] }}" class="qr-img" alt="QR">
                                    @else
                                        <span style="font-size: 8px;">No QR</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                @endfor
                
                @for($k = 0; $k < $cols - min($cols, $itemsCount - $i); $k++)
                    <td>&nbsp;</td>
                @endfor
            </tr>
        @endfor
    </table>
    
    <div class="footer">
        <p>ESD Safe - Quality Management System | This document is system generated</p>
    </div>
</body>
</html>