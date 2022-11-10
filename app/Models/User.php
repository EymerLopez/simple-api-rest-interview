<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable;
    use Authorizable;
    use HasFactory;
    use HasUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'token', 'token_expiration',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password', 'token',
    ];

    protected $casts = [
        'token_expiration' => 'datetime',
    ];

    public function isTokenExpired(): bool
    {
        if (!$this->token_expiration || !$this->token) {
            return true;
        }

        if (date_create('now') > $this->token_expiration) {
            return true;
        }

        return false;
    }
}
