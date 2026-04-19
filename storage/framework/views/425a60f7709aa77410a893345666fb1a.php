<?php # [BlazeFolded]:{flux::heading}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::badge}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/badge/index.blade.php}:{1774988736} ?>
<?php # [BlazeFolded]:{flux::separator}:{D:\laragon\www\siix-portal-new\vendor\livewire\flux\src/../stubs/resources/views/flux/separator.blade.php}:{1774988736} ?>
<div class="relative mb-4 w-full">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 text-zinc-800 dark:text-zinc-200 -mt-0.5">
                <path d="m20.798 11.012-3.188 3.416L9.462 6.28l4.24-4.542a.75.75 0 0 1 1.272.71L12.982 9.75h7.268a.75.75 0 0 1 .548 1.262ZM3.202 12.988 6.39 9.572l8.148 8.148-4.24 4.542a.75.75 0 0 1-1.272-.71l1.992-7.302H3.75a.75.75 0 0 1-.548-1.262ZM3.53 2.47a.75.75 0 0 0-1.06 1.06l18 18a.75.75 0 1 0 1.06-1.06l-18-18Z" />
            </svg>
            <?php ob_start(); ?><h1 class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-2xl [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" style="margin-bottom: 4px;" data-flux-heading><?php ob_start(); ?><?php echo e(__('ESD Monitoring')); ?><?php echo trim(ob_get_clean()); ?></h1>

        <?php echo ltrim(ob_get_clean()); ?>
        </div>
        <?php ob_start(); ?><div data-flux-badge="data-flux-badge" class="inline-flex items-center font-medium whitespace-nowrap  [print-color-adjust:exact] text-sm py-1.5 **:data-flux-badge-icon:me-2 rounded-md px-2 text-yellow-800 [&amp;_button]:text-yellow-800! dark:text-yellow-200 dark:[&amp;_button]:text-yellow-200! bg-yellow-400/25 dark:bg-yellow-400/40 [&amp;:is(button)]:hover:bg-yellow-400/40 dark:[button]:hover:bg-yellow-400/50">
        <?php ob_start(); ?>
            ELECTROSTATIC DISCHARGE CONTROL
        <?php echo trim(ob_get_clean()); ?>

    </div>
<?php echo ltrim(ob_get_clean()); ?>
    </div>
    <?php ob_start(); ?><div data-orientation="horizontal" role="none" class="border-0 [print-color-adjust:exact] bg-zinc-800/5 dark:bg-white/10 h-px w-full mt-3" data-flux-separator></div>
<?php echo ltrim(ob_get_clean()); ?>
</div><?php /**PATH D:\laragon\www\siix-portal-new\resources\views\partials\esd-heading.blade.php ENDPATH**/ ?>