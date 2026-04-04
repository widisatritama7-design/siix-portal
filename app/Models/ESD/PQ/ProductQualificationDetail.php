<?php

namespace App\Models\ESD\PQ;

use App\Models\ESD\PQ\ProductQualification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ProductQualificationDetail extends Model
{
    use HasFactory;

    protected $table = 'tb_esd_product_qualification_details';

    protected $fillable = [
        'product_qualification_id',
        'supplier_name',
        'description',
        'data_sheet',
        'test_report',
        'status',
    ];

    public function productQualification()
    {
        return $this->belongsTo(ProductQualification::class, 'product_qualification_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = Auth::id();
        });

        static::updating(function ($model) {
            $model->updated_by = Auth::id();
        });
    }
}
