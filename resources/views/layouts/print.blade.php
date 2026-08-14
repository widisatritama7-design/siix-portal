<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Label - ESD System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f0f0f0; font-family: Arial, sans-serif; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; }
        
        .print-header {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .btn-back {
            padding: 8px 16px;
            font-size: 14px;
            font-weight: bold;
            background: #777;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-print {
            padding: 8px 18px;
            font-size: 14px;
            font-weight: bold;
            background: #2647ff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-back:hover { background: #555; }
        .btn-print:hover { background: #000; }

        #print-area {
            padding: 10mm;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .label-card {
            border: 2px solid #000;
            padding: 15px;
            margin-bottom: 15px;
            page-break-inside: avoid;
            background: #fff;
        }

        .label-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }

        .label-title {
            font-size: 18px;
            font-weight: bold;
            color: #1a56db;
        }

        .label-body {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .label-info {
            flex: 1;
        }

        .label-info-item {
            margin-bottom: 5px;
        }

        .label-info-item .label {
            font-weight: bold;
            color: #555;
        }

        .label-info-item .value {
            font-weight: bold;
            color: #000;
        }

        .label-qr {
            border-left: 2px solid #000;
            padding-left: 20px;
            text-align: center;
        }

        .label-qr svg {
            display: block;
            margin: 0 auto;
            max-width: 150px;
            height: auto;
        }

        .label-qr-text {
            font-size: 10px;
            color: #666;
            margin-top: 5px;
        }

        @media print {
            @page { 
                size: A4; 
                margin: 8mm; 
            }
            
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            #print-area { 
                position: absolute; 
                top: 0; 
                left: 0; 
                width: 100%;
                box-shadow: none;
                border-radius: 0;
                padding: 5mm;
            }
            
            .print-header {
                display: none !important;
            }
            
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="print-header">
            <button onclick="history.back()" class="btn-back">⬅ Back</button>
            <button onclick="window.print()" class="btn-print">🖨️ Print Now</button>
        </div>

        <div id="print-area">
            @yield('content')
        </div>
    </div>

    <!-- Auto Print Script -->
    <script>
        // Tunggu halaman selesai loading
        window.addEventListener('load', function() {
            // Print otomatis setelah 1 detik
            setTimeout(function() {
                window.print();
            }, 1000);
        });

        // Setelah print selesai, kembali ke halaman sebelumnya
        window.onafterprint = function() {
            setTimeout(function() {
                window.history.back();
            }, 500);
        };
    </script>
</body>
</html>