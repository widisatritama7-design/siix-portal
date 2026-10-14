<div x-data="{ show: false, message: '', type: 'success' }"
    x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
    x-show="show" x-transition
    class="fixed bottom-4 right-4 z-50"
    :class="{ 'bg-green-500': type === 'success', 'bg-red-500': type === 'error', 'bg-yellow-500': type === 'warning' }"
    style="display: none;">
    <div class="text-white px-6 py-3 rounded-lg shadow-lg"><span x-text="message"></span></div>
</div><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/livewire/qaqc/scan-xray/partials/notify.blade.php ENDPATH**/ ?>