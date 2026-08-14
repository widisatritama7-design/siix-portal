@extends('layouts.esd')

@section('title', 'Admin Monitoring')

@section('content')
<div>
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">📊 Admin Monitoring - ESD Locker</h2>
        <button wire:click="refreshData" 
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-200">
            🔄 Refresh
        </button>
    </div>

    <!-- Statistics -->
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
        <div class="bg-white border rounded-lg p-4 shadow-sm">
            <p class="text-sm text-gray-500">Total Loker</p>
            <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</p>
        </div>
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <p class="text-sm text-green-600">Tersedia</p>
            <p class="text-2xl font-bold text-green-700">{{ $stats['available'] }}</p>
        </div>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <p class="text-sm text-red-600">Terisi</p>
            <p class="text-2xl font-bold text-red-700">{{ $stats['occupied'] }}</p>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
            <p class="text-sm text-gray-600">Maintenance</p>
            <p class="text-2xl font-bold text-gray-700">{{ $stats['maintenance'] }}</p>
        </div>
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <p class="text-sm text-yellow-600">Transaksi Aktif</p>
            <p class="text-2xl font-bold text-yellow-700">{{ $stats['transactions_active'] }}</p>
        </div>
    </div>

    <!-- Locker Grid -->
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <h3 class="font-semibold text-lg text-gray-700 mb-4">🗄️ Status Loker</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-4">
            @foreach($lockers as $locker)
                <div class="border rounded-lg p-4 text-center locker-grid-item {{ $locker->status == 'available' ? 'bg-green-50 border-green-300' : ($locker->status == 'occupied' ? 'bg-red-50 border-red-300' : 'bg-gray-50 border-gray-300') }}">
                    <div class="font-mono font-bold text-lg">{{ $locker->code }}</div>
                    <div class="text-xs mt-1">
                        <span class="px-2 py-1 rounded text-xs {{ $this->getLockerStatusBadge($locker) }}">
                            {{ $this->getLockerStatusText($locker) }}
                        </span>
                    </div>
                    @if($locker->employee)
                        <div class="text-xs text-gray-600 mt-1 truncate">{{ $locker->employee->name }}</div>
                    @endif
                    @if($locker->isLocked())
                        <div class="text-xs text-red-600 mt-1">🔒 Terkunci</div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <!-- Active Transactions -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-lg text-gray-700">📋 Transaksi Aktif</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">NIK</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Loker</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode Akses</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaction->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaction->employee->nik ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $transaction->employee->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono font-bold">
                                {{ $transaction->locker->code }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($transaction->type == 'store')
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-xs">Menyimpan</span>
                                @else
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">Mengambil</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'on_progress' => 'bg-orange-100 text-orange-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'waiting_pickup' => 'bg-purple-100 text-purple-800'
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded text-xs {{ $statusColors[$transaction->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-mono">
                                {{ $transaction->access_code }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                Tidak ada transaksi aktif
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection