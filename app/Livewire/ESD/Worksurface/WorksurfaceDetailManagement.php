<?php

namespace App\Livewire\ESD\Worksurface;

use App\Models\ESD\Worksurface\Worksurface;
use App\Models\ESD\Worksurface\WorksurfaceDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class WorksurfaceDetailManagement extends Component
{
    use WithPagination;

    public $detail_id;
    public $worksurface_id;
    public $register_no;
    public $area;
    public $location;
    public $layer_count;
    public $category;
    public $item;
    public $a1;
    public $a1_scientific;
    public $judgement_a1;
    public $a2;
    public $judgement_a2;
    public $a3;
    public $judgement_a3;
    public $a4_1;
    public $a4_2;
    public $a4_3;
    public $a4_4;
    public $a4_5;
    public $remarks;
    public $next_date;

    public $search = '';
    public $filterWorksurface = '';
    public $filterArea = '';
    public $filterLocation = '';
    public $filterItem = '';
    public $filterJudgementA1 = '';
    public $filterJudgementA2 = '';
    public $filterJudgementA3 = '';
    public $filterA4_1 = '';
    public $filterA4_2 = '';
    public $filterA4_3 = '';
    public $filterA4_4 = '';
    public $filterA4_5 = '';
    public $filterDateFrom = '';
    public $filterDateUntil = '';
    public $filterNextDateFrom = '';
    public $filterNextDateUntil = '';

    // Properti untuk print
    public $printPreview = false;
    public $printRegisterFilter = '';
    public $printAreaFilter = '';
    public $printLocationFilter = '';
    public $printItemFilter = '';
    public $printDateFrom = '';
    public $printDateUntil = '';

    public $worksurfaceSearch = '';
    public $showWorksurfaceDropdown = false;

    public $modalTitle = 'Add New Worksurface Measurement';
    public $detailToDelete = null;

    protected function rules()
    {
        return [
            'worksurface_id' => 'required|exists:tb_esd_worksurfaces,id',
            'item' => 'nullable|string|max:100',
            'a1' => 'nullable|numeric',
            'a2' => 'nullable|numeric',
            'a3' => 'nullable|numeric',
            'a4_1' => 'nullable|boolean',
            'a4_2' => 'nullable|boolean',
            'a4_3' => 'nullable|boolean',
            'a4_4' => 'nullable|boolean',
            'a4_5' => 'nullable|boolean',
            'remarks' => 'nullable|string|max:500',
            'next_date' => 'nullable|date',
        ];
    }

    protected $messages = [
        'worksurface_id.required' => 'Worksurface equipment is required.',
        'worksurface_id.exists' => 'Selected worksurface does not exist.',
        'item.string' => 'Item must be a string.',
        'item.max' => 'Item cannot exceed 100 characters.',
        'a1.numeric' => 'A1 measurement result must be a number.',
        'a2.numeric' => 'A2 measurement result must be a number.',
        'a3.numeric' => 'A3 measurement result must be a number.',
        'a4_1.boolean' => 'A4.1 must be Yes or No.',
        'a4_2.boolean' => 'A4.2 must be Yes or No.',
        'a4_3.boolean' => 'A4.3 must be Yes or No.',
        'a4_4.boolean' => 'A4.4 must be Yes or No.',
        'a4_5.boolean' => 'A4.5 must be Yes or No.',
        'next_date.date' => 'Next date must be a valid date.',
    ];


    public function selectWorksurface($id)
    {
        $this->worksurface_id = $id;
        $this->showWorksurfaceDropdown = false;

        // Trigger logika updatedWorksurfaceId
        $this->updatedWorksurfaceId($id);
    }

    public function clearWorksurface()
    {
        $this->worksurface_id = null;
        $this->worksurfaceSearch = '';
        $this->register_no = null;
        $this->area = null;
        $this->location = null;
        $this->layer_count = null;
        $this->category = null;
    }

    public function getFilteredWorksurfacesProperty()
    {
        $query = Worksurface::query();

        if (!empty($this->worksurfaceSearch)) {
            $term = '%' . $this->worksurfaceSearch . '%';
            $query->where(function ($q) use ($term) {
                $q->where('register_no', 'like', $term)
                    ->orWhere('area', 'like', $term)
                    ->orWhere('location', 'like', $term)
                    ->orWhere('category', 'like', $term);
            });
        }

        return $query->orderBy('register_no')->limit(50)->get();
    }
    /**
     * Generate PDF untuk print
     */
    public function printPDF()
    {
        if (!auth()->user()->can('view worksurface details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        if (
            empty($this->printRegisterFilter) && empty($this->printAreaFilter) &&
            empty($this->printLocationFilter) && empty($this->printItemFilter) &&
            empty($this->printDateFrom) && empty($this->printDateUntil)
        ) {
            $this->dispatch('notify', message: 'Please select at least one filter (Register No, Area, Location, Item, or Date Range)!', type: 'error');
            return;
        }

        $query = WorksurfaceDetail::with(['worksurface', 'creator']);

        if (!empty($this->printRegisterFilter)) {
            $query->whereHas('worksurface', function ($q) {
                $q->where('register_no', 'like', '%' . $this->printRegisterFilter . '%');
            });
        }

        if (!empty($this->printAreaFilter)) {
            $query->whereHas('worksurface', function ($q) {
                $q->where('area', 'like', '%' . $this->printAreaFilter . '%');
            });
        }

        if (!empty($this->printLocationFilter)) {
            $query->whereHas('worksurface', function ($q) {
                $q->where('location', 'like', '%' . $this->printLocationFilter . '%');
            });
        }

        if (!empty($this->printItemFilter)) {
            $query->where('item', 'like', '%' . $this->printItemFilter . '%');
        }

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

        $data = [
            'details' => $details,
            'title' => 'ESD WORK SURFACE MAT MEASUREMENT REPORT',
            'date_from' => $this->printDateFrom,
            'date_until' => $this->printDateUntil,
            'register_filter' => $this->printRegisterFilter,
            'area_filter' => $this->printAreaFilter,
            'location_filter' => $this->printLocationFilter,
            'item_filter' => $this->printItemFilter,
            'generated_by' => auth()->user()->name,
            'generated_at' => Carbon::now()->format('d M Y H:i:s'),
            'prepared_by' => auth()->user()->name,
            'checked_by' => null,
            'approved_by' => null,
        ];

        $pdf = Pdf::loadView('livewire.esd.worksurface.worksurface-detail-pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        return response()->streamDownload(
            function () use ($pdf) {
                echo $pdf->output();
            },
            'worksurface-measurement-' . Carbon::now()->format('Ymd_His') . '.pdf'
        );
    }

    public function resetPrintFilters()
    {
        $this->printRegisterFilter = '';
        $this->printAreaFilter = '';
        $this->printLocationFilter = '';
        $this->printItemFilter = '';
        $this->printDateFrom = '';
        $this->printDateUntil = '';
        $this->printPreview = false;
        $this->dispatch('notify', message: 'Print filters have been reset!', type: 'success');
    }

    public function mount()
    {
        $this->resetJudgements();
    }

    public function resetJudgements()
    {
        // A1 Judgement: < 1,000,000,000 is OK
        if ($this->a1 !== null && $this->a1 !== '') {
            $this->judgement_a1 = floatval($this->a1) < 1000000000 ? 'OK' : 'NG';
            $this->a1_scientific = sprintf('%.2E', floatval($this->a1));
        }

        // A2 Judgement: < 100 is OK
        if ($this->a2 !== null && $this->a2 !== '') {
            $this->judgement_a2 = floatval($this->a2) < 100 ? 'OK' : 'NG';
        }

        // A3 Judgement: < 100 is OK (Clear Acrylic Static Field Voltage)
        if ($this->a3 !== null && $this->a3 !== '') {
            $this->judgement_a3 = floatval($this->a3) < 100 ? 'OK' : 'NG';
        }
    }

    public function updatedA1()
    {
        $this->resetJudgements();
    }

    public function updatedA2()
    {
        $this->resetJudgements();
    }

    public function updatedA3()
    {
        $this->resetJudgements();
    }

    public function updatedWorksurfaceId($value)
    {
        if ($value) {
            $worksurface = Worksurface::find($value);
            if ($worksurface) {
                $this->register_no = $worksurface->register_no;
                $this->area = $worksurface->area;
                $this->location = $worksurface->location;
                $this->layer_count = $worksurface->layer_count;
                $this->category = $worksurface->category;
            }
        } else {
            $this->register_no = null;
            $this->area = null;
            $this->location = null;
            $this->layer_count = null;
            $this->category = null;
        }
    }

    public function resetForm()
    {
        $this->reset([
            'detail_id', 'worksurface_id', 'register_no', 'area', 'location', 'layer_count', 'category',
            'item', 'a1', 'a1_scientific', 'judgement_a1', 'a2', 'judgement_a2',
            'a3', 'judgement_a3', 'a4_1', 'a4_2', 'a4_3', 'a4_4', 'a4_5',
            'remarks', 'next_date'
        ]);

        // ✅ Reset search dropdown
        $this->worksurfaceSearch = '';
        $this->showWorksurfaceDropdown = false;

        $this->modalTitle = 'Add New Worksurface Measurement';
        $this->resetValidation();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'filterWorksurface', 'filterArea', 'filterLocation', 'filterItem',
            'filterJudgementA1', 'filterJudgementA2',
            'filterJudgementA3', 'filterA4_1', 'filterA4_2', 'filterA4_3', 'filterA4_4', 'filterA4_5',
            'filterDateFrom', 'filterDateUntil',
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
            if (!auth()->user()->can('edit worksurface details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        } else {
            if (!auth()->user()->can('create worksurface details')) {
                $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
                return;
            }
        }

        $this->validate();

        $this->resetJudgements();

        $data = [
            'worksurface_id' => $this->worksurface_id,
            'item' => strtoupper($this->item),
            'a1' => $this->a1,
            'a1_scientific' => $this->a1_scientific,
            'judgement_a1' => $this->judgement_a1,
            'a2' => $this->a2,
            'judgement_a2' => $this->judgement_a2,
            'a3' => $this->a3,
            'judgement_a3' => $this->judgement_a3,
            'a4_1' => $this->a4_1,
            'a4_2' => $this->a4_2,
            'a4_3' => $this->a4_3,
            'a4_4' => $this->a4_4,
            'a4_5' => $this->a4_5,
            'remarks' => $this->remarks,
            'next_date' => $this->next_date,
        ];

        if ($this->detail_id) {
            $detail = WorksurfaceDetail::find($this->detail_id);
            if (!$detail) {
                $this->dispatch('notify', message: 'Worksurface measurement not found!', type: 'error');
                return;
            }

            $detail->update($data);
            $message = 'Worksurface measurement updated successfully!';
        } else {
            WorksurfaceDetail::create($data);
            $message = 'Worksurface measurement created successfully!';
        }

        $this->resetForm();
        $this->dispatch('notify', message: $message);
        $this->dispatch('close-modal', 'detail-form-modal');
    }

    public function edit($id)
    {
        if (!auth()->user()->can('edit worksurface details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = WorksurfaceDetail::with('worksurface')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Worksurface measurement not found!', type: 'error');
            return;
        }

        $this->detail_id = $detail->id;
        $this->worksurface_id = $detail->worksurface_id;
        $this->register_no = $detail->worksurface->register_no ?? '';
        $this->area = $detail->worksurface->area ?? '';
        $this->location = $detail->worksurface->location ?? '';
        $this->layer_count = $detail->worksurface->layer_count ?? '';
        $this->category = $detail->worksurface->category ?? '';
        $this->item = $detail->item;
        $this->a1 = $detail->a1;
        $this->a1_scientific = $detail->a1_scientific;
        $this->judgement_a1 = $detail->judgement_a1;
        $this->a2 = $detail->a2;
        $this->judgement_a2 = $detail->judgement_a2;
        $this->a3 = $detail->a3;
        $this->judgement_a3 = $detail->judgement_a3;
        $this->a4_1 = $detail->a4_1;
        $this->a4_2 = $detail->a4_2;
        $this->a4_3 = $detail->a4_3;
        $this->a4_4 = $detail->a4_4;
        $this->a4_5 = $detail->a4_5;
        $this->remarks = $detail->remarks;
        $this->next_date = $detail->next_date ? Carbon::parse($detail->next_date)->format('Y-m-d') : null;
        $this->modalTitle = 'Edit Worksurface Measurement';
    }

    public function confirmDelete($id)
    {
        if (!auth()->user()->can('delete worksurface details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = WorksurfaceDetail::with('worksurface')->find($id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Worksurface measurement not found!', type: 'error');
            return;
        }

        $this->detailToDelete = $detail;
        $this->dispatch('open-modal', 'delete-detail-modal');
    }

    public function delete()
    {
        if (!auth()->user()->can('delete worksurface details')) {
            $this->dispatch('notify', message: 'You do not have permission!', type: 'error');
            return;
        }

        $detail = WorksurfaceDetail::find($this->detailToDelete->id);

        if (!$detail) {
            $this->dispatch('notify', message: 'Worksurface measurement not found!', type: 'error');
            $this->detailToDelete = null;
            return;
        }

        $registerNo = $detail->worksurface->register_no ?? 'Unknown';
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

    public function render()
    {
        if (!auth()->user()->can('view worksurface details')) {
            abort(403, 'Unauthorized access.');
        }

        $worksurfaces = Worksurface::orderBy('register_no')->get();

        $areas = Worksurface::select('area')->distinct()->orderBy('area')->pluck('area');
        $locations = Worksurface::select('location')->distinct()->orderBy('location')->pluck('location');
        $items = WorksurfaceDetail::select('item')->distinct()->orderBy('item')->pluck('item');

        $details = WorksurfaceDetail::with(['worksurface', 'creator'])
            ->when($this->search, function ($query) {
                $query->whereHas('worksurface', function ($q) {
                    $q->where('register_no', 'like', '%' . $this->search . '%')
                        ->orWhere('area', 'like', '%' . $this->search . '%')
                        ->orWhere('location', 'like', '%' . $this->search . '%')
                        ->orWhere('category', 'like', '%' . $this->search . '%');
                })->orWhere('item', 'like', '%' . $this->search . '%');
            })
            ->when($this->filterWorksurface, function ($query) {
                $query->where('worksurface_id', $this->filterWorksurface);
            })
            ->when($this->filterArea, function ($query) {
                $query->whereHas('worksurface', function ($q) {
                    $q->where('area', $this->filterArea);
                });
            })
            ->when($this->filterLocation, function ($query) {
                $query->whereHas('worksurface', function ($q) {
                    $q->where('location', $this->filterLocation);
                });
            })
            ->when($this->filterItem, function ($query) {
                $query->where('item', $this->filterItem);
            })
            ->when($this->filterJudgementA1, function ($query) {
                $query->where('judgement_a1', $this->filterJudgementA1);
            })
            ->when($this->filterJudgementA2, function ($query) {
                $query->where('judgement_a2', $this->filterJudgementA2);
            })
            ->when($this->filterJudgementA3, function ($query) {
                $query->where('judgement_a3', $this->filterJudgementA3);
            })
            ->when($this->filterA4_1 !== '', function ($query) {
                $query->where('a4_1', $this->filterA4_1);
            })
            ->when($this->filterA4_2 !== '', function ($query) {
                $query->where('a4_2', $this->filterA4_2);
            })
            ->when($this->filterA4_3 !== '', function ($query) {
                $query->where('a4_3', $this->filterA4_3);
            })
            ->when($this->filterA4_4 !== '', function ($query) {
                $query->where('a4_4', $this->filterA4_4);
            })
            ->when($this->filterA4_5 !== '', function ($query) {
                $query->where('a4_5', $this->filterA4_5);
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

        return view('livewire.esd.worksurface.worksurface-detail-management', [
            'details' => $details,
            'worksurfaces' => $worksurfaces,
            'areas' => $areas,
            'locations' => $locations,
            'items' => $items,
        ]);
    }
}