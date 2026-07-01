<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>NCP - {{ $ncp->ncp_number }}</title>
    <style>
        @page {
            margin: 15px 20px;
        }
        
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #000;
            line-height: 1.4;
        }
        
        .header {
            text-align: center;
            padding-bottom: 6px;
            border-bottom: 2px solid #000;
            margin-bottom: 10px;
        }
        
        .header h2 {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
            letter-spacing: 1px;
        }
        
        .header h3 {
            font-size: 13px;
            font-weight: normal;
            margin: 2px 0 0 0;
            font-style: italic;
        }
        
        /* ===== ROW 1: TAG NO & DATE ===== */
        .row-tag {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
            margin-bottom: 8px;
            padding-bottom: 4px;
            border-bottom: 1px dashed #ccc;
        }
        
        .tag-no {
            display: flex;
            align-items: baseline;
            gap: 5px;
        }
        
        .tag-no .label {
            font-weight: bold;
            font-size: 13px;
        }
        
        .tag-no .value {
            font-weight: bold;
            font-size: 14px;
            border-bottom: 1px solid #000;
            padding: 0 8px;
            min-width: 150px;
        }
        
        .tag-date {
            display: flex;
            align-items: baseline;
            gap: 5px;
        }
        
        .tag-date .label {
            font-weight: bold;
            font-size: 13px;
        }
        
        .tag-date .value {
            border-bottom: 1px solid #000;
            padding: 0 8px;
            min-width: 100px;
        }
        
        /* ===== ROW 2: Kiri & Kanan ===== */
        .row-two-col {
            display: flex;
            gap: 30px;
            margin-bottom: 4px;
        }
        
        .col-left {
            flex: 1;
        }
        
        .col-right {
            flex: 1;
        }
        
        .field-row {
            display: flex;
            align-items: baseline;
            margin-bottom: 2px;
        }
        
        .field-row .label {
            font-weight: bold;
            min-width: 110px;
            flex-shrink: 0;
        }
        
        .field-row .label-sm {
            font-weight: bold;
            min-width: 90px;
            flex-shrink: 0;
        }
        
        .field-row .value {
            border-bottom: 1px solid #000;
            padding: 0 5px;
            flex: 1;
            min-height: 18px;
        }
        
        .field-row .value-sm {
            border-bottom: 1px solid #000;
            padding: 0 5px;
            min-width: 60px;
            flex-shrink: 0;
        }
        
        .field-row .value-failure {
            border-bottom: 1px solid #000;
            padding: 0 5px;
            min-width: 50px;
            flex-shrink: 0;
            font-weight: bold;
            color: #dc2626;
        }
        
        .field-row .value-center {
            border-bottom: 1px solid #000;
            padding: 0 5px;
            flex: 1;
            text-align: center;
        }
        
        /* ===== ROW 3: DEFECT TABLE ===== */
        .defect-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10px;
            margin: 5px 0 6px 0;
        }
        
        .defect-table th {
            border: 1px solid #000;
            padding: 3px 5px;
            text-align: center;
            font-weight: bold;
            background-color: #f0f0f0;
        }
        
        .defect-table td {
            border: 1px solid #000;
            padding: 3px 5px;
            min-height: 18px;
        }
        
        .defect-table td.empty {
            height: 18px;
        }
        
        /* ===== ROW 4: DO, Packing List, Remarks ===== */
        .row-doc {
            display: flex;
            gap: 15px;
            margin: 4px 0;
            align-items: baseline;
        }
        
        .row-doc .field {
            display: flex;
            align-items: baseline;
            flex: 1;
        }
        
        .row-doc .label {
            font-weight: bold;
            min-width: 100px;
            flex-shrink: 0;
        }
        
        .row-doc .label-sm {
            font-weight: bold;
            min-width: 80px;
            flex-shrink: 0;
        }
        
        .row-doc .value {
            border-bottom: 1px solid #000;
            padding: 0 5px;
            flex: 1;
            min-height: 18px;
        }
        
        /* ===== ROW 5: DISPOSITION ===== */
        .disposition-section {
            margin: 6px 0 4px 0;
            padding: 4px 0;
            border-top: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        
        .disposition-title {
            font-weight: bold;
            font-size: 12px;
        }
        
        .disposition-items {
            display: flex;
            flex-wrap: wrap;
            gap: 5px 25px;
            margin-top: 3px;
        }
        
        .disposition-item {
            display: inline-flex;
            align-items: baseline;
            gap: 2px;
        }
        
        .disposition-item .check {
            font-weight: bold;
            font-size: 12px;
        }
        
        .disposition-item .detail {
            font-style: italic;
            color: #555;
            margin-left: 2px;
        }
        
        /* ===== ROW 6: SIGNATURE ===== */
        .signature-section {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            padding-top: 8px;
        }
        
        .signature-box {
            flex: 1;
        }
        
        .signature-box .label {
            font-weight: bold;
            font-size: 11px;
        }
        
        .signature-box .name {
            font-weight: bold;
            font-size: 12px;
            margin-top: 2px;
        }
        
        .signature-box .dept {
            font-size: 10px;
            color: #555;
        }
        
        .signature-line {
            border-bottom: 1px solid #000;
            width: 180px;
            margin-top: 15px;
        }
        
        .signature-line-right {
            border-bottom: 1px solid #000;
            width: 150px;
            margin-top: 15px;
            margin-left: auto;
        }
        
        .signature-date {
            font-size: 9px;
            color: #666;
            margin-top: 2px;
        }
        
        /* ===== ROW 7: FOOTER ===== */
        .footer {
            text-align: center;
            font-size: 9px;
            font-weight: bold;
            margin-top: 10px;
            padding-top: 5px;
            border-top: 2px solid #000;
            display: flex;
            justify-content: space-between;
        }
        
        .footer .left {
            font-weight: bold;
        }
        
        .footer .right {
            font-size: 8px;
            font-weight: normal;
            color: #666;
        }
        
        /* ===== BARCODE ===== */
        .barcode-section {
            text-align: center;
            margin-top: 4px;
            padding-top: 4px;
        }
        
        .barcode-section img {
            max-height: 40px;
        }
        
        .barcode-number {
            font-size: 9px;
            font-weight: bold;
            letter-spacing: 1px;
            margin-top: 1px;
        }
        
        /* ===== STATUS ===== */
        .status-badge {
            display: inline-block;
            padding: 1px 10px;
            border: 1px solid #000;
            font-size: 9px;
            font-weight: bold;
            margin-left: 5px;
        }
        
        .status-badge.open { background: #fff3cd; }
        .status-badge.in_progress { background: #cce5ff; }
        .status-badge.closed { background: #d4edda; }
        .status-badge.rejected { background: #f8d7da; }
        
        .status-row {
            text-align: right;
            margin-top: 2px;
            font-size: 10px;
        }
        
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }
    </style>
</head>
<body>
    <!-- ============================================ -->
    <!-- HEADER: Title di Kiri, Barcode di Kanan -->
    <!-- ============================================ -->
    <table style="width: 100%; border-bottom: 2px solid #000; padding-bottom: 6px; margin-bottom: 10px;">
        <tr>
            <td style="text-align: left; width: 70%;">
                <h2 style="font-size: 16px; font-weight: bold; margin: 0; letter-spacing: 1px;">PT. SIIX EMS INDONESIA</h2>
                <h3 style="font-size: 13px; font-weight: normal; margin: 2px 0 0 0;">NON-CONFORMING PRODUCT TAG (NCP TAG)</h3>
            </td>
        </tr>
    </table>

    <!-- ============================================ -->
    <!-- ROW 1: TAG NO. & DATE (Kanan Atas - Atas Bawah) -->
    <!-- ============================================ -->
    <div style="width: 100%; border-bottom: 1px dashed #ccc; margin-bottom: 8px; padding-bottom: 4px;">
        <table style="margin-left: auto; border-collapse: collapse;">
            <!-- BARIS 1: TAG NO. -->
            <tr>
                <!-- Kolom 1: Label -->
                <td style="text-align: left; padding: 2px 0; sans-serif;">
                    <span style="font-weight: bold; font-size: 13px;">TAG NO</span>
                </td>
                <!-- Kolom 2: Tanda : -->
                <td style="text-align: right; padding: 2px 4px; sans-serif;">
                    <span style="font-weight: bold; font-size: 13px;">:</span>
                </td>
                <!-- Kolom 3: Value -->
                <td style="text-align: right; padding: 2px 0; sans-serif;">
                    <span style="font-weight: bold; font-size: 13px;">{{ $ncp->ncp_number }}</span>
                </td>
            </tr>
            <!-- BARIS 2: DATE -->
            <tr>
                <!-- Kolom 1: Label -->
                <td style="text-align: left; padding: 2px 0; sans-serif;">
                    <span style="font-weight: bold; font-size: 13px;">DATE</span>
                </td>
                <!-- Kolom 2: Tanda : -->
                <td style="text-align: right; padding: 2px 4px; sans-serif;">
                    <span style="font-weight: bold; font-size: 13px;">:</span>
                </td>
                <!-- Kolom 3: Value -->
                <td style="text-align: right; padding: 2px 0; sans-serif;">
                    <span style="font-weight: bold; font-size: 13px;">{{ $ncp->created_at ? \Carbon\Carbon::parse($ncp->created_at)->format('d/m/Y H:i') : '-' }}</span>
                </td>
            </tr>
        </table>
    </div>

    <!-- ============================================ -->
    <!-- ROW 2: KIRI (PART DESCRIPTION, PART NUMBER, SUPPLIER, CUSTOMER) -->
    <!--        KANAN (MODEL AFFECTED, LOT NO., LOT QTY, REJECTED QTY FAILURE RATE) -->
    <!-- ============================================ -->
    <table style="width: 100%; margin-bottom: 4px; border-collapse: collapse;">
        <tr>
            <!-- Kolom Kiri -->
            <td style="width: 50%; vertical-align: top; padding-right: 20px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="font-weight: bold; width: 140px; padding: 2px 0; font-size: 10px">PART DESCRIPTION</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px;">{{ $ncp->part_description ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; width: 140px; padding: 2px 0; font-size: 10px">PART NUMBER</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px;">{{ $ncp->part_number ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; width: 140px; padding: 2px 0; font-size: 10px">SUPPLIER</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px;">{{ $ncp->supplier ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; width: 140px; padding: 2px 0; font-size: 10px">CUSTOMER</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px;">{{ $ncp->customer ?? '' }}</td>
                    </tr>
                </table>
            </td>
            
            <!-- Kolom Kanan -->
            <td style="width: 50%; vertical-align: top;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="font-weight: bold; width: 140px; padding: 2px 0; font-size: 10px">MODEL AFFECTED</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px;">{{ $ncp->model_affected ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; width: 140px; padding: 2px 0; font-size: 10px">LOT NO.</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px;">{{ $ncp->lot_no ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; width: 140px; padding: 2px 0; font-size: 10px">LOT QTY</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px;">{{ $ncp->lot_qty ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="font-weight: bold; width: 140px; padding: 2px 0; font-size: 10px">REJECTED QTY</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px; width: 60px;">{{ $ncp->rejected_qty ?? '' }}</td>
                        <td style="font-weight: bold; padding: 2px 0 2px 15px; font-size: 10px">FAILURE RATE</td>
                        <td style="padding: 2px 5px; width: 10px;">:</td>
                        <td style="padding: 2px 5px; font-weight: bold; color: #dc2626; font-size: 8px">{{ $ncp->failure_rate ? number_format((float)$ncp->failure_rate, 2, '.', '') . '%' : '0.00%' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ============================================ -->
    <!-- ROW 3: DEFECT TABLE (S/N, DEFECT DESCRIPTION, QTY, REMARKS) -->
    <!-- ============================================ -->
    <div style="padding-top: 2px;">
        <table class="defect-table" style="width: 100%; border-collapse: collapse; font-size: 10px; margin: 5px 0 6px 0;">
            <thead>
                <tr>
                    <th style="width: 10%; border: 1px solid #000; padding: 2px 3px; text-align: center; font-weight: bold; background-color: #f0f0f0;">S/N</th>
                    <th style="width: 45%; border: 1px solid #000; padding: 2px 3px; text-align: center; font-weight: bold; background-color: #f0f0f0;">DEFECT DESCRIPTION</th>
                    <th style="width: 10%; border: 1px solid #000; padding: 2px 3px; text-align: center; font-weight: bold; background-color: #f0f0f0;">QTY</th>
                    <th style="width: 35%; border: 1px solid #000; padding: 2px 3px; text-align: center; font-weight: bold; background-color: #f0f0f0;">REMARKS</th>
                </tr>
            </thead>
            <tbody>
                @if($ncp->defect_details && count($ncp->defect_details) > 0)
                    @foreach($ncp->defect_details as $defect)
                    <tr>
                        <td style="border: 1px solid #000; padding: 1px 3px; text-align: center;">{{ $defect['serial_number'] ?? '' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 3px;">{{ $defect['defect_description'] ?? '' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 3px; text-align: center;">{{ $defect['quantity'] ?? '' }}</td>
                        <td style="border: 1px solid #000; padding: 1px 3px;">{{ $defect['defect_remarks'] ?? '' }}</td>
                    </tr>
                    @endforeach
                    @for($i = count($ncp->defect_details); $i < 6; $i++)
                    <tr>
                        <td style="border: 1px solid #000; padding: 1px 3px; height: 16px;"></td>
                        <td style="border: 1px solid #000; padding: 1px 3px; height: 16px;"></td>
                        <td style="border: 1px solid #000; padding: 1px 3px; height: 16px;"></td>
                        <td style="border: 1px solid #000; padding: 1px 3px; height: 16px;"></td>
                    </tr>
                    @endfor
                @else
                    @for($i = 0; $i < 6; $i++)
                    <tr>
                        <td style="border: 1px solid #000; padding: 1px 3px; height: 16px;"></td>
                        <td style="border: 1px solid #000; padding: 1px 3px; height: 16px;"></td>
                        <td style="border: 1px solid #000; padding: 1px 3px; height: 16px;"></td>
                        <td style="border: 1px solid #000; padding: 1px 3px; height: 16px;"></td>
                    </tr>
                    @endfor
                @endif
            </tbody>
        </table>
    </div>

    <!-- ============================================ -->
    <!-- ROW 4: DO No., Packing List No./Invoice No., Remarks (HORIZONTAL) -->
    <!-- ============================================ -->
    <table style="width: 100%; margin: 4px 0; border-collapse: collapse; ">
        <tr>
            <td style="white-space: nowrap; font-weight: bold; padding-right: 3px; width: 35px;">DO No.</td>
            <td style="border-bottom: 1px solid #000; padding: 0 5px; width: 20%; font-size: 7px;">{{ $ncp->do_no ?? '' }}</td>
            
            <td style="white-space: nowrap; font-weight: bold; padding: 0 3px 0 15px; width: 120px;">Packing List No./Invoice No.</td>
            <td style="border-bottom: 1px solid #000; padding: 0 5px; width: 25%; font-size: 7px;">{{ $ncp->packing_list_no ?? '' }}</td>
            
            <td style="white-space: nowrap; font-weight: bold; padding: 0 3px 0 15px; width: 55px;">Remarks</td>
            <td style="border-bottom: 1px solid #000; padding: 0 5px; flex: 1; font-size: 7px;">{{ $ncp->remarks ?? '' }}</td>
        </tr>
    </table>

    <!-- ============================================ -->
    <!-- ROW 5: DISPOSITION (HORIZONTAL) -->
    <!-- ============================================ -->
    <div style="margin: 6px 0 4px 0; padding: 4px 0; border-bottom: 1px dashed #ccc;">
        <div style="font-weight: bold; font-size: 12px; margin-bottom: 6px;">DISPOSITION :</div>
        
        @php
            $selectedDispositions = [];
            if ($ncp->disposition) {
                $parts = explode(', ', $ncp->disposition);
                foreach ($parts as $part) {
                    if (str_contains($part, ': ')) {
                        list($key, $value) = explode(': ', $part, 2);
                        $selectedDispositions[trim($key)] = trim($value);
                    } else {
                        $selectedDispositions[trim($part)] = null;
                    }
                }
            }
            
            $allDispositions = ['Sorting', 'Rework', 'Scrap', 'Use as it', 'RTV/S. (CAR/NO CAR)', 'Others'];
        @endphp
        
        <div style="padding: 4px 0;">
            @foreach($allDispositions as $option)
                @if(array_key_exists($option, $selectedDispositions))
                    <!-- Selected - Kotak hitam penuh -->
                    <span style="display: inline-block; margin-right: 15px; font-size: 10px; vertical-align: middle;">
                        <span style="display: inline-block; width: 14px; height: 14px; background-color: #000000; text-align: center; line-height: 14px; border-radius: 2px; vertical-align: middle;"></span>
                        <span style="font-weight: 600; color: #000000; vertical-align: middle; margin-left: 3px;">{{ $option }}</span>
                        @if($selectedDispositions[$option])
                            <span style="font-weight: normal; color: #000000; font-style: italic; margin-left: 2px; vertical-align: middle;">
                                ({{ $selectedDispositions[$option] }})
                            </span>
                        @endif
                    </span>
                @else
                    <!-- Not Selected - Kotak kosong -->
                    <span style="display: inline-block; margin-right: 15px; font-size: 10px; vertical-align: middle;">
                        <span style="display: inline-block; width: 14px; height: 14px; border: 1.5px solid #000000; text-align: center; line-height: 14px; border-radius: 2px; vertical-align: middle;"></span>
                        <span style="color: #000000; vertical-align: middle; margin-left: 3px;">{{ $option }}</span>
                    </span>
                @endif
            @endforeach
        </div>
    </div>

    <!-- ============================================ -->
    <!-- ROW 6: SIGNATURE (Prepared by & Approved) SEJAJAR -->
    <!-- ============================================ -->
    <table style="width: 100%; margin-top: 10px; border-collapse: collapse;">
        <tr>
            <!-- Prepared by (Kiri) -->
            <td style="width: 50%; vertical-align: top; padding-right: 20px; text-align: left;">
                <div style="font-weight: bold; font-size: 11px; margin-bottom: 4px; text-align: left; padding-left: 70px;">Prepared by (Dept and Name)</div>
                <div style="font-weight: font-size: 12px; margin-top: 2px; text-align: left; padding-left: 70px;">{{ $ncp->employee->department ?? '-' }} | {{ $ncp->employee->name ?? '' }}</div>
                <div style="font-size: 10px; color: #555; text-align: left;">
                </div>
                <div style="border-bottom: 1px solid #000; width: 80%; margin-top: 8px;"></div>
            </td>
                    
            <!-- Approved by (Kanan) -->
            <div style="flex: 1; text-align: right; padding-left: 20px;">
                <div style="font-weight: bold; font-size: 11px; margin-bottom: 4px; padding-right: 105px;">Approved by</div>
                <div style="border-bottom: 1px solid #000; width: 80%; margin-top: 28px; margin-left: auto;"></div>
            </div>
        </tr>
    </table>

    <!-- Footer -->
    <table style="width: 100%; margin-top: 10px; padding-top: 5px; font-size: 9px;">
        <tr>
            <td style="text-align: left; font-weight: bold; width: 50%;">QR-QAD-11-K020 (Rev.01)</td>
            <td style="text-align: right; font-weight: width: 50%;">Printed Date : {{ date('d/m/Y H:i') }} | Print Count : {{ $ncp->print_count }}</td>
        </tr>
    </table>
</body>
</html>