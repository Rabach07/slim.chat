<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['visitor_id', 'name', 'value'];

    protected $appends = ['type'];

    protected $casts = [
        'visitor_id' => 'integer',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public static function set(int $visitor_id, string $name, string $value): Property
    {
        $property = Property::updateOrCreate([
            'visitor_id' => $visitor_id,
            'name'       => $name,
        ], [
            'value' => $value,
        ]);

        return $property;
    }

    public static function get(int $visitor_id, string $name): ?string
    {
        $property = Property::whereVisitorId($visitor_id)
            ->whereName($name)
            ->first();

        return optional($property)->value;
    }
}
