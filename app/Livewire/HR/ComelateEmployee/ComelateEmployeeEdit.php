<?php

namespace App\Livewire\HR\ComelateEmployee;

use App\Models\HR\ComelateEmployee;
use App\Models\HR\Employee;
use Livewire\Component;
use Carbon\Carbon;

class ComelateEmployeeEdit extends Component
{
    public $comelateId;
    public $nik = '';
    public $name = '';
    public $department = '';
    public $status_display = '';
    public $shift = '';
    public $jam_masuk = '';
    public $jam = '';
    public $count_jam = '';
    public $count_jam_display = '';
    public $alasan_terlambat = '';
    public $nama_security = '';
    public $tanggal = '';
    public $remarks = '';
    public $employeeCallCount = null;
    public $employeeLabel = '';
    
    public function getShiftsProperty()
    {
        return [
            'NS' => 'Non Shift',
            '1' => 'Shift 1',
            '2' => 'Shift 2',
            '3' => 'Shift 3',
        ];
    }
    
    public function getReasonOptionsProperty()
    {
        return [
            'Macet Lalulintas' => 'Macet Lalulintas',
            'Masalah Kendaraan' => 'Masalah Kendaraan',
            'Telat Berangkat' => 'Telat Berangkat',
            'Keperluan Pribadi' => 'Keperluan Pribadi',
            'Keperluan Keluarga' => 'Keperluan Keluarga',
        ];
    }
    
    // Format menit menjadi teks
    public function formatMinutes($minutes)
    {
        if (!$minutes || $minutes == 0) {
            return '-';
        }
        
        return $minutes . ' Menit';
    }
    
    // Format waktu dengan Pagi/Siang
    public function formatTimeWithPeriod($time)
    {
        if (!$time) {
            return '';
        }
        
        $carbon = Carbon::parse($time);
        $hour = (int)$carbon->format('H');
        $period = $hour < 12 ? 'Pagi' : 'Siang';
        
        return $carbon->format('H:i') . ' ' . $period;
    }
    
    public function mount($id)
    {
        $this->comelateId = $id;
        $comelate = ComelateEmployee::findOrFail($id);
        
        $this->nik = $comelate->nik;
        $this->name = $comelate->name;
        $this->department = $comelate->department;
        $this->shift = $comelate->shift;
        $this->jam_masuk = $comelate->jam_masuk;
        $this->jam = $comelate->jam;
        $this->count_jam = $comelate->count_jam;
        $this->count_jam_display = $this->formatMinutes($comelate->count_jam);
        $this->alasan_terlambat = $comelate->alasan_terlambat;
        $this->nama_security = $comelate->nama_security;
        $this->tanggal = $comelate->tanggal;
        $this->remarks = $comelate->remarks;
        
        $employee = Employee::find($comelate->nik);
        if ($employee) {
            $this->status_display = match($employee->status) {
                1 => 'Permanent',
                2 => 'Contract',
                3 => 'Magang',
                default => 'Unknown',
            };
            $this->employeeCallCount = \App\Models\HR\EmployeeCall::where('nik', $employee->id)
                ->where('category', 'Comelate')
                ->count();
            $this->employeeLabel = $employee->nik . ' - ' . $employee->name;
        }
    }
    
    private function calculateJamMasuk($shift, $tanggal)
    {
        if (!$shift) return null;
        
        try {
            $tanggalCarbon = Carbon::parse($tanggal);
            $isSabtu = $tanggalCarbon->isSaturday();
            
            $nsSpecialStart = Carbon::create(2026, 2, 18)->startOfDay();
            $nsSpecialEnd = Carbon::create(2026, 3, 25)->endOfDay();
            
            if ($shift === 'NS' && $tanggalCarbon->between($nsSpecialStart, $nsSpecialEnd)) {
                return '07:00';
            }
        } catch (\Exception $e) {
            $isSabtu = false;
        }
        
        return match ($shift) {
            'NS' => '08:00',
            '1' => '07:00',
            '2' => $isSabtu ? '12:30' : '15:00',
            '3' => $isSabtu ? '17:45' : '23:00',
            default => null,
        };
    }
    
    private function calculateCountJam($jam, $jamMasuk)
    {
        try {
            $jamDatang = Carbon::parse($jam)->seconds(0);
            $jamHarusMasuk = Carbon::parse($jamMasuk)->seconds(0);
            
            if ($jamDatang->lte($jamHarusMasuk)) {
                return 0;
            }
            
            return $jamHarusMasuk->diffInMinutes($jamDatang); // <-- dibalik (AMAN)
        } catch (\Exception $e) {
            return 0;
        }
    }
    
    public function updatedShift()
    {
        $this->updateJamMasuk();
    }
    
    public function updatedTanggal()
    {
        $this->updateJamMasuk();
    }
    
    private function updateJamMasuk()
    {
        if ($this->shift && $this->tanggal) {
            $jamMasuk = $this->calculateJamMasuk($this->shift, $this->tanggal);
            if ($jamMasuk) {
                $this->jam_masuk = $jamMasuk;
                
                if ($this->jam) {
                    $minutes = $this->calculateCountJam($this->jam, $this->jam_masuk);
                    $this->count_jam = $minutes;
                    $this->count_jam_display = $this->formatMinutes($minutes);
                }
            }
        }
    }
    
    public function updatedJam($value)
    {
        if ($value && $this->jam_masuk) {
            $minutes = $this->calculateCountJam($value, $this->jam_masuk);
            $this->count_jam = $minutes;
            $this->count_jam_display = $this->formatMinutes($minutes);
        }
    }
    
    public function update()
    {
        $this->validate([
            'shift' => 'required',
            'jam' => 'required',
            'alasan_terlambat' => 'required',
            'nama_security' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'remarks' => 'nullable|string',
        ]);
        
        $comelate = ComelateEmployee::findOrFail($this->comelateId);
        $comelate->update([
            'shift' => $this->shift,
            'jam_masuk' => $this->jam_masuk,
            'jam' => $this->jam,
            'count_jam' => $this->count_jam,
            'alasan_terlambat' => $this->alasan_terlambat,
            'nama_security' => $this->nama_security,
            'tanggal' => $this->tanggal,
            'remarks' => $this->remarks,
        ]);
        
        session()->flash('message', 'Record updated successfully.');
        return redirect()->route('hr.comelate.index');
    }

    // Format jam dengan periode (Pagi, Siang, Sore, Malam)
    public function formatJamWithPeriod($jam)
    {
        if (!$jam) return '-';
        
        $carbon = Carbon::parse($jam);
        $hour = (int)$carbon->format('H');
        
        // Menentukan periode
        if ($hour >= 1 && $hour <= 12) {
            $period = 'Pagi';
        } elseif ($hour >= 13 && $hour <= 15) {
            $period = 'Siang';
        } elseif ($hour >= 16 && $hour <= 18) {
            $period = 'Sore';
        } else {
            $period = 'Malam';
        }
        
        return $carbon->format('H:i') . ' ' . $period;
    }

    // Untuk mendapatkan warna badge berdasarkan periode
    public function getPeriodColor($jam)
    {
        if (!$jam) return 'gray';
        
        $hour = (int)Carbon::parse($jam)->format('H');
        
        if ($hour >= 1 && $hour <= 12) return 'green';
        if ($hour >= 13 && $hour <= 15) return 'yellow';
        if ($hour >= 16 && $hour <= 18) return 'orange';
        return 'blue';
    }
    
    public function render()
    {
        return view('livewire.hr.comelate-employee.edit');
    }
}