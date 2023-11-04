<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramSemester extends Model
{
    use HasFactory;
    protected $fillable = ['programCode', 'semesterid'];



    public function program()
    {
        return $this->belongsTo(Program::class , 'programCode' , 'code');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class , 'semesterid' , 'id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class , 'programSemesterId' , 'id');
    }

}
