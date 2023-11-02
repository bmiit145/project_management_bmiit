<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panel extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
    ];

    public function presentationPanel()
    {
        return $this->hasMany(PresentationPanel::class , 'panelId' , 'id');
    }

    public function panelProjects()
    {
        return $this->hasMany(PanelProject::class , 'panelId' , 'id');
    }
}
