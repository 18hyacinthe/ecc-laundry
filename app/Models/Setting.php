<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    public static function getSetting($key, $default = null)
    {
        return static::where('key', $key)->first()->value ?? $default;
    }

    protected $hidden = [
        'id',
        'key',
        'value',
        'created_at',
        'updated_at'
    ];
}
