@extends('layouts.pcb')

@section('title', 'PCB Scan Dashboard')

@section('content')
<div class="max-w-4xl mx-auto px-4">
    <!-- Header -->
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">PCB Scan Dashboard</h1>
        <p class="text-gray-600">Select process to scan PCB</p>
    </div>

    @if($isSystemLocked)
        <!-- System Locked Banner -->
        <div class="bg-red-100 border-2 border-red-500 rounded-xl p-8 mb-8 text-center animate__animated animate__shakeX">
            <div class="text-7xl mb-4">🔒</div>
            <h3 class="text-2xl font-bold text-red-700 mb-2">SYSTEM LOCKED</h3>
            <p class="text-red-600 mb-4">There is an active NG Box that needs to be unlocked by leader.</p>
            <a href="{{ route('leader.index') }}" 
               class="inline-block bg-red-500 hover:bg-red-600 text-white font-bold py-3 px-8 rounded-lg transition duration-200">
                <i class="fas fa-lock-open mr-2"></i>
                Go to Leader Panel
            </a>
        </div>
    @endif

    <!-- Process Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- FCT Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 transition-all duration-300 
            {{ $isSystemLocked ? 'border-gray-200 opacity-60' : 'border-blue-200 hover:border-blue-500 hover:shadow-xl' }}">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-4 py-4">
                <div class="flex items-center">
                    <i class="fas fa-microchip text-2xl mr-3"></i>
                    <div>
                        <h3 class="text-lg font-bold">FCT Process</h3>
                        <p class="text-xs text-blue-100">Step 1 of 3</p>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <p class="text-gray-600 mb-4 text-sm">Functional Test - Auto OK</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>Scan to start
                    </span>
                    @if($isSystemLocked)
                        <button disabled class="bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                            <i class="fas fa-lock mr-2"></i>Locked
                        </button>
                    @else
                        <a href="{{ route('pcb-scan.fct') }}" 
                           class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-5 rounded-lg transition duration-200 text-sm font-medium">
                            Go to Scan
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- LED Test Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 transition-all duration-300 
            {{ $isSystemLocked ? 'border-gray-200 opacity-60' : 'border-green-200 hover:border-green-500 hover:shadow-xl' }}">
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-4">
                <div class="flex items-center">
                    <i class="fas fa-lightbulb text-2xl mr-3"></i>
                    <div>
                        <h3 class="text-lg font-bold">LED Test Process</h3>
                        <p class="text-xs text-green-100">Step 2 of 3</p>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <p class="text-gray-600 mb-4 text-sm">LED Testing - Auto OK</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>Requires FCT first
                    </span>
                    @if($isSystemLocked)
                        <button disabled class="bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                            <i class="fas fa-lock mr-2"></i>Locked
                        </button>
                    @else
                        <a href="{{ route('pcb-scan.led-test') }}" 
                           class="bg-green-500 hover:bg-green-600 text-white py-2 px-5 rounded-lg transition duration-200 text-sm font-medium">
                            Go to Scan
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Visual Inspection Card -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border-2 transition-all duration-300 
            {{ $isSystemLocked ? 'border-gray-200 opacity-60' : 'border-purple-200 hover:border-purple-500 hover:shadow-xl' }}">
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 text-white px-4 py-4">
                <div class="flex items-center">
                    <i class="fas fa-eye text-2xl mr-3"></i>
                    <div>
                        <h3 class="text-lg font-bold">Visual Inspection</h3>
                        <p class="text-xs text-purple-100">Step 3 of 3</p>
                    </div>
                </div>
            </div>
            <div class="p-5">
                <p class="text-gray-600 mb-4 text-sm">Final Inspection - Auto OK</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-400">
                        <i class="fas fa-info-circle mr-1"></i>Final step
                    </span>
                    @if($isSystemLocked)
                        <button disabled class="bg-gray-300 text-gray-500 py-2 px-4 rounded-lg cursor-not-allowed">
                            <i class="fas fa-lock mr-2"></i>Locked
                        </button>
                    @else
                        <a href="{{ route('pcb-scan.visual-inspection') }}" 
                           class="bg-purple-500 hover:bg-purple-600 text-white py-2 px-5 rounded-lg transition duration-200 text-sm font-medium">
                            Go to Scan
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="mt-10 grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-5 text-center">
            <div class="text-3xl font-bold text-blue-600 mb-1" id="totalScans">0</div>
            <div class="text-xs text-blue-500 font-medium">TOTAL SCANS</div>
        </div>
        <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-5 text-center">
            <div class="text-3xl font-bold text-green-600 mb-1" id="okScans">0</div>
            <div class="text-xs text-green-500 font-medium">OK</div>
        </div>
        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-5 text-center">
            <div class="text-3xl font-bold text-red-600 mb-1" id="ngScans">0</div>
            <div class="text-xs text-red-500 font-medium">NG</div>
        </div>
        <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-5 text-center">
            <div class="text-3xl font-bold text-purple-600 mb-1" id="completedPCBs">0</div>
            <div class="text-xs text-purple-500 font-medium">COMPLETED</div>
        </div>
    </div>

    <!-- Lock Status Indicator (Hidden, just for AJAX) -->
    <div id="lockStatus" data-locked="{{ $isSystemLocked ? 'true' : 'false' }}"></div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
$(document).ready(function() {
    // Load initial stats
    loadStats();
    
    // Refresh stats every 10 seconds
    setInterval(loadStats, 10000);
    
    // Check lock status every 5 seconds
    setInterval(checkLockStatus, 5000);
});

function loadStats() {
    $.get('/api/dashboard-stats', function(data) {
        $('#totalScans').text(data.total_scans || 0);
        $('#okScans').text(data.ok_scans || 0);
        $('#ngScans').text(data.ng_scans || 0);
        $('#completedPCBs').text(data.completed_pcbs || 0);
    }).fail(function() {
        console.log('Failed to load stats');
    });
}

function checkLockStatus() {
    $.get('/api/check-system-lock', function(data) {
        const wasLocked = $('#lockStatus').data('locked') === 'true';
        const isLocked = data.is_locked;
        
        // Update hidden status
        $('#lockStatus').data('locked', isLocked ? 'true' : 'false');
        
        // If lock status changed, reload page to update UI
        if (wasLocked !== isLocked) {
            location.reload();
        }
    }).fail(function() {
        console.log('Failed to check lock status');
    });
}
</script>
@endsection