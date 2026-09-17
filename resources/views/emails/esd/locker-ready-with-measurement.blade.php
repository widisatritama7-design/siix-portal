<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ESD Locker - Seragam Siap Diambil</title>
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
            background: linear-gradient(135deg, #16a34a, #22c55e);
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
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-radius: 12px;
            border: 2px dashed #22c55e;
        }
        .qr-section .qr-label {
            font-size: 12px;
            color: #166534;
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
            color: #166534;
            font-weight: 500;
        }
        .qr-section .qr-hint small {
            font-weight: 400;
            color: #22c55e;
        }

        /* ===== ACCESS CODE ===== */
        .access-code-box {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 2px solid #eab308;
            border-radius: 12px;
            padding: 18px 20px;
            margin: 20px 0;
            text-align: center;
        }
        .access-code-box .label {
            font-size: 12px;
            color: #854d0e;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            font-weight: 700;
        }
        .access-code-box .code {
            font-size: 32px;
            font-weight: 700;
            color: #1e293b;
            font-family: 'Courier New', monospace;
            margin: 6px 0 4px;
            letter-spacing: 3px;
            background: #ffffff;
            padding: 8px 16px;
            border-radius: 8px;
            display: inline-block;
        }

        /* ===== DETAILS TABLE ===== */
        .details-box {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border-left: 4px solid #22c55e;
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
            justify-content: center;
            gap: 8px;
            border-bottom: 1px solid #bbf7d0;
            padding-bottom: 8px;
        }

        .details-table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .details-table-wrapper::-webkit-scrollbar {
            height: 6px;
        }
        .details-table-wrapper::-webkit-scrollbar-track {
            background: #dcfce7;
            border-radius: 4px;
        }
        .details-table-wrapper::-webkit-scrollbar-thumb {
            background: #22c55e;
            border-radius: 4px;
        }
        .details-table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #16a34a;
        }

        .details-table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
            font-size: 14px;
        }
        .details-table thead {
            background: linear-gradient(135deg, #dcfce7, #bbf7d0);
        }
        .details-table th {
            padding: 10px 16px;
            font-weight: 700;
            color: #166534;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #22c55e;
            white-space: nowrap;
            text-align: center;
        }
        .details-table .text-center {
            text-align: center;
        }
        .details-table tr {
            border-bottom: 1px solid rgba(187, 247, 208, 0.5);
        }
        .details-table tr:last-child {
            border-bottom: none;
        }
        .details-table td {
            padding: 8px 16px;
            color: #334155;
            vertical-align: middle;
            white-space: nowrap;
            text-align: center;
        }
        .details-table .value {
            font-weight: 400;
            color: #1e293b;
        }
        .details-table .value.locker {
            color: #2563eb;
            font-family: monospace;
            font-size: 16px;
        }

        /* ===== STATUS BADGE ===== */
        .status-badge {
            display: inline-block;
            background: #22c55e;
            color: #ffffff;
            padding: 4px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
        }

        /* ===== MEASUREMENT TABLE ===== */
        .measurement-section {
            background: linear-gradient(135deg, #faf5ff, #f3e8ff);
            border: 2px solid #c084fc;
            border-radius: 12px;
            padding: 16px 20px;
            margin: 16px 0;
            overflow-x: auto;
        }
        .measurement-section .measurement-title {
            font-weight: 700;
            color: #6b21a8;
            font-size: 14px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-bottom: 1px solid #e9d5ff;
            padding-bottom: 8px;
        }

        .measurement-standard-wrapper {
            text-align: center;
            padding: 8px 0 12px 0;
        }
        .measurement-standard-badge {
            display: inline-block;
            background: #fef3c7;
            border: 1px solid #f59e0b;
            color: #92400e;
            padding: 6px 20px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(245, 158, 11, 0.15);
        }

        .measurement-table-wrapper {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .measurement-table-wrapper::-webkit-scrollbar {
            height: 6px;
        }
        .measurement-table-wrapper::-webkit-scrollbar-track {
            background: #f3e8ff;
            border-radius: 4px;
        }
        .measurement-table-wrapper::-webkit-scrollbar-thumb {
            background: #c084fc;
            border-radius: 4px;
        }
        .measurement-table-wrapper::-webkit-scrollbar-thumb:hover {
            background: #a855f7;
        }

        .measurement-table {
            width: 100%;
            min-width: 480px;
            border-collapse: collapse;
            font-size: 14px;
        }
        .measurement-table thead {
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
        }
        .measurement-table th {
            padding: 10px 16px;
            font-weight: 700;
            color: #4c1d95;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #c084fc;
            white-space: nowrap;
            text-align: center;
        }
        .measurement-table .text-center {
            text-align: center;
        }
        .measurement-table tr {
            border-bottom: 1px solid rgba(233, 213, 255, 0.5);
        }
        .measurement-table tr:last-child {
            border-bottom: none;
        }
        .measurement-table td {
            padding: 8px 16px;
            color: #334155;
            vertical-align: middle;
            white-space: nowrap;
            text-align: center;
        }
        .measurement-table .label {
            font-weight: 400;
            color: #475569;
        }
        .measurement-table .value {
            font-weight: 400;
            color: #1e293b;
        }
        .judgement-ok {
            display: inline-block;
            background: #22c55e;
            color: #ffffff;
            padding: 2px 14px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
        }
        .judgement-ng {
            display: inline-block;
            background: #ef4444;
            color: #ffffff;
            padding: 2px 14px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 700;
        }

        /* ===== INFO BOX ===== */
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

        /* ===== CONTACT BOX ===== */
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

        /* ===== FOOTER ===== */
        .footer {
            background: #f1f5f9;
            padding: 20px 28px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .footer .note {
            margin: 4px 0 0;
            font-size: 11px;
            font-style: italic;
        }

        /* ===== RESPONSIVE ===== */
        @media only screen and (max-width: 480px) {
            .content {
                padding: 20px 16px;
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

            .access-code-box .code {
                font-size: 24px;
                padding: 6px 12px;
            }

            .details-box {
                padding: 12px 14px;
                margin: 12px 0 16px 0;
            }
            .details-box .title {
                font-size: 13px;
                margin-bottom: 10px;
                padding-bottom: 6px;
            }
            .details-table {
                font-size: 12px;
                min-width: 500px;
            }
            .details-table th,
            .details-table td {
                padding: 6px 10px;
            }
            .details-table .value.locker {
                font-size: 13px;
            }
            .status-badge {
                font-size: 11px;
                padding: 2px 10px;
            }

            .measurement-section {
                padding: 12px 14px;
            }
            .measurement-table {
                font-size: 13px;
                min-width: 380px;
            }
            .measurement-table th,
            .measurement-table td {
                padding: 6px 10px;
            }
            .measurement-standard-badge {
                font-size: 12px;
                padding: 4px 14px;
            }
            .measurement-standard-wrapper {
                padding: 4px 0 10px 0;
            }
            .judgement-ok,
            .judgement-ng {
                font-size: 11px;
                padding: 1px 10px;
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

            <!-- QR Code -->
            <div class="qr-section">
                <div class="qr-label">Scan untuk Pengambilan</div>
                <div class="qr-code">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=300x300&data={{ urlencode($data['access_code'] ?? '') }}" 
                         alt="QR Code"
                         width="160"
                         height="160">
                </div>
                <div class="qr-hint">
                    Scan QR Code untuk proses pengambilan seragam<br>
                </div>
            </div>

                        <!-- Access Code -->
            <div class="access-code-box">
                <div class="label">ATAU KETIK KODE AKSES PENGAMBILAN</div>
                <div class="code">{{ $data['access_code'] ?? '' }}</div>
            </div>

            <!-- Greeting -->
            <p class="greeting">
                Halo <strong>{{ $data['employee_name'] ?? '' }}</strong>,
            </p>
            <p class="greeting" style="margin-top: -8px; color: #16a34a;">
                <strong>Seragam Anda telah selesai diperiksa dan siap diambil!</strong>
            </p>

            <hr class="divider">

            <!-- ===== DATA PENGUKURAN ===== -->
            @if(isset($data['garment_data']) && $data['garment_data'])
            <div class="measurement-section">
                <div class="measurement-title">Data Hasil Pengukuran Seragam</div>
                
                <!-- Standard Value - Badge Kuning dengan jarak -->
                <div class="measurement-standard-wrapper">
                    <span class="measurement-standard-badge">
                        Standard : &lt; 1.00E+11 Ohm
                    </span>
                </div>
                
                <!-- WRAPPER UNTUK SCROLL HORIZONTAL DI HP -->
                <div class="measurement-table-wrapper">
                    <table class="measurement-table">
                        <thead>
                            <tr>
                                <th class="text-center">Type</th>
                                <th class="text-center">Result</th>
                                <th class="text-center">Judgement</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="label text-center">D1 (Shirt/Baju)</td>
                                <td class="value text-center">{{ $data['garment_data']['d1_scientific'] ?? '-' }}</td>
                                <td class="value text-center">
                                    @if(isset($data['garment_data']['judgement_d1']))
                                        <span class="judgement-{{ $data['garment_data']['judgement_d1'] == 'OK' ? 'ok' : 'ng' }}">
                                            {{ $data['garment_data']['judgement_d1'] }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label text-center">D2 (Pants/Celana)</td>
                                <td class="value text-center">{{ $data['garment_data']['d2_scientific'] ?? '-' }}</td>
                                <td class="value text-center">
                                    @if(isset($data['garment_data']['judgement_d2']))
                                        <span class="judgement-{{ $data['garment_data']['judgement_d2'] == 'OK' ? 'ok' : 'ng' }}">
                                            {{ $data['garment_data']['judgement_d2'] }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label text-center">D3 (Cap/Topi)</td>
                                <td class="value text-center">{{ $data['garment_data']['d3_scientific'] ?? '-' }}</td>
                                <td class="value text-center">
                                    @if(isset($data['garment_data']['judgement_d3']))
                                        <span class="judgement-{{ $data['garment_data']['judgement_d3'] == 'OK' ? 'ok' : 'ng' }}">
                                            {{ $data['garment_data']['judgement_d3'] }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="label text-center">D4 (Hijab/Jilbab)</td>
                                <td class="value text-center">{{ $data['garment_data']['d4_scientific'] ?? '-' }}</td>
                                <td class="value text-center">
                                    @if(isset($data['garment_data']['judgement_d4']))
                                        <span class="judgement-{{ $data['garment_data']['judgement_d4'] == 'OK' ? 'ok' : 'ng' }}">
                                            {{ $data['garment_data']['judgement_d4'] }}
                                        </span>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Detail Transaksi -->
            <div class="details-box">
                <div class="title">Detail Transaksi</div>
                
                <!-- WRAPPER UNTUK SCROLL HORIZONTAL DI HP -->
                <div class="details-table-wrapper">
                    <table class="details-table">
                        <thead>
                            <tr>
                                <th class="text-center">NIK</th>
                                <th class="text-center">Nama</th>
                                <th class="text-center">Locker</th>
                                <th class="text-center">Waktu</th>
                                <th class="text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="value text-center">{{ $data['nik'] ?? '' }}</td>
                                <td class="value text-center">{{ $data['employee_name'] ?? '' }}</td>
                                <td class="value text-center locker">{{ $data['locker_code'] ?? '' }}</td>
                                <td class="value text-center">{{ $data['datetime'] ?? '' }}</td>
                                <td class="value text-center">
                                    <span class="status-badge">Siap Diambil</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Informasi -->
            <div class="info-box">
                <p><strong>Langkah Selanjutnya:</strong></p>
                <ul>
                    <li>Datang ke lokasi locker ESD</li>
                    <li>Masukkan kode akses <strong>{{ $data['access_code'] ?? '' }}</strong> di terminal</li>
                    <li>Locker akan terbuka otomatis</li>
                    <li>Ambil seragam Anda dan tutup locker dengan rapat</li>
                </ul>
            </div>

            <div class="info-box warning">
                <p><strong>Perhatian:</strong></p>
                <ul>
                    <li>Kode akses hanya <strong>satu kali pakai</strong></li>
                    <li>Jangan berikan kode akses kepada orang lain</li>
                    <li>Jika ada kendala, hubungi tim ESD</li>
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