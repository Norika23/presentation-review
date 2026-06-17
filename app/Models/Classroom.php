<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = [
        'name',
    ];

    public function presentationTypes()
    {
        return $this->hasMany(PresentationType::class);
    }

    public function presentations()
    {
        return $this->hasManyThrough(Presentation::class, PresentationType::class);
    }
}
