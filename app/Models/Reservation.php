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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $hidden = [
        // 'id',
        'user_id',
        'machine_id',
        'start_time',
        'end_time',
        'notified_start',
        'notified_end',
        'weekly_session_limit_remaining',
        'created_at',
        'updated_at',
    ];
}
