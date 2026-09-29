<?php

namespace App\Models\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Model as BlindTestModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $table = 'tb_qaqc_question';

    protected $fillable = [
        'customer_id',
        'model_id',
        'section',
        'items',
        'question_text',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'items' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function blindTests(): HasMany
    {
        return $this->hasMany(BlindTest::class, 'question_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Model utama (legacy, tetap dipakai untuk backward-compat)
    public function model(): BelongsTo
    {
        return $this->belongsTo(BlindTestModel::class, 'model_id');
    }

    // 👇 BARU: relasi many-to-many ke model
    public function models(): BelongsToMany
    {
        return $this->belongsToMany(
            BlindTestModel::class,
            'tb_qaqc_question_model',
            'question_id',
            'model_id'
        )->withTimestamps();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Cek apakah question ini sudah dipakai di blind test.
     */
    public function isUsed(): bool
    {
        return $this->blindTests()->exists();
    }

    /**
     * Hitung berapa kali question ini dipakai.
     */
    public function usageCount(): int
    {
        return $this->blindTests()->count();
    }

    /**
     * Total defect overall (semua model digabung).
     * Support format lama (flat) & format baru (group per model).
     */
    public function totalDefects(): int
    {
        $items = $this->items ?? [];

        // Format baru (per-model group)
        if (!empty($items) && isset($items[0]['model_id'])) {
            return collect($items)->sum(fn($g) => count($g['items'] ?? []));
        }

        // Format lama (flat array)
        return count($items);
    }
}