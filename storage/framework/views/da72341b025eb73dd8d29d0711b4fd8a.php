<?php # [BlazeVersion]:{v3} ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Event Report</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            margin: 0;
            padding: 24px 28px;
            background: #ffffff;
        }

        /* ===== Header ===== */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-bottom: 2px solid #1e40af;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header h1 {
            font-size: 20px;
            margin: 0;
            color: #1e40af;
            letter-spacing: -0.3px;
        }
        .header .subtitle {
            font-size: 10px;
            color: #6b7280;
            margin-top: 3px;
        }
        .header .summary {
            text-align: right;
            font-size: 10px;
            color: #4b5563;
        }
        .header .summary strong {
            display: block;
            font-size: 16px;
            color: #1e40af;
        }

        /* ===== Filter bar ===== */
        .filters {
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            padding: 8px 12px;
            font-size: 10px;
            color: #374151;
            margin-bottom: 14px;
            line-height: 1.4;
        }
        .filters strong { 
            color: #1e40af; 
            margin-right: 5px; 
            vertical-align: middle; /* Kunci agar teks sejajar tengah */
            display: inline-block;
        }
        .filters .chip {
            display: inline-block;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 2px 8px;
            margin: 2px 4px 2px 0;
            font-size: 9px;
            vertical-align: middle; /* Kunci agar chip sejajar tengah */
            line-height: 1.2;
        }

        /* ===== Table ===== */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
        }
        thead th {
            background: #1e40af;
            color: #ffffff;
            padding: 8px 6px;
            text-align: left;
            font-size: 9.5px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.4px;
            white-space: nowrap;
        }
        tbody td {
            padding: 7px 6px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
            vertical-align: top;
            line-height: 1.4;
        }
        tbody tr:nth-child(even) td { background: #f9fafb; }
        .title-cell strong { color: #111827; }
        .empty-cell {
            text-align: center;
            padding: 28px !important;
            color: #9ca3af;
            font-style: italic;
        }

        /* ===== Badges ===== */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 10px;
            font-size: 8.5px;
            font-weight: 700;
            white-space: nowrap;
            letter-spacing: 0.2px;
        }
        .type-Abnormality      { background: #ffe4e6; color: #be123c; }
        .type-Project          { background: #dbeafe; color: #1d4ed8; }
        .type-DailyMeasurement { background: #ede9fe; color: #6d28d9; }
        .type-Repair           { background: #fef3c7; color: #b45309; }
        .type-Cleaning                 { background: #dcfce7; color: #166534; }
        .type-TicketingSupportRequest  { background: #e0f2fe; color: #0369a1; }
        .status-Open           { background: #fee2e2; color: #b91c1c; }
        .status-OnProgress     { background: #fef9c3; color: #a16207; }
        .status-Closed         { background: #dcfce7; color: #15803d; }

        /* ===== Files / thumbnails (DomPDF Compatible) ===== */
        .thumbs {
            font-size: 0; /* Menghilangkan spasi antar inline-block */
            line-height: 0;
        }
        .thumb {
            display: inline-block;
            width: 38px;
            height: 38px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            background: #f3f4f6;
            margin: 0 3px 3px 0; /* Jarak antar gambar */
            vertical-align: top;
        }
        .thumb-fallback {
            display: inline-block;
            width: 38px;
            height: 38px;
            border-radius: 5px;
            border: 1px solid #e5e7eb;
            background: #f3f4f6;
            margin: 0 3px 3px 0;
            vertical-align: top;
            text-align: center;
            line-height: 38px;
            font-size: 8px;
            color: #9ca3af;
        }
        .thumb-more {
            display: inline-block;
            width: 38px;
            height: 38px;
            border-radius: 5px;
            background: #1e40af;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            margin: 0 3px 3px 0; 
            vertical-align: top;
            text-align: center;
            line-height: 38px; /* Trik center vertikal DomPDF */
        }
        .file-doc {
            display: inline-block;
            padding: 2px 6px;
            background: #f3f4f6;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            font-size: 8px;
            color: #4b5563;
            margin: 0 2px 3px 0;
            max-width: 130px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            vertical-align: top;
        }
        .no-file { color: #9ca3af; font-size: 10px; }

        /* ===== Footer ===== */
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8.5px;
            color: #9ca3af;
            padding: 6px 0;
            border-top: 1px solid #e5e7eb;
            background: #ffffff;
        }
    </style>
</head>
<body>

    
    <div class="header">
        <div>
            <h1>ESD Event Report</h1>
            <div class="subtitle">Event Management &amp; Monitoring Summary</div>
        </div>
        <div class="summary">
            <strong><?php echo e($events->count()); ?></strong>
            event(s) &middot; <?php echo e($generatedAt); ?>

        </div>
    </div>

    
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search || $filterType || $filterStatus || $filterDateFrom || $filterDateTo): ?>
    <div class="filters">
        <strong>Active Filters:</strong>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($search): ?> <span class="chip">Search: "<?php echo e($search); ?>"</span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterType): ?> <span class="chip">Type: <?php echo e($filterType); ?></span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterStatus): ?> <span class="chip">Status: <?php echo e(['red'=>'Open','yellow'=>'On Progress','green'=>'Closed'][$filterStatus] ?? $filterStatus); ?></span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterDateFrom): ?> <span class="chip">From: <?php echo e($filterDateFrom); ?></span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($filterDateTo): ?> <span class="chip">To: <?php echo e($filterDateTo); ?></span> <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <table>
        <thead>
            <tr>
                <th style="width: 26px;">#</th>
                <th style="width: 22%;">Title</th>
                <th style="width: 11%;">Type</th>
                <th style="width: 10%;">Status</th>
                <th style="width: 13%;">Start</th>
                <th style="width: 13%;">End</th>
                <th style="width: 100px;">Files</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $events; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $event): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
            <?php
                $statusLabel = match($event->color) {
                    'red' => 'Open',
                    'yellow' => 'On Progress',
                    'green' => 'Closed',
                    default => 'Open',
                };
                $statusClass = 'status-' . str_replace(' ', '', $statusLabel);
                $typeClass = 'type-' . str_replace(' ', '', $event->type ?? 'Project');

                // Decode file (bisa array / json string)
                $fileAttr = $event->file;
                if (is_string($fileAttr)) {
                    $decoded = json_decode(stripslashes($fileAttr), true);
                    $files = is_array($decoded) ? $decoded : [];
                } elseif (is_array($fileAttr)) {
                    $files = $fileAttr;
                } else {
                    $files = [];
                }

                // Pisahkan gambar vs dokumen
                $images = [];
                $docs = [];
                foreach ($files as $f) {
                    if (preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $f)) {
                        $images[] = $f;
                    } else {
                        $docs[] = $f;
                    }
                }

                $maxThumbs = 3; // Batasi maksimal 3 gambar agar tidak memenuhi kolom
                $shownImages = array_slice($images, 0, $maxThumbs);
                $remainingImages = count($images) - count($shownImages);
                $fileCount = count($files); 
            ?>
            <tr>
                <td style="color:#9ca3af;"><?php echo e($i + 1); ?></td>
                <td class="title-cell"><strong><?php echo e($event->title); ?></strong></td>
                <td><span class="badge <?php echo e($typeClass); ?>"><?php echo e($event->type ?? '-'); ?></span></td>
                <td><span class="badge <?php echo e($statusClass); ?>"><?php echo e($statusLabel); ?></span></td>
                <td><?php echo e($event->start_at ? $event->start_at->format('d M Y H:i') : '-'); ?></td>
                <td><?php echo e($event->end_at ? $event->end_at->format('d M Y H:i') : '-'); ?></td>
                
                
                <td>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fileCount > 0): ?>
                        <div class="thumbs">
                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $shownImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                <?php
                                    // Gunakan public_path agar DomPDF bisa membaca gambar lokal
                                    $imgPath = public_path('storage/' . $img);
                                    $imgUrl = file_exists($imgPath) ? $imgPath : '';
                                ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($imgUrl): ?>
                                    <img src="<?php echo e($imgUrl); ?>" class="thumb" alt="attachment">
                                <?php else: ?>
                                    <div class="thumb-fallback">IMG</div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($remainingImages > 0): ?>
                                <div class="thumb-more">+<?php echo e($remainingImages); ?></div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($docs) > 0): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = array_slice($docs, 0, 1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $doc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                                    <span class="file-doc"><?php echo e(basename($doc)); ?></span>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(count($docs) > 1): ?>
                                    <span class="file-doc">+<?php echo e(count($docs) - 1); ?> doc</span>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php else: ?>
                        <span class="no-file">-</span>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </td>

                <td><?php echo e(\Illuminate\Support\Str::limit($event->description, 90) ?: '-'); ?></td>
            </tr>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
            <tr>
                <td colspan="8" class="empty-cell">No events found</td>
            </tr>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </tbody>
    </table>

    <div class="footer">ESD Control Panel — Event Management Report</div>
</body>
</html><?php /**PATH /www/wwwroot/test.siix-ems.co.id/siix-portal/resources/views/livewire/esd/activity/event-pdf.blade.php ENDPATH**/ ?>