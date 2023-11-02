<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'datetime',
        'assessmenttype',
        'courseYearId',
    ];

    public function courseYear()
    {
        return $this->belongsTo(CourseYear::class , 'courseYearId' , 'id');
    }

}
