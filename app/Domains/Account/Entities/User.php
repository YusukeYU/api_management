<?php

namespace App\Domains\Account\Entities;

use App\Modules\Account\Mails\MailResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject, MustVerifyEmail

{
    use Notifiable, SoftDeletes;

    public $module = 'account';

    protected $table = 'users';

    protected $guarded = [];

    protected $fillable = [
        'id',
        'login',
        'document',
        'password',
        'email_verified_at',
        'name',
        'email',
        'logged_at',
        'created_at',
        'updated_at',
    ];

    public $hidden = [
        'password',
    ];

    protected $dates = [
        'deleted_at'
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new MailResetPasswordNotification($token));
    }

}
