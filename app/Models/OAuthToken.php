<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OAuthToken extends Model
{
    protected $table = 'o_auth_tokens';

    protected $fillable = [
        'provider',
        'access_token',
        'refresh_token',
        'expires_at',
        'email',
    ];

     protected $casts = [
        'expires_at' => 'datetime',
    ];
}
