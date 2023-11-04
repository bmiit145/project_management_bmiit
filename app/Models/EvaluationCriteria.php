<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    protected $table = 'evaluationcriteria';

    protected $fillable = [
        'name',
    ];

    public function evaluationMark()
    {
        return $this->hasMany(EvaluationMark::class , 'criteriaId' , 'id');
    }
}
