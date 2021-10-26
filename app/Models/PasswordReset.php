<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasswordReset extends AppModel
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'email',
        'token',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
