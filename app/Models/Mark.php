<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mark extends Model
{
    use HasFactory;

    protected $fillable = [
        'groupId',
        'evaluationMarkId',
        'marks',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class , 'groupId' , 'id');
    }

    public function evaluationMark()
    {
        return $this->belongsTo(EvaluationMark::class , 'evaluationMarkId' , 'id');
    }

}
