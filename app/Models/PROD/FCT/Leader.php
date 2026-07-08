<?php

namespace App\Models\PROD\FCT;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leader extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_leaders';
    
    protected $fillable = [
        'employee_id',
        'name',
        'unlock_code',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public static function generateUniqueCode()
    {
        do {
            $code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (self::where('unlock_code', $code)->exists());
        
        return $code;
    }
}