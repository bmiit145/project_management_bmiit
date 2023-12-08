<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        'enro' , 'fname','lname' , 'contactno' , 'email' , 'username' , 'status' , 'programId'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'programId', 'id');
    }

    public function studentGroups()
    {
        return $this->hasMany(StudentGroup::class, 'studentenro', 'enro');
    }

    public function groups()
    {
        return $this->belongsToMany(Group::class, 'student_groups', 'studentenro', 'groupid');
    }

    public function panddingGroups()
    {
        return $this->hasMany(PanddingGroups::class, 'studentenro', 'enro');
    }

    public function userInfo()
    {
        return $this->hasOne(User::class, 'username', 'username');
    }
}
