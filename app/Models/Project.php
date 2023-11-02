<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'definition',
        'groupId',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'groupId', 'id');
    }

}
