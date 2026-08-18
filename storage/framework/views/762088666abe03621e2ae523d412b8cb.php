<?php $__env->startSection('title', 'ESD Locker - Information'); ?>

<?php $__env->startSection('content'); ?>
<div x-data="lockerApp()" x-init="init()" class="space-y-4">
    <!-- Breadcrumbs -->
    <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
        <a href="<?php echo e(route('dashboard')); ?>" class="hover:text-blue-600 dark:hover:text-blue-400">Dashboard</a>
        <span>/</span>
        <span class="font-semibold text-blue-600 dark:text-blue-400">ESD</span>
        <span>/</span>
        <span class="font-semibold text-blue-600 dark:text-blue-400">Locker Info</span>
    </nav>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">
                ESD Locker System
            </h1>
            <p class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                Lihat status loker dan pilih layanan
            </p>
        </div>
        <button @click="refreshLockers()" class="flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition text-sm font-medium">
            <i class="fas fa-sync-alt" :class="{'animate-spin': loading}"></i>
            Refresh
        </button>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col lg:flex-row gap-4 mt-2">
        <!-- LEFT COLUMN: Locker Grid -->
        <div class="w-full lg:w-[70%]">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4">
                <!-- Legend -->
                <div class="mb-4 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                    <div class="flex flex-wrap items-center justify-center gap-4 text-xs">
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-green-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">Available</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-yellow-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">Open</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-blue-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">In Progress</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-red-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">NG</span>
                        </div>
                        <div class="flex items-center gap-1.5">
                            <span class="inline-block w-3 h-3 rounded-full bg-gray-500"></span>
                            <span class="text-zinc-600 dark:text-zinc-400">Finished</span>
                        </div>
                    </div>
                </div>

                <!-- Locker Grid -->
                <div class="grid grid-cols-4 sm:grid-cols-5 md:grid-cols-6 lg:grid-cols-7 gap-2 max-h-[450px] overflow-y-auto pr-2 locker-grid">
                    <template x-for="locker in lockers" :key="locker.id">
                        <div class="rounded-lg text-white p-3 text-center font-bold shadow hover:shadow-lg transition-all duration-200 cursor-default"
                             :class="getStatusClass(locker.status)">
                            <div class="text-sm" x-text="locker.code"></div>
                        </div>
                    </template>
                    <div x-show="lockers.length === 0" class="col-span-full text-center py-8 text-zinc-500 dark:text-zinc-400">
                        No lockers available
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Actions -->
        <div class="w-full lg:w-[30%]">
            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-lg border border-zinc-200 dark:border-zinc-800 p-4">
                <div class="space-y-4">
                    <!-- Button Store -->
                    <button @click="openModal('store')" 
                            class="w-full bg-green-500 hover:bg-green-600 text-white rounded-lg p-6 shadow-lg transition duration-200 flex flex-col items-center justify-center">
                        <i class="fas fa-arrow-down text-3xl mb-2"></i>
                        <span class="text-xl font-bold">Store</span>
                        <span class="text-sm opacity-75">Menyimpan seragam</span>
                    </button>

                    <!-- Button Take -->
                    <button @click="openModal('take')" 
                            class="w-full bg-purple-500 hover:bg-purple-600 text-white rounded-lg p-6 shadow-lg transition duration-200 flex flex-col items-center justify-center">
                        <i class="fas fa-arrow-up text-3xl mb-2"></i>
                        <span class="text-xl font-bold">Take (Pick Up)</span>
                        <span class="text-sm opacity-75">Mengambil seragam</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL STORE -->
    <!-- ============================================================ -->
    <div x-show="modals.store" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 modal-backdrop" @click="closeModal('store')"></div>
        
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto relative z-10 border border-zinc-200 dark:border-zinc-700 modal-animate">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                            <i class="fas fa-arrow-down text-green-600 dark:text-green-400"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Store Uniform</h2>
                    </div>
                    <button @click="closeModal('store')" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Step 1: Input NIK -->
                <div x-show="storeStep === 1" class="space-y-6">
                    <div class="text-center">
                        <p class="text-gray-600 dark:text-gray-400">Enter your NIK to start storing your uniform</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">NIK</label>
                        <input type="text" 
                               x-model="storeNik"
                               class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent dark:bg-zinc-800 dark:text-white text-center text-2xl font-mono tracking-wider transition"
                               placeholder="Enter your NIK">
                        <span x-show="storeError" class="text-red-500 text-sm mt-1 block" x-text="storeError"></span>
                    </div>

                    <!-- Numpad -->
                    <div class="text-center">
                        <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-2">Or use numpad below</p>
                    </div>
                    <div class="grid grid-cols-3 gap-2 max-w-xs mx-auto">
                        <template x-for="key in ['1','2','3','4','5','6','7','8','9','clear','0','backspace']">
                            <button type="button"
                                    @click="handleNumpad(key, 'store')"
                                    class="numpad-btn"
                                    :class="{
                                        'bg-red-500 hover:bg-red-600 text-white': key === 'clear',
                                        'bg-yellow-500 hover:bg-yellow-600 text-white': key === 'backspace',
                                        'bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white': !['clear','backspace'].includes(key)
                                    }">
                                <template x-if="key === 'clear'">
                                    <i class="fas fa-times text-lg"></i>
                                </template>
                                <template x-if="key === 'backspace'">
                                    <i class="fas fa-delete-left text-lg"></i>
                                </template>
                                <template x-if="!['clear','backspace'].includes(key)">
                                    <span x-text="key"></span>
                                </template>
                            </button>
                        </template>
                    </div>

                    <button @click="checkStoreNik()" 
                            :disabled="storeLoading"
                            class="w-full bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20">
                        <span x-show="!storeLoading">Check NIK</span>
                        <span x-show="storeLoading"><i class="fas fa-spinner animate-spin mr-2"></i>Checking...</span>
                    </button>
                </div>

                <!-- Step 2: Confirm Employee -->
                <div x-show="storeStep === 2" class="space-y-6">
                    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-5">
                        <h3 class="font-semibold text-green-800 dark:text-green-300 mb-3 flex items-center gap-2">
                            <i class="fas fa-file-alt"></i>
                            Confirm Employee Data
                        </h3>
                        <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                            <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                <span class="font-medium">NIK</span>
                                <span x-text="storeEmployee.nik"></span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                <span class="font-medium">Name</span>
                                <span x-text="storeEmployee.name"></span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="font-medium">Department</span>
                                <span x-text="storeEmployee.department"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button @click="storeUniform()" 
                                :disabled="storeLoading"
                                class="flex-1 bg-blue-600 hover:bg-blue-700 disabled:opacity-50 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                            <span x-show="!storeLoading">Confirm Store</span>
                            <span x-show="storeLoading"><i class="fas fa-spinner animate-spin mr-2"></i>Processing...</span>
                        </button>
                        <button @click="resetStore()" 
                                class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                            Cancel
                        </button>
                    </div>
                </div>

                <!-- Step 3: Success -->
                <div x-show="storeStep === 3" class="text-center py-4">
                    <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                        <i class="fas fa-check text-4xl text-green-600 dark:text-green-400"></i>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Locker Opened!</h3>
                    <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                        Locker <span class="font-bold text-blue-600 dark:text-blue-400" x-text="storeLockerCode"></span> is now open
                    </p>
                    
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-4">
                        <div class="flex items-center justify-center gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                            <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                            <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                        </div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">Access code has been sent to your WhatsApp</p>
                    </div>

                    <div class="bg-zinc-50 dark:bg-zinc-800/50 rounded-xl p-5 mb-6 border border-zinc-200 dark:border-zinc-700">
                        <p class="text-sm text-zinc-500 dark:text-zinc-400">Your Access Code</p>
                        <p class="text-3xl font-mono font-bold text-zinc-800 dark:text-white tracking-wider" x-text="storeAccessCode"></p>
                        <p class="text-xs text-zinc-400 dark:text-zinc-500 mt-1">Valid for 24 hours</p>
                    </div>

                    <button @click="resetStore()" 
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- MODAL TAKE -->
    <!-- ============================================================ -->
    <div x-show="modals.take" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="fixed inset-0 modal-backdrop" @click="closeModal('take')"></div>
        
        <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl w-full max-w-2xl max-h-[90vh] overflow-y-auto relative z-10 border border-zinc-200 dark:border-zinc-700 modal-animate">
            <div class="p-6">
                <!-- Header -->
                <div class="flex justify-between items-center mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <i class="fas fa-arrow-up text-purple-600 dark:text-purple-400"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-zinc-800 dark:text-white">Take Uniform</h2>
                    </div>
                    <button @click="closeModal('take')" class="text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>

                <!-- Step 1: Input Access Code -->
                <div x-show="takeStep === 1" class="space-y-4">
                    <div class="text-center">
                        <p class="text-gray-600 dark:text-gray-400">Enter the access code sent via WhatsApp</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Access Code</label>
                        <input type="text" 
                               x-model="takeAccessCode"
                               class="w-full px-4 py-3 border border-zinc-300 dark:border-zinc-700 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent text-center text-2xl font-mono uppercase dark:bg-zinc-800 dark:text-white transition"
                               placeholder="e.g. ABCD1234EF">
                        <span x-show="takeError" class="text-red-500 text-sm mt-1 block" x-text="takeError"></span>
                    </div>

                    <!-- Numpad for Access Code -->
                    <div class="text-center">
                        <p class="text-xs text-zinc-400 dark:text-zinc-500 mb-2">Or use numpad below</p>
                    </div>
                    
                    <!-- Row 1: A-Z -->
                    <div class="grid grid-cols-9 gap-1.5 max-w-full">
                        <template x-for="letter in 'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('')">
                            <button type="button"
                                    @click="takeAccessCode = (takeAccessCode || '') + letter"
                                    class="numpad-btn bg-gray-300 dark:bg-gray-600 hover:bg-gray-400 dark:hover:bg-gray-500 text-gray-800 dark:text-white py-2 rounded-lg font-bold text-sm transition">
                                <span x-text="letter"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Row 2: 0-9 -->
                    <div class="grid grid-cols-10 gap-1.5 max-w-full">
                        <template x-for="num in '0123456789'.split('')">
                            <button type="button"
                                    @click="takeAccessCode = (takeAccessCode || '') + num"
                                    class="numpad-btn bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white py-2 rounded-lg font-bold text-sm transition">
                                <span x-text="num"></span>
                            </button>
                        </template>
                    </div>

                    <!-- Row 3: Clear & Backspace -->
                    <div class="grid grid-cols-2 gap-1.5 max-w-full">
                        <button type="button"
                                @click="takeAccessCode = ''"
                                class="numpad-btn bg-red-500 hover:bg-red-600 text-white py-2.5 rounded-lg font-bold text-base transition flex items-center justify-center gap-2">
                            <i class="fas fa-times"></i>
                            Clear
                        </button>
                        <button type="button"
                                @click="takeAccessCode = takeAccessCode ? takeAccessCode.slice(0, -1) : ''"
                                class="numpad-btn bg-yellow-500 hover:bg-yellow-600 text-white py-2.5 rounded-lg font-bold text-base transition flex items-center justify-center gap-2">
                            <i class="fas fa-delete-left"></i>
                            Backspace
                        </button>
                    </div>

                    <button @click="checkTakeCode()" 
                            :disabled="takeLoading"
                            class="w-full bg-purple-600 hover:bg-purple-700 disabled:opacity-50 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-purple-600/20">
                        <span x-show="!takeLoading">Check Code</span>
                        <span x-show="takeLoading"><i class="fas fa-spinner animate-spin mr-2"></i>Checking...</span>
                    </button>
                </div>

                <!-- Step 2: Transaction Info -->
                <div x-show="takeStep === 2" class="space-y-6">
                    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-xl p-5">
                        <h3 class="font-semibold text-purple-800 dark:text-purple-300 mb-3 flex items-center gap-2">
                            <i class="fas fa-info-circle"></i>
                            Transaction Details
                        </h3>
                        <div class="space-y-2 text-zinc-700 dark:text-zinc-300">
                            <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                <span class="font-medium">NIK</span>
                                <span x-text="takeTransaction.employee?.nik"></span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                <span class="font-medium">Name</span>
                                <span x-text="takeTransaction.employee?.name"></span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                <span class="font-medium">Department</span>
                                <span x-text="takeTransaction.employee?.department"></span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-zinc-200 dark:border-zinc-700">
                                <span class="font-medium">Locker</span>
                                <span class="font-mono font-bold text-blue-600 dark:text-blue-400" x-text="takeTransaction.locker?.code"></span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="font-medium">Locker Status</span>
                                <span class="px-3 py-1 rounded-full text-xs font-medium" 
                                      :class="getStatusBadgeClass(takeTransaction.locker?.status)"
                                      x-text="formatStatus(takeTransaction.locker?.status)"></span>
                            </div>
                        </div>
                    </div>

                    <div class="flex gap-3">
                        <button @click="openTakeLocker()" 
                                :disabled="takeLoading"
                                class="flex-1 bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white py-3 px-4 rounded-lg transition duration-200 font-medium shadow-lg shadow-green-600/20">
                            <span x-show="!takeLoading">Open Locker</span>
                            <span x-show="takeLoading"><i class="fas fa-spinner animate-spin mr-2"></i>Processing...</span>
                        </button>
                        <button @click="resetTake()" 
                                class="px-6 bg-zinc-200 dark:bg-zinc-700 text-zinc-700 dark:text-zinc-300 py-3 rounded-lg hover:bg-zinc-300 dark:hover:bg-zinc-600 transition duration-200">
                            Cancel
                        </button>
                    </div>
                </div>

                <!-- Step 3: Success -->
                <div x-show="takeStep === 3" class="text-center py-4">
                    <div class="w-24 h-24 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-green-500/20">
                        <i class="fas fa-check text-4xl text-green-600 dark:text-green-400"></i>
                    </div>
                    
                    <h3 class="text-2xl font-bold text-green-600 dark:text-green-400 mb-2">Locker Opened!</h3>
                    <p class="text-lg text-zinc-700 dark:text-zinc-300 mb-4">
                        Locker <span class="font-bold text-blue-600 dark:text-blue-400" x-text="takeTransaction?.locker?.code"></span> is now open
                    </p>
                    
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 mb-6">
                        <div class="flex items-center justify-center gap-3 text-sm text-zinc-600 dark:text-zinc-400">
                            <i class="fas fa-clock text-yellow-600 dark:text-yellow-400"></i>
                            <span>Door will close automatically in <strong class="text-red-600 dark:text-red-400">15 seconds</strong></span>
                        </div>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-2 text-center">Please take your uniform</p>
                    </div>

                    <button @click="resetTake()" 
                            class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg transition duration-200 font-medium shadow-lg shadow-blue-600/20">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-4 right-4 z-50 hidden transition-all duration-300 transform">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3">
            <i id="toast-icon" class="fas fa-check-circle text-xl"></i>
            <span id="toast-message"></span>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
    function lockerApp() {
        return {
            // Data
            lockers: [],
            loading: false,
            
            // Store
            modals: { store: false, take: false },
            storeStep: 1,
            storeNik: '',
            storeEmployee: {},
            storeLockerCode: '',
            storeAccessCode: '',
            storeError: '',
            storeLoading: false,
            
            // Take
            takeStep: 1,
            takeAccessCode: '',
            takeTransaction: {},
            takeError: '',
            takeLoading: false,

            // Init
            init() {
                this.fetchLockers();
            },

            // Fetch Lockers
            async fetchLockers() {
                this.loading = true;
                try {
                    const response = await fetch('<?php echo e(route("api.esd.lockers")); ?>');
                    const data = await response.json();
                    this.lockers = data;
                } catch (error) {
                    console.error('Error fetching lockers:', error);
                    showToast('Failed to load lockers', 'error');
                }
                this.loading = false;
            },

            refreshLockers() {
                this.fetchLockers();
            },

            // Modal
            openModal(type) {
                this.modals[type] = true;
                if (type === 'store') {
                    this.storeStep = 1;
                    this.storeNik = '';
                    this.storeError = '';
                } else if (type === 'take') {
                    this.takeStep = 1;
                    this.takeAccessCode = '';
                    this.takeError = '';
                }
                document.body.style.overflow = 'hidden';
            },

            closeModal(type) {
                this.modals[type] = false;
                document.body.style.overflow = '';
                if (type === 'store') this.resetStore();
                if (type === 'take') this.resetTake();
            },

            // Numpad
            handleNumpad(key, type) {
                if (type === 'store') {
                    if (key === 'clear') {
                        this.storeNik = '';
                    } else if (key === 'backspace') {
                        this.storeNik = this.storeNik.slice(0, -1);
                    } else {
                        this.storeNik = (this.storeNik || '') + key;
                    }
                }
            },

            // Store Functions
            async checkStoreNik() {
                if (!this.storeNik) {
                    this.storeError = 'NIK is required';
                    return;
                }
                
                this.storeError = '';
                this.storeLoading = true;
                
                try {
                    const response = await fetch('<?php echo e(route("api.esd.check-nik")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({ nik: this.storeNik })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.storeEmployee = data.employee;
                        this.storeStep = 2;
                    } else {
                        this.storeError = data.message || 'Employee not found';
                        showToast(this.storeError, 'error');
                    }
                } catch (error) {
                    this.storeError = 'Error checking NIK';
                    showToast('Error checking NIK', 'error');
                }
                
                this.storeLoading = false;
            },

            async storeUniform() {
                this.storeLoading = true;
                
                try {
                    const response = await fetch('<?php echo e(route("api.esd.store-uniform")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({ nik: this.storeEmployee.nik })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.storeLockerCode = data.locker_code;
                        this.storeAccessCode = data.access_code;
                        this.storeStep = 3;
                        showToast('Locker opened successfully!', 'success');
                        this.fetchLockers();
                    } else {
                        showToast(data.message || 'Error storing uniform', 'error');
                    }
                } catch (error) {
                    showToast('Error storing uniform', 'error');
                }
                
                this.storeLoading = false;
            },

            resetStore() {
                this.storeStep = 1;
                this.storeNik = '';
                this.storeEmployee = {};
                this.storeLockerCode = '';
                this.storeAccessCode = '';
                this.storeError = '';
                this.storeLoading = false;
            },

            // Take Functions
            async checkTakeCode() {
                if (!this.takeAccessCode) {
                    this.takeError = 'Access code is required';
                    return;
                }
                
                this.takeError = '';
                this.takeLoading = true;
                
                try {
                    const response = await fetch('<?php echo e(route("api.esd.check-take")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({ code: this.takeAccessCode })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.takeTransaction = data.transaction;
                        this.takeStep = 2;
                    } else {
                        this.takeError = data.message || 'Invalid access code';
                        showToast(this.takeError, 'error');
                    }
                } catch (error) {
                    this.takeError = 'Error checking access code';
                    showToast('Error checking access code', 'error');
                }
                
                this.takeLoading = false;
            },

            async openTakeLocker() {
                this.takeLoading = true;
                
                try {
                    const response = await fetch('<?php echo e(route("api.esd.open-take-locker")); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                        },
                        body: JSON.stringify({ transaction_id: this.takeTransaction.id })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        this.takeStep = 3;
                        showToast('Locker opened successfully!', 'success');
                        this.fetchLockers();
                    } else {
                        showToast(data.message || 'Error opening locker', 'error');
                    }
                } catch (error) {
                    showToast('Error opening locker', 'error');
                }
                
                this.takeLoading = false;
            },

            resetTake() {
                this.takeStep = 1;
                this.takeAccessCode = '';
                this.takeTransaction = {};
                this.takeError = '';
                this.takeLoading = false;
            },

            // Helper Functions
            getStatusClass(status) {
                const classes = {
                    'available': 'bg-green-500 hover:bg-green-600',
                    'open': 'bg-yellow-500 hover:bg-yellow-600',
                    'in_progress': 'bg-blue-500 hover:bg-blue-600',
                    'ng': 'bg-red-500 hover:bg-red-600',
                    'finished': 'bg-gray-500 hover:bg-gray-600'
                };
                return classes[status] || 'bg-gray-500';
            },

            getStatusBadgeClass(status) {
                const classes = {
                    'available': 'bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300',
                    'open': 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-800 dark:text-yellow-300',
                    'in_progress': 'bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300',
                    'ng': 'bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300',
                    'finished': 'bg-gray-100 dark:bg-gray-900/30 text-gray-800 dark:text-gray-300'
                };
                return classes[status] || 'bg-gray-100 text-gray-800';
            },

            formatStatus(status) {
                if (!status) return '';
                return status.replace('_', ' ').toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
            }
        };
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.esd', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /www/wwwroot/testings.siix-ems.co.id/siix-portal/resources/views/esd/locker/index.blade.php ENDPATH**/ ?>