<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESD Locker - Pengembalian Seragam</title>
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
            background: linear-gradient(135deg, #7c3aed, #8b5cf6);
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
        /* ===== QR CODE SECTION ===== */
        .qr-section {
            text-align: center;
            margin: 10px 0 24px 0;
            padding: 20px;
            background: linear-gradient(135deg, #faf5ff, #f3e8ff);
            border-radius: 12px;
            border: 2px dashed #c084fc;
        }
        .qr-section .qr-label {
            font-size: 12px;
            color: #6b21a8;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
            margin-bottom: 8px;
        }
        .qr-section .qr-code {
            display: inline-block;
            background: #ffffff;
            padding: 12px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            margin-bottom: 8px;
        }
        .qr-section .qr-code img {
            display: block;
            width: 160px;
            height: 160px;
            margin: 0 auto;
        }
        .qr-section .qr-hint {
            font-size: 13px;
            color: #4c1d95;
            font-weight: 500;
        }
        .qr-section .qr-hint small {
            font-weight: 400;
            color: #7c3aed;
        }
        /* ===== DETAILS TABLE ===== */
        .details-box {
            background: linear-gradient(135deg, #f5f3ff, #ede9fe);
            border-left: 4px solid #7c3aed;
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
            border-bottom: 1px solid #ddd6fe;
            padding-bottom: 8px;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        .details-table tr {
            border-bottom: 1px solid rgba(221, 214, 254, 0.5);
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
            color: #7c3aed;
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
        .status-badge.returned {
            background: #dbeafe;
            color: #1e40af;
        }
        /* ===== MEASUREMENT SECTION ===== */
        .measurement-section {
            background: linear-gradient(135deg, #faf5ff, #f3e8ff);
            border: 2px solid #c084fc;
            border-radius: 12px;
            padding: 16px 20px;
            margin: 16px 0;
        }
        .measurement-section .measurement-title {
            font-weight: 700;
            color: #6b21a8;
            font-size: 14px;
            text-align: center;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .measurement-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }
        .measurement-item {
            background: #ffffff;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            border: 1px solid #e9d5ff;
        }
        .measurement-item .label {
            font-size: 11px;
            color: #7c3aed;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .measurement-item .value {
            font-size: 18px;
            font-weight: 700;
            color: #1e293b;
            margin: 2px 0;
        }
        .measurement-item .scientific {
            font-size: 11px;
            color: #94a3b8;
        }
        .judgement-ok {
            display: inline-block;
            background: #22c55e;
            color: #ffffff;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            margin-top: 2px;
        }
        .judgement-ng {
            display: inline-block;
            background: #ef4444;
            color: #ffffff;
            padding: 2px 10px;
            border-radius: 12px;
            font-size: 10px;
            font-weight: 700;
            margin-top: 2px;
        }
        .measurement-footer {
            text-align: center;
            font-size: 12px;
            color: #6b21a8;
            border-top: 1px solid #e9d5ff;
            padding-top: 10px;
            margin-top: 10px;
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
        .info-box.warning {
            background: #fef2f2;
            border-color: #fca5a5;
        }
        .info-box.warning p,
        .info-box.warning ul {
            color: #991b1b;
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
        .return-summary {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 14px 18px;
            margin: 16px 0;
        }
        .return-summary p {
            font-size: 13px;
            color: #334155;
            margin: 0;
        }
        .return-summary ul {
            font-size: 13px;
            color: #334155;
            margin: 6px 0 0;
            padding-left: 20px;
        }
        .return-summary ul li {
            margin-bottom: 3px;
        }

        /* ===== RESPONSIVE FIX UNTUK HP ===== */
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
            
            .qr-section {
                padding: 16px;
                margin: 5px 0 16px 0;
            }
            .qr-section .qr-code img {
                width: 120px;
                height: 120px;
            }
            .qr-section .qr-hint {
                font-size: 12px;
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
                border-bottom: 1px solid rgba(221, 214, 254, 0.3);
            }
            .details-table tr {
                display: block;
                border-bottom: 1px solid rgba(221, 214, 254, 0.5);
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
            
            .measurement-grid {
                grid-template-columns: 1fr;
            }
            .measurement-item .value {
                font-size: 16px;
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
            
            .return-summary {
                padding: 12px 14px;
                margin: 12px 0;
            }
            .return-summary p {
                font-size: 12px;
            }
            .return-summary ul {
                font-size: 12px;
                padding-left: 16px;
            }
            
            .footer {
                padding: 16px 16px;
                font-size: 11px;
            }
            .footer .note {
                font-size: 10px;
            }
        }

        @media only screen and (min-width: 481px) and (max-width: 768px) {
            .content {
                padding: 24px 20px;
            }
            .details-table td {
                padding: 8px 4px;
            }
            .measurement-grid {
                grid-template-columns: 1fr 1fr;
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

            <!-- ===== QR CODE SECTION ===== -->
            <div class="qr-section">
                <div class="qr-label">Scan untuk Pengambilan</div>
                <div class="qr-code">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($data['access_code'] ?? 'ESD-' . $data['locker_code']) }}" 
                         alt="QR Code untuk Pengembalian Seragam"
                         width="160"
                         height="160">
                </div>
                <div class="qr-hint">
                    Scan QR Code untuk proses pengambilan seragam<br>
                    <small>atau gunakan kode: <strong>{{ $data['access_code'] ?? 'ESD-' . $data['locker_code'] }}</strong></small>
                </div>
            </div>

            <!-- Greeting -->
            <p class="greeting">
                Halo <strong>{{ $data['employee_name'] }}</strong>,
            </p>
            <p class="greeting" style="margin-top: -8px;">
                Seragam Anda telah berhasil <strong>dikembalikan</strong> ke locker 
                <strong style="color: #7c3aed;">{{ $data['locker_code'] }}</strong>.
            </p>

            <hr class="divider">

            <!-- ===== DATA PENGUKURAN ===== -->
            @if(isset($data['garment_data']) && $data['garment_data'])
            <div class="measurement-section">
                <div class="measurement-title">
                    Data Pengukuran Seragam
                </div>
                <div class="measurement-grid">
                    <div class="measurement-item">
                        <div class="label">D1</div>
                        <div class="value">{{ $data['garment_data']['d1'] ?? '-' }}</div>
                        <div class="scientific">{{ $data['garment_data']['d1_scientific'] ?? '-' }}</div>
                        @if(isset($data['garment_data']['judgement_d1']))
                            <span class="judgement-{{ $data['garment_data']['judgement_d1'] == 'OK' ? 'ok' : 'ng' }}">
                                {{ $data['garment_data']['judgement_d1'] }}
                            </span>
                        @endif
                    </div>
                    <div class="measurement-item">
                        <div class="label">D2</div>
                        <div class="value">{{ $data['garment_data']['d2'] ?? '-' }}</div>
                        <div class="scientific">{{ $data['garment_data']['d2_scientific'] ?? '-' }}</div>
                        @if(isset($data['garment_data']['judgement_d2']))
                            <span class="judgement-{{ $data['garment_data']['judgement_d2'] == 'OK' ? 'ok' : 'ng' }}">
                                {{ $data['garment_data']['judgement_d2'] }}
                            </span>
                        @endif
                    </div>
                    <div class="measurement-item">
                        <div class="label">D3</div>
                        <div class="value">{{ $data['garment_data']['d3'] ?? '-' }}</div>
                        <div class="scientific">{{ $data['garment_data']['d3_scientific'] ?? '-' }}</div>
                        @if(isset($data['garment_data']['judgement_d3']))
                            <span class="judgement-{{ $data['garment_data']['judgement_d3'] == 'OK' ? 'ok' : 'ng' }}">
                                {{ $data['garment_data']['judgement_d3'] }}
                            </span>
                        @endif
                    </div>
                    <div class="measurement-item">
                        <div class="label">D4</div>
                        <div class="value">{{ $data['garment_data']['d4'] ?? '-' }}</div>
                        <div class="scientific">{{ $data['garment_data']['d4_scientific'] ?? '-' }}</div>
                        @if(isset($data['garment_data']['judgement_d4']))
                            <span class="judgement-{{ $data['garment_data']['judgement_d4'] == 'OK' ? 'ok' : 'ng' }}">
                                {{ $data['garment_data']['judgement_d4'] }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            @endif

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
                            <span class="status-badge returned">Dikembalikan</span>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Ringkasan Pengembalian -->
            <div class="return-summary">
                <p>
                    <strong>Ringkasan Pengembalian:</strong>
                </p>
                <ul>
                    <li>Seragam telah dikembalikan ke locker {{ $data['locker_code'] }}</li>
                    <li>Locker dalam keadaan terkunci dengan aman</li>
                    <li>Terima kasih telah menggunakan layanan ESD Locker</li>
                </ul>
            </div>

            <!-- Informasi -->
            <div class="info-box">
                <p>
                    <strong>Informasi:</strong>
                </p>
                <ul>
                    <li>Seragam Anda telah aman tersimpan di locker</li>
                    <li>Untuk pengambilan berikutnya, gunakan prosedur yang sama</li>
                    <li>Jika ada kendala, hubungi tim ESD</li>
                </ul>
            </div>

            <div class="info-box warning">
                <p>
                    <strong>Perhatian:</strong>
                </p>
                <ul>
                    <li>Pastikan locker tertutup dengan rapat setelah digunakan</li>
                    <li>Jangan tinggalkan barang berharga di dalam locker</li>
                    <li>Laporkan jika ada kerusakan pada locker</li>
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