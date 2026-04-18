<?php

namespace App\Models\PROD\WIP;

use App\Models\PROD\WIP\MasterWip;
use App\Models\PROD\WIP\RackLosePack;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class DetailWip extends Model
{
    use HasFactory;

    protected $table = 'tb_prod_detail_wips';

    protected $fillable = [
        'master_wips_id', 
        'qty', 
        'acm', 
        'balance',
        'status', 
        'no_hu',
        'ng_count', 
        'no_hu_2',
        'remarks', 
        'created_by', 
        'updated_by',
        'no_box',
        'rack_lose_pack_id'
    ];

    protected $casts = [
        'qty' => 'array',
        'ng_count' => 'array',
        'no_hu' => 'array',
    ];
    
     public function getNoHuTextAttribute()
     {
         $value = $this->attributes['no_hu'] ?? null;
         
         if (is_null($value)) {
             return '';
         }
         
         if (is_array($this->no_hu)) {
             if (count($this->no_hu) === 1) {
                 return (string) reset($this->no_hu);
             }
             return implode(', ', $this->no_hu);
         }
         
         $decoded = json_decode($value, true);
         if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
             if (count($decoded) === 1) {
                 return (string) reset($decoded);
             }
             return implode(', ', $decoded);
         }
         
         return (string) $value;
     }

     public function getQtyTextAttribute()
     {
         $value = $this->attributes['qty'] ?? null;
         
         if (is_null($value)) {
             return '0';
         }
         
         if (is_array($this->qty)) {
             if (count($this->qty) === 1) {
                 return (string) reset($this->qty);
             }
             return implode(', ', $this->qty);
         }
         
         $decoded = json_decode($value, true);
         if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
             if (count($decoded) === 1) {
                 return (string) reset($decoded);
             }
             return implode(', ', $decoded);
         }
         
         return (string) $value;
     }

     public function getNgCountTextAttribute()
     {
         $value = $this->attributes['ng_count'] ?? null;
         
         if (is_null($value)) {
             return '0';
         }
         
         if (is_array($this->ng_count)) {
             if (count($this->ng_count) === 1) {
                 return (string) reset($this->ng_count);
             }
             return implode(', ', $this->ng_count);
         }
         
         $decoded = json_decode($value, true);
         if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
             if (count($decoded) === 1) {
                 return (string) reset($decoded);
             }
             return implode(', ', $decoded);
         }
         
         return (string) $value;
    }
    
    public function getNoHuFirstAttribute()
    {
        $text = $this->no_hu_text;
        $parts = explode(', ', $text);
        return $parts[0] ?? '';
    }

    public function getQtyFirstAttribute()
    {
        $text = $this->qty_text;
        $parts = explode(', ', $text);
        return $parts[0] ?? '0';
    }

    public function getNgCountFirstAttribute()
    {
        $text = $this->ng_count_text;
        $parts = explode(', ', $text);
        return $parts[0] ?? '0';
    }

    public function setNoHuAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['no_hu'] = json_encode($value);
        } elseif ($this->isJson($value)) {
            $this->attributes['no_hu'] = $value;
        } else {
            $this->attributes['no_hu'] = $value;
        }
    }

    public function setQtyAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['qty'] = json_encode($value);
        } elseif ($this->isJson($value)) {
            $this->attributes['qty'] = $value;
        } else {
            $this->attributes['qty'] = $value;
        }
    }

    public function setNgCountAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['ng_count'] = json_encode($value);
        } elseif ($this->isJson($value)) {
            $this->attributes['ng_count'] = $value;
        } else {
            $this->attributes['ng_count'] = $value;
        }
    }

    private function isJson($string)
    {
        if (!is_string($string)) {
            return false;
        }
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }

    public function rackLosePack()
    {
        return $this->belongsTo(RackLosePack::class, 'rack_lose_pack_id');
    }
    
    public function masterWip()
    {
        return $this->belongsTo(MasterWip::class, 'master_wips_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function updateRack($rackId)
    {
        $this->update([
            'rack_lose_pack_id' => $rackId,
            'updated_by' => Auth::id()
        ]);
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