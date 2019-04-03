<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Visitor extends Model
{
    protected $fillable = ['business_id', 'uuid', 'external_id'];

    protected $casts = [
        'business_id' => 'integer',
    ];

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
    public static function get(int $business_id, string $uuid = null): ?Visitor
    {
        $visitor = Visitor::where([
            'business_id' => $business_id,
            'uuid'        => $uuid,
        ])->first();

        if (! $visitor) {
            $visitor = Visitor::create([
                'business_id' => $business_id,
                'uuid'        => Str::uuid(),
            ]);
        }

        return $visitor;
    }

    public function getPropsAttribute()
    {
        $properties = $this->properties;

        return $properties->pluck('value', 'name');
    }
}
