<?php

namespace App\Models\ESD\Activity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_events';

    protected $fillable = [
        'title',
        'description',
        'type',
        'file',
        'color',
        'start_at',
        'end_at',
    ];

    protected $casts = [
        'file' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * Available event types.
     */
    public const TYPES = [
        'Abnormality',
        'Project',
        'Daily Measurement',
        'Repair',
        'Cleaning',
        'Ticketing Support Request',
    ];

    /**
     * Available status colors (mapped to labels in UI).
     */
    public const COLORS = [
        'red'    => 'Open',
        'yellow' => 'On Progress',
        'green'  => 'Closed',
    ];

    /**
     * Accessor: human-readable status label.
     */
    public function getStatusLabelAttribute(): string
    {
        return self::COLORS[$this->color] ?? 'Unknown';
    }

    /**
     * Accessor: count of attached files.
     */
    public function getFileCountAttribute(): int
    {
        return is_array($this->file) ? count($this->file) : 0;
    }

    /**
     * Scope: filter by type.
     */
    public function scopeOfType($query, ?string $type)
    {
        return $type ? $query->where('type', $type) : $query;
    }

    /**
     * Scope: filter by status color.
     */
    public function scopeOfStatus($query, ?string $status)
    {
        return $status ? $query->where('color', $status) : $query;
    }

    /**
     * Scope: filter by date range (overlap with start_at/end_at).
     */
    public function scopeBetweenDates($query, ?string $from, ?string $to)
    {
        if ($from) {
            $query->whereDate('start_at', '>=', $from);
        }
        if ($to) {
            $query->whereDate('end_at', '<=', $to);
        }
        return $query;
    }

    /**
     * Scope: search title or description.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!$term) {
            return $query;
        }
        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', '%' . $term . '%')
              ->orWhere('description', 'like', '%' . $term . '%');
        });
    }
}