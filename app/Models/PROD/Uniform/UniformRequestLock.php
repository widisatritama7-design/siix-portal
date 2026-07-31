<?php

namespace App\Models\PROD\Uniform;

use Illuminate\Database\Eloquent\Model;

class UniformRequestLock extends Model
{
    protected $table = 'tb_prod_uniform_request_locks';
    
    protected $fillable = [
        'request_id', 'user_id', 'user_name', 'locked_at', 
        'expires_at', 'session_id'
    ];
    
    protected $casts = [
        'locked_at' => 'datetime',
        'expires_at' => 'datetime',
    ];
    
    public function isValid()
    {
        return $this->expires_at > now();
    }
}