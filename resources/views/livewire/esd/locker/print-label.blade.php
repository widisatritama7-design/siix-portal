<?php
use App\Models\ESD\Locker\UniformTransaction;

$transaction = UniformTransaction::with(['employee', 'locker'])->find($id);
if (!$transaction) {
    abort(404);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Print Label - ESD System</title>
    <style>
        * { 
            margin: 0; 
            padding: 0; 
            box-sizing: border-box; 
        }
        
        body { 
            font-family: 'Courier New', monospace; 
            width: 58mm;
            margin: 0;
            padding: 0;
            background: #fff;
            font-size: 12px;
            text-align: left;
        }
        
        /* PRINT HEADER */
        .print-header {
            display: flex;
            justify-content: center;
            gap: 8px;
            padding: 4mm 3mm;
            width: 100%;
        }

        .btn-back, .btn-print {
            padding: 6px 14px;
            font-size: 13px;
            font-weight: 700;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            color: #fff;
            font-family: Arial, sans-serif;
            transition: all 0.2s;
        }

        .btn-back { 
            background: #6b7280; 
        }
        .btn-back:hover { 
            background: #4b5563; 
        }
        
        .btn-print { 
            background: #2563eb; 
        }
        .btn-print:hover { 
            background: #1d4ed8; 
        }

        #print-area {
            width: 58mm;
            padding: 0;
            margin: 0;
            text-align: left;
        }

        /* MAIN LABEL */
        .label {
            padding: 3mm 3mm 3mm 0.5mm;
            page-break-inside: avoid;
            background: #ffffff;
            width: 100%;
            margin: 0;
            border: none;
            text-align: left;
        }

        /* HEADER */
        .label-header {
            text-align: center;
            padding-bottom: 2mm;
            margin-bottom: 2mm;
            border-bottom: 2px dashed #000;
        }

        .label-title {
            font-size: 16px;
            font-weight: 900;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #000;
            display: block;
            text-align: center;
            font-weight: 700;
        }

        .label-locker {
            font-size: 20px;
            font-weight: 900;
            margin-top: 1.5mm;
            color: #000;
            display: block;
            text-align: center;
            letter-spacing: 2px;
            background: #f0f4ff;
            padding: 1mm 0;
            border-radius: 3px;
            font-weight: 700;
        }

        /* LINE DASHED */
        .line-dashed {
            text-align: center;
            color: #000;
            letter-spacing: 3px;
            padding: 1mm 0;
            width: 100%;
            font-size: 14px;
            font-weight: 700;
            border-top: 2px dashed #000;
            border-bottom: 2px dashed #000;
            margin: 1mm 0;
        }

        .line-dashed-single {
            text-align: center;
            color: #000;
            letter-spacing: 3px;
            padding: 0.5mm 0;
            width: 100%;
            font-size: 14px;
            font-weight: 700;
            border-bottom: 2px dashed #000;
            margin: 1mm 0;
        }

        /* BODY */
        .label-body {
            padding: 1mm 0;
            width: 100%;
        }

        .label-info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2mm 0;
            font-size: 13px;
            width: 100%;
            border-bottom: 1px dotted #000;
            font-weight: 700;
        }

        .label-info-item:last-child {
            border-bottom: none;
        }

        .label-info-item .label-text {
            font-weight: 700;
            color: #000;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .label-info-item .value {
            font-weight: 700;
            color: #000;
            text-align: right;
            font-size: 13px;
        }

        .label-info-item .value-code {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 2px;
            color: #000;
            background: #f3f4f6;
            padding: 1mm 3mm;
            border-radius: 4px;
            font-family: 'Courier New', monospace;
        }

        /* QR CODE */
        .label-qr {
            text-align: center;
            padding: 2mm 0;
            margin: 1mm auto;
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .label-qr svg {
            display: block;
            margin: 0 auto;
            width: 42mm !important;
            height: 42mm !important;
            max-width: 42mm;
            border: 2px solid #000;
            border-radius: 4px;
            padding: 2mm;
            background: #ffffff;
        }

        .label-qr-text {
            font-size: 14px;
            font-weight: 700;
            color: #000;
            margin-top: 1mm;
            letter-spacing: 3px;
            text-align: center;
            width: 100%;
            text-transform: uppercase;
        }

        /* FOOTER */
        .label-footer {
            text-align: center;
            font-size: 12px;
            font-weight: 700;
            color: #000;
            padding-top: 1.5mm;
            width: 100%;
            letter-spacing: 1px;
            border-top: 2px dashed #000;
            margin-top: 1mm;
        }

        /* MEDIA PRINT */
        @media print {
            @page { 
                size: 58mm auto; 
                margin: 0; 
            }
            
            body { 
                margin: 0; 
                padding: 0; 
                width: 58mm; 
                font-size: 12px;
                text-align: left;
                background: #fff;
            }
            
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            
            #print-area { 
                position: absolute; 
                top: 0; 
                left: 0; 
                right: 0;
                width: 58mm; 
                padding: 0;
                margin: 0;
                text-align: left;
            }
            
            .print-header { 
                display: none !important; 
            }
            
            * { 
                -webkit-print-color-adjust: exact !important; 
                print-color-adjust: exact !important; 
                color-adjust: exact !important;
            }

            .label {
                padding: 2mm 3mm 2mm 0.5mm;
                border: none;
                margin: 0;
                text-align: left;
                background: #fff;
            }

            .label-header {
                border-bottom: 2px dashed #000;
            }

            .label-title {
                font-size: 16px;
                font-weight: 700;
                color: #000;
            }

            .label-locker {
                font-size: 20px;
                font-weight: 700;
                color: #000;
                background: #f0f4ff;
            }

            .label-info-item {
                padding: 1.2mm 0;
                font-size: 13px;
                border-bottom: 1px dotted #000;
                font-weight: 700;
            }

            .label-info-item .label-text {
                font-weight: 700;
                color: #000;
                font-size: 12px;
            }

            .label-info-item .value {
                font-weight: 700;
                color: #000;
                font-size: 13px;
            }

            .label-info-item .value-code {
                font-size: 18px;
                font-weight: 700;
                color: #000;
                background: #f3f4f6;
            }

            .label-qr svg {
                border: 2px solid #000;
                background: #fff;
                width: 42mm !important;
                height: 42mm !important;
            }

            .label-qr-text {
                font-size: 14px;
                font-weight: 700;
                color: #000;
            }

            .label-footer {
                font-size: 12px;
                font-weight: 700;
                color: #000;
                border-top: 2px dashed #000;
            }

            .line-dashed {
                color: #000;
                font-weight: 700;
                border-top: 2px dashed #000;
                border-bottom: 2px dashed #000;
            }

            .line-dashed-single {
                color: #000;
                font-weight: 700;
                border-bottom: 2px dashed #000;
            }
        }

        /* SCREEN VIEW */
        @media screen {
            body { 
                background: #f3f4f6; 
                padding: 10mm; 
                font-size: 12px;
                text-align: center;
            }
            
            .container { 
                background: white; 
                padding: 0; 
                border-radius: 8px; 
                box-shadow: 0 4px 20px rgba(0,0,0,0.15);
                width: 58mm;
                margin: 0 auto;
                overflow: hidden;
                text-align: left;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="print-header">
            <button onclick="history.back()" class="btn-back">← Back</button>
            <button onclick="window.print()" class="btn-print">🖨️ Print</button>
        </div>

        <div id="print-area">
            <div class="label">

                <!-- HEADER -->
                <div class="label-header">
                    <span class="label-title">ESD SMART LOCKER</span>
                    <span class="label-locker">{{ $transaction->locker->code }}</span>
                </div>

                <!-- BODY -->
                <div class="label-body">
                    <div class="label-info-item">
                        <span class="label-text">NIK</span>
                        <span class="value">{{ $transaction->employee->nik }}</span>
                    </div>
                    <div class="label-info-item">
                        <span class="label-text">Name</span>
                        <span class="value">{{ $transaction->employee->name }}</span>
                    </div>
                    <div class="label-info-item">
                        <span class="label-text">Dept</span>
                        <span class="value">{{ $transaction->employee->department }}</span>
                    </div>
                    <div class="label-info-item" style="padding-top: 1.5mm; border-bottom: none;">
                        <span class="label-text">Code</span>
                        <span class="value value-code">{{ $transaction->access_code }}</span>
                    </div>
                </div>

                <!-- QR CODE -->
                <div class="label-qr">
                    {!! DNS2D::getBarcodeHTML($transaction->access_code, 'QRCODE', 5, 5) !!}
                    <span class="label-qr-text">SCAN   QR CODE</span>
                </div>

                <!-- FOOTER -->
                <div class="label-footer">
                    {{ now()->format('d/m/Y H:i') }}
                </div>

            </div>
        </div>
    </div>

    <script>
        // Auto print dengan delay agar QR code termuat
        setTimeout(function() { 
            window.print(); 
        }, 1000);
        
        window.onafterprint = function() {
            setTimeout(function() { 
                window.history.back(); 
            }, 500);
        };
    </script>
</body>
</html>