<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Automation extends Model
{
    protected $fillable = ['business_id', 'name', 'active', 'message', 'logic', 'filters'];

    protected $casts = [
        'active'  => 'boolean',
        'filters' => 'json',
    ];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
