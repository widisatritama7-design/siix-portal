<section class="w-full" x-data="{ currentStep: 0, steps: [] }" x-init="steps = [
    { number: 1, name: 'GENERAL', complete: false },
    { number: 2, name: 'LOADER', complete: false },
    { number: 3, name: 'PCB CLEANER', complete: false },
    { number: 4, name: 'PRINTING', complete: false },
    { number: 5, name: 'SPI', complete: false },
    { number: 6, name: 'CHIP MOUNTER 1', complete: false },
    { number: 7, name: 'CHIP MOUNTER 2', complete: false },
    { number: 8, name: 'REFLOW', complete: false },
    { number: 9, name: 'AOI', complete: false },
    { number: 10, name: 'UNLOADER', complete: false },
    { number: 11, name: 'AOI TABLE', complete: false },
    { number: 12, name: 'REFLOW 2', complete: false },
    { number: 13, name: 'CHIP MOUNTER 3', complete: false },
    { number: 14, name: 'CHIP MOUNTER 4', complete: false },
    { number: 15, name: 'SPI 2', complete: false },
    { number: 16, name: 'PRINTER', complete: false },
    { number: 17, name: 'PCB CLEANER 2', complete: false },
    { number: 18, name: 'IONIZER', complete: false },
    { number: 19, name: 'TIME & STATUS', complete: false }
]">

    <flux:heading class="sr-only">
        {{ __('MTC - Create Daily Panasonic Inspection') }}
    </flux:heading>

    <x-mtc.layout class="!max-w-full !px-0 !mx-0">
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
                    <flux:breadcrumbs.item href="{{ route('mtc.master-lines.show', $masterLineId) }}" wire:navigate separator="slash">
                        Line {{ $masterLine->line_number }}
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        Create Daily Panasonic
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div class="w-full sm:w-auto">
                        <h1 class="text-2xl sm:text-3xl font-bold text-zinc-800 dark:text-white">
                            Create Daily Panasonic Inspection
                        </h1>
                        <p class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            Create new inspection record for line {{ $masterLine->line_number }}
                        </p>
                    </div>
                    <div class="w-full sm:w-auto flex-shrink-0">
                        <flux:button 
                            href="{{ route('mtc.master-lines.show', $masterLineId) }}"
                            wire:navigate
                            icon="arrow-left"
                            variant="primary"
                            color="blue"
                            class="w-full sm:w-auto justify-center"
                        >
                            Back to Line Detail
                        </flux:button>
                    </div>
                </div>
            </div>
        </x-slot>
        
        <div class="-mt-2">
            <form wire:submit="save">
                <!-- Status Judgement Card -->
                <flux:card class="p-0 shadow-lg overflow-hidden mb-6">
                    <div class="{{ $overallStatus === 'success' ? 'bg-green-600' : 'bg-red-600' }} dark:{{ $overallStatus === 'success' ? 'bg-green-500' : 'bg-red-500' }} px-6 py-4">
                        <div class="flex items-center gap-2">
                            @if($overallStatus === 'success')
                                <flux:icon.check-circle class="w-5 h-5 text-white" />
                            @else
                                <flux:icon.x-circle class="w-5 h-5 text-white" />
                            @endif
                            <h3 class="font-semibold text-base text-white">
                                {{ $overallStatus === 'success' ? 'All Parameters Valid' : 'Incomplete / Invalid Parameters' }}
                            </h3>
                        </div>
                    </div>
                    <div class="p-4">
                        <p class="text-sm {{ $overallStatus === 'success' ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400' }}">
                            {{ $overallStatusText }}
                        </p>
                        @if($overallStatus === 'success')
                            <p class="text-xs text-green-600 dark:text-green-500 mt-2">
                                Status akan otomatis berubah menjadi "Checked" ketika semua parameter terisi dengan benar.
                            </p>
                        @else
                            <p class="text-xs text-red-600 dark:text-red-500 mt-2">
                                Lengkapi semua field yang diperlukan untuk menyelesaikan inspection.
                            </p>
                        @endif
                    </div>
                </flux:card>

                <!-- Wizard Navigation -->
                <div class="mb-8">
                    <!-- Desktop View -->
                    <div class="hidden lg:block">
                        <div class="relative mb-8">
                            <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                <div class="w-full border-t-2 border-zinc-200 dark:border-zinc-700"></div>
                            </div>
                            <div class="relative flex justify-between">
                                <template x-for="(step, index) in steps" :key="index">
                                    <button 
                                        type="button"
                                        @click="currentStep = index"
                                        class="group relative flex flex-col items-center flex-1"
                                    >
                                        <span class="relative flex h-10 w-10 items-center justify-center rounded-full transition-all duration-300"
                                            :class="{
                                                'bg-blue-600 ring-4 ring-blue-200 dark:ring-blue-900': currentStep === index,
                                                'bg-green-600 ring-4 ring-green-200 dark:ring-green-900': step.complete && currentStep !== index,
                                                'bg-red-500 ring-4 ring-red-200 dark:ring-red-900': step.hasError && currentStep !== index,
                                                'bg-zinc-300 dark:bg-zinc-600': !step.complete && !step.hasError && currentStep !== index
                                            }">
                                            <template x-if="step.complete && currentStep !== index">
                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </template>
                                            <template x-if="step.hasError && currentStep !== index">
                                                <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                            </template>
                                            <template x-if="(!step.complete && !step.hasError) || currentStep === index">
                                                <span class="text-sm font-semibold text-white" x-text="step.number"></span>
                                            </template>
                                        </span>
                                        <div class="absolute -bottom-6">
                                            <div class="flex items-center gap-1">
                                                <span class="text-xs font-medium px-1.5 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none"
                                                    :class="{
                                                        'text-blue-600 dark:text-blue-400': currentStep === index,
                                                        'text-green-600 dark:text-green-400': step.complete && currentStep !== index,
                                                        'text-red-600 dark:text-red-400': step.hasError && currentStep !== index,
                                                        'text-zinc-400 dark:text-zinc-500': !step.complete && !step.hasError && currentStep !== index
                                                    }"
                                                    x-text="step.name">
                                                </span>
                                            </div>
                                        </div>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Tablet View -->
                    <div class="hidden sm:block lg:hidden">
                        <div class="overflow-x-auto pb-4 -mx-4 px-4">
                            <div class="flex gap-3 min-w-max">
                                <template x-for="(step, index) in steps" :key="index">
                                    <button
                                        type="button"
                                        @click="currentStep = index"
                                        class="flex flex-col items-center gap-1 px-3 py-2 rounded-lg transition-all duration-200 min-w-[70px] relative"
                                        :class="{
                                            'bg-blue-600 text-white shadow-lg': currentStep === index,
                                            'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400': step.complete && currentStep !== index,
                                            'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': step.hasError && currentStep !== index,
                                            'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400': !step.complete && !step.hasError && currentStep !== index
                                        }"
                                    >
                                        <div x-show="step.hasError && currentStep !== index" 
                                            class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </div>
                                        <div x-show="step.complete && currentStep !== index" 
                                            class="absolute -top-1 -right-1 w-4 h-4 rounded-full bg-green-500 flex items-center justify-center">
                                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm font-bold" x-text="step.number"></span>
                                        <span class="text-[10px] font-medium truncate max-w-[60px]" x-text="step.name"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile View -->
                    <div class="sm:hidden">
                        <div class="overflow-x-auto pb-4 -mx-4 px-4">
                            <div class="flex gap-2 min-w-max">
                                <template x-for="(step, index) in steps" :key="index">
                                    <button
                                        type="button"
                                        @click="currentStep = index"
                                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-full transition-all duration-200 relative"
                                        :class="{
                                            'bg-blue-600 text-white shadow-lg': currentStep === index,
                                            'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400': step.complete && currentStep !== index,
                                            'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400': step.hasError && currentStep !== index,
                                            'bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400': !step.complete && !step.hasError && currentStep !== index
                                        }"
                                    >
                                        <template x-if="step.complete && currentStep !== index">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </template>
                                        <template x-if="step.hasError && currentStep !== index">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </template>
                                        <template x-if="(!step.complete && !step.hasError) || currentStep === index">
                                            <span class="text-xs font-bold" x-text="step.number"></span>
                                        </template>
                                        <span class="text-xs whitespace-nowrap" x-text="step.name"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Current Step Info -->
                    <div class="mt-4 text-center">
                        <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full"
                            :class="{
                                'bg-blue-50 dark:bg-blue-950/30': !steps[currentStep]?.hasError,
                                'bg-red-50 dark:bg-red-950/30': steps[currentStep]?.hasError
                            }">
                            <span class="text-xs font-medium"
                                :class="{
                                    'text-blue-600 dark:text-blue-400': !steps[currentStep]?.hasError,
                                    'text-red-600 dark:text-red-400': steps[currentStep]?.hasError
                                }">
                                Step <span x-text="currentStep + 1" class="font-bold"></span> of <span x-text="steps.length" class="font-bold"></span>
                                <span class="hidden sm:inline"> - <span x-text="steps[currentStep]?.name"></span></span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <!-- STEP 1: GENERAL (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 0" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">1</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">GENERAL</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Body Cover</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure all machine cover clean | Standard : No Dust and clean</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="body_cover" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="body_cover" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 2: LOADER -->
                    <div x-show="currentStep === 1" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">2</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">LOADER</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cylinder (1)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Operation And center | Standard : Smooth and center</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cylinder" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cylinder" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Magazine PCB (1.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="rail_and_magazine_pcb" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="rail_and_magazine_pcb" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cover Magazine (1.b)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cover_magazine" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cover_magazine" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 3: PCB CLEANER (sama seperti Daily Fuji dengan field yang sama) -->
                    <div x-show="currentStep === 2" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">3</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">PCB CLEANER</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <!-- Brush -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Brush (2)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning touch PCB | Standard : Rotation</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="brush" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="brush" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Air Pressure -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (2.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.45 - 0.54 Mpa</p>
                                    <input type="text" wire:model.live="air_presure" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('air_presure', $air_presure) }}">
                                    @php $validation = $this->validateNumericField('air_presure', $air_presure); @endphp
                                    @if(!$validation['valid'] && $air_presure !== null && $air_presure !== '' && $air_presure !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Vacume Pressure Unitech -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Pressure Unitech (2.b)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.45 - 0.54 Mpa (Unitech only)</p>
                                    <input type="text" wire:model.live="vacume_presure_unitech" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('vacume_presure_unitech', $vacume_presure_unitech) }}">
                                    @php $validation = $this->validateNumericField('vacume_presure_unitech', $vacume_presure_unitech); @endphp
                                    @if(!$validation['valid'] && $vacume_presure_unitech !== null && $vacume_presure_unitech !== '' && $vacume_presure_unitech !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Vacume Pressure Nix -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Pressure Nix (2.c)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.60 - 0.70 Mpa (N.I.X only)</p>
                                    <input type="text" wire:model.live="vacume_presure_nix" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('vacume_presure_nix', $vacume_presure_nix) }}">
                                    @php $validation = $this->validateNumericField('vacume_presure_nix', $vacume_presure_nix); @endphp
                                    @if(!$validation['valid'] && $vacume_presure_nix !== null && $vacume_presure_nix !== '' && $vacume_presure_nix !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Vacume Brush -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Brush (3)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Operation | Standard : Rotation</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="vacume_brush" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="vacume_brush" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Cleaning Roller -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cleaning Roller (4)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Rotation and Cleaning | Standard : Smooth rotation & Clean</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cleaning_roller" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cleaning_roller" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Ionizer -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Ionizer (5)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning | Standard : 5 Times to push cleaner</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="ionizer" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="ionizer" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Conveyor Setting -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Conveyor Setting (6)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Analog panel (write value) | Standard : ≤ 40</p>
                                    <input type="text" wire:model.live="conveyor_speed" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('conveyor_speed', $conveyor_speed) }}">
                                    @php $validation = $this->validateNumericField('conveyor_speed', $conveyor_speed); @endphp
                                    @if(!$validation['valid'] && $conveyor_speed !== null && $conveyor_speed !== '' && $conveyor_speed !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 4: PRINTING (dengan field Panasonic: clamp_presure_sp_60, clamp_presure_spg_2, squeege_sp_60, squeege_spg_2) -->
                    <div x-show="currentStep === 3" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">4</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">PRINTING</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <!-- IPA Solvent -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">IPA Solvent (7)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure solvent minimal on mid level (half) | Standard : Tank Minimal half</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="ipa_solvent" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="ipa_solvent" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <!-- Temperature Control -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (8)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Result-01 | Standard : 23-27℃</p>
                                    <input type="text" wire:model.live="temperature_control_1" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('temperature_control_1', $temperature_control_1) }}">
                                    @php $validation = $this->validateNumericField('temperature_control_1', $temperature_control_1); @endphp
                                    @if(!$validation['valid'] && $temperature_control_1 !== null && $temperature_control_1 !== '' && $temperature_control_1 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Humidity Control -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Humidity Control (8.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Result-01 | Standard : 35 % - 70 %</p>
                                    <input type="text" wire:model.live="humidity_control_1" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('humidity_control_1', $humidity_control_1) }}">
                                    @php $validation = $this->validateNumericField('humidity_control_1', $humidity_control_1); @endphp
                                    @if(!$validation['valid'] && $humidity_control_1 !== null && $humidity_control_1 !== '' && $humidity_control_1 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Clamp Pressure SP-60 -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Clamp Pressure SP-60 (9)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.20 ~ 0.4 Mpa</p>
                                    <input type="text" wire:model.live="clamp_presure_sp_60" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('clamp_presure_sp_60', $clamp_presure_sp_60) }}">
                                    @php $validation = $this->validateNumericField('clamp_presure_sp_60', $clamp_presure_sp_60); @endphp
                                    @if(!$validation['valid'] && $clamp_presure_sp_60 !== null && $clamp_presure_sp_60 !== '' && $clamp_presure_sp_60 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Clamp Pressure SPG-2 -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Clamp Pressure SPG-2 (9)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.20 ~ 0.4 Mpa</p>
                                    <input type="text" wire:model.live="clamp_presure_spg_2" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('clamp_presure_spg_2', $clamp_presure_spg_2) }}">
                                    @php $validation = $this->validateNumericField('clamp_presure_spg_2', $clamp_presure_spg_2); @endphp
                                    @if(!$validation['valid'] && $clamp_presure_spg_2 !== null && $clamp_presure_spg_2 !== '' && $clamp_presure_spg_2 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Squeege SP-60 -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Squeege SP-60 (10)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.19 ~ 0.21 Mpa</p>
                                    <input type="text" wire:model.live="squeege_sp_60" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('squeege_sp_60', $squeege_sp_60) }}">
                                    @php $validation = $this->validateNumericField('squeege_sp_60', $squeege_sp_60); @endphp
                                    @if(!$validation['valid'] && $squeege_sp_60 !== null && $squeege_sp_60 !== '' && $squeege_sp_60 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Squeege SPG-2 -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Squeege SPG-2 (10)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.11 ~ 0.13 Mpa</p>
                                    <input type="text" wire:model.live="squeege_spg_2" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('squeege_spg_2', $squeege_spg_2) }}">
                                    @php $validation = $this->validateNumericField('squeege_spg_2', $squeege_spg_2); @endphp
                                    @if(!$validation['valid'] && $squeege_spg_2 !== null && $squeege_spg_2 !== '' && $squeege_spg_2 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Cleaning Solvent -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cleaning Solvent (11)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.19 ~ 0.21 Mpa</p>
                                    <input type="text" wire:model.live="cleaning_solvent" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('cleaning_solvent', $cleaning_solvent) }}">
                                    @php $validation = $this->validateNumericField('cleaning_solvent', $cleaning_solvent); @endphp
                                    @if(!$validation['valid'] && $cleaning_solvent !== null && $cleaning_solvent !== '' && $cleaning_solvent !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <!-- Air Pressure Meter -->
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Meter (12)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.50~ 0.55 Mpa</p>
                                    <input type="text" wire:model.live="air_presure_meter" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('air_presure_meter', $air_presure_meter) }}">
                                    @php $validation = $this->validateNumericField('air_presure_meter', $air_presure_meter); @endphp
                                    @if(!$validation['valid'] && $air_presure_meter !== null && $air_presure_meter !== '' && $air_presure_meter !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 5: SPI (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 4" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">5</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">SPI</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Meter Parmi (12.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa (PARMI)</p>
                                    <input type="text" wire:model.live="air_presure_meter_parmi" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('air_presure_meter_parmi', $air_presure_meter_parmi) }}">
                                    @php $validation = $this->validateNumericField('air_presure_meter_parmi', $air_presure_meter_parmi); @endphp
                                    @if(!$validation['valid'] && $air_presure_meter_parmi !== null && $air_presure_meter_parmi !== '' && $air_presure_meter_parmi !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Capability Index (12.b)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check SPI Measurement result with Master Jig (Solder Paste height) (write CpK value) | Standard : CpK for Masspro > 1.33</p>
                                    <input type="text" wire:model.live="capability_index" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('capability_index', $capability_index) }}">
                                    @php $validation = $this->validateNumericField('capability_index', $capability_index); @endphp
                                    @if(!$validation['valid'] && $capability_index !== null && $capability_index !== '' && $capability_index !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 6: CHIP MOUNTER 1 (Panasonic: box, vaccuum_parameter, expire_date, vaccuum_pump) -->
                    <div x-show="currentStep === 5" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">6</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">CHIP MOUNTER 1</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Supply (13)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.49 ~ 0.54 Mpa</p>
                                    <input type="text" wire:model.live="air_presure_supply" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('air_presure_supply', $air_presure_supply) }}">
                                    @php $validation = $this->validateNumericField('air_presure_supply', $air_presure_supply); @endphp
                                    @if(!$validation['valid'] && $air_presure_supply !== null && $air_presure_supply !== '' && $air_presure_supply !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (13.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                                    <input type="text" wire:model.live="vaccuum_pump" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('vaccuum_pump', $vaccuum_pump) }}">
                                    @php $validation = $this->validateNumericField('vaccuum_pump', $vaccuum_pump); @endphp
                                    @if(!$validation['valid'] && $vaccuum_pump !== null && $vaccuum_pump !== '' && $vaccuum_pump !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (13.b)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Chip collection | Standard : No components</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="box" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="box" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Parameter (13.c)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with machine parameter result | Standard : No Yellow initial (display)</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="vaccuum_parameter" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="vaccuum_parameter" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Expire Date (14)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure due date on the label | Standard : No Expired</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="expire_date" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="expire_date" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 7: CHIP MOUNTER 2 (Panasonic: box_2, vaccuum_parameter_2, expire_date_2, vaccuum_pump_2) -->
                    <div x-show="currentStep === 6" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">7</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">CHIP MOUNTER 2</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Supply (15)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.49 ~ 0.54 Mpa</p>
                                    <input type="text" wire:model.live="air_presure_supply_2" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('air_presure_supply_2', $air_presure_supply_2) }}">
                                    @php $validation = $this->validateNumericField('air_presure_supply_2', $air_presure_supply_2); @endphp
                                    @if(!$validation['valid'] && $air_presure_supply_2 !== null && $air_presure_supply_2 !== '' && $air_presure_supply_2 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (15.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                                    <input type="text" wire:model.live="vaccuum_pump_2" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('vaccuum_pump_2', $vaccuum_pump_2) }}">
                                    @php $validation = $this->validateNumericField('vaccuum_pump_2', $vaccuum_pump_2); @endphp
                                    @if(!$validation['valid'] && $vaccuum_pump_2 !== null && $vaccuum_pump_2 !== '' && $vaccuum_pump_2 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (15.b)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Chip collection | Standard : No components</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="box_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="box_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Parameter (15.c)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with machine parameter result | Standard : No Yellow initial (display)</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="vaccuum_parameter_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="vaccuum_parameter_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Expire Date (16)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Make sure due date on the label | Standard : No Expired</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="expire_date_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="expire_date_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 8: REFLOW (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 7" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">8</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">REFLOW</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Abandonment (17)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Damage | Standard : No Damage</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="abandonment" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="abandonment" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fire Possibility (17.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : PCB input area No paper,plastic | Standard : No Paper, No plastic</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="fire_posibilty" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="fire_posibilty" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Transfer Unit (18)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : make sure it is smooth condition | Standard : No jammed</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="rail_and_transfer_unit" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="rail_and_transfer_unit" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">N2 Pressure (19)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check N2 Pressure | Standard : 0.4MPa ~ 0.5MPa</p>
                                    <input type="text" wire:model.live="n2_presure" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('n2_presure', $n2_presure) }}">
                                    @php $validation = $this->validateNumericField('n2_presure', $n2_presure); @endphp
                                    @if(!$validation['valid'] && $n2_presure !== null && $n2_presure !== '' && $n2_presure !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Oxygen Density SEK (20)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Oxygen meter (SEK Standard) | Standard : 1200~1800 ppm</p>
                                    <input type="text" wire:model.live="oxygent_density_sek" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('oxygent_density_sek', $oxygent_density_sek) }}">
                                    @php $validation = $this->validateNumericField('oxygent_density_sek', $oxygent_density_sek); @endphp
                                    @if(!$validation['valid'] && $oxygent_density_sek !== null && $oxygent_density_sek !== '' && $oxygent_density_sek !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Oxygen Density Special (20)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Oxygen meter (Special Requirement) | Standard : 500~1000 ppm</p>
                                    <input type="text" wire:model.live="oxygent_density_special" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('oxygent_density_special', $oxygent_density_special) }}">
                                    @php $validation = $this->validateNumericField('oxygent_density_special', $oxygent_density_special); @endphp
                                    @if(!$validation['valid'] && $oxygent_density_special !== null && $oxygent_density_special !== '' && $oxygent_density_special !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fire Possibility (20.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : PCB Output area No paper,plastic | Standard : No Paper, No plastic</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="fire_posibilty_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="fire_posibilty_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 9: AOI (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 8" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">9</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">AOI</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (20.b)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa</p>
                                    <input type="text" wire:model.live="air_presure_2" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('air_presure_2', $air_presure_2) }}">
                                    @php $validation = $this->validateNumericField('air_presure_2', $air_presure_2); @endphp
                                    @if(!$validation['valid'] && $air_presure_2 !== null && $air_presure_2 !== '' && $air_presure_2 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 10: UNLOADER (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 9" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">10</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">UNLOADER</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cylinder (21)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Operation And center | Standard : Smooth and center</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cylinder_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cylinder_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Magazine PCB (21.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="rail_and_magazine_pcb_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="rail_and_magazine_pcb_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cover Magazine (21.b)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cover_magazine_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="cover_magazine_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 11: AOI TABLE (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 10" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">11</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">AOI TABLE</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Angle & Filter (22)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning | Standard : No dirt / no dust</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="angle_and_filter" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="angle_and_filter" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Lamp Indicator (22.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : LED Lamp (Green) | Standard : Function</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="lamp_indicator" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="lamp_indicator" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 12: REFLOW 2 (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 11" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">12</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">REFLOW 2</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Chiller (23)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Write down the value | Standard : 17-23℃</p>
                                    <input type="text" wire:model.live="temperature_chiller" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('temperature_chiller', $temperature_chiller) }}">
                                    @php $validation = $this->validateNumericField('temperature_chiller', $temperature_chiller); @endphp
                                    @if(!$validation['valid'] && $temperature_chiller !== null && $temperature_chiller !== '' && $temperature_chiller !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (24)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check Value inspect | Standard : 300℃ ±10℃</p>
                                    <input type="text" wire:model.live="temperature_control_3" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('temperature_control_3', $temperature_control_3) }}">
                                    @php $validation = $this->validateNumericField('temperature_control_3', $temperature_control_3); @endphp
                                    @if(!$validation['valid'] && $temperature_control_3 !== null && $temperature_control_3 !== '' && $temperature_control_3 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 13: CHIP MOUNTER 3 (Panasonic: box_3, vaccuum_pump_3) -->
                    <div x-show="currentStep === 12" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">13</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">CHIP MOUNTER 3</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (25)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Chip collection | Standard : No components</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="box_3" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="box_3" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (25.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                                    <input type="text" wire:model.live="vaccuum_pump_3" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('vaccuum_pump_3', $vaccuum_pump_3) }}">
                                    @php $validation = $this->validateNumericField('vaccuum_pump_3', $vaccuum_pump_3); @endphp
                                    @if(!$validation['valid'] && $vaccuum_pump_3 !== null && $vaccuum_pump_3 !== '' && $vaccuum_pump_3 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 14: CHIP MOUNTER 4 (Panasonic: box_4, vaccuum_pump_4) -->
                    <div x-show="currentStep === 13" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">14</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">CHIP MOUNTER 4</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (26)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Chip collection | Standard : No components</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="box_4" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="box_4" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (26.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                                    <input type="text" wire:model.live="vaccuum_pump_4" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('vaccuum_pump_4', $vaccuum_pump_4) }}">
                                    @php $validation = $this->validateNumericField('vaccuum_pump_4', $vaccuum_pump_4); @endphp
                                    @if(!$validation['valid'] && $vaccuum_pump_4 !== null && $vaccuum_pump_4 !== '' && $vaccuum_pump_4 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 15: SPI 2 (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 14" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">15</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">SPI 2</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (27)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa (Kohyoung)</p>
                                    <input type="text" wire:model.live="air_presure_3" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('air_presure_3', $air_presure_3) }}">
                                    @php $validation = $this->validateNumericField('air_presure_3', $air_presure_3); @endphp
                                    @if(!$validation['valid'] && $air_presure_3 !== null && $air_presure_3 !== '' && $air_presure_3 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 16: PRINTER (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 15" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">16</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">PRINTER</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (28)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Air cond Setting Temperature | Standard : 23-27℃</p>
                                    <input type="text" wire:model.live="temperature_control_4" placeholder="Enter value or '-' for not applicable" class="w-full rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 {{ $this->getFieldColorClass('temperature_control_4', $temperature_control_4) }}">
                                    @php $validation = $this->validateNumericField('temperature_control_4', $temperature_control_4); @endphp
                                    @if(!$validation['valid'] && $temperature_control_4 !== null && $temperature_control_4 !== '' && $temperature_control_4 !== '-')
                                        <p class="text-xs text-red-600 mt-1">{{ $validation['message'] }}</p>
                                    @endif
                                </div>
                                
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Water Reservoirs (28.a)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Damage, Function | Standard : Function, No Damage</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="water_reservoirs" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="water_reservoirs" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 17: PCB CLEANER 2 (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 16" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">17</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">PCB CLEANER 2</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Filter (29)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning | Standard : Clean</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="filter" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="filter" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 18: IONIZER (sama seperti Daily Fuji) -->
                    <div x-show="currentStep === 17" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-blue-100 dark:bg-blue-900/30 px-6 py-4 border-b border-blue-200 dark:border-blue-800">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">18</span>
                                    <h3 class="font-semibold text-base text-blue-800 dark:text-blue-300">IONIZER</h3>
                                </div>
                            </div>
                            <div class="p-6">
                                <div>
                                    <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Angle & Filter (30)</label>
                                    <p class="text-xs text-zinc-500 mt-1 mb-2">Details On Check : Cleaning | Standard : No dirt / no dust</p>
                                    <div class="flex gap-6">
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="angle_and_filter_2" value="checked" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">Checked ✓</span>
                                        </label>
                                        <label class="inline-flex items-center gap-2">
                                            <input type="radio" wire:model.live="angle_and_filter_2" value="na" class="rounded border-zinc-300 text-blue-600 focus:ring-blue-500">
                                            <span class="text-sm">N/A (Not Applicable)</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- STEP 19: TIME & STATUS -->
                    <div x-show="currentStep === 18" x-cloak>
                        <flux:card class="p-0 shadow-lg overflow-hidden">
                            <div class="bg-green-600 dark:bg-green-500 px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <flux:icon name="clock" class="w-5 h-5 text-white" />
                                    <h3 class="font-semibold text-base text-white">TIME & STATUS</h3>
                                </div>
                            </div>
                            <div class="p-6 space-y-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Stop Time</label>
                                        <input type="time" wire:model="stop_time" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Run Time</label>
                                        <input type="time" wire:model.live="run_time" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">
                                    </div>
                                    
                                    <div>
                                        <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Group <span class="text-red-500">*</span></label>
                                        <select wire:model.live="group" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm focus:ring-2 focus:ring-green-500">
                                            <option value="">Select Group</option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                        </select>
                                        @error('group') <span class="text-xs text-red-600 mt-1">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <!-- Status Preview -->
                                <div class="mt-4 p-4 rounded-lg {{ $overallStatus === 'success' ? 'bg-green-50 dark:bg-green-950/30 border border-green-200' : 'bg-yellow-50 dark:bg-yellow-950/30 border border-yellow-200' }}">
                                    <div class="flex items-center gap-2">
                                        @if($overallStatus === 'success')
                                            <flux:icon.check-circle class="w-5 h-5 text-green-600" />
                                            <span class="text-sm font-medium text-green-700 dark:text-green-400">Status akan disimpan sebagai: Checked</span>
                                        @else
                                            <flux:icon.clock class="w-5 h-5 text-yellow-600" />
                                            <span class="text-sm font-medium text-yellow-700 dark:text-yellow-400">Status akan disimpan sebagai: On Progress</span>
                                        @endif
                                    </div>
                                    <p class="text-xs {{ $overallStatus === 'success' ? 'text-green-600' : 'text-yellow-600' }} mt-1">
                                        {{ $overallStatusText }}
                                    </p>
                                </div>
                            </div>
                        </flux:card>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between gap-3 mt-6">
                        <div>
                            <button type="button" x-show="currentStep > 0" @click="currentStep--" class="px-4 py-2 text-sm font-medium rounded-lg border border-zinc-300 dark:border-zinc-600 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                ← Previous
                            </button>
                        </div>
                        <div class="flex gap-3">
                            <button type="button" x-show="currentStep < steps.length - 1" @click="currentStep++" class="px-4 py-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                                Next →
                            </button>
                            <button type="submit" x-show="currentStep === steps.length - 1" class="px-6 py-2 text-sm font-medium rounded-lg bg-green-600 text-white hover:bg-green-700 transition-colors">
                                Create Inspection
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </x-mtc.layout>
</section>

<script>
    document.addEventListener('livewire:initialized', () => {
        // Update step completion status when form changes
        Livewire.on('step-complete-update', () => {
            // This will be triggered when judgement runs
        });
    });
</script>

<style>
    [x-cloak] { display: none !important; }
    input.border-red-500, select.border-red-500 { border-color: #ef4444 !important; }
    input.border-green-500, select.border-green-500 { border-color: #22c55e !important; }
</style>