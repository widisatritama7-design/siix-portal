<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESD Locker - Pengecekan Seragam</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0,0,0,0.12);
        }
        .header {
            background: linear-gradient(135deg, #2563eb, #3b82f6);
            padding: 32px 24px;
            text-align: center;
            color: #ffffff;
        }
        .header h1 {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
        }
        .header p {
            margin: 6px 0 0;
            opacity: 0.85;
            font-size: 14px;
        }
        .content {
            padding: 32px 28px;
        }
        .icon-large {
            text-align: center;
            font-size: 56px;
            margin-bottom: 12px;
        }
        .content h2 {
            color: #1e293b;
            font-size: 20px;
            font-weight: 700;
            margin: 0 0 8px;
            text-align: center;
        }
        .subtitle {
            text-align: center;
            color: #64748b;
            font-size: 14px;
            margin-top: 0;
            margin-bottom: 24px;
        }
        .greeting {
            color: #334155;
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 16px;
        }
        .greeting strong {
            color: #1e293b;
        }
        .divider {
            border: none;
            border-top: 2px solid #e2e8f0;
            margin: 24px 0;
        }
        /* ===== DETAILS TABLE ===== */
        .details-box {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border-left: 4px solid #2563eb;
            padding: 18px 22px;
            border-radius: 8px;
            margin: 16px 0 20px;
            overflow-x: auto;
        }
        .details-box .title {
            font-weight: 700;
            color: #1e293b;
            font-size: 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            border-bottom: 1px solid #bfdbfe;
            padding-bottom: 8px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .details-table tr {
            border-bottom: 1px solid rgba(191, 219, 254, 0.5);
        }
        .details-table tr:last-child {
            border-bottom: none;
        }
        .details-table td {
            padding: 10px 6px;
            color: #334155;
            vertical-align: middle;
        }
        .details-table .label {
            font-weight: 600;
            color: #475569;
            width: 35%;
            white-space: nowrap;
        }
        .details-table .value {
            font-weight: 600;
            color: #1e293b;
            width: 65%;
            text-align: right;
            word-break: break-word;
        }
        .details-table .value.locker {
            color: #2563eb;
            font-family: monospace;
            font-size: 16px;
        }
        .status-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }
        .info-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 10px;
            padding: 14px 18px;
            margin: 16px 0;
        }
        .info-box p {
            font-size: 13px;
            color: #166534;
            margin: 0;
        }
        .info-box ul {
            font-size: 13px;
            color: #166534;
            margin: 6px 0 0;
            padding-left: 20px;
        }
        .info-box ul li {
            margin-bottom: 3px;
        }
        .contact-box {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 10px;
            padding: 14px 18px;
            text-align: center;
            margin: 16px 0;
        }
        .contact-box p {
            font-size: 13px;
            color: #1e40af;
            margin: 0;
        }
        .contact-box strong {
            font-size: 15px;
        }
        .footer {
            background: #f1f5f9;
            padding: 20px 28px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .footer .brand {
            font-weight: 700;
            color: #475569;
        }
        .footer .separator {
            color: #cbd5e1;
            margin: 0 4px;
        }
        .footer .note {
            margin: 4px 0 0;
            font-size: 11px;
            font-style: italic;
        }
        .progress-steps {
            display: flex;
            justify-content: space-between;
            margin: 20px 0;
            padding: 0;
            position: relative;
        }
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 24px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: #e2e8f0;
            z-index: 0;
        }
        .step-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            flex: 1;
            position: relative;
            z-index: 1;
        }
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 14px;
            color: #94a3b8;
            border: 3px solid #e2e8f0;
        }
        .step-circle.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }
        .step-circle.completed {
            background: #22c55e;
            border-color: #22c55e;
            color: #ffffff;
        }
        .step-label {
            font-size: 11px;
            color: #94a3b8;
            margin-top: 6px;
            text-align: center;
            font-weight: 500;
        }
        .step-label.active {
            color: #2563eb;
        }
        .step-label.completed {
            color: #22c55e;
        }

        /* ===== RESPONSIVE ===== */
        @media only screen and (max-width: 480px) {
            .container {
                margin: 10px auto;
                border-radius: 12px;
            }
            .content {
                padding: 20px 16px;
            }
            .header {
                padding: 24px 16px;
            }
            .header h1 {
                font-size: 22px;
            }
            .header p {
                font-size: 13px;
            }
            
            .details-box {
                padding: 14px 14px;
                margin: 12px 0 16px 0;
            }
            .details-box .title {
                font-size: 13px;
                margin-bottom: 10px;
                padding-bottom: 6px;
            }
            .details-table {
                font-size: 13px;
            }
            .details-table td {
                padding: 8px 4px;
                display: block;
                width: 100% !important;
                text-align: left !important;
                border-bottom: 1px solid rgba(191, 219, 254, 0.3);
            }
            .details-table tr {
                display: block;
                border-bottom: 1px solid rgba(191, 219, 254, 0.5);
            }
            .details-table tr:last-child {
                border-bottom: none;
            }
            .details-table tr:last-child td:last-child {
                border-bottom: none;
            }
            .details-table .label {
                font-weight: 700;
                color: #475569;
                font-size: 12px;
                padding-bottom: 2px !important;
                padding-top: 8px !important;
                border-bottom: none !important;
            }
            .details-table .value {
                font-weight: 600;
                color: #1e293b;
                padding-top: 2px !important;
                padding-bottom: 8px !important;
                border-bottom: none !important;
            }
            .details-table .value.locker {
                font-size: 15px;
            }
            
            .greeting {
                font-size: 14px;
                line-height: 1.6;
            }
            
            .info-box {
                padding: 12px 14px;
                margin: 12px 0;
            }
            .info-box p {
                font-size: 12px;
            }
            .info-box ul {
                font-size: 12px;
                padding-left: 16px;
            }
            .info-box ul li {
                margin-bottom: 2px;
            }
            
            .contact-box {
                padding: 12px 14px;
                margin: 12px 0;
            }
            .contact-box p {
                font-size: 12px;
            }
            .contact-box strong {
                font-size: 14px;
            }
            
            .footer {
                padding: 16px 16px;
                font-size: 11px;
            }
            .footer .note {
                font-size: 10px;
            }
            .content h2 {
                font-size: 18px;
            }
            
            .progress-steps {
                flex-direction: column;
                gap: 10px;
            }
            .progress-steps::before {
                display: none;
            }
            .step-item {
                flex-direction: row;
                gap: 12px;
            }
        }

        /* Untuk tablet kecil */
        @media only screen and (min-width: 481px) and (max-width: 768px) {
            .content {
                padding: 24px 20px;
            }
            .details-table td {
                padding: 8px 4px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- HEADER -->
        <div class="header">
            <h1>ESD Locker System</h1>
            <p>Simpan dengan aman, ambil dengan mudah</p>
        </div>

        <!-- CONTENT -->
        <div class="content">

            <!-- Greeting -->
            <p class="greeting">
                Halo <strong>{{ $data['employee_name'] }}</strong>,
            </p>
            <p class="greeting" style="margin-top: -8px;">
                Seragam Anda sedang dalam <strong>proses pengecekan</strong> (On Progress Measure) di locker 
                <strong style="color: #2563eb;">{{ $data['locker_code'] }}</strong>.
            </p>

            <hr class="divider">

            <!-- Detail Transaksi - Menggunakan TABLE -->
            <div class="details-box">
                <div class="title">Detail Transaksi</div>
                <table class="details-table">
                    <tr>
                        <td class="label">NIK</td>
                        <td class="value">{{ $data['nik'] }}</td>
                    </tr>
                    <tr>
                        <td class="label">Nama</td>
                        <td class="value">{{ $data['employee_name'] }}</td>
                    </tr>
                    <tr>
                        <td class="label">Locker</td>
                        <td class="value locker">{{ $data['locker_code'] }}</td>
                    </tr>
                    <tr>
                        <td class="label">Waktu</td>
                        <td class="value">{{ $data['datetime'] }}</td>
                    </tr>
                    <tr>
                        <td class="label">Status</td>
                        <td class="value">
                            <span class="status-badge">Sedang Diperiksa</span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Informasi -->
            <div class="info-box">
                <p>
                    <strong>Informasi Penting:</strong>
                </p>
                <ul>
                    <li>Mohon tunggu, seragam Anda sedang diperiksa oleh tim ESD</li>
                    <li>Anda akan mendapat notifikasi email setelah selesai diperiksa</li>
                    <li>Proses pengecekan membutuhkan waktu ± 15-30 menit</li>
                    <li>Setelah selesai, Anda akan menerima kode akses untuk mengambil</li>
                </ul>
            </div>

            <!-- Kontak ESD -->
            <div class="contact-box">
                <p>
                    📞 Hubungi ESD Team: 
                    <strong>+62 878-8399-4150</strong>
                </p>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="footer">
            <p style="margin: 4px 0 0; color: #94a3b8;">
                © {{ date('Y') }} ESD Locker System. All Rights Reserved.
            </p>
            <p class="note">
                Email ini dikirim otomatis oleh sistem. Mohon tidak membalas email ini.
            </p>
        </div>
    </div>
</body>
</html>