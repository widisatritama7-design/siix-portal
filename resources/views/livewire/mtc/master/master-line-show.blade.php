<section class="w-full">
    @include('partials.mtc-heading')

    <flux:heading class="sr-only">
        {{ __('MTC - Master Line Detail') }}
    </flux:heading>

    <x-mtc.layout 
        class="!max-w-full !px-0 !mx-0"
    >
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Maintenance
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item href="{{ route('mtc.master-lines') }}" wire:navigate separator="slash">
                        Master Line
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        View
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="w-full sm:w-auto">
                        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                            View Master Line
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            View detailed information about production line
                        </p>
                    </div>
                    <div class="w-full sm:w-auto flex-shrink-0">
                        <flux:button 
                            href="{{ route('mtc.master-lines') }}"
                            wire:navigate
                            icon="arrow-left"
                            variant="primary"
                            color="blue"
                            class="w-full sm:w-auto justify-center"
                        >
                            Back to List
                        </flux:button>
                    </div>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Line Information Card -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <div class="bg-blue-600 dark:bg-blue-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <flux:icon name="queue-list" class="w-5 h-5 text-white" />
                        <h3 class="font-semibold text-base text-white">Line Information</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
                        <div class="text-center">
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Line Number</label>
                            <p class="mt-1 text-base font-semibold text-zinc-800 dark:text-white">
                                {{ $line->line_number }}
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Location</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $line->location->location_name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Area</label>
                            <p class="mt-1 text-base text-zinc-800 dark:text-white">
                                {{ $line->location->area->area_name ?? 'N/A' }}
                            </p>
                        </div>

                        <div class="text-center">
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Machine Type</label>
                            <div class="mt-1 flex justify-center">
                                @php
                                    $machineTypeColors = [
                                        'fuji' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-400',
                                        'panasonic' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        'both' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $machineTypeColors[$line->machine_type] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($line->machine_type) }}
                                </span>
                            </div>
                        </div>

                        <div class="text-center">
                            <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block">Status</label>
                            <div class="mt-1 flex justify-center">
                                @php
                                    $statusColors = [
                                        'Running' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
                                        'Maintenance' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400',
                                        'No Schedule' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
                                        'Trouble' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400',
                                    ];
                                @endphp
                                <span class="inline-flex px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$line->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $line->status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Shift Information - Collapsible -->
                    <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <div x-data="{ open: true }" class="bg-gradient-to-r from-yellow-50 to-amber-50 dark:from-yellow-950/20 dark:to-amber-950/20 rounded-xl border border-yellow-200 dark:border-yellow-800 overflow-hidden">
                            
                            <!-- Header (Click to toggle) -->
                            <button @click="open = !open" class="w-full flex items-center justify-between p-4 hover:bg-yellow-100/50 dark:hover:bg-yellow-900/20 transition-colors">
                                <div class="flex items-center gap-2">
                                    <div class="bg-yellow-500 p-1.5 rounded-lg">
                                        <flux:icon name="clock" class="w-5 h-5 text-white" />
                                    </div>
                                    <label class="text-base font-bold text-yellow-700 dark:text-yellow-400">Shift Information & Deadline</label>
                                </div>
                                <div class="text-yellow-600 dark:text-yellow-400">
                                    <svg x-show="!open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <svg x-show="open" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </div>
                            </button>
                            
                            <!-- Content (Collapsible) -->
                            <div x-show="open" x-collapse class="p-4 pt-0">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-4">
                                    <!-- Shift 1 -->
                                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg p-3 border-l-4 border-green-500 shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-400 text-xs font-bold">1</span>
                                                <span class="font-semibold text-zinc-800 dark:text-white">Shift 1</span>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">
                                                Morning
                                            </span>
                                        </div>
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                                            🕐 07:00 - 15:00
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                ⏰ Deadline: 15:00
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Shift 2 -->
                                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg p-3 border-l-4 border-yellow-500 shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-400 text-xs font-bold">2</span>
                                                <span class="font-semibold text-zinc-800 dark:text-white">Shift 2</span>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400">
                                                Afternoon
                                            </span>
                                        </div>
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                                            🕐 15:00 - 23:00
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                ⏰ Deadline: 23:00
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Shift 3 -->
                                    <div class="bg-white dark:bg-zinc-800/50 rounded-lg p-3 border-l-4 border-blue-500 shadow-sm">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center gap-2">
                                                <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-400 text-xs font-bold">3</span>
                                                <span class="font-semibold text-zinc-800 dark:text-white">Shift 3</span>
                                            </div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400">
                                                Night
                                            </span>
                                        </div>
                                        <div class="text-sm text-zinc-600 dark:text-zinc-400 mb-2">
                                            🕐 23:00 - 07:00
                                        </div>
                                        <div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                ⏰ Deadline: 07:00
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Saturday Schedule -->
                                <div class="bg-white dark:bg-zinc-800/50 rounded-lg p-3 mb-4 border border-purple-200 dark:border-purple-800">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-purple-100 dark:bg-purple-900/50 text-purple-700 dark:text-purple-400 text-xs font-bold">S</span>
                                        <span class="font-semibold text-zinc-800 dark:text-white">Saturday Schedule</span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400">
                                            Weekend
                                        </span>
                                    </div>
                                    
                                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                        <!-- Saturday Shift 1 -->
                                        <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-lg p-2 border-l-4 border-green-500">
                                            <div class="flex items-center justify-between mb-1">
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-green-100 dark:bg-green-900/50 text-green-700 dark:text-green-400 text-xs font-bold">1</span>
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Shift 1</span>
                                                </div>
                                            </div>
                                            <div class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">
                                                🕐 07:00 - 12:15
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                    Deadline: 12:15
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Saturday Shift 2 -->
                                        <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-lg p-2 border-l-4 border-yellow-500">
                                            <div class="flex items-center justify-between mb-1">
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-yellow-100 dark:bg-yellow-900/50 text-yellow-700 dark:text-yellow-400 text-xs font-bold">2</span>
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Shift 2</span>
                                                </div>
                                            </div>
                                            <div class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">
                                                🕐 12:15 - 17:45
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                    Deadline: 17:45
                                                </span>
                                            </div>
                                        </div>

                                        <!-- Saturday Shift 3 -->
                                        <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-lg p-2 border-l-4 border-blue-500">
                                            <div class="flex items-center justify-between mb-1">
                                                <div class="flex items-center gap-1">
                                                    <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-blue-100 dark:bg-blue-900/50 text-blue-700 dark:text-blue-400 text-xs font-bold">3</span>
                                                    <span class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Shift 3</span>
                                                </div>
                                            </div>
                                            <div class="text-xs text-zinc-600 dark:text-zinc-400 mb-1">
                                                🕐 17:45 - 23:00
                                            </div>
                                            <div>
                                                <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400">
                                                    Deadline: 23:00
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Warning Note -->
                                <div class="bg-red-50 dark:bg-red-950/30 rounded-lg p-3 border border-red-200 dark:border-red-800">
                                    <div class="flex items-center gap-2">
                                        <div class="bg-red-500 p-1 rounded-full">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                        <div class="flex-1">
                                            <span class="font-semibold text-red-700 dark:text-red-400">⚠️ Important</span>
                                            <p class="text-sm text-red-600 dark:text-red-400">If inspection exceeds the shift deadline, status will automatically change to <strong>"Delay"</strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($line->trouble_desc)
                    <div class="mt-6 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                        <label class="text-sm font-medium text-zinc-500 dark:text-zinc-400 block mb-2">Trouble Description</label>
                        <div class="bg-red-50 dark:bg-red-950/30 rounded-lg p-3">
                            <p class="text-sm text-red-700 dark:text-red-400">
                                {{ $line->trouble_desc }}
                            </p>
                        </div>
                    </div>
                    @endif
                </div>
            </flux:card>

            <!-- Daily Fuji Inspection Records -->
            @if(in_array($line->machine_type, ['fuji', 'both']))
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <div class="bg-white dark:bg-zinc-800 px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <flux:icon name="clipboard-document-list" class="w-5 h-5 text-zinc-600 dark:text-zinc-400" />
                            <h3 class="font-semibold text-base text-zinc-900 dark:text-white">Daily Fuji Inspection Records</h3>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <flux:input 
                                wire:model.live.debounce.300ms="search" 
                                placeholder="Search..."
                                icon="magnifying-glass"
                                class="w-48 sm:w-64"
                            />
                            <select 
                                wire:model.live="selectedStatus" 
                                class="rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-green-500"
                            >
                                <option value="">All Status</option>
                                <option value="Checked">Checked</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Delay">Delay</option>
                                <option value="Holiday">Holiday</option>
                            </select>
                            <flux:button 
                                wire:click="resetFilters" 
                                icon="arrow-path" 
                                variant="subtle"
                            >
                                Reset
                            </flux:button>
                            <flux:button 
                                wire:click="createDailyFuji"
                                icon="plus"
                                color="green"
                            >
                                New Inspection
                            </flux:button>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 sm:p-6">
                    @if($dailyFujis->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Approval</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Group</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Run Time</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Stop Time</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Check By</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Approved By</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Time First</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Updated</th>
                                    <th class="px-3 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($dailyFujis as $dailyFuji)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group">
                                    <!-- Status Column with Icon & Tooltip -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="relative inline-flex items-center gap-2 cursor-help group/status"
                                            title="{{ $dailyFuji->overall_status_text }}">
                                            @if($dailyFuji->overall_status === 'success')
                                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                                            @else
                                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                                            @endif
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $dailyFuji->overall_status === 'success' ? 'OK' : 'Invalid' }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <!-- Approval Badge -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @php
                                            $approvalConfig = [
                                                'Approved' => ['class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400', 'icon' => 'check-circle'],
                                                'Rejected' => ['class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400', 'icon' => 'x-circle'],
                                                'Pending' => ['class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400', 'icon' => 'clock'],
                                            ];
                                            $config = $approvalConfig[$dailyFuji->approval] ?? $approvalConfig['Pending'];
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $config['class'] }}">
                                            <flux:icon name="{{ $config['icon'] }}" class="w-3 h-3" />
                                            {{ $dailyFuji->approval ?? 'Pending' }}
                                        </span>
                                    </td>
                                    
                                    <!-- Group -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-semibold text-sm">
                                            {{ $dailyFuji->group ?? '-' }}
                                        </span>
                                    </td>
                                    
                                    <!-- Run Time Badge -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @if($dailyFuji->run_time)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <flux:icon.play class="w-3 h-3" />
                                            {{ $dailyFuji->run_time->format('H:i') }}
                                        </span>
                                        @else
                                        <span class="text-sm text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Stop Time Badge -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @if($dailyFuji->stop_time)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                            <flux:icon.stop class="w-3 h-3" />
                                            {{ $dailyFuji->stop_time->format('H:i') }}
                                        </span>
                                        @else
                                        <span class="text-sm text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Check By -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                                    {{ substr($dailyFuji->updater->name ?? $dailyFuji->creator->name ?? '-', 0, 1) }}
                                                </span>
                                            </div>
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $dailyFuji->updater->name ?? $dailyFuji->creator->name ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <!-- Approved By -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @if($dailyFuji->approvedBy)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                                <span class="text-xs font-medium text-green-600 dark:text-green-400">
                                                    {{ substr($dailyFuji->approvedBy->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $dailyFuji->approvedBy->name }}
                                            </span>
                                        </div>
                                        @else
                                        <span class="text-sm text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Created At -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="text-sm">
                                            <div class="text-zinc-700 dark:text-zinc-300">{{ $dailyFuji->created_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-zinc-400">{{ $dailyFuji->created_at->format('H:i:s') }}</div>
                                        </div>
                                    </td>

                                    
                                    <!-- Created At -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="text-sm">
                                            <div class="text-zinc-700 dark:text-zinc-300">{{ $dailyFuji->updated_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-zinc-400">{{ $dailyFuji->updated_at->format('H:i:s') }}</div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                            <!-- View Details Button -->
                                            <flux:button 
                                                wire:click="viewDailyFujiDetails({{ $dailyFuji->id }})"
                                                size="sm"
                                                icon="eye"
                                                color="blue"
                                                class="!p-2 flex-shrink-0"
                                                title="View inspection details"
                                            />
                                            
                                            <!-- Edit Button dengan validasi waktu -->
                                            @php
                                                $canEdit = now()->lessThanOrEqualTo($dailyFuji->getShiftEnd());
                                            @endphp
                                            
                                            @if($canEdit)
                                                <flux:button 
                                                    wire:click="editDailyFuji({{ $dailyFuji->id }})"
                                                    size="sm"
                                                    icon="pencil-square"
                                                    color="yellow"
                                                    class="!p-2 flex-shrink-0"
                                                    title="Edit inspection"
                                                />
                                            @else
                                                <flux:button 
                                                    size="sm"
                                                    icon="pencil-square"
                                                    color="gray"
                                                    class="!p-2 flex-shrink-0 opacity-50 cursor-not-allowed"
                                                    title="Cannot edit - Shift has ended"
                                                    disabled
                                                />
                                            @endif
                                            
                                            <!-- Approval Button -->
                                            @if($dailyFuji->approval !== 'Approved' && $dailyFuji->status === 'Checked' && auth()->user()->can('edit daily fuji'))
                                                <flux:button 
                                                    wire:click="openApprovalModal({{ $dailyFuji->id }})"
                                                    size="sm"
                                                    icon="check-badge"
                                                    color="green"
                                                    class="!p-2 flex-shrink-0"
                                                    title="Approve/Reject inspection"
                                                />
                                            @endif

                                            <a 
                                                href="{{ route('print.daily-fuji', $dailyFuji->id) }}"
                                                target="_blank"
                                                class="inline-flex items-center justify-center p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors dark:text-gray-400 dark:hover:bg-gray-800"
                                                title="Print checklist"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination -->
                    <div class="mt-4 px-2">
                        {{ $dailyFujis->links() }}
                    </div>
                    
                    @else
                    <div class="text-center py-12">
                        <flux:icon.document-magnifying-glass class="w-12 h-12 mx-auto text-zinc-400 mb-3" />
                        <p class="text-zinc-500 dark:text-zinc-400">No inspection records found for this line.</p>
                        <button 
                            wire:click="createDailyFuji"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors"
                        >
                            <flux:icon.plus class="w-4 h-4" />
                            Create First Inspection
                        </button>
                    </div>
                    @endif
                </div>
            </flux:card>
            @endif

            <!-- Daily Panasonic Inspection Records -->
            @if(in_array($line->machine_type, ['panasonic', 'both']))
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden mb-6">
                <div class="bg-white dark:bg-zinc-800 px-6 py-4 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <flux:icon name="clipboard-document-list" class="w-5 h-5 text-zinc-600 dark:text-zinc-400" />
                            <h3 class="font-semibold text-base text-zinc-900 dark:text-white">Daily Panasonic Inspection Records</h3>
                        </div>
                        <div class="flex flex-wrap items-center gap-2">
                            <flux:input 
                                wire:model.live.debounce.300ms="panasonicSearch" 
                                placeholder="Search..."
                                icon="magnifying-glass"
                                class="w-48 sm:w-64"
                            />
                            <select 
                                wire:model.live="selectedPanasonicStatus" 
                                class="rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                            >
                                <option value="">All Status</option>
                                <option value="Checked">Checked</option>
                                <option value="On Progress">On Progress</option>
                                <option value="Delay">Delay</option>
                                <option value="Holiday">Holiday</option>
                            </select>
                            <flux:button 
                                wire:click="resetPanasonicFilters" 
                                icon="arrow-path" 
                                variant="subtle"
                            >
                                Reset
                            </flux:button>
                            <flux:button 
                                wire:click="createDailyPanasonic"
                                icon="plus"
                                color="green"
                            >
                                New Inspection
                            </flux:button>
                        </div>
                    </div>
                </div>
                
                <div class="p-4 sm:p-6">
                    @if($dailyPanasonics->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-zinc-200 dark:divide-zinc-700">
                            <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                                <tr>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Approval</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Group</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Run Time</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Stop Time</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Check By</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Approved By</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Time First</th>
                                    <th class="px-3 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Last Updated</th>
                                    <th class="px-3 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                                @foreach($dailyPanasonics as $dailyPanasonic)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors group">
                                    <!-- Status Column -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="relative inline-flex items-center gap-2 cursor-help group/status"
                                            title="{{ $dailyPanasonic->overall_status_text }}">
                                            @if($dailyPanasonic->overall_status === 'success')
                                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                                            @else
                                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                                            @endif
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $dailyPanasonic->overall_status === 'success' ? 'OK' : 'Invalid' }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <!-- Approval Badge -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @php
                                            $panasonicApprovalConfig = [
                                                'Approved' => ['class' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400', 'icon' => 'check-circle'],
                                                'Rejected' => ['class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400', 'icon' => 'x-circle'],
                                                'Pending' => ['class' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400', 'icon' => 'clock'],
                                            ];
                                            $panasonicConfig = $panasonicApprovalConfig[$dailyPanasonic->approval] ?? $panasonicApprovalConfig['Pending'];
                                        @endphp
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium {{ $panasonicConfig['class'] }}">
                                            <flux:icon name="{{ $panasonicConfig['icon'] }}" class="w-3 h-3" />
                                            {{ $dailyPanasonic->approval ?? 'Pending' }}
                                        </span>
                                    </td>
                                    
                                    <!-- Group -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 font-semibold text-sm">
                                            {{ $dailyPanasonic->group ?? '-' }}
                                        </span>
                                    </td>
                                    
                                    <!-- Run Time -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @if($dailyPanasonic->run_time)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400">
                                            <flux:icon.play class="w-3 h-3" />
                                            {{ $dailyPanasonic->run_time->format('H:i') }}
                                        </span>
                                        @else
                                        <span class="text-sm text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Stop Time -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @if($dailyPanasonic->stop_time)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400">
                                            <flux:icon.stop class="w-3 h-3" />
                                            {{ $dailyPanasonic->stop_time->format('H:i') }}
                                        </span>
                                        @else
                                        <span class="text-sm text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Check By -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                <span class="text-xs font-medium text-blue-600 dark:text-blue-400">
                                                    {{ substr($dailyPanasonic->updater->name ?? $dailyPanasonic->creator->name ?? '-', 0, 1) }}
                                                </span>
                                            </div>
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $dailyPanasonic->updater->name ?? $dailyPanasonic->creator->name ?? '-' }}
                                            </span>
                                        </div>
                                    </td>
                                    
                                    <!-- Approved By -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        @if($dailyPanasonic->approvedBy)
                                        <div class="flex items-center gap-2">
                                            <div class="w-6 h-6 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                                                <span class="text-xs font-medium text-green-600 dark:text-green-400">
                                                    {{ substr($dailyPanasonic->approvedBy->name, 0, 1) }}
                                                </span>
                                            </div>
                                            <span class="text-sm text-zinc-700 dark:text-zinc-300">
                                                {{ $dailyPanasonic->approvedBy->name }}
                                            </span>
                                        </div>
                                        @else
                                        <span class="text-sm text-zinc-400">-</span>
                                        @endif
                                    </td>
                                    
                                    <!-- Created At -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="text-sm">
                                            <div class="text-zinc-700 dark:text-zinc-300">{{ $dailyPanasonic->created_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-zinc-400">{{ $dailyPanasonic->created_at->format('H:i:s') }}</div>
                                        </div>
                                    </td>
                                    
                                    <!-- Updated At -->
                                    <td class="px-3 py-3 whitespace-nowrap">
                                        <div class="text-sm">
                                            <div class="text-zinc-700 dark:text-zinc-300">{{ $dailyPanasonic->updated_at->format('d/m/Y') }}</div>
                                            <div class="text-xs text-zinc-400">{{ $dailyPanasonic->updated_at->format('H:i:s') }}</div>
                                        </div>
                                    </td>
                                    
                                    <!-- Actions -->
                                    <td class="px-4 py-3 text-right">
                                        <div class="flex items-center justify-end gap-1 whitespace-nowrap">
                                            <!-- View Button -->
                                            <flux:button 
                                                wire:click="viewDailyPanasonicDetails({{ $dailyPanasonic->id }})"
                                                size="sm"
                                                icon="eye"
                                                color="blue"
                                                class="!p-2 flex-shrink-0"
                                                title="View inspection details"
                                            />
                                            
                                            <!-- Edit Button -->
                                            @php
                                                $canEditPanasonic = now()->lessThanOrEqualTo($dailyPanasonic->getShiftEnd());
                                            @endphp
                                            
                                            @if($canEditPanasonic)
                                                <flux:button 
                                                    wire:click="editDailyPanasonic({{ $dailyPanasonic->id }})"
                                                    size="sm"
                                                    icon="pencil-square"
                                                    color="yellow"
                                                    class="!p-2 flex-shrink-0"
                                                    title="Edit inspection"
                                                />
                                            @else
                                                <flux:button 
                                                    size="sm"
                                                    icon="pencil-square"
                                                    color="gray"
                                                    class="!p-2 flex-shrink-0 opacity-50 cursor-not-allowed"
                                                    title="Cannot edit - Shift has ended"
                                                    disabled
                                                />
                                            @endif
                                            
                                            <!-- Approval Button -->
                                            @if($dailyPanasonic->approval !== 'Approved' && $dailyPanasonic->status === 'Checked' && auth()->user()->can('edit daily panasonic'))
                                                <flux:button 
                                                    wire:click="openPanasonicApprovalModal({{ $dailyPanasonic->id }})"
                                                    size="sm"
                                                    icon="check-badge"
                                                    color="green"
                                                    class="!p-2 flex-shrink-0"
                                                    title="Approve/Reject inspection"
                                                />
                                            @endif

                                            <a 
                                                href="{{ route('print.daily-panasonic', $dailyPanasonic->id) }}"
                                                target="_blank"
                                                class="inline-flex items-center justify-center p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors dark:text-gray-400 dark:hover:bg-gray-800"
                                                title="Print checklist"
                                            >
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>   
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Pagination Panasonic -->
                    <div class="mt-4 px-2">
                        {{ $dailyPanasonics->links() }}
                    </div>
                    
                    @else
                    <div class="text-center py-12">
                        <flux:icon.document-magnifying-glass class="w-12 h-12 mx-auto text-zinc-400 mb-3" />
                        <p class="text-zinc-500 dark:text-zinc-400">No Panasonic inspection records found for this line.</p>
                        <button 
                            wire:click="createDailyPanasonic"
                            class="mt-4 inline-flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors"
                        >
                            <flux:icon.plus class="w-4 h-4" />
                            Create First Panasonic Inspection
                        </button>
                    </div>
                    @endif
                </div>
            </flux:card>
            @endif

            <style>
                [x-cloak] { display: none !important; }
            </style>
        </div>
    </x-mtc.layout>

    <!-- Daily Fuji Detail Modal -->
    <flux:modal wire:model="showDailyFujiModal" class="max-w-4xl">
        <div class="space-y-4">
            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 pb-3">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Daily Fuji Inspection Details
                </h3>
            </div>
            
            @if($selectedDailyFuji)
            <div class="space-y-4 max-h-[75vh] overflow-y-auto px-1 pb-4">
                <!-- Header Info -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 rounded-lg">
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Line Number</label>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $selectedDailyFuji->masterLine->line_number ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Group</label>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $selectedDailyFuji->group ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Status</label>
                        <p class="text-sm">
                            @php
                                $statusColors = [
                                    'Checked' => 'text-green-600',
                                    'On Progress' => 'text-yellow-600',
                                    'Delay' => 'text-red-600',
                                    'Holiday' => 'text-gray-600',
                                ];
                            @endphp
                            <span class="font-semibold {{ $statusColors[$selectedDailyFuji->status] ?? 'text-zinc-600' }}">
                                {{ $selectedDailyFuji->status }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Approval</label>
                        <p class="text-sm font-semibold">
                            @php
                                $approvalColors = [
                                    'Approved' => 'text-green-600',
                                    'Rejected' => 'text-red-600',
                                    'Pending' => 'text-yellow-600',
                                ];
                            @endphp
                            <span class="{{ $approvalColors[$selectedDailyFuji->approval] ?? 'text-zinc-600' }}">
                                {{ $selectedDailyFuji->approval ?? 'Pending' }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Overall Status -->
                <div class="p-4 rounded-lg {{ $selectedDailyFuji->overall_status === 'success' ? 'bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800' }}">
                    <div class="flex items-center gap-2">
                        @if($selectedDailyFuji->overall_status === 'success')
                            <flux:icon.check-circle class="w-6 h-6 text-green-600" />
                        @else
                            <flux:icon.x-circle class="w-6 h-6 text-red-600" />
                        @endif
                        <span class="font-semibold {{ $selectedDailyFuji->overall_status === 'success' ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                            {{ $selectedDailyFuji->overall_status_text }}
                        </span>
                    </div>
                </div>

                @php
                    // Helper function to check if field is empty (null or empty string, but '-' is considered filled)
                    function isFieldEmpty($value) {
                        return $value === null || $value === '';
                    }
                    
                    // Helper function to check if step has incomplete fields
                    function isStepIncomplete($dailyFuji, $stepFields) {
                        foreach ($stepFields as $field) {
                            $value = $dailyFuji->{$field};
                            if (isFieldEmpty($value)) {
                                return true;
                            }
                        }
                        return false;
                    }
                    
                    // Helper function to get field color class
                    function getFieldColorClass($value) {
                        return isFieldEmpty($value) ? 'text-red-600' : 'text-green-600';
                    }
                @endphp

                <!-- STEP 1: GENERAL -->
                @php
                    $step1Fields = ['body_cover'];
                    $step1Incomplete = isStepIncomplete($selectedDailyFuji, $step1Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step1Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step1Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step1Incomplete ? 'text-red-600' : 'text-blue-600' }}">1</span>
                                <h4 class="font-semibold {{ $step1Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">GENERAL</h4>
                            </div>
                            @if($step1Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Body Cover</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure all machine cover clean</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->body_cover) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->body_cover ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: LOADER -->
                @php
                    $step2Fields = ['cylinder', 'rail_and_magazine_pcb', 'cover_magazine'];
                    $step2Incomplete = isStepIncomplete($selectedDailyFuji, $step2Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step2Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step2Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step2Incomplete ? 'text-red-600' : 'text-blue-600' }}">2</span>
                                <h4 class="font-semibold {{ $step2Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">LOADER</h4>
                            </div>
                            @if($step2Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <!-- Cylinder -->
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cylinder (1)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Operation And center</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Smooth and center</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->cylinder) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->cylinder ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Rail & Magazine PCB -->
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Rail & Magazine PCB (1.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning Dust and dirty</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->rail_and_magazine_pcb) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->rail_and_magazine_pcb ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <!-- Cover Magazine -->
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cover Magazine (1.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning Dust and dirty</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->cover_magazine) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->cover_magazine ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: PCB CLEANER -->
                @php
                    $step3Fields = ['brush', 'air_presure', 'vacume_presure_unitech', 'vacume_presure_nix', 'vacume_brush', 'cleaning_roller', 'ionizer', 'conveyor_speed'];
                    $step3Incomplete = isStepIncomplete($selectedDailyFuji, $step3Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step3Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step3Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step3Incomplete ? 'text-red-600' : 'text-blue-600' }}">3</span>
                                <h4 class="font-semibold {{ $step3Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">PCB CLEANER</h4>
                            </div>
                            @if($step3Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Brush (2)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning touch PCB</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Rotation</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->brush) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->brush ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure (2.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.45 - 0.54 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->air_presure) }}">
                                    Value : {{ $selectedDailyFuji->air_presure ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vacume Pressure Unitech (2.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.45 - 0.54 Mpa (Unitech only)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->vacume_presure_unitech) }}">
                                    Value : {{ $selectedDailyFuji->vacume_presure_unitech ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vacume Pressure Nix (2.c)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.60 - 0.70 Mpa (N.I.X only)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->vacume_presure_nix) }}">
                                    Value : {{ $selectedDailyFuji->vacume_presure_nix ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vacume Brush (3)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Operation</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Rotation</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->vacume_brush) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->vacume_brush ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cleaning Roller (4)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Rotation and Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Smooth rotation & Clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->cleaning_roller) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->cleaning_roller ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Ionizer (5)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 5 Times to push cleaner</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->ionizer) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->ionizer ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Conveyor Setting (6)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Analog panel (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 40</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->conveyor_speed) }}">
                                    Value : {{ $selectedDailyFuji->conveyor_speed ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: PRINTING -->
                @php
                    $step4Fields = ['ipa_solvent', 'temperature_control_1', 'humidity_control_1', 'clamp_presure', 'squeege_upper', 'cleaning_solvent', 'air_presure_meter'];
                    $step4Incomplete = isStepIncomplete($selectedDailyFuji, $step4Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step4Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step4Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step4Incomplete ? 'text-red-600' : 'text-blue-600' }}">4</span>
                                <h4 class="font-semibold {{ $step4Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">PRINTING</h4>
                            </div>
                            @if($step4Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">IPA Solvent (7)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure solvent minimal on mid level (half)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Tank Minimal half</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->ipa_solvent) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->ipa_solvent ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Temperature Control (8)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Result-01</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 23-27℃</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->temperature_control_1) }}">
                                    Value : {{ $selectedDailyFuji->temperature_control_1 ?? '-' }} ℃
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Humidity Control (8.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Result-01</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 35 % - 70 %</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->humidity_control_1) }}">
                                    Value : {{ $selectedDailyFuji->humidity_control_1 ?? '-' }} %
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Clamp Pressure (9)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.20 ~ 0.4 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->clamp_presure) }}">
                                    Value : {{ $selectedDailyFuji->clamp_presure ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Squeege Upper (10)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.12 ~ (+/ 0.01) Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->squeege_upper) }}">
                                    Value : {{ $selectedDailyFuji->squeege_upper ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cleaning Solvent (11)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.20 ~ (+/ 0.01) Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->cleaning_solvent) }}">
                                    Value : {{ $selectedDailyFuji->cleaning_solvent ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure Meter (12)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.50~ 0.55 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->air_presure_meter) }}">
                                    Value : {{ $selectedDailyFuji->air_presure_meter ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 5: SPI -->
                @php
                    $step5Fields = ['air_presure_meter_parmi', 'capability_index'];
                    $step5Incomplete = isStepIncomplete($selectedDailyFuji, $step5Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step5Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step5Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step5Incomplete ? 'text-red-600' : 'text-blue-600' }}">5</span>
                                <h4 class="font-semibold {{ $step5Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">SPI</h4>
                            </div>
                            @if($step5Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure Meter Parmi (12.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.40 - 0.50 Mpa (PARMI)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->air_presure_meter_parmi) }}">
                                    Value : {{ $selectedDailyFuji->air_presure_meter_parmi ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Capability Index (12.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check SPI Measurement result with Master Jig (Solder Paste height) (write CpK value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : CpK for Masspro > 1.67</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->capability_index) }}">
                                    Value : {{ $selectedDailyFuji->capability_index ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 6: CHIP MOUNTER 1 -->
                @php
                    $step6Fields = ['air_presure_supply', 'vaccuum_pump_1', 'box_1', 'vaccuum_parameter_1', 'expire_date_1'];
                    $step6Incomplete = isStepIncomplete($selectedDailyFuji, $step6Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step6Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step6Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step6Incomplete ? 'text-red-600' : 'text-blue-600' }}">6</span>
                                <h4 class="font-semibold {{ $step6Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">CHIP MOUNTER 1</h4>
                            </div>
                            @if($step6Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure Supply (13)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.49 ~ 0.54 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->air_presure_supply) }}">
                                    Value : {{ $selectedDailyFuji->air_presure_supply ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Pump (13.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -87 ~ -100 Kpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->vaccuum_pump_1) }}">
                                    Value : {{ $selectedDailyFuji->vaccuum_pump_1 ?? '-' }} Kpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Box (13.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Chip collection</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No components</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->box_1) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->box_1 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Parameter (13.c)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with machine parameter result</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Yellow initial (display)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->vaccuum_parameter_1) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->vaccuum_parameter_1 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Expire Date (14)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure due date on the label</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Expired</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->expire_date_1) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->expire_date_1 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 7: CHIP MOUNTER 2 -->
                @php
                    $step7Fields = ['air_presure_supply_2', 'vaccuum_pump_2', 'box_2', 'vaccuum_parameter_2', 'expire_date_2'];
                    $step7Incomplete = isStepIncomplete($selectedDailyFuji, $step7Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step7Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step7Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step7Incomplete ? 'text-red-600' : 'text-blue-600' }}">7</span>
                                <h4 class="font-semibold {{ $step7Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">CHIP MOUNTER 2</h4>
                            </div>
                            @if($step7Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure Supply (15)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.49 ~ 0.54 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->air_presure_supply_2) }}">
                                    Value : {{ $selectedDailyFuji->air_presure_supply_2 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Pump (15.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -87 ~ -100 Kpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->vaccuum_pump_2) }}">
                                    Value : {{ $selectedDailyFuji->vaccuum_pump_2 ?? '-' }} Kpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Box (15.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Chip collection</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No components</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->box_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->box_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Parameter (15.c)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with machine parameter result</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Yellow initial (display)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->vaccuum_parameter_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->vaccuum_parameter_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Expire Date (16)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure due date on the label</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Expired</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->expire_date_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->expire_date_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 8: REFLOW -->
                @php
                    $step8Fields = ['abandonment', 'fire_posibilty', 'rail_and_transfer_unit', 'n2_presure', 'oxygent_density_sek', 'oxygent_density_special', 'fire_posibilty_2'];
                    $step8Incomplete = isStepIncomplete($selectedDailyFuji, $step8Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step8Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step8Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step8Incomplete ? 'text-red-600' : 'text-blue-600' }}">8</span>
                                <h4 class="font-semibold {{ $step8Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">REFLOW</h4>
                            </div>
                            @if($step8Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Abandonment (17)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Damage</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Damage</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->abandonment) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->abandonment ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Fire Possibility (17.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : PCB input area No paper,plastic</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Paper, No plastic</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->fire_posibilty) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->fire_posibilty ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Rail & Transfer Unit (18)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : make sure it is smooth condition</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No jammed</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->rail_and_transfer_unit) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->rail_and_transfer_unit ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">N2 Pressure (19)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check N2 Pressure</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.4MPa ~ 0.5MPa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->n2_presure) }}">
                                    Value : {{ $selectedDailyFuji->n2_presure ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Oxygen Density SEK (20)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Oxygen meter (SEK Standard)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 1200~1800 ppm</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->oxygent_density_sek) }}">
                                    Value : {{ $selectedDailyFuji->oxygent_density_sek ?? '-' }} ppm
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Oxygen Density Special (20)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Oxygen meter (Special Requirement)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 500~1000 ppm</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->oxygent_density_special) }}">
                                    Value : {{ $selectedDailyFuji->oxygent_density_special ?? '-' }} ppm
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Fire Possibility (20.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : PCB Output area No paper,plastic</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Paper, No plastic</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->fire_posibilty_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->fire_posibilty_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 9: AOI -->
                @php
                    $step9Fields = ['air_presure_2'];
                    $step9Incomplete = isStepIncomplete($selectedDailyFuji, $step9Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step9Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step9Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step9Incomplete ? 'text-red-600' : 'text-blue-600' }}">9</span>
                                <h4 class="font-semibold {{ $step9Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">AOI</h4>
                            </div>
                            @if($step9Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure (20.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.40 - 0.50 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->air_presure_2) }}">
                                    Value : {{ $selectedDailyFuji->air_presure_2 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 10: UNLOADER -->
                @php
                    $step10Fields = ['cylinder_2', 'rail_and_magazine_pcb_2', 'cover_magazine_2'];
                    $step10Incomplete = isStepIncomplete($selectedDailyFuji, $step10Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step10Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step10Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step10Incomplete ? 'text-red-600' : 'text-blue-600' }}">10</span>
                                <h4 class="font-semibold {{ $step10Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">UNLOADER</h4>
                            </div>
                            @if($step10Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cylinder (21)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Operation And center</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Smooth and center</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->cylinder_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->cylinder_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Rail & Magazine PCB (21.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning Dust and dirty</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->rail_and_magazine_pcb_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->rail_and_magazine_pcb_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cover Magazine (21.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning Dust and dirty</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->cover_magazine_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->cover_magazine_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 11: AOI TABLE -->
                @php
                    $step11Fields = ['angle_and_filter', 'lamp_indicator'];
                    $step11Incomplete = isStepIncomplete($selectedDailyFuji, $step11Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step11Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step11Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step11Incomplete ? 'text-red-600' : 'text-blue-600' }}">11</span>
                                <h4 class="font-semibold {{ $step11Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">AOI TABLE</h4>
                            </div>
                            @if($step11Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Angle & Filter (22)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No dirt / no dust</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->angle_and_filter) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->angle_and_filter ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Lamp Indicator (22.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : LED Lamp (Green)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Function</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->lamp_indicator) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->lamp_indicator ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 12: REFLOW 2 -->
                @php
                    $step12Fields = ['temperature_chiller', 'temperature_control_3'];
                    $step12Incomplete = isStepIncomplete($selectedDailyFuji, $step12Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step12Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step12Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step12Incomplete ? 'text-red-600' : 'text-blue-600' }}">12</span>
                                <h4 class="font-semibold {{ $step12Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">REFLOW 2</h4>
                            </div>
                            @if($step12Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Temperature Chiller (23)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Write down the value</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 17-23℃</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->temperature_chiller) }}">
                                    Value : {{ $selectedDailyFuji->temperature_chiller ?? '-' }} ℃
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Temperature Control (24)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check Value inspect</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 300℃ ±10℃</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->temperature_control_3) }}">
                                    Value : {{ $selectedDailyFuji->temperature_control_3 ?? '-' }} ℃
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 13: CHIP MOUNTER 3 -->
                @php
                    $step13Fields = ['fan_unit_1'];
                    $step13Incomplete = isStepIncomplete($selectedDailyFuji, $step13Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step13Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step13Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step13Incomplete ? 'text-red-600' : 'text-blue-600' }}">13</span>
                                <h4 class="font-semibold {{ $step13Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">CHIP MOUNTER 3</h4>
                            </div>
                            @if($step13Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Fan Unit 1 (25)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure all Fan clean</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->fan_unit_1) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->fan_unit_1 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 14: CHIP MOUNTER 4 -->
                @php
                    $step14Fields = ['fan_unit_2'];
                    $step14Incomplete = isStepIncomplete($selectedDailyFuji, $step14Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step14Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step14Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step14Incomplete ? 'text-red-600' : 'text-blue-600' }}">14</span>
                                <h4 class="font-semibold {{ $step14Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">CHIP MOUNTER 4</h4>
                            </div>
                            @if($step14Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Fan Unit 2 (26)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure all Fan clean</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->fan_unit_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->fan_unit_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 15: SPI 2 -->
                @php
                    $step15Fields = ['air_presure_3'];
                    $step15Incomplete = isStepIncomplete($selectedDailyFuji, $step15Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step15Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step15Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step15Incomplete ? 'text-red-600' : 'text-blue-600' }}">15</span>
                                <h4 class="font-semibold {{ $step15Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">SPI 2</h4>
                            </div>
                            @if($step15Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure (27)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.40 - 0.50 Mpa (Kohyoung)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->air_presure_3) }}">
                                    Value : {{ $selectedDailyFuji->air_presure_3 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 16: PRINTER -->
                @php
                    $step16Fields = ['temperature_control_4', 'water_reservoirs'];
                    $step16Incomplete = isStepIncomplete($selectedDailyFuji, $step16Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step16Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step16Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step16Incomplete ? 'text-red-600' : 'text-blue-600' }}">16</span>
                                <h4 class="font-semibold {{ $step16Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">PRINTER</h4>
                            </div>
                            @if($step16Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Temperature Control (28)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Air cond Setting Temperature</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 23-27℃</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->temperature_control_4) }}">
                                    Value : {{ $selectedDailyFuji->temperature_control_4 ?? '-' }} ℃
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Water Reservoirs (28.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Damage, Function</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Function, No Damage</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->water_reservoirs) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->water_reservoirs ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 17: PCB CLEANER 2 -->
                @php
                    $step17Fields = ['filter'];
                    $step17Incomplete = isStepIncomplete($selectedDailyFuji, $step17Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step17Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step17Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step17Incomplete ? 'text-red-600' : 'text-blue-600' }}">17</span>
                                <h4 class="font-semibold {{ $step17Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">PCB CLEANER 2</h4>
                            </div>
                            @if($step17Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Filter (29)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->filter) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->filter ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 18: IONIZER -->
                @php
                    $step18Fields = ['angle_and_filter_2'];
                    $step18Incomplete = isStepIncomplete($selectedDailyFuji, $step18Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step18Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step18Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step18Incomplete ? 'text-red-600' : 'text-blue-600' }}">18</span>
                                <h4 class="font-semibold {{ $step18Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">IONIZER</h4>
                            </div>
                            @if($step18Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Angle & Filter (30)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No dirt / no dust</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->angle_and_filter_2) }}">
                                    Value : {{ ucfirst($selectedDailyFuji->angle_and_filter_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TIME & STATUS -->
                @php
                    $stepTimeFields = ['run_time', 'group'];
                    $stepTimeIncomplete = false;
                    foreach ($stepTimeFields as $field) {
                        if (isFieldEmpty($selectedDailyFuji->{$field})) {
                            $stepTimeIncomplete = true;
                            break;
                        }
                    }
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $stepTimeIncomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $stepTimeIncomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $stepTimeIncomplete ? 'text-red-600' : 'text-blue-600' }}">19</span>
                                <h4 class="font-semibold {{ $stepTimeIncomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">TIME & STATUS</h4>
                            </div>
                            @if($stepTimeIncomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Stop Time</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : -</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ isFieldEmpty($selectedDailyFuji->stop_time) ? 'text-red-600' : 'text-green-600' }}">
                                    Value : {{ $selectedDailyFuji->stop_time ? $selectedDailyFuji->stop_time->format('H:i') : '-' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Run Time</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : -</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->run_time) }}">
                                    Value : {{ $selectedDailyFuji->run_time ? $selectedDailyFuji->run_time->format('H:i') : '-' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Group</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : -</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : A, B, or C</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getFieldColorClass($selectedDailyFuji->group) }}">
                                    Value : {{ $selectedDailyFuji->group ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/50 dark:to-gray-800/50 rounded-lg text-xs text-zinc-500 space-y-1">
                    <div><span class="font-medium">Created:</span> {{ $selectedDailyFuji->created_at->format('d/m/Y H:i:s') }} by {{ $selectedDailyFuji->creator->name ?? 'System' }}</div>
                    <div><span class="font-medium">Last Updated:</span> {{ $selectedDailyFuji->updated_at->format('d/m/Y H:i:s') }} by {{ $selectedDailyFuji->updater->name ?? '-' }}</div>
                    @if($selectedDailyFuji->approved_by)
                    <div><span class="font-medium">Approved:</span> {{ $selectedDailyFuji->updated_at->format('d/m/Y H:i:s') }} by {{ $selectedDailyFuji->approvedBy->name ?? '-' }}</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </flux:modal>

    <!-- Approval Modal -->
    <flux:modal wire:model="showApprovalModal" class="max-w-md">
        <div class="space-y-4">
            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 pb-3">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Update Approval Status
                </h3>
                <flux:button 
                    wire:click="closeApprovalModal" 
                    icon="x-mark" 
                    variant="subtle"
                    size="sm"
                />
            </div>
            
            <div class="space-y-4">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Set approval status for inspection record.
                </p>
                
                <div class="flex gap-4 justify-center">
                    <button 
                        wire:click="setApproval('Approved')"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors"
                    >
                        <flux:icon.check-circle class="w-5 h-5" />
                        <span>Approved</span>
                    </button>
                    <button 
                        wire:click="setApproval('Rejected')"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors"
                    >
                        <flux:icon.x-circle class="w-5 h-5" />
                        <span>Rejected</span>
                    </button>
                </div>
            </div>
        </div>
    </flux:modal>

    <!-- Daily Panasonic Detail Modal -->
    <flux:modal wire:model="showDailyPanasonicModal" class="max-w-4xl">
        <div class="space-y-4">
            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 pb-3 sticky top-0 bg-white dark:bg-zinc-900 z-10">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Daily Panasonic Inspection Details
                </h3>
                <flux:button wire:click="closePanasonicDetailModal" icon="x-mark" variant="subtle" size="sm" />
            </div>
            
            @if($selectedDailyPanasonic)
            <div class="space-y-4 max-h-[75vh] overflow-y-auto px-1 pb-4">
                <!-- Header Info -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 rounded-lg">
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Line Number</label>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $selectedDailyPanasonic->masterLine->line_number ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Group</label>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $selectedDailyPanasonic->group ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Status</label>
                        <p class="text-sm">
                            @php
                                $panasonicStatusColors = [
                                    'Checked' => 'text-green-600',
                                    'On Progress' => 'text-yellow-600',
                                    'Delay' => 'text-red-600',
                                    'Holiday' => 'text-gray-600',
                                ];
                            @endphp
                            <span class="font-semibold {{ $panasonicStatusColors[$selectedDailyPanasonic->status] ?? 'text-zinc-600' }}">
                                {{ $selectedDailyPanasonic->status }}
                            </span>
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Approval</label>
                        <p class="text-sm font-semibold">
                            @php
                                $panasonicApprovalColors = [
                                    'Approved' => 'text-green-600',
                                    'Rejected' => 'text-red-600',
                                    'Pending' => 'text-yellow-600',
                                ];
                            @endphp
                            <span class="{{ $panasonicApprovalColors[$selectedDailyPanasonic->approval] ?? 'text-zinc-600' }}">
                                {{ $selectedDailyPanasonic->approval ?? 'Pending' }}
                            </span>
                        </p>
                    </div>
                </div>

                <!-- Overall Status -->
                <div class="p-4 rounded-lg {{ $selectedDailyPanasonic->overall_status === 'success' ? 'bg-green-50 dark:bg-green-950/30 border border-green-200 dark:border-green-800' : 'bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800' }}">
                    <div class="flex items-center gap-2">
                        @if($selectedDailyPanasonic->overall_status === 'success')
                            <flux:icon.check-circle class="w-6 h-6 text-green-600" />
                        @else
                            <flux:icon.x-circle class="w-6 h-6 text-red-600" />
                        @endif
                        <span class="font-semibold {{ $selectedDailyPanasonic->overall_status === 'success' ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                            {{ $selectedDailyPanasonic->overall_status_text }}
                        </span>
                    </div>
                </div>

                @php
                    // Helper function to check if field is empty
                    function isPanasonicFieldEmpty($value) {
                        return $value === null || $value === '';
                    }
                    
                    // Helper function to check if step has incomplete fields
                    function isPanasonicStepIncomplete($dailyPanasonic, $stepFields) {
                        foreach ($stepFields as $field) {
                            $value = $dailyPanasonic->{$field};
                            if (isPanasonicFieldEmpty($value)) {
                                return true;
                            }
                        }
                        return false;
                    }
                    
                    // Helper function to get field color class
                    // PERBAIKAN: Nilai '-' dianggap valid (warna hijau)
                    function getPanasonicFieldColorClass($value) {
                        // Nilai '-' dianggap valid
                        if ($value === '-') {
                            return 'text-green-600';
                        }
                        return isPanasonicFieldEmpty($value) ? 'text-red-600' : 'text-green-600';
                    }
                @endphp

                <!-- STEP 1: GENERAL -->
                @php
                    $step1Fields = ['body_cover'];
                    $step1Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step1Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step1Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step1Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step1Incomplete ? 'text-red-600' : 'text-blue-600' }}">1</span>
                                <h4 class="font-semibold {{ $step1Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">GENERAL</h4>
                            </div>
                            @if($step1Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Body Cover</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure all machine cover clean</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->body_cover) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->body_cover ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: LOADER -->
                @php
                    $step2Fields = ['cylinder', 'rail_and_magazine_pcb', 'cover_magazine'];
                    $step2Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step2Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step2Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step2Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step2Incomplete ? 'text-red-600' : 'text-blue-600' }}">2</span>
                                <h4 class="font-semibold {{ $step2Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">LOADER</h4>
                            </div>
                            @if($step2Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cylinder (1)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Operation And center</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Smooth and center</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->cylinder) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->cylinder ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Rail & Magazine PCB (1.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning Dust and dirty</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->rail_and_magazine_pcb) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->rail_and_magazine_pcb ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cover Magazine (1.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning Dust and dirty</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->cover_magazine) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->cover_magazine ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: PCB CLEANER -->
                @php
                    $step3Fields = ['brush', 'air_presure', 'vacume_presure_unitech', 'vacume_presure_nix', 'vacume_brush', 'cleaning_roller', 'ionizer', 'conveyor_speed'];
                    $step3Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step3Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step3Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step3Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step3Incomplete ? 'text-red-600' : 'text-blue-600' }}">3</span>
                                <h4 class="font-semibold {{ $step3Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">PCB CLEANER</h4>
                            </div>
                            @if($step3Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Brush (2)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning touch PCB</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Rotation</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->brush) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->brush ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure (2.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.45 - 0.54 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->air_presure) }}">
                                    Value : {{ $selectedDailyPanasonic->air_presure ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vacume Pressure Unitech (2.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.45 - 0.54 Mpa (Unitech only)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vacume_presure_unitech) }}">
                                    Value : {{ $selectedDailyPanasonic->vacume_presure_unitech ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vacume Pressure Nix (2.c)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.60 - 0.70 Mpa (N.I.X only)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vacume_presure_nix) }}">
                                    Value : {{ $selectedDailyPanasonic->vacume_presure_nix ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vacume Brush (3)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Operation</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Rotation</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vacume_brush) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->vacume_brush ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cleaning Roller (4)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Rotation and Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Smooth rotation & Clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->cleaning_roller) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->cleaning_roller ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Ionizer (5)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 5 Times to push cleaner</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->ionizer) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->ionizer ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Conveyor Setting (6)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Analog panel (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 40</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->conveyor_speed) }}">
                                    Value : {{ $selectedDailyPanasonic->conveyor_speed ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 4: PRINTING -->
                @php
                    $step4Fields = ['ipa_solvent', 'temperature_control_1', 'humidity_control_1', 'clamp_presure_sp_60', 'clamp_presure_spg_2', 'squeege_sp_60', 'squeege_spg_2', 'cleaning_solvent', 'air_presure_meter'];
                    $step4Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step4Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step4Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step4Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step4Incomplete ? 'text-red-600' : 'text-blue-600' }}">4</span>
                                <h4 class="font-semibold {{ $step4Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">PRINTING</h4>
                            </div>
                            @if($step4Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">IPA Solvent (7)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure solvent minimal on mid level (half)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Tank Minimal half</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->ipa_solvent) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->ipa_solvent ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Temperature Control (8)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Result-01</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 23-27℃</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->temperature_control_1) }}">
                                    Value : {{ $selectedDailyPanasonic->temperature_control_1 ?? '-' }} ℃
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Humidity Control (8.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Result-01</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 35 % - 70 %</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->humidity_control_1) }}">
                                    Value : {{ $selectedDailyPanasonic->humidity_control_1 ?? '-' }} %
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Clamp Pressure SP-60 (9)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.20 ~ 0.4 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->clamp_presure_sp_60) }}">
                                    Value : {{ $selectedDailyPanasonic->clamp_presure_sp_60 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Clamp Pressure SPG-2 (9)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.20 ~ 0.4 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->clamp_presure_spg_2) }}">
                                    Value : {{ $selectedDailyPanasonic->clamp_presure_spg_2 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Squeege SP-60 (10)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.19 ~ 0.21 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->squeege_sp_60) }}">
                                    Value : {{ $selectedDailyPanasonic->squeege_sp_60 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Squeege SPG-2 (10)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.11 ~ 0.13 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->squeege_spg_2) }}">
                                    Value : {{ $selectedDailyPanasonic->squeege_spg_2 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cleaning Solvent (11)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.19 ~ 0.21 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->cleaning_solvent) }}">
                                    Value : {{ $selectedDailyPanasonic->cleaning_solvent ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure Meter (12)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.50~ 0.55 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->air_presure_meter) }}">
                                    Value : {{ $selectedDailyPanasonic->air_presure_meter ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 5: SPI -->
                @php
                    $step5Fields = ['air_presure_meter_parmi', 'capability_index'];
                    $step5Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step5Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step5Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step5Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step5Incomplete ? 'text-red-600' : 'text-blue-600' }}">5</span>
                                <h4 class="font-semibold {{ $step5Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">SPI</h4>
                            </div>
                            @if($step5Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure Meter Parmi (12.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.40 - 0.50 Mpa (PARMI)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->air_presure_meter_parmi) }}">
                                    Value : {{ $selectedDailyPanasonic->air_presure_meter_parmi ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Capability Index (12.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check SPI Measurement result with Master Jig (Solder Paste height) (write CpK value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : CpK for Masspro > 1.33</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->capability_index) }}">
                                    Value : {{ $selectedDailyPanasonic->capability_index ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 6: CHIP MOUNTER 1 -->
                @php
                    $step6Fields = ['air_presure_supply', 'vaccuum_pump', 'box', 'vaccuum_parameter', 'expire_date'];
                    $step6Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step6Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step6Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step6Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step6Incomplete ? 'text-red-600' : 'text-blue-600' }}">6</span>
                                <h4 class="font-semibold {{ $step6Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">CHIP MOUNTER 1</h4>
                            </div>
                            @if($step6Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure Supply (13)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.49 ~ 0.54 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->air_presure_supply) }}">
                                    Value : {{ $selectedDailyPanasonic->air_presure_supply ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Pump (13.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -87 ~ -100 Kpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vaccuum_pump) }}">
                                    Value : {{ $selectedDailyPanasonic->vaccuum_pump ?? '-' }} Kpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Box (13.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Chip collection</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No components</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->box) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->box ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Parameter (13.c)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with machine parameter result</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Yellow initial (display)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vaccuum_parameter) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->vaccuum_parameter ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Expire Date (14)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure due date on the label</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Expired</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->expire_date) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->expire_date ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 7: CHIP MOUNTER 2 -->
                @php
                    $step7Fields = ['air_presure_supply_2', 'vaccuum_pump_2', 'box_2', 'vaccuum_parameter_2', 'expire_date_2'];
                    $step7Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step7Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step7Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step7Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step7Incomplete ? 'text-red-600' : 'text-blue-600' }}">7</span>
                                <h4 class="font-semibold {{ $step7Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">CHIP MOUNTER 2</h4>
                            </div>
                            @if($step7Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure Supply (15)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.49 ~ 0.54 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->air_presure_supply_2) }}">
                                    Value : {{ $selectedDailyPanasonic->air_presure_supply_2 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Pump (15.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -87 ~ -100 Kpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vaccuum_pump_2) }}">
                                    Value : {{ $selectedDailyPanasonic->vaccuum_pump_2 ?? '-' }} Kpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Box (15.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Chip collection</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No components</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->box_2) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->box_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Parameter (15.c)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with machine parameter result</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Yellow initial (display)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vaccuum_parameter_2) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->vaccuum_parameter_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Expire Date (16)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Make sure due date on the label</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Expired</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->expire_date_2) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->expire_date_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 8: REFLOW -->
                @php
                    $step8Fields = ['abandonment', 'fire_posibilty', 'rail_and_transfer_unit', 'n2_presure', 'oxygent_density_sek', 'oxygent_density_special', 'fire_posibilty_2'];
                    $step8Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step8Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step8Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step8Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step8Incomplete ? 'text-red-600' : 'text-blue-600' }}">8</span>
                                <h4 class="font-semibold {{ $step8Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">REFLOW</h4>
                            </div>
                            @if($step8Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Abandonment (17)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Damage</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Damage</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->abandonment) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->abandonment ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Fire Possibility (17.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : PCB input area No paper,plastic</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Paper, No plastic</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->fire_posibilty) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->fire_posibilty ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Rail & Transfer Unit (18)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : make sure it is smooth condition</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No jammed</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->rail_and_transfer_unit) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->rail_and_transfer_unit ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">N2 Pressure (19)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check N2 Pressure</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.4MPa ~ 0.5MPa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->n2_presure) }}">
                                    Value : {{ $selectedDailyPanasonic->n2_presure ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Oxygen Density SEK (20)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Oxygen meter (SEK Standard)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 1200~1800 ppm</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->oxygent_density_sek) }}">
                                    Value : {{ $selectedDailyPanasonic->oxygent_density_sek ?? '-' }} ppm
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Oxygen Density Special (20)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Oxygen meter (Special Requirement)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 500~1000 ppm</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->oxygent_density_special) }}">
                                    Value : {{ $selectedDailyPanasonic->oxygent_density_special ?? '-' }} ppm
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Fire Possibility (20.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : PCB Output area No paper,plastic</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Paper, No plastic</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->fire_posibilty_2) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->fire_posibilty_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 9: AOI -->
                @php
                    $step9Fields = ['air_presure_2'];
                    $step9Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step9Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step9Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step9Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step9Incomplete ? 'text-red-600' : 'text-blue-600' }}">9</span>
                                <h4 class="font-semibold {{ $step9Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">AOI</h4>
                            </div>
                            @if($step9Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure (20.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.40 - 0.50 Mpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->air_presure_2) }}">
                                    Value : {{ $selectedDailyPanasonic->air_presure_2 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 10: UNLOADER -->
                @php
                    $step10Fields = ['cylinder_2', 'rail_and_magazine_pcb_2', 'cover_magazine_2'];
                    $step10Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step10Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step10Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step10Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step10Incomplete ? 'text-red-600' : 'text-blue-600' }}">10</span>
                                <h4 class="font-semibold {{ $step10Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">UNLOADER</h4>
                            </div>
                            @if($step10Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cylinder (21)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Operation And center</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Smooth and center</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->cylinder_2) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->cylinder_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Rail & Magazine PCB (21.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning Dust and dirty</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->rail_and_magazine_pcb_2) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->rail_and_magazine_pcb_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Cover Magazine (21.b)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning Dust and dirty</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No Dust and clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->cover_magazine_2) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->cover_magazine_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 11: AOI TABLE -->
                @php
                    $step11Fields = ['angle_and_filter', 'lamp_indicator'];
                    $step11Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step11Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step11Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step11Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step11Incomplete ? 'text-red-600' : 'text-blue-600' }}">11</span>
                                <h4 class="font-semibold {{ $step11Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">AOI TABLE</h4>
                            </div>
                            @if($step11Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Angle & Filter (22)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No dirt / no dust</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->angle_and_filter) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->angle_and_filter ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Lamp Indicator (22.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : LED Lamp (Green)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Function</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->lamp_indicator) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->lamp_indicator ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 12: REFLOW 2 -->
                @php
                    $step12Fields = ['temperature_chiller', 'temperature_control_3'];
                    $step12Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step12Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step12Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step12Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step12Incomplete ? 'text-red-600' : 'text-blue-600' }}">12</span>
                                <h4 class="font-semibold {{ $step12Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">REFLOW 2</h4>
                            </div>
                            @if($step12Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Temperature Chiller (23)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Write down the value</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 17-23℃</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->temperature_chiller) }}">
                                    Value : {{ $selectedDailyPanasonic->temperature_chiller ?? '-' }} ℃
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Temperature Control (24)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check Value inspect</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 300℃ ±10℃</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->temperature_control_3) }}">
                                    Value : {{ $selectedDailyPanasonic->temperature_control_3 ?? '-' }} ℃
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 13: CHIP MOUNTER 3 -->
                @php
                    $step13Fields = ['box_3', 'vaccuum_pump_3'];
                    $step13Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step13Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step13Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step13Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step13Incomplete ? 'text-red-600' : 'text-blue-600' }}">13</span>
                                <h4 class="font-semibold {{ $step13Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">CHIP MOUNTER 3</h4>
                            </div>
                            @if($step13Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Box (25)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Chip collection</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No components</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->box_3) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->box_3 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Pump (25.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -87 ~ -100 Kpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vaccuum_pump_3) }}">
                                    Value : {{ $selectedDailyPanasonic->vaccuum_pump_3 ?? '-' }} Kpa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 14: CHIP MOUNTER 4 -->
                @php
                    $step14Fields = ['box_4', 'vaccuum_pump_4'];
                    $step14Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step14Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step14Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step14Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step14Incomplete ? 'text-red-600' : 'text-blue-600' }}">14</span>
                                <h4 class="font-semibold {{ $step14Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">CHIP MOUNTER 4</h4>
                            </div>
                            @if($step14Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Box (26)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Chip collection</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No components</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->box_4) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->box_4 ?? '-') }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Vaccuum Pump (26.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -87 ~ -100 Kpa</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->vaccuum_pump_4) }}">
                                    Value : {{ $selectedDailyPanasonic->vaccuum_pump_4 ?? '-' }} Kpa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 15: SPI 2 -->
                @php
                    $step15Fields = ['air_presure_3'];
                    $step15Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step15Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step15Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step15Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step15Incomplete ? 'text-red-600' : 'text-blue-600' }}">15</span>
                                <h4 class="font-semibold {{ $step15Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">SPI 2</h4>
                            </div>
                            @if($step15Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Air Pressure (27)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Check with Pressure Meter (write value)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 0.40 - 0.50 Mpa (Kohyoung)</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->air_presure_3) }}">
                                    Value : {{ $selectedDailyPanasonic->air_presure_3 ?? '-' }} Mpa
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 16: PRINTER -->
                @php
                    $step16Fields = ['temperature_control_4', 'water_reservoirs'];
                    $step16Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step16Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step16Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step16Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step16Incomplete ? 'text-red-600' : 'text-blue-600' }}">16</span>
                                <h4 class="font-semibold {{ $step16Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">PRINTER</h4>
                            </div>
                            @if($step16Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Temperature Control (28)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Air cond Setting Temperature</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : 23-27℃</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->temperature_control_4) }}">
                                    Value : {{ $selectedDailyPanasonic->temperature_control_4 ?? '-' }} ℃
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Water Reservoirs (28.a)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Damage, Function</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Function, No Damage</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->water_reservoirs) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->water_reservoirs ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 17: PCB CLEANER 2 -->
                @php
                    $step17Fields = ['filter'];
                    $step17Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step17Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step17Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step17Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step17Incomplete ? 'text-red-600' : 'text-blue-600' }}">17</span>
                                <h4 class="font-semibold {{ $step17Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">PCB CLEANER 2</h4>
                            </div>
                            @if($step17Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Filter (29)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : Clean</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->filter) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->filter ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 18: IONIZER -->
                @php
                    $step18Fields = ['angle_and_filter_2'];
                    $step18Incomplete = isPanasonicStepIncomplete($selectedDailyPanasonic, $step18Fields);
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $step18Incomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $step18Incomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $step18Incomplete ? 'text-red-600' : 'text-blue-600' }}">18</span>
                                <h4 class="font-semibold {{ $step18Incomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">IONIZER</h4>
                            </div>
                            @if($step18Incomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Angle & Filter (30)</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : Cleaning</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : No dirt / no dust</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->angle_and_filter_2) }}">
                                    Value : {{ ucfirst($selectedDailyPanasonic->angle_and_filter_2 ?? '-') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TIME & STATUS -->
                @php
                    $stepTimeFields = ['run_time', 'group'];
                    $stepTimeIncomplete = false;
                    foreach ($stepTimeFields as $field) {
                        if (isPanasonicFieldEmpty($selectedDailyPanasonic->{$field})) {
                            $stepTimeIncomplete = true;
                            break;
                        }
                    }
                @endphp
                <div class="border rounded-lg overflow-hidden {{ $stepTimeIncomplete ? 'border-red-500 dark:border-red-500' : 'border-zinc-200 dark:border-zinc-700' }}">
                    <div class="{{ $stepTimeIncomplete ? 'bg-red-100 dark:bg-red-900/50' : 'bg-blue-100 dark:bg-blue-900/30' }} px-4 py-3">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold {{ $stepTimeIncomplete ? 'text-red-600' : 'text-blue-600' }}">19</span>
                                <h4 class="font-semibold {{ $stepTimeIncomplete ? 'text-red-800 dark:text-red-300' : 'text-blue-800 dark:text-blue-300' }}">TIME & STATUS</h4>
                            </div>
                            @if($stepTimeIncomplete)
                                <flux:icon.x-circle class="w-5 h-5 text-red-600" />
                            @else
                                <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                            @endif
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Stop Time</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : -</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ isPanasonicFieldEmpty($selectedDailyPanasonic->stop_time) ? 'text-red-600' : 'text-green-600' }}">
                                    Value : {{ $selectedDailyPanasonic->stop_time ? $selectedDailyPanasonic->stop_time->format('H:i') : '-' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Run Time</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : -</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : -</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->run_time) }}">
                                    Value : {{ $selectedDailyPanasonic->run_time ? $selectedDailyPanasonic->run_time->format('H:i') : '-' }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <p class="font-medium text-zinc-800 dark:text-white">Group</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Details On Check : -</p>
                                <p class="text-sm text-zinc-600 dark:text-zinc-400">Standard : A, B, or C</p>
                            </div>
                            <div class="text-right ml-4">
                                <span class="text-sm font-semibold {{ getPanasonicFieldColorClass($selectedDailyPanasonic->group) }}">
                                    Value : {{ $selectedDailyPanasonic->group ?? '-' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Info -->
                <div class="p-4 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-900/50 dark:to-gray-800/50 rounded-lg text-xs text-zinc-500 space-y-1">
                    <div><span class="font-medium">Created:</span> {{ $selectedDailyPanasonic->created_at->format('d/m/Y H:i:s') }} by {{ $selectedDailyPanasonic->creator->name ?? 'System' }}</div>
                    <div><span class="font-medium">Last Updated:</span> {{ $selectedDailyPanasonic->updated_at->format('d/m/Y H:i:s') }} by {{ $selectedDailyPanasonic->updater->name ?? '-' }}</div>
                    @if($selectedDailyPanasonic->approved_by)
                    <div><span class="font-medium">Approved:</span> {{ $selectedDailyPanasonic->updated_at->format('d/m/Y H:i:s') }} by {{ $selectedDailyPanasonic->approvedBy->name ?? '-' }}</div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </flux:modal>

    <!-- Panasonic Approval Modal -->
    <flux:modal wire:model="showPanasonicApprovalModal" class="max-w-md">
        <div class="space-y-4">
            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 pb-3">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    Update Approval Status (Panasonic)
                </h3>
                <flux:button 
                    wire:click="closePanasonicApprovalModal" 
                    icon="x-mark" 
                    variant="subtle"
                    size="sm"
                />
            </div>
            
            <div class="space-y-4">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Set approval status for Panasonic inspection record.
                </p>
                
                <div class="flex gap-4 justify-center">
                    <button 
                        wire:click="setPanasonicApproval('Approved')"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors"
                    >
                        <flux:icon.check-circle class="w-5 h-5" />
                        <span>Approved</span>
                    </button>
                    <button 
                        wire:click="setPanasonicApproval('Rejected')"
                        class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 rounded-lg bg-red-600 text-white hover:bg-red-700 transition-colors"
                    >
                        <flux:icon.x-circle class="w-5 h-5" />
                        <span>Rejected</span>
                    </button>
                </div>
            </div>
        </div>
    </flux:modal>
    
</section>