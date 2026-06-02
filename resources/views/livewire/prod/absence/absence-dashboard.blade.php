{{-- resources/views/livewire/prod/absence/absence-dashboard.blade.php --}}
<div class="p-1 space-y-2">
    @section('title', 'Attendance Dashboard')
    
    <flux:breadcrumbs>
        <flux:breadcrumbs.item href="{{ route('dashboard') }}" wire:navigate separator="slash">Dashboard</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">HR</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Attendance</flux:breadcrumbs.item>
        <flux:breadcrumbs.item separator="slash" class="font-semibold text-blue-600">Dashboard</flux:breadcrumbs.item>
    </flux:breadcrumbs>

    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mt-2">
        <div>
            <h1 class="text-3xl font-bold text-zinc-800 dark:text-white">Attendance Dashboard</h1>
            <p class="text-sm text-zinc-500">Monitor Attendance data and statistics</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Start Date</label>
            <input type="date" wire:model.live="startDate" class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">End Date</label>
            <input type="date" wire:model.live="endDate" class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg">
        </div>
        <div>
            <label class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-1">Department</label>
            <select wire:model.live="selectedDepartment" class="w-full px-3 py-2 text-sm bg-white dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-lg">
                <option value="">All Departments</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept }}">{{ $dept }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <!-- Chart 1: Percentage per Day (Line Chart) -->
    <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow">
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-white mb-4">📊 Persentase Kehadiran per Hari</h2>
        <p class="text-sm text-zinc-500 mb-4">Periode: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
        
        <div id="percentageChart"></div>
    </flux:card>

    <!-- Chart 2: Horizontal Bar Chart per Shift -->
    <flux:card class="p-6 shadow-lg hover:shadow-xl transition-shadow">
        <h2 class="text-xl font-semibold text-zinc-800 dark:text-white mb-4">📊 Distribusi Shift & Ketidakhadiran</h2>
        <p class="text-sm text-zinc-500 mb-4">Total Records: {{ $shiftStackedData['total'] ?? 0 }}</p>
        
        <div id="stackedChart"></div>
    </flux:card>

    <!-- Daily Accumulation Table -->
    <flux:card class="p-0 shadow-lg hover:shadow-xl transition-shadow overflow-hidden">
        <div class="p-4 border-b bg-zinc-50 dark:bg-zinc-800/50">
            <h2 class="text-xl font-semibold text-zinc-800 dark:text-white">📋 Akumulasi Ketidakhadiran per Hari</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-zinc-100 dark:bg-zinc-800/50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-zinc-500">Tanggal</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500">CT</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500">SD</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500">IJ</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500">A</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500">CK</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500">CM</th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-zinc-500 bg-blue-50">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                    @forelse($dailyData as $row)
                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50">
                        <td class="px-4 py-2 font-medium">{{ $row['display_date'] }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($row['CT']) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($row['SD']) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($row['IJ']) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($row['A']) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($row['CK']) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format($row['CM']) }}</td>
                        <td class="px-4 py-2 text-center font-semibold bg-blue-50 dark:bg-blue-900/20">{{ number_format($row['total']) }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-4 py-8 text-center text-zinc-500">No data available</td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot class="bg-zinc-50 dark:bg-zinc-800/50 font-semibold">
                    <tr>
                        <td class="px-4 py-2">Total</td>
                        <td class="px-4 py-2 text-center">{{ number_format(collect($dailyData)->sum('CT')) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format(collect($dailyData)->sum('SD')) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format(collect($dailyData)->sum('IJ')) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format(collect($dailyData)->sum('A')) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format(collect($dailyData)->sum('CK')) }}</td>
                        <td class="px-4 py-2 text-center">{{ number_format(collect($dailyData)->sum('CM')) }}</td>
                        <td class="px-4 py-2 text-center bg-blue-100 dark:bg-blue-900/30">{{ number_format(collect($dailyData)->sum('total')) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </flux:card>

    <!-- Notification -->
    <div x-data="{ show: false, message: '', type: 'success' }" 
         x-on:notify.window="show = true; message = $event.detail.message; type = $event.detail.type || 'success'; setTimeout(() => show = false, 3000)"
         x-show="show" x-transition class="fixed bottom-4 right-4 z-50"
         :class="{'bg-green-500': type === 'success', 'bg-red-500': type === 'error'}" style="display: none;">
        <div class="text-white px-6 py-3 rounded-lg shadow-lg" x-text="message"></div>
    </div>
</div>

<!-- ApexCharts CDN - Lightweight and modern -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<script>
    let percentageChart = null;
    let stackedChart = null;
    
    function initPercentageChart() {
        const labels = @json($percentageChartData['labels'] ?? []);
        const values = @json($percentageChartData['values'] ?? []);
        
        if (percentageChart) {
            percentageChart.destroy();
        }
        
        const options = {
            series: [{
                name: 'Persentase Kehadiran (%)',
                data: values.length ? values : [0]
            }],
            chart: {
                type: 'line',
                height: 400,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: false,
                        reset: true
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3,
                colors: ['#3B82F6']
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#60A5FA'],
                    inverseColors: false,
                    opacityFrom: 0.6,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            },
            markers: {
                size: 5,
                colors: ['#3B82F6'],
                strokeColors: '#fff',
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            xaxis: {
                categories: labels.length ? labels : ['No Data'],
                title: {
                    text: 'Tanggal',
                    style: {
                        fontSize: '12px',
                        fontWeight: 500
                    }
                },
                labels: {
                    rotate: -45,
                    style: {
                        fontSize: '11px'
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Persentase (%)',
                    style: {
                        fontSize: '12px',
                        fontWeight: 500
                    }
                },
                min: 0,
                max: 100,
                labels: {
                    formatter: function(value) {
                        return value + '%';
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + '%';
                    },
                    title: {
                        formatter: function() {
                            return 'Kehadiran: ';
                        }
                    }
                },
                theme: 'dark'
            },
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 5,
                position: 'back'
            },
            title: {
                text: labels.length ? undefined : 'Tidak ada data untuk ditampilkan',
                align: 'center',
                style: {
                    fontSize: '14px',
                    color: '#666'
                }
            }
        };
        
        percentageChart = new ApexCharts(document.querySelector("#percentageChart"), options);
        percentageChart.render();
    }
    
    function initStackedChart() {
        const labels = @json($shiftStackedData['labels'] ?? []);
        const values = @json($shiftStackedData['values'] ?? []);
        const colors = @json($shiftStackedData['backgroundColors'] ?? []);
        
        if (stackedChart) {
            stackedChart.destroy();
        }
        
        const options = {
            series: [{
                name: 'Jumlah Records',
                data: values.length ? values : [0]
            }],
            chart: {
                type: 'bar',
                height: labels.length * 50 + 80, // Dynamic height based on number of items
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: false,
                        zoom: false,
                        pan: false,
                        reset: true
                    }
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 8,
                    horizontal: true,
                    distributed: true,
                    barHeight: '70%',
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            colors: colors.length ? colors : ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6', '#EC4899'],
            dataLabels: {
                enabled: true,
                formatter: function(val) {
                    return val + ' records';
                },
                offsetX: 10,
                style: {
                    fontSize: '11px',
                    fontWeight: 500
                }
            },
            xaxis: {
                categories: labels.length ? labels : ['No Data'],
                title: {
                    text: 'Jumlah Records',
                    style: {
                        fontSize: '12px',
                        fontWeight: 500
                    }
                },
                labels: {
                    formatter: function(value) {
                        return Math.floor(value);
                    }
                }
            },
            yaxis: {
                title: {
                    text: 'Kategori',
                    style: {
                        fontSize: '12px',
                        fontWeight: 500
                    }
                },
                labels: {
                    style: {
                        fontSize: '12px',
                        fontWeight: 500
                    }
                }
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return value + ' records';
                    }
                },
                theme: 'dark'
            },
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 5,
                xaxis: {
                    lines: {
                        show: true
                    }
                }
            },
            legend: {
                show: false
            },
            title: {
                text: labels.length ? undefined : 'Tidak ada data untuk ditampilkan',
                align: 'center',
                style: {
                    fontSize: '14px',
                    color: '#666'
                }
            }
        };
        
        stackedChart = new ApexCharts(document.querySelector("#stackedChart"), options);
        stackedChart.render();
    }
    
    // Initialize charts when page loads
    document.addEventListener('livewire:init', function() {
        setTimeout(function() {
            initPercentageChart();
            initStackedChart();
        }, 300);
    });
    
    // Re-initialize charts when Livewire updates
    Livewire.on('render', () => {
        setTimeout(function() {
            if (percentageChart) {
                percentageChart.destroy();
            }
            if (stackedChart) {
                stackedChart.destroy();
            }
            initPercentageChart();
            initStackedChart();
        }, 300);
    });
    
    // Watch for Livewire refresh events
    Livewire.on('$refresh', () => {
        setTimeout(function() {
            if (percentageChart) {
                percentageChart.destroy();
            }
            if (stackedChart) {
                stackedChart.destroy();
            }
            initPercentageChart();
            initStackedChart();
        }, 300);
    });
    
    // Handle dark mode changes
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                setTimeout(function() {
                    if (percentageChart) {
                        percentageChart.updateOptions({
                            theme: {
                                mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                            }
                        });
                    }
                    if (stackedChart) {
                        stackedChart.updateOptions({
                            theme: {
                                mode: document.documentElement.classList.contains('dark') ? 'dark' : 'light'
                            }
                        });
                    }
                }, 100);
            }
        });
    });
    
    observer.observe(document.documentElement, { attributes: true });
</script>

<style>
    [x-cloak] { display: none !important; }
    .apexcharts-canvas {
        width: 100% !important;
    }
</style>