<?php # [BlazeVersion]:{v3} ?>
<?php # [BlazeFolded]:{flux::heading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/heading.blade.php}:{1792543558} ?>
<?php # [BlazeFolded]:{flux::subheading}:{C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/subheading.blade.php}:{1792543558} ?>
<div class="flex flex-col">
    <!-- Header -->
    <div class="mb-6">
        <?php ob_start(); ?><div class="font-medium [:where(&amp;)]:text-zinc-800 [:where(&amp;)]:dark:text-white text-sm [&amp;:has(+[data-flux-subheading])]:mb-2 [[data-flux-subheading]+&amp;]:mt-2" data-flux-heading><?php ob_start(); ?><?php echo e($heading ?? ''); ?><?php echo trim(ob_get_clean()); ?></div>
<?php echo ltrim(ob_get_clean()); ?>
        <?php ob_start(); ?><div class="text-sm [:where(&amp;)]:text-zinc-500 [:where(&amp;)]:dark:text-white/70" data-flux-subheading>
    <?php ob_start(); ?><?php echo e($subheading ?? ''); ?><?php echo trim(ob_get_clean()); ?>

</div>
<?php echo ltrim(ob_get_clean()); ?>
    </div>

    <!-- Main Content -->
    <div class="mt-2 w-full">
        <?php echo e($slot); ?>

    </div>
</div><?php /**PATH C:\laragon\www\siix-portal\resources\views/components/settings/layout.blade.php ENDPATH**/ ?>