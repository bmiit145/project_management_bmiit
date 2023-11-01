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

    public function studentGroup()
    {
        return $this->belongsTo(Group::class, 'studentgroupno', 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'facultyid', 'id');
    }
}
