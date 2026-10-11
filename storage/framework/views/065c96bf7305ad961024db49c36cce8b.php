<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'sidebar' => false,
]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter(([
    'sidebar' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>

<?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($sidebar): ?>
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/sidebar/brand.blade.php', $__blaze->compiledPath.'/3b72932a6ef0236ea390ac857ef8a0ff.php'); ?>
<?php if (isset($__slots3b72932a6ef0236ea390ac857ef8a0ff)) { $__slotsStack3b72932a6ef0236ea390ac857ef8a0ff[] = $__slots3b72932a6ef0236ea390ac857ef8a0ff; } ?>
<?php if (isset($__attrs3b72932a6ef0236ea390ac857ef8a0ff)) { $__attrsStack3b72932a6ef0236ea390ac857ef8a0ff[] = $__attrs3b72932a6ef0236ea390ac857ef8a0ff; } ?>
<?php $__attrs3b72932a6ef0236ea390ac857ef8a0ff = ['name' => 'SIIX-Portal','attributes' => $attributes]; ?>
<?php $__slots3b72932a6ef0236ea390ac857ef8a0ff = []; ?>
<?php $__blaze->pushData($__attrs3b72932a6ef0236ea390ac857ef8a0ff); ?>
<?php ob_start(); ?>
             <?php $__slots3b72932a6ef0236ea390ac857ef8a0ff['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php ob_start(); ?>
            <img src="/images/siix-portal.png" alt="SIIX-Portal" class="h-8 w-auto">
        <?php $__slots3b72932a6ef0236ea390ac857ef8a0ff['logo'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php $__blaze->pushSlots($__slots3b72932a6ef0236ea390ac857ef8a0ff); ?>
<?php _3b72932a6ef0236ea390ac857ef8a0ff($__blaze, $__attrs3b72932a6ef0236ea390ac857ef8a0ff, $__slots3b72932a6ef0236ea390ac857ef8a0ff, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStack3b72932a6ef0236ea390ac857ef8a0ff)) { $__slots3b72932a6ef0236ea390ac857ef8a0ff = array_pop($__slotsStack3b72932a6ef0236ea390ac857ef8a0ff); } ?>
<?php if (! empty($__attrsStack3b72932a6ef0236ea390ac857ef8a0ff)) { $__attrs3b72932a6ef0236ea390ac857ef8a0ff = array_pop($__attrsStack3b72932a6ef0236ea390ac857ef8a0ff); } ?>
<?php $__blaze->popData(); ?>
<?php else: ?>
    <?php $__blaze->ensureRequired('C:\laragon\www\siix-portal\vendor\livewire\flux\src/../stubs/resources/views/flux/brand.blade.php', $__blaze->compiledPath.'/acfbe159bdd981c8091e00996afc1491.php'); ?>
<?php if (isset($__slotsacfbe159bdd981c8091e00996afc1491)) { $__slotsStackacfbe159bdd981c8091e00996afc1491[] = $__slotsacfbe159bdd981c8091e00996afc1491; } ?>
<?php if (isset($__attrsacfbe159bdd981c8091e00996afc1491)) { $__attrsStackacfbe159bdd981c8091e00996afc1491[] = $__attrsacfbe159bdd981c8091e00996afc1491; } ?>
<?php $__attrsacfbe159bdd981c8091e00996afc1491 = ['name' => 'SIIX-Portal','attributes' => $attributes]; ?>
<?php $__slotsacfbe159bdd981c8091e00996afc1491 = []; ?>
<?php $__blaze->pushData($__attrsacfbe159bdd981c8091e00996afc1491); ?>
<?php ob_start(); ?>
             <?php $__slotsacfbe159bdd981c8091e00996afc1491['slot'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), []); ?>
<?php ob_start(); ?>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 40 42" class="size-5 fill-current text-white dark:text-black">
                <path 
                    fill="currentColor" 
                    fill-rule="evenodd" 
                    clip-rule="evenodd"
                    d="M17.2 5.633 8.6.855 0 5.633v26.51l16.2 9 16.2-9v-8.442l7.6-4.223V9.856l-8.6-4.777-8.6 4.777V18.3l-5.6 3.111V5.633ZM38 18.301l-5.6 3.11v-6.157l5.6-3.11V18.3Zm-1.06-7.856-5.54 3.078-5.54-3.079 5.54-3.078 5.54 3.079ZM24.8 18.3v-6.157l5.6 3.111v6.158L24.8 18.3Zm-1 1.732 5.54 3.078-13.14 7.302-5.54-3.078 13.14-7.3v-.002Zm-16.2 7.89 7.6 4.222V38.3L2 30.966V7.92l5.6 3.111v16.892ZM8.6 9.3 3.06 6.222 8.6 3.143l5.54 3.08L8.6 9.3Zm21.8 15.51-13.2 7.334V38.3l13.2-7.334v-6.156ZM9.6 11.034l5.6-3.11v14.6l-5.6 3.11v-14.6Z"
                />
            </svg>
        <?php $__slotsacfbe159bdd981c8091e00996afc1491['logo'] = new \Illuminate\View\ComponentSlot(trim(ob_get_clean()), ['class' => 'flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground']); ?>
<?php $__blaze->pushSlots($__slotsacfbe159bdd981c8091e00996afc1491); ?>
<?php _acfbe159bdd981c8091e00996afc1491($__blaze, $__attrsacfbe159bdd981c8091e00996afc1491, $__slotsacfbe159bdd981c8091e00996afc1491, ['attributes'], [], $__this ?? (isset($this) ? $this : null)); ?>
<?php if (! empty($__slotsStackacfbe159bdd981c8091e00996afc1491)) { $__slotsacfbe159bdd981c8091e00996afc1491 = array_pop($__slotsStackacfbe159bdd981c8091e00996afc1491); } ?>
<?php if (! empty($__attrsStackacfbe159bdd981c8091e00996afc1491)) { $__attrsacfbe159bdd981c8091e00996afc1491 = array_pop($__attrsStackacfbe159bdd981c8091e00996afc1491); } ?>
<?php $__blaze->popData(); ?>
<?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?><?php /**PATH C:\laragon\www\siix-portal\resources\views\components\app-logo.blade.php ENDPATH**/ ?>