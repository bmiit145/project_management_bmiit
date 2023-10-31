<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'courseYearId'
    ];

    public function courseYear()
    {
        return $this->belongsTo(CourseYear::class , 'courseYearId' , 'id');
    }

    public function committeeMember()
    {
        return $this->hasMany(CommitteeMember::class , 'committee_id' , 'id');
    }
}


