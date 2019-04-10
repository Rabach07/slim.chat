<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'seen',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'seen'              => 'datetime',
    ];

    protected $appends = ['status'];

    public function businesses()
    {
        return $this->hasMany(Business::class, 'owner_id');
    }

    public function getSettingsAttribute()
    {
        $settings = Setting::whereUserId($this->id)->get();

        return $settings->pluck('value', 'name');
    }

    /**
     * User status: online, offline, away.
     *
     * @return string
     */
    public function getStatusAttribute(): String
    {
        return 'online';
    }

    public function see()
    {
        $this->update([
            'seen' => now(),
        ]);
    }
}
