<div class="p-1 space-y-2">

    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Ticketing Support
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('ticket.list') }}" wire:navigate separator="slash">
            Ticket List
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            View
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>
    
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <div class="flex items-center gap-2">
                <a href="{{ route('ticket.list') }}" class="text-zinc-600 hover:text-zinc-800 dark:text-zinc-400 dark:hover:text-zinc-200">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                    Ticket Details
                </h1>
            </div>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Ticket Number : <span class="font-mono font-semibold text-zinc-700 dark:text-zinc-300">{{ $ticket->ticket_number }}</span>
            </p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Ticket Info -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <!-- Header with Solid Color -->
                <div class="bg-blue-600 dark:bg-blue-500 px-6 py-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-semibold text-base text-white">Ticket Information</h3>
                    </div>
                </div>
                
                <div class="p-6">
                    <!-- Title -->
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Title</label>
                        <p class="text-gray-800 dark:text-gray-200 text-lg font-medium break-words">{{ $ticket->title }}</p>
                    </div>
                    
                    <!-- Description -->
                    <div class="mt-4">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Description</label>
                        <div class="prose dark:prose-invert max-w-none bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4 border border-gray-200 dark:border-zinc-700">
                            {!! nl2br(e($ticket->description)) !!}
                        </div>
                    </div>
                    
                    <!-- Attachments -->
                    @if($ticket->file && count($ticket->file) > 0)
                    <div class="mt-4">
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Attachments ({{ count($ticket->file) }})</label>
                        <div class="flex flex-wrap gap-3">
                            @foreach($ticket->file as $index => $file)
                                @php
                                    $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                                    $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                                @endphp
                                
                                @if($isImage)
                                    <div 
                                        wire:click="openImageModal('{{ Storage::url($file) }}', '{{ $ticket->title }} - Attachment')"
                                        class="group relative cursor-pointer">
                                        <img src="{{ Storage::url($file) }}" 
                                            class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-zinc-700 shadow-md hover:shadow-xl transition-all duration-200 group-hover:scale-105 cursor-pointer">
                                        <div class="absolute inset-0 bg-black/40 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <a href="{{ Storage::url($file) }}" target="_blank" class="group">
                                        <div class="w-20 h-20 bg-gray-100 dark:bg-zinc-800 rounded-lg flex flex-col items-center justify-center border border-gray-200 dark:border-zinc-700 shadow-md hover:shadow-xl transition-all duration-200 group-hover:scale-105 group-hover:bg-gray-200 dark:group-hover:bg-zinc-700">
                                            <svg class="w-8 h-8 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1 uppercase">{{ strtoupper($fileExtension) }}</span>
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </flux:card>

            <!-- Image Modal -->
            @if($showImageModal)
            <div x-data="{ open: true }" 
                x-show="open"
                x-init="document.body.style.overflow = 'hidden'"
                @keydown.escape.window="open = false; $wire.closeImageModal(); document.body.style.overflow = ''"
                x-cloak>
                <div class="fixed inset-0 bg-black/70 z-50 flex items-center justify-center p-4"
                    @click="open = false; $wire.closeImageModal(); document.body.style.overflow = ''">
                    <div class="relative max-w-2xl max-h-[80vh] w-full" @click.stop>
                        <!-- Image Container -->
                        <div class="bg-white dark:bg-zinc-800 rounded-lg overflow-hidden shadow-xl border border-gray-200 dark:border-zinc-700">
                            <!-- Header with Close Button -->
                            <div class="flex justify-between items-center p-3 border-b border-gray-200 dark:border-zinc-700">
                                <button 
                                    @click="open = false; $wire.closeImageModal(); document.body.style.overflow = ''"
                                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors ml-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <!-- Image Content -->
                            <div class="p-3 flex justify-center items-center bg-gray-100 dark:bg-zinc-800">
                                <img src="{{ $imageModalUrl }}" 
                                    alt="{{ $imageModalTitle }}"
                                    class="max-w-full max-h-[60vh] object-contain rounded">
                            </div>
                            
                            <!-- Footer with Download Button -->
                            <div class="p-3 border-t border-gray-200 dark:border-zinc-700 flex justify-end">
                                <a href="{{ $imageModalUrl }}" 
                                download
                                class="px-3 py-1.5 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                    </svg>
                                    Download
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Feedback Timeline -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <!-- Header with Solid Green Color -->
                <div class="bg-green-600 dark:bg-green-500 px-6 py-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <h3 class="font-semibold text-base text-white">Activity Timeline</h3>
                        </div>
                        
                        <!-- Add Feedback Button -->
                        @php
                            $lastFeedback = $feedbacks->first();
                            $isLastFeedbackClosed = $lastFeedback && $lastFeedback->status === 'Closed';
                        @endphp

                        @if(!$isLastFeedbackClosed)
                            <button 
                                wire:click="openFeedbackModal"
                                class="px-3 py-1.5 bg-white hover:bg-gray-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 text-green-600 dark:text-green-400 rounded-lg transition-all duration-200 flex items-center gap-2 text-sm shadow-md hover:shadow-lg">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path>
                                </svg>
                                Add Feedback
                            </button>
                        @endif
                    </div>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        @forelse($feedbacks as $feedback)
                            @php
                                $createdDate = $feedback->created_at instanceof \Carbon\Carbon ? $feedback->created_at->format('d M Y H:i') : \Carbon\Carbon::parse($feedback->created_at)->format('d M Y H:i');
                                $isMoreThan24Hours = \Carbon\Carbon::parse($feedback->created_at)->diffInHours(now()) > 24;
                                $comment = $feedback->comments;
                                $pattern = '/\b(?:https?:\/\/|www\.)[^\s]+/i';
                                preg_match_all($pattern, $comment, $urlMatches);
                                $hasUrls = !empty($urlMatches[0]);
                            @endphp
                            <div class="border-l-4 border-green-500 pl-4 py-2 group">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex-1">
                                        <div class="flex items-center flex-wrap gap-2">
                                            <span class="font-semibold text-sm">{{ $feedback->user->name ?? 'Status' }}</span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border border-gray-200 dark:border-gray-700
                                                {{ match($feedback->status) {
                                                    'Open' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                                    'In Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                                    'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                    'Closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300'
                                                } }}">
                                                {{ $feedback->status }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs text-gray-500">{{ $createdDate }}</span>
                                        @if(!$isMoreThan24Hours)
                                            <div class="flex items-center gap-1">
                                                <button 
                                                    wire:click="editFeedback({{ $feedback->id }})"
                                                    class="text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400 transition-colors"
                                                    title="Edit feedback">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                    </svg>
                                                </button>
                                                <button 
                                                    wire:click="confirmDeleteFeedback({{ $feedback->id }})"
                                                    class="text-gray-500 hover:text-red-600 dark:text-gray-400 dark:hover:text-red-400 transition-colors"
                                                    title="Delete feedback">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                                    @if($hasUrls)
                                        @php
                                            $textWithoutUrls = preg_replace($pattern, '', $comment);
                                            $textWithoutUrls = trim($textWithoutUrls);
                                        @endphp
                                        @if($textWithoutUrls)
                                            <p class="mb-2">{{ $textWithoutUrls }}</p>
                                        @endif
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($urlMatches[0] as $url)
                                                @php
                                                    $fullUrl = $url;
                                                    if (!preg_match('/^https?:\/\//', $fullUrl)) {
                                                        $fullUrl = 'http://' . $fullUrl;
                                                    }
                                                @endphp
                                                <a href="{{ $fullUrl }}" target="_blank" rel="noopener noreferrer" 
                                                class="inline-flex items-center gap-1 px-3 py-1.5 bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg border border-green-200 dark:border-green-800 hover:bg-green-100 dark:hover:bg-green-800/40 transition-colors text-sm font-medium">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                    </svg>
                                                    Open Link
                                                </a>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>{{ $comment }}</p>
                                    @endif
                                </div>
                                
                                @if($feedback->photo)
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @php
                                            $photos = is_array($feedback->photo) ? $feedback->photo : json_decode($feedback->photo, true);
                                        @endphp
                                        @if($photos && is_array($photos))
                                            @foreach($photos as $photo)
                                                <div 
                                                    wire:click="openImageModal('{{ Storage::url($photo) }}', 'Feedback Image from {{ $feedback->user->name ?? 'Status' }}')"
                                                    class="cursor-pointer block">
                                                    <img src="{{ Storage::url($photo) }}" 
                                                        class="w-16 h-16 object-cover rounded-lg border border-gray-200 dark:border-zinc-700 hover:opacity-80 transition-opacity shadow-md hover:shadow-lg cursor-pointer">
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                                
                                @if($feedback->file)
                                    <div class="flex flex-wrap gap-2 mt-3">
                                        @php
                                            $files = is_array($feedback->file) ? $feedback->file : json_decode($feedback->file, true);
                                        @endphp
                                        @if($files && is_array($files))
                                            @foreach($files as $file)
                                                <a href="{{ Storage::url($file) }}" target="_blank" class="inline-flex items-center gap-1 px-3 py-1.5 bg-gray-100 dark:bg-zinc-800 text-gray-700 dark:text-gray-300 rounded-lg border border-gray-200 dark:border-zinc-700 hover:bg-gray-200 dark:hover:bg-zinc-700 transition-colors text-sm">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                    Download File
                                                </a>
                                            @endforeach
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <svg class="w-12 h-12 mx-auto text-gray-400 dark:text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p class="text-gray-500 dark:text-gray-400">No feedback yet. Be the first to add feedback!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </flux:card>

            <!-- Edit Feedback Modal -->
            @if($showEditFeedbackModal && $editingFeedback)
            <div x-data="{ open: true }" 
                x-show="open"
                @keydown.escape.window="open = false; $wire.closeEditFeedbackModal()"
                x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.closeEditFeedbackModal()"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
                    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl w-full max-w-2xl my-8 max-h-[90vh] flex flex-col border border-gray-200 dark:border-zinc-700">
                        <!-- Header - Fixed -->
                        <div class="p-6 border-b border-gray-200 dark:border-zinc-700 flex-shrink-0">
                            <div class="flex justify-between items-center">
                                <h2 class="text-xl font-bold">Edit Feedback</h2>
                                <button @click="open = false; $wire.closeEditFeedbackModal()" class="text-gray-500 hover:text-gray-700">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        
                        <!-- Scrollable Content -->
                        <div class="flex-1 overflow-y-auto p-6">
                            <form wire:submit.prevent="updateFeedback" id="editFeedbackForm">
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Status <span class="text-red-500">*</span></label>
                                        <div class="grid grid-cols-4 gap-2">
                                            @foreach(['Open', 'In Progress', 'Pending', 'Closed'] as $status)
                                                <div 
                                                    wire:click="$set('editStatus', '{{ $status }}')"
                                                    class="text-center px-3 py-2 border rounded-lg transition-all duration-200 cursor-pointer
                                                        {{ $editStatus == $status ? 
                                                            ($status == 'Open' ? 'bg-red-100 border-red-500 dark:bg-red-900/50 text-red-900 dark:text-red-200 font-medium shadow-md ring-2 ring-red-400' :
                                                            ($status == 'In Progress' ? 'bg-yellow-100 border-yellow-500 dark:bg-yellow-900/50 text-yellow-900 dark:text-yellow-200 font-medium shadow-md ring-2 ring-yellow-400' :
                                                            ($status == 'Pending' ? 'bg-blue-100 border-blue-500 dark:bg-blue-900/50 text-blue-900 dark:text-blue-200 font-medium shadow-md ring-2 ring-blue-400' :
                                                            'bg-green-100 border-green-500 dark:bg-green-900/50 text-green-900 dark:text-green-200 font-medium shadow-md ring-2 ring-green-400'))) :
                                                            'bg-white dark:bg-zinc-700 border-gray-300 dark:border-zinc-600 hover:bg-gray-50 dark:hover:bg-zinc-600 text-gray-700 dark:text-gray-300' }}">
                                                    {{ $status }}
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('editStatus') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Comments <span class="text-red-500">*</span></label>
                                        <textarea 
                                            wire:model="editComments"
                                            rows="4"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                            placeholder="Enter your feedback..."></textarea>
                                        @error('editComments') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <!-- Existing Photos -->
                                    @if(count($existingPhotos) > 0)
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Existing Photos ({{ count($existingPhotos) }})</label>
                                        <div class="flex flex-wrap gap-2 max-h-48 overflow-y-auto p-2 border rounded-lg bg-gray-50 dark:bg-zinc-700/50">
                                            @foreach($existingPhotos as $photoIndex => $photo)
                                                <div class="relative group flex-shrink-0" wire:key="photo-{{ $photoIndex }}">
                                                    <img src="{{ Storage::url($photo) }}" 
                                                        class="w-20 h-20 object-cover rounded-lg border border-gray-200 dark:border-zinc-600 shadow-md">
                                                    <button 
                                                        type="button"
                                                        wire:click="removeExistingPhoto('{{ $photo }}')"
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md hover:bg-red-600 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        ×
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Existing Files -->
                                    @if(count($existingFiles) > 0)
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Existing Files ({{ count($existingFiles) }})</label>
                                        <div class="space-y-1 max-h-48 overflow-y-auto p-2 border rounded-lg bg-gray-50 dark:bg-zinc-700/50">
                                            @foreach($existingFiles as $fileIndex => $file)
                                                <div class="flex items-center justify-between bg-white dark:bg-zinc-700 p-2 rounded shadow-sm border border-gray-200 dark:border-zinc-600 group" wire:key="file-{{ $fileIndex }}">
                                                    <a href="{{ Storage::url($file) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800 truncate flex-1">
                                                        {{ basename($file) }}
                                                    </a>
                                                    <button 
                                                        type="button"
                                                        wire:click="removeExistingFile('{{ $file }}')"
                                                        class="text-red-500 hover:text-red-700 ml-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                        Remove
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @endif
                                    
                                    <!-- Add New Photos -->
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Add New Photos</label>
                                        <input type="file" 
                                            wire:model="editPhotos"
                                            multiple
                                            accept="image/*"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                                        @error('editPhotos.*') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                        
                                        @if($editTempPhotos && count($editTempPhotos) > 0)
                                            <div class="mt-2 flex flex-wrap gap-2 max-h-32 overflow-y-auto p-2 border rounded-lg bg-gray-50 dark:bg-zinc-700/50">
                                                @foreach($editTempPhotos as $index => $photo)
                                                    <div class="relative flex-shrink-0">
                                                        <img src="{{ $photo->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg shadow-md border border-gray-200 dark:border-zinc-600">
                                                        <button type="button" 
                                                                wire:click="removeEditTempPhoto({{ $index }})"
                                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md hover:bg-red-600">
                                                            ×
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Add New Files -->
                                    <div>
                                        <label class="block text-sm font-medium mb-2">Add New Files (PDF, DOC, XLS)</label>
                                        <input type="file" 
                                            wire:model="editFiles"
                                            multiple
                                            accept=".pdf,.doc,.docx,.xls,.xlsx"
                                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                                        @error('editFiles.*') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                        
                                        @if($editTempFiles && count($editTempFiles) > 0)
                                            <div class="mt-2 space-y-1 max-h-32 overflow-y-auto p-2 border rounded-lg bg-gray-50 dark:bg-zinc-700/50">
                                                @foreach($editTempFiles as $index => $file)
                                                    <div class="flex items-center justify-between bg-white dark:bg-zinc-700 p-2 rounded shadow-sm border border-gray-200 dark:border-zinc-600">
                                                        <span class="text-sm truncate flex-1">{{ $file->getClientOriginalName() }}</span>
                                                        <button type="button" 
                                                                wire:click="removeEditTempFile({{ $index }})"
                                                                class="text-red-500 hover:text-red-700 ml-2 flex-shrink-0">
                                                            Remove
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Footer - Fixed -->
                        <div class="p-6 border-t border-gray-200 dark:border-zinc-700 flex-shrink-0">
                            <div class="flex justify-end gap-2">
                                <button type="button" 
                                        @click="open = false; $wire.closeEditFeedbackModal()"
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                                    Cancel
                                </button>
                                <button type="submit" 
                                        form="editFeedbackForm"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Update Feedback
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Delete Confirmation Modal -->
            @if($showDeleteFeedbackModal && $feedbackToDelete)
            <div x-data="{ open: true }" 
                x-show="open"
                @keydown.escape.window="open = false; $wire.closeDeleteFeedbackModal()"
                x-cloak>
                <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.closeDeleteFeedbackModal()"></div>
                <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
                    <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl w-full max-w-md border border-gray-200 dark:border-zinc-700">
                        <div class="p-6">
                            <div class="flex items-center justify-center mb-4">
                                <div class="w-12 h-12 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-lg font-semibold text-center mb-2">Delete Feedback</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 text-center mb-6">
                                Are you sure you want to delete this feedback? This action cannot be undone.
                            </p>
                            <div class="flex justify-center gap-3">
                                <button 
                                    wire:click="closeDeleteFeedbackModal"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                                    Cancel
                                </button>
                                <button 
                                    wire:click="deleteFeedback"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Sidebar -->
        <div class="space-y-4">
            <!-- Status Information -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-amber-600 dark:bg-amber-500 px-4 py-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="font-semibold text-sm text-white">Status Information</h3>
                    </div>
                </div>
                <div class="p-4">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Status:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border border-gray-200 dark:border-gray-700
                                {{ match($ticket->status) {
                                    'Open' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    'In Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                    'Closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300'
                                } }}">
                                {{ $ticket->status }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Priority:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border border-gray-200 dark:border-gray-700
                                {{ match($ticket->priority) {
                                    'Low' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                    'Medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    'Urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    'Critical' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/30 dark:text-purple-300',
                                    default => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300'
                                } }}">
                                {{ $ticket->priority }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">Category:</span>
                            @php
                                $categoryName = $ticket->category->name ?? '-';
                                $isLongCategory = strlen($categoryName) > 20;
                            @endphp
                            
                            @if($isLongCategory && $categoryName !== '-')
                                <div class="relative group">
                                    <span class="font-medium cursor-help border-b border-dashed border-gray-400 dark:border-gray-500">
                                        {{ Str::limit($categoryName, 20) }}
                                    </span>
                                    <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full right-0 mb-2 pointer-events-none">
                                        <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                            <div class="font-semibold text-xs text-gray-300 mb-1">Category</div>
                                            {{ $categoryName }}
                                        </div>
                                        <div class="absolute -bottom-1 right-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                    </div>
                                </div>
                            @else
                                <span class="font-medium">{{ $categoryName }}</span>
                            @endif
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Created:</span>
                            <span>{{ $ticket->created_at instanceof \Carbon\Carbon ? $ticket->created_at->format('d M Y H:i') : \Carbon\Carbon::parse($ticket->created_at)->format('d M Y H:i') }}</span>
                        </div>
                        @if($ticket->closed_at)
                        <div class="flex justify-between">
                            <span class="text-gray-500">Closed:</span>
                            <span>{{ $ticket->closed_at instanceof \Carbon\Carbon ? $ticket->closed_at->format('d M Y H:i') : \Carbon\Carbon::parse($ticket->closed_at)->format('d M Y H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </flux:card>
            
            <!-- Approval Status -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-amber-600 dark:bg-amber-500 px-4 py-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <h3 class="font-semibold text-sm text-white">Approval Status</h3>
                    </div>
                </div>
                <div class="p-4">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">PIC ESD:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border border-gray-200 dark:border-gray-700
                                {{ match($ticket->approval) {
                                    'Approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    'Rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'
                                } }}">
                                {{ $ticket->approval }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-500">User:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border border-gray-200 dark:border-gray-700
                                {{ match($ticket->approval_user) {
                                    'Approved' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                    'Rejected' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300'
                                } }}">
                                {{ $ticket->approval_user }}
                            </span>
                        </div>
                    </div>
                </div>
            </flux:card>
            
            <!-- Requester -->
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-amber-600 dark:bg-amber-500 px-4 py-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <h3 class="font-semibold text-sm text-white">Requester</h3>
                    </div>
                </div>
                <div class="p-4">
                    <div class="space-y-1 text-sm">
                        <div class="font-medium">{{ $ticket->creator->name ?? 'N/A' }}</div>
                        <div class="text-gray-500">{{ $ticket->email_user }}</div>
                        @if($ticket->registration_no)
                            <div class="text-gray-500 text-xs">Reg: {{ $ticket->registration_no }}</div>
                        @endif
                    </div>
                </div>
            </flux:card>
            
            <!-- Assigned To -->
            @if($ticket->assigned_role)
            <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                <div class="bg-amber-600 dark:bg-amber-500 px-4 py-3">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                        <h3 class="font-semibold text-sm text-white">Assigned To</h3>
                    </div>
                </div>
                <div class="p-4">
                    <div class="text-sm">
                        @php
                            $roleMapping = [
                                'ADMINESD' => 'ESD (Electrostatic Discharge)',
                                'ADMINUTILITY' => 'Utility & Building',
                                'ADMINHR' => 'HR (Human Resource)',
                                'ADMINGA' => 'GA (General Affair)',
                            ];
                        @endphp
                        {{ $roleMapping[$ticket->assigned_role] ?? $ticket->assigned_role }}
                    </div>
                </div>
            </flux:card>
            @endif
        </div>
    </div>
    
    <!-- Feedback Modal -->
    @if($showFeedbackModal)
    <div x-data="{ open: true, processing: false }" 
        x-show="open"
        @keydown.escape.window="if(!processing) { open = false; $wire.closeModal() }"
        x-cloak>
        <div class="fixed inset-0 bg-black/50 z-40" @click="if(!processing) { open = false; $wire.closeModal() }"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-xl w-full max-w-2xl my-8 max-h-[90vh] flex flex-col border border-gray-200 dark:border-zinc-700">
                <!-- Header - Fixed -->
                <div class="p-6 border-b border-gray-200 dark:border-zinc-700 flex-shrink-0">
                    <div class="flex justify-between items-center">
                        <h2 class="text-xl font-bold">Add Feedback</h2>
                        <button @click="if(!processing) { open = false; $wire.closeModal() }" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                
                <!-- Scrollable Content -->
                <div class="flex-1 overflow-y-auto p-6">
                    <form wire:submit.prevent="submitFeedback" @submit="processing = true" id="feedbackForm">
                        <div class="space-y-4" x-show="!processing">
                            <div>
                                <label class="block text-sm font-medium mb-2">Status <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach(['Open', 'In Progress', 'Pending', 'Closed'] as $status)
                                        <div 
                                            wire:click="$set('status', '{{ $status }}')"
                                            class="text-center px-3 py-2 border rounded-lg transition-all duration-200 cursor-pointer
                                                {{ $this->status == $status ? 
                                                    ($status == 'Open' ? 'bg-red-100 border-red-500 dark:bg-red-900/50 text-red-900 dark:text-red-200 font-medium shadow-md ring-2 ring-red-400' :
                                                    ($status == 'In Progress' ? 'bg-yellow-100 border-yellow-500 dark:bg-yellow-900/50 text-yellow-900 dark:text-yellow-200 font-medium shadow-md ring-2 ring-yellow-400' :
                                                    ($status == 'Pending' ? 'bg-blue-100 border-blue-500 dark:bg-blue-900/50 text-blue-900 dark:text-blue-200 font-medium shadow-md ring-2 ring-blue-400' :
                                                    'bg-green-100 border-green-500 dark:bg-green-900/50 text-green-900 dark:text-green-200 font-medium shadow-md ring-2 ring-green-400'))) :
                                                    'bg-white dark:bg-zinc-700 border-gray-300 dark:border-zinc-600 hover:bg-gray-50 dark:hover:bg-zinc-600 text-gray-700 dark:text-gray-300' }}">
                                            {{ $status }}
                                        </div>
                                    @endforeach
                                </div>
                                @error('status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2">Comments <span class="text-red-500">*</span></label>
                                <textarea 
                                    wire:model="comments"
                                    rows="4"
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                    placeholder="Enter your feedback..."></textarea>
                                @error('comments') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2">Photos</label>
                                <input type="file" 
                                    wire:model="photos"
                                    multiple
                                    accept="image/*"
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                                @error('photos.*') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                
                                @if($tempPhotos)
                                    <div class="mt-2 flex flex-wrap gap-2 max-h-32 overflow-y-auto p-2 border rounded-lg bg-gray-50 dark:bg-zinc-700/50">
                                        @foreach($tempPhotos as $index => $photo)
                                            <div class="relative flex-shrink-0">
                                                <img src="{{ $photo->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg shadow-md border border-gray-200 dark:border-zinc-600">
                                                <button type="button" 
                                                        wire:click="removeTempPhoto({{ $index }})"
                                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md hover:bg-red-600">
                                                    ×
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2">Files (PDF, DOC, XLS)</label>
                                <input type="file" 
                                    wire:model="files"
                                    multiple
                                    accept=".pdf,.doc,.docx,.xls,.xlsx"
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                                @error('files.*') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                                
                                @if($tempFiles)
                                    <div class="mt-2 space-y-1 max-h-32 overflow-y-auto p-2 border rounded-lg bg-gray-50 dark:bg-zinc-700/50">
                                        @foreach($tempFiles as $index => $file)
                                            <div class="flex items-center justify-between bg-white dark:bg-zinc-700 p-2 rounded shadow-sm border border-gray-200 dark:border-zinc-600">
                                                <span class="text-sm truncate flex-1">{{ $file->getClientOriginalName() }}</span>
                                                <button type="button" 
                                                        wire:click="removeTempFile({{ $index }})"
                                                        class="text-red-500 hover:text-red-700 ml-2 flex-shrink-0">
                                                    Remove
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Loading Overlay -->
                        <div x-show="processing" 
                            x-cloak
                            class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
                            style="display: none;">
                            <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-2xl p-8 max-w-md mx-4 text-center border border-gray-200 dark:border-zinc-700">
                                <div class="relative">
                                    <div class="w-20 h-20 mx-auto mb-4">
                                        <svg class="animate-spin h-20 w-20 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                    </div>
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                    Processing Feedback
                                </h3>
                                <div class="space-y-3 mt-4">
                                    <div class="flex items-center justify-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                        <svg class="animate-pulse w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Saving feedback...</span>
                                    </div>
                                    <div class="flex items-center justify-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                        <svg class="animate-spin w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                        </svg>
                                        <span>Sending email to PIC...</span>
                                    </div>
                                    <div class="flex items-center justify-center gap-2 text-sm text-gray-600 dark:text-gray-300">
                                        <svg class="animate-pulse w-4 h-4 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                        </svg>
                                        <span>Sending email to User...</span>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                                    Please wait, this may take a few seconds...
                                </p>
                            </div>
                        </div>
                    </form>
                </div>
                
                <!-- Footer - Fixed -->
                <div class="p-6 border-t border-gray-200 dark:border-zinc-700 flex-shrink-0">
                    <div class="flex justify-end gap-2" x-show="!processing">
                        <button type="button" 
                                @click="open = false; $wire.closeModal()"
                                class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-700 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                form="feedbackForm"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors shadow-lg hover:shadow-xl">
                            Submit Feedback
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>