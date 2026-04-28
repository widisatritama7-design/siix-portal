<section class="w-full" x-data="{ 
    showUpdateModal: false,
    isSaving: false,
    status: @entangle('status'),
    line_name: @entangle('line_name'),
    nik: @entangle('nik'),
    input_count_stencil: @entangle('input_count_stencil'),
    register_no: @entangle('register_no'),
    employees: {{ json_encode($employees->toArray()) }},
    lineOptions: {{ json_encode($lineOptions->toArray()) }},
    searchEmployee: '',
    searchLine: '',
    showEmployeeDropdown: false,
    showLineDropdown: false
}">

    <flux:heading class="sr-only">
        {{ __('MTC - Stencil Management') }}
    </flux:heading>

    <x-mtc.layout class="!max-w-full !px-0 !mx-0">
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        MTC
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Stencil Management
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Stencil Management
                </h1>
                <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Manage stencil inventory and status
                </p>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Search Filter Section -->
            <div class="mb-4">
                <div class="flex justify-between items-center gap-4">
                    <div class="flex-1">
                        <flux:input
                            wire:model.live.debounce.300ms="search"
                            placeholder="Search by Register No, Customer, Rack..."
                            icon="magnifying-glass"
                            clearable
                            class="w-full"
                        />
                    </div>
                    
                    <div class="flex gap-2">
                        @if($search || $selectedStatus || $selectedCustomer)
                        <flux:button wire:click="resetFilters" variant="ghost" size="sm">
                            Clear All Filters
                        </flux:button>
                        @endif
                    </div>
                </div>
            </div>

        <!-- Tabs Navigation -->
        <div class="mt-6 mb-6 border-b border-zinc-200 dark:border-zinc-700">
            <!-- Scrollable Tabs Container - Hidden scrollbar -->
            <div class="relative">
                <div class="overflow-x-auto scrollbar-hide">
                    <div class="flex flex-nowrap gap-1 min-w-max">
                        <button wire:click="setTab('in_use_with_line')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'in_use_with_line' ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd" d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" clip-rule="evenodd" />
                                <path d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z" />
                            </svg>
                            Use In Line
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'in_use_with_line' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['in_use_with_line'] ?? 0 }}
                            </span>
                            @if($activeTab === 'in_use_with_line') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-emerald-600 dark:bg-emerald-400 rounded-t-full"></div> @endif
                        </button>

                        <button wire:click="setTab('in_use')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'in_use' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            In Use
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'in_use' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['in_use'] ?? 0 }}
                            </span>
                            @if($activeTab === 'in_use') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-green-600 dark:bg-green-400 rounded-t-full"></div> @endif
                        </button>

                        <button wire:click="setTab('prepared')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'prepared' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Prepared
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'prepared' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['prepared'] ?? 0 }}
                            </span>
                            @if($activeTab === 'prepared') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div> @endif
                        </button>

                        <button wire:click="setTab('cleaning')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'cleaning' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 8H9L8 4z"></path>
                            </svg>
                            Cleaning
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'cleaning' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['cleaning'] ?? 0 }}
                            </span>
                            @if($activeTab === 'cleaning') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600 dark:bg-red-400 rounded-t-full"></div> @endif
                        </button>

                        <button wire:click="setTab('stand_by')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'stand_by' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Stand By
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'stand_by' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['stand_by'] ?? 0 }}
                            </span>
                            @if($activeTab === 'stand_by') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-yellow-600 dark:bg-yellow-400 rounded-t-full"></div> @endif
                        </button>

                        <button wire:click="setTab('disposed')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'disposed' ? 'text-gray-600 dark:text-gray-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Disposed
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'disposed' ? 'bg-gray-200 text-gray-800 dark:bg-gray-800 dark:text-gray-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['disposed'] ?? 0 }}
                            </span>
                            @if($activeTab === 'disposed') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-gray-600 dark:bg-gray-400 rounded-t-full"></div> @endif
                        </button>

                        <button wire:click="setTab('all')" class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative whitespace-nowrap {{ $activeTab === 'all' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}">
                            <svg class="inline w-4 h-4 mr-1.5 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                            </svg>
                            All
                            <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $activeTab === 'all' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                                {{ $tabCounts['all'] ?? 0 }}
                            </span>
                            @if($activeTab === 'all') <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div> @endif
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add this CSS to your stylesheet or in a <style> tag -->
        <style>
            /* Hide scrollbar for Chrome, Safari and Opera */
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            
            /* Hide scrollbar for IE, Edge and Firefox */
            .scrollbar-hide {
                -ms-overflow-style: none;  /* IE and Edge */
                scrollbar-width: none;  /* Firefox */
            }
        </style>

            <!-- Stencil Table -->
            <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 w-full">
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Register No</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Customer</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Rack Number</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Line Name</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Count</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Update</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Update By</th>
                                <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                            @forelse($stencils as $stencil)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-4 py-3">
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white">
                                        {{ $stencil->register_no }}
                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->customer ?? '-' }}
                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->rack_number ?? '-' }}
                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $this->getStatusColorClass($stencil->status) }}">
                                        {{ $stencil->status }}
                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->line_name ?? '-' }}
                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->count_stencil ?? '-' }}
                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->updated_at ? $stencil->updated_at->format('d/m/Y H:i') : '-' }}
                                    </span>
                                
    
                                <td class="px-4 py-3">
                                    <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                        {{ $stencil->employee->name ?? '-' }}
                                    </span>
                                
    
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                        <flux:button 
                                            wire:click="viewActivity({{ $stencil->id }})"
                                            size="sm"
                                            icon="document-text"
                                            variant="primary"
                                            color="purple"
                                            class="!p-2 flex-shrink-0"
                                            title="View activity log"
                                        />
                                        @can('edit stencil')
                                        <flux:button 
                                            wire:click="updateStatus({{ $stencil->id }})"
                                            @click="showUpdateModal = true"
                                            size="sm"
                                            icon="pencil-square"
                                            variant="primary"
                                            color="yellow"
                                            class="!p-2 flex-shrink-0"
                                            title="Update status"
                                        />
                                        @endcan
                                    </div>
                                
    
                             </tr>
                            @empty
                             <tr>
                                <td colspan="9" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                            <flux:icon name="document-magnifying-glass" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                                No stencil records found
                                            </h3>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                {{ $search || $selectedStatus || $selectedCustomer ? 'Try adjusting your search or filter' : 'No data available' }}
                                            </p>
                                        </div>
                                    </div>
                                
 
                             </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($stencils->hasPages())
                <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $stencils->links() }}
                </div>
                @endif
            </flux:card>
        </div>
    </x-mtc.layout>

    <!-- Update Status Modal -->
    <div x-show="showUpdateModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm" @click="showUpdateModal = false"></div>
        <div class="flex min-h-full items-center justify-center p-4">
            <div class="relative bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl" @click.stop>
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-800 dark:to-blue-900 rounded-t-2xl px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-xl">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white">Update Status & NIK</h3>
                                <p class="text-xs text-blue-100 mt-0.5">Update stencil information</p>
                            </div>
                        </div>
                        <button @click="showUpdateModal = false" class="text-white/80 hover:text-white transition-colors duration-200 p-1 rounded-lg hover:bg-white/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6">
                    <div class="space-y-5">
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-xl p-4 border border-gray-200 dark:border-zinc-700">
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Register Number</label>
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                </svg>
                                <input type="text" x-model="register_no" readonly class="flex-1 rounded-lg border-gray-200 dark:border-zinc-600 bg-white dark:bg-zinc-800 px-3 py-2 text-sm font-mono font-semibold cursor-not-allowed">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">Status <span class="text-red-500">*</span></label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="In Use" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-green-500 peer-checked:bg-green-50 dark:peer-checked:bg-green-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">In Use</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="Prepared" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-blue-500 peer-checked:bg-blue-50 dark:peer-checked:bg-blue-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Prepared</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="Cleaning" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-red-500 peer-checked:bg-red-50 dark:peer-checked:bg-red-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 8H9L8 4z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Cleaning</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="Stand By" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-yellow-500 peer-checked:bg-yellow-50 dark:peer-checked:bg-yellow-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Stand By</span>
                                        </div>
                                    </div>
                                </label>
                                <label class="relative flex cursor-pointer">
                                    <input type="radio" x-model="status" value="Disposed" @change="$wire.set('status', status)" class="peer sr-only">
                                    <div class="w-full p-3 rounded-lg border-2 transition-all duration-200 peer-checked:border-gray-500 peer-checked:bg-gray-50 dark:peer-checked:bg-gray-900/20 border-gray-200 dark:border-zinc-700 bg-white dark:bg-zinc-800 hover:shadow-md">
                                        <div class="flex items-center justify-center gap-2">
                                            <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm font-medium">Disposed</span>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('status') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div x-show="['In Use', 'Prepared'].includes(status)" x-cloak>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Line Name <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                        </svg>
                                    </div>
                                    <input type="text" x-model="searchLine" @input="showLineDropdown = searchLine.trim().length > 0" @focus="showLineDropdown = true" :placeholder="line_name ? line_name : 'Select or search line...'" class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div x-show="showLineDropdown" @click.outside="showLineDropdown = false" class="absolute z-50 w-full mt-2 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-lg max-h-60 overflow-y-auto" style="display: none;">
                                    <template x-for="(label, value) in lineOptions" :key="value">
                                        <div x-show="label.toLowerCase().includes(searchLine.toLowerCase()) || value.toLowerCase().includes(searchLine.toLowerCase())" @click="line_name = value; searchLine = label; showLineDropdown = false; $wire.set('line_name', value);" class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer transition-colors">
                                            <span class="text-sm" x-text="label"></span>
                                        </div>
                                    </template>
                                    <div x-show="Object.keys(lineOptions).filter(key => lineOptions[key].toLowerCase().includes(searchLine.toLowerCase()) || key.toLowerCase().includes(searchLine.toLowerCase())).length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">No lines found</div>
                                </div>
                                <input type="hidden" x-model="line_name" @change="$wire.set('line_name', line_name)">
                            </div>
                            @error('line_name') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div x-show="status === 'Cleaning'" x-cloak>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">Count Last Use Stencil <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                    </svg>
                                </div>
                                <input type="number" x-model="input_count_stencil" @input="$wire.set('input_count_stencil', input_count_stencil)" placeholder="Enter count number" class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white" min="1">
                            </div>
                            @error('input_count_stencil') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">NIK / Employee <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                    <input type="text" x-model="searchEmployee" @input="showEmployeeDropdown = searchEmployee.trim().length > 0" @focus="showEmployeeDropdown = true" placeholder="Search by NIK or name..." class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:border-zinc-600 dark:text-white">
                                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div x-show="showEmployeeDropdown" @click.outside="showEmployeeDropdown = false" class="absolute z-50 w-full mt-2 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-lg max-h-60 overflow-y-auto" style="display: none;">
                                    <template x-for="(label, value) in employees" :key="value">
                                        <div x-show="label.toLowerCase().includes(searchEmployee.toLowerCase()) || value.includes(searchEmployee)" @click="nik = value; searchEmployee = label; showEmployeeDropdown = false; $wire.set('nik', value);" class="px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer transition-colors">
                                            <span class="text-sm" x-text="label"></span>
                                        </div>
                                    </template>
                                </div>
                                <input type="hidden" x-model="nik" @change="$wire.set('nik', nik)">
                            </div>
                            @error('nik') <span class="text-xs text-red-600 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-b-2xl px-6 py-4 flex justify-end gap-3">
                    <button @click="showUpdateModal = false" class="px-5 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl hover:bg-gray-100 dark:hover:bg-zinc-700 transition-all duration-200 font-medium text-sm">Cancel</button>
                    <button wire:click="saveStatusUpdate" wire:loading.attr="disabled" :disabled="isSaving" class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all duration-200 font-medium text-sm shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                        <span wire:loading.remove wire:target="saveStatusUpdate">
                            <svg class="inline w-4 h-4 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Save Changes
                        </span>
                        <span wire:loading wire:target="saveStatusUpdate">
                            <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Saving...
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ACTIVITY LOG -->
    <flux:modal wire:model="showActivityModal" class="w-full max-w-5xl">
        <div class="flex flex-col" style="height: auto; max-height: 85vh; overflow: hidden;">
            <div class="flex justify-between items-center px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex-shrink-0">
                <div>
                    <h2 class="text-xl font-bold text-zinc-800 dark:text-white">Activity Log</h2>
                    @if($selectedStencilForActivity)
                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                        Stencil: <span class="font-semibold">{{ $selectedStencilForActivity->register_no }}</span>
                        @if($selectedStencilForActivity->customer) | Customer: <span class="font-semibold">{{ $selectedStencilForActivity->customer }}</span> @endif
                    </p>
                    @endif
                </div>
            </div>

            @if($selectedStencilForActivity)
            @php
                $activitiesData = $activities;
                $totalRecords = $activitiesData->total();
                $lastPage = $activitiesData->lastPage();
                $allUsers = \App\Models\User::all()->keyBy('id');
                $allEmployees = \App\Models\HR\Employee::all()->keyBy('id');
            @endphp
            
            <div class="flex-1 overflow-y-auto p-6">
                @if($totalRecords > 0)
                    <div class="space-y-4">
                        <div class="flex gap-2 mb-2">
                            <span class="px-2 py-1 rounded-full text-white font-bold bg-red-600 text-xs">Old Value</span>
                            <span class="px-2 py-1 rounded-full text-white font-bold bg-green-600 text-xs">New Value</span>
                        </div>

                        <div class="space-y-2">
                            @foreach($activitiesData as $index => $activity)
                                @php
                                    $attributeChanges = is_string($activity->attribute_changes) ? json_decode($activity->attribute_changes, true) : ($activity->attribute_changes ?? []);
                                    $old = $attributeChanges['old'] ?? [];
                                    $new = $attributeChanges['attributes'] ?? [];
                                    
                                    if (empty($old) && empty($new)) {
                                        $props = is_string($activity->properties) ? json_decode($activity->properties, true) : ($activity->properties ?? []);
                                        $old = $props['old'] ?? [];
                                        $new = $props['attributes'] ?? [];
                                    }
                                    
                                    $changes = [];
                                    if ($activity->event == 'created') {
                                        foreach ($new as $key => $val) {
                                            if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => null, 'new' => $val];
                                            }
                                        }
                                    } elseif ($activity->event == 'updated') {
                                        foreach ($new as $key => $val) {
                                            $oldVal = $old[$key] ?? null;
                                            if ($oldVal !== $val && !in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => $oldVal, 'new' => $val];
                                            }
                                        }
                                    } elseif ($activity->event == 'deleted') {
                                        foreach ($old as $key => $val) {
                                            if (!in_array($key, ['created_by', 'updated_by', 'id', 'created_at', 'updated_at'])) {
                                                $changes[$key] = ['old' => $val, 'new' => null];
                                            }
                                        }
                                    }
                                    
                                    $isFirst = $loop->first;
                                @endphp
                                
                                @if(!empty($changes))
                                <div x-data="{ open: {{ $isFirst ? 'true' : 'false' }} }" class="border rounded-lg shadow-sm bg-white dark:bg-zinc-900">
                                    <button type="button" @click="open = !open" class="w-full flex justify-between items-center px-4 py-3 text-left font-medium bg-gray-100 hover:bg-gray-200 dark:bg-zinc-800 dark:hover:bg-zinc-700 rounded-t-lg">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            @if($activity->event == 'created')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                    CREATED
                                                </span>
                                            @elseif($activity->event == 'updated')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    UPDATED
                                                </span>
                                            @elseif($activity->event == 'deleted')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    DELETED
                                                </span>
                                            @endif
                                            <strong class="text-sm text-zinc-800 dark:text-zinc-200">{{ $activity->causer?->name ?? 'System' }}</strong>
                                            <span class="text-xs text-zinc-500">{{ $activity->created_at ? $activity->created_at->format('d M Y H:i:s') : '-' }}</span>
                                        </div>
                                        <svg :class="{ 'rotate-180': open }" class="w-4 h-4 transform transition-transform text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>

                                    <div x-show="open" x-transition class="p-4 space-y-2">
                                        @foreach ($changes as $field => $change)
                                            @php
                                                $oldValue = $change['old'];
                                                $newValue = $change['new'];
                                                $fieldName = ucfirst(str_replace('_', ' ', $field));
                                                
                                                // Handle field nik - ambil nama employee berdasarkan kolom ID
                                                if ($field === 'nik') {
                                                    if (!empty($oldValue)) {
                                                        $employee = $allEmployees[$oldValue] ?? null;
                                                        $oldValue = $employee ? $employee->name . ' (' . $employee->nik . ')' : $oldValue;
                                                    }
                                                    if (!empty($newValue)) {
                                                        $employee = $allEmployees[$newValue] ?? null;
                                                        $newValue = $employee ? $employee->name . ' (' . $employee->nik . ')' : $newValue;
                                                    }
                                                }
                                                
                                                // Handle field created_by, updated_by
                                                if (in_array($field, ['created_by', 'updated_by']) && is_numeric($oldValue)) {
                                                    $oldValue = $allUsers[$oldValue]?->name ?? $oldValue;
                                                }
                                                if (in_array($field, ['created_by', 'updated_by']) && is_numeric($newValue)) {
                                                    $newValue = $allUsers[$newValue]?->name ?? $newValue;
                                                }
                                                
                                                $displayOld = $oldValue ?? '-';
                                                $displayNew = $newValue ?? '-';
                                            @endphp

                                            <div class="text-sm flex items-center gap-2 flex-wrap">
                                                <span class="font-semibold min-w-[100px]">{{ $fieldName }}:</span>
                                                <div class="flex items-center gap-2 flex-wrap">
                                                    @if($activity->event == 'created')
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs">{{ $displayNew }}</span>
                                                    @elseif($activity->event == 'deleted')
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 text-xs">{{ $displayOld }}</span>
                                                    @else
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-red-600 line-through text-xs">{{ $displayOld }}</span>
                                                        <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                        </svg>
                                                        <span class="px-2 py-0.5 rounded-full text-white font-bold bg-green-600 text-xs">{{ $displayNew }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        
                        @if($lastPage > 1)
                        <div class="flex justify-between items-center mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                            <div class="text-sm text-zinc-500 dark:text-zinc-400">
                                Showing {{ $activitiesData->firstItem() }} to {{ $activitiesData->lastItem() }} of {{ $totalRecords }} records
                            </div>
                            <div class="flex gap-2">
                                <flux:button wire:click="setActivityPage({{ $activityPage - 1 }})" size="sm" variant="outline" :disabled="$activityPage <= 1" class="!px-3">Previous</flux:button>
                                @for($i = 1; $i <= $lastPage; $i++)
                                    @if($i == $activityPage)
                                        <flux:button size="sm" variant="primary" class="!px-3">{{ $i }}</flux:button>
                                    @elseif($i == 1 || $i == $lastPage || ($i >= $activityPage - 1 && $i <= $activityPage + 1))
                                        <flux:button wire:click="setActivityPage({{ $i }})" size="sm" variant="outline" class="!px-3">{{ $i }}</flux:button>
                                    @elseif($i == $activityPage - 2 || $i == $activityPage + 2)
                                        <span class="px-2 py-1 text-sm text-zinc-500 dark:text-zinc-400">...</span>
                                    @endif
                                @endfor
                                <flux:button wire:click="setActivityPage({{ $activityPage + 1 }})" size="sm" variant="outline" :disabled="$activityPage >= $lastPage" class="!px-3">Next</flux:button>
                            </div>
                        </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 mx-auto text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-sm text-zinc-500 dark:text-zinc-400">No activity logs found for this stencil</p>
                    </div>
                @endif
            </div>
            @endif
        </div>
    </flux:modal>

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
</section>