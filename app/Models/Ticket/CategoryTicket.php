<?php

namespace App\Models\Ticket;

use App\Models\Ticket\Ticket;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTicket extends Model
{
    use HasFactory;

    protected $table = 'tb_tc_category_tickets';

    protected $fillable = [
        'name',
        'description',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'category_id');
    }
}
