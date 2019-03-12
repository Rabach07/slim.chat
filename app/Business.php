<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = ['app_id', 'owner_id', 'name'];

    protected $casts = [
        'app_id'   => 'integer',
        'owner_id' => 'integer',
    ];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public static function findByAppId(string $app_id): ?Business
    {
        return Business::whereAppId($app_id)->first();
    }

    public function getSettingsAttribute()
    {
        $settings = Setting::whereBusinessId($this->id)->get();

        return $settings->pluck('value', 'name');
    }
}
