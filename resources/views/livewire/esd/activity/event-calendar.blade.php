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
                        Event
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                            Event Calendar
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Manage ESD events and activities
                        </p>
                    </div>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <div class="flex flex-col lg:flex-row gap-4 sm:gap-6 w-full">
                <!-- Calendar Container -->
                <div class="lg:w-2/5 w-full bg-white dark:bg-zinc-800 rounded-2xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-3 sm:p-4 md:p-5 transition-all duration-300">
                    <!-- Calendar Navigation -->
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <button wire:click="goToPrevMonth" 
                                class="p-1.5 sm:p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 shadow-sm hover:scale-105 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                        
                        <span class="font-semibold text-gray-800 dark:text-white text-base sm:text-lg transition-opacity duration-300" 
                            x-data="{ month: '{{ $currentMonthName }}' }" 
                            x-text="month">{{ $currentMonthName }}</span>
                        
                        <button wire:click="goToNextMonth" 
                                class="p-1.5 sm:p-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-all duration-300 shadow-sm hover:scale-105 active:scale-95">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 sm:w-5 sm:h-5">
                                <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm4.28 10.28a.75.75 0 0 0 0-1.06l-3-3a.75.75 0 1 0-1.06 1.06l1.72 1.72H8.25a.75.75 0 0 0 0 1.5h5.69l-1.72 1.72a.75.75 0 1 0 1.06 1.06l3-3Z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>

                    <!-- Calendar Grid - Responsive with dynamic height -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-separate border-spacing-0.5 sm:border-spacing-1">
                            <thead>
                                <tr>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Sun</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Mon</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Tue</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Wed</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Thu</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Fri</th>
                                    <th class="text-gray-500 dark:text-gray-400 font-medium text-[10px] sm:text-xs pb-1 sm:pb-2 text-center">Sat</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($calendarWeeks as $week)
                                <tr>
                                    @foreach($week as $day)
                                    @php
                                        // Tentukan weekend: Sabtu dan Minggu
                                        $isWeekend = \Carbon\Carbon::parse($day['date'])->isWeekend();
                                    @endphp
                                    <td class="p-0.5 sm:p-1 text-center relative">
                                        @if($day['isCurrentMonth'])
                                            <button wire:click="selectDate('{{ $day['date'] }}')"
                                                class="w-full aspect-square rounded-lg transition-all duration-300 hover:scale-95 active:scale-90 flex flex-col items-center justify-center text-[11px] sm:text-sm
                                                {{ $day['isSelected'] ? 'bg-blue-600 text-white font-bold shadow-md transform scale-95' : 
                                                ($isWeekend ? 'bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 hover:bg-red-200 dark:hover:bg-red-800/50' : 
                                                'bg-blue-50 dark:bg-blue-950/30 text-gray-800 dark:text-white hover:bg-blue-100 dark:hover:bg-blue-900/50') }}">
                                                
                                                <span class="text-[11px] sm:text-sm">{{ $day['day'] }}</span>
                                            </button>
                                            
                                            @if($day['eventCount'] > 0)
                                                <span class="absolute -top-1 -right-1 text-white text-[10px] sm:text-xs rounded-full w-4 h-4 sm:w-5 sm:h-5 flex items-center justify-center font-bold shadow-md transition-all duration-200
                                                    {{ $day['badgeColor'] == 'green' ? 'bg-green-600' : 
                                                    ($day['badgeColor'] == 'red' ? 'bg-red-600' : 'bg-yellow-600') }}">
                                                    {{ $day['eventCount'] }}
                                                </span>
                                            @endif
                                        @else
                                            <div class="w-full aspect-square"></div>
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Event Panel -->
                <div class="lg:w-3/5 w-full bg-white dark:bg-zinc-800 rounded-2xl shadow-lg border border-zinc-200 dark:border-zinc-700 p-3 sm:p-4 md:p-5 h-fit transition-all duration-300">
                    <!-- Header -->
                    <div class="flex items-center justify-between pb-3 border-b border-zinc-200 dark:border-zinc-700">
                        <h2 class="text-sm sm:text-base font-semibold text-gray-800 dark:text-white flex items-center gap-2">
                            <span class="w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                            Event Calendar
                        </h2>
                        <button wire:click="loadEvents" 
                                class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-3 py-1 sm:py-1.5 bg-gray-50 dark:bg-zinc-700 hover:bg-gray-100 dark:hover:bg-zinc-600 text-gray-600 dark:text-gray-300 rounded-lg transition-all duration-200 text-[11px] sm:text-xs font-medium border border-zinc-200 dark:border-zinc-600 hover:scale-105 active:scale-95">
                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                            </svg>
                            <span class="hidden xs:inline">Refresh</span>
                        </button>
                    </div>

                    <!-- Legend Badges -->
                    <div class="flex flex-wrap gap-2 sm:gap-4 py-2 sm:py-3">
                        <div class="flex items-center gap-1 sm:gap-1.5">
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-red-500 rounded-full"></span>
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Open</span>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-1.5">
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-yellow-500 rounded-full"></span>
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">On Progress</span>
                        </div>
                        <div class="flex items-center gap-1 sm:gap-1.5">
                            <span class="w-2 h-2 sm:w-2.5 sm:h-2.5 bg-green-500 rounded-full"></span>
                            <span class="text-[10px] sm:text-xs text-gray-600 dark:text-gray-400">Closed</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-2 mt-1 mb-3">
                        <h3 class="text-xs sm:text-sm font-semibold text-gray-800 dark:text-white flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            Events on <span class="text-blue-600 font-medium text-[11px] sm:text-xs">{{ $selectedDateFormatted }}</span>
                        </h3>
                        <button wire:click="openCreateModal" 
                                class="flex items-center gap-1 sm:gap-1.5 px-2 sm:px-3 py-1 sm:py-1.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg transition-all duration-300 text-[11px] sm:text-xs font-medium shadow-sm hover:scale-105 active:scale-95 whitespace-nowrap">
                            <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            New Event
                        </button>
                    </div>

                    <!-- Event List -->
                    <div class="event-list-container">
                        @if(count($selectedDateEvents) > 0)
                            <ul class="space-y-1.5 sm:space-y-2">
                                @foreach($selectedDateEvents as $event)
                                @php
                                    $colorClass = match($event['color']) {
                                        'red' => 'bg-red-100 border-l-4 border-red-600 hover:bg-red-200 text-red-900 dark:bg-red-900/30 dark:border-red-500 dark:text-red-300 dark:hover:bg-red-900/50',
                                        'yellow' => 'bg-yellow-100 border-l-4 border-yellow-600 hover:bg-yellow-200 text-yellow-900 dark:bg-yellow-900/30 dark:border-yellow-500 dark:text-yellow-300 dark:hover:bg-yellow-900/50',
                                        'green' => 'bg-green-100 border-l-4 border-green-600 hover:bg-green-200 text-green-900 dark:bg-green-900/30 dark:border-green-500 dark:text-green-300 dark:hover:bg-green-900/50',
                                        default => 'bg-gray-100 border-l-4 border-gray-600 hover:bg-gray-200 text-gray-900 dark:bg-gray-900/30 dark:border-gray-500 dark:text-gray-300 dark:hover:bg-gray-900/50',
                                    };
                                    
                                    // Decode file jika berupa string JSON
                                    $fileArray = [];
                                    if(isset($event['file'])) {
                                        if(is_string($event['file'])) {
                                            // Hapus backslash dari string JSON terlebih dahulu
                                            $cleanedString = stripslashes($event['file']);
                                            $fileArray = json_decode($cleanedString, true);
                                            if(json_last_error() !== JSON_ERROR_NONE) {
                                                $fileArray = is_array($event['file']) ? $event['file'] : [];
                                            }
                                        } elseif(is_array($event['file'])) {
                                            $fileArray = $event['file'];
                                        }
                                    }
                                    
                                    // Bersihkan setiap path file dari backslash
                                    $fileArray = array_map(function($file) {
                                        return stripslashes($file);
                                    }, $fileArray);
                                    
                                    // Filter hanya file gambar
                                    $imageFiles = array_filter($fileArray, function($file) {
                                        return preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
                                    });
                                    
                                    // Fungsi untuk mendapatkan URL file (handle kedua format)
                                    $getFileUrl = function($file) {
                                        // Bersihkan dari backslash terlebih dahulu
                                        $file = stripslashes($file);
                                        
                                        // Jika sudah mengandung 'events/' (tanpa backslash)
                                        if (str_contains($file, 'events/')) {
                                            return Storage::url($file);
                                        }
                                        // Jika hanya nama file, tambahkan folder 'events/'
                                        return Storage::url('events/' . $file);
                                    };
                                    
                                    // Ambil 2 gambar pertama untuk ditampilkan
                                    $displayImages = array_slice($imageFiles, 0, 2);
                                    $totalImages = count($imageFiles);
                                    $remainingImages = $totalImages - 2;
                                @endphp
                                <li class="p-2 sm:p-3 rounded-lg cursor-pointer {{ $colorClass }}" 
                                    wire:click="openEditModal({{ $event['id'] }})">
                                    <div class="flex items-center justify-between gap-2">
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-xs sm:text-sm font-medium truncate">{{ $event['title'] }}</h4>
                                            <p class="text-[10px] sm:text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                                {{ $event['start_time'] }} - {{ $event['end_time'] }}
                                            </p>
                                        </div>
                                        <div class="flex items-center gap-1 sm:gap-2 flex-shrink-0">
                                            @if($totalImages > 0)
                                                <div class="flex -space-x-2 sm:-space-x-3">
                                                    @foreach($displayImages as $imageFile)
                                                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full border-2 border-white dark:border-zinc-800 overflow-hidden bg-gray-200 dark:bg-zinc-700 shadow-sm">
                                                            <img src="{{ $getFileUrl($imageFile) }}" 
                                                                class="w-full h-full object-cover" 
                                                                alt="photo"
                                                                onerror="this.src='{{ asset('storage/default-image.png') }}'; this.onerror=null;">
                                                        </div>
                                                    @endforeach
                                                    @if($remainingImages > 0)
                                                        <div class="w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-blue-500 text-white text-[9px] sm:text-xs flex items-center justify-center font-medium border-2 border-white dark:border-zinc-800 shadow-sm">
                                                            +{{ $remainingImages }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 flex-shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="p-4 sm:p-6 text-center text-gray-400 dark:text-gray-500 bg-gray-50 dark:bg-zinc-800/50 rounded-lg border border-dashed border-gray-200 dark:border-zinc-700">
                                <svg class="w-8 h-8 sm:w-10 sm:h-10 mx-auto text-gray-300 dark:text-gray-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="text-[11px] sm:text-xs">No events scheduled for this day</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- MODAL FORM EVENT - Wizard Style -->
            <flux:modal wire:model="showModal" class="w-full max-w-3xl mx-4 sm:mx-auto">
                <div class="p-4 sm:p-6">
                    <!-- Wizard Header -->
                    <div class="mb-6">
                        <h2 class="text-lg sm:text-xl font-bold mb-4">{{ $modalTitle }}</h2>
                        
                        <!-- Progress Steps -->
                        <div class="flex items-center justify-between gap-2">
                            <button type="button" 
                                    wire:click="setWizardStep(1)" 
                                    class="flex-1 text-center transition-all duration-300 {{ $wizardStep >= 1 ? 'cursor-pointer' : 'cursor-not-allowed opacity-50' }}">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 
                                        {{ $wizardStep > 1 ? 'bg-green-500 text-white' : ($wizardStep >= 1 ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-zinc-700 text-gray-500') }}">
                                        {{ $wizardStep > 1 ? '✓' : '1' }}
                                    </div>
                                    <span class="text-xs sm:text-sm font-medium hidden sm:inline {{ $wizardStep >= 1 ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Basic Info</span>
                                </div>
                            </button>
                            <div class="flex-1 h-0.5 bg-gray-200 dark:bg-zinc-700 rounded">
                                <div class="h-0.5 bg-blue-600 rounded transition-all duration-500" style="width: {{ $wizardStep >= 2 ? '100%' : '0%' }}"></div>
                            </div>
                            <button type="button" 
                                    wire:click="setWizardStep(2)" 
                                    class="flex-1 text-center transition-all duration-300 {{ $wizardStep >= 2 ? 'cursor-pointer' : 'cursor-not-allowed opacity-50' }}">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 
                                        {{ $wizardStep > 2 ? 'bg-green-500 text-white' : ($wizardStep >= 2 ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-zinc-700 text-gray-500') }}">
                                        {{ $wizardStep > 2 ? '✓' : '2' }}
                                    </div>
                                    <span class="text-xs sm:text-sm font-medium hidden sm:inline {{ $wizardStep >= 2 ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Attachments</span>
                                </div>
                            </button>
                            <div class="flex-1 h-0.5 bg-gray-200 dark:bg-zinc-700 rounded">
                                <div class="h-0.5 bg-blue-600 rounded transition-all duration-500" style="width: {{ $wizardStep >= 3 ? '100%' : '0%' }}"></div>
                            </div>
                            <button type="button" 
                                    wire:click="setWizardStep(3)" 
                                    class="flex-1 text-center transition-all duration-300 {{ $wizardStep >= 3 ? 'cursor-pointer' : 'cursor-not-allowed opacity-50' }}">
                                <div class="flex items-center justify-center gap-2">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 
                                        {{ $wizardStep >= 3 ? 'bg-blue-600 text-white' : 'bg-gray-300 dark:bg-zinc-700 text-gray-500' }}">
                                        3
                                    </div>
                                    <span class="text-xs sm:text-sm font-medium hidden sm:inline {{ $wizardStep >= 3 ? 'text-gray-900 dark:text-white' : 'text-gray-400' }}">Review</span>
                                </div>
                            </button>
                        </div>
                    </div>

                    <form wire:submit="save">
                        <!-- STEP 1: Basic Info -->
                        <div x-show="$wire.wizardStep === 1" x-cloak>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                                <!-- Title -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs sm:text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="title" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Description -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs sm:text-sm font-medium mb-1">Description</label>
                                    <textarea wire:model="description" rows="3" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200"></textarea>
                                    @error('description') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Start Date & Time -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-1">Start Date <span class="text-red-500">*</span></label>
                                    <input type="date" wire:model="start_date" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    @error('start_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-1">Start Time <span class="text-red-500">*</span></label>
                                    <input type="time" wire:model="start_time" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    @error('start_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- End Date & Time -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-1">End Date <span class="text-red-500">*</span></label>
                                    <input type="date" wire:model="end_date" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    @error('end_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-1">End Time <span class="text-red-500">*</span></label>
                                    <input type="time" wire:model="end_time" class="w-full px-3 py-2 text-sm border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                    @error('end_time') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>

                                <!-- Status -->
                                <div class="md:col-span-2">
                                    <label class="block text-xs sm:text-sm font-medium mb-2">Status <span class="text-red-500">*</span></label>
                                    <div class="flex flex-wrap gap-3 sm:gap-4">
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model="color" value="red" class="w-4 h-4 text-red-600 focus:ring-red-500">
                                            <span class="w-5 h-5 rounded-full bg-red-500"></span>
                                            <span class="text-xs sm:text-sm font-medium text-red-700 dark:text-red-400">Open</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model="color" value="yellow" class="w-4 h-4 text-yellow-600 focus:ring-yellow-500">
                                            <span class="w-5 h-5 rounded-full bg-yellow-500"></span>
                                            <span class="text-xs sm:text-sm font-medium text-yellow-700 dark:text-yellow-400">On Progress</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2 cursor-pointer">
                                            <input type="radio" wire:model="color" value="green" class="w-4 h-4 text-green-600 focus:ring-green-500">
                                            <span class="w-5 h-5 rounded-full bg-green-500"></span>
                                            <span class="text-xs sm:text-sm font-medium text-green-700 dark:text-green-400">Closed</span>
                                        </label>
                                    </div>
                                    @error('color') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- STEP 2: Attachments -->
                        <div x-show="$wire.wizardStep === 2" x-cloak>
                            <div class="space-y-4">
                                <!-- Existing Files with Image Preview -->
                                @if($existing_file && count($existing_file) > 0)
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-2">Current Attachments ({{ count($existing_file) }})</label>
                                    <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                        @foreach($existing_file as $index => $file)
                                        @php
                                            $isImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
                                            $fileUrl = Storage::url($file);
                                        @endphp
                                        <div class="relative group">
                                            @if($isImage)
                                                <a href="{{ $fileUrl }}" 
                                                target="_blank" 
                                                rel="noopener noreferrer"
                                                class="block aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-zinc-800 border-2 border-gray-200 dark:border-zinc-700 hover:border-blue-500 transition-all duration-200">
                                                    <img src="{{ $fileUrl }}" 
                                                        class="w-full h-full object-cover"
                                                        alt="attachment">
                                                </a>
                                            @else
                                                <a href="{{ $fileUrl }}" 
                                                target="_blank" 
                                                rel="noopener noreferrer"
                                                class="block aspect-square rounded-lg bg-gray-100 dark:bg-zinc-800 border-2 border-gray-200 dark:border-zinc-700 flex flex-col items-center justify-center hover:border-blue-500 transition-all duration-200">
                                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    <span class="text-[10px] text-gray-500 mt-1 truncate px-1">{{ basename($file) }}</span>
                                                </a>
                                            @endif
                                            <button type="button" 
                                                    wire:click="removeFile({{ $index }})" 
                                                    class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs font-bold opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-600">
                                                ×
                                            </button>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif

                                <!-- Upload New Files -->
                                <div>
                                    <label class="block text-xs sm:text-sm font-medium mb-2">Upload New Files</label>
                                    <div class="border-2 border-dashed border-gray-300 dark:border-zinc-700 rounded-lg p-4 text-center hover:border-blue-500 transition-all duration-200"
                                        x-data="{ isDragging: false }"
                                        @dragover.prevent="isDragging = true"
                                        @dragleave.prevent="isDragging = false"
                                        @drop.prevent="isDragging = false; $refs.fileInput.files = $event.dataTransfer.files; $wire.uploadFiles($refs.fileInput.files)">
                                        <input type="file" 
                                            wire:model="new_files" 
                                            multiple 
                                            x-ref="fileInput"
                                            class="hidden"
                                            accept="image/*,.pdf,.doc,.docx,.xlsx">
                                        <svg class="w-10 h-10 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Drag & drop files here or</p>
                                        <button type="button" 
                                                onclick="document.querySelector('[x-ref=\'fileInput\']').click()"
                                                class="mt-2 text-blue-600 hover:text-blue-700 text-sm font-medium">
                                            Browse Files
                                        </button>
                                        <p class="text-xs text-gray-500 mt-2">Supported: JPG, PNG, GIF, PDF, DOC, DOCX, XLSX (Max 10MB)</p>
                                    </div>
                                    
                                    <!-- Preview Uploaded Files -->
                                    @if($new_files && count($new_files) > 0)
                                    <div class="mt-3">
                                        <label class="block text-xs sm:text-sm font-medium mb-2">New Files ({{ count($new_files) }})</label>
                                        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 gap-2">
                                            @foreach($new_files as $index => $file)
                                            @php
                                                $isImage = str_contains($file->getMimeType(), 'image');
                                                $previewUrl = $isImage ? $file->temporaryUrl() : null;
                                            @endphp
                                            <div class="relative group">
                                                @if($isImage)
                                                    <div class="aspect-square rounded-lg overflow-hidden bg-gray-100 dark:bg-zinc-800 border-2 border-gray-200 dark:border-zinc-700">
                                                        <img src="{{ $previewUrl }}" 
                                                            class="w-full h-full object-cover cursor-pointer"
                                                            alt="preview"
                                                            onclick="window.open('{{ $previewUrl }}', '_blank')">
                                                    </div>
                                                @else
                                                    <div class="aspect-square rounded-lg bg-gray-100 dark:bg-zinc-800 border-2 border-gray-200 dark:border-zinc-700 flex flex-col items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                        </svg>
                                                        <span class="text-[10px] text-gray-500 mt-1 truncate px-1">{{ $file->getClientOriginalName() }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    
                                    @error('new_files.*') <span class="text-red-500 text-xs block mt-2">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3: Review -->
                        <div x-show="$wire.wizardStep === 3" x-cloak>
                            <div class="space-y-4">
                                <!-- Summary Card -->
                                <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white mb-3">Event Summary</h3>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Title:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $title ?: '-' }}</span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Description:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $description ?: '-' }}</span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Start:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $start_date }} {{ $start_time }}</span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">End:</span>
                                            <span class="text-gray-900 dark:text-white">{{ $end_date }} {{ $end_time }}</span>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Status:</span>
                                            <div class="flex items-center gap-2">
                                                <span class="w-3 h-3 rounded-full 
                                                    {{ $color == 'red' ? 'bg-red-500' : ($color == 'yellow' ? 'bg-yellow-500' : 'bg-green-500') }}"></span>
                                                <span class="text-gray-900 dark:text-white">
                                                    {{ $color == 'red' ? 'Open' : ($color == 'yellow' ? 'On Progress' : 'Closed') }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex flex-wrap gap-2">
                                            <span class="font-medium text-gray-600 dark:text-gray-400 w-24">Attachments:</span>
                                            <span class="text-gray-900 dark:text-white">{{ count($existing_file) + count($new_files) }} file(s)</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Validation Check -->
                                @if($errors->any())
                                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-3">
                                    <p class="text-red-600 dark:text-red-400 text-sm font-medium mb-2">Please fix the following:</p>
                                    <ul class="list-disc list-inside text-xs text-red-500 space-y-1">
                                        @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Navigation Buttons - Save button appears on ALL steps -->
                        <div class="flex justify-between gap-2 mt-6">
                            <div>
                                @if($wizardStep > 1)
                                <button type="button" 
                                        wire:click="previousStep" 
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all duration-200 text-sm">
                                    ← Back
                                </button>
                                @endif
                            </div>
                            <div class="flex gap-2">
                                @if($wizardStep < 3)
                                <button type="button" 
                                        wire:click="nextStep" 
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all duration-200 text-sm">
                                    Next →
                                </button>
                                @endif
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 text-sm">
                                    {{ $event_id ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </flux:modal>

            <!-- CSS untuk x-cloak -->
            <style>
                [x-cloak] { display: none !important; }
            </style>

            <!-- MODAL DELETE - Responsive -->
            <flux:modal wire:model="showDeleteModal" class="w-full max-w-md mx-4 sm:mx-auto">
                <div class="p-4 sm:p-6 text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center animate-pulse">
                        <svg class="w-6 h-6 sm:w-8 sm:h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                    </div>
                    <h3 class="text-base sm:text-lg font-bold mb-2">Delete Event</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                        Are you sure you want to delete event "<span class="font-semibold">{{ $eventToDelete?->title }}</span>"? This action cannot be undone.
                    </p>
                    <div class="flex justify-center gap-3">
                        <button wire:click="$set('showDeleteModal', false)" class="px-3 sm:px-4 py-1.5 sm:py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all duration-200 text-sm">
                            Cancel
                        </button>
                        <button wire:click="delete" class="px-3 sm:px-4 py-1.5 sm:py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all duration-200 text-sm hover:scale-105 active:scale-95">
                            Yes, Delete
                        </button>
                    </div>
                </div>
            </flux:modal>

            <!-- Notifikasi - Responsive -->
            <div x-data="{ show: false, message: '', type: 'success' }" 
                 x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
                 x-show="show"
                 x-transition.duration.300ms
                 class="fixed bottom-3 right-3 sm:bottom-4 sm:right-4 z-50"
                 :class="{
                     'bg-green-500': type === 'success',
                     'bg-red-500': type === 'error',
                     'bg-yellow-500': type === 'warning'
                 }"
                 style="display: none;">
                <div class="text-white px-4 py-2 sm:px-6 sm:py-3 rounded-lg shadow-lg text-xs sm:text-sm">
                    <span x-text="message"></span>
                </div>
            </div>

            <style>
                [x-cloak] { display: none !important; }
                @media (max-width: 480px) {
                    .xs\:inline { display: inline; }
                }
            </style>
        </div>
    </x-esd.layout>
</section>