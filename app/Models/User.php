<?php

namespace App\Models;

use App\Http\Traits\AuthTrait;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends AppModel implements Authenticatable
{
    use AuthTrait, AuthAuthenticatable, HasFactory;

    protected $fillable = [
        'email',
        'password',
    ];

    // protected $hidden = [
    //     'password',
    // ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $this->generatePassword($value);
    }

    public function setNewToken()
    {
        $this->token = $this->generateNewToken();
        $this->save();
    }
}
