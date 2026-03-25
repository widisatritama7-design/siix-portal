{{-- resources/views/livewire/header-badge.blade.php --}}
<div>
    @if($notification)
        <!-- Desktop Version - Full Text -->
        <div class="hidden md:block">
            <div class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full whitespace-nowrap {{ $notification->getColorClasses() }} border border-black/10 dark:border-white/20">
                @if($notification->icon)
                    @if(str_contains($notification->icon, '<svg'))
                        {!! $notification->icon !!}
                    @else
                        <flux:icon :name="$notification->icon" class="w-4 h-4 mr-1.5" />
                    @endif
                @else
                    <flux:icon.star class="w-4 h-4 mr-1.5" />
                @endif
                
                {{ $notification->message }}
                
                @if($notification->button_text && $notification->button_url)
                    <a href="{{ $notification->button_url }}" 
                       class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full transition-colors text-black hover:opacity-80 border border-black/20 dark:border-white/20"
                       style="background-color: rgba(255,255,255,0.6);">
                        {{ $notification->button_text }}
                    </a>
                @endif
            </div>
        </div>

        <!-- Mobile Version - Icon with Dropdown -->
        <div x-data="{ open: @entangle('dropdownOpen') }" class="relative md:hidden">
            <button 
                @click="open = !open"
                @click.outside="open = false"
                class="inline-flex items-center justify-center w-8 h-8 rounded-full transition-colors {{ $notification->getColorClasses() }} hover:opacity-80 border border-black/10 dark:border-white/20"
            >
                @if($notification->icon)
                    @if(str_contains($notification->icon, '<svg'))
                        {!! str_replace('class="', 'class="w-5 h-5 ', $notification->icon) !!}
                    @else
                        <flux:icon :name="$notification->icon" class="w-5 h-5" />
                    @endif
                @else
                    <flux:icon.star class="w-5 h-5" />
                @endif
            </button>
            
            <div 
                x-show="open"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-1"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-1"
                class="absolute left-0 top-full mt-2 w-80 bg-white dark:bg-zinc-800 rounded-lg shadow-lg border border-zinc-200 dark:border-zinc-700 z-50"
            >
                <div class="p-4">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            @if($notification->icon)
                                @if(str_contains($notification->icon, '<svg'))
                                    {!! str_replace('class="', 'class="w-5 h-5 ' . $notification->getIconColorClasses() . ' ', $notification->icon) !!}
                                @else
                                    <flux:icon :name="$notification->icon" class="w-5 h-5 {{ $notification->getIconColorClasses() }}" />
                                @endif
                            @else
                                <flux:icon.star class="w-5 h-5 {{ $notification->getIconColorClasses() }}" />
                            @endif
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                {{ $notification->message }}
                            </p>
                            @if($notification->button_text && $notification->button_url)
                                <div class="mt-3">
                                    <a href="{{ $notification->button_url }}" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors text-black dark:text-black hover:opacity-80 border border-black/20 dark:border-white/20"
                                       style="background-color: rgba(255,255,255,0.7);">
                                        {{ $notification->button_text }}
                                        <flux:icon.arrow-right class="w-3 h-3 ml-1" />
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>