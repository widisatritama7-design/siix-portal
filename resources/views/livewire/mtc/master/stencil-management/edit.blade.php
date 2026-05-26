<section class="w-full">
    <x-mtc.layout class="!max-w-full !px-0 !mx-0">
        <x-slot name="heading">
            <div class="w-full">
                <flux:breadcrumbs class="mb-1">
                    <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">
                        Dashboard
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item href="{{ route('mtc.stencil.index') }}" wire:navigate separator="slash">
                        Stencil Management
                    </flux:breadcrumbs.item>
                    <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600 dark:text-blue-400">
                        {{ $isEditMode ? 'Edit Stencil' : 'Create Stencil' }}
                    </flux:breadcrumbs.item>
                </flux:breadcrumbs>
            </div>
        </x-slot>
        
        <x-slot name="subheading">
            <div class="w-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <div>
                        <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                            {{ $isEditMode ? 'Edit Stencil' : 'Create New Stencil' }}
                        </h1>
                        <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                            {{ $isEditMode ? 'Update stencil information' : 'Add new stencil to inventory' }}
                        </p>
                    </div>
                </div>
            </div>
        </x-slot>

        <div class="mt-4">
            <flux:card class="p-6">
                <form wire:submit="saveStencil" class="space-y-6">
                    <!-- Basic Information Section -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-zinc-700">
                            Basic Information
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Register No <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="register_no" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                @error('register_no') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Customer <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="customer" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                @error('customer') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Category <span class="text-red-500">*</span></label>
                                <select wire:model="category" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Category</option>
                                    <option value="STENCIL">STENCIL</option>
                                    <option value="JIG">JIG</option>
                                    <option value="MACHINE">MACHINE</option>
                                </select>
                                @error('category') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Tooling Type <span class="text-red-500">*</span></label>
                                <select wire:model="tooling_type" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Tooling Type</option>
                                    <option value="METAL MASK">METAL MASK</option>
                                    <option value="JIG ASSY">JIG ASSY</option>
                                    <option value="SOLDERING JIG">SOLDERING JIG</option>
                                    <option value="COATING JIG">COATING JIG</option>
                                    <option value="ROUTER JIG">ROUTER JIG</option>
                                </select>
                                @error('tooling_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Location <span class="text-red-500">*</span></label>
                                <select wire:model="location" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Location</option>
                                    <option value="PROD.1">PROD.1</option>
                                    <option value="PROD.2">PROD.2</option>
                                </select>
                                @error('location') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Status <span class="text-red-500">*</span></label>
                                <select wire:model="status" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                                    <option value="">Select Status</option>
                                    <option value="In Use">In Use</option>
                                    <option value="Prepared">Prepared</option>
                                    <option value="Cleaning">Cleaning</option>
                                    <option value="Stand By">Stand By</option>
                                    <option value="Not in Use">Not in Use</option>
                                    <option value="Damaged">Damaged</option>
                                    <option value="Under Repair">Under Repair</option>
                                    <option value="Disposed">Disposed</option>
                                </select>
                                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Line Name</label>
                                <input type="text" wire:model="line_name" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Rack Number</label>
                                <input type="text" wire:model="rack_number" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Technical Details Section -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-zinc-700">
                            Technical Details
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Owned By (SEK Cust ID)</label>
                                <input type="text" wire:model="sek_cust_id" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Fabricator</label>
                                <input type="text" wire:model="fabricator" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Model</label>
                                <input type="text" wire:model="model" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Description</label>
                                <input type="text" wire:model="description" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Application</label>
                                <input type="text" wire:model="application" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Pin Quantity</label>
                                <input type="number" wire:model="pin_qty" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Jig Quantity</label>
                                <input type="number" wire:model="jig_qty" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Design By</label>
                                <input type="text" wire:model="design_by" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Results</label>
                                <input type="text" wire:model="results" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Amount Solder</label>
                                <input type="text" wire:model="amount_solder" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Rack</label>
                                <input type="text" wire:model="rack" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Bit Size</label>
                                <input type="text" wire:model="bit_size" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Dates Section -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 pb-2 border-b border-gray-200 dark:border-zinc-700">
                            Dates
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Received Date</label>
                                <input type="date" wire:model="received_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Registration Date</label>
                                <input type="date" wire:model="registration_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-1">Qualified Date</label>
                                <input type="datetime-local" wire:model="qualified_date" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                            </div>
                        </div>
                    </div>
                    
                    <!-- Remarks -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Remarks</label>
                        <textarea wire:model="remarks" rows="3" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700"></textarea>
                    </div>

                    <!-- Photos -->
                    <div>
                        <label class="block text-sm font-medium mb-1">Photos</label>
                        <input type="file" wire:model="photo" multiple accept="image/*" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-800 dark:border-zinc-700">
                        <p class="text-xs text-gray-500 mt-1">Max file size: 2MB per file</p>
                        @error('photo.*') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        
                        @if($existing_photos && count($existing_photos) > 0)
                            <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($existing_photos as $index => $photoPath)
                                    <div class="relative group">
                                        <img src="{{ Storage::url($photoPath) }}" class="w-full h-32 object-cover rounded-lg">
                                        <button type="button" wire:click="removePhoto({{ $index }})" class="absolute top-2 right-2 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-zinc-700">
                        <flux:button wire:navigate href="{{ route('mtc.stencil.index') }}" variant="ghost">
                            Cancel
                        </flux:button>
                        <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="saveStencil">
                                {{ $isEditMode ? 'Update Stencil' : 'Create Stencil' }}
                            </span>
                            <span wire:loading wire:target="saveStencil">
                                <svg class="inline w-4 h-4 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Saving...
                            </span>
                        </flux:button>
                    </div>
                </form>
            </flux:card>
        </div>
    </x-mtc.layout>

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
    </style>
</section>