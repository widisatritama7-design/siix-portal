<?php

namespace App\Models\ESD\Garment;

use App\Models\ESD\Garment\GarmentDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Garment extends Model 
{
    use HasFactory;

    protected $table = 'tb_hr_employee';

    protected $fillable = [
        'id',
        'nik',
        'name',
        'department',
        'email',
        'status',
        'contract_date',
        'in_date',
        'last_group',
        'last_job',
        'last_route',
        'photo',        
    ];

    protected $primaryKey = 'id';

    public $timestamps = false;

    public function setAttribute($key, $value)
    {
        return null;
    }

    public function garmentDetails()
    {
        return $this->hasMany(GarmentDetail::class, 'nik', 'id');
    }
}
