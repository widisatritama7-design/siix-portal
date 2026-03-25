<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'icon',
        'color',
        'message',
        'button_text',
        'button_url',
        'is_active',
        'display_order'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer'
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }

    // Helper untuk mendapatkan class warna
    public function getColorClasses()
    {
        return match($this->color) {
            'yellow' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
            'blue' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
            'green' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
            'red' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
            'purple' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
            'pink' => 'bg-pink-100 text-pink-800 dark:bg-pink-900 dark:text-pink-200',
            'indigo' => 'bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-200',
            'gray' => 'bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-300',
            default => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
        };
    }

    public function getIconColorClasses()
    {
        return match($this->color) {
            'yellow' => 'text-yellow-600 dark:text-yellow-400',
            'blue' => 'text-blue-600 dark:text-blue-400',
            'green' => 'text-green-600 dark:text-green-400',
            'red' => 'text-red-600 dark:text-red-400',
            'purple' => 'text-purple-600 dark:text-purple-400',
            'pink' => 'text-pink-600 dark:text-pink-400',
            'indigo' => 'text-indigo-600 dark:text-indigo-400',
            'gray' => 'text-gray-600 dark:text-gray-400',
            default => 'text-yellow-600 dark:text-yellow-400',
        };
    }
}