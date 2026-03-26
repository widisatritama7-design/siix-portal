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
    <div class="space-y-4">
        <!-- Search and Date Filters - Full Width -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <flux:input
                wire:model.live.debounce.300ms="search"
                placeholder="Search by ticket number or title..."
                icon="magnifying-glass"
                clearable
                class="md:col-span-2"
            />
            
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
        
        <!-- Status Tabs - Bottom Border Style -->
        <div class="border-b border-zinc-200 dark:border-zinc-700">
            <div class="flex flex-wrap gap-1">
                <button 
                    wire:click="setStatusFilter('')"
                    class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative {{ $statusFilter === '' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                >
                    All Tickets
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $statusFilter === '' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                        {{ $totalTicketsCount ?? $tickets->total() }}
                    </span>
                    @if($statusFilter === '')
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div>
                    @endif
                </button>
                
                <button 
                    wire:click="setStatusFilter('Open')"
                    class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative {{ $statusFilter === 'Open' ? 'text-red-600 dark:text-red-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                >
                    Open
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $statusFilter === 'Open' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                        {{ $statusCounts['Open'] ?? 0 }}
                    </span>
                    @if($statusFilter === 'Open')
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-red-600 dark:bg-red-400 rounded-t-full"></div>
                    @endif
                </button>
                
                <button 
                    wire:click="setStatusFilter('In Progress')"
                    class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative {{ $statusFilter === 'In Progress' ? 'text-yellow-600 dark:text-yellow-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                >
                    In Progress
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $statusFilter === 'In Progress' ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                        {{ $statusCounts['In Progress'] ?? 0 }}
                    </span>
                    @if($statusFilter === 'In Progress')
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-yellow-600 dark:bg-yellow-400 rounded-t-full"></div>
                    @endif
                </button>
                
                <button 
                    wire:click="setStatusFilter('Pending')"
                    class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative {{ $statusFilter === 'Pending' ? 'text-blue-600 dark:text-blue-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                >
                    Pending
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $statusFilter === 'Pending' ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                        {{ $statusCounts['Pending'] ?? 0 }}
                    </span>
                    @if($statusFilter === 'Pending')
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-blue-600 dark:bg-blue-400 rounded-t-full"></div>
                    @endif
                </button>
                
                <button 
                    wire:click="setStatusFilter('Closed')"
                    class="px-5 py-2.5 text-sm font-medium transition-all duration-200 relative {{ $statusFilter === 'Closed' ? 'text-green-600 dark:text-green-400' : 'text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-200' }}"
                >
                    Closed
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full {{ $statusFilter === 'Closed' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-zinc-800 dark:text-gray-400' }}">
                        {{ $statusCounts['Closed'] ?? 0 }}
                    </span>
                    @if($statusFilter === 'Closed')
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-green-600 dark:bg-green-400 rounded-t-full"></div>
                    @endif
                </button>
            </div>
        </div>
    </div>

    <!-- Tickets Table -->
    <flux:card class="p-6 h-full shadow-lg hover:shadow-xl transition-shadow duration-300 mt-6">
        <div class="overflow-x-auto">
            <table class="w-full min-w-max">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Ticket #</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Title</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Priority</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Requester</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Created</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($tickets as $index => $ticket)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors" wire:key="ticket-{{ $ticket->id }}">
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400 whitespace-nowrap">
                            {{ $tickets->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm font-mono font-semibold text-blue-600 dark:text-blue-400">
                                {{ $ticket->ticket_number }}
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $title = $ticket->title;
                                $isLongText = strlen($title) > 25;
                            @endphp
                            
                            @if($isLongText)
                                <div class="relative group inline-block">
                                    <div class="text-sm text-zinc-800 dark:text-white cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                        {{ Str::limit($title, 25) }}
                                    </div>
                                    <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                        <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                            <div class="font-semibold text-xs text-gray-300 mb-1">Title</div>
                                            {{ $title }}
                                        </div>
                                        <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                    </div>
                                </div>
                            @else
                                <div class="text-sm text-zinc-800 dark:text-white">
                                    {{ $title }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $statusColors = [
                                    'Open' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    'In Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    'Pending' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                    'Closed' => 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300',
                                ];
                                $statusColor = $statusColors[$ticket->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                {{ $ticket->status }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $priorityColors = [
                                    'Low' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
                                    'Medium' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                                    'Urgent' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                    'Critical' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                                ];
                                $priorityColor = $priorityColors[$ticket->priority] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300';
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $priorityColor }}">
                                {{ $ticket->priority }}
                            </span>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @php
                                $categoryName = $ticket->category->name ?? '-';
                                $isLongText = strlen($categoryName) > 25;
                            @endphp
                            
                            @if($isLongText && $categoryName !== '-')
                                <div class="relative group inline-block">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400 cursor-help border-b border-dashed border-zinc-400 dark:border-zinc-500">
                                        {{ Str::limit($categoryName, 25) }}
                                    </div>
                                    <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 bottom-full left-0 mb-2 pointer-events-none">
                                        <div class="bg-gray-900 dark:bg-gray-800 text-white rounded-lg shadow-lg px-3 py-2 text-sm whitespace-normal max-w-xs">
                                            <div class="font-semibold text-xs text-gray-300 mb-1">Category</div>
                                            {{ $categoryName }}
                                        </div>
                                        <div class="absolute -bottom-1 left-4 w-2 h-2 bg-gray-900 dark:bg-gray-800 transform rotate-45"></div>
                                    </div>
                                </div>
                            @else
                                <div class="text-sm text-zinc-600 dark:text-zinc-400">
                                    {{ $categoryName }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm">
                                <div class="text-zinc-800 dark:text-white">{{ $ticket->creator->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $ticket->email_user }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="text-sm">
                                <div class="text-zinc-600 dark:text-zinc-400">{{ $ticket->created_at->format('d M Y') }}</div>
                                <div class="text-xs text-zinc-500">{{ $ticket->created_at->format('H:i') }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1">
                                <!-- View - Ghost Emerald (lebih subtle) -->
                                <flux:tooltip content="View">
                                    <flux:button 
                                        href="{{ route('ticket.show', $ticket->id) }}"
                                        size="sm"
                                        icon="eye"
                                        variant="primary"
                                        color="blue"
                                        class="!p-2"
                                        title="View ticket"
                                    />
                                </flux:tooltip>

                                <!-- PIC Approval Button - Primary Purple -->
                                @if($ticket->approval === 'Waiting Approval' && auth()->user()->can('approve tickets', $ticket))
                                <flux:tooltip content="PIC Approval">
                                    <flux:button 
                                        wire:click="openPicApprovalModal({{ $ticket->id }})"
                                        size="sm"
                                        icon="check-badge"
                                        variant="primary"
                                        color="purple"
                                        class="!p-2"
                                        title="PIC Approval"
                                    />
                                </flux:tooltip>
                                @endif
                                
                                <!-- User Approval Button - Primary Teal -->
                                @if($ticket->approval_user === 'Waiting Approval' && auth()->user()->can('check tickets', $ticket))
                                <flux:tooltip content="User Approval">
                                    <flux:button 
                                        wire:click="openUserApprovalModal({{ $ticket->id }})"
                                        size="sm"
                                        icon="check-circle"
                                        variant="primary"
                                        color="teal"
                                        class="!p-2"
                                        title="User Approval"
                                    />
                                </flux:tooltip>
                                @endif
                                
                                <!-- Edit - Outline Blue (lebih ringan) -->
                                @if(!in_array($ticket->status, ['In Progress', 'Pending', 'Closed']) && $ticket->created_at > now()->subHours(24))
                                @can('edit tickets')
                                <flux:tooltip content="Edit">
                                    <flux:button 
                                        wire:click="editTicket({{ $ticket->id }})"
                                        size="sm"
                                        icon="pencil-square"
                                        variant="outline"
                                        color="blue"
                                        class="!p-2"
                                        title="Edit ticket"
                                    />
                                </flux:tooltip>
                                @endcan
                                @endif
                                
                                <!-- Delete - Primary Red -->
                                @can('delete tickets')
                                <flux:tooltip content="Delete">
                                    <flux:button 
                                        wire:click="confirmDelete({{ $ticket->id }})"
                                        size="sm"
                                        icon="trash"
                                        variant="primary"
                                        color="red"
                                        class="!p-2"
                                        title="Delete ticket"
                                    />
                                </flux:tooltip>
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
    <div x-data="{ open: true, processing: false }" 
        x-show="open"
        @keydown.escape.window="if(!processing) { open = false; $wire.closeModal() }"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="if(!processing) { open = false; $wire.closeModal() }"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-3xl my-8 transition-all duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                            Create New Ticket
                        </h2>
                        <button @click="if(!processing) { open = false; $wire.closeModal() }" 
                                class="text-gray-500 hover:text-gray-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Enhanced Wizard Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between relative">
                            @for($i = 1; $i <= $totalSteps; $i++)
                                <div class="flex flex-col items-center flex-1 relative z-10">
                                    <div class="relative">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 
                                            {{ $currentStep >= $i ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'bg-gray-200 dark:bg-zinc-700 text-gray-500' }}
                                            {{ $currentStep == $i ? 'ring-4 ring-blue-200 dark:ring-blue-900/50 scale-110' : '' }}">
                                            @if($currentStep > $i)
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            @else
                                                {{ $i }}
                                            @endif
                                        </div>
                                    </div>
                                    <span class="mt-2 text-xs font-medium {{ $currentStep >= $i ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500' }}">
                                        {{ $i == 1 ? 'Ticket Info' : ($i == 2 ? 'Details & Upload' : 'Categorization') }}
                                    </span>
                                </div>
                                @if($i < $totalSteps)
                                    <div class="flex-1 h-0.5 {{ $currentStep > $i ? 'bg-gradient-to-r from-blue-500 to-blue-600' : 'bg-gray-200 dark:bg-zinc-700' }} relative -ml-2 -mr-2 z-0"></div>
                                @endif
                            @endfor
                        </div>
                    </div>

                    <form wire:submit.prevent="createTicket" @submit="processing = true">
                        <!-- Step 1: Ticket Information -->
                        @if($currentStep == 1)
                            <div class="space-y-4 animate-fadeIn">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Ticket Number</label>
                                    <input type="text" 
                                        wire:model="ticket_number"
                                        disabled
                                        class="w-full px-3 py-2 border rounded-lg bg-gray-50 dark:bg-zinc-800 dark:border-zinc-700 font-mono text-sm">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Title <span class="text-red-500">*</span></label>
                                    <input type="text" 
                                        wire:model="title"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="Enter ticket title">
                                    @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Email <span class="text-red-500">*</span></label>
                                    <input type="email" 
                                        wire:model="email_user"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    @error('email_user') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Registration Number</label>
                                    <input type="text" 
                                        wire:model="registration_no"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="Enter registration number (optional)">
                                </div>
                            </div>
                        @endif

                        <!-- Step 2: Details & Upload -->
                        @if($currentStep == 2)
                            <div class="space-y-4 animate-fadeIn">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Description <span class="text-red-500">*</span></label>
                                    <textarea 
                                        wire:model="description"
                                        rows="6"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="Describe your issue in detail..."></textarea>
                                    @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Attachments (Images)</label>
                                    <input type="file" 
                                        wire:model="files"
                                        multiple
                                        accept="image/*"
                                        class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 transition-all">
                                    @error('files.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                    
                                    @if($tempFiles)
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            @foreach($tempFiles as $index => $file)
                                                <div class="relative group">
                                                    <img src="{{ $file->temporaryUrl() }}" class="w-20 h-20 object-cover rounded-lg shadow-md">
                                                    <button type="button" 
                                                            wire:click="removeTempFile({{ $index }})"
                                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs hover:bg-red-600 transition-colors">
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
                            <div class="space-y-4 animate-fadeIn">
                                <div>
                                    <label class="block text-sm font-medium mb-1">Priority <span class="text-red-500">*</span></label>
                                    <div class="grid grid-cols-4 gap-2">
                                        @foreach(['Low', 'Medium', 'Urgent', 'Critical'] as $prio)
                                            <div 
                                                wire:click="$set('priority', '{{ $prio }}')"
                                                class="text-center px-4 py-2 border rounded-lg transition-all duration-200 cursor-pointer
                                                    {{ $priority == $prio ? 
                                                        ($prio == 'Low' ? 'bg-gray-100 border-gray-500 dark:bg-gray-700 text-gray-900 dark:text-white font-medium shadow-md ring-2 ring-gray-400' :
                                                        ($prio == 'Medium' ? 'bg-yellow-100 border-yellow-500 dark:bg-yellow-900/50 text-yellow-900 dark:text-yellow-200 font-medium shadow-md ring-2 ring-yellow-400' :
                                                        ($prio == 'Urgent' ? 'bg-red-100 border-red-500 dark:bg-red-900/50 text-red-900 dark:text-red-200 font-medium shadow-md ring-2 ring-red-400' :
                                                        'bg-purple-100 border-purple-500 dark:bg-purple-900/50 text-purple-900 dark:text-purple-200 font-medium shadow-md ring-2 ring-purple-400'))) :
                                                        'bg-white dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 text-gray-700 dark:text-gray-300' }}">
                                                {{ $prio }}
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('priority') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-1">Assign To Section</label>
                                    <select wire:model="assigned_role" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
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
                                    <div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto border rounded-lg p-2 bg-gray-50 dark:bg-zinc-800/50">
                                        @foreach($categories as $category)
                                            <label class="flex items-center gap-2 p-2 rounded-lg cursor-pointer transition-all duration-200
                                                {{ $category_id == $category->id ? 'bg-blue-50 dark:bg-blue-900/20 border border-blue-500 shadow-sm' : 'hover:bg-gray-100 dark:hover:bg-zinc-700 border border-transparent' }}">
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
                        <div class="flex justify-between mt-6 pt-4 border-t dark:border-zinc-700">
                            @if($currentStep > 1)
                                <button type="button" 
                                        wire:click="previousStep"
                                        class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all duration-200">
                                    ← Previous
                                </button>
                            @else
                                <div></div>
                            @endif
                            
                            @if($currentStep < $totalSteps)
                                <button type="button" 
                                        wire:click="nextStep"
                                        class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                    Next →
                                </button>
                            @else
                                <button type="submit" 
                                        x-bind:disabled="processing"
                                        class="px-6 py-2 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed relative">
                                    <span x-show="!processing">Create Ticket</span>
                                    <span x-show="processing" class="flex items-center gap-2">
                                        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        Processing...
                                    </span>
                                </button>
                            @endif
                        </div>
                    </form>
                    
                    <!-- Processing Modal Overlay -->
                    <div x-show="processing" 
                        x-cloak
                        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
                        style="display: none;">
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-2xl p-8 max-w-md mx-4 text-center animate-pulse">
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
                                Creating Ticket
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 mb-3">
                                Please wait while we process your request...
                            </p>
                            <div class="space-y-2">
                                <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="animate-bounce w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span>Saving ticket information...</span>
                                </div>
                                <div class="flex items-center justify-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                                    <svg class="animate-spin w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>Sending email notifications to PIC...</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <div x-data="{ open: true, processing: false, currentStep: 1, totalSteps: 3 }" 
        x-show="open"
        @keydown.escape.window="if(!processing) { open = false; $wire.closeModal() }"
        x-cloak>

        <div class="fixed inset-0 bg-black/50 z-40" @click="if(!processing) { open = false; $wire.closeModal() }"></div>

        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-3xl my-8 transition-all duration-300">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Edit Ticket
                            </h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Ticket #: <span class="font-mono font-semibold text-blue-600 dark:text-blue-400">{{ $selectedTicket->ticket_number ?? '' }}</span>
                            </p>
                        </div>
                        <button @click="if(!processing) { open = false; $wire.closeModal() }" 
                                class="text-gray-500 hover:text-gray-700 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Wizard Steps -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between relative">
                            <div class="flex flex-col items-center flex-1 relative z-10">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300" 
                                        :class="currentStep >= 1 ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'bg-gray-200 dark:bg-zinc-700 text-gray-500'"
                                        :style="currentStep == 1 ? 'ring: 4px solid rgba(59,130,246,0.2); transform: scale(1.1);' : ''">
                                        <template x-if="currentStep > 1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </template>
                                        <template x-if="currentStep <= 1">
                                            <span>1</span>
                                        </template>
                                    </div>
                                </div>
                                <span class="mt-2 text-xs font-medium" :class="currentStep >= 1 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500'">
                                    Basic Info
                                </span>
                            </div>
                            <div class="flex-1 h-0.5 relative -ml-2 -mr-2 z-0" :class="currentStep > 1 ? 'bg-gradient-to-r from-blue-500 to-blue-600' : 'bg-gray-200 dark:bg-zinc-700'"></div>
                            
                            <div class="flex flex-col items-center flex-1 relative z-10">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300" 
                                        :class="currentStep >= 2 ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'bg-gray-200 dark:bg-zinc-700 text-gray-500'"
                                        :style="currentStep == 2 ? 'ring: 4px solid rgba(59,130,246,0.2); transform: scale(1.1);' : ''">
                                        <template x-if="currentStep > 2">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </template>
                                        <template x-if="currentStep <= 2">
                                            <span>2</span>
                                        </template>
                                    </div>
                                </div>
                                <span class="mt-2 text-xs font-medium" :class="currentStep >= 2 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500'">
                                    Priority & Category
                                </span>
                            </div>
                            <div class="flex-1 h-0.5 relative -ml-2 -mr-2 z-0" :class="currentStep > 2 ? 'bg-gradient-to-r from-blue-500 to-blue-600' : 'bg-gray-200 dark:bg-zinc-700'"></div>
                            
                            <div class="flex flex-col items-center flex-1 relative z-10">
                                <div class="relative">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300" 
                                        :class="currentStep >= 3 ? 'bg-gradient-to-r from-blue-500 to-blue-600 text-white shadow-lg' : 'bg-gray-200 dark:bg-zinc-700 text-gray-500'"
                                        :style="currentStep == 3 ? 'ring: 4px solid rgba(59,130,246,0.2); transform: scale(1.1);' : ''">
                                        <span>3</span>
                                    </div>
                                </div>
                                <span class="mt-2 text-xs font-medium" :class="currentStep >= 3 ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500'">
                                    Additional Info
                                </span>
                            </div>
                        </div>
                    </div>

                    <form wire:submit.prevent="updateTicket" @submit="processing = true">
                        <!-- Step 1: Basic Information -->
                        <div x-show="currentStep === 1" x-cloak class="space-y-5 animate-fadeIn">
                            <div>
                                <label class="block text-sm font-medium mb-2">Title <span class="text-red-500">*</span></label>
                                <input type="text" 
                                    wire:model="title"
                                    class="w-full px-4 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Enter ticket title">
                                @error('title') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2">Description <span class="text-red-500">*</span></label>
                                <textarea 
                                    wire:model="description"
                                    rows="6"
                                    class="w-full px-4 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                    placeholder="Describe your issue in detail..."></textarea>
                                @error('description') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <!-- Current Status Info -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2 mb-2">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">Current Status</span>
                                </div>
                                <div class="flex items-center justify-between">
                                    <div>
                                        <flux:badge size="sm" color="{{ match($selectedTicket->status ?? '') {
                                            'Open' => 'danger',
                                            'In Progress' => 'warning',
                                            'Pending' => 'info',
                                            'Closed' => 'success',
                                            default => 'gray'
                                        } }}">
                                            {{ $selectedTicket->status ?? 'N/A' }}
                                        </flux:badge>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Created</span>
                                        <p class="text-sm text-gray-700 dark:text-gray-300">
                                            {{ $selectedTicket ? $selectedTicket->created_at->format('d M Y H:i') : 'N/A' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Step 2: Priority & Category -->
                        <div x-show="currentStep === 2" x-cloak class="space-y-5 animate-fadeIn">
                            <div>
                                <label class="block text-sm font-medium mb-2">Priority <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-4 gap-2">
                                    @foreach(['Low', 'Medium', 'Urgent', 'Critical'] as $prio)
                                        <div 
                                            wire:click="$set('priority', '{{ $prio }}')"
                                            class="text-center px-4 py-2.5 border rounded-lg transition-all duration-200 cursor-pointer
                                                {{ $priority == $prio ? 
                                                    ($prio == 'Low' ? 'bg-gray-100 border-gray-500 dark:bg-gray-700 text-gray-900 dark:text-white font-medium shadow-md ring-2 ring-gray-400' :
                                                    ($prio == 'Medium' ? 'bg-yellow-100 border-yellow-500 dark:bg-yellow-900/50 text-yellow-900 dark:text-yellow-200 font-medium shadow-md ring-2 ring-yellow-400' :
                                                    ($prio == 'Urgent' ? 'bg-red-100 border-red-500 dark:bg-red-900/50 text-red-900 dark:text-red-200 font-medium shadow-md ring-2 ring-red-400' :
                                                    'bg-purple-100 border-purple-500 dark:bg-purple-900/50 text-purple-900 dark:text-purple-200 font-medium shadow-md ring-2 ring-purple-400'))) :
                                                    'bg-white dark:bg-zinc-800 border-gray-300 dark:border-zinc-700 hover:bg-gray-50 dark:hover:bg-zinc-700 text-gray-700 dark:text-gray-300' }}">
                                            {{ $prio }}
                                        </div>
                                    @endforeach
                                </div>
                                @error('priority') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2">Category <span class="text-red-500">*</span></label>
                                <div class="grid grid-cols-1 gap-2 max-h-60 overflow-y-auto border rounded-lg p-2 bg-gray-50 dark:bg-zinc-800/50">
                                    @foreach($categories as $category)
                                        <label class="flex items-center gap-2 p-2 rounded-lg cursor-pointer transition-all duration-200
                                            {{ $category_id == $category->id ? 'bg-blue-50 dark:bg-blue-900/20 border border-blue-500 shadow-sm' : 'hover:bg-gray-100 dark:hover:bg-zinc-700 border border-transparent' }}">
                                            <input type="radio" 
                                                wire:model="category_id" 
                                                value="{{ $category->id }}"
                                                class="text-blue-600">
                                            <span class="text-sm">{{ $category->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                                @error('category_id') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2">Assign To Section</label>
                                <select wire:model="assigned_role" 
                                        class="w-full px-4 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all">
                                    <option value="ADMINESD">ESD (Electrostatic Discharge)</option>
                                    @can('assign to other sections')
                                        <option value="ADMINUTILITY">Utility & Building</option>
                                        <option value="ADMINHR">HR (Human Resource)</option>
                                        <option value="ADMINGA">GA (General Affair)</option>
                                    @endcan
                                </select>
                            </div>
                        </div>

                        <!-- Step 3: Additional Information -->
                        <div x-show="currentStep === 3" x-cloak class="space-y-5 animate-fadeIn">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium mb-2">Email</label>
                                    <input type="email" 
                                        wire:model="email_user"
                                        class="w-full px-4 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="user@example.com">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium mb-2">Registration Number</label>
                                    <input type="text" 
                                        wire:model="registration_no"
                                        class="w-full px-4 py-2.5 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                                        placeholder="Enter registration number (optional)">
                                </div>
                            </div>
                            
                            <div class="bg-gray-50 dark:bg-zinc-800/50 rounded-lg p-4">
                                <div class="flex items-center gap-2 mb-3">
                                    <svg class="w-5 h-5 text-gray-600 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Ticket Information</span>
                                </div>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Ticket Number:</span>
                                        <p class="font-mono font-semibold text-gray-900 dark:text-white mt-1">{{ $selectedTicket->ticket_number ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500 dark:text-gray-400">Last Updated:</span>
                                        <p class="text-gray-900 dark:text-white mt-1">{{ $selectedTicket ? $selectedTicket->updated_at->format('d M Y H:i') : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Navigation Buttons -->
                        <div class="flex justify-between mt-6 pt-4 border-t dark:border-zinc-700">
                            <button type="button" 
                                    x-show="currentStep > 1"
                                    @click="currentStep--"
                                    class="px-5 py-2.5 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-all duration-200">
                                ← Previous
                            </button>
                            <div x-show="currentStep === 1" class="invisible">Placeholder</div>
                            
                            <button type="button" 
                                    x-show="currentStep < totalSteps"
                                    @click="currentStep++"
                                    class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg hover:from-blue-600 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                                Next →
                            </button>
                            
                            <button type="submit" 
                                    x-show="currentStep === totalSteps"
                                    x-bind:disabled="processing"
                                    class="px-6 py-2.5 bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg hover:from-green-600 hover:to-green-700 transition-all duration-200 shadow-md hover:shadow-lg disabled:opacity-50 disabled:cursor-not-allowed">
                                <span x-show="!processing">Update Ticket</span>
                                <span x-show="processing" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Updating...
                                </span>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Processing Modal Overlay -->
                    <div x-show="processing" 
                        x-cloak
                        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
                        style="display: none;">
                        <div class="bg-white dark:bg-zinc-800 rounded-xl shadow-2xl p-8 max-w-md mx-4 text-center animate-pulse">
                            <div class="relative">
                                <div class="w-20 h-20 mx-auto mb-4">
                                    <svg class="animate-spin h-20 w-20 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </div>
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">
                                Updating Ticket
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300">
                                Please wait while we update your ticket...
                            </p>
                        </div>
                    </div>
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

    <!-- MODAL APPROVAL PIC -->
    @if($showApprovalPicModal && $selectedTicket)
    <flux:modal wire:model="showApprovalPicModal" class="w-full max-w-lg">
        <div class="p-4 sm:p-5">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                        PIC Approval
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Ticket #: <span class="font-mono font-semibold text-blue-600 dark:text-blue-400">{{ $selectedTicket->ticket_number ?? '' }}</span>
                    </p>
                </div>
                <button wire:click="closeApprovalModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="submitPicApproval">
                <div class="space-y-4">
                    <!-- Ticket Info Summary -->
                    <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4">
                        <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-3">Ticket Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Title:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedTicket->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Requester:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedTicket->creator->name ?? 'N/A' }}</span>
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
                        </div>
                    </div>

                    <!-- Approval Status -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Approval Status <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button"
                                    wire:click="$set('approval_status', 'Approved')"
                                    class="px-4 py-3 rounded-lg border-2 transition-all duration-200 flex items-center justify-center gap-2
                                        {{ $approval_status === 'Approved' ? 
                                            'border-green-500 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300' : 
                                            'border-gray-300 dark:border-zinc-700 hover:border-green-300 text-gray-700 dark:text-gray-300' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approve
                            </button>
                            <button type="button"
                                    wire:click="$set('approval_status', 'Rejected')"
                                    class="px-4 py-3 rounded-lg border-2 transition-all duration-200 flex items-center justify-center gap-2
                                        {{ $approval_status === 'Rejected' ? 
                                            'border-red-500 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300' : 
                                            'border-gray-300 dark:border-zinc-700 hover:border-red-300 text-gray-700 dark:text-gray-300' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject
                            </button>
                        </div>
                        @error('approval_status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Comments -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Comments <span class="text-red-500">*</span></label>
                        <textarea 
                            wire:model="comment_manager"
                            rows="4"
                            class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('comment_manager') border-red-500 @enderror"
                            placeholder="Please provide your comments or reasons for approval/rejection... (minimum 5 characters)"></textarea>
                        @error('comment_manager') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end gap-2 pt-4 border-t dark:border-zinc-700">
                        <flux:button variant="ghost" wire:click="closeApprovalModal">
                            Cancel
                        </flux:button>
                        <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Submit Approval</span>
                            <span wire:loading>Processing...</span>
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>
    </flux:modal>
    @endif

    <!-- MODAL APPROVAL USER -->
    @if($showApprovalUserModal && $selectedTicket)
    <flux:modal wire:model="showApprovalUserModal" class="w-full max-w-lg">
        <div class="p-4 sm:p-5">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <h2 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-teal-600 bg-clip-text text-transparent">
                        User Approval
                    </h2>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Ticket #: <span class="font-mono font-semibold text-blue-600 dark:text-blue-400">{{ $selectedTicket->ticket_number ?? '' }}</span>
                    </p>
                </div>
                <button wire:click="closeApprovalModal" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="submitUserApproval">
                <div class="space-y-4">
                    <!-- Ticket Info Summary -->
                    <div class="bg-gray-50 dark:bg-zinc-800 rounded-lg p-4">
                        <h3 class="font-semibold text-sm text-gray-700 dark:text-gray-300 mb-3">Ticket Information</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Title:</span>
                                <span class="font-medium text-gray-900 dark:text-white">{{ $selectedTicket->title }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Assigned To:</span>
                                <span class="font-medium text-gray-900 dark:text-white">
                                    @php
                                        $roleMapping = [
                                            'ADMINESD' => 'ESD (Electrostatic Discharge)',
                                            'ADMINUTILITY' => 'Utility & Building',
                                            'ADMINHR' => 'HR (Human Resource)',
                                            'ADMINGA' => 'GA (General Affair)',
                                        ];
                                    @endphp
                                    {{ $roleMapping[$selectedTicket->assigned_role] ?? $selectedTicket->assigned_role }}
                                </span>
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
                        </div>
                    </div>

                    <!-- Approval Status -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Approval Status <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 gap-3">
                            <button type="button"
                                    wire:click="$set('approval_user_status', 'Approved')"
                                    class="px-4 py-3 rounded-lg border-2 transition-all duration-200 flex items-center justify-center gap-2
                                        {{ $approval_user_status === 'Approved' ? 
                                            'border-green-500 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300' : 
                                            'border-gray-300 dark:border-zinc-700 hover:border-green-300 text-gray-700 dark:text-gray-300' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Approve
                            </button>
                            <button type="button"
                                    wire:click="$set('approval_user_status', 'Rejected')"
                                    class="px-4 py-3 rounded-lg border-2 transition-all duration-200 flex items-center justify-center gap-2
                                        {{ $approval_user_status === 'Rejected' ? 
                                            'border-red-500 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300' : 
                                            'border-gray-300 dark:border-zinc-700 hover:border-red-300 text-gray-700 dark:text-gray-300' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Reject
                            </button>
                        </div>
                        @error('approval_user_status') <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Comments -->
                    <div>
                        <label class="block text-sm font-medium mb-2">Comments <span class="text-red-500">*</span></label>
                        <textarea 
                            wire:model="comment_user"
                            rows="4"
                            class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all @error('comment_user') border-red-500 @enderror"
                            placeholder="Please provide your comments or feedback... (minimum 5 characters)"></textarea>
                        @error('comment_user') 
                            <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-end gap-2 pt-4 border-t dark:border-zinc-700">
                        <flux:button variant="ghost" wire:click="closeApprovalModal">
                            Cancel
                        </flux:button>
                        <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                            <span wire:loading.remove>Submit Approval</span>
                            <span wire:loading>Processing...</span>
                        </flux:button>
                    </div>
                </div>
            </form>
        </div>
    </flux:modal>
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
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeIn {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</div>