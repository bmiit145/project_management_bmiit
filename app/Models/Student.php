<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'enro' , 'fname','lname' , 'contactno' , 'email' , 'username' , 'status' , 'courseYearId'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function courseYear()
    {
        return $this->belongsTo(CourseYear::class, 'courseYearId', 'id');
    }

    public function studentGroups()
    {
        return $this->hasMany(StudentGroup::class, 'studentenro', 'enro');
    }


}
