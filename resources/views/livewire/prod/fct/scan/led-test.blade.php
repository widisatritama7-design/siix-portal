@extends('layouts.pcb')

@section('title', 'LED Test Process Scan')

@section('content')
<div class="max-w-3xl mx-auto px-4">
    <!-- Header -->
    <div class="mb-6 text-center">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center justify-center">
            <i class="fas fa-lightbulb text-green-500 mr-3"></i>
            LED Test Process
        </h1>
        <p class="text-gray-600 mt-1">Scan PCB barcode to start LED Test process</p>
    </div>

    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden">
        <!-- System Status -->
        <div class="px-6 py-3 bg-green-50 border-b border-green-100 flex items-center">
            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
            <span class="text-sm text-green-700">System Online - Ready</span>
            <span class="ml-auto text-xs text-gray-400" id="lastCheck">Connected</span>
        </div>

        <!-- Warning Message -->
        <div id="lockWarning" class="hidden px-6 py-3 bg-red-50 border-b border-red-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center text-red-700">
                    <i class="fas fa-lock mr-2 text-sm"></i>
                    <span class="text-sm" id="lockMessage">System locked</span>
                </div>
                <a href="{{ route('pcb-scan.leader.index') }}" class="text-xs bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Resolve</a>
            </div>
        </div>

        <!-- Content -->
        <div class="p-6">
            <!-- Scan Input -->
            <!-- Scan Input - Center -->
            <div class="mb-6 max-w-md mx-auto">
                <label class="block text-sm font-medium text-gray-700 mb-2 text-center">
                    Scan PCB Barcode <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" 
                        id="serial_number" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:border-green-500 focus:ring-1 focus:ring-green-500 outline-none text-lg text-center"
                        placeholder="Scan barcode here..."
                        autofocus
                        autocomplete="off">
                </div>
                <p class="text-xs text-gray-500 mt-2 text-center">
                    <i class="fas fa-info-circle mr-1"></i>
                    Requires FCT completed first
                </p>
            </div>

            <!-- Result Display -->
            <div id="result" class="mb-4 hidden"></div>

            <!-- Recent Scans -->
            <div>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-700">
                        <i class="fas fa-history mr-2 text-gray-400"></i>
                        Recent LED Test Scans
                    </h3>
                    <span class="text-xs text-gray-400" id="refreshTime"></span>
                </div>
                <div class="bg-gray-50 rounded-lg p-3" id="recent-scans">
                    <div class="flex justify-center py-4">
                        <div class="w-5 h-5 border-2 border-gray-300 border-t-green-500 rounded-full animate-spin"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<!-- Audio -->
<audio id="beep-sound" src="https://www.soundjay.com/misc/sounds/bell-ringing-05.mp3" preload="auto"></audio>
<audio id="error-sound" src="https://www.soundjay.com/misc/sounds/buzzer-1.mp3" preload="auto"></audio>
@endsection

@section('scripts')
<script>
let isProcessing = false;
let currentPage = 1;
let totalPages = 1;
const itemsPerPage = 3;

$(document).ready(function() {
    loadRecentScans(1);
    checkSystemLock();
    setInterval(checkSystemLock, 5000);
    
    $('#serial_number').on('keypress', function(e) {
        if (e.which === 13) {
            e.preventDefault();
            processScan();
        }
    });
});

let lockCheckInterval;

function checkSystemLock() {
    $.get('/api/check-system-lock', function(data) {
        if (data.is_locked) {
            $('#lockWarning').removeClass('hidden');
            $('#lockMessage').text('🔒 Locked by: ' + (data.locked_boxes?.[0]?.serial_number || 'Unknown'));
            $('#serial_number').prop('disabled', true);
        } else {
            $('#lockWarning').addClass('hidden');
            $('#serial_number').prop('disabled', false);
            
            // AUTO FOCUS setelah unlock (tanpa perlu refresh)
            setTimeout(function() {
                $('#serial_number').focus();
            }, 300);
        }
    }).fail(function() {
        $('#lastCheck').text('Connection issue');
    });
}

function loadRecentScans(page) {
    $.ajax({
        url: '/api/recent-scans/led_test',
        method: 'GET',
        data: { page: page, per_page: itemsPerPage },
        success: function(response) {
            const data = response.data || response;
            totalPages = response.last_page || 1;
            
            if (data.length > 0) {
                let html = '<div class="space-y-2">';
                data.forEach((scan, i) => {
                    html += `
                        <div class="flex justify-between items-center p-2 bg-white rounded border border-gray-100">
                            <span class="font-mono text-sm">${scan.serial_number}</span>
                            <span class="text-xs text-gray-400">${new Date(scan.created_at).toLocaleTimeString()}</span>
                        </div>
                    `;
                });
                html += '</div>';
                
                if (totalPages > 1) {
                    html += `
                        <div class="flex justify-between items-center mt-3 pt-2 border-t border-gray-200">
                            <button onclick="changePage('prev')" ${currentPage === 1 ? 'disabled' : ''} 
                                class="text-xs px-2 py-1 border rounded ${currentPage === 1 ? 'text-gray-300' : 'text-gray-600 hover:bg-gray-50'}">
                                Previous
                            </button>
                            <span class="text-xs text-gray-500">Page ${currentPage} of ${totalPages}</span>
                            <button onclick="changePage('next')" ${currentPage === totalPages ? 'disabled' : ''} 
                                class="text-xs px-2 py-1 border rounded ${currentPage === totalPages ? 'text-gray-300' : 'text-gray-600 hover:bg-gray-50'}">
                                Next
                            </button>
                        </div>
                    `;
                }
                
                $('#recent-scans').html(html);
                $('#refreshTime').text(new Date().toLocaleTimeString());
            } else {
                $('#recent-scans').html('<p class="text-center py-4 text-gray-400 text-sm">No scans today</p>');
            }
        }
    });
}

function changePage(direction) {
    if (direction === 'prev' && currentPage > 1) currentPage--;
    if (direction === 'next' && currentPage < totalPages) currentPage++;
    loadRecentScans(currentPage);
}

function processScan() {
    if (isProcessing) return;
    
    const serialNumber = $('#serial_number').val().trim();
    
    if (!serialNumber) {
        showResult('error', '⚠️ Please scan a barcode');
        $('#serial_number').addClass('border-red-500').focus();
        setTimeout(() => $('#serial_number').removeClass('border-red-500'), 1000);
        return;
    }

    isProcessing = true;
    $('#serial_number').prop('disabled', true).addClass('bg-gray-100');
    
    $.ajax({
        url: '{{ route("pcb-scan.process", "fct") }}', // Sesuaikan dengan proses
        method: 'POST',
        data: {
            serial_number: serialNumber,
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            if (response.success) {
                document.getElementById('beep-sound').play();
                showResult('success', response.message);
                
                // Jika process completed (visual inspection)
                if (response.process_completed) {
                    document.getElementById('complete-sound')?.play();
                    $('#completionMessage').removeClass('hidden').show();
                    setTimeout(function() {
                        $('#completionMessage').fadeOut('slow');
                    }, 8000);
                }
                
                $('#serial_number').val('').prop('disabled', false).removeClass('bg-gray-100').focus();
                loadRecentScans(1);
            } else {
                document.getElementById('error-sound').play();
                
                // Cek apakah ini error duplicate
                if (response.error_type === 'duplicate') {
                    showResult('warning', response.message);
                } else {
                    showResult('error', response.message);
                }
                
                $('#serial_number').prop('disabled', false).removeClass('bg-gray-100').focus();
                
                // Jika ada redirect (system locked)
                if (response.redirect) {
                    setTimeout(function() {
                        window.location.href = response.redirect;
                    }, 3000);
                }
            }
        },
        error: function(xhr) {
            document.getElementById('error-sound').play();
            
            let errorMsg = '⚠️ An unexpected error occurred. Please try again.';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMsg = xhr.responseJSON.message;
            }
            
            showResult('error', errorMsg);
            $('#serial_number').prop('disabled', false).removeClass('bg-gray-100').focus();
        },
        complete: function() {
            isProcessing = false;
        }
    });
}

function showResult(type, message) {
    const resultDiv = $('#result');
    resultDiv.removeClass('hidden');
    
    const styles = {
        success: { 
            bg: 'bg-green-50', 
            text: 'text-green-700', 
            border: 'border-green-200', 
            icon: 'fa-check-circle',
            iconColor: 'text-green-500'
        },
        error: { 
            bg: 'bg-red-50', 
            text: 'text-red-700', 
            border: 'border-red-200', 
            icon: 'fa-exclamation-circle',
            iconColor: 'text-red-500'
        },
        warning: { 
            bg: 'bg-yellow-50', 
            text: 'text-yellow-700', 
            border: 'border-yellow-200', 
            icon: 'fa-triangle-exclamation',
            iconColor: 'text-yellow-500'
        },
        info: { 
            bg: 'bg-blue-50', 
            text: 'text-blue-700', 
            border: 'border-blue-200', 
            icon: 'fa-info-circle',
            iconColor: 'text-blue-500'
        }
    };
    
    const s = styles[type] || styles.info;
    
    resultDiv.html(`
        <div class="${s.bg} border ${s.border} ${s.text} px-4 py-4 rounded-lg flex items-center justify-between shadow-sm" role="alert">
            <div class="flex items-center">
                <i class="fas ${s.icon} ${s.iconColor} text-xl mr-3"></i>
                <div>
                    <span class="font-medium">${type === 'success' ? 'Success!' : type === 'error' ? 'Error!' : type === 'warning' ? 'Warning!' : 'Info!'}</span>
                    <span class="ml-2">${message}</span>
                </div>
            </div>
            <button onclick="$(this).closest('div').fadeOut()" class="text-gray-400 hover:text-gray-600 transition">
                <i class="fas fa-times"></i>
            </button>
        </div>
    `);
    
    // Auto hide setelah 5 detik (kecuali warning)
    if (type !== 'warning') {
        setTimeout(function() {
            resultDiv.fadeOut('slow');
        }, 5000);
    }
}
</script>
@endsection