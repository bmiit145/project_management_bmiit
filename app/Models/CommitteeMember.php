<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommitteeMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'faculty_id',
        'type',
        'committee_id',
    ];

    public function faculty()
    {
        return $this->belongsTo(Faculty::class , 'faculty_id' , 'id');
    }

    public function committee()
    {
        return $this->belongsTo(Committee::class , 'committee_id' , 'id');
    }
}
