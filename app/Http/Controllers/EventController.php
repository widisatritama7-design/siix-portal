<?php

namespace App\Http\Controllers;

use App\Models\ESD\Activity\Event;
use Illuminate\Http\Request;
use Carbon\Carbon;

class EventController extends Controller
{
    public function index()
    {
        return view('livewire.esd.activity.event-calendar');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'color' => 'required|string',
        ]);
        
        // Gabungkan start date dan start time
        $startDateTime = $validated['start'] . ' ' . $validated['start_time'];
        $endDateTime = $validated['end'] . ' ' . $validated['end_time'];
        
        $event = Event::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_at' => $startDateTime,
            'end_at' => $endDateTime,
            'color' => $validated['color'],
        ]);

        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'required|date',
            'start_time' => 'required|string',
            'end_time' => 'required|string',
            'color' => 'required|string',
        ]);
        
        // Gabungkan start date dan start time
        $startDateTime = $validated['start'] . ' ' . $validated['start_time'];
        $endDateTime = $validated['end'] . ' ' . $validated['end_time'];
        
        $event->update([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'start_at' => $startDateTime,
            'end_at' => $endDateTime,
            'color' => $validated['color'],
        ]);

        return response()->json($event);
    }

    /**
     * Ambil semua event dalam format yang dibutuhkan frontend.
     */
    public function getEvents()
    {
        $events = Event::all();

        $formatted = $events->map(function ($event) {
            $startAt = $event->start_at ? Carbon::parse($event->start_at) : null;
            $endAt   = $event->end_at ? Carbon::parse($event->end_at) : null;

            // Handle file
            $file = $event->file ?? [];
            if (is_string($file)) {
                $file = json_decode($file, true) ?? [];
            }

            return [
                'id'          => $event->id,
                'title'       => $event->title,
                'description' => $event->description,
                'color'       => $event->color ?? 'blue',
                'start'       => $startAt ? $startAt->format('Y-m-d') : null,
                'end'         => $endAt ? $endAt->format('Y-m-d') : null,
                'start_time'  => $startAt ? $startAt->format('H:i') : '00:00',
                'end_time'    => $endAt ? $endAt->format('H:i') : '00:00',
                'file'        => $file,
            ];
        });

        return response()->json($formatted);
    }
}