<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password_reset extends Model
{

    use HasFactory;

    protected $fillable = [
         'email' , 'token'
    ];

}
