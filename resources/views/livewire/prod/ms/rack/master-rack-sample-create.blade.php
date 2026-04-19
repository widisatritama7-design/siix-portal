<div class="space-y-1 p-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            MS
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.ms.master-rack') }}" wire:navigate separator="slash">
            Master Rack Sample
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Create Rack
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Create Master Rack Sample
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Add new racks, columns, or sheets to existing rack
            </p>
        </div>

        <div class="flex gap-2">
            <flux:button variant="outline" icon="arrow-left" wire:click="back">
                Back to List
            </flux:button>
        </div>
    </div>

    <!-- Form Card -->
    <flux:card class="w-full">
        <form wire:submit="save" class="space-y-6">
            <!-- Mode Penambahan -->
            <div>
                <flux:label>Jenis Penambahan <span class="text-red-500">*</span></flux:label>
                <select 
                    wire:model.live="add_mode" 
                    class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700"
                >
                    <option value="rack">Tambah Rack Baru</option>
                    <option value="column">Tambah Column</option>
                    <option value="sheet">Tambah Sheet</option>
                </select>
                <flux:error name="add_mode" />
            </div>

            <!-- Type Rack -->
            <div>
                <flux:label>Type Rack <span class="text-red-500">*</span></flux:label>
                <flux:input 
                    wire:model.live="type_rack" 
                    placeholder="Masukkan Type Rack (contoh: A, B, C)"
                    class="w-full"
                />
                <p class="text-xs text-zinc-500 mt-1">Masukkan Type Rack (contoh: A, B, C)</p>
                <flux:error name="type_rack" />
            </div>

            <!-- Informasi Rack Existing -->
            @if($type_rack)
                <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                    <h4 class="font-semibold text-sm mb-2 text-zinc-700 dark:text-zinc-300">Informasi Rack Existing</h4>
                    <div class="text-sm text-zinc-600 dark:text-zinc-400 whitespace-pre-line">
                        {{ $rackSummary }}
                    </div>
                </div>

                <!-- Column yang Ada -->
                @if(!empty($existingColumns))
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                        <h4 class="font-semibold text-sm mb-2 text-zinc-700 dark:text-zinc-300">Column yang Ada</h4>
                        <div class="flex flex-wrap gap-2">
                            @foreach($existingColumns as $column)
                                <flux:badge size="sm" color="blue">Column {{ $column }}</flux:badge>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Sheet Existing per Column -->
                @if(!empty($existingSheets))
                    <div class="p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                        <h4 class="font-semibold text-sm mb-2 text-zinc-700 dark:text-zinc-300">Sheet Existing (per Column)</h4>
                        <div class="space-y-1 text-sm text-zinc-600 dark:text-zinc-400">
                            @foreach($existingSheets as $sheet)
                                <div>🧱 Column {{ $sheet['column'] }} → Sheet 1–{{ $sheet['max_sheet'] }} ({{ $sheet['total_sheets'] }} sheets)</div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif

            <!-- Tambah Column (Mode Rack & Column) -->
            @if(in_array($add_mode, ['rack', 'column']))
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg space-y-3">
                    <p class="text-sm text-blue-700 dark:text-blue-300 font-medium">
                        @if($add_mode === 'rack')
                            🔧 Buat Rack Baru dengan columns dan sheets
                        @else
                            📊 Tambah Column Baru ke Rack "{{ $type_rack ?: '(pilih type rack)' }}"
                        @endif
                    </p>
                    
                    <div>
                        <flux:label>Jumlah Column Baru</flux:label>
                        <flux:input 
                            wire:model="add_columns" 
                            type="number" 
                            min="1" 
                            max="100"
                        />
                        <p class="text-xs text-zinc-500 mt-1">Berapa column yang ingin ditambahkan</p>
                        <flux:error name="add_columns" />
                    </div>
                    
                    <div>
                        <flux:label>Sheet per Column</flux:label>
                        <flux:input 
                            wire:model="sheets_per_column" 
                            type="number" 
                            min="1" 
                            max="50"
                        />
                        <p class="text-xs text-zinc-500 mt-1">Jumlah sheet untuk setiap column</p>
                        <flux:error name="sheets_per_column" />
                    </div>
                    
                    <div class="text-xs text-blue-600 dark:text-blue-400 mt-2 font-semibold">
                        Total rack yang akan dibuat: {{ $add_columns * $sheets_per_column }}
                    </div>
                </div>
            @endif

            <!-- Tambah Sheet (Mode Sheet) -->
            @if($add_mode === 'sheet')
                <div class="p-4 bg-green-50 dark:bg-green-900/20 rounded-lg space-y-3">
                    <p class="text-sm text-green-700 dark:text-green-300 font-medium">
                        📄 Tambah Sheet Baru ke Rack "{{ $type_rack ?: '(pilih type rack)' }}"
                    </p>
                    
                    <div>
                        <flux:label>Pilih Column</flux:label>
                        <select 
                            wire:model="target_column" 
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-zinc-800 dark:border-zinc-700"
                        >
                            <option value="">Pilih Column</option>
                            @foreach($targetColumnOptions as $value => $label)
                                <option value="{{ $value }}">Column {{ $label }}</option>
                            @endforeach
                        </select>
                        <flux:error name="target_column" />
                    </div>
                    
                    <div>
                        <flux:label>Jumlah Sheet Baru</flux:label>
                        <flux:input 
                            wire:model="add_sheets" 
                            type="number" 
                            min="1" 
                            max="50"
                        />
                        <p class="text-xs text-zinc-500 mt-1">Sheet akan dilanjutkan dari sheet terakhir</p>
                        <flux:error name="add_sheets" />
                    </div>
                    
                    <div class="text-xs text-green-600 dark:text-green-400 mt-2 font-semibold">
                        Total sheet yang akan dibuat: {{ $add_sheets }}
                    </div>
                </div>
            @endif

            <!-- Preview Summary -->
            @if($type_rack)
                <div class="p-3 bg-zinc-100 dark:bg-zinc-800 rounded-lg">
                    <p class="text-sm font-medium mb-1">Ringkasan:</p>
                    <ul class="text-xs text-zinc-600 dark:text-zinc-400 space-y-1">
                        <li>• Type Rack: <span class="font-semibold">{{ $type_rack }}</span></li>
                        @if($add_mode === 'rack')
                            <li>• Mode: Buat rack baru dengan {{ $add_columns }} column(s) dan {{ $sheets_per_column }} sheet(s) per column</li>
                            <li>• Total: <span class="font-semibold text-blue-600">{{ $add_columns * $sheets_per_column }}</span> rack akan dibuat</li>
                        @elseif($add_mode === 'column')
                            <li>• Mode: Tambah {{ $add_columns }} column baru dengan {{ $sheets_per_column }} sheet(s) per column</li>
                            <li>• Total: <span class="font-semibold text-blue-600">{{ $add_columns * $sheets_per_column }}</span> rack akan dibuat</li>
                        @else
                            <li>• Mode: Tambah {{ $add_sheets }} sheet baru ke Column {{ $target_column }}</li>
                            <li>• Total: <span class="font-semibold text-blue-600">{{ $add_sheets }}</span> sheet akan dibuat</li>
                        @endif
                    </ul>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button variant="outline" wire:click="back">
                    Cancel
                </flux:button>
                <flux:button type="submit" variant="primary">
                    Create Racks
                </flux:button>
            </div>
        </form>
    </flux:card>

    <!-- Notifikasi -->
    <flux:toast />
</div>