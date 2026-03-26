<div class="p-1 space-y-2">
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Ticketing Support
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Ticket List
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Ticket Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage and track all support tickets
            </p>
        </div>

        <!-- Create Ticket Button -->
        @can('create tickets')
        <flux:button 
            variant="primary" 
            icon="plus" 
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="$set('showCreateModal', true)"
        >
            Create New Ticket
        </flux:button>
        @endcan
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <flux:input
            wire:model.live.debounce.300ms="search"
            placeholder="Search by ticket number or title..."
            icon="magnifying-glass"
            clearable
        />
        
        <div>
            <select wire:model.live="statusFilter" 
                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                <option value="">All Status</option>
                @foreach($statusOptions as $status)
                    <option value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>
        
        <flux:input 
            type="date" 
            wire:model.live="dateFrom" 
            placeholder="From Date"
        />
        
        <flux:input 
            type="date" 
            wire:model.live="dateTo" 
            placeholder="To Date"
        />
    </div>

    <!-- Tickets Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Ticket #</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Priority</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Requester</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Created</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($tickets as $index => $ticket)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="ticket-{{ $ticket->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400">
                            {{ $tickets->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm font-mono font-semibold text-blue-600 dark:text-blue-400">
                                {{ $ticket->ticket_number }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-zinc-800 dark:text-white max-w-xs truncate" title="{{ $ticket->title }}">
                                {{ Str::limit($ticket->title, 40) }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <flux:badge size="sm" color="{{ match($ticket->status) {
                                'Open' => 'danger',
                                'In Progress' => 'warning',
                                'Pending' => 'info',
                                'Closed' => 'success',
                                default => 'gray'
                            } }}">
                                {{ $ticket->status }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3">
                            <flux:badge size="sm" color="{{ match($ticket->priority) {
                                'Low' => 'gray',
                                'Medium' => 'warning',
                                'Urgent' => 'danger',
                                'Critical' => 'primary',
                                default => 'gray'
                            } }}">
                                {{ $ticket->priority }}
                            </flux:badge>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                {{ $ticket->category->name ?? '-' }}
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm">
                                <div class="text-zinc-800 dark:text-white">{{ $ticket->creator->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $ticket->email_user }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm">
                                <div class="text-zinc-600 dark:text-zinc-400">{{ $ticket->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-zinc-500">{{ $ticket->created_at->format('H:i') }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="flex items-center justify-end gap-1">
                                <!-- View -->
                                <flux:button 
                                    wire:click="viewTicket({{ $ticket->id }})"
                                    size="sm"
                                    icon="eye"
                                    class="!p-2 text-green-600 hover:bg-green-50 dark:text-green-400 dark:hover:bg-green-950/50"
                                    title="View ticket"
                                />
                                
                                <!-- Timeline -->
                                <flux:button 
                                    wire:click="showTimelineModal({{ $ticket->id }})"
                                    size="sm"
                                    icon="clock"
                                    class="!p-2 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-950/50"
                                    title="Activity timeline"
                                />
                                
                                <!-- Edit (only if allowed) -->
                                @if(!in_array($ticket->status, ['In Progress', 'Pending', 'Closed']) && $ticket->created_at > now()->subHours(24))
                                @can('edit tickets')
                                <flux:button 
                                    wire:click="editTicket({{ $ticket->id }})"
                                    size="sm"
                                    icon="pencil-square"
                                    class="!p-2 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/50"
                                    title="Edit ticket"
                                />
                                @endcan
                                @endif
                                
                                <!-- Delete -->
                                @can('delete tickets')
                                <flux:button 
                                    wire:click="confirmDelete({{ $ticket->id }})"
                                    size="sm"
                                    icon="trash"
                                    class="!p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50"
                                    title="Delete ticket"
                                />
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <flux:icon name="ticket" class="w-10 h-10 text-zinc-400 dark:text-zinc-500" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No tickets found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new ticket' }}
                                    </p>
                                </div>
                                @if($search)
                                    <flux:button wire:click="$set('search', '')" size="sm">
                                        Clear Search
                                    </flux:button>
                                @else
                                    @can('create tickets')
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="$set('showCreateModal', true)"
                                    >
                                        Create Your First Ticket
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
        @if($tickets->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $tickets->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL CREATE TICKET -->
    @if($showCreateModal)
    <div x-data="{ open: true }" 
         x-show="open"
         @keydown.escape.window="open = false; $wire.closeModal()"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.closeModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-3xl my-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Create New Ticket</h2>
                        <button @click="open = false; $wire.closeModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Wizard Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between">
                            @for($i = 1; $i <= $totalSteps; $i++)
                                <div class="flex items-center flex-1">
                                    <div class="relative">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center {{ $currentStep >= $i ? 'bg-blue-600 text-white' : 'bg-gray-200 dark:bg-zinc-700 text-gray-500' }}">
                                            {{ $i }}
                                        </div>
                                        @if($i < $totalSteps)
                                            <div class="absolute top-4 left-8 w-full h-0.5 {{ $currentStep > $i ? 'bg-blue-600' : 'bg-gray-200 dark:bg-zinc-700' }}"></div>
                                        @endif
                                    </div>
                                    <span class="ml-2 text-sm {{ $currentStep >= $i ? 'text-blue-600 font-medium' : 'text-gray-500' }}">
                                        {{ $i == 1 ? 'Ticket Info' : ($i == 2 ? 'Details & Upload' : 'Categorization') }}
                                    </span>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <form wire:submit.prevent="createTicket">
                        <!-- Step 1: Ticket Information -->
                        @if($currentStep == 1)
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Ticket Number</label>
                                    <input type="text" 
                                           wire:model="ticket_number"
                                           disabled
                                           class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-zinc-800 dark:border-zinc-700">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                           wire:model="title"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter ticket title">
                                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                                    <input type="email" 
                                           wire:model="email_user"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @error('email_user') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Registration Number</label>
                                    <input type="text" 
                                           wire:model="registration_no"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                           placeholder="Enter registration number (optional)">
                                </div>
                            </div>
                        @endif

                        <!-- Step 2: Details & Upload -->
                        @if($currentStep == 2)
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
                                    <textarea 
                                        wire:model="description"
                                        rows="6"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="Describe your issue in detail..."></textarea>
                                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Attachments (Images)</label>
                                    <input type="file" 
                                           wire:model="files"
                                           multiple
                                           accept="image/*"
                                           class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500">
                                    @error('files.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    
                                    @if($tempFiles)
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @foreach($tempFiles as $index => $file)
                                                <div class="relative">
                                                    <img src="{{ $file->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg">
                                                    <button type="button" 
                                                            wire:click="removeTempFile({{ $index }})"
                                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                                        ×
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                    <p class="text-xs text-zinc-500 mt-1">You can upload multiple images (max 10MB each)</p>
                                </div>
                            </div>
                        @endif

                        <!-- Step 3: Categorization & Priority -->
                        @if($currentStep == 3)
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Priority <span class="text-red-500">*</span></label>
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach(['Low', 'Medium', 'Urgent', 'Critical'] as $prio)
                                            <label class="cursor-pointer">
                                                <input type="radio" 
                                                       wire:model="priority" 
                                                       value="{{ $prio }}"
                                                       class="hidden peer">
                                                <div class="text-center px-4 py-2 border rounded-lg transition-all
                                                    {{ $priority == $prio ? 
                                                        ($prio == 'Low' ? 'bg-gray-100 border-gray-400 dark:bg-gray-700' :
                                                         ($prio == 'Medium' ? 'bg-yellow-100 border-yellow-400 dark:bg-yellow-900/30' :
                                                          ($prio == 'Urgent' ? 'bg-red-100 border-red-400 dark:bg-red-900/30' :
                                                           'bg-purple-100 border-purple-400 dark:bg-purple-900/30'))) :
                                                        'bg-white dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 hover:bg-gray-50' }}">
                                                    {{ $prio }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Assign To Section</label>
                                    <select wire:model="assigned_role" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <option value="ADMINESD">ESD (Electrostatic Discharge)</option>
                                        @can('assign to other sections')
                                            <option value="ADMINUTILITY">Utility & Building</option>
                                            <option value="ADMINHR">HR (Human Resource)</option>
                                            <option value="ADMINGA">GA (General Affair)</option>
                                        @endcan
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                                    <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto border rounded-lg p-2">
                                        @foreach($categories as $category)
                                            <label class="flex items-center gap-2 p-2 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-zinc-800 border transition-all
                                                {{ $category_id == $category->id ? 'bg-blue-50 dark:bg-blue-900/20 border-blue-500' : 'border-gray-200 dark:border-zinc-700' }}">
                                                <input type="radio" 
                                                       wire:model="category_id" 
                                                       value="{{ $category->id }}"
                                                       class="text-blue-600">
                                                <span class="text-sm">{{ $category->name }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                    @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                            </div>
                        @endif

                        <!-- Navigation Buttons -->
                        <div class="flex justify-between mt-6 pt-4 border-t">
                            @if($currentStep > 1)
                                <button type="button" 
                                        wire:click="previousStep"
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                    Previous
                                </button>
                            @else
                                <div></div>
                            @endif
                            
                            @if($currentStep < $totalSteps)
                                <button type="button" 
                                        wire:click="nextStep"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    Next
                                </button>
                            @else
                                <button type="submit" 
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    Create Ticket
                                </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL VIEW TICKET -->
    @if($showViewModal && $selectedTicket)
    <div x-data="{ open: true }" 
         x-show="open"
         @keydown.escape.window="open = false; $wire.closeModal()"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.closeModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-4xl my-8">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h2 class="text-xl font-bold">Ticket Details</h2>
                            <p class="text-sm text-gray-500">#{{ $selectedTicket->ticket_number }}</p>
                        </div>
                        <button @click="open = false; $wire.closeModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <!-- Main Content -->
                        <div class="lg:col-span-2 space-y-4">
                            <div>
                                <h3 class="font-semibold mb-1 text-sm text-gray-600 dark:text-gray-400">Title</h3>
                                <p class="text-gray-700 dark:text-gray-300">{{ $selectedTicket->title }}</p>
                            </div>
                            
                            <div>
                                <h3 class="font-semibold mb-1 text-sm text-gray-600 dark:text-gray-400">Description</h3>
                                <div class="prose dark:prose-invert max-w-none bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                    {!! nl2br(e($selectedTicket->description)) !!}
                                </div>
                            </div>
                            
                            @if($selectedTicket->file)
                            <div>
                                <h3 class="font-semibold mb-2 text-sm text-gray-600 dark:text-gray-400">Attachments</h3>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($selectedTicket->file as $file)
                                        <a href="{{ Storage::url($file) }}" target="_blank" class="block">
                                            <img src="{{ Storage::url($file) }}" class="w-24 h-24 object-cover rounded-lg hover:opacity-80 transition-opacity">
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Sidebar -->
                        <div class="space-y-4">
                            <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                <h3 class="font-semibold mb-2 text-sm">Status Information</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Status:</span>
                                        <flux:badge size="sm" color="{{ match($selectedTicket->status) {
                                            'Open' => 'danger',
                                            'In Progress' => 'warning',
                                            'Pending' => 'info',
                                            'Closed' => 'success',
                                            default => 'gray'
                                        } }}">
                                            {{ $selectedTicket->status }}
                                        </flux:badge>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Priority:</span>
                                        <flux:badge size="sm" color="{{ match($selectedTicket->priority) {
                                            'Low' => 'gray',
                                            'Medium' => 'warning',
                                            'Urgent' => 'danger',
                                            'Critical' => 'primary',
                                            default => 'gray'
                                        } }}">
                                            {{ $selectedTicket->priority }}
                                        </flux:badge>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Category:</span>
                                        <span class="font-medium">{{ $selectedTicket->category->name ?? '-' }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Created:</span>
                                        <span>{{ $selectedTicket->created_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @if($selectedTicket->closed_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">Closed:</span>
                                        <span>{{ $selectedTicket->closed_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                <h3 class="font-semibold mb-2 text-sm">Approval Status</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">PIC ESD:</span>
                                        <flux:badge size="sm" color="{{ match($selectedTicket->approval) {
                                            'Approved' => 'success',
                                            'Rejected' => 'danger',
                                            default => 'warning'
                                        } }}">
                                            {{ $selectedTicket->approval }}
                                        </flux:badge>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">User:</span>
                                        <flux:badge size="sm" color="{{ match($selectedTicket->approval_user) {
                                            'Approved' => 'success',
                                            'Rejected' => 'danger',
                                            default => 'warning'
                                        } }}">
                                            {{ $selectedTicket->approval_user }}
                                        </flux:badge>
                                    </div>
                                    @if($selectedTicket->approval_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">PIC Approval Date:</span>
                                        <span>{{ $selectedTicket->approval_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @endif
                                    @if($selectedTicket->approval_user_at)
                                    <div class="flex justify-between">
                                        <span class="text-gray-500">User Approval Date:</span>
                                        <span>{{ $selectedTicket->approval_user_at->format('d M Y H:i') }}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                <h3 class="font-semibold mb-2 text-sm">Requester</h3>
                                <div class="space-y-1 text-sm">
                                    <div class="font-medium">{{ $selectedTicket->creator->name ?? 'N/A' }}</div>
                                    <div class="text-gray-500">{{ $selectedTicket->email_user }}</div>
                                    @if($selectedTicket->registration_no)
                                        <div class="text-gray-500 text-xs">Reg: {{ $selectedTicket->registration_no }}</div>
                                    @endif
                                </div>
                            </div>

                            @if($selectedTicket->assigned_role)
                            <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                <h3 class="font-semibold mb-2 text-sm">Assigned To</h3>
                                <div class="text-sm">
                                    @php
                                        $roleMapping = [
                                            'ADMINESD' => 'ESD (Electrostatic Discharge)',
                                            'ADMINUTILITY' => 'Utility & Building',
                                            'ADMINHR' => 'HR (Human Resource)',
                                            'ADMINGA' => 'GA (General Affair)',
                                        ];
                                    @endphp
                                    {{ $roleMapping[$selectedTicket->assigned_role] ?? $selectedTicket->assigned_role }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL EDIT TICKET -->
    @if($showEditModal && $selectedTicket)
    <div x-data="{ open: true }" 
         x-show="open"
         @keydown.escape.window="open = false; $wire.closeModal()"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.closeModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl my-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Edit Ticket</h2>
                        <button @click="open = false; $wire.closeModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <form wire:submit.prevent="updateTicket">
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
                                <input type="text" 
                                       wire:model="title"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
                                <textarea 
                                    wire:model="description"
                                    rows="6"
                                    class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Priority <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach(['Low', 'Medium', 'Urgent', 'Critical'] as $prio)
                                        <label class="cursor-pointer">
                                            <input type="radio" 
                                                   wire:model="priority" 
                                                   value="{{ $prio }}"
                                                   class="hidden peer">
                                            <div class="text-center px-4 py-2 border rounded-lg transition-all
                                                {{ $priority == $prio ? 
                                                    ($prio == 'Low' ? 'bg-gray-100 border-gray-400 dark:bg-gray-700' :
                                                     ($prio == 'Medium' ? 'bg-yellow-100 border-yellow-400 dark:bg-yellow-900/30' :
                                                      ($prio == 'Urgent' ? 'bg-red-100 border-red-400 dark:bg-red-900/30' :
                                                       'bg-purple-100 border-purple-400 dark:bg-purple-900/30'))) :
                                                    'bg-white dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 hover:bg-gray-50' }}">
                                                {{ $prio }}
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                                @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                                <select wire:model="category_id" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Assign To Section</label>
                                <select wire:model="assigned_role" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="ADMINESD">ESD (Electrostatic Discharge)</option>
                                    @can('assign to other sections')
                                        <option value="ADMINUTILITY">Utility & Building</option>
                                        <option value="ADMINHR">HR (Human Resource)</option>
                                        <option value="ADMINGA">GA (General Affair)</option>
                                    @endcan
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Email</label>
                                <input type="email" 
                                       wire:model="email_user"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Registration Number</label>
                                <input type="text" 
                                       wire:model="registration_no"
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                        
                        <div class="flex justify-end gap-2 mt-6 pt-4 border-t">
                            <button type="button" 
                                    @click="open = false; $wire.closeModal()"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                Update Ticket
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL DELETE CONFIRMATION -->
    @if($showDeleteModal && $ticketToDelete)
    <div x-data="{ open: true }" 
         x-show="open"
         @keydown.escape.window="open = false; $wire.closeModal()"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.closeModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-red-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>

                <h3 class="text-lg font-bold mb-2">Delete Ticket</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to delete ticket <strong>"{{ $ticketToDelete->ticket_number }}"</strong>?
                    <br>
                    <span class="text-sm text-red-500">This action cannot be undone.</span>
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="open = false; $wire.closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="deleteTicket" 
                            class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- MODAL TIMELINE -->
    @if($showTimeline && $timelineTicket)
    <div x-data="{ open: true }" 
         x-show="open"
         @keydown.escape.window="open = false; $wire.closeModal()"
         x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false; $wire.closeModal()"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl my-8">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Activity Timeline</h2>
                        <button @click="open = false; $wire.closeModal()" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="relative">
                        <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-zinc-700"></div>
                        <div class="space-y-6">
                            @foreach($timelineTicket->getActivityTimeline() as $activity)
                                <div class="relative flex gap-4">
                                    <div class="flex-shrink-0 z-10">
                                        <div class="w-8 h-8 rounded-full flex items-center justify-center 
                                            {{ $activity['status'] == 'open' ? 'bg-green-100 text-green-600' : 
                                               ($activity['status'] == 'in_progress' ? 'bg-yellow-100 text-yellow-600' : 
                                                ($activity['status'] == 'pending' ? 'bg-orange-100 text-orange-600' : 
                                                 'bg-gray-100 text-gray-600')) }}">
                                            @if($activity['status'] == 'open')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                            @elseif($activity['status'] == 'in_progress')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                            @elseif($activity['status'] == 'pending')
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="bg-gray-50 dark:bg-zinc-800 p-4 rounded-lg">
                                            <h4 class="font-semibold text-sm">{{ $activity['title'] }}</h4>
                                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">{{ $activity['description'] }}</p>
                                            <p class="text-xs text-gray-500 mt-2">{{ $activity['created_at']->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Notification -->
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