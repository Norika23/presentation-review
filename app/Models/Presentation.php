<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presentation extends Model
{
    protected $fillable = [
        'presentation_type_id',
        'title',
        'token',
    ];

    public function presentationType()
    {
        return $this->belongsTo(PresentationType::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
