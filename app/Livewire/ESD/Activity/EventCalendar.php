<?php

namespace App\Livewire\ESD\Activity;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\ESD\Activity\Event;
use Illuminate\Support\Facades\Storage;

class EventCalendar extends Component
{
    use WithFileUploads;

    public $events = [];
    public $selectedDate = null;
    public $currentMonth = null;
    public $currentYear = null;
    
    // Form properties
    public $event_id;
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $start_time;
    public $end_time;
    public $color = 'blue';
    public $new_files = []; // File baru yang diupload
    public $existing_file = []; // File yang sudah ada
    public $files_to_remove = []; // Index file yang akan dihapus
    
    public $modalTitle = 'Add New Event';
    public $showModal = false;
    public $showDeleteModal = false;
    public $eventToDelete = null;

    public $wizardStep = 1;
    public $showPreviewModal = false;
    public $previewUrl = null;
    public $previewIsImage = false;

    protected function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'color' => 'required|string|in:red,yellow,green',
            'new_files.*' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,doc,docx,xlsx|max:10240',
        ];
    }

    protected function messages()
    {
        return [
            'title.required' => 'Title is required.',
            'start_date.required' => 'Start date is required.',
            'end_date.required' => 'End date is required.',
            'end_date.after_or_equal' => 'End date must be after or equal to start date.',
            'start_time.required' => 'Start time is required.',
            'end_time.required' => 'End time is required.',
            'color.required' => 'Status is required.',
            'color.in' => 'Status must be Open, On Progress, or Closed.',
            'new_files.*.mimes' => 'File must be an image or document.',
            'new_files.*.max' => 'File cannot exceed 10MB.',
        ];
    }

    public function mount()
    {
        $this->currentMonth = now()->month;
        $this->currentYear = now()->year;
        $this->selectedDate = now()->format('Y-m-d');
        $this->loadEvents();
    }

    // Method untuk wizard
    public function setWizardStep($step)
    {
        if ($step <= $this->wizardStep + 1 || $step <= $this->wizardStep) {
            $this->wizardStep = $step;
        }
    }

    public function nextStep()
    {
        if ($this->wizardStep < 3) {
            // Validasi untuk step 1 sebelum ke step 2
            if ($this->wizardStep == 1) {
                $this->validate([
                    'title' => 'required|string|max:255',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date',
                    'start_time' => 'required|string',
                    'end_time' => 'required|string',
                    'color' => 'required|string|in:red,yellow,green',
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

    public function previewAttachment($file)
    {
        $this->previewUrl = Storage::url($file);
        $this->previewIsImage = preg_match('/\.(jpg|jpeg|png|gif|webp)$/i', $file);
        $this->showPreviewModal = true;
    }

    public function loadEvents()
    {
        $this->events = Event::all()->map(function ($event) {
            // Decode file dengan benar
            $files = [];
            if ($event->file) {
                if (is_array($event->file)) {
                    $files = $event->file;
                } elseif (is_string($event->file)) {
                    // Bersihkan dari backslash escape
                    $cleaned = stripslashes($event->file);
                    $decoded = json_decode($cleaned, true);
                    $files = is_array($decoded) ? $decoded : [];
                }
            }
            
            return [
                'id' => $event->id,
                'title' => $event->title,
                'description' => $event->description,
                'color' => $event->color ?? 'blue',
                'start' => $event->start_at ? date('Y-m-d', strtotime($event->start_at)) : null,
                'end' => $event->end_at ? date('Y-m-d', strtotime($event->end_at)) : null,
                'start_time' => $event->start_at ? date('H:i', strtotime($event->start_at)) : '00:00',
                'end_time' => $event->end_at ? date('H:i', strtotime($event->end_at)) : '00:00',
                'file' => $files,
            ];
        })->toArray();
    }

    public function getBadgeColorForDate($date)
    {
        $dateEvents = array_filter($this->events, function ($event) use ($date) {
            return $date >= $event['start'] && $date <= $event['end'];
        });
        
        if (count($dateEvents) == 0) {
            return null;
        }
        
        $hasRed = false;
        $hasYellow = false;
        
        foreach ($dateEvents as $event) {
            $color = $event['color'] ?? 'blue';
            if ($color === 'red') $hasRed = true;
            if ($color === 'yellow') $hasYellow = true;
        }
        
        if ($hasRed) {
            return 'red';
        } elseif ($hasYellow) {
            return 'yellow';
        } else {
            return 'green';
        }
    }

    public function goToPrevMonth()
    {
        $date = \Carbon\Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function goToNextMonth()
    {
        $date = \Carbon\Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
    }

    public function resetForm()
    {
        $this->reset([
            'event_id', 'title', 'description', 'start_date', 'end_date',
            'start_time', 'end_time', 'color', 'new_files', 'existing_file', 'files_to_remove'
        ]);
        $this->color = 'blue';
        $this->modalTitle = 'Add New Event';
        $this->resetValidation();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->start_date = $this->selectedDate;
        $this->end_date = $this->selectedDate;
        $this->start_time = '08:00';
        $this->end_time = '17:00';
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $event = Event::find($id);
        if (!$event) {
            $this->dispatch('notify', message: 'Event not found!', type: 'error');
            return;
        }

        // Decode existing files
        $existingFiles = [];
        if ($event->file) {
            if (is_array($event->file)) {
                $existingFiles = $event->file;
            } elseif (is_string($event->file)) {
                $cleaned = stripslashes($event->file);
                $decoded = json_decode($cleaned, true);
                $existingFiles = is_array($decoded) ? $decoded : [];
            }
        }

        $this->event_id = $event->id;
        $this->title = $event->title;
        $this->description = $event->description;
        $this->start_date = $event->start_at ? date('Y-m-d', strtotime($event->start_at)) : null;
        $this->end_date = $event->end_at ? date('Y-m-d', strtotime($event->end_at)) : null;
        $this->start_time = $event->start_at ? date('H:i', strtotime($event->start_at)) : '08:00';
        $this->end_time = $event->end_at ? date('H:i', strtotime($event->end_at)) : '17:00';
        $this->color = $event->color ?? 'blue';
        $this->existing_file = $existingFiles;
        $this->files_to_remove = [];
        $this->modalTitle = 'Edit Event';
        $this->showModal = true;
    }

    public function removeFile($index)
    {
        if (isset($this->existing_file[$index])) {
            $fileToDelete = $this->existing_file[$index];
            // Hapus dari storage
            Storage::disk('public')->delete($fileToDelete);
            // Hapus dari array
            unset($this->existing_file[$index]);
            $this->existing_file = array_values($this->existing_file);
        }
    }

    public function save()
    {
        $this->validate();

        $startDateTime = $this->start_date . ' ' . $this->start_time;
        $endDateTime = $this->end_date . ' ' . $this->end_time;

        // Mulai dengan file yang sudah ada (yang tidak dihapus)
        $allFiles = $this->existing_file ?: [];
        
        // Upload file baru
        if ($this->new_files) {
            foreach ($this->new_files as $file) {
                // Generate nama file tanpa backslash dan karakter aneh
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $safeName = preg_replace('/[^a-zA-Z0-9]/', '_', $originalName);
                $fileName = time() . '_' . $safeName . '.' . $extension;
                $filePath = $file->storeAs('events', $fileName, 'public');
                $allFiles[] = $filePath;
            }
        }
        
        $data = [
            'title' => $this->title,
            'description' => $this->description,
            'start_at' => $startDateTime,
            'end_at' => $endDateTime,
            'color' => $this->color,
            'file' => json_encode(array_values($allFiles)), // Simpan sebagai JSON string
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

        $this->resetForm();
        $this->showModal = false;
        $this->loadEvents();
        $this->dispatch('notify', message: $message);
    }

    public function confirmDelete($id)
    {
        $this->eventToDelete = Event::find($id);
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if ($this->eventToDelete) {
            // Delete files from storage
            if ($this->eventToDelete->file) {
                $files = [];
                if (is_string($this->eventToDelete->file)) {
                    $cleaned = stripslashes($this->eventToDelete->file);
                    $files = json_decode($cleaned, true) ?: [];
                } elseif (is_array($this->eventToDelete->file)) {
                    $files = $this->eventToDelete->file;
                }
                
                foreach ($files as $file) {
                    if ($file && Storage::disk('public')->exists($file)) {
                        Storage::disk('public')->delete($file);
                    }
                }
            }
            
            $this->eventToDelete->delete();
            $this->dispatch('notify', message: 'Event deleted successfully!');
        }
        
        $this->showDeleteModal = false;
        $this->eventToDelete = null;
        $this->loadEvents();
    }

    public function getEventsForDate($date)
    {
        return array_filter($this->events, function ($event) use ($date) {
            return $date >= $event['start'] && $date <= $event['end'];
        });
    }

    public function render()
    {
        // Generate calendar data
        $firstDayOfMonth = \Carbon\Carbon::create($this->currentYear, $this->currentMonth, 1);
        $lastDayOfMonth = $firstDayOfMonth->copy()->endOfMonth();
        $startDay = $firstDayOfMonth->copy()->startOfWeek(\Carbon\Carbon::SUNDAY);
        $endDay   = $lastDayOfMonth->copy()->endOfWeek(\Carbon\Carbon::SUNDAY);
        
        $calendarWeeks = [];
        $currentDay = $startDay->copy();
        
        while ($currentDay <= $endDay) {
            $week = [];
            for ($i = 0; $i < 7; $i++) {
                $dateStr = $currentDay->format('Y-m-d');
                $isCurrentMonth = $currentDay->month == $this->currentMonth;
                $isSelected = $dateStr == $this->selectedDate;
                $isWeekend = $currentDay->isSunday() || $currentDay->isSaturday();
                $dayEvents = $this->getEventsForDate($dateStr);
                
                $week[] = [
                    'date' => $dateStr,
                    'day' => $currentDay->day,
                    'isCurrentMonth' => $isCurrentMonth,
                    'isSelected' => $isSelected,
                    'isWeekend' => $isWeekend,
                    'events' => array_values($dayEvents),
                    'eventCount' => count($dayEvents),
                    'badgeColor' => $this->getBadgeColorForDate($dateStr),
                ];
                $currentDay->addDay();
            }
            $calendarWeeks[] = $week;
        }

        // Get events for selected date
        $selectedDateEvents = $this->getEventsForDate($this->selectedDate);
        usort($selectedDateEvents, function ($a, $b) {
            return strcmp($a['start_time'], $b['start_time']);
        });

        return view('livewire.esd.activity.event-calendar', [
            'calendarWeeks' => $calendarWeeks,
            'currentMonthName' => $firstDayOfMonth->format('F Y'),
            'selectedDateEvents' => $selectedDateEvents,
            'selectedDateFormatted' => \Carbon\Carbon::parse($this->selectedDate)->format('l, d M Y'),
        ]);
    }
}