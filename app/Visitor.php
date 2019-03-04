<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
}
