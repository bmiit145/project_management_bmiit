<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'created_by',
        'updated_by',
    ];

    public function students()
    {
        return $this->hasMany(StudentGroup::class, 'group_id', 'id');
    }

    public function studentGroups()
    {
        return $this->hasMany(StudentGroup::class, 'groupid', 'id');
    }

    public function allocation()
    {
        return $this->hasOne(Allocation::class, 'studentgroupno', 'id');
    }

    public function project()
    {
        return $this->hasOne(Project::class, 'groupId', 'id');
    }

    public function panelProjects()
    {
        return $this->hasMany(PanelProject::class , 'groupId' , 'id');
    }

    public function presentationPanel()
    {
        return $this->hasMany(PresentationPanel::class , 'groupId' , 'id');
    }
}
