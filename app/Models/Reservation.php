<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'machine_id',
        'start_time',
        'end_time',
        'weekly_session_limit_remaining',
    ];

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }
}