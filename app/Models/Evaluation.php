<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'student_id',
        'reviewer_name',
        'content_score',
        'english_score',
        'delivery_score',
        'communication_score',
        'good_point',
        'advice',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function getTotalScoreAttribute()
    {
        return $this->content_score
            + $this->english_score
            + $this->delivery_score
            + $this->communication_score;
    }
}
