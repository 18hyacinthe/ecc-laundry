<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Machine extends Model
{
    protected $fillable = ['name', 'status', 'type'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }

    public function reclamations(): HasMany
    {
        return $this->hasMany(Reclamation::class);
    }

    // protected $hidden = [
    //     // 'id',
    //     // 'name',
    //     'status',
    //     // 'type',
    //     'color',
    //     'created_at',
    //     'updated_at'
    // ];
}
