<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $fillable = ['app_id', 'owner_id', 'name'];

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }

    public static function byAppId(string $app_id): ?Business
    {
        return Business::whereAppId($app_id)->first();
    }
}
