<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\InviteUser;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reservations()
    {
        return $this->hasMany(\App\Reservation::class);
    }

    public function campers()
    {
        return $this->hasMany(\App\Camper::class);
    }

    // If admin creates a user send them an invite using password reset token
    public function sendPasswordResetNotification($token)
    {
        if ($this->invite_pending) {
            $this->notify(new InviteUser($token));
        } else {
            $this->notify(new ResetPassword($token));
        }
    }

    public static function label()
    {
        return 'name';
    }

    public function getLabelAttribute()
    {
        $labelColumn = static::label();
        return $this->$labelColumn;
    }

    public function jsObject()
    {
        $user['uuid'] = $this->uuid;
        $user['email'] = $this->email;
        return json_encode($user);
    }

    public function getUnreadNotificationCountAttribute()
    {
        return $this->unreadNotifications->count();
    }

    public function isAdmin()
    {
        return $this->hasRole('admin');
    }
}
