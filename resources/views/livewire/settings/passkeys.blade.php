<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">
        {{ __('Passkey settings') }}
    </flux:heading>

    <x-settings.layout
        :heading="__('Passkey')"
        :subheading="__('Manage passkeys for passwordless login')"
    >
        <div class="space-y-6">

            {{-- Flash Message --}}
            @if (session('status'))
                <div class="p-3 rounded-lg bg-green-100 text-green-700 text-sm text-center dark:bg-green-900/30 dark:text-green-400">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Informasi --}}
            <flux:card class="space-y-3">
                <div class="flex items-start gap-3">
                    <flux:icon
                        name="shield-check"
                        class="mt-1 size-6 text-green-600"
                    />

                    <div class="space-y-1">
                        <flux:heading size="lg">
                            {{ __('Secure Login') }}
                        </flux:heading>

                        <flux:text>
                            {{ __('Gunakan passkey untuk login tanpa perlu memasukkan NIK dan password. Autentikasi dapat menggunakan sidik jari, pengenalan wajah, atau PIN perangkat.') }}
                        </flux:text>
                    </div>
                </div>
            </flux:card>

            {{-- Tambah Passkey --}}
            <flux:card class="space-y-5">
                <div>
                    <flux:heading size="lg">
                        {{ __('Register New Passkey') }}
                    </flux:heading>

                    <flux:text class="mt-1">
                        {{ __('Daftarkan perangkat baru untuk akun Anda.') }}
                    </flux:text>
                </div>

                <flux:input
                    id="passkey-name"
                    :label="__('Passkey Name')"
                    placeholder="Contoh: Laptop Kantor"
                    value="Perangkat Saya"
                />

                <div
                    x-data="{
                        busy: false,
                        message: '',
                        isError: false,
                        async register() {
                            if (!window.registerPasskey) {
                                this.message = 'Passkey module belum siap. Coba refresh halaman.';
                                this.isError = true;
                                return;
                            }
                            this.busy = true;
                            this.message = '';
                            try {
                                const name = document.getElementById('passkey-name').value.trim() || 'Perangkat Saya';
                                await window.registerPasskey(name);
                                this.message = 'Passkey berhasil didaftarkan.';
                                this.isError = false;
                                setTimeout(() => window.location.reload(), 800);
                            } catch (e) {
                                console.error(e);
                                this.message = e?.message || 'Pendaftaran passkey gagal atau dibatalkan.';
                                this.isError = true;
                            } finally {
                                this.busy = false;
                            }
                        }
                    }"
                >
                    <flux:button
                        type="button"
                        variant="primary"
                        icon="finger-print"
                        x-on:click="register()"
                        x-bind:disabled="busy"
                    >
                        {{ __('Register Passkey') }}
                    </flux:button>

                    <flux:text
                        x-show="message"
                        x-text="message"
                        x-bind:class="isError ? 'text-red-600 mt-3' : 'text-green-600 mt-3'"
                    />
                </div>
            </flux:card>

            {{-- Daftar Passkey --}}
            <flux:card class="space-y-5">
                <div>
                    <flux:heading size="lg">
                        {{ __('Registered Passkeys') }}
                    </flux:heading>

                    <flux:text class="mt-1">
                        {{ __('Daftar passkey yang terhubung dengan akun Anda.') }}
                    </flux:text>
                </div>

                @php
                    $passkeys = auth()->user()->passkeys()->latest()->get();
                @endphp

                @forelse ($passkeys as $passkey)
                    <div
                        wire:key="passkey-{{ $passkey->id }}"
                        class="flex flex-col gap-4 border-t border-zinc-200 pt-4 first:border-t-0 first:pt-0 sm:flex-row sm:items-center sm:justify-between dark:border-zinc-700"
                    >
                        <div class="flex items-start gap-3">
                            <div class="rounded-lg bg-zinc-100 p-3 dark:bg-zinc-800">
                                <flux:icon
                                    name="finger-print"
                                    class="size-5"
                                />
                            </div>

                            <div class="space-y-1">
                                <flux:heading>
                                    {{ $passkey->name ?: 'Passkey' }}
                                </flux:heading>

                                <flux:text class="text-xs">
                                    {{ __('Registered') }}:
                                    {{ $passkey->created_at?->format('d M Y H:i') ?? '-' }}
                                </flux:text>

                                @if ($passkey->last_used_at)
                                    <flux:text class="text-xs">
                                        {{ __('Last used') }}:
                                        {{ $passkey->last_used_at->format('d M Y H:i') }}
                                    </flux:text>
                                @endif
                            </div>
                        </div>

                        {{-- Tombol hapus memicu modal --}}
                        <flux:button
                            type="button"
                            variant="danger"
                            size="sm"
                            wire:click="confirmDelete({{ $passkey->id }})"
                        >
                            {{ __('Delete') }}
                        </flux:button>
                    </div>
                @empty
                    <div class="rounded-lg border border-dashed border-zinc-300 p-6 text-center dark:border-zinc-700">
                        <flux:icon
                            name="finger-print"
                            class="mx-auto size-10 text-zinc-400"
                        />

                        <flux:heading class="mt-3">
                            {{ __('No passkeys registered') }}
                        </flux:heading>

                        <flux:text class="mt-1">
                            {{ __('Daftarkan passkey pertama Anda melalui tombol di atas.') }}
                        </flux:text>
                    </div>
                @endforelse
            </flux:card>

        </div>
    </x-settings.layout>

    {{-- Modal Konfirmasi Hapus (Menggunakan Flux UI) --}}
    <flux:modal wire:model="showDeleteModal" class="max-w-md">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">
                    {{ __('Delete Passkey') }}
                </flux:heading>
                <flux:text class="mt-2">
                    {{ __('Apakah Anda yakin ingin menghapus passkey ini? Anda tidak akan bisa menggunakan passkey ini untuk login lagi.') }}
                </flux:text>
            </div>

            <div class="flex gap-2">
                <flux:spacer />

                <flux:button 
                    type="button" 
                    variant="ghost" 
                    wire:click="$set('showDeleteModal', false)"
                >
                    {{ __('Cancel') }}
                </flux:button>

                <flux:button 
                    type="button" 
                    variant="danger" 
                    wire:click="deletePasskey"
                >
                    {{ __('Delete Passkey') }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</section>