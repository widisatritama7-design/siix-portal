<?php

use App\Livewire\MTC\Daily\Fuji\DailyFujiCreate;
use App\Livewire\MTC\Daily\Fuji\DailyFujiEdit;
use App\Livewire\MTC\Daily\Panasonic\DailyPanasonicCreate;
use App\Livewire\MTC\Daily\Panasonic\DailyPanasonicEdit;
use App\Livewire\MTC\Dashboard\DailyDashboard;
use App\Livewire\MTC\Dashboard\StencilDashboard;
use App\Livewire\MTC\Master\MasterAreaManagement;
use App\Livewire\MTC\Master\MasterLineManagement;
use App\Livewire\MTC\Master\MasterLineShow;
use App\Livewire\MTC\Master\MasterLocationManagement;
use App\Livewire\MTC\Master\MasterMachineManagement;
use App\Livewire\MTC\Master\StencilManagement;
use App\Models\ESD\Jig\Jig;
use App\Models\HR\Employee;
use App\Models\MTC\Daily\DailyFuji;
use App\Models\MTC\Daily\DailyPanasonic;
use App\Models\MTC\Master\MasterStencil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {

    // Master Area
    Route::livewire('mtc/master-areas', MasterAreaManagement::class)->name('mtc.master-areas');

    // Master Location
    Route::livewire('mtc/master-locations', MasterLocationManagement::class)->name('mtc.master-locations');

    // Master Machine
    Route::livewire('mtc/master-machines', MasterMachineManagement::class)->name('mtc.master-machines');

    // Master Line
    Route::livewire('mtc/master-lines', MasterLineManagement::class)->name('mtc.master-lines');
    Route::livewire('mtc/master-lines/{id}', MasterLineShow::class)->name('mtc.master-lines.show');

    // Daily Fuji
    Route::get('mtc/master-lines/{masterLineId}/daily-fuji/create', DailyFujiCreate::class)->name('mtc.daily-fuji.create');
    Route::get('mtc/master-lines/{masterLineId}/daily-fuji/{dailyFujiId}/edit', DailyFujiEdit::class)->name('mtc.daily-fuji.edit');
    Route::get('mtc/master-lines/dailyFuji/{dailyFuji}', function ($id) {$dailyFuji = DailyFuji::with(['masterLine', 'creator', 'updater', 'approvedBy'])->findOrFail($id); return view('mtc.daily.fuji.daily-fuji-print', compact('dailyFuji')); })->name('print.daily-fuji');

    // Daily Panasonic
    Route::get('mtc/master-lines/{masterLineId}/daily-panasonic/create', DailyPanasonicCreate::class)->name('mtc.daily-panasonic.create');
    Route::get('mtc/master-lines/{masterLineId}/daily-panasonic/{dailyPanasonicId}/edit', DailyPanasonicEdit::class)->name('mtc.daily-panasonic.edit');
    Route::get('print/daily-panasonic/{dailyPanasonic}', function ($id) {$dailyPanasonic = DailyPanasonic::with(['masterLine', 'creator', 'updater', 'approvedBy'])->findOrFail($id); return view('mtc.daily.panasonic.daily-panasonic-print', compact('dailyPanasonic')); })->name('print.daily-panasonic');

    // Stencil
    Route::livewire('mtc/stencils', StencilManagement::class)->name('mtc.stencils');

    // Daily Dashboard
    Route::livewire('/mtc/daily-dashboard', DailyDashboard::class)->name('mtc.daily-dashboard');

    // Stencil Daschboard
    Route::get('/mtc/stencil-dashboard', StencilDashboard::class)->name('mtc.stencil-dashboard');
    Route::post('/api/stencils/update-status', function (Request $request) {
        try {
            $validated = $request->validate([
                'id' => 'required|exists:tb_esd_jigs,id',
                'status' => 'required|in:Prepared,In Use,Stand By,Cleaning,Disposed',
                'nik' => 'required|string',
                'reset_rack' => 'boolean'
            ]);
            
            // Cari employee berdasarkan NIK (string)
            $employee = Employee::where('nik', $validated['nik'])->first();
            
            if (!$employee) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Employee with NIK ' . $validated['nik'] . ' not found'
                ], 404);
            }
            
            // Cari stencil
            $stencil = MasterStencil::find($validated['id']);
            
            if (!$stencil) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Stencil not found'
                ], 404);
            }
            
            // Update data - simpan ID employee ke kolom nik
            $stencil->nik = $employee->id;  // Simpan ID (integer)
            $stencil->status = $validated['status'];
            
            if (auth()->check()) {
                $stencil->updated_by = auth()->id();
            }
            
            if ($validated['reset_rack'] ?? false) {
                $stencil->rack_number = null;
            }
            
            $stencil->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Status updated successfully',
                'data' => $stencil->load('employee')
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false, 
                'message' => 'Failed to update status: ' . $e->getMessage()
            ], 500);
        }
    })->name('api.stencils.update-status');

    Route::get('/api/stencils/latest', function () {
        try {
            $allStencils = App\Models\MTC\Master\MasterStencil::with(['employee'])
                ->where('category', 'STENCIL')
                ->get()
                ->groupBy('line_name');
            
            $stencils = [];
            for ($i = 1; $i <= 17; $i++) {
                $line = "SMT $i";
                $stencils[$line] = $allStencils[$line] ?? [];
            }
            
            return response()->json($stencils);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    })->name('api.stencils.latest');

});
