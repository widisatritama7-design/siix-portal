<div class="p-6 space-y-6" 
     x-data="{ showLoading: @entangle('isLoading') }"
     x-init="$watch('showLoading', value => {
         if (value) {
             document.body.classList.add('overflow-hidden');
         } else {
             document.body.classList.remove('overflow-hidden');
         }
     })">
    
    <!-- Loading Overlay -->
    <div x-show="showLoading" 
         x-cloak
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-zinc-900 rounded-lg p-8 flex flex-col items-center shadow-2xl">
            <svg class="animate-spin h-12 w-12 text-blue-600 mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="text-lg font-medium text-zinc-700 dark:text-zinc-300">Processing...</span>
            <span class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">Please wait a moment</span>
        </div>
    </div>

    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            DCC
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Submission
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Dynamic Pages -->
    @if($currentPage === 'index')
        @include('livewire.dcc.pages.index')
    @elseif($currentPage === 'create')
        @include('livewire.dcc.pages.create')
    @elseif($currentPage === 'edit')
        @include('livewire.dcc.pages.edit')
    @elseif($currentPage === 'show')
        @include('livewire.dcc.pages.show')
    @elseif($currentPage === 'receive')
        @include('livewire.dcc.pages.receive')
    @elseif($currentPage === 'distribute')
        @include('livewire.dcc.pages.distribute')
    @elseif($currentPage === 'delete')
        @include('livewire.dcc.pages.delete')
    @endif

    <!-- Notifikasi -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-2"
         class="fixed bottom-4 right-4 z-50">
        <div :class="{
            'bg-green-500': type === 'success',
            'bg-red-500': type === 'error',
            'bg-yellow-500': type === 'warning',
            'bg-blue-500': type === 'info'
        }" class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2 min-w-[300px]">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <template x-if="type === 'success'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </template>
                <template x-if="type === 'error'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </template>
                <template x-if="type === 'warning'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </template>
                <template x-if="type === 'info'">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </template>
            </svg>
            <span class="flex-1" x-text="message"></span>
            <button @click="show = false" class="hover:opacity-75">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>