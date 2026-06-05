<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Ketidakhadiran Karyawan</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 10px;
            margin: 15px;
            position: relative;
            min-height: 100vh;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h2 {
            margin: 0;
            padding: 0;
            font-size: 16px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 15px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px;
            vertical-align: top;
        }
        .info-table td:first-child {
            width: 120px;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9px;
        }
        .data-table th, .data-table td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }
        .data-table th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }
        .signature {
            width: 100%;
            margin-top: 30px;
            margin-bottom: 30px;
            border-collapse: collapse;
        }
        .signature td {
            text-align: center;
            vertical-align: top;
            padding: 0 5px;
        }
        .signature .label {
            font-weight: normal;
            margin-bottom: 15px;
        }
        .signature .signature-name {
            font-weight: bold;
            font-size: 10px;
            margin: 8px 0 5px 0;
        }
        .signature .signature-line {
            border-bottom: 1px solid #000;
            width: 80%;
            margin: 0 auto;
        }
        .signature .signature-position {
            font-size: 9px;
            margin-top: 5px;
            font-weight: normal;
        }
        .footer-legend {
            margin-top: 20px;
            font-size: 8px;
            border-top: 1px solid #ccc;
            padding-top: 8px;
        }
        .legend-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 5px;
            font-size: 8px;
        }
        .legend-table td {
            padding: 2px;
            vertical-align: top;
        }
        .note {
            margin-top: 15px;
            font-size: 8px;
            font-style: italic;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .bold {
            font-weight: bold;
        }
        hr {
            margin: 8px 0;
        }
        .footer {
            position: absolute;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8px;
        }
        .content-wrapper {
            min-height: calc(100vh - 50px);
            padding-bottom: 30px;
        }
        .signature .signature-datetime {
            font-size: 8px;
            color: #888;
            margin: 2px 0 8px 0;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="header">
            <h2>LAPORAN KETIDAKHADIRAN KARYAWAN</h2>
            <hr>
        </div>

        <table class="info-table">
            <tr>
                <td>Tanggal</td>
                <td>: <?php echo e($date); ?></td>
                <td style="width: 150px;"></td>
                <td style="width: 100px;"></td>
            </tr>
            <tr>
                <td>Departemen</td>
                <td colspan="3">: <?php echo e($departmentString); ?></td>
            </tr>
        </table>

        <table class="data-table">
            <thead>
                <tr>
                    <th style="width: 20px;">No</th>
                    <th style="width: 40px;">NIK</th>
                    <th style="width: 130px;">Nama</th>
                    <th style="width: 100px;">Departement</th>
                    <th style="width: 60px;">Group</th>
                    <th style="width: 60px;">Line</th>
                    <th style="width: 180px;">Jenis Ketidakhadiran *)</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <tr>
                    <td class="text-center"><?php echo e($row['no']); ?></td>
                    <td><?php echo e($row['nik']); ?></td>
                    <td><?php echo e($row['nama']); ?></td>
                    <td><?php echo e($row['department']); ?></td>
                    <td><?php echo e($row['group']); ?></td>
                    <td><?php echo e($row['line']); ?></td>
                    <td><?php echo e($row['jenis_display']); ?></td>
                    <td><?php echo e($row['keterangan']); ?></td>
                </tr>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data</td>
                </tr>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </tbody>
        </table>

        <!-- TANDA TANGAN - DIPERBAIKI -->
        <table class="signature">
            <tr>
                <td style="width: 25%;">
                    <div class="label">Dilaporkan,</div>
                    <div class="signature-name"><?php echo e($createdBy); ?></div>
                    <div class="signature-datetime"><?php echo e($createdAt); ?></div>
                    <div class="signature-line"></div>
                    <div class="signature-position">Leader</div>
                </td>
                <td style="width: 25%;">
                    <div class="label">Diperiksa,</div>
                    <div class="signature-name"><?php echo e($checkedBy); ?></div>
                    <div class="signature-datetime"><?php echo e($checkedAt); ?></div>
                    <div class="signature-line"></div>
                    <div class="signature-position">Supervisor</div>
                </td>
                <td style="width: 25%;">
                    <div class="label">Disetujui,</div>
                    <div class="signature-name"><?php echo e($approvedBy); ?></div>
                    <div class="signature-datetime"><?php echo e($approvedAt); ?></div>
                    <div class="signature-line"></div>
                    <div class="signature-position">Manager</div>
                </td>
                <td style="width: 25%;">
                    <div class="label">Diterima,</div>
                    <div class="signature-name"><?php echo e($receivedBy); ?></div>
                    <div class="signature-datetime"><?php echo e($receivedAt); ?></div>
                    <div class="signature-line"></div>
                    <div class="signature-position">Admin</div>
                </td>
            </tr>
        </table>

        <div class="footer-legend">
            <div class="bold">*) Jenis Ketidakhadiran :</div>
            <table class="legend-table">
                <tr>
                    <td style="width: 250px;">SD : Sakit Dengan Surat Dokter</td>
                    <td style="width: 250px;">CT : Cuti Tahunan</td>
                </tr>
                <tr>
                    <td>IJ : Izin Pribadi</td>
                    <td>CK : Cuti Keguguran</td>
                </tr>
                <tr>
                    <td>A : Tidak Hadir Tanpa Keterangan</td>
                    <td>CM : Cuti Melahirkan</td>
                </tr>
            </table>
        </div>

        <div class="note">
            <strong>Note :</strong> Formulir ini harus dilaporkan ke ADMIN setiap hari kerja jam 08:30 (Dilampirkan Absent terkait)
        </div>
    </div>

    <div class="footer">
        QR-ADM-13-K002 (Rev.01)
    </div>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/prod/absence/absence-report.blade.php ENDPATH**/ ?>