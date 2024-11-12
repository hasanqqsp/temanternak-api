<?php

namespace App\Infrastructure\Repository\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Illuminate\Foundation\Auth\Access\Authorizable;
use MongoDB\Laravel\Eloquent\DocumentModel;
use MongoDB\Laravel\Eloquent\Model;

class AuthUser extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail, DocumentModel;
    protected $keyType = 'string';
}
