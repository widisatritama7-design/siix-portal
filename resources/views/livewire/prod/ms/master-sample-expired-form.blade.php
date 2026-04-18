<div class="p-6 max-w-2xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $isEdit ? 'Edit' : 'Add' }} Expired History</h1>
        <a href="{{ route('prod.ms.master-sample.expired', $masterSample->id) }}" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition">Cancel</a>
    </div>
    
    <div class="bg-white dark:bg-zinc-800 rounded-lg shadow p-6">
        <div class="mb-4 pb-4 border-b">
            <h3 class="font-semibold text-lg">{{ $masterSample->model_name }}</h3>
            <p class="text-sm text-gray-500">Customer: {{ $masterSample->customer }} | Name/MC: {{ $masterSample->name_or_mc }}</p>
        </div>
        
        <form wire:submit="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Updated Date <span class="text-red-500">*</span></label>
                <input type="date" wire:model="updatedDate" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                @error('updatedDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Expired Date <span class="text-red-500">*</span></label>
                <input type="date" wire:model="expiredDate" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                @error('expiredDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Alarm Date <span class="text-red-500">*</span></label>
                <input type="date" wire:model="alarmDate" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                @error('alarmDate') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Checked By</label>
                <select wire:model="checkedBy" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                    <option value="">Select Checker</option>
                    @foreach($checkerOptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Knowledge By</label>
                <select wire:model="knowledgeBy" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                    <option value="">Select Knowledge</option>
                    @foreach($knowledgeOptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium mb-1">Approved By</label>
                <select wire:model="approvedBy" class="w-full px-3 py-2 border rounded-lg dark:bg-zinc-700 dark:border-zinc-600">
                    <option value="">Select Approver</option>
                    @foreach($approverOptions as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex justify-end gap-2 pt-4 border-t">
                <a href="{{ route('prod.ms.master-sample.expired', $masterSample->id) }}" class="px-4 py-2 border rounded-lg hover:bg-gray-100 transition">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Save</button>
            </div>
        </form>
    </div>
</div>