<?php

namespace App\Http\Controllers;

use App\Business;
use App\Events\PropertiesUpdated;
use App\Property;
use App\Setting;
use App\Visitor;
use Illuminate\Http\Request;

class AnnounceController extends Controller
{
    public function announce(Request $request)
    {
        $business = Business::findByAppId($request->app_id);
        abort_if(! $business, 404, 'Business not found.');

        $visitor = Visitor::get($business->id, $request->visitor_uuid);

        // Device info
        $agent = new \Jenssegers\Agent\Agent();
        Property::set($visitor->id, 'device', $agent->device());
        Property::set($visitor->id, 'platform', $agent->isDesktop() ? 'desktop' : 'mobile');
        Property::set($visitor->id, 'operating_system', $agent->platform().' '.$agent->version($agent->platform()));
        Property::set($visitor->id, 'browser', $agent->browser().' '.$agent->version($agent->browser()));
        Property::set($visitor->id, 'language', count($agent->languages()) ? $agent->languages()[0] : '');

        // Geo info
        $ip = request()->ip();
        $geo = json_decode(file_get_contents('https://get.geojs.io/v1/ip/geo/'.$ip.'.json'));
        Property::set($visitor->id, 'country', isset($geo->country) ? $geo->country : '');
        Property::set($visitor->id, 'region', isset($geo->region) ? $geo->region : '');
        Property::set($visitor->id, 'city', isset($geo->city) ? $geo->city : '');
        Property::set($visitor->id, 'ip', isset($geo->ip) ? $geo->ip : '');
        Property::set($visitor->id, 'timezone', isset($geo->timezone) ? $geo->timezone : '');

        event(new PropertiesUpdated($visitor));

        return response()->json([
            'data' => [
                'uuid'     => $visitor->uuid,
                'business' => [
                    'name' => $business->name,
                ],
                'settings' => [
                    'logo'           => '/storage/business_logos/'.$business->app_id.'.png',
                    'color_primary'  => optional(Setting::get($business->id, 'color_primary'))->value,
                    'color_contrast' => optional(Setting::get($business->id, 'color_contrast'))->value,
                ],
            ],
        ]);
    }
}
