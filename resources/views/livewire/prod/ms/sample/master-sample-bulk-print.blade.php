<div class="print-header">
    <button onclick="history.back()" class="btn-back">
        ⬅ Back
    </button>

    <button onclick="window.print()" class="btn-print">
        🖨️ Print Now
    </button>
</div>



<div id="print-area">
    @php
        $recordsArray = $records->all();
        $chunks = array_chunk($recordsArray, 3);
    @endphp

    @foreach($chunks as $rowRecords)
        <div class="page-row">
            @foreach($rowRecords as $record)

                @php
                    $samples = [];

                    // NG
                    if($record->sample_ng) {
                        $ngValue = strtoupper(preg_replace('/[^A-Z0-9\-]/', '', trim($record->sample_ng)));
                        $samples[] = [
                            'type' => 'NG',
                            'value' => $ngValue,
                            'color' => 'red',
                            'special_hole' => false,
                        ];

                        // Blank → copy dari NG
                        if($record->sample_blank) {
                            $samples[] = [
                                'type' => 'Blank',
                                'value' => $ngValue,
                                'color' => 'red',
                                'special_hole' => true, // hole hitam
                            ];
                        }
                    }

                    // OK
                    if($record->sample_ok) {
                        $okValue = strtoupper(preg_replace('/[^A-Z0-9\-]/', '', trim($record->sample_ok)));
                        $samples[] = [
                            'type' => 'OK',
                            'value' => $okValue,
                            'color' => 'green',
                            'special_hole' => false,
                        ];

                        // OK Backup → copy dari OK
                        if($record->sample_ok_backup) {
                            $samples[] = [
                                'type' => 'OK Backup',
                                'value' => $okValue,
                                'color' => 'green',
                                'special_hole' => true, // hole hitam
                            ];
                        }
                    }
                @endphp

                <div class="tag-column">
                    @foreach($samples as $sample)
                        <div class="tag-row {{ $sample['color'] }}">
                            <div class="label-left">
                                <div class="hole {{ $sample['special_hole'] ? 'special-hole' : '' }}"></div>
                                <div class="label-text">
                                    <div class="label-model">{{ $record->model_name }}</div>
                                    <div class="label-sample">{{ $sample['value'] }}</div>
                                </div>
                            </div>
                            <div class="qr-wrapper">
                                {!! DNS2D::getBarcodeHTML($sample['value'] . ' - ' . $record->model_name, 'QRCODE', 2, 2) !!}
                            </div>
                        </div>
                    @endforeach
                </div>

            @endforeach
        </div>
    @endforeach
</div>

<style>
    #print-area {
        padding: 6mm;
        font-family: Arial, Helvetica, sans-serif;
    }

    /* 3 KOLUMN PER BARIS */
    .page-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1px;
        page-break-inside: avoid;
    }
    .tag-column {
        width: 32%;
    }

    /* TAG ROW BORDER SATU & CENTER */
    .tag-row {
        display: flex;
        align-items: center; /* center vertikal */
        justify-content: space-between;
        margin-bottom: 12px;

        border: 2px solid #000;
        box-sizing: border-box;
        background: #fff;
        
    }

    .tag-row.red { background: #fa0202; }
    .tag-row.green { background: #30c20c; }
    .tag-row.green .label-text {
        color: #fff;
    }
    .tag-row.red .label-text {
        color: #fff;
    }

    /* LABEL + HOLE */
    .label-left {
        display: flex;
        align-items: center; /* center vertikal hole + text */
        padding-left: 12px;
        flex: 1;
    }

    /* HOLE */
    .hole {
        width: 20px;
        height: 20px;
        background: #fff;
        border: 2px solid #000;
        border-radius: 50%;
        margin-right: 5px;
    }

    /* HOLE SPESIAL (Backup / Blank) */
    .hole.special-hole {
        background: #000; /* hitam */
    }

    /* LABEL TEXT */
    .label-text {
        text-align: center;
        flex: 1;
    }
    .label-model {
        font-size: 12px;
        font-weight: bold;
        line-height: 1.1;
    }
    .label-sample {
        font-size: 12px;
        font-weight: bold;
        margin-top: 1px;
    }

    /* QR */
    .qr-wrapper {
        border-left: 2px solid #000;
        width: 1.5cm;
        height: 1.5cm;
        background: #fff;
        padding: 0.5mm;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .qr-wrapper svg {
        display: block;
        margin: auto;
    }

    .print-header {
        display: flex;
        justify-content: center;   /* TENGAH HORIZONTAL */
        margin-bottom: 12px;
    }

    .print-header {
        display: flex;
        justify-content: center;   /* tengah */
        gap: 10px;                 /* jarak antar tombol */
        margin-bottom: 12px;
    }

    /* BACK */
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

    .btn-back:hover {
        background: #555;
    }

    /* PRINT */
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

    .btn-print:hover {
        background: #000;
    }

    /* PRINT MODE */
    @media print {
        @page { size: A4; margin: 8mm; }
        body * { visibility: hidden; }
        #print-area, #print-area * { visibility: visible; }
        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .print-header {
            display: none !important;
        }
    }
</style>
