<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'studentgroupno',
        'facultyid',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'studentgroupno', 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'studentgroupno', 'groupid');
    }

    public function studentGroups()
    {
        return $this->belongsTo(StudentGroup::class, 'studentgroupno', 'groupid');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'facultyid', 'id');
    }
}
