<?php

namespace App\Livewire\ESD\Activity;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use App\Models\ESD\Activity\Event;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class EventCalendar extends Component
{
    use WithFileUploads;
    use WithPagination;

    // ============ Form Properties ============
    public $event_id;
    public $title;
    public $description;
    public $type = 'Project';
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $color = 'green';
    public $new_files = [];
    public $existing_file = [];
    public $files_to_remove = [];

    // ============ UI State ============
    public $modalTitle = 'Add New Event';
    public $showModal = false;
    public $showDeleteModal = false;
    public $eventToDelete = null;
    public $wizardStep = 1;

    // ============ Preview State ============
    public $showPreviewModal = false;
    public $previewFiles = [];
    public $previewEventTitle = '';
    public $previewActiveIndex = 0;

    // ============ Filters ============
    public $search = '';
    public $filterType = '';
    public $filterStatus = '';
    public $filterDateFrom = '';
    public $filterDateTo = '';
    public $perPage = 10;

    protected $queryString = [
        'search'         => ['except' => ''],
        'filterType'     => ['except' => ''],
        'filterStatus'   => ['except' => ''],
        'filterDateFrom' => ['except' => ''],
        'filterDateTo'   => ['except' => ''],
        'perPage'        => ['except' => 10],
    ];

    // ============ Validation ============
    protected function rules()
    {
        return [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'type'        => 'required|string|in:' . implode(',', Event::TYPES),
            'start_date'  => 'required|date',
            'end_date'    => 'required|date|after_or_equal:start_date',
            'start_time'  => 'required|string',
            'end_time'    => 'required|string',
            'color'       => 'required|string|in:red,yellow,green',
            'new_files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xlsx|max:10240',
        ];
    }

    protected function messages()
    {
        return [
            'title.required'          => 'Title is required.',
            'type.required'           => 'Type is required.',
            'type.in'                 => 'Type must be one of: ' . implode(', ', Event::TYPES) . '.',
            'start_date.required'     => 'Start date is required.',
            'end_date.required'       => 'End date is required.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'start_time.required'     => 'Start time is required.',
            'end_time.required'       => 'End time is required.',
            'color.required'          => 'Status is required.',
            'color.in'                => 'Status must be Open, On Progress, or Closed.',
            'new_files.*.mimes'       => 'File must be an image or document.',
            'new_files.*.max'         => 'File cannot exceed 10MB.',
        ];
    }

    // ============ Mount ============
    public function mount()
    {
        $this->start_date = now()->format('Y-m-d');
        $this->end_date   = now()->format('Y-m-d');
        $this->start_time = '08:00';
        $this->end_time   = '17:00';
    }

    // ============ Helpers ============
    private function decodeFiles($fileAttr): array
    {
        if (!$fileAttr) return [];
        if (is_array($fileAttr)) return $fileAttr;
        if (is_string($fileAttr)) {
            $cleaned = stripslashes($fileAttr);
            $decoded = json_decode($cleaned, true);
            return is_array($decoded) ? $decoded : [];
        }
        return [];
    }

    // ============ Preview ============
    public function openPreviewModal($eventId, $index = 0)
    {
        $event = Event::find($eventId);
        if (!$event) {
            $this->dispatch('notify', message: 'Event not found!', type: 'error');
            return;
        }

        $files = $this->decodeFiles($event->file);
        if (empty($files)) {
            $this->dispatch('notify', message: 'No attachments found.', type: 'warning');
            return;
        }

        $this->previewFiles       = array_values($files);
        $this->previewEventTitle  = $event->title;
        $this->previewActiveIndex = min($index, count($this->previewFiles) - 1);
        $this->showPreviewModal   = true;
        $this->dispatch('open-event-preview-modal');
    }

    public function setPreviewIndex($index)
    {
        if (isset($this->previewFiles[$index])) {
            $this->previewActiveIndex = $index;
        }
    }

    public function closePreviewModal()
    {
        $this->showPreviewModal   = false;
        $this->previewFiles       = [];
        $this->previewActiveIndex = 0;
        $this->previewEventTitle  = '';
        $this->dispatch('close-event-preview-modal');
    }

    public function getPreviewFileUrlProperty(): ?string
    {
        $file = $this->previewFiles[$this->previewActiveIndex] ?? null;
        return $file ? Storage::url($file) : null;
    }

    public function getPreviewIsImageProperty(): bool
    {
        $file = $this->previewFiles[$this->previewActiveIndex] ?? null;
        return $file ? (bool) preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file) : false;
    }

    public function getPreviewFileNameProperty(): string
    {
        $file = $this->previewFiles[$this->previewActiveIndex] ?? '';
        return $file ? basename($file) : '';
    }

    // ============ Wizard ============
    public function setWizardStep($step)
    {
        if ($step <= $this->wizardStep + 1 || $step <= $this->wizardStep) {
            $this->wizardStep = $step;
        }
    }

    public function nextStep()
    {
        if ($this->wizardStep < 3) {
            if ($this->wizardStep == 1) {
                $this->validate([
                    'title'      => 'required|string|max:255',
                    'type'       => 'required|string|in:' . implode(',', Event::TYPES),
                    'start_date' => 'required|date',
                    'end_date'   => 'required|date|after_or_equal:start_date',
                    'start_time' => 'required|string',
                    'end_time'   => 'required|string',
                    'color'      => 'required|string|in:red,yellow,green',
                ]);
            }
            $this->wizardStep++;
        }
    }

    public function previousStep()
    {
        if ($this->wizardStep > 1) {
            $this->wizardStep--;
        }
    }

    // ============ Form ============
    public function resetForm()
    {
        $this->reset([
            'event_id', 'title', 'description', 'start_date', 'end_date',
            'start_time', 'end_time', 'color', 'new_files', 'existing_file', 'files_to_remove',
        ]);
        $this->type       = 'Project';
        $this->color      = 'green';
        $this->wizardStep = 1;
        $this->modalTitle = 'Add New Event';
        $this->resetValidation();
    }

    public function closeFormModal()
    {
        $this->showModal = false;
        $this->dispatch('close-event-form-modal');
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->start_date = now()->format('Y-m-d');
        $this->end_date   = now()->format('Y-m-d');
        $this->start_time = '08:00';
        $this->end_time   = '17:00';
        $this->showModal  = true;
        $this->dispatch('open-event-form-modal');
    }

    public function openEditModal($id)
    {
        $event = Event::find($id);
        if (!$event) {
            $this->dispatch('notify', message: 'Event not found!', type: 'error');
            return;
        }

        $this->event_id        = $event->id;
        $this->title           = $event->title;
        $this->description     = $event->description;
        $this->type            = $event->type ?? 'Project';
        $this->start_date      = $event->start_at ? $event->start_at->format('Y-m-d') : null;
        $this->end_date        = $event->end_at   ? $event->end_at->format('Y-m-d')   : null;
        $this->start_time      = $event->start_at ? $event->start_at->format('H:i')   : '08:00';
        $this->end_time        = $event->end_at   ? $event->end_at->format('H:i')     : '17:00';
        $this->color           = $event->color ?? 'green';
        $this->existing_file   = $this->decodeFiles($event->file);
        $this->files_to_remove = [];
        $this->modalTitle      = 'Edit Event';
        $this->wizardStep      = 1;
        $this->showModal       = true;
        $this->dispatch('open-event-form-modal');
    }

    public function removeFile($index)
    {
        if (isset($this->existing_file[$index])) {
            $this->files_to_remove[] = $this->existing_file[$index];
            unset($this->existing_file[$index]);
            $this->existing_file = array_values($this->existing_file);
        }
    }

    public function save()
    {
        $this->validate();

        $startDateTime = $this->start_date . ' ' . $this->start_time;
        $endDateTime   = $this->end_date   . ' ' . $this->end_time;

        $allFiles = $this->existing_file ?: [];

        if ($this->new_files) {
            foreach ($this->new_files as $file) {
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension    = $file->getClientOriginalExtension();
                $safeName     = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName);
                $fileName     = time() . '_' . $safeName . '.' . $extension;
                $filePath     = $file->storeAs('events', $fileName, 'public');
                $allFiles[]   = $filePath;
            }
        }

        $data = [
            'title'       => $this->title,
            'description' => $this->description,
            'type'        => $this->type,
            'start_at'    => $startDateTime,
            'end_at'      => $endDateTime,
            'color'       => $this->color,
            'file'        => array_values(array_filter($allFiles, function ($file) {
                return !empty($file) && Storage::disk('public')->exists($file);
            })),
        ];

        if ($this->event_id) {
            $event = Event::find($this->event_id);
            if (!$event) {
                $this->dispatch('notify', message: 'Event not found!', type: 'error');
                return;
            }
            $event->update($data);
            $message = 'Event updated successfully!';
        } else {
            Event::create($data);
            $message = 'Event created successfully!';
        }

        if (!empty($this->files_to_remove)) {
            foreach ($this->files_to_remove as $f) {
                if ($f && Storage::disk('public')->exists($f)) {
                    Storage::disk('public')->delete($f);
                }
            }
        }

        $this->resetForm();
        $this->showModal = false;
        $this->dispatch('close-event-form-modal');
        $this->dispatch('notify', message: $message);
    }

    // ============ Delete ============
    public function confirmDelete($id)
    {
        $this->eventToDelete   = Event::find($id);
        $this->showDeleteModal = true;
        $this->dispatch('open-event-delete-modal');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->eventToDelete   = null;
        $this->dispatch('close-event-delete-modal');
    }

    public function delete()
    {
        if ($this->eventToDelete) {
            $files = $this->decodeFiles($this->eventToDelete->file);
            foreach ($files as $file) {
                if ($file && Storage::disk('public')->exists($file)) {
                    Storage::disk('public')->delete($file);
                }
            }
            $this->eventToDelete->delete();
            $this->dispatch('notify', message: 'Event deleted successfully!');
        }
        $this->showDeleteModal = false;
        $this->eventToDelete   = null;
        $this->dispatch('close-event-delete-modal');
    }

    // ============ Filters ============
    public function updatingSearch()       { $this->resetPage(); }
    public function updatingFilterType()   { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }
    public function updatingPerPage()      { $this->resetPage(); }

    public function updatingFilterDateFrom()
    {
        if ($this->filterDateFrom && !strtotime($this->filterDateFrom)) {
            $this->filterDateFrom = '';
        }
        $this->resetPage();
    }

    public function updatingFilterDateTo()
    {
        if ($this->filterDateTo && !strtotime($this->filterDateTo)) {
            $this->filterDateTo = '';
        }
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterType', 'filterStatus', 'filterDateFrom', 'filterDateTo', 'perPage']);
        $this->perPage = 10;
        $this->resetPage();
    }

    // ============ Query ============
    private function buildQuery()
    {
        return Event::query()
            ->search($this->search)
            ->ofType($this->filterType)
            ->ofStatus($this->filterStatus)
            ->betweenDates($this->filterDateFrom, $this->filterDateTo);
    }

    public function getEventsProperty()
    {
        return $this->buildQuery()
            ->orderBy('start_at', 'desc')
            ->paginate($this->perPage);
    }

    // ============ PDF ============
    public function exportPdf()
    {
        $events = $this->buildQuery()->orderBy('start_at', 'desc')->get();

        $pdf = Pdf::loadView('livewire.esd.activity.event-pdf', [
            'events'         => $events,
            'filterType'     => $this->filterType,
            'filterStatus'   => $this->filterStatus,
            'filterDateFrom' => $this->filterDateFrom,
            'filterDateTo'   => $this->filterDateTo,
            'search'         => $this->search,
            'generatedAt'    => now()->format('d M Y H:i'),
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'events-' . now()->format('Ymd-His') . '.pdf');
    }

    // ============ Render ============
    public function render()
    {
        return view('livewire.esd.activity.event-calendar', [
            'events' => $this->events,
            'types'  => Event::TYPES,
        ]);
    }
}