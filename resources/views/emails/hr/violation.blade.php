<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Violation Notification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.5;
            color: #333;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 100%;
            margin: 0;
            padding: 20px;
            background: #ffffff;
            border: none;
            box-shadow: none;
        }
        .header {
            text-align: center;
            font-size: 20px;
            font-weight: bold;
            color: #842029;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #dc3545;
        }
        .greeting {
            margin-bottom: 15px;
        }
        .greeting strong {
            color: #842029;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 12px;
        }
        th {
            background: #dc3545;
            color: #fff;
        }
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: bold;
            text-align: center;
        }
        .badge-red {
            background: #dc3545;
            color: white;
        }
        .badge-orange {
            background: #fd7e14;
            color: white;
        }
        .badge-yellow {
            background: #ffc107;
            color: #333;
        }
        .badge-blue {
            background: #0d6efd;
            color: white;
        }
        .badge-green {
            background: #198754;
            color: white;
        }
        .stats-section {
            margin-top: 25px;
            padding: 0;
            background: transparent;
            border: none;
        }
        .stats-title {
            font-size: 16px;
            font-weight: bold;
            color: #495057;
            margin-bottom: 15px;
            padding-bottom: 8px;
            border-bottom: 2px solid #dc3545;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .info-box {
            margin-bottom: 15px;
            padding: 12px 15px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .signature {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            font-size: 12px;
            font-weight: bold;
        }
        .company-info {
            font-size: 11px;
            color: #555;
            margin-top: 8px;
        }
        .footer {
            margin-top: 20px;
            font-size: 11px;
            color: #777;
            text-align: center;
            border-top: 1px solid #dee2e6;
            padding-top: 15px;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header">
        ⚠️ VIOLATION NOTIFICATION
    </div>

    <div class="greeting">
        Dear Mr/Mrs.
        <strong>{{ $is_named ? $receiver_name : 'Good Day' }}</strong>,
    </div>

    <p>Hereby we share an employee violation report as below:</p>

    {{-- Main Violation Table --}}
    <table>
        <thead>
            <tr>
                <th>NIK</th>
                <th>Name</th>
                <th>Dept</th>
                <th>Shift</th>
                <th>Category</th>
                <th>Plat No</th>
                <th>Security</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $violation->employee?->nik ?? $violation->nik }}</td>
                <td>{{ $violation->employee?->name ?? $violation->name }}</td>
                <td>{{ $violation->dept ?? '-' }}</td>
                <td>{{ match($violation->shift) {
                    'NS' => 'Non Shift',
                    '1' => 'Shift 1',
                    '2' => 'Shift 2',
                    '3' => 'Shift 3',
                    default => $violation->shift ?? '-',
                } }}</td>
                <td>{{ $violation->category ?? '-' }}</td>
                <td>{{ $violation->plat_motor ?? '-' }}</td>
                <td>{{ strtoupper($violation->security_name ?? '-') }}</td>
                <td>{{ strtoupper($violation->alasan ?? '-') }}</td>
            </tr>
        </tbody>
    </table>

    {{-- Sub Category Table --}}
    @if(!empty($violation->sub_category) && is_array($violation->sub_category))
        <p><strong>📋 DETAIL CATEGORIES:</strong></p>
        <table>
            <thead>
                <tr>
                    <th style="width: 10%">No</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach($violation->sub_category as $index => $sub)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $sub }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Remarks Table --}}
    @if(!empty($violation->remarks))
        <p><strong>📝 REMARKS:</strong></p>
        <table>
            <thead>
                <tr><th>Remarks</th></tr>
            </thead>
            <tbody>
                @php
                    $remarksArray = is_array($violation->remarks) ? $violation->remarks : explode("\n", $violation->remarks);
                @endphp
                @foreach($remarksArray as $remark)
                    @if(!empty(trim($remark)))
                    <tr><td>{{ strtoupper(trim($remark)) }}</td></tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- STATISTICS SECTION --}}
    <div class="stats-section">
        <div class="stats-title">
            📊 RIWAYAT PELANGGARAN KARYAWAN (30 HARI TERAKHIR)
        </div>

        {{-- Employee Call Info --}}
        <div class="info-box">
            <div>
                <strong>Total Employee Call:</strong>
                <span class="badge {{ $stats['employee_call_count'] > 0 ? 'badge-yellow' : 'badge-green' }}">
                    {{ $stats['employee_call_count'] > 0 ? 'Sudah mendapat Panggilan dari HR (' . $stats['employee_call_count'] . ' kali)' : 'Belum mendapat Panggilan dari HR' }}
                </span>
            </div>
        </div>

        {{-- Last Violation Date --}}
        <div class="info-box">
            <div>
                <strong>Terakhir pelanggaran:</strong> {{ $stats['last_violation_date'] }}
            </div>
        </div>

        {{-- Summary Table --}}
        @if(!empty($stats['sub_category_counts']))
            <p><strong>📊 RINGKASAN PELANGGARAN:</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Kategori</th>
                        <th>Jenis Pelanggaran</th>
                        <th>Terakhir</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $groupedByMainCategory = [];
                        $oneMonthAgo = \Carbon\Carbon::now()->subMonth();
                        $recentViolations = \App\Models\HR\ViolationEmployee::where('nik', $violation->employee?->id)
                            ->where('created_at', '>=', $oneMonthAgo)
                            ->get();
                        
                        foreach ($recentViolations as $viol) {
                            if ($viol->sub_category) {
                                $subCategories = is_array($viol->sub_category) 
                                    ? $viol->sub_category 
                                    : json_decode($viol->sub_category, true) ?? [];
                                
                                $mainCategory = $viol->category ?? 'Lainnya';
                                
                                if (!isset($groupedByMainCategory[$mainCategory])) {
                                    $groupedByMainCategory[$mainCategory] = [];
                                }
                                
                                foreach ($subCategories as $subCat) {
                                    $found = false;
                                    foreach ($groupedByMainCategory[$mainCategory] as &$item) {
                                        if ($item['name'] === $subCat) {
                                            $item['count']++;
                                            if ($viol->created_at > $item['last_date_object']) {
                                                $item['last_date'] = $viol->created_at->format('d/m/Y H:i');
                                                $item['last_date_object'] = $viol->created_at;
                                            }
                                            $found = true;
                                            break;
                                        }
                                    }
                                    
                                    if (!$found) {
                                        $groupedByMainCategory[$mainCategory][] = [
                                            'name' => $subCat,
                                            'count' => 1,
                                            'last_date' => $viol->created_at->format('d/m/Y H:i'),
                                            'last_date_object' => $viol->created_at
                                        ];
                                    }
                                }
                            }
                        }
                    @endphp
                    
                    @foreach($groupedByMainCategory as $mainCategory => $items)
                        @foreach($items as $index => $item)
                            <tr>
                                @if($index === 0)
                                    <td rowspan="{{ count($items) }}" style="vertical-align: top; font-weight: bold; background: #f8f9fa;">
                                        {{ $mainCategory }}
                                    </td>
                                @endif
                                <td>{{ $item['name'] }}</td>
                                <td class="text-center">{{ $item['last_date'] }}</td>
                                <td class="text-center">
                                    <span class="badge {{ 
                                        $item['count'] >= 5 ? 'badge-red' : 
                                        ($item['count'] >= 3 ? 'badge-orange' : 'badge-blue') 
                                    }}">
                                        {{ $item['count'] }}x
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                    <tr style="background: #e9ecef; font-weight: bold;">
                        <td colspan="3" class="text-center">Total Pelanggaran:</td>
                        <td class="text-center">
                            <span class="badge badge-red" style="font-size: 13px; padding: 4px 12px;">
                                {{ $stats['total_monthly_violations'] }}x
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        @else
            <div style="padding: 15px; background: #d1e7dd; border: 1px solid #badbcc; border-radius: 4px; color: #0f5132;">
                ✅ Tidak ada pelanggaran dalam 30 hari terakhir
            </div>
        @endif
    </div>

    <div class="signature">
        Best Regards,<br>
        <strong>Admin Dept.</strong>
    </div>

    <div class="company-info">
        <strong>PT. SIIX EMS INDONESIA</strong><br>
        Jl. Maligi VIII Lot S-4, Kawasan Industri KIIC<br>
        Teluk Jambe Barat, Karawang (41361)
    </div>

    <div class="footer">
        This email was sent automatically, please do not reply to this email.<br>
        <small>Generated on {{ now()->format('d F Y H:i:s') }}</small>
    </div>

</div>
</body>
</html>