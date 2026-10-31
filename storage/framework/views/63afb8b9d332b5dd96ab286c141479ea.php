


<div
        x-init="
        window.Mingle.Elements['<?php echo e($this->component()); ?>']
            .boot(
                '<?php echo e($this->mingleId); ?>',
                '<?php echo e($_instance->getId()); ?>',
            )
    "
>
    <div id="<?php echo e($this->mingleId); ?>-container" wire:ignore x-ignore>
        <div
                id="<?php echo e($this->mingleId); ?>"
                data-mingle-data="<?php echo e(json_encode($this->mingleData())); ?>"
        ></div>
    </div>
</div>
<?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/vendor/ijpatricio/mingle/resources/views/mingle.blade.php ENDPATH**/ ?>