@extends('layouts.pcb')

@section('title', 'Unlock NG Box')

@section('content')
<div class="max-w-2xl mx-auto px-4">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                    <i class="fas fa-lock-open text-blue-500 mr-3"></i>
                    Unlock NG Box
                </h1>
                <p class="text-gray-600 mt-1">Enter unlock code to release locked PCB and resume production</p>
            </div>
            <a href="{{ route('pcb-scan.leader.index') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm transition duration-200 flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Back
            </a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- Locked Box Info Header -->
        <div class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-4">
            <div class="flex items-center">
                <div class="bg-white/20 p-3 rounded-full mr-4">
                    <i class="fas fa-exclamation-triangle text-xl"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold">LOCKED PCB DETECTED</h3>
                    <p class="text-sm text-red-100">This PCB is locked and blocking production</p>
                </div>
            </div>
        </div>
        
        <!-- Content -->
        <div class="p-6">
            <!-- PCB Details -->
            <div class="bg-gray-50 rounded-lg p-5 mb-6">
                <h4 class="text-sm font-medium text-gray-500 mb-3">PCB DETAILS</h4>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-gray-400 mb-1">Serial Number</div>
                        <div class="text-lg font-mono font-bold text-gray-800">{{ $ngBox->serial_number }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 mb-1">Blocked Process</div>
                        <div class="text-lg font-bold text-gray-800 uppercase">{{ str_replace('_', ' ', $ngBox->blocked_at_process) }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 mb-1">Locked Since</div>
                        <div class="text-base font-semibold text-gray-800">{{ $ngBox->created_at->format('d M Y H:i:s') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-gray-400 mb-1">Duration</div>
                        <div class="text-base font-semibold text-gray-800">{{ $ngBox->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>

            <!-- Unlock Code Form -->
            <form action="{{ route('pcb-scan.leader.unlock', $ngBox->id) }}" method="POST" id="unlockForm">
                @csrf
                
                <div class="mb-6 flex flex-col items-center">
                    <label class="block text-sm font-medium text-gray-700 mb-2 text-center">
                        Enter Unlock Code <span class="text-red-500">*</span>
                    </label>
                    
                    <!-- Code Input with Eye Toggle - Center -->
                    <div class="relative w-full max-w-xs mx-auto">
                        <input type="password" 
                               name="unlock_code" 
                               id="unlock_code"
                               class="w-full px-4 py-3 text-2xl tracking-widest text-center font-mono border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 outline-none @error('unlock_code') border-red-500 @enderror"
                               placeholder="••••••"
                               maxlength="6"
                               autocomplete="off"
                               autofocus>
                        
                        <button type="button" 
                                onclick="togglePassword()"
                                class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                            <i class="fas fa-eye text-lg" id="eyeIcon"></i>
                        </button>
                    </div>
                    
                    @error('unlock_code')
                        <p class="text-red-500 text-xs mt-1 text-center">{{ $message }}</p>
                    @enderror
                    
                    <p class="text-xs text-gray-500 mt-2 text-center">
                        <i class="fas fa-info-circle mr-1"></i>
                        Enter the 6-digit unlock code provided to the leader
                    </p>
                </div>

                <!-- Action Buttons -->
                <div class="flex space-x-3">
                    <button type="submit" 
                            class="flex-1 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                        <i class="fas fa-lock-open mr-2"></i>
                        UNLOCK BOX
                    </button>
                    
                    <a href="{{ route('pcb-scan.leader.index') }}" 
                       class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>

            <!-- Error Message from Session -->
            @if(session('error'))
                <div class="mt-4 p-3 bg-red-50 border border-red-200 rounded-lg">
                    <div class="flex items-center text-xs text-red-700">
                        <i class="fas fa-exclamation-circle mr-2"></i>
                        <span>{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            <!-- Success Message from Session -->
            @if(session('success'))
                <div class="mt-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <div class="flex items-center text-xs text-green-700">
                        <i class="fas fa-check-circle mr-2"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Warning Message -->
    <div class="mt-4 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3"></i>
            <div class="text-sm text-blue-700">
                <span class="font-bold">Important:</span> 
                Unlocking this box will allow production to continue. Make sure to check the PCB 
                and document the issue before unlocking.
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Toggle password visibility
function togglePassword() {
    const input = document.getElementById('unlock_code');
    const eyeIcon = document.getElementById('eyeIcon');
    
    if (input.type === 'password') {
        input.type = 'text';
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

// Auto-submit when 6 digits entered
document.getElementById('unlock_code').addEventListener('input', function(e) {
    if (this.value.length === 6) {
        this.classList.add('border-green-500');
        this.classList.remove('border-gray-300');
    } else {
        this.classList.remove('border-green-500');
        this.classList.add('border-gray-300');
    }
});

// Prevent form resubmission on page refresh
if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
}

// Confirm before unlock
document.getElementById('unlockForm').addEventListener('submit', function(e) {
    const code = document.getElementById('unlock_code').value;
    
    if (code.length !== 6) {
        e.preventDefault();
        alert('Please enter 6-digit unlock code');
        return;
    }
    
    if (!confirm('Are you sure you want to unlock this box? Production will resume.')) {
        e.preventDefault();
    }
});

// Focus on input
$(document).ready(function() {
    $('#unlock_code').focus();
    
    // Clear any previous messages after 5 seconds
    setTimeout(function() {
        $('.bg-red-50, .bg-green-50').fadeOut();
    }, 5000);
});
</script>
@endsection