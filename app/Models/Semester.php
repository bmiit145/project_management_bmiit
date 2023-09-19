<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    
    protected $fillable = ['name'];

    public function programsemesters()
    {
        return $this->hasMany(ProgramSemester::class , 'id' , 'semesterid');
    }
}
