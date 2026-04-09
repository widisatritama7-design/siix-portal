<?php

namespace App\Livewire\ESD\GB;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\ESD\GB\GroundMonitorBox;
use App\Models\ESD\GB\GroundMonitorBoxDetail;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class GroundMonitorBoxDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $ground_monitor_box_id;
    public $register_no;
    public $area;
    public $location;
    public $g_3;
    public $g_4;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterGroundMonitorBox = '';
    public $filterArea = '';
    public $filterLocation = '';
    public $filterG3 = '';
    public $filterG4 = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    public $modalTitle = 'Add New Ground Monitor Box Measurement';
    public $detailToDelete = null;

    // Properti untuk print
    public $printPreview = false;
    public $printRegisterNo = '';
    public $printArea = '';
    public $printLocation = '';
    public $printDateFrom = '';
    public $printDateUntil = '';

    protected function rules()
    {
        return [
            'ground_monitor_box_id' => 'required|exists:tb_esd_ground_monitor_boxs,id',
            'g_3' => 'required|in:YES,NO',
            'g_4' => 'required|in:YES,NO',
            'remarks' => 'nullable|string|max:255',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'ground_monitor_box_id.required' => 'Register number is required.',
        'ground_monitor_box_id.exists' => 'Selected Ground Monitor Box does not exist.',
        'g_3.required' => 'G1 measurement is required.',
        'g_3.in' => 'G1 must be YES or NO.',
        'g_4.required' => 'G2 measurement is required.',
        'g_4.in' => 'G2 must be YES or NO.',
        'remarks.max' => 'Remarks cannot exceed 255 characters.',
        'next_date.date' => 'Next date must be a valid date.',
    ];

    public function updatedGroundMonitorBoxId($value)
    {
        if ($value) {
            $groundMonitorBox = GroundMonitorBox::find($value);
            if ($groundMonitorBox) {
                $this->area = $groundMonitorBox->area;
                $this->location = $groundMonitorBox->location;
                $this->register_no = $groundMonitorBox->register_no;
            }
        } else {
            $this->area = null;
            $this->location = null;
            $this->register_no = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'ground_monitor_box_id', 'register_no', 'area', 'location',
            'g_3', 'g_4', 'remarks', 'next_date'
        ]);
        $this->modalTitle = 'Add New Ground Monitor Box Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterGroundMonitorBox', 'filterArea', 'filterLocation',
            'filterG3', 'filterG4', 'filterDateFrom', 'filterDateUntil',
            'filterNextDateFrom', 'filterNextDateUntil'
        ]);
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function save()
    {
        if ($this->detail_id) {
            if (!auth()->user()->can('edit ground monitor box details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create ground monitor box details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $data = [
            'ground_monitor_box_id' => $this->ground_monitor_box_id,
            'g_3' => $this->g_3,
            'g_4' => $this->g_4,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = GroundMonitorBoxDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Ground Monitor Box measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Ground Monitor Box measurement updated successfully!';
        } else {
            GroundMonitorBoxDetail::create($data);
            $message = 'Ground Monitor Box measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit ground monitor box details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GroundMonitorBoxDetail::with('groundMonitorBox')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Ground Monitor Box measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->ground_monitor_box_id = $detail->ground_monitor_box_id;
        $this->register_no = $detail->groundMonitorBox->register_no ?? '';
        $this->area = $detail->groundMonitorBox->area ?? '';
        $this->location = $detail->groundMonitorBox->location ?? '';
        $this->g_3 = $detail->g_3;
        $this->g_4 = $detail->g_4;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date;
        $this->modalTitle = 'Edit Ground Monitor Box Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete ground monitor box details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GroundMonitorBoxDetail::with('groundMonitorBox')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Ground Monitor Box measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete ground monitor box details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = GroundMonitorBoxDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Ground Monitor Box measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $this->detailToDelete->groundMonitorBox->register_no ?? 'Unknown';
        $detail->delete();

        $this->detailToDelete = null;
        $this->dispatch('notify', message: "Measurement for '{$registerNo}' has been deleted successfully!");
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    public function cancelDelete()
    {
        $this->detailToDelete = null;
        $this->dispatch('close-modal', 'delete-detail-modal');
    }

    /**
     * Generate PDF untuk print
     */
    public function printPDF()
    {
        if (!auth()->user()->can('view ground monitor box details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        // Validasi minimal satu filter dipilih
        if (empty($this->printRegisterNo) && empty($this->printArea) && empty($this->printLocation) && empty($this->printDateFrom) && empty($this->printDateUntil)) {
            $this->dispatch('notify', message: 'Please select at least one filter (Register No, Area, Location, or Date Range)!', type: 'error');
            return;
        }

        // Query data untuk print
        $query = GroundMonitorBoxDetail::with(['groundMonitorBox', 'creator']);

        // Filter by Register No
        if (!empty($this->printRegisterNo)) {
            $query->whereHas('groundMonitorBox', function ($q) {
                $q->where('register_no', 'like', '%' . $this->printRegisterNo . '%');
            });
        }

        // Filter by Area
        if (!empty($this->printArea)) {
            $query->whereHas('groundMonitorBox', function ($q) {
                $q->where('area', 'like', '%' . $this->printArea . '%');
            });
        }

        // Filter by Location
        if (!empty($this->printLocation)) {
            $query->whereHas('groundMonitorBox', function ($q) {
                $q->where('location', 'like', '%' . $this->printLocation . '%');
            });
        }

        // Filter by Date Range
        if (!empty($this->printDateFrom)) {
            $query->whereDate('created_at', '>=', $this->printDateFrom);
        }

        if (!empty($this->printDateUntil)) {
            $query->whereDate('created_at', '<=', $this->printDateUntil);
        }

        $details = $query->orderBy('created_at', 'desc')->get();

        if ($details->isEmpty()) {
            $this->dispatch('notify', message: 'No data found for the selected filters!', type: 'warning');
            return;
        }

        // Data untuk PDF
        $data = [
            'details' => $details,
            'title' => 'ESD GROUND MONITOR BOX MEASUREMENT REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'register_no' => $this->printRegisterNo,
            'area' => $this->printArea,
            'location' => $this->printLocation,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
            'prepared_by' => auth()->user()->name,
            'checked_by' => null,
            'approved_by' => null,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('livewire.esd.gb.ground-monitor-box-detail-pdf', $data);
        $pdf->setPaper('A4', 'landscape');
        
        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'ground-monitor-box-measurement-' . Carbon::now()->format('Ymd_His') . '.pdf'
        );
    }

    public function resetPrintFilters()
    {
        $this->printRegisterNo = '';
        $this->printArea = '';
        $this->printLocation = '';
        $this->printDateFrom = '';
        $this->printDateUntil = '';
        $this->printPreview = false;
        $this->dispatch('notify', message: 'Print filters have been reset!', type: 'success');
    }

    public function render()
    {
        if (!auth()->user()->can('view ground monitor box details')) {
            abort(403, 'Unauthorized access.');
        }

        $groundMonitorBoxes = GroundMonitorBox::orderBy('register_no')->get();
        
        $details = GroundMonitorBoxDetail::with(['groundMonitorBox', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('groundMonitorBox', function ($q) {
                    $q->where('register_no', 'like', '%' . $this->search . '%')
                        ->orWhere('area', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterGroundMonitorBox, function ($query) {
                $query->where('ground_monitor_box_id', $this->filterGroundMonitorBox);
            })
            ->when($this->filterArea, function ($query) {
                $query->whereHas('groundMonitorBox', function ($q) {
                    $q->where('area', 'like', '%' . $this->filterArea . '%');
                });
            })
            ->when($this->filterLocation, function ($query) {
                $query->whereHas('groundMonitorBox', function ($q) {
                    $q->where('location', 'like', '%' . $this->filterLocation . '%');
                });
            })
            ->when($this->filterG3, function ($query) {
                $query->where('g_3', $this->filterG3);
            })
            ->when($this->filterG4, function ($query) {
                $query->where('g_4', $this->filterG4);
            })
            ->when($this->filterDateFrom, function ($query) {
                $query->whereDate('created_at', '>=', $this->filterDateFrom);
            })
            ->when($this->filterDateUntil, function ($query) {
                $query->whereDate('created_at', '<=', $this->filterDateUntil);
            })
            ->when($this->filterNextDateFrom, function ($query) {
                $query->whereDate('next_date', '>=', $this->filterNextDateFrom);
            })
            ->when($this->filterNextDateUntil, function ($query) {
                $query->whereDate('next_date', '<=', $this->filterNextDateUntil);
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.esd.gb.ground-monitor-box-detail-management', [
            'details' => $details,
            'groundMonitorBoxes' => $groundMonitorBoxes,
        ]);
    }
}