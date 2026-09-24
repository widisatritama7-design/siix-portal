<?php

namespace App\Models\QAQC\BlindTest;

use App\Models\QAQC\BlindTest\BlindTest;
use App\Models\QAQC\BlindTest\Model as BlindTestModel;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    // 👇 Pakai alias
    public function model(): BelongsTo
    {
        return $this->belongsTo(BlindTestModel::class, 'model_id');
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
}