<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresentationPanel extends Model
{
    use HasFactory;

    protected $fillable = [
        'panelId',
        'facultyId',
        'courseYearId',
    ];

    public function panel()
    {
        return $this->belongsTo(Panel::class , 'panelId' , 'id');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class , 'facultyId' , 'id');
    }

    public function courseYear()
    {
        return $this->belongsTo(CourseYear::class , 'courseYearId' , 'id');
    }

    public function panelProjects()
    {
        return $this->hasMany(PanelProject::class , 'panelId' , 'panelId');
    }
}
