<section class="w-full">
    @include('partials.esd-heading')

    <flux:heading class="sr-only">
        {{ __('Electrostatic Discharge') }}
    </flux:heading>

    <x-esd.layout 
        :heading="__('Profile')" 
        :subheading="__('Update your name and email address')"
        >

    </x-esd.layout>
</section>