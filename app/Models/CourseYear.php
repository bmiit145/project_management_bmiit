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
        return $this->belongsTo(Course::class);
    }

    public function year()
    {
        return $this->belongsTo(academicyear::class);
    }

    public  function committee()
    {
        return $this->hasMany(Committee::class);
    }


}
