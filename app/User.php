<?php

namespace App;

use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Auth\Notifications\ResetPassword;
use App\Notifications\InviteUser;
use App\Traits\Customer;
use Spatie\Permission\Traits\HasRoles;

use App\Counselor;

class User extends Authenticatable
{
    use HasRoles, Notifiable, Impersonate, Customer;

    protected $guarded = ['id'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function reservations()
    {
        return $this->hasMany(\App\Reservation::class);
    }

    public function payments()
    {
        return $this->hasMany(\App\Payment::class);
    }

    public function campers()
    {
        return $this->hasMany(\App\Camper::class);
    }

    public function hasPaidRegistrationFee()
    {
        $camp = \App\Camp::current();

        return $camp && $this->payments()
            ->where('type', 'registration_fee')
            ->where('camp_id', $camp->id)
            ->count();
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

    public function counselor()
    {
        return $this->hasOne(\App\Counselor::class);
    }

    public function isCounselor()
    {
        $counselor = Counselor::where('user_id', $this->id)
            ->count();
        return $counselor > 0 ? true : false;
    }

    public function canImpersonate()
    {
        return $this->hasRole('admin');
    }

    public function canBeImpersonated()
    {
        return !$this->hasRole('admin');
    }
}
