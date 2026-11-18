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

    {{-- ===== Header ===== --}}
    <div class="header">
        <div>
            <h1>ESD Event Report</h1>
            <div class="subtitle">Event Management &amp; Monitoring Summary</div>
        </div>
        <div class="summary">
            <strong>{{ $events->count() }}</strong>
            event(s) &middot; {{ $generatedAt }}
        </div>
    </div>

    {{-- ===== Filters ===== --}}
    @if($search || $filterType || $filterStatus || $filterDateFrom || $filterDateTo)
    <div class="filters">
        <strong>Active Filters:</strong>
        @if($search) <span class="chip">Search: "{{ $search }}"</span> @endif
        @if($filterType) <span class="chip">Type: {{ $filterType }}</span> @endif
        @if($filterStatus) <span class="chip">Status: {{ ['red'=>'Open','yellow'=>'On Progress','green'=>'Closed'][$filterStatus] ?? $filterStatus }}</span> @endif
        @if($filterDateFrom) <span class="chip">From: {{ $filterDateFrom }}</span> @endif
        @if($filterDateTo) <span class="chip">To: {{ $filterDateTo }}</span> @endif
    </div>
    @endif

    {{-- ===== Table ===== --}}
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
            @forelse($events as $i => $event)
            @php
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
            @endphp
            <tr>
                <td style="color:#9ca3af;">{{ $i + 1 }}</td>
                <td class="title-cell"><strong>{{ $event->title }}</strong></td>
                <td><span class="badge {{ $typeClass }}">{{ $event->type ?? '-' }}</span></td>
                <td><span class="badge {{ $statusClass }}">{{ $statusLabel }}</span></td>
                <td>{{ $event->start_at ? $event->start_at->format('d M Y H:i') : '-' }}</td>
                <td>{{ $event->end_at ? $event->end_at->format('d M Y H:i') : '-' }}</td>
                
                {{-- ===== KOLOM FILES ===== --}}
                <td>
                    @if($fileCount > 0)
                        <div class="thumbs">
                            {{-- Render Gambar --}}
                            @foreach($shownImages as $img)
                                @php
                                    // Gunakan public_path agar DomPDF bisa membaca gambar lokal
                                    $imgPath = public_path('storage/' . $img);
                                    $imgUrl = file_exists($imgPath) ? $imgPath : '';
                                @endphp
                                @if($imgUrl)
                                    <img src="{{ $imgUrl }}" class="thumb" alt="attachment">
                                @else
                                    <div class="thumb-fallback">IMG</div>
                                @endif
                            @endforeach

                            {{-- Tombol +X (Sisa Gambar) --}}
                            @if($remainingImages > 0)
                                <div class="thumb-more">+{{ $remainingImages }}</div>
                            @endif

                            {{-- Render Dokumen (Maksimal 1 file doc yang ditampilkan) --}}
                            @if(count($docs) > 0)
                                @foreach(array_slice($docs, 0, 1) as $doc)
                                    <span class="file-doc">{{ basename($doc) }}</span>
                                @endforeach
                                @if(count($docs) > 1)
                                    <span class="file-doc">+{{ count($docs) - 1 }} doc</span>
                                @endif
                            @endif
                        </div>
                    @else
                        <span class="no-file">-</span>
                    @endif
                </td>

                <td>{{ \Illuminate\Support\Str::limit($event->description, 90) ?: '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="empty-cell">No events found</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">ESD Control Panel — Event Management Report</div>
</body>
</html>