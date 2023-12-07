<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RejectGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'groupNumber',
        'studentenro',
        'courseYearId',
        'title',
        'definition',
        'created_by',
    ];

    public function courseYear()
    {
        return $this->belongsTo(CourseYear::class, 'courseYearId', 'id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'studentenro', 'enro');
    }

    public function panddingGroups()
    {
        return $this->hasMany(PanddingGroups::class, 'groupNumber', 'groupNumber');
    }

    public function panddingGroup()
    {
        return $this->belongsTo(PanddingGroups::class, 'groupNumber', 'groupNumber');
    }
}
