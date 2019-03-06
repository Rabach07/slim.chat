<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Visitor extends Model
{
    protected $fillable = ['business_id', 'uuid', 'external_id'];

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

    /**
     * Find a visitor by UUID.
     *
     * @param string $uuid
     *
     * @return App\Visitor
     */
    public static function findByUuid(string $uuid): ?Visitor
    {
        return Visitor::whereUuid($uuid)->first();
    }

    /**
     * Get a visitor.
     *
     * @param int    $business_id
     * @param string $uuid
     *
     * @return App\Visitor
     */
    public static function get(int $business_id, string $uuid): ?Visitor
    {
        if (! $uuid) {
            $uuid = Str::uuid();
        }

        return Visitor::firstOrCreate([
            'business_id' => $business_id,
            'uuid'        => $uuid,
        ]);
    }
}
