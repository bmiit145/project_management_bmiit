<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'programsemesterid',
    ];


    public function programsemester()
    {
        return $this->belongsTo(ProgramSemester::class , 'programsemesterid' , 'id');
    }

}
