<div class="p-1 space-y-2 overflow-x-auto">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            WIP
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Master WIP
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <style>
        /* Status Summary Cards - Compact Version */
        .status-card {
            border-radius: 12px;
            padding: 0.875rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
            min-width: 180px;
        }

        .status-card:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        /* Light mode */
        .status-card-open {
            background: linear-gradient(135deg, #fee2e2 0%, #fecaca 100%);
            border: 1px solid #f87171;
        }

        .status-card-progress {
            background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
            border: 1px solid #fbbf24;
        }

        .status-card-finished {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            border: 1px solid #4ade80;
        }

        /* Dark mode - lebih gelap dan tidak terlalu terang */
        .dark .status-card-open {
            background: linear-gradient(135deg, rgba(127, 29, 29, 0.4) 0%, rgba(153, 27, 27, 0.5) 100%);
            border: 1px solid rgba(248, 113, 113, 0.3);
        }

        .dark .status-card-progress {
            background: linear-gradient(135deg, rgba(113, 63, 18, 0.4) 0%, rgba(146, 64, 14, 0.5) 100%);
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .dark .status-card-finished {
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.4) 0%, rgba(4, 120, 87, 0.5) 100%);
            border: 1px solid rgba(74, 222, 128, 0.3);
        }

        .status-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Light mode icons */
        .status-icon-open {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .status-icon-progress {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .status-icon-finished {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        /* Dark mode icons - lebih gelap */
        .dark .status-icon-open {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.7) 0%, rgba(220, 38, 38, 0.8) 100%);
        }

        .dark .status-icon-progress {
            background: linear-gradient(135deg, rgba(245, 158, 11, 0.7) 0%, rgba(217, 119, 6, 0.8) 100%);
        }

        .dark .status-icon-finished {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.7) 0%, rgba(5, 150, 105, 0.8) 100%);
        }

        .status-icon svg {
            width: 20px;
            height: 20px;
            color: white;
        }

        .status-label {
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        /* Light mode label colors */
        .status-label-open {
            color: #991b1b;
        }

        .status-label-progress {
            color: #92400e;
        }

        .status-label-finished {
            color: #065f46;
        }

        /* Dark mode label colors - lebih soft */
        .dark .status-label-open {
            color: #fca5a5;
        }

        .dark .status-label-progress {
            color: #fcd34d;
        }

        .dark .status-label-finished {
            color: #86efac;
        }

        .status-value {
            font-size: 1.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-top: 0.125rem;
        }

        /* Light mode value colors */
        .status-value-open {
            color: #b91c1c;
        }

        .status-value-progress {
            color: #b45309;
        }

        .status-value-finished {
            color: #047857;
        }

        /* Dark mode value colors - lebih terang tapi tetap nyaman */
        .dark .status-value-open {
            color: #f87171;
        }

        .dark .status-value-progress {
            color: #fbbf24;
        }

        .dark .status-value-finished {
            color: #4ade80;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        .status-icon-progress svg {
            animation: spin 2s linear infinite;
        }

        /* Prevent wrapping on table */
        .wip-table-container {
            overflow-x: auto;
            white-space: nowrap;
        }
        
        .wip-table {
            min-width: 1200px;
            white-space: nowrap;
        }
        
        .wip-table td, 
        .wip-table th {
            white-space: nowrap;
        }
        
        .wip-table td:first-child,
        .wip-table th:first-child {
            white-space: normal;
            min-width: 150px;
        }
        
        .wip-table td:nth-child(4),
        .wip-table th:nth-child(4) {
            white-space: normal;
            min-width: 200px;
        }
    </style>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Master Transfer WIP
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage WIP production transfers and tracking
            </p>
        </div>

        <!-- Tombol Add WIP -->
        @can('create wip')
        <flux:button 
            variant="primary" 
            icon="plus" 
            size="sm"
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="resetForm"
            x-on:click="$dispatch('open-modal', 'wip-form-modal')"
        >
            New Transfer WIP
        </flux:button>
        @endcan
    </div>

    <!-- Status Summary Cards - 1 Baris dengan Horizontal Scroll di Mobile -->
    <div class="overflow-x-auto pb-2">
        <div class="grid grid-cols-3 gap-3 min-w-[600px] md:min-w-0">
            <!-- Open Card -->
            <div class="status-card status-card-open">
                <div>
                    <div class="status-label status-label-open">Open</div>
                    <div class="status-value status-value-open">{{ $statusCounts['Open'] ?? 0 }}</div>
                </div>
                <div class="status-icon status-icon-open">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- In Progress Card -->
            <div class="status-card status-card-progress">
                <div>
                    <div class="status-label status-label-progress">In Progress</div>
                    <div class="status-value status-value-progress">{{ $statusCounts['In Progress'] ?? 0 }}</div>
                </div>
                <div class="status-icon status-icon-progress">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </div>
            </div>

            <!-- Finished Card -->
            <div class="status-card status-card-finished">
                <div>
                    <div class="status-label status-label-finished">Finished</div>
                    <div class="status-value status-value-finished">{{ $statusCounts['Finished'] ?? 0 }}</div>
                </div>
                <div class="status-icon status-icon-finished">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <flux:card class="p-3">
        <div class="flex flex-wrap items-center gap-2">
            <!-- Search Input -->
            <div class="flex-1 min-w-[200px]">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search by model, part number, or PrdOrd..."
                    icon="magnifying-glass"
                    clearable
                    size="sm"
                />
            </div>

            <!-- Status Filter -->
            <div class="w-36">
                <select 
                    wire:model.live="status"
                    class="w-full px-2 py-1.5 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="">All Status</option>
                    <option value="Open">Open</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Finished">Finished</option>
                </select>
            </div>

            <!-- Date Filters -->
            <div class="flex items-center gap-1">
                <div class="w-32">
                    <flux:input
                        type="date"
                        wire:model.live="date_from"
                        placeholder="From"
                        size="sm"
                    />
                </div>
                <span class="text-zinc-400 text-sm">—</span>
                <div class="w-32">
                    <flux:input
                        type="date"
                        wire:model.live="date_to"
                        placeholder="To"
                        size="sm"
                    />
                </div>
            </div>

            <!-- Reset Button -->
            <flux:button 
                wire:click="resetFilters"
                variant="outline"
                icon="arrow-path"
                size="sm"
            >
                Reset
            </flux:button>
        </div>
    </flux:card>

    <!-- WIP Table with Horizontal Scroll -->
    <flux:card class="p-0 overflow-hidden h-full shadow-lg">
        <div class="wip-table-container overflow-x-auto">
            <table class="wip-table w-full text-sm">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-700">
                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Model / Part Number</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">PrdOrd</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Lot Qty</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Progress</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Total Scans</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Date</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">PIC</th>
                        <th class="px-3 py-2 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider sticky right-0 bg-zinc-50 dark:bg-zinc-800/50 shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.05)]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($wips as $wip)
                    @php
                        $lotQty = (int) ($wip->lot_qty ?? 0);
                        $acmQty = (int) ($wip->current_acm ?? 0);
                        $remainingQty = max($lotQty - $acmQty, 0);
                        $percentage = $lotQty > 0 ? (int) floor(($acmQty / $lotQty) * 100) : 0;
                        $currentStatus = $wip->getStatus();
                        $scansCount = (int) ($wip->scans_count ?? 0);
                        $canDelete = $scansCount === 0;
                    @endphp

                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="wip-{{ $wip->id }}">
                        <td class="px-3 py-2">
                            <div class="font-medium text-zinc-900 dark:text-white text-sm">{{ $wip->model }}</div>
                            <div class="text-xs text-zinc-500 dark:text-zinc-400">{{ $wip->part_number ?: '-' }}</div>
                        </td>
                        <td class="px-3 py-2 text-sm text-zinc-600 dark:text-zinc-300">
                            <code class="text-xs bg-zinc-100 dark:bg-zinc-800 px-1.5 py-0.5 rounded">{{ $wip->dj }}</code>
                        </td>
                        <td class="px-3 py-2 text-sm text-zinc-600 dark:text-zinc-300">{{ number_format($wip->lot_qty) }}</td>
                        <td class="px-3 py-2 min-w-[180px]">
                            <div>
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-xs font-medium text-zinc-500 uppercase tracking-wider">Progress</span>
                                    <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $percentage }}%</span>
                                </div>
                                <div class="w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-2 overflow-hidden">
                                    <div class="bg-blue-600 h-2 rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                                </div>
                                @if($acmQty > 0)
                                <div class="text-xs text-zinc-500 dark:text-zinc-400 mt-0.5">
                                    {{ number_format($acmQty) }} / {{ number_format($lotQty) }}
                                </div>
                                @endif
                            </div>
                        </td>
                        
                        <td class="px-3 py-2">
                            @if($currentStatus === 'Finished')
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-green-100 text-green-800 border border-green-200 dark:bg-green-900/30 dark:text-green-400">
                                    <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Finished
                                </span>
                            @elseif($currentStatus === 'Open')
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-red-100 text-red-800 border border-red-200 dark:bg-red-900/30 dark:text-red-400">
                                    <svg class="w-3 h-3 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Open
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200 dark:bg-yellow-900/30 dark:text-yellow-400">
                                    <svg class="w-3 h-3 mr-1 animate-spin flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    In Progress
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-3 py-2">
                            @if($scansCount > 0)
                            <div class="text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $scansCount }} scan{{ $scansCount !== 1 ? 's' : '' }}
                            </div>
                            @else
                            <span class="text-sm text-zinc-400">—</span>
                            @endif
                        </td>

                        <td class="px-3 py-2 text-xs text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                            {{ $wip->created_at ? $wip->created_at->format('d/m/Y H:i:s') : 'N/A' }}
                        </td>
                        
                        <td class="px-3 py-2">
                            <div class="flex items-center gap-1.5">
                                <div class="w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-medium text-blue-700 dark:text-blue-400">
                                        {{ substr($wip->creator->name ?? 'NA', 0, 1) }}
                                    </span>
                                </div>
                                <span class="text-xs text-zinc-700 dark:text-zinc-300">{{ $wip->creator->name ?? 'N/A' }}</span>
                            </div>
                        </td>
                        
                        <!-- Actions Column -->
                        <td class="px-3 py-2 sticky right-0 bg-white dark:bg-zinc-900 shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.05)]">
                            <div class="flex items-center justify-end gap-1">
                                <!-- View Button -->
                                @can('view wip')
                                <flux:button
                                    tag="a"
                                    href="{{ route('prod.wip.show', $wip->id) }}"
                                    size="xs"
                                    icon="eye"
                                    variant="primary"
                                    color="info"
                                    class="!p-1.5"
                                    title="View Details"
                                />
                                @endcan
                                
                                <!-- Scan Button -->
                                @if(!$wip->isFinished())
                                    <flux:button
                                        tag="a"
                                        href="{{ route('prod.wip.scan', $wip->id) }}"
                                        size="xs"
                                        icon="camera"
                                        variant="primary"
                                        color="green"
                                        class="!p-1.5"
                                        title="Scan"
                                    />
                                @endif

                                <!-- Edit Button -->
                                @can('edit wip')
                                    @if($currentStatus === 'Open')
                                    <flux:button 
                                        wire:click="edit({{ $wip->id }})" 
                                        x-on:click="$dispatch('open-modal', 'wip-form-modal')"
                                        size="xs"
                                        icon="pencil-square"
                                        variant="primary"
                                        color="yellow"
                                        class="!p-1.5"
                                        title="Edit WIP"
                                    />
                                    @endif
                                @endcan

                                <!-- Delete Button -->
                                @if($canDelete && auth()->user()->can('delete wip'))
                                <flux:button 
                                    wire:click="confirmDelete({{ $wip->id }})" 
                                    x-on:click="$dispatch('open-modal', 'delete-wip-modal')"
                                    size="xs"
                                    icon="trash"
                                    variant="primary"
                                    color="red"
                                    class="!p-1.5"
                                    title="Delete WIP"
                                />
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-16 h-16 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="document" class="w-8 h-8 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-base font-medium text-zinc-900 dark:text-white mb-0.5">
                                        No WIP records found
                                    </h3>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mb-3">
                                        {{ $search || $status || $date_from || $date_to ? 'No records match your filters. Try adjusting your search criteria.' : 'Get started by creating your first WIP record.' }}
                                    </p>
                                </div>
                                @if($search || $status || $date_from || $date_to)
                                    <flux:button wire:click="resetFilters" size="xs">
                                        Clear Filters
                                    </flux:button>
                                @else
                                    @can('create wip')
                                    <flux:button 
                                        variant="primary" 
                                        size="xs"
                                        wire:click="resetForm"
                                        x-on:click="$dispatch('open-modal', 'wip-form-modal')"
                                    >
                                        Create Your First WIP
                                    </flux:button>
                                    @endcan
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($wips->hasPages())
        <div class="p-3 border-t border-zinc-200 dark:border-zinc-700">
            {{ $wips->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM WIP -->
    <div x-data="{ 
        open: false, 
        searchModel: '',
        selectedModel: @entangle('model'),
        models: @js($availableModels->toArray())
    }" 
    x-show="open" 
    @open-modal.window="if ($event.detail === 'wip-form-modal') open = true; searchModel = '';"
    @close-modal.window="if ($event.detail === 'wip-form-modal') open = false"
    x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-lg">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save">
                        <!-- Model dengan Search -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Model <span class="text-red-500">*</span></label>
                            <div class="relative" x-data="{ 
                                showDropdown: false,
                                filteredModels: [],
                                init() {
                                    this.filteredModels = this.models;
                                },
                                filterModels() {
                                    if (!this.searchModel) {
                                        this.filteredModels = this.models;
                                    } else {
                                        this.filteredModels = this.models.filter(model => 
                                            model.model.toLowerCase().includes(this.searchModel.toLowerCase()) ||
                                            (model.customer && model.customer.toLowerCase().includes(this.searchModel.toLowerCase()))
                                        );
                                    }
                                },
                                selectModel(model) {
                                    this.searchModel = model.model + ' - ' + (model.customer || '');
                                    this.selectedModel = model.model;
                                    showDropdown = false;
                                    @this.set('model', model.model);
                                }
                            }">
                                <input type="text"
                                    x-model="searchModel"
                                    @focus="showDropdown = true; filterModels()"
                                    @click="showDropdown = true; filterModels()"
                                    @keyup="filterModels()"
                                    @click.outside="showDropdown = false"
                                    placeholder="Search model by name or customer..."
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    autocomplete="off">
                                
                                <!-- Dropdown -->
                                <div x-show="showDropdown && filteredModels.length > 0"
                                    x-cloak
                                    class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                    <template x-for="model in filteredModels" :key="model.model">
                                        <div @click="selectModel(model)"
                                            class="px-3 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer border-b border-zinc-100 dark:border-zinc-700 last:border-0">
                                            <div class="font-medium text-sm text-zinc-900 dark:text-white" x-text="model.model"></div>
                                            <div class="text-xs text-zinc-500 dark:text-zinc-400" x-text="model.customer || '-'"></div>
                                        </div>
                                    </template>
                                </div>
                                
                                <!-- No results -->
                                <div x-show="showDropdown && filteredModels.length === 0"
                                    x-cloak
                                    class="absolute z-50 w-full mt-1 bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-lg shadow-lg p-3 text-center text-sm text-zinc-500">
                                    No models found
                                </div>
                            </div>
                            <input type="hidden" wire:model="model">
                            @error('model') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Part Number (Auto-filled) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Part Number</label>
                            <input type="text" 
                                wire:model="part_number"
                                readonly
                                class="w-full px-3 py-2 border rounded-lg bg-zinc-50 dark:bg-zinc-800/50 dark:border-zinc-700 cursor-not-allowed">
                            <p class="text-xs text-zinc-500 mt-1">Auto-filled from selected model</p>
                        </div>

                        <!-- PrdOrd (DJ) -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">PrdOrd <span class="text-red-500">*</span></label>
                            <input type="text" 
                                wire:model="dj"
                                placeholder="Enter PrdOrd"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('dj') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Lot Qty -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Lot Quantity <span class="text-red-500">*</span></label>
                            <input type="number" 
                                wire:model="lot_qty"
                                placeholder="Enter lot quantity"
                                class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('lot_qty') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2 mt-6">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                {{ $wip_id ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE (Sama seperti sebelumnya) -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-wip-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-wip-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete WIP</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete WIP "{{ $wipToDelete?->dj }}"? This action cannot be undone.
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="open = false" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                        Cancel
                    </button>
                    <button wire:click="delete" 
                            @click="open = false"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition
         class="fixed bottom-4 right-4 z-50"
         :class="{
             'bg-green-500': type === 'success',
             'bg-red-500': type === 'error',
             'bg-yellow-500': type === 'warning'
         }"
         style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <span x-text="message"></span>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>