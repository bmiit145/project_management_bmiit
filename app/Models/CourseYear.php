<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'year_id',
//        'status',
    ];


    public function course()
    {
        return $this->belongsTo(Course::class , 'course_id' , 'id');
    }

    public function year()
    {
        return $this->belongsTo(academicyear::class , 'year_id' , 'id');
    }

    public  function committee()
    {
        return $this->hasMany(Committee::class , 'courseYearId' , 'id');
    }

    public function schedule()
    {
        return $this->hasMany(Schedule::class);
    }

    public function presentationPanel()
    {
        return $this->hasMany(PresentationPanel::class);
    }

    public function evaluationMark()
    {
        return $this->hasMany(EvaluationMark::class);
    }

}
