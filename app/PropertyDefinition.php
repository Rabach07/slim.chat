<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PropertyDefinition extends Model
{
    protected $fillable = ['name', 'type', 'business_id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
