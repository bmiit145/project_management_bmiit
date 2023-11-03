<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationMark extends Model
{
    use HasFactory;

    protected $fillable = [
        'criteriaId',
        'outof',
        'courseYearId',
    ];

    public function evaluationCriteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criteriaId' , 'id');
    }

    public function courseYear()
    {
        return $this->belongsTo(CourseYear::class, 'courseYearId' , 'id');
    }
}
