@props([
    'label' => 'Phase',
    'note'  => '',
])

<div class="relative rounded-2xl overflow-hidden shadow-lg ring-1 ring-zinc-200 dark:ring-zinc-700 bg-zinc-50 dark:bg-zinc-900/50 border-2 border-dashed border-zinc-300 dark:border-zinc-700">
    <div class="p-8 text-center">
        <div class="w-12 h-12 rounded-full bg-zinc-200 dark:bg-zinc-800 flex items-center justify-center mx-auto mb-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
            </svg>
        </div>
        <h3 class="text-base font-bold text-zinc-700 dark:text-zinc-300 mb-1">{{ $label }}</h3>
        <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ $note }}</p>
    </div>
</div>