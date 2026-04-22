<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Profile settings') }}</flux:heading>

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your name and email address')">
        <flux:card class="!p-0 space-y-0 overflow-hidden shadow-lg hover:shadow-xl transition-shadow duration-300">
            <!-- Profile Form -->
            <form wire:submit="updateProfileInformation" class="p-6 space-y-6">
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                    @if ($this->hasUnverifiedEmail)
                        <div>
                            <flux:text class="mt-4">
                                {{ __('Your email address is unverified.') }}

                                <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                    {{ __('Click here to re-send the verification email.') }}
                                </flux:link>
                            </flux:text>

                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="mt-2 font-medium !dark:text-green-400 !text-green-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </flux:text>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>
        </flux:card>
    </x-settings.layout>
</section>