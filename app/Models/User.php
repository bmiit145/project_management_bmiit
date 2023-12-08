<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'password', 'role',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function userInfo()
    {
        if ($this->role == 0) {
            return $this->belongsTo(Student::class, 'username' , 'username');
        } elseif ($this->role == 2) {
            return $this->belongsTo(Faculty::class, 'username' , 'username');
        }
    }

    public function user()
    {
        if ($this->role == 0) {
            return $this->belongsTo(Student::class, 'username' , 'username');
        } elseif ($this->role == 2) {
            return $this->belongsTo(Faculty::class, 'username' , 'username');
        }
    }
}
