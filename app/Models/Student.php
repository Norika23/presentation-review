<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'presentation_id',
        'name',
        'result_token',
    ];

    public function presentation()
    {
        return $this->belongsTo(Presentation::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}
