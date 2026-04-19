<?php # [BlazeFolded]:{flux::icon.star}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/star.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon.star}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/star.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon.star}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/star.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::icon.arrow-right}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/arrow-right.blade.php}:{1774988736} ?>

<div>
    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification): ?>
        <!-- Desktop Version - Full Text -->
        <div class="hidden md:block">
            <div class="inline-flex items-center px-3 py-1 text-sm font-medium rounded-full whitespace-nowrap <?php echo e($notification->getColorClasses()); ?> border border-black/10 dark:border-white/20">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->icon): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(str_contains($notification->icon, '<svg')): ?>
                        <?php echo $notification->icon; ?>

                    <?php else: ?>
                        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['name' => $notification->icon, 'class' => 'w-4 h-4 mr-1.5']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/0f2a77fb6d4d542c1b97a0147f9e29a8.php'); ?>
<?php $__blaze->pushData(['name' => $notification->icon,'class' => 'w-4 h-4 mr-1.5']); ?>
<?php _0f2a77fb6d4d542c1b97a0147f9e29a8($__blaze, ['name' => $notification->icon,'class' => 'w-4 h-4 mr-1.5'], [], ['name'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-4 h-4 mr-1.5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                
                <?php echo e($notification->message); ?>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->button_text && $notification->button_url): ?>
                    <a href="<?php echo e($notification->button_url); ?>" 
                       class="ml-2 px-2 py-0.5 text-xs font-medium rounded-full transition-colors text-black hover:opacity-80 border border-black/20 dark:border-white/20"
                       style="background-color: rgba(255,255,255,0.6);">
                        <?php echo e($notification->button_text); ?>

                    </a>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>

        <!-- Mobile Version - Icon with Dropdown -->
        <div x-data="{ open: <?php if ((object) ('dropdownOpen') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('dropdownOpen'->value()); ?>')<?php echo e('dropdownOpen'->hasModifier('live') ? '.live' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($__livewire->getId()); ?>').entangle('<?php echo e('dropdownOpen'); ?>')<?php endif; ?> }" class="relative md:hidden">
            <button 
                @click="open = !open"
                @click.outside="open = false"
                class="inline-flex items-center justify-center w-8 h-8 rounded-full transition-colors <?php echo e($notification->getColorClasses()); ?> hover:opacity-80 border border-black/10 dark:border-white/20"
            >
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->icon): ?>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(str_contains($notification->icon, '<svg')): ?>
                        <?php echo str_replace('class="', 'class="w-5 h-5 ', $notification->icon); ?>

                    <?php else: ?>
                        <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['name' => $notification->icon, 'class' => 'w-5 h-5']); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/0f2a77fb6d4d542c1b97a0147f9e29a8.php'); ?>
<?php $__blaze->pushData(['name' => $notification->icon,'class' => 'w-5 h-5']); ?>
<?php _0f2a77fb6d4d542c1b97a0147f9e29a8($__blaze, ['name' => $notification->icon,'class' => 'w-5 h-5'], [], ['name'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-5 h-5" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->icon): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(str_contains($notification->icon, '<svg')): ?>
                                    <?php echo str_replace('class="', 'class="w-5 h-5 ' . $notification->getIconColorClasses() . ' ', $notification->icon); ?>

                                <?php else: ?>
                                    <?php $blaze_memoized_key = \Livewire\Blaze\Memoizer\Memo::key("flux::icon", ['name' => $notification->icon, 'class' => 'w-5 h-5 '.e($notification->getIconColorClasses())]); ?><?php if ($blaze_memoized_key !== null && \Livewire\Blaze\Memoizer\Memo::has($blaze_memoized_key)) : ?><?php echo \Livewire\Blaze\Memoizer\Memo::get($blaze_memoized_key); ?><?php else : ?><?php ob_start(); ?><?php $__blaze->ensureRequired('D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/icon/index.blade.php', $__blaze->compiledPath.'/0f2a77fb6d4d542c1b97a0147f9e29a8.php'); ?>
<?php $__blaze->pushData(['name' => $notification->icon,'class' => 'w-5 h-5 '.e($notification->getIconColorClasses())]); ?>
<?php _0f2a77fb6d4d542c1b97a0147f9e29a8($__blaze, ['name' => $notification->icon,'class' => 'w-5 h-5 '.e($notification->getIconColorClasses())], [], ['name'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php $__blaze->popData(); ?><?php $blaze_memoized_html = ob_get_clean(); ?><?php if ($blaze_memoized_key !== null) { \Livewire\Blaze\Memoizer\Memo::put($blaze_memoized_key, $blaze_memoized_html); } ?><?php echo $blaze_memoized_html; ?><?php endif; ?>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-5 h-5 <?php echo e($notification->getIconColorClasses()); ?>" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                <?php echo e($notification->message); ?>

                            </p>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($notification->button_text && $notification->button_url): ?>
                                <div class="mt-3">
                                    <a href="<?php echo e($notification->button_url); ?>" 
                                       class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors text-black dark:text-black hover:opacity-80 border border-black/20 dark:border-white/20"
                                       style="background-color: rgba(255,255,255,0.7);">
                                        <?php echo e($notification->button_text); ?>

                                        <?php ob_start(); ?><svg class="shrink-0 [:where(&amp;)]:size-6 w-3 h-3 ml-1" data-flux-icon xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
  <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"/>
</svg>

        <?php echo ltrim(ob_get_clean()); ?>
                                    </a>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div><?php /**PATH D:\laragon\www\siix-portal-new\resources\views/livewire/settings/header-badge.blade.php ENDPATH**/ ?>