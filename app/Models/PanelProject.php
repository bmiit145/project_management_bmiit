<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanelProject extends Model
{
    use HasFactory;

    protected $fillable = [
        'panelId',
        'groupId',
    ];

    public function panel()
    {
        return $this->belongsTo(Panel::class , 'panelId' , 'id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class , 'groupId' , 'id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class , 'groupId' , 'groupId');
    }

    public function presentationPanel()
    {
        return $this->belongsTo(PresentationPanel::class , 'panelId' , 'panelId');
    }
}
