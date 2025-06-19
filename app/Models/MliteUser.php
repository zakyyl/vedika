<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class MliteUser extends Authenticatable
{
    use Notifiable;

    protected $table = 'mlite_users';
    protected $primaryKey = 'id'; 
    public $timestamps = false;

    protected $fillable = [
        'username',
        'fullname',
        'password',
        'role',
        'access',
    ];

    protected $hidden = ['password'];
}

