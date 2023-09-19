<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'code' , 'name',
    ];
    
    public function programsemesters()
    {
        return $this->hasMany(ProgramSemester::class , 'code' , 'programCode');
    }
}
