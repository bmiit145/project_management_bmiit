<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'studentenro',
        'groupid',
        'courseYearId',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentenro', 'enro');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'groupid', 'id');
    }

    public function courseYear()
    {
        return $this->belongsTo(CourseYear::class, 'courseYearId', 'id');
    }

    public function allocation()
    {
        return $this->hasOne(Allocation::class, 'studentgroupno', 'groupid');
    }
}
