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
}
