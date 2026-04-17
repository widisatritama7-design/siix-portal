<div class="p-1 space-y-2">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            PROD
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Kaizen Management
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Kaizen Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage Kaizen improvement submissions
            </p>
        </div>

        @can('create kaizen')
        <flux:button 
            variant="primary" 
            icon="plus" 
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="resetForm"
            x-on:click="$dispatch('open-modal', 'kaizen-form-modal')"
        >
            Add New Kaizen
        </flux:button>
        @endcan
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
        <flux:input
            wire:model.live.debounce.300ms="search"
            placeholder="Search by title, NIK, name, process..."
            icon="magnifying-glass"
            clearable
        />
        
        <flux:select wire:model.live="filterApprovalStatus" placeholder="Approval Status">
            <flux:select.option value="">All Approval Status</flux:select.option>
            <flux:select.option value="Pending">Pending</flux:select.option>
            <flux:select.option value="Accepted">Accepted</flux:select.option>
            <flux:select.option value="Rejected">Rejected</flux:select.option>
        </flux:select>
        
        <flux:select wire:model.live="filterKaizenStatus" placeholder="Kaizen Status">
            <flux:select.option value="">All Kaizen Status</flux:select.option>
            <flux:select.option value="Pending">Pending</flux:select.option>
            <flux:select.option value="Approved">Approved</flux:select.option>
            <flux:select.option value="Rejected">Rejected</flux:select.option>
        </flux:select>
        
        <flux:input 
            type="date"
            wire:model.live="dateFrom"
            placeholder="Date From"
        />
        
        <flux:input 
            type="date"
            wire:model.live="dateTo"
            placeholder="Date To"
        />
        
        @if($search || $filterApprovalStatus || $filterKaizenStatus || $dateFrom || $dateTo)
        <div class="sm:col-span-2 lg:col-span-5 flex justify-end">
            <flux:button wire:click="clearFilters" size="sm" variant="outline">
                Clear Filters
            </flux:button>
        </div>
        @endif
    </div>

    <!-- Kaizen Table - Horizontal Scroll Only, No Vertical Scroll -->
    <flux:card class="p-0 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
        <div class="overflow-x-auto" style="overflow-y: visible;">
            <table class="w-full min-w-[1200px]">
                <thead class="bg-zinc-50 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-16">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-48">Employee</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-36">Process/Line</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-64">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-24">Photos</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-36">Approval</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-36">Check</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider w-36">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($kaizens as $index => $kaizen)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="kaizen-{{ $kaizen->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                            {{ $kaizens->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-medium shadow-lg flex-shrink-0">
                                    {{ strtoupper(substr($kaizen->name ?? $kaizen->nik, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <span class="text-sm font-semibold text-zinc-800 dark:text-white block truncate max-w-[150px]">
                                        {{ $kaizen->name ?? 'N/A' }}
                                    </span>
                                    <span class="text-xs text-zinc-500 dark:text-zinc-400">
                                        NIK: {{ $kaizen->nik }}
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div>
                                <flux:badge size="sm" color="purple" class="mb-1 whitespace-nowrap">
                                    {{ $kaizen->process }}
                                </flux:badge>
                                @if($kaizen->line)
                                <div class="text-xs text-zinc-500 mt-1 whitespace-nowrap">
                                    Line {{ $kaizen->line }}
                                </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="min-w-[200px] max-w-[300px]">
                                <!-- Title with Tooltip -->
                                <div class="relative group">
                                    <span class="text-sm font-medium text-zinc-800 dark:text-white block truncate">
                                        {{ $kaizen->title }}
                                    </span>
                                    @if(strlen($kaizen->title) > 50)
                                    <div class="absolute bottom-full left-0 mb-2 hidden group-hover:block z-50">
                                        <div class="bg-gray-900 text-white text-xs rounded-lg px-3 py-2 whitespace-normal max-w-[300px] break-words shadow-xl">
                                            {{ $kaizen->title }}
                                        </div>
                                        <div class="absolute top-full left-3 w-2 h-2 bg-gray-900 transform rotate-45 -mt-1"></div>
                                    </div>
                                    @endif
                                </div>
                                
                                <!-- Description with Tooltip -->
                                <div class="relative group mt-1">
                                    <span class="text-xs text-zinc-500 line-clamp-2 break-words">
                                        {{ \Illuminate\Support\Str::limit(strip_tags($kaizen->description), 80) }}
                                    </span>
                                    @if(strlen(strip_tags($kaizen->description)) > 80)
                                    <div class="absolute bottom-full left-0 mb-2 hidden group-hover:block z-50">
                                        <div class="bg-gray-900 text-white text-xs rounded-lg px-3 py-2 whitespace-normal max-w-[350px] break-words shadow-xl">
                                            {{ strip_tags($kaizen->description) }}
                                        </div>
                                        <div class="absolute top-full left-3 w-2 h-2 bg-gray-900 transform rotate-45 -mt-1"></div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $photos = is_array($kaizen->photo) ? $kaizen->photo : [];
                                $photoUrls = array_map(fn($p) => Storage::disk('public')->url($p), $photos);
                            @endphp
                            @if(count($photos) > 0)
                                <div class="flex -space-x-2">
                                    @foreach(array_slice($photos, 0, 3) as $index => $photo)
                                        @php
                                            $photoUrl = Storage::disk('public')->url($photo);
                                            $photoUrlsJson = json_encode($photoUrls);
                                        @endphp
                                        <div class="relative group cursor-pointer" 
                                            @click="$dispatch('open-photo-modal', { 
                                                url: '{{ $photoUrl }}', 
                                                index: {{ $index }}, 
                                                allPhotos: {{ $photoUrlsJson }},
                                                total: {{ count($photoUrls) }}
                                            })">
                                            <div class="w-8 h-8 rounded-full ring-2 ring-white dark:ring-zinc-900 flex-shrink-0 overflow-hidden bg-gray-200 dark:bg-gray-700 hover:scale-110 transition-transform duration-200">
                                                <img src="{{ $photoUrl }}" 
                                                    alt="Photo" 
                                                    class="w-full h-full object-cover"
                                                    onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 fill=%22none%22 viewBox=%220 0 24 24%22 stroke=%22%239CA3AF%22%3E%3Cpath stroke-linecap=%22round%22 stroke-linejoin=%22round%22 stroke-width=%222%22 d=%22M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z%22/%3E%3C/svg%3E'">
                                            </div>
                                            <!-- Tooltip -->
                                            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-2 hidden group-hover:block z-50">
                                                <div class="bg-black/80 text-white text-xs px-2 py-1 rounded whitespace-nowrap">
                                                    Click to preview
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if(count($photos) > 3)
                                        @php
                                            $firstPhotoUrl = Storage::disk('public')->url($photos[0]);
                                        @endphp
                                        <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-xs font-medium ring-2 ring-white dark:ring-zinc-900 flex-shrink-0 cursor-pointer hover:bg-blue-600 transition-colors"
                                            @click="$dispatch('open-photo-modal', { 
                                                url: '{{ $firstPhotoUrl }}', 
                                                index: 0, 
                                                allPhotos: {{ json_encode($photoUrls) }},
                                                total: {{ count($photoUrls) }}
                                            })">
                                            +{{ count($photos) - 3 }}
                                        </div>
                                    @endif
                                </div>
                            @else
                                <span class="text-xs text-zinc-400 whitespace-nowrap">No photos</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div>
                                @php
                                    $approvalColors = [
                                        'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                        'Accepted' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'Rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    ];
                                    $approvalColor = $approvalColors[$kaizen->approval_status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $approvalColor }}">
                                    @switch($kaizen->approval_status)
                                        @case('Pending')
                                            <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            @break
                                        @case('Accepted')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            @break
                                        @case('Rejected')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            @break
                                    @endswitch
                                    {{ $kaizen->approval_status }}
                                </span>
                                @if($kaizen->comment)
                                    <div class="text-xs text-zinc-500 mt-1 truncate max-w-[150px]" title="{{ $kaizen->comment }}">
                                        💬 {{ \Illuminate\Support\Str::limit($kaizen->comment, 25) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div>
                                @php
                                    $kaizenColors = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                        'Approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                        'Rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    ];
                                    $kaizenColor = $kaizenColors[$kaizen->status_kaizen] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                                @endphp
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $kaizenColor }}">
                                    @switch($kaizen->status_kaizen)
                                        @case('Pending')
                                            <svg class="w-3 h-3 animate-spin" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            @break
                                        @case('Approved')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            @break
                                        @case('Rejected')
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                            @break
                                    @endswitch
                                    {{ $kaizen->status_kaizen }}
                                </span>
                                @if($kaizen->comment_spv)
                                    <div class="text-xs text-zinc-500 mt-1 truncate max-w-[150px]" title="{{ $kaizen->comment_spv }}">
                                        💬 {{ \Illuminate\Support\Str::limit($kaizen->comment_spv, 25) }}
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">

                                <!-- Update Approval Status (Leader) -->
                                @can('kaizen check', App\Models\PROD\Kaizen\Kaizen::class)
                                    @if(!in_array($kaizen->approval_status, ['Accepted', 'Rejected']))
                                    <flux:button 
                                        wire:click="$dispatch('open-approval-modal', { id: {{ $kaizen->id }}, currentStatus: '{{ $kaizen->approval_status }}' })"
                                        size="sm"
                                        icon="check-circle"
                                        variant="primary"
                                        color="green"
                                        class="!p-2"
                                        title="Update approval status"
                                    />
                                    @endif
                                @endcan

                                <!-- Update Kaizen Status (SPV) -->
                                @can('kaizen approve', App\Models\PROD\Kaizen\Kaizen::class)
                                    @if($kaizen->status_kaizen !== 'Approved')
                                    <flux:button 
                                        wire:click="$dispatch('open-kaizen-status-modal', { id: {{ $kaizen->id }}, currentStatus: '{{ $kaizen->status_kaizen }}' })"
                                        size="sm"
                                        icon="arrow-path"
                                        variant="primary"
                                        color="yellow"
                                        class="!p-2"
                                        title="Update kaizen status"
                                    />
                                    @endif
                                @endcan

                                <!-- Edit Button -->
                                @can('edit kaizen')
                                <flux:button 
                                    wire:click="edit({{ $kaizen->id }})" 
                                    x-on:click="$dispatch('open-modal', 'kaizen-form-modal')"
                                    size="sm"
                                    icon="pencil-square"
                                    variant="primary"
                                    color="yellow"
                                    class="!p-2"
                                    title="Edit kaizen"
                                />
                                @endcan

                                <!-- Delete Button -->
                                @can('delete kaizen')
                                    <flux:button 
                                        wire:click="confirmDelete({{ $kaizen->id }})" 
                                        x-on:click="$dispatch('open-modal', 'delete-kaizen-modal')"
                                        size="sm"
                                        icon="trash"
                                        variant="primary"
                                        color="red"
                                        class="!p-2"
                                        title="Delete kaizen"
                                    />
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="document-text" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No kaizen submissions found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ ($search || $filterApprovalStatus || $filterKaizenStatus || $dateFrom || $dateTo) 
                                            ? 'Try adjusting your filters' 
                                            : 'Get started by creating a new kaizen submission' }}
                                    </p>
                                </div>
                                @if($search || $filterApprovalStatus || $filterKaizenStatus || $dateFrom || $dateTo)
                                    <flux:button wire:click="clearFilters" size="sm">
                                        Clear Filters
                                    </flux:button>
                                @else
                                    @can('create kaizen')
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="resetForm"
                                        x-on:click="$dispatch('open-modal', 'kaizen-form-modal')"
                                    >
                                        Add Your First Kaizen
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
        @if($kaizens->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $kaizens->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL PHOTO PREVIEW - IMAGE FIT WITHOUT CROPPING -->
    <div x-data="{ 
        open: false,
        currentPhotoUrl: '',
        currentPhotoIndex: 0,
        allPhotos: [],
        totalPhotos: 0
    }" 
        x-show="open" 
        x-cloak
        @open-photo-modal.window="
            open = true; 
            currentPhotoUrl = $event.detail.url; 
            currentPhotoIndex = $event.detail.index;
            allPhotos = $event.detail.allPhotos;
            totalPhotos = $event.detail.total;
            document.body.style.overflow = 'hidden';
        "
        @close-modal.window="if ($event.detail === 'photo-preview-modal') { open = false; document.body.style.overflow = ''; }">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/95 z-50" @click="open = false; document.body.style.overflow = '';"></div>

        <!-- Modal Container -->
        <div class="fixed inset-0 z-50 flex flex-col items-center justify-center p-2 sm:p-4">
            
            <!-- Top Bar with Close Button -->
            <div class="w-full max-w-7xl mb-2 sm:mb-4 flex justify-end">
                <button @click="open = false; document.body.style.overflow = '';" 
                        class="text-white/70 hover:text-white transition-all duration-200 p-2 rounded-full hover:bg-white/10">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    <span class="sr-only">Close</span>
                </button>
            </div>

            <!-- Main Image Container -->
            <div class="relative w-full max-w-7xl flex-1 flex items-center justify-center min-h-0">
                
                <!-- Navigation Buttons - Left -->
                <button x-show="currentPhotoIndex > 0"
                        @click="if(currentPhotoIndex > 0) { currentPhotoIndex--; currentPhotoUrl = allPhotos[currentPhotoIndex]; }"
                        class="absolute left-0 sm:left-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 sm:p-3 transition-all duration-200 hover:scale-110 z-10 backdrop-blur-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <!-- Image Display - WILL NOT CROP, WILL SCALE DOWN -->
                <div class="flex items-center justify-center w-full h-full px-8 sm:px-12">
                    <img :src="currentPhotoUrl" 
                        alt="Preview" 
                        class="max-w-full max-h-[65vh] sm:max-h-[70vh] w-auto h-auto object-contain rounded-lg shadow-2xl transition-all duration-300">
                </div>

                <!-- Navigation Buttons - Right -->
                <button x-show="currentPhotoIndex < totalPhotos - 1"
                        @click="if(currentPhotoIndex < totalPhotos - 1) { currentPhotoIndex++; currentPhotoUrl = allPhotos[currentPhotoIndex]; }"
                        class="absolute right-0 sm:right-2 top-1/2 transform -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 sm:p-3 transition-all duration-200 hover:scale-110 z-10 backdrop-blur-sm">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

                <!-- Image Counter -->
                <div class="absolute top-2 left-1/2 transform -translate-x-1/2 bg-black/60 backdrop-blur-sm text-white text-xs sm:text-sm px-2 sm:px-3 py-1 rounded-full z-10">
                    <span x-text="currentPhotoIndex + 1"></span> / <span x-text="totalPhotos"></span>
                </div>

                <!-- Download Button -->
                <div class="absolute bottom-2 right-2 sm:bottom-4 sm:right-4">
                    <a :href="currentPhotoUrl" 
                    download
                    target="_blank"
                    class="bg-black/50 hover:bg-black/70 text-white rounded-full p-1.5 sm:p-2 transition-all duration-200 backdrop-blur-sm inline-flex items-center gap-1 sm:gap-2 text-xs sm:text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        <span class="hidden sm:inline">Download</span>
                    </a>
                </div>
            </div>

            <!-- Thumbnail Strip -->
            <div x-show="totalPhotos > 1" class="w-full max-w-7xl mt-2 sm:mt-4 flex justify-center gap-1 sm:gap-2 overflow-x-auto px-2 pb-2">
                <template x-for="(photo, idx) in allPhotos" :key="idx">
                    <div class="flex-shrink-0 cursor-pointer transition-all duration-200 hover:scale-105"
                        @click="currentPhotoIndex = idx; currentPhotoUrl = allPhotos[idx]">
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-lg overflow-hidden border-2" 
                            :class="currentPhotoIndex == idx ? 'border-blue-500 shadow-lg' : 'border-transparent opacity-60 hover:opacity-100'">
                            <img :src="photo" class="w-full h-full object-cover" :alt="'Thumbnail ' + (idx + 1)">
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <!-- MODAL FORM KAIZEN - ENHANCED DESIGN -->
    <div x-data="{ 
        open: false,
        searchEmployee: '',
        showEmployeeDropdown: false,
        employees: {{ json_encode(\App\Models\HR\Employee::select('nik', 'name')->get()->mapWithKeys(fn($e) => [$e->nik => $e->nik . ' - ' . $e->name])->toArray()) }},
        selectedNik: @entangle('nik'),
        selectedName: @entangle('name')
    }" 
        x-show="open" 
        x-cloak
        @open-modal.window="if ($event.detail === 'kaizen-form-modal') { open = true; document.body.style.overflow = 'hidden'; }"
        @close-modal.window="if ($event.detail === 'kaizen-form-modal') { open = false; document.body.style.overflow = ''; }">

        <!-- Backdrop -->
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm z-40 transition-opacity duration-300" 
            @click="open = false; document.body.style.overflow = '';"></div>

        <!-- Modal Container -->
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 sm:p-6 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-5xl my-8 transform transition-all duration-300 ease-out"
                x-show="open"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 dark:from-blue-800 dark:to-indigo-800 rounded-t-2xl px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-white/20 rounded-xl backdrop-blur-sm">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold text-white">{{ $modalTitle }}</h2>
                                <p class="text-xs text-blue-100 mt-0.5">Fill in the kaizen improvement details</p>
                            </div>
                        </div>
                        <button type="button" 
                                @click="open = false; document.body.style.overflow = '';" 
                                class="text-white/80 hover:text-white transition-all duration-200 p-2 rounded-xl hover:bg-white/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Form Body -->
                <form wire:submit="save">
                    <div class="p-6 space-y-6 max-h-[calc(100vh-200px)] overflow-y-auto">
                        <!-- Employee Section -->
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-xl p-5 border border-gray-100 dark:border-zinc-700">
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Employee Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- NIK Selection with Searchable Dropdown -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        NIK <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" 
                                            x-model="searchEmployee" 
                                            @input="showEmployeeDropdown = searchEmployee.trim().length > 0" 
                                            @focus="showEmployeeDropdown = true"
                                            @keydown.escape="showEmployeeDropdown = false"
                                            placeholder="Search by NIK or name..." 
                                            class="w-full pl-10 pr-10 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white transition-all duration-200">
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                            </svg>
                                        </div>
                                        
                                        <!-- Dropdown -->
                                        <div x-show="showEmployeeDropdown" 
                                            @click.outside="showEmployeeDropdown = false" 
                                            class="absolute z-50 w-full mt-2 bg-white dark:bg-zinc-800 border border-gray-200 dark:border-zinc-700 rounded-xl shadow-lg max-h-60 overflow-y-auto"
                                            style="display: none;">
                                            <div class="sticky top-0 bg-gray-50 dark:bg-zinc-900 px-4 py-2 border-b border-gray-200 dark:border-zinc-700">
                                                <span class="text-xs font-medium text-gray-500">Select Employee</span>
                                            </div>
                                            <template x-for="(label, value) in employees" :key="value">
                                                <div x-show="label.toLowerCase().includes(searchEmployee.toLowerCase())" 
                                                    @click="selectedNik = value; searchEmployee = label; showEmployeeDropdown = false; $wire.set('nik', value); $wire.set('name', label.split(' - ').pop())" 
                                                    class="px-4 py-3 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer transition-colors border-b border-gray-100 dark:border-zinc-700 last:border-0">
                                                    <span class="text-sm" x-text="label"></span>
                                                </div>
                                            </template>
                                            <div x-show="Object.keys(employees).filter(key => employees[key].toLowerCase().includes(searchEmployee.toLowerCase())).length === 0" 
                                                class="px-4 py-8 text-sm text-gray-500 text-center">
                                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                No employees found
                                            </div>
                                        </div>
                                    </div>
                                    @error('nik') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Name (Auto-filled, disabled) -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Employee Name <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <input type="text" 
                                            x-model="selectedName"
                                            disabled
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl bg-gray-100 dark:bg-zinc-700 text-gray-600 dark:text-gray-400 cursor-not-allowed">
                                    </div>
                                    @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Process & Line Section -->
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-xl p-5 border border-gray-100 dark:border-zinc-700">
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Production Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Process -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Process <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
                                            </svg>
                                        </div>
                                        <select 
                                            wire:model.live="process"
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white appearance-none cursor-pointer transition-all duration-200">
                                            <option value="">Select Process</option>
                                            <option value="SMT">SMT</option>
                                            <option value="MI">MI</option>
                                            <option value="ROUTER">ROUTER</option>
                                            <option value="LASER">LASER</option>
                                            <option value="PREPARATION">PREPARATION</option>
                                            <option value="TECHNICIAN">TECHNICIAN</option>
                                            <option value="MAINTENANCE">MAINTENANCE</option>
                                            <option value="ESD">ESD</option>
                                            <option value="UTILITY">UTILITY</option>
                                            <option value="PE">PE</option>
                                            <option value="QUALITY">QUALITY</option>
                                            <option value="MATERIAL">MATERIAL</option>
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('process') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Line (Conditional) -->
                                @if($this->show_line_field)
                                <div x-show="['SMT', 'MI', 'ROUTER', 'LASER'].includes($wire.process)" x-cloak>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Line <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                                            </svg>
                                        </div>
                                        <select 
                                            wire:model="line"
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white appearance-none cursor-pointer transition-all duration-200">
                                            <option value="">Select Line</option>
                                            @foreach($this->line_options as $key => $value)
                                                <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                    @error('line') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Kaizen Details Section -->
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-xl p-5 border border-gray-100 dark:border-zinc-700">
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Kaizen Details
                            </h3>
                            <div class="space-y-5">
                                <!-- Title -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Title <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                            </svg>
                                        </div>
                                        <input type="text" 
                                            wire:model="title"
                                            placeholder="Enter kaizen title..."
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white transition-all duration-200">
                                    </div>
                                    @error('title') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Description -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        Description <span class="text-red-500">*</span>
                                    </label>
                                    <div class="relative">
                                        <div class="absolute top-3 left-3 pointer-events-none">
                                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                                            </svg>
                                        </div>
                                        <textarea 
                                            wire:model="description"
                                            rows="5"
                                            placeholder="Describe your kaizen improvement in detail..."
                                            class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-zinc-800 dark:text-white resize-none transition-all duration-200"></textarea>
                                    </div>
                                    @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Photos Section -->
                        <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-xl p-5 border border-gray-100 dark:border-zinc-700">
                            <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300 mb-4 flex items-center gap-2">
                                <svg class="w-4 h-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Photos
                            </h3>
                            
                            <!-- Existing Photos -->
                            @if(count($existingPhotos) > 0)
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Current Photos</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach($existingPhotos as $index => $photo)
                                        <div class="relative group">
                                            <div class="w-24 h-24 rounded-xl overflow-hidden border-2 border-gray-200 dark:border-zinc-600 shadow-md group-hover:shadow-lg transition-all duration-200">
                                                <img src="{{ Storage::disk('public')->url($photo) }}" 
                                                    class="w-full h-full object-cover">
                                            </div>
                                            <button type="button" 
                                                    wire:click="removeExistingPhoto({{ $index }})"
                                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-600 shadow-lg">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- New Photos Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Upload New Photos</label>
                                <div class="relative">
                                    <div class="flex items-center justify-center w-full">
                                        <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 dark:border-zinc-600 rounded-xl cursor-pointer bg-gray-50 dark:bg-zinc-800/30 hover:bg-gray-100 dark:hover:bg-zinc-800 transition-all duration-200">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                                </p>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                                    PNG, JPG, JPEG (Max 5MB each)
                                                </p>
                                            </div>
                                            <input type="file" 
                                                wire:model="new_photos" 
                                                multiple
                                                accept="image/*"
                                                class="hidden">
                                        </label>
                                    </div>
                                </div>
                                @error('new_photos.*') <p class="text-xs text-red-500 mt-2">{{ $message }}</p> @enderror
                                
                                <!-- Preview new photos -->
                                @if($new_photos && count($new_photos) > 0)
                                    <div class="mt-4">
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Preview</label>
                                        <div class="flex flex-wrap gap-3">
                                            @foreach($new_photos as $index => $photo)
                                                @if($photo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                                    <div class="relative group">
                                                        <div class="w-24 h-24 rounded-xl overflow-hidden border-2 border-green-500 shadow-md">
                                                            <img src="{{ $photo->temporaryUrl() }}" 
                                                                class="w-full h-full object-cover">
                                                        </div>
                                                        <button type="button" 
                                                                wire:click="removeNewPhoto({{ $index }})"
                                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-all duration-200 hover:bg-red-600 shadow-lg">
                                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Footer Buttons -->
                    <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-b-2xl px-6 py-4 flex justify-end gap-3 border-t border-gray-200 dark:border-zinc-700">
                        <button type="button" 
                                @click="open = false; document.body.style.overflow = '';" 
                                class="px-5 py-2.5 border border-gray-300 dark:border-zinc-600 rounded-xl hover:bg-gray-100 dark:hover:bg-zinc-700 transition-all duration-200 font-medium text-sm text-gray-700 dark:text-gray-300">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-5 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 font-medium text-sm shadow-md hover:shadow-lg">
                            <svg class="inline w-4 h-4 mr-2 -mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ $kaizen_id ? 'Update Kaizen' : 'Create Kaizen' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- MODAL VIEW KAIZEN - FIXED POSITIONING -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'view-kaizen-modal') { open = true; document.body.style.overflow = 'hidden'; }"
         @close-modal.window="if ($event.detail === 'view-kaizen-modal') { open = false; document.body.style.overflow = ''; }"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; document.body.style.overflow = '';"></div>

        <div class="fixed inset-0 z-50 flex items-start sm:items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl my-8 sm:my-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Kaizen Details</h2>
                        <button @click="open = false; document.body.style.overflow = '';" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    @if($kaizenToView)
                    <div class="max-h-[calc(100vh-200px)] overflow-y-auto px-1">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="text-sm font-medium text-zinc-500">NIK</label>
                                <p class="text-base">{{ $kaizenToView->nik }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-zinc-500">Name</label>
                                <p class="text-base">{{ $kaizenToView->name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-zinc-500">Process</label>
                                <p class="text-base">{{ $kaizenToView->process }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-zinc-500">Line</label>
                                <p class="text-base">{{ $kaizenToView->line ?: 'N/A' }}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="text-sm font-medium text-zinc-500">Title</label>
                                <p class="text-base font-semibold">{{ $kaizenToView->title }}</p>
                            </div>
                            <div class="col-span-2">
                                <label class="text-sm font-medium text-zinc-500">Description</label>
                                <div class="text-base prose dark:prose-invert max-w-none">
                                    {!! nl2br(e($kaizenToView->description)) !!}
                                </div>
                            </div>
                            
                            @if($kaizenToView->comment)
                            <div class="col-span-2">
                                <label class="text-sm font-medium text-zinc-500">Comment (Leader)</label>
                                <p class="text-base bg-yellow-50 dark:bg-yellow-900/20 p-3 rounded-lg">{{ $kaizenToView->comment }}</p>
                            </div>
                            @endif
                            
                            @if($kaizenToView->comment_spv)
                            <div class="col-span-2">
                                <label class="text-sm font-medium text-zinc-500">Comment (SPV)</label>
                                <p class="text-base bg-blue-50 dark:bg-blue-900/20 p-3 rounded-lg">{{ $kaizenToView->comment_spv }}</p>
                            </div>
                            @endif
                            
                            <div>
                                <label class="text-sm font-medium text-zinc-500">Approval Status</label>
                                <div class="mt-1">
                                    <flux:badge color="{{ match($kaizenToView->approval_status) {
                                        'Pending' => 'info',
                                        'Accepted' => 'success',
                                        'Rejected' => 'danger',
                                        default => 'gray'
                                    } }}">
                                        {{ $kaizenToView->approval_status }}
                                    </flux:badge>
                                </div>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-zinc-500">Kaizen Status</label>
                                <div class="mt-1">
                                    <flux:badge color="{{ match($kaizenToView->status_kaizen) {
                                        'Pending' => 'info',
                                        'Approved' => 'success',
                                        'Rejected' => 'danger',
                                        default => 'gray'
                                    } }}">
                                        {{ $kaizenToView->status_kaizen }}
                                    </flux:badge>
                                </div>
                            </div>
                        </div>

                        @if(count($viewPhotoUrls) > 0)
                        <div class="mt-4">
                            <label class="text-sm font-medium text-zinc-500 mb-2 block">Photos</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach($viewPhotoUrls as $photoUrl)
                                    <a href="{{ $photoUrl }}" target="_blank" class="block">
                                        <img src="{{ $photoUrl }}" class="w-full h-32 object-cover rounded-lg border hover:shadow-lg transition">
                                    </a>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="text-xs text-zinc-400 pt-4 mt-4 border-t">
                            Created by: {{ $kaizenToView->creator?->name ?? 'N/A' }} | 
                            {{ $kaizenToView->created_at?->format('d M Y H:i') }}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UPDATE APPROVAL STATUS - FIXED POSITIONING -->
    <div x-data="{ open: false, id: null, currentStatus: null, selectedStatus: 'Accepted', comment: '' }" 
         x-show="open" 
         @open-approval-modal.window="open = true; id = $event.detail.id; currentStatus = $event.detail.currentStatus; selectedStatus = 'Accepted'; comment = ''"
         @close-modal.window="if ($event.detail === 'approval-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Update Approval Status</h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-2">
                                <input type="radio" x-model="selectedStatus" value="Accepted" class="w-4 h-4 text-green-600">
                                <span class="text-green-600">Accepted</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" x-model="selectedStatus" value="Rejected" class="w-4 h-4 text-red-600">
                                <span class="text-red-600">Rejected</span>
                            </label>
                        </div>
                    </div>
                    
                    <div x-show="selectedStatus === 'Rejected'" class="mb-4">
                        <label class="block text-sm font-medium mb-1">Comment</label>
                        <textarea x-model="comment" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700" placeholder="Provide reason for rejection..."></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-2 mt-6">
                        <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                        <button @click="$wire.updateApprovalStatus(id, selectedStatus, comment); open = false" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL UPDATE KAIZEN STATUS - FIXED POSITIONING -->
    <div x-data="{ open: false, id: null, currentStatus: null, selectedStatus: 'Approved', comment: '' }" 
         x-show="open" 
         @open-kaizen-status-modal.window="open = true; id = $event.detail.id; currentStatus = $event.detail.currentStatus; selectedStatus = 'Approved'; comment = ''"
         @close-modal.window="if ($event.detail === 'kaizen-status-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Update Kaizen Status</h2>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Status</label>
                        <div class="flex gap-3">
                            <label class="flex items-center gap-2">
                                <input type="radio" x-model="selectedStatus" value="Approved" class="w-4 h-4 text-green-600">
                                <span class="text-green-600">Approved</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" x-model="selectedStatus" value="Rejected" class="w-4 h-4 text-red-600">
                                <span class="text-red-600">Rejected</span>
                            </label>
                        </div>
                    </div>
                    
                    <div x-show="selectedStatus === 'Rejected'" class="mb-4">
                        <label class="block text-sm font-medium mb-1">Comment</label>
                        <textarea x-model="comment" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700" placeholder="Provide reason for rejection..."></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-2 mt-6">
                        <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                        <button @click="$wire.updateKaizenStatus(id, selectedStatus, comment); open = false" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE PHOTO - FIXED POSITIONING -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-photo-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-photo-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete Photo</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete this photo? This action cannot be undone.
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                    <button wire:click="confirmDeletePhoto" @click="open = false" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE KAIZEN - FIXED POSITIONING -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-kaizen-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-kaizen-modal') open = false"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete Kaizen</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete kaizen "{{ $kaizenToDelete?->title }}"? This action cannot be undone.
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="open = false" class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                    <button wire:click="delete" @click="open = false" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
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
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</div>