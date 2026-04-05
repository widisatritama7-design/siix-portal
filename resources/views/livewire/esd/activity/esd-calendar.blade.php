<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge - Event Calendar') }}
    </flux:heading>

    <x-esd.layout class="!max-w-full !px-0 !mx-0">
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Maintenance
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        ESD
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Calendar
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h1 class="text-xl sm:text-2xl font-bold text-zinc-800 dark:text-white">
                            ESD Measurement Schedule
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-0.5">
                            Control And Monitor Your ESD Schedule
                        </p>
                    </div>
                    <!-- TOMBOL REFRESH ALL -->
                    <div>
                        <button wire:click="refreshAllCards"
                            wire:loading.attr="disabled"
                            wire:target="refreshAllCards"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white text-xs sm:text-sm font-semibold py-2 px-4 rounded-full transition-all duration-200 hover:scale-105 shadow-md">
                            <!-- Icon normal (tidak loading) -->
                            <svg wire:loading.remove wire:target="refreshAllCards" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                            </svg>
                            <!-- Icon loading (sama tapi diputer) -->
                            <svg wire:loading wire:target="refreshAllCards" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 animate-spin">
                                <path fill-rule="evenodd" d="M4.755 10.059a7.5 7.5 0 0 1 12.548-3.364l1.903 1.903h-3.183a.75.75 0 1 0 0 1.5h4.992a.75.75 0 0 0 .75-.75V4.356a.75.75 0 0 0-1.5 0v3.18l-1.9-1.9A9 9 0 0 0 3.306 9.67a.75.75 0 1 0 1.45.388Zm15.408 3.352a.75.75 0 0 0-.919.53 7.5 7.5 0 0 1-12.548 3.364l-1.902-1.903h3.183a.75.75 0 0 0 0-1.5H2.984a.75.75 0 0 0-.75.75v4.992a.75.75 0 0 0 1.5 0v-3.18l1.9 1.9a9 9 0 0 0 15.059-4.035.75.75 0 0 0-.53-.918Z" clip-rule="evenodd" />
                            </svg>
                            <span wire:loading.remove wire:target="refreshAllCards">Refresh All</span>
                            <span wire:loading wire:target="refreshAllCards">Refreshing...</span>
                        </button>
                    </div>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <!-- Grid auto-fill dengan card ukuran sedang -->
            <div class="grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1rem;">
                @foreach($sortedTypes as $type)
                <div class="bg-white dark:bg-zinc-800 rounded-2xl shadow-md border border-zinc-200 dark:border-zinc-700 p-3.5 hover:shadow-lg transition-all duration-300">
                    
                    <!-- Navigation dengan Icon SVG -->
                    <div class="flex justify-between items-center mb-3">
                        <button wire:click="goToPrevMonth('{{ $type }}')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white p-1.5 rounded-full transition-all duration-200 hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        <span class="font-semibold text-gray-800 dark:text-white text-xs sm:text-sm text-center truncate mx-1">
                            {{ $this->getMonthName($type) }}
                        </span>
                        <button wire:click="goToNextMonth('{{ $type }}')" 
                                class="bg-blue-600 hover:bg-blue-700 text-white p-1.5 rounded-full transition-all duration-200 hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <!-- Badges - rounded-full -->
                    <div class="mb-3">
                        @if(($typeCodes[$type] ?? '-') !== '-')
                            <div class="bg-gradient-to-r from-purple-600 to-purple-800 text-white py-1.5 px-3 rounded-full text-[11px] sm:text-xs font-bold text-center truncate shadow-sm">
                                {{ $typeCodes[$type] }}
                            </div>
                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-1 px-3 rounded-full text-[10px] sm:text-[11px] font-bold text-center mt-1.5 truncate shadow-sm">
                                {{ $displayNames[$type] }}
                            </div>
                        @else
                            <div class="bg-gray-500 text-white py-1.5 px-3 rounded-full text-[11px] sm:text-xs font-bold text-center shadow-sm">
                                -
                            </div>
                            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white py-1 px-3 rounded-full text-[10px] sm:text-[11px] font-bold text-center mt-1.5 truncate shadow-sm">
                                {{ $displayNames[$type] }}
                            </div>
                        @endif
                    </div>

                    <!-- Calendar Table -->
                    <div>
                        <table class="w-full">
                            <thead>
                                <tr>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">S</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">M</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">T</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">W</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">T</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">F</th>
                                    <th class="text-gray-500 dark:text-gray-400 text-[10px] sm:text-xs py-1 text-center font-medium">S</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($this->getCalendarWeeks($type) as $week)
                                <tr>
                                    @foreach($week as $day)
                                        @if($day)
                                            @php
                                                $eventCount = $this->getEventCount($type, $day['date']);
                                                $badgeColor = $this->getBadgeColor($type, $day['date']);
                                                $displayCount = $eventCount > 99 ? '99+' : $eventCount;
                                            @endphp
                                            <td class="p-0.5 text-center align-middle">
                                                <button wire:click="selectDate('{{ $type }}', '{{ $day['date'] }}')"
                                                        class="relative w-full py-1.5 rounded-xl transition-all duration-200 text-xs sm:text-sm font-semibold
                                                        {{ $day['isSelected'] ? 'bg-blue-600 text-white shadow-md scale-95' : 'bg-gray-100 dark:bg-zinc-700 text-gray-800 dark:text-white hover:bg-gray-200 dark:hover:bg-zinc-600 hover:scale-95' }}">
                                                    {{ $day['day'] }}
                                                    
                                                    @if($eventCount > 0)
                                                        <span class="absolute -top-1 -right-1 text-white text-[9px] sm:text-[10px] rounded-full min-w-[16px] h-4 flex items-center justify-center font-bold shadow-md
                                                            {{ $badgeColor == 'green' ? 'bg-green-600' : ($badgeColor == 'yellow' ? 'bg-yellow-500' : 'bg-red-600') }}
                                                            px-0.5">
                                                            {{ $displayCount }}
                                                        </span>
                                                    @endif
                                                </button>
                                            </button>
                                        </td>
                                        @else
                                            <td class="p-0.5">
                                                <div class="w-full py-1.5"></div>
                                            </td>
                                        @endif
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Event List - Scroll hanya di sini -->
                    <div class="mt-3">
                        <div class="max-h-[130px] overflow-y-auto space-y-1.5 pr-0.5">
                            @php
                                $selectedDateForCard = $selectedDate[$type] ?? date('Y-m-d');
                                $dayEvents = $this->getEventsForDate($type, $selectedDateForCard);
                            @endphp
                            
                            @if(count($dayEvents) === 0)
                                <div class="text-center text-gray-400 text-[10px] sm:text-xs py-2 bg-gray-50 dark:bg-zinc-800/50 rounded-xl">
                                    No events
                                </div>
                            @else
                                @foreach($dayEvents as $event)
                                    @php
                                        $detailUrl = $this->getDetailUrl($type, $event['detail_foreign_key']);
                                    @endphp
                                    <a href="{{ $detailUrl }}" 
                                       target="_blank"
                                       class="block transition-all duration-200 hover:translate-x-0.5">
                                        <div class="flex items-center justify-between p-1.5 rounded-xl text-[10px] sm:text-xs
                                            {{ $event['hasActual'] ? 'bg-green-50 dark:bg-green-900/20 border-l-2 border-green-500' : 'bg-red-50 dark:bg-red-900/20 border-l-2 border-red-500' }}">
                                            <span class="flex-1 truncate mr-1 font-medium">{{ $event['title'] }}</span>
                                            <span class="font-bold flex-shrink-0 text-[11px] sm:text-xs">{{ $event['hasActual'] ? '✓' : '✗' }}</span>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </x-esd.layout>
</section>

@push('styles')
<style>
    /* Fully responsive grid - auto adjust */
    .grid {
        display: grid !important;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)) !important;
        gap: 1rem !important;
    }
    
    /* Card styling */
    .rounded-2xl {
        border-radius: 1rem !important;
    }
    
    /* Hover effect card */
    .bg-white, .dark\:bg-zinc-800 {
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    .bg-white:hover, .dark\:bg-zinc-800:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.02);
    }
    
    /* Button rounded full */
    button {
        border-radius: 9999px !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Badge timbul */
    .absolute {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        z-index: 10;
    }
    
    /* Table spacing */
    table {
        border-collapse: separate;
        border-spacing: 3px;
        width: 100%;
    }
    
    /* Scroll hanya untuk event list */
    .overflow-y-auto {
        overflow-y: auto;
        scrollbar-width: thin;
    }
    
    .overflow-y-auto::-webkit-scrollbar {
        width: 4px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-track {
        background: #e2e8f0;
        border-radius: 10px;
    }
    
    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 10px;
    }
    
    .dark .overflow-y-auto::-webkit-scrollbar-track {
        background: #1e293b;
    }
    
    .dark .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #475569;
    }
    
    /* Truncate */
    .truncate {
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    
    /* Animasi spin */
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
    .animate-spin {
        animation: spin 1s linear infinite;
    }
    
    /* Responsive */
    @media (max-width: 640px) {
        .grid {
            gap: 0.75rem !important;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)) !important;
        }
        table {
            border-spacing: 2px;
        }
    }
    
    /* Animasi klik */
    button:active {
        transform: scale(0.96);
    }
</style>
@endpush