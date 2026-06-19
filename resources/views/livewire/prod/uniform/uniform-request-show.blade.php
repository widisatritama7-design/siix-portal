<div class="p-1 space-y-2">
    @section('title', 'Uniform Request Details')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Uniform</flux:breadcrumbs.item>
        <flux:breadcrumbs.item href="{{ route('prod.uniform.request.index') }}" wire:navigate separator="slash">Request Uniform</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Details</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Uniform Request Details</h1>
            <p class="text-sm text-zinc-500">View and manage feedback</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('prod.uniform.request.index') }}" wire:navigate
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5">
                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-4.28 9.22a.75.75 0 0 0 0 1.06l3 3a.75.75 0 1 0 1.06-1.06l-1.72-1.72h5.69a.75.75 0 0 0 0-1.5h-5.69l1.72-1.72a.75.75 0 0 0-1.06-1.06l-3 3Z" clip-rule="evenodd" />
                </svg>
                Back to List
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif

    <flux:card class="p-6">
        <div class="mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
            <p class="text-sm text-zinc-500">Request Number</p>
            <p class="font-mono font-semibold text-xl text-zinc-900 dark:text-white">{{ $request->request_number }}</p>
            <p class="text-sm text-zinc-500 mt-1">Prepared by <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $request->created_by }}</span> at <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $request->created_at ? $request->created_at->format('d M Y H:i') : '-' }}</span></p>
        </div>
        
        <!-- Export & Import Buttons -->
        @php
            $allAdminFeedbackFilled = true;
            $allCostingFeedbackFilled = true;
            $allVerificationFilled = true;
            $hasRejectedItems = false;
            $hasApprovedItems = false;
            $hasManualItems = false;
            $hasRegularPendingItems = false;
            
            foreach($itemsDetail as $item) {
                if (empty($item['admin_feedback'])) {
                    $allAdminFeedbackFilled = false;
                }
                
                // Cek apakah manual
                $isManual = isset($item['is_manual']) && $item['is_manual'];
                if ($isManual) {
                    $hasManualItems = true;
                }
                
                // Costing feedback dianggap filled jika:
                // 1. Costing feedback sudah terisi, ATAU
                // 2. Verification status = rejected (tidak perlu costing feedback)
                // 3. Item manual (tidak perlu verification)
                if (empty($item['costing_feedback']) && $item['verification_status'] !== 'rejected') {
                    $allCostingFeedbackFilled = false;
                }
                
                // Verification hanya diperlukan untuk non-manual
                if (!$isManual && empty($item['verification_status'])) {
                    $allVerificationFilled = false;
                    $hasRegularPendingItems = true;
                }
                
                if ($item['verification_status'] === 'rejected') {
                    $hasRejectedItems = true;
                }
                if ($item['verification_status'] === 'approved') {
                    $hasApprovedItems = true;
                }
            }
            
            // Costing ready jika:
            // 1. Semua non-manual sudah diverifikasi (approved/rejected) ATAU
            // 2. Ada item manual (langsung ready)
            // 3. Dan ada item yang approved atau manual
            $costingReady = ($allVerificationFilled && $hasApprovedItems) || $hasManualItems;
            
            // Costing completed jika semua approved dan manual sudah punya costing feedback
            $allCostingCompleted = true;
            foreach($itemsDetail as $item) {
                $isManual = isset($item['is_manual']) && $item['is_manual'];
                // Jika manual atau approved, harus ada costing feedback
                if (($isManual || $item['verification_status'] === 'approved') && empty($item['costing_feedback'])) {
                    $allCostingCompleted = false;
                    break;
                }
            }
        @endphp

        <div class="mb-4 flex gap-2 flex-wrap">
            @can('feedback uniform request admin')
                @if(!$allAdminFeedbackFilled)
                    <div class="flex gap-2 flex-wrap">
                        <button wire:click="exportAdminFeedback" 
                            class="inline-flex items-center gap-2 px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Export Admin Feedback CSV
                        </button>
                        <button wire:click="openImportModal('admin')" 
                            class="inline-flex items-center gap-2 px-3 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors text-sm whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Import Admin Feedback CSV
                        </button>
                    </div>
                @else
                    <div class="text-sm text-green-600 bg-green-50 dark:bg-green-900/20 px-3 py-2 rounded-lg whitespace-nowrap">
                        ✓ All admin feedbacks have been filled
                    </div>
                @endif
            @endcan
            
            @can('feedback uniform request costing')
                @if($costingReady && !$allCostingCompleted)
                    <div class="flex gap-2">
                        <button wire:click="exportCostingFeedback" 
                            class="inline-flex items-center gap-2 px-3 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors text-sm whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                            Export Costing Feedback CSV
                        </button>
                        <button wire:click="openImportModal('costing')" 
                            class="inline-flex items-center gap-2 px-3 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors text-sm whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            Import Costing Feedback CSV
                        </button>
                    </div>
                    @if($hasManualItems && $hasRegularPendingItems)
                        <div class="text-sm text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-3 py-2 rounded-lg whitespace-nowrap">
                            ℹ️ Manual items ready for costing, waiting for regular items verification
                        </div>
                    @endif
                @elseif($costingReady && $allCostingCompleted)
                    <div class="text-sm text-green-600 bg-green-50 dark:bg-green-900/20 px-3 py-2 rounded-lg whitespace-nowrap">
                        ✓ All costing feedbacks have been filled
                        @if($hasRejectedItems)
                            <span class="text-xs text-zinc-500 ml-1">(Rejected items skipped)</span>
                        @endif
                    </div>
                @elseif(!$allVerificationFilled && !$hasManualItems)
                    <div class="text-sm text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 px-3 py-2 rounded-lg whitespace-nowrap">
                        ⏳ Waiting for all items to be verified before costing process
                        ({{ collect($itemsDetail)->where('verification_status', null)->count() }} item(s) pending)
                    </div>
                @elseif($allVerificationFilled && !$hasApprovedItems && !$hasManualItems)
                    <div class="text-sm text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-3 py-2 rounded-lg whitespace-nowrap">
                        ℹ️ All items are rejected. No costing feedback needed.
                    </div>
                @elseif($hasManualItems && !$hasApprovedItems && $allVerificationFilled)
                    <div class="text-sm text-blue-600 bg-blue-50 dark:bg-blue-900/20 px-3 py-2 rounded-lg whitespace-nowrap">
                        ℹ️ Only manual items available for costing. Regular items are rejected.
                    </div>
                @endif
            @endcan
        </div>
        
        <!-- Scroll Horizontal Table -->
        <div class="overflow-x-auto rounded-lg border border-zinc-200 dark:border-zinc-700">
            <table class="w-full text-sm" style="min-width: 1600px;">
                <thead class="bg-zinc-100 dark:bg-zinc-800">
                    <tr>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">#</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">NIK</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">NAME</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">DEPARTMENT</th>  {{-- TAMBAHKAN --}}
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">ITEM CODE</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">DESCRIPTION</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">SIZE</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">QTY</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">GROUP</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">REQUEST DATE</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">REASON</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">REMARKS</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">ADMIN FEEDBACK</th>
                        @canany(['feedback uniform request admin', 'feedback uniform request costing'])
                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">SALARY DEDUCTION</th>
                            <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">PERIOD</th>
                        @endcanany
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">VERIFICATION</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">COSTING FEEDBACK</th>
                        <th class="px-3 py-2 text-center text-xs font-medium text-zinc-500 dark:text-zinc-400 uppercase tracking-wider whitespace-nowrap">SIGNATURE</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @foreach($paginatedItems as $item)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ $loop->iteration }}</td>
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ $item['employee_nik'] }}</td>
                        <td class="px-3 py-2 text-left text-sm whitespace-nowrap">{{ $item['employee_name'] }}</td>
                        <td class="px-3 py-2 text-left text-sm whitespace-nowrap">{{ $item['employee_department'] }}</td>  {{-- TAMBAHKAN --}}
                        <td class="px-3 py-2 text-center text-sm font-mono whitespace-nowrap">{{ $item['item_code'] }}</td>
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ $item['description'] }}</td>
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ $item['size'] }}</td>
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ $item['qty'] }}</td>
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ $item['group'] }}</td>
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ \Carbon\Carbon::parse($item['request_date'])->format('d/m/Y') }}</td>
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ $item['reason'] }}</td>
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">{{ $item['remarks'] }}</td>
                        
                        <!-- Admin Feedback Column -->
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">
                            <div class="space-y-1">
                                @if($item['admin_feedback'])
                                    <div class="text-xs whitespace-nowrap">{{ $item['admin_feedback'] }}</div>
                                    @if($item['admin_feedback_datetime'])
                                    <div class="text-[10px] text-zinc-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($item['admin_feedback_datetime'])->format('d/m/Y H:i') }}</div>
                                    @endif
                                @else
                                    <div class="text-xs text-zinc-400 italic whitespace-nowrap">Waiting</div>
                                @endif
                            </div>
                        </td>
                        
                        @canany(['feedback uniform request admin', 'feedback uniform request costing'])
                            <!-- Salary Deduction Column -->
                            <td class="px-3 py-2 text-center text-sm whitespace-nowrap">
                                @php
                                    $isRejected = isset($item['verification_status']) && $item['verification_status'] === 'rejected';
                                @endphp
                                
                                @if($isRejected)
                                    <span class="text-xs text-zinc-400 italic whitespace-nowrap">-</span>
                                @elseif(isset($item['salary_deduction']))
                                    @if($item['salary_deduction'] === 'yes')
                                        <div class="flex items-center justify-center gap-2 whitespace-nowrap">
                                            <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300 whitespace-nowrap">
                                                Yes
                                            </span>
                                            <span class="text-xs font-semibold text-red-600 whitespace-nowrap">
                                            ( - Rp {{ number_format($item['deduction_amount'] ?? 0, 0, ',', '.') }} )
                                            </span>
                                        </div>
                                    @elseif($item['salary_deduction'] === 'no')
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                            No
                                        </span>
                                    @else
                                        <span class="text-xs text-zinc-400 italic whitespace-nowrap">-</span>
                                    @endif
                                @else
                                    @can('feedback uniform request admin')
                                        @php
                                            $isClosed = !empty($item['admin_feedback']) && 
                                                        !empty($item['verification_status']) && 
                                                        !empty($item['costing_feedback']) && 
                                                        !empty($item['digital_signature']);
                                        @endphp
                                        @if($isClosed)
                                            <button type="button" 
                                                wire:click="openSalaryModal({{ $item['index'] }})" 
                                                class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-emerald-700 bg-emerald-100 rounded-lg hover:bg-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-300 dark:hover:bg-emerald-900/50 transition-colors whitespace-nowrap">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Set Deduction
                                            </button>
                                        @else
                                            <span class="text-xs text-zinc-400 italic whitespace-nowrap">Waiting</span>
                                        @endif
                                    @else
                                        <span class="text-xs text-zinc-400 italic whitespace-nowrap">-</span>
                                    @endcan
                                @endif
                            </td>

                            <!-- Period Column -->
                            <td class="px-3 py-2 text-center text-sm whitespace-nowrap">
                                @php
                                    $isRejected = isset($item['verification_status']) && $item['verification_status'] === 'rejected';
                                @endphp
                                
                                @if($isRejected)
                                    <span class="text-xs text-zinc-400 italic whitespace-nowrap">-</span>
                                @elseif(isset($item['payroll_period']) && $item['payroll_period'])
                                    @php
                                        $periodDate = \Carbon\Carbon::parse($item['payroll_period'] . '-01');
                                    @endphp
                                    <span class="text-xs font-medium whitespace-nowrap">
                                        {{ $periodDate->format('F Y') }}
                                    </span>
                                @else
                                    <span class="text-xs text-zinc-400 italic whitespace-nowrap">-</span>
                                @endif
                            </td>
                        @endcanany

                        <!-- Verification Column -->
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">
                            @php
                                $isManual = isset($item['is_manual']) && $item['is_manual'];
                            @endphp
                            
                            @if($isManual)
                                {{-- Jika manual input, tidak perlu verifikasi --}}
                                <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300 whitespace-nowrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                    </svg>
                                    N/A
                                </span>
                            @elseif(isset($item['verification_status']) && $item['verification_status'])
                                @if($item['verification_status'] === 'approved')
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                        </svg>
                                        Approved
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                            <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                        </svg>
                                        Rejected
                                    </span>
                                @endif
                                <div class="text-[10px] text-zinc-400 mt-0.5 whitespace-nowrap">
                                    {{ isset($item['verification_datetime']) ? \Carbon\Carbon::parse($item['verification_datetime'])->format('d/m/Y H:i') : '-' }}
                                </div>
                            @else
                                @can('verify uniform request')
                                    @if(isset($item['admin_feedback']) && $item['admin_feedback'])
                                        <button type="button" 
                                            wire:click="openVerificationModal({{ $item['index'] }})" 
                                            class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 dark:bg-purple-900/30 dark:text-purple-300 dark:hover:bg-purple-900/50 transition-colors whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                                <path fill-rule="evenodd" d="M8.603 3.799A4.49 4.49 0 0 1 12 2.25c1.357 0 2.573.6 3.397 1.549a4.49 4.49 0 0 1 3.498 1.307 4.491 4.491 0 0 1 1.307 3.497A4.49 4.49 0 0 1 21.75 12a4.49 4.49 0 0 1-1.549 3.397 4.491 4.491 0 0 1-1.307 3.497 4.491 4.491 0 0 1-3.497 1.307A4.49 4.49 0 0 1 12 21.75a4.49 4.49 0 0 1-3.397-1.549 4.49 4.49 0 0 1-3.498-1.306 4.491 4.491 0 0 1-1.307-3.498A4.49 4.49 0 0 1 2.25 12c0-1.357.6-2.573 1.549-3.397a4.49 4.49 0 0 1 1.307-3.497 4.49 4.49 0 0 1 3.497-1.307Zm7.007 6.387a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                            </svg>
                                            Verify
                                        </button>
                                    @else
                                        <span class="text-xs text-zinc-400 italic whitespace-nowrap">Waiting form Admin</span>
                                    @endif
                                @else
                                    <span class="text-xs text-zinc-400 italic whitespace-nowrap">-</span>
                                @endcan
                            @endif
                        </td>

                        <!-- Costing Feedback Column -->
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">
                            <div class="space-y-1">
                                @if($item['costing_feedback'])
                                    <div class="text-xs whitespace-nowrap">{{ $item['costing_feedback'] }}</div>
                                    @if($item['costing_feedback_datetime'])
                                    <div class="text-[10px] text-zinc-400 whitespace-nowrap">{{ \Carbon\Carbon::parse($item['costing_feedback_datetime'])->format('d/m/Y H:i') }}</div>
                                    @endif
                                @else
                                    @php
                                        $isManual = isset($item['is_manual']) && $item['is_manual'];
                                    @endphp
                                    
                                    @if($isManual)
                                        {{-- Manual input: menunggu costing feedback dari import --}}
                                        <span class="text-xs text-zinc-400 italic whitespace-nowrap">Waiting</span>
                                    @elseif(isset($item['verification_status']) && $item['verification_status'] === 'rejected')
                                        <span class="text-xs text-zinc-500 italic whitespace-nowrap">-</span>
                                    @elseif(isset($item['verification_status']) && $item['verification_status'] === 'approved')
                                        <span class="text-xs text-zinc-400 italic whitespace-nowrap">Waiting</span>
                                    @else
                                        <span class="text-xs text-zinc-400 italic whitespace-nowrap">Waiting from User</span>
                                    @endif
                                @endif
                            </div>
                        </td>

                        <!-- Digital Signature Column -->
                        <td class="px-3 py-2 text-center text-sm whitespace-nowrap">
                            <div x-data="{ 
                                showTooltip: false,
                                tooltipPosition: { top: 0, left: 0 }
                            }" 
                            class="inline-block"
                            @mouseenter="
                                showTooltip = true;
                                const rect = $event.target.closest('td').getBoundingClientRect();
                                tooltipPosition.top = rect.top - 10;
                                tooltipPosition.left = rect.left + (rect.width / 2);
                            "
                            @mouseleave="showTooltip = false">
                                
                                @if(isset($item['digital_signature']) && $item['digital_signature'])
                                    <div class="flex items-center justify-center gap-1 whitespace-nowrap">
                                        <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-full dark:bg-indigo-900/30 dark:text-indigo-300 whitespace-nowrap">
                                            Signed
                                        </span>
                                    </div>
                                    <div class="text-[10px] text-zinc-400 mt-0.5 whitespace-nowrap">
                                        {{ isset($item['signature_datetime']) ? \Carbon\Carbon::parse($item['signature_datetime'])->format('d/m/Y H:i') : '-' }}
                                    </div>
                                @else
                                    @if(isset($item['verification_status']) && $item['verification_status'] === 'rejected')
                                        <span class="text-xs text-zinc-400 italic whitespace-nowrap">-</span>
                                    @else
                                        @can('sign uniform request')
                                            @if(isset($item['costing_feedback']) && $item['costing_feedback'])
                                                <button type="button" 
                                                    wire:click="openSignatureModal({{ $item['index'] }})" 
                                                    class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-indigo-700 bg-indigo-100 rounded-lg hover:bg-indigo-200 dark:bg-indigo-900/30 dark:text-indigo-300 dark:hover:bg-indigo-900/50 transition-colors whitespace-nowrap">
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                                                        <path d="M21.731 2.269a2.625 2.625 0 0 0-3.712 0l-1.157 1.157 3.712 3.712 1.157-1.157a2.625 2.625 0 0 0 0-3.712ZM19.513 8.199l-3.712-3.712-12.15 12.15a5.25 5.25 0 0 0-1.32 2.214l-.8 2.685a.75.75 0 0 0 .933.933l2.685-.8a5.25 5.25 0 0 0 2.214-1.32L19.513 8.2Z" />
                                                    </svg>
                                                    Sign
                                                </button>
                                            @else
                                                <span class="text-xs text-zinc-400 italic whitespace-nowrap">Waiting from Costing</span>
                                            @endif
                                        @else
                                            <span class="text-xs text-zinc-400 italic whitespace-nowrap">-</span>
                                        @endcan
                                    @endif
                                @endif
                                
                                @if(isset($item['digital_signature']) && $item['digital_signature'])
                                <div class="fixed z-[9999] pointer-events-none"
                                    x-show="showTooltip"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-95"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-cloak
                                    :style="`top: ${tooltipPosition.top - 10}px; left: ${tooltipPosition.left}px; transform: translateX(-50%) translateY(-100%);`">
                                    
                                    <div class="bg-zinc-900 text-white text-xs rounded-lg p-3 shadow-2xl min-w-[220px] max-w-[300px]">
                                        <div class="space-y-1 text-left">
                                            <p class="font-semibold text-zinc-300 border-b border-zinc-700 pb-1 mb-1">Signature Details</p>
                                            <p><span class="text-zinc-400">Status:</span> <span class="text-indigo-400">✓ Signed</span></p>
                                            <p><span class="text-zinc-400">Date:</span> {{ isset($item['signature_datetime']) ? \Carbon\Carbon::parse($item['signature_datetime'])->format('d/m/Y H:i') : '-' }}</p>
                                            <p><span class="text-zinc-400">By:</span> {{ $item['signature_name'] ?? '-' }}</p>
                                            @if(isset($item['digital_signature']) && $item['digital_signature'])
                                                <div class="border-t border-zinc-700 pt-2 mt-1">
                                                    <img src="{{ $item['digital_signature'] }}" 
                                                        alt="Signature" 
                                                        class="h-12 w-auto mx-auto border rounded dark:border-zinc-700 bg-white"
                                                        style="cursor: pointer;"
                                                        @click.stop="window.open('{{ $item['digital_signature'] }}', '_blank')">
                                                    <p class="text-[10px] text-zinc-500 text-center mt-1">Click signature to enlarge</p>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="absolute -bottom-1.5 left-1/2 transform -translate-x-1/2 rotate-45 w-3 h-3 bg-zinc-900"></div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($paginatedItems->hasPages())
            <div class="p-4">
                {{ $paginatedItems->onEachSide(1)->links() }}
            </div>
        @endif
    </flux:card>

    <!-- MODAL FEEDBACK -->
    <div x-data="{ 
        open: @entangle('showModal'), 
        closeModal() { this.open = false; $wire.closeModal(); }
    }" 
    x-show="open" 
    x-cloak>
        <div class="fixed inset-0 bg-black/50 z-40" @click="closeModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">{{ $modalTitle }}</h2>
                        <button @click="closeModal()" class="text-zinc-500 hover:text-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Feedback <span class="text-red-500">*</span></label>
                        <textarea wire:model="feedback_input" rows="4" 
                            placeholder="Enter your feedback here..."
                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button @click="closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="saveFeedback" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                            Save Feedback
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL VERIFICATION -->
    <div x-data="{ 
        open: @entangle('showVerificationModal'), 
        closeModal() { this.open = false; $wire.closeVerificationModal(); }
    }" 
    x-show="open" 
    x-cloak>
        <div class="fixed inset-0 bg-black/50 z-40" @click="closeModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Verify Item</h2>
                        <button @click="closeModal()" class="text-zinc-500 hover:text-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                                        
                    <div class="mb-4 overflow-x-auto">
                        <table class="w-full text-sm border rounded-lg">
                            <tbody>
                                <tr class="border-b">
                                    <td class="px-3 py-2 font-medium text-zinc-600 dark:text-zinc-400 w-1/3">Employee</td>
                                    <td class="px-3 py-2">: {{ $verificationItem['employee_name'] ?? '-' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-3 py-2 font-medium text-zinc-600 dark:text-zinc-400">NIK</td>
                                    <td class="px-3 py-2">: {{ $verificationItem['employee_nik'] ?? '-' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-3 py-2 font-medium text-zinc-600 dark:text-zinc-400">Item</td>
                                    <td class="px-3 py-2">: {{ $verificationItem['item_code'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 font-medium text-zinc-600 dark:text-zinc-400">Description</td>
                                    <td class="px-3 py-2">: {{ $verificationItem['description'] ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Verification Status <span class="text-red-500">*</span></label>
                        <div class="flex gap-3">
                            <button type="button" 
                                wire:click="$set('verificationStatus', 'approved')"
                                class="flex-1 px-4 py-2 border-2 rounded-lg transition-colors flex items-center justify-center gap-2"
                                :class="{
                                    'border-green-500 bg-green-50 dark:bg-green-900/20 text-green-700 dark:text-green-300': $wire.verificationStatus === 'approved',
                                    'border-zinc-300 dark:border-zinc-700 hover:border-green-300 text-zinc-700 dark:text-zinc-300': $wire.verificationStatus !== 'approved'
                                }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 shrink-0"
                                    :class="{
                                        'text-green-600': $wire.verificationStatus === 'approved',
                                        'text-green-400': $wire.verificationStatus !== 'approved'
                                    }">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">Approve</span>
                            </button>
                            
                            <button type="button" 
                                wire:click="$set('verificationStatus', 'rejected')"
                                class="flex-1 px-4 py-2 border-2 rounded-lg transition-colors flex items-center justify-center gap-2"
                                :class="{
                                    'border-red-500 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-300': $wire.verificationStatus === 'rejected',
                                    'border-zinc-300 dark:border-zinc-700 hover:border-red-300 text-zinc-700 dark:text-zinc-300': $wire.verificationStatus !== 'rejected'
                                }">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-5 shrink-0"
                                    :class="{
                                        'text-red-600': $wire.verificationStatus === 'rejected',
                                        'text-red-400': $wire.verificationStatus !== 'rejected'
                                    }">
                                    <path fill-rule="evenodd" d="M12 2.25c-5.385 0-9.75 4.365-9.75 9.75s4.365 9.75 9.75 9.75 9.75-4.365 9.75-9.75S17.385 2.25 12 2.25Zm-1.72 6.97a.75.75 0 1 0-1.06 1.06L10.94 12l-1.72 1.72a.75.75 0 1 0 1.06 1.06L12 13.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L13.06 12l1.72-1.72a.75.75 0 1 0-1.06-1.06L12 10.94l-1.72-1.72Z" clip-rule="evenodd" />
                                </svg>
                                <span class="text-sm font-medium">Reject</span>
                            </button>
                        </div>
                        @error('verificationStatus') 
                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Note (Optional)</label>
                        <textarea wire:model="verificationNote" rows="3" 
                            placeholder="Add note for verification..."
                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button @click="closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="saveVerification" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                            Save Verification
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DIGITAL SIGNATURE -->
    <div x-data="{ 
        open: @entangle('showSignatureModal'), 
        closeModal() { 
            this.open = false; 
            $wire.closeSignatureModal(); 
        },
        init() {
            this.$watch('open', (value) => {
                if (value) {
                    setTimeout(() => this.initCanvas(), 200);
                }
            });
        },
        initCanvas() {
            const canvas = document.getElementById('signatureCanvas');
            if (!canvas) return;
            
            const ctx = canvas.getContext('2d');
            let isDrawing = false;
            let lastX = 0;
            let lastY = 0;

            // Set ukuran canvas dengan benar - gunakan devicePixelRatio untuk kualitas lebih baik
            const rect = canvas.getBoundingClientRect();
            const dpr = window.devicePixelRatio || 1;
            canvas.width = rect.width * dpr;
            canvas.height = rect.height * dpr;
            canvas.style.width = rect.width + 'px';
            canvas.style.height = rect.height + 'px';
            ctx.scale(dpr, dpr);

            ctx.strokeStyle = '#1a1a1a';
            ctx.lineWidth = 2;
            ctx.lineCap = 'round';
            ctx.lineJoin = 'round';

            // Load signature yang sudah ada - gunakan $wire bukan @this
            if ($wire.signatureImage) {
                const img = new Image();
                img.onload = function() {
                    ctx.drawImage(img, 0, 0, rect.width, rect.height);
                };
                img.src = $wire.signatureImage;
            }

            function getPos(e) {
                const rect = canvas.getBoundingClientRect();
                let clientX, clientY;
                
                if (e.touches && e.touches.length > 0) {
                    clientX = e.touches[0].clientX;
                    clientY = e.touches[0].clientY;
                    e.preventDefault();
                } else {
                    clientX = e.clientX;
                    clientY = e.clientY;
                }
                
                // Hitung posisi relatif terhadap canvas
                return {
                    x: clientX - rect.left,
                    y: clientY - rect.top
                };
            }

            function startDraw(e) {
                e.preventDefault();
                isDrawing = true;
                const pos = getPos(e);
                lastX = pos.x;
                lastY = pos.y;
                console.log('Start draw at:', lastX, lastY); // Debug
            }

            function draw(e) {
                e.preventDefault();
                if (!isDrawing) return;
                const pos = getPos(e);
                ctx.beginPath();
                ctx.moveTo(lastX, lastY);
                ctx.lineTo(pos.x, pos.y);
                ctx.stroke();
                lastX = pos.x;
                lastY = pos.y;
            }

            function stopDraw(e) {
                e.preventDefault();
                if (isDrawing) {
                    isDrawing = false;
                    const imageData = canvas.toDataURL('image/png');
                    // Simpan ke Livewire
                    $wire.set('signatureImage', imageData);
                }
            }

            // Hapus event listener lama (jika ada)
            // Gunakan pendekatan dengan flag untuk menghindari duplicate listener
            if (canvas._listenersAdded) {
                // Jika sudah ada listener, jangan tambahkan lagi
                return;
            }
            canvas._listenersAdded = true;

            // Tambahkan event listener
            canvas.addEventListener('mousedown', startDraw);
            canvas.addEventListener('mousemove', draw);
            canvas.addEventListener('mouseup', stopDraw);
            canvas.addEventListener('mouseleave', stopDraw);

            canvas.addEventListener('touchstart', startDraw, { passive: false });
            canvas.addEventListener('touchmove', draw, { passive: false });
            canvas.addEventListener('touchend', stopDraw, { passive: false });

            // Clear button
            const clearBtn = document.getElementById('clearSignature');
            if (clearBtn) {
                clearBtn.onclick = function() {
                    const c = document.getElementById('signatureCanvas');
                    if (c) {
                        const ct = c.getContext('2d');
                        const r = c.getBoundingClientRect();
                        ct.clearRect(0, 0, r.width, r.height);
                        $wire.set('signatureImage', null);
                    }
                };
            }
        }
    }" 
    x-show="open" 
    x-cloak>
        <div class="fixed inset-0 bg-black/50 z-40" @click="closeModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl w-full max-w-md">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-bold">Digital Signature</h2>
                        <button @click="closeModal()" class="text-zinc-500 hover:text-zinc-700">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-4 overflow-x-auto">
                        <table class="w-full text-sm border rounded-lg">
                            <tbody>
                                <tr class="border-b">
                                    <td class="px-3 py-2 font-medium text-zinc-600 dark:text-zinc-400 w-1/3">Employee</td>
                                    <td class="px-3 py-2">: {{ $signatureItem['employee_name'] ?? '-' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-3 py-2 font-medium text-zinc-600 dark:text-zinc-400">NIK</td>
                                    <td class="px-3 py-2">: {{ $signatureItem['employee_nik'] ?? '-' }}</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="px-3 py-2 font-medium text-zinc-600 dark:text-zinc-400">Item</td>
                                    <td class="px-3 py-2">: {{ $signatureItem['item_code'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="px-3 py-2 font-medium text-zinc-600 dark:text-zinc-400">Qty</td>
                                    <td class="px-3 py-2">: {{ $signatureItem['qty'] ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Full Name <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="signatureName" 
                            placeholder="Enter your full name"
                            value="{{ $signatureItem['employee_name'] ?? '' }}"
                            class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 focus:ring-2 focus:ring-blue-500">
                        @error('signatureName') 
                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-1">Signature <span class="text-red-500">*</span></label>
                        <div class="border-2 border-zinc-300 dark:border-zinc-600 rounded-lg overflow-hidden bg-white dark:bg-zinc-800">
                            <canvas id="signatureCanvas" 
                                class="w-full h-48 touch-none cursor-crosshair"
                                style="touch-action: none; display: block;"
                            ></canvas>
                        </div>
                        <div class="flex justify-between mt-2">
                            <button id="clearSignature" 
                                type="button"
                                class="text-xs text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                Clear Signature
                            </button>
                            <span class="text-xs text-zinc-500">Draw your signature above</span>
                        </div>
                        @if($signatureImage)
                            <div class="mt-2 p-2 bg-green-50 dark:bg-green-900/20 rounded-lg">
                                <p class="text-xs text-green-600 dark:text-green-400">✓ Signature captured</p>
                            </div>
                        @endif
                        @error('signatureImage') 
                            <span class="text-red-500 text-xs">{{ $message }}</span> 
                        @enderror
                    </div>
                    
                    <div class="mb-4 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                        <p class="text-xs text-yellow-700 dark:text-yellow-400 flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span>By signing, you confirm that all information is correct and you authorize this request.</span>
                        </p>
                    </div>
                    
                    <div class="flex justify-end gap-2">
                        <button @click="closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="saveSignature" 
                            wire:loading.attr="disabled"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors inline-flex items-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            <svg wire:loading class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove>Sign Now</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL IMPORT ADMIN/COSTING -->
    <div x-data="{ 
        open: @entangle('showImportModal'), 
        closeModal() { this.open = false; $wire.closeImportModal(); }
    }" 
    x-show="open" 
    x-cloak>
        <div class="fixed inset-0 bg-black/50 z-40" @click="closeModal()"></div>
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-xl transition-all duration-300 flex flex-col"
                :class="{
                    'w-full max-w-2xl': !($wire.importPreview?.length > 0 || $wire.importErrors?.length > 0),
                    'w-full max-w-7xl': ($wire.importPreview?.length > 0 || $wire.importErrors?.length > 0)
                }">
                
                <div class="flex justify-between items-center p-6 pb-0">
                    <h2 class="text-xl font-bold">
                        Import {{ ucfirst($importType) }} Feedback
                    </h2>
                    <button @click="closeModal()" class="text-zinc-500 hover:text-zinc-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                
                <div class="flex-1 overflow-y-auto px-6" style="max-height: calc(90vh - 140px);">
                    @if(empty($importPreview) && empty($importErrors))
                        <div class="mb-4">
                            <div x-data="{ isDragging: false }" 
                                @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false"
                                @drop.prevent="
                                    isDragging = false;
                                    const file = event.dataTransfer.files[0];
                                    if (file && (file.type === 'text/csv' || file.name.endsWith('.csv'))) {
                                        $wire.upload('importFile', file);
                                    } else {
                                        alert('Please upload a CSV file');
                                    }
                                "
                                class="border-2 border-dashed rounded-lg p-8 text-center transition-colors cursor-pointer"
                                :class="{
                                    'border-blue-500 bg-blue-50 dark:bg-blue-900/20': isDragging,
                                    'border-zinc-300 dark:border-zinc-700 hover:border-blue-500 dark:hover:border-blue-500': !isDragging
                                }"
                                onclick="document.getElementById('csvFileInput').click()">
                                
                                <input type="file" wire:model="importFile" accept=".csv" id="csvFileInput" class="hidden">
                                
                                <svg class="w-12 h-12 mx-auto mb-3 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                
                                <p class="text-sm font-medium mb-1">Click to upload or drag and drop</p>
                                <p class="text-xs text-zinc-500">CSV file only (max 2MB)</p>
                                
                                <div wire:loading wire:target="importFile" class="mt-3">
                                    <div class="inline-flex items-center gap-2 text-blue-600">
                                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span>Uploading...</span>
                                    </div>
                                </div>
                                
                                <div wire:loading.remove wire:target="importFile" class="mt-2">
                                    <p class="text-xs text-green-600" id="fileNameDisplay">
                                        @if($importFile)
                                            ✓ {{ $importFile->getClientOriginalName() }}
                                        @else
                                            No file selected
                                        @endif
                                    </p>
                                </div>
                            </div>
                            
                            @error('importFile') 
                                <span class="text-red-500 text-xs block mt-2">{{ $message }}</span> 
                            @enderror
                            
                            <div class="mt-4 p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg">
                                <p class="text-xs font-medium text-zinc-600 dark:text-zinc-400 mb-1">CSV format required:</p>
                                @if($importType === 'admin')
                                    <p class="text-[10px] font-mono text-zinc-500 break-all">
                                        NIK,NAME,ITEM CODE,DESCRIPTION,SIZE,QTY,GROUP,REQUEST DATE,REASON,REMARKS,ADMIN FEEDBACK,SALARY DEDUCTION,PERIOD
                                    </p>
                                    <p class="text-[10px] text-zinc-400 mt-1">
                                        Note: SALARY DEDUCTION (Yes/No) and PERIOD (Month Year) are optional
                                    </p>
                                @else
                                    <p class="text-[10px] font-mono text-zinc-500 break-all">
                                        NIK,NAME,ITEM CODE,DESCRIPTION,SIZE,QTY,GROUP,REQUEST DATE,REASON,REMARKS,ADMIN FEEDBACK,ADMIN FEEDBACK DATE,VERIFICATION STATUS,VERIFICATION DATE,VERIFIED BY,VERIFICATION NOTE,COSTING FEEDBACK
                                    </p>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="mb-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg mb-4">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="font-semibold">Import Summary</p>
                                        <p class="text-sm">Total Success: <span class="text-green-600 font-bold">{{ $importSuccessCount }}</span></p>
                                        <p class="text-sm">Total Failed: <span class="text-red-600 font-bold">{{ $importFailCount }}</span></p>
                                    </div>
                                </div>
                            </div>
                            
                            @if(count($importErrors) > 0)
                                <div class="mb-6">
                                    <h3 class="font-semibold text-red-600 mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Failed Rows ({{ count($importErrors) }} rows) - Cannot Import
                                    </h3>
                                    <div class="overflow-x-auto border border-red-200 dark:border-red-800 rounded-lg">
                                        <table class="w-full text-sm" style="min-width: max-content; white-space: nowrap;">
                                            <thead class="bg-red-50 dark:bg-red-900/20">
                                                <tr>
                                                    <th class="px-3 py-2 text-left">Row</th>
                                                    <th class="px-3 py-2 text-left">Error Message</th>
                                                    <th class="px-3 py-2 text-left">NIK</th>
                                                    <th class="px-3 py-2 text-left">NAME</th>
                                                    <th class="px-3 py-2 text-left">ITEM CODE</th>
                                                    <th class="px-3 py-2 text-left">DESCRIPTION</th>
                                                    <th class="px-3 py-2 text-left">SIZE</th>
                                                    <th class="px-3 py-2 text-center">QTY</th>
                                                    <th class="px-3 py-2 text-left">GROUP</th>
                                                    <th class="px-3 py-2 text-left">REQUEST DATE</th>
                                                    <th class="px-3 py-2 text-left">REASON</th>
                                                    <th class="px-3 py-2 text-left">REMARKS</th>
                                                    <th class="px-3 py-2 text-left">FEEDBACK</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($importErrors as $error)
                                                    <tr class="border-t border-red-100 dark:border-red-900/50 hover:bg-red-50 dark:hover:bg-red-900/10">
                                                        <td class="px-3 py-2 font-mono text-red-700">{{ $error['row'] }}</td>
                                                        <td class="px-3 py-2 text-red-600 text-xs max-w-xs">
                                                            <div class="whitespace-normal">{{ $error['message'] }}</div>
                                                        </td>
                                                        <td class="px-3 py-2 font-mono">{{ $error['data']['NIK'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">{{ $error['data']['NAME'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">{{ $error['data']['ITEM CODE'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">{{ $error['data']['DESCRIPTION'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">{{ $error['data']['SIZE'] ?? '-' }}</td>
                                                        <td class="px-3 py-2 text-center">{{ $error['data']['QTY'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">{{ $error['data']['GROUP'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">{{ $error['data']['REQUEST DATE'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">{{ $error['data']['REASON'] ?? '-' }}</td>
                                                        <td class="px-3 py-2">{{ $error['data']['REMARKS'] ?? '-' }}</td>
                                                        <td class="px-3 py-2 max-w-xs">
                                                            <div class="text-xs break-words">{{ $error['data'][$importType === 'admin' ? 'ADMIN FEEDBACK' : 'COSTING FEEDBACK'] ?? '-' }}</div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                            
                            @if(count($importPreview) > 0)
                                <div class="mb-4">
                                    <h3 class="font-semibold text-green-600 mb-2 flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Success Rows ({{ count($importPreview) }} rows) - Ready to Import
                                    </h3>
                                    <div class="overflow-x-auto border border-green-200 dark:border-green-800 rounded-lg">
                                        <table class="w-full text-sm border-collapse" style="min-width: max-content;">
                                            <thead class="bg-green-50 dark:bg-green-900/20">
                                                <tr>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">Row</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">NIK</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">NAME</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">ITEM CODE</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">DESCRIPTION</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">SIZE</th>
                                                    <th class="px-3 py-2 text-center border-b border-green-200 dark:border-green-800">QTY</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">GROUP</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">REQUEST DATE</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">REASON</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">REMARKS</th>
                                                    <th class="px-3 py-2 text-left border-b border-green-200 dark:border-green-800">FEEDBACK</th>
                                                    
                                                    {{-- KOLOM UNTUK ADMIN --}}
                                                    @if($importType === 'admin')
                                                        <th class="px-3 py-2 text-center border-b border-green-200 dark:border-green-800">SALARY DEDUCTION</th>
                                                        <th class="px-3 py-2 text-center border-b border-green-200 dark:border-green-800">PERIOD</th>
                                                        <th class="px-3 py-2 text-center border-b border-green-200 dark:border-green-800">AMOUNT</th>
                                                    @endif
                                                    
                                                    {{-- KOLOM UNTUK COSTING --}}
                                                    @if($importType === 'costing')
                                                        <th class="px-3 py-2 text-center border-b border-green-200 dark:border-green-800">ADMIN FEEDBACK</th>
                                                        <th class="px-3 py-2 text-center border-b border-green-200 dark:border-green-800">VERIFICATION</th>
                                                        <th class="px-3 py-2 text-center border-b border-green-200 dark:border-green-800">STATUS</th>
                                                    @endif
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($importPreview as $preview)
                                                    <tr class="border-b border-green-100 dark:border-green-900/50 hover:bg-green-50 dark:hover:bg-green-900/10">
                                                        <td class="px-3 py-2 font-mono text-center">{{ $preview['row'] }}</td>
                                                        <td class="px-3 py-2 font-mono">{{ $preview['nik'] }}</td>
                                                        <td class="px-3 py-2">{{ $preview['name'] }}</td>
                                                        <td class="px-3 py-2 font-mono">{{ $preview['item_code'] }}</td>
                                                        <td class="px-3 py-2">{{ $preview['description'] }}</td>
                                                        <td class="px-3 py-2">{{ $preview['size'] ?: '-' }}</td>
                                                        <td class="px-3 py-2 text-center">{{ $preview['qty'] }}</td>
                                                        <td class="px-3 py-2">{{ $preview['group'] }}</td>
                                                        <td class="px-3 py-2">{{ $preview['request_date'] }}</td>
                                                        <td class="px-3 py-2">{{ $preview['reason'] }}</td>
                                                        <td class="px-3 py-2">{{ $preview['remarks'] ?: '-' }}</td>
                                                        <td class="px-3 py-2 max-w-md">
                                                            <div class="text-xs break-words whitespace-normal">
                                                                @if(isset($preview['is_rejected']) && $preview['is_rejected'])
                                                                    <span class="text-orange-600">⚠️ {{ $preview['feedback'] }}</span>
                                                                @else
                                                                    {{ $preview['feedback'] }}
                                                                @endif
                                                            </div>
                                                        </td>
                                                        
                                                        {{-- DATA UNTUK ADMIN --}}
                                                        @if($importType === 'admin')
                                                            <td class="px-3 py-2 text-center">
                                                                @if(isset($preview['salary_deduction']))
                                                                    @if($preview['salary_deduction'] === 'yes')
                                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300">
                                                                            Yes
                                                                        </span>
                                                                    @elseif($preview['salary_deduction'] === 'no')
                                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                                                            No
                                                                        </span>
                                                                    @else
                                                                        <span class="text-xs text-zinc-400">-</span>
                                                                    @endif
                                                                @else
                                                                    <span class="text-xs text-zinc-400">-</span>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-2 text-center">
                                                                {{ $preview['salary_period_display'] ?? '-' }}
                                                            </td>
                                                            <td class="px-3 py-2 text-center">
                                                                @if(isset($preview['salary_amount']) && $preview['salary_amount'] > 0)
                                                                    <span class="text-xs font-semibold text-red-600">- Rp {{ number_format($preview['salary_amount'], 0, ',', '.') }}</span>
                                                                @else
                                                                    <span class="text-xs text-zinc-400">-</span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        
                                                        {{-- DATA UNTUK COSTING --}}
                                                        @if($importType === 'costing')
                                                            <td class="px-3 py-2 text-center">
                                                                @if($preview['admin_feedback'])
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                        </svg>
                                                                        Filled
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                        Empty
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-2 text-center">
                                                                @if(isset($preview['is_manual']) && $preview['is_manual'])
                                                                    {{-- Manual input: N/A --}}
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-gray-700 bg-gray-100 rounded-full dark:bg-gray-900/30 dark:text-gray-300">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                        </svg>
                                                                        N/A
                                                                    </span>
                                                                @elseif(isset($preview['verification_status']) && $preview['verification_status'] === 'approved')
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-green-700 bg-green-100 rounded-full dark:bg-green-900/30 dark:text-green-300">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                        </svg>
                                                                        Approved
                                                                    </span>
                                                                @elseif(isset($preview['verification_status']) && $preview['verification_status'] === 'rejected')
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-red-700 bg-red-100 rounded-full dark:bg-red-900/30 dark:text-red-300">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                                        </svg>
                                                                        Rejected
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-yellow-700 bg-yellow-100 rounded-full dark:bg-yellow-900/30 dark:text-yellow-300">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                        </svg>
                                                                        Pending
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-2 text-center">
                                                                @if(isset($preview['is_rejected']) && $preview['is_rejected'])
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-orange-700 bg-orange-100 rounded-full dark:bg-orange-900/30 dark:text-orange-300">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                                        </svg>
                                                                        Skipped
                                                                    </span>
                                                                @else
                                                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 text-xs font-medium text-blue-700 bg-blue-100 rounded-full dark:bg-blue-900/30 dark:text-blue-300">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                        </svg>
                                                                        Ready
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        @endif
                                                        
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    @if($importType === 'costing')
                                        <div class="mt-3 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                                            <p class="text-xs text-yellow-700 dark:text-yellow-400 flex items-start gap-2">
                                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                <span><strong>Note:</strong> Items with status "Skipped" are REJECTED items. They will be ignored during import (no costing feedback will be added).</span>
                                            </p>
                                        </div>
                                    @endif
                                    
                                    @if($importType === 'admin')
                                        <div class="mt-3 p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                                            <p class="text-xs text-blue-700 dark:text-blue-400 flex items-start gap-2">
                                                <svg class="w-4 h-4 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                                <span><strong>Note:</strong> Salary Deduction will be auto-calculated from Master Uniform price. PERIOD format: "Month Year" (e.g., July 2026).</span>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
                
                <div class="flex justify-end gap-2 p-6 border-t border-zinc-200 dark:border-zinc-700 mt-2">
                    @if(empty($importPreview) && empty($importErrors))
                        <button @click="closeModal()" 
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="previewImport" 
                            wire:loading.attr="disabled"
                            :disabled="$wire.importFile === null"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            Preview Import
                        </button>
                    @else
                        <button wire:click="closeImportModal" 
                            wire:loading.attr="disabled"
                            class="px-4 py-2 border rounded-lg hover:bg-gray-50 dark:hover:bg-zinc-800 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="saveImport" 
                            @if($importSuccessCount == 0) disabled @endif
                            wire:loading.attr="disabled"
                            wire:target="saveImport"
                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center gap-2">
                            <svg wire:loading.remove wire:target="saveImport" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <svg wire:loading wire:target="saveImport" class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span wire:loading.remove wire:target="saveImport">Import {{ $importSuccessCount }} Record(s)</span>
                            <span wire:loading wire:target="saveImport">Importing & Sending Email...</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        .overflow-x-auto {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f1f1f1;
        }
        .overflow-x-auto::-webkit-scrollbar {
            height: 6px;
        }
        .overflow-x-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-track {
            background: #1f1f1f;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb {
            background: #3f3f46;
        }
        .dark .overflow-x-auto::-webkit-scrollbar-thumb:hover {
            background: #52525b;
        }
        .fixed.z-\[9999\] {
            will-change: transform;
        }
        .pointer-events-none {
            pointer-events: none;
        }
        .pointer-events-none img {
            pointer-events: auto;
        }
    </style>
</div>