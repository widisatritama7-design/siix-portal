<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Ketidakhadiran Karyawan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            max-width: 1000px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #2563eb;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 20px;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 12px;
            color: #888;
            padding: 10px;
            border-top: 1px solid #eee;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 12px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f0f8ff;
            width: 30%;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .badge-info {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        /* Table wrapper for horizontal scroll */
        .table-wrapper {
            overflow-x: auto;
            margin-top: 15px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
            margin-top: 0;
        }
        .items-table th, .items-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
            white-space: nowrap;
        }
        .items-table th {
            background-color: #f0f8ff;
            text-align: center;
        }
        .items-table td {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }
        .btn:hover {
            background-color: #1e40af;
        }
        
        /* Legend Table Style - Single Column */
        .legend-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            border: 1px solid #e5e7eb;
        }
        .legend-table th {
            background-color: #f9fafb;
            padding: 10px;
            text-align: left;
            font-weight: 600;
            width: 80px;
        }
        .legend-table td {
            padding: 10px;
            border: 1px solid #e5e7eb;
        }
        .legend-title {
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            LAPORAN KETIDAKHADIRAN KARYAWAN
        </div>
        <div class="content">
            <p>Dear <strong>Admin & Team</strong>,</p>
            
            <p>Laporan ketidakhadiran karyawan telah dibuat dengan detail sebagai berikut:</p>
            
            <h3>Informasi Laporan</h3>
            <table>
                <tr>
                    <th>Tanggal</th>
                    <td><?php echo e($date); ?></td>
                </tr>
                <tr>
                    <th>Departemen</th>
                    <td><?php echo e($departmentString); ?></td>
                </tr>
                <tr>
                    <th>Dilaporkan Oleh</th>
                    <td><?php echo e($createdBy); ?></td>
                </tr>
                <tr>
                    <th>Waktu Laporan</th>
                    <td><?php echo e($createdAt); ?></td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        <span class="badge badge-info">Menunggu Persetujuan</span>
                    </td>
                </tr>
            </table>
            
            <h3>Detail Ketidakhadiran</h3>
            <div class="table-wrapper">
                <table class="items-table">
                    <thead>
                        <tr>
                            <th style="width: 50px;">No</th>
                            <th style="width: 100px;">NIK</th>
                            <th style="width: 150px;">Nama</th>
                            <th style="width: 120px;">Departemen</th>
                            <th style="width: 80px;">Group</th>
                            <th style="width: 80px;">Line</th>
                            <th style="width: 200px;">Jenis Ketidakhadiran</th>
                            <th style="min-width: 150px;">Keterangan</th>
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
            </div>
            
            <div class="legend-title">*) Jenis Ketidakhadiran :</div>
            <table class="legend-table">
                <tr>
                    <th style="text-align: center;">SD</th>
                    <td>Sakit Dengan Surat Dokter</td>
                </tr>
                <tr>
                    <th style="text-align: center;">IJ</th>
                    <td>Izin Pribadi</td>
                </tr>
                <tr>
                    <th style="text-align: center;">A</th>
                    <td>Tidak Hadir Tanpa Keterangan</td>
                </tr>
                <tr>
                    <th style="text-align: center;">CT</th>
                    <td>Cuti Tahunan</td>
                </tr>
                <tr>
                    <th style="text-align: center;">CK</th>
                    <td>Cuti Keguguran</td>
                </tr>
                <tr>
                    <th style="text-align: center;">CM</th>
                    <td>Cuti Melahirkan</td>
                </tr>
            </table>
            
            <p>Anda dapat melihat detail lengkap laporan melalui link dibawah ini:</p>
            <p>
                <a href="<?php echo e($reportUrl ?? '#'); ?>" class="btn">
                    Lihat Detail Laporan
                </a>
            </p>
            <p>Mohon untuk segera dilakukan pengecekan dan verifikasi.</p>
            
            <p>Terima kasih,</p>
            <p>Best Regards,<br>Web Portal SIIX EMS Indonesia</p>
        </div>
        <div class="footer">
            <p>This is an automated notification from SIIX Absence Report System.</p>
            <p>&copy; <?php echo e(date('Y')); ?> SIIX - All rights reserved.</p>
        </div>
    </div>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/emails/prod/absence-report.blade.php ENDPATH**/ ?>