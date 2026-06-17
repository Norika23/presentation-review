<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PresentationType extends Model
{
    protected $fillable = [
        'classroom_id',
        'name',
    ];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class);
    }

    public function presentations()
    {
        return $this->hasMany(Presentation::class);
    }
}
