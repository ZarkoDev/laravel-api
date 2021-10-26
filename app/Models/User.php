<?php

namespace App\Models;

use App\Notifications\CustomResetPassword;
use App\Http\Traits\AuthTrait;
use Illuminate\Auth\Authenticatable as AuthAuthenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\CanResetPassword as AuthCanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class User extends AppModel implements Authenticatable, AuthCanResetPassword
{
    use AuthTrait, AuthAuthenticatable, HasFactory, CanResetPassword, Notifiable;

    protected $fillable = [
        'email',
        'password',
        'token',
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = $this->generatePassword($value);
        $this->attributes['token'] = $this->generateNewLoginToken();
    }

    public function setNewToken()
    {
        $this->token = $this->generateNewLoginToken();
        $this->save();
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new CustomResetPassword($token));
    }

    public function hasValidEmail()
    {
        // more validates can be made
        return empty($this->email);
    }

    public function jobTasks()
    {
        return $this->hasMany('App\Model\JobTask', 'user_id');
    }
}
