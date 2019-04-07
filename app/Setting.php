<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['user_id', 'business_id', 'name', 'value'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public static function get($businessId, $name)
    {
        return Setting::whereBusinessId($businessId)
            ->whereName($name)->first();
    }
}
