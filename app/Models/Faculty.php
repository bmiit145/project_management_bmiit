<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
         'fname','lname' , 'contactno' , 'email' , 'doj' , 'designation' ,'username' ,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'username', 'username');
    }

    public function committeeMember()
    {
        return $this->hasMany(CommitteeMember::class , 'faculty_id' , 'id');
    }

    public function allocations()
    {
        return $this->hasMany(Allocation::class, 'facultyid', 'id');
    }

    public function presentationPanel()
    {
        return $this->hasMany(PresentationPanel::class , 'facultyId' , 'id');
    }

    public function userInfo()
    {
        return $this->hasOne(User::class, 'username', 'username');
    }
}
