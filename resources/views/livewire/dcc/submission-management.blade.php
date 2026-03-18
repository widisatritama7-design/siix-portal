<div class="p-6 space-y-6">
    <!-- Breadcrumbs -->
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
            Dashboard
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            DCC
        </flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
            Submission Management
        </flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                Submission Management
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Manage DCC submissions and documents
            </p>
        </div>
        
        <!-- Tombol Add Submission -->
        @can('create submissions')
        <flux:button 
            variant="primary" 
            icon="plus" 
            class="bg-blue-600 hover:bg-blue-700"
            wire:click="resetForm"
            x-on:click="$dispatch('open-modal', 'submission-form-modal')"
        >
            Add New Submission
        </flux:button>
        @endcan
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @php
            $totalSubmissions = \App\Models\DCC\Submission::count();
            $waitingSubmissions = \App\Models\DCC\Submission::where('status', 'Waiting Received')->count();
            $completedSubmissions = \App\Models\DCC\Submission::where('status', 'Completed')->count();
            $overdueSubmissions = \App\Models\DCC\Submission::where('due_date', '<', now())
                ->where('status', 'Waiting Received')
                ->count();
        @endphp

        <flux:card class="bg-blue-50 dark:bg-blue-900/20">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-blue-600 dark:text-blue-400">Total Submissions</p>
                    <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">{{ $totalSubmissions }}</p>
                </div>
            </div>
        </flux:card>

        <flux:card class="bg-yellow-50 dark:bg-yellow-900/20">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-yellow-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-yellow-600 dark:text-yellow-400">Waiting</p>
                    <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-300">{{ $waitingSubmissions }}</p>
                </div>
            </div>
        </flux:card>

        <flux:card class="bg-green-50 dark:bg-green-900/20">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-green-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-green-600 dark:text-green-400">Completed</p>
                    <p class="text-2xl font-bold text-green-700 dark:text-green-300">{{ $completedSubmissions }}</p>
                </div>
            </div>
        </flux:card>

        <flux:card class="bg-red-50 dark:bg-red-900/20">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-red-500 rounded-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-red-600 dark:text-red-400">Overdue</p>
                    <p class="text-2xl font-bold text-red-700 dark:text-red-300">{{ $overdueSubmissions }}</p>
                </div>
            </div>
        </flux:card>
    </div>

    <!-- Filter Toggle Button -->
    <div class="flex justify-end">
        <flux:button 
            wire:click="$toggle('showFilters')" 
            variant="ghost" 
            icon="adjustments-horizontal"
            class="gap-2"
        >
            {{ $showFilters ? 'Hide Filters' : 'Show Filters' }}
        </flux:button>
    </div>

    <!-- Advanced Filters -->
    @if($showFilters)
    <flux:card class="p-4">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <!-- Search -->
            <div>
                <label class="block text-sm font-medium mb-1">Search</label>
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Search..."
                    icon="magnifying-glass"
                />
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-sm font-medium mb-1">Status</label>
                <select wire:model.live="filterStatus" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">All Status</option>
                    <option value="Waiting Received">Waiting Received</option>
                    <option value="Received">Received</option>
                    <option value="Completed">Completed</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>

            <!-- Department Filter -->
            <div>
                <label class="block text-sm font-medium mb-1">Department</label>
                <select wire:model.live="filterDept" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->dept_name }}">{{ $dept->dept_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Category Filter -->
            <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <select wire:model.live="filterCategory" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}">{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Year Filter -->
            <div>
                <label class="block text-sm font-medium mb-1">Year</label>
                <select wire:model.live="filterYear" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">All Years</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}">{{ $year }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Month Filter -->
            <div>
                <label class="block text-sm font-medium mb-1">Month</label>
                <select wire:model.live="filterMonth" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                    <option value="">All Months</option>
                    @foreach($months as $num => $name)
                        <option value="{{ $num }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Date From -->
            <div>
                <label class="block text-sm font-medium mb-1">Date From</label>
                <input type="date" wire:model.live="filterDateFrom" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
            </div>

            <!-- Date Until -->
            <div>
                <label class="block text-sm font-medium mb-1">Date Until</label>
                <input type="date" wire:model.live="filterDateUntil" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
            </div>
        </div>

        <!-- Clear Filters Button -->
        <div class="flex justify-end mt-4">
            <flux:button wire:click="clearFilters" variant="ghost" size="sm">
                Clear All Filters
            </flux:button>
        </div>
    </flux:card>
    @endif

    <!-- Bulk Actions -->
    @if(count($selectedSubmissions) > 0)
    <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg flex items-center justify-between">
        <span class="text-sm text-blue-700 dark:text-blue-300">
            {{ count($selectedSubmissions) }} submissions selected
        </span>
        <div class="flex gap-2">
            @can('receive submissions')
            <flux:button wire:click="bulkReceive" size="sm" icon="check-circle" class="bg-green-600 hover:bg-green-700">
                Mark as Received
            </flux:button>
            @endcan

            <flux:button wire:click="bulkMarkDistributed" size="sm" icon="check-badge" class="bg-purple-600 hover:bg-purple-700">
                Mark as Distributed
            </flux:button>

            <flux:button wire:click="$set('selectedSubmissions', [])" size="sm" variant="ghost">
                Clear Selection
            </flux:button>
        </div>
    </div>
    @endif

    <!-- Submissions Table -->
    <flux:card class="overflow-hidden">
        <div class="overflow-x-auto" style="overflow-x: auto; white-space: nowrap;">
            <table class="w-full" style="min-width: 1400px; table-layout: auto;">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/50">
                        <th class="px-4 py-3 text-left sticky left-0 bg-zinc-50 dark:bg-zinc-800/50 z-10" style="min-width: 50px;">
                            <input type="checkbox" wire:model.live="selectAll" class="rounded">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 60px;">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 150px;">Category</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 250px;">Description</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 150px;">Department</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 120px;">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 150px;">Due Date</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 120px;">PIC</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 180px;">Created By</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider" style="min-width: 200px;">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($submissions as $index => $submission)
                    @php
                        $dueDateLabel = $submission->dueDateLabel;
                        $rowClass = '';
                        if ($submission->due_date && $submission->due_date->isPast() && $submission->status === 'Waiting Received') {
                            $rowClass = 'bg-red-50 dark:bg-red-900/20';
                        } elseif ($submission->due_date && $submission->due_date->isToday() && $submission->status === 'Waiting Received') {
                            $rowClass = 'bg-yellow-50 dark:bg-yellow-900/20';
                        }
                    @endphp
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ $rowClass }}"
                        wire:key="submission-{{ $submission->id }}">
                        <td class="px-4 py-3 sticky left-0 bg-inherit z-10" style="min-width: 50px;">
                            <input type="checkbox" 
                                   wire:model.live="selectedSubmissions" 
                                   value="{{ $submission->id }}"
                                   class="rounded">
                        </td>
                        <td class="px-4 py-3 text-sm text-zinc-500 dark:text-zinc-400" style="min-width: 60px;">
                            {{ $submissions->firstItem() + $index }}
                        </td>
                        <td class="px-4 py-3" style="min-width: 150px;">
                            <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">
                                {{ $submission->category_document }}
                            </span>
                        </td>
                        <td class="px-4 py-3" style="min-width: 250px;">
                            <div>
                                <span class="text-sm font-semibold text-zinc-800 dark:text-white block">
                                    {{ $submission->description }}
                                </span>
                                <span class="text-xs text-zinc-500">Rev: {{ $submission->revision }}</span>
                                @if($submission->remarks)
                                <span class="text-xs text-zinc-500 block">{{ $submission->remarks }}</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3" style="min-width: 150px;">
                            <span class="text-sm">{{ $submission->department->dept_name ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 py-3" style="min-width: 120px;">
                            <div class="space-y-1">
                                <span class="px-2 py-1 bg-{{ $submission->statusColor }}-100 text-{{ $submission->statusColor }}-800 text-xs rounded-full inline-block">
                                    {{ $submission->status }}
                                </span>
                                @if($submission->status_distribute === 'Distributed')
                                <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded-full inline-block">
                                    Distributed
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3" style="min-width: 150px;">
                            <div>
                                <span class="text-sm block">{{ $submission->due_date?->format('d M Y') ?? '-' }}</span>
                                <span class="text-xs px-2 py-0.5 bg-{{ $dueDateLabel['color'] }}-100 text-{{ $dueDateLabel['color'] }}-800 rounded-full inline-block mt-1">
                                    {{ $dueDateLabel['label'] }}
                                </span>
                            </div>
                        </td>
                        <td class="px-4 py-3" style="min-width: 120px;">
                            <span class="text-sm">{{ $submission->pic ?? 'N/A' }}</span>
                        </td>
                        <td class="px-4 py-3" style="min-width: 180px;">
                            <div class="text-sm">
                                <div>{{ $submission->creator->name ?? 'N/A' }}</div>
                                <div class="text-xs text-zinc-500">{{ $submission->created_at->format('d M Y H:i') }}</div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-right" style="min-width: 200px;">
                            <div class="flex items-center justify-end gap-1">
                                <!-- Download Button -->
                                @if($submission->documentation)
                                <flux:button 
                                    wire:click="downloadDocumentation({{ $submission->id }})"
                                    size="sm"
                                    icon="arrow-down-tray"
                                    class="!p-2 text-green-600 hover:bg-green-50 dark:text-green-400 dark:hover:bg-green-950/50"
                                    title="Download documentation"
                                />
                                @endif

                                <!-- Receive Button -->
                                @can('receive submissions')
                                    @if($submission->canReceive())
                                    <flux:button 
                                        wire:click="openReceiveModal({{ $submission->id }})"
                                        size="sm"
                                        icon="check-circle"
                                        class="!p-2 text-yellow-600 hover:bg-yellow-50 dark:text-yellow-400 dark:hover:bg-yellow-950/50"
                                        title="Receive/Reject"
                                    />
                                    @endif
                                @endcan

                                <!-- Mark Distributed Button -->
                                @if($submission->canMarkDistributed())
                                <flux:button 
                                    wire:click="openDistributeModal({{ $submission->id }})"
                                    size="sm"
                                    icon="check-badge"
                                    class="!p-2 text-purple-600 hover:bg-purple-50 dark:text-purple-400 dark:hover:bg-purple-950/50"
                                    title="Mark as Distributed"
                                />
                                @endif

                                <!-- Edit Button -->
                                @can('edit submissions')
                                    @if($submission->canEdit())
                                    <flux:button 
                                        wire:click="edit({{ $submission->id }})" 
                                        x-on:click="$dispatch('open-modal', 'submission-form-modal')"
                                        size="sm"
                                        icon="pencil-square"
                                        class="!p-2 text-blue-600 hover:bg-blue-50 dark:text-blue-400 dark:hover:bg-blue-950/50"
                                        title="Edit submission"
                                    />
                                    @endif
                                @endcan

                                <!-- Delete Button -->
                                @can('delete submissions')
                                    @if($submission->canDelete())
                                    <flux:button 
                                        wire:click="confirmDelete({{ $submission->id }})" 
                                        size="sm"
                                        icon="trash"
                                        class="!p-2 text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/50"
                                        title="Delete submission"
                                    />
                                    @endif
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="px-4 py-12 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <div class="w-20 h-20 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-zinc-400 dark:text-zinc-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-lg font-medium text-zinc-900 dark:text-white mb-1">
                                        No submissions found
                                    </h3>
                                    <p class="text-sm text-zinc-500 dark:text-zinc-400 mb-4">
                                        {{ $search ? 'Try adjusting your search query' : 'Get started by creating a new submission' }}
                                    </p>
                                </div>
                                @if($search || $filterStatus || $filterDept || $filterCategory)
                                    <flux:button wire:click="clearFilters" size="sm">
                                        Clear Filters
                                    </flux:button>
                                @else
                                    @can('create submissions')
                                    <flux:button 
                                        variant="primary" 
                                        size="sm"
                                        wire:click="resetForm"
                                        x-on:click="$dispatch('open-modal', 'submission-form-modal')"
                                    >
                                        Add Your First Submission
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
        @if($submissions->hasPages())
        <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
            {{ $submissions->links() }}
        </div>
        @endif
    </flux:card>

    <!-- MODAL FORM SUBMISSION -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'submission-form-modal') open = true"
         @close-modal.window="if ($event.detail === 'submission-form-modal') open = false"
         x-cloak>
        
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-2xl max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">{{ $modalTitle }}</h2>

                    <form wire:submit="save" enctype="multipart/form-data">
                        <!-- Category Document -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Category Document *</label>
                            <select wire:model="category_document" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                <option value="">Select Category</option>
                                @foreach($categoryOptions as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category_document') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Description *</label>
                            <input type="text" 
                                   wire:model="description" 
                                   class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 uppercase"
                                   placeholder="Enter description">
                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Revision -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Revision *</label>
                                <input type="text" wire:model="revision" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                @error('revision') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- PIC -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">PIC *</label>
                                <input type="text" 
                                       wire:model="pic" 
                                       class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700 uppercase"
                                       placeholder="Enter PIC name">
                                @error('pic') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <!-- Department -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Department *</label>
                                <select wire:model="dept" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $dept)
                                        <option value="{{ $dept->dept_name }}">{{ $dept->dept_name }}</option>
                                    @endforeach
                                </select>
                                @error('dept') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>

                            <!-- Due Date -->
                            <div class="mb-4">
                                <label class="block text-sm font-medium mb-1">Due Date *</label>
                                <input type="date" wire:model="due_date" min="{{ now()->format('Y-m-d') }}" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                @error('due_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Emails -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">
                                Emails Tujuan * 
                                @if($dept && count($emails) > 0)
                                    <span class="text-xs text-green-600 ml-2">({{ count($emails) }} selected)</span>
                                @endif
                            </label>

                            <!-- Selected emails badges -->
                            @if(count($emails) > 0)
                                <div class="mb-3 flex flex-wrap gap-1 p-2 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                                    @foreach($emails as $email)
                                        <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-600 text-white text-xs rounded-full">
                                            {{ $email }}
                                            <button type="button" wire:click="toggleEmail('{{ $email }}')" class="hover:text-red-200">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </button>
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Department selection info -->
                            @if(!$dept)
                                <div class="p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg mb-2">
                                    <p class="text-sm text-yellow-700 dark:text-yellow-300">
                                        Please select a department first to see available emails.
                                    </p>
                                </div>
                            @else
                                @php
                                    $selectedDept = $departments->where('dept_name', $dept)->first();
                                    $availableEmails = [];
                                    
                                    if ($selectedDept && $selectedDept->emails) {
                                        if (is_string($selectedDept->emails)) {
                                            $availableEmails = array_map('trim', explode(',', $selectedDept->emails));
                                        } elseif (is_array($selectedDept->emails)) {
                                            $availableEmails = $selectedDept->emails;
                                        }
                                    }
                                @endphp

                                <!-- Quick actions -->
                                @if(count($availableEmails) > 0)
                                    <div class="flex gap-2 mb-3">
                                        <button type="button" 
                                                wire:click="selectAllEmails"
                                                class="text-xs px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">
                                            Select All
                                        </button>
                                        <button type="button" 
                                                wire:click="clearAllEmails"
                                                class="text-xs px-2 py-1 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                                            Clear All
                                        </button>
                                    </div>
                                @endif

                                <!-- Available emails list -->
                                <div class="border rounded-lg p-3 max-h-48 overflow-y-auto dark:border-zinc-700">
                                    @if(count($availableEmails) > 0)
                                        <div class="space-y-2">
                                            @foreach($availableEmails as $email)
                                                @if(!empty($email))
                                                <label class="flex items-center gap-2 p-2 hover:bg-zinc-50 dark:hover:bg-zinc-800 rounded cursor-pointer">
                                                    <input type="checkbox" 
                                                           value="{{ $email }}"
                                                           {{ in_array($email, $emails) ? 'checked' : '' }}
                                                           wire:click="toggleEmail('{{ $email }}')"
                                                           class="rounded">
                                                    <span class="text-sm">{{ $email }}</span>
                                                </label>
                                                @endif
                                            @endforeach
                                        </div>
                                    @else
                                        <p class="text-sm text-zinc-400 text-center py-4">
                                            No emails available for this department
                                        </p>
                                    @endif
                                </div>
                            @endif

                            @error('emails') 
                                <span class="text-red-500 text-sm mt-1 block">{{ $message }}</span>
                            @enderror
                            
                            <p class="text-xs text-zinc-500 mt-2">
                                * Select at least one email address
                            </p>
                        </div>

                        <!-- Documentation File -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Documentation File</label>
                            @if($existing_documentation)
                                <div class="mb-2 p-2 bg-blue-50 rounded-lg flex items-center justify-between">
                                    <span class="text-sm text-blue-700">Current file: {{ basename($existing_documentation) }}</span>
                                    <button type="button" wire:click="$set('existing_documentation', null)" class="text-red-600">Remove</button>
                                </div>
                            @endif
                            <input type="file" wire:model="documentation_file" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            @error('documentation_file') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            <p class="text-xs text-zinc-500 mt-1">Max 10MB. Allowed: PDF, DOC, DOCX, XLS, XLSX, ZIP, JPG, PNG</p>
                        </div>

                        <!-- Remarks -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Remarks</label>
                            <textarea wire:model="remarks" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                {{ $submission_id ? 'Update' : 'Create' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL RECEIVE/REJECT -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'receive-modal') open = true"
         @close-modal.window="if ($event.detail === 'receive-modal') open = false"
         x-cloak>
        
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Receive / Reject Submission</h2>

                    <form wire:submit="processReceive">
                        <!-- Submission Info -->
                        @if($receivingSubmission)
                        <div class="mb-4 p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <p class="text-sm"><span class="font-medium">Description:</span> {{ $receivingSubmission->description }}</p>
                            <p class="text-sm"><span class="font-medium">Department:</span> {{ $receivingSubmission->department->dept_name ?? 'N/A' }}</p>
                        </div>
                        @endif

                        <!-- Status -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Status *</label>
                            <select wire:model="receiveStatus" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                <option value="">Select Status</option>
                                <option value="Received">Received</option>
                                <option value="Rejected">Rejected</option>
                            </select>
                            @error('receiveStatus') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Reason (if Rejected) -->
                        <div class="mb-4" x-show="$wire.receiveStatus === 'Rejected'" x-cloak>
                            <label class="block text-sm font-medium mb-1">Reason for Rejection *</label>
                            <textarea wire:model="receiveReason" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700" placeholder="Enter reason for rejection"></textarea>
                            @error('receiveReason') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL MARK DISTRIBUTED -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'distribute-modal') open = true"
         @close-modal.window="if ($event.detail === 'distribute-modal') open = false"
         x-cloak>
        
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4">Mark as Distributed</h2>

                    <form wire:submit="processDistribute">
                        <!-- Submission Info -->
                        @if($distributingSubmission)
                        <div class="mb-4 p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <p class="text-sm"><span class="font-medium">Description:</span> {{ $distributingSubmission->description }}</p>
                            <p class="text-sm"><span class="font-medium">Department:</span> {{ $distributingSubmission->department->dept_name ?? 'N/A' }}</p>
                            <p class="text-sm"><span class="font-medium">Status:</span> {{ $distributingSubmission->status }}</p>
                        </div>
                        @endif

                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mb-4">
                            Are you sure you want to mark this submission as <span class="font-semibold text-purple-600">Distributed</span>?
                        </p>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                                Yes, Mark Distributed
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DELETE WITH REASON -->
    <div x-data="{ open: false }" 
         x-show="open" 
         @open-modal.window="if ($event.detail === 'delete-reason-modal') open = true"
         @close-modal.window="if ($event.detail === 'delete-reason-modal') open = false"
         x-cloak>
        
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <h2 class="text-xl font-bold mb-4 text-red-600">Delete Submission</h2>

                    <form wire:submit="deleteWithReason">
                        <!-- Submission Info -->
                        @if($submissionToDelete)
                        <div class="mb-4 p-3 bg-zinc-50 dark:bg-zinc-800 rounded-lg">
                            <p class="text-sm"><span class="font-medium">Description:</span> {{ $submissionToDelete->description }}</p>
                            <p class="text-sm"><span class="font-medium">Department:</span> {{ $submissionToDelete->department->dept_name ?? 'N/A' }}</p>
                        </div>
                        @endif

                        <!-- Reason to Delete -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-1">Reason for Deletion *</label>
                            <textarea wire:model="reason_to_delete" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700" placeholder="Enter reason for deletion"></textarea>
                            @error('reason_to_delete') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-2">
                            <button type="button" 
                                    @click="open = false"
                                    class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                Yes, Delete
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL CONFIRM BULK ACTIONS -->
    <div x-data="{ open: false, action: '', count: 0 }" 
         x-show="open" 
         @open-bulk-modal.window="open = true; action = $event.detail.action; count = $event.detail.count"
         @close-modal.window="open = false"
         x-cloak>
        
        <div class="fixed inset-0 bg-black/50 z-40" @click="open = false"></div>
        
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md p-6 text-center">
                <div class="w-16 h-16 mx-auto mb-4 bg-blue-100 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                
                <h3 class="text-lg font-bold mb-2">Confirm Bulk Action</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    Are you sure you want to mark <span class="font-bold" x-text="count"></span> submissions as <span class="font-semibold" x-text="action"></span>?
                </p>

                <div class="flex justify-center gap-3">
                    <button @click="open = false" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800">
                        Cancel
                    </button>
                    <button x-show="action === 'Received'" 
                            @click="open = false; $wire.bulkReceive()"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Yes, Proceed
                    </button>
                    <button x-show="action === 'Distributed'" 
                            @click="open = false; $wire.bulkMarkDistributed()"
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700">
                        Yes, Proceed
                    </button>
                </div>
            </div>
        </div>
    </div>

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
        }" class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span x-text="message"></span>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
    </style>
</div>