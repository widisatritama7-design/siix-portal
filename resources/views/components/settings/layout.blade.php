<div class="flex flex-col">
    <!-- Header -->
    <div class="mb-6">
        <flux:heading>{{ $heading ?? '' }}</flux:heading>
        <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>
    </div>

    <!-- Main Content -->
    <div class="mt-2 w-full">
        {{ $slot }}
    </div>
</div>