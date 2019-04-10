<?php

namespace App\Http\Controllers;

use App\Business;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BusinessAvailabilityController extends Controller
{
    public function show(Request $request, Business $business)
    {
        $timezone = optional(Setting::get($business->id, 'timezone'))->value;
        $hours = json_decode(optional(Setting::get($business->id, 'hours'))->value);

        $now = Carbon::now($timezone);
        $currentDay = strtolower($now->englishDayOfWeek);
        $currentHour = $now->hour;
        $currentMinute = $now->format('i');
        $currentTime = floatval($currentHour.'.'.$currentMinute);

        $status = 'offline';
        $message = 'Offline';
        for ($i = 0; $i < count($hours); ++$i) {
            if ($hours[$i][0] == $currentDay) {
                $timeStartDecimal = floatval((int) explode(':', $hours[$i][1])[0].'.'.explode(':', $hours[$i][1])[1]);
                $timeEndDecimal = floatval((int) explode(':', $hours[$i][2])[0].'.'.explode(':', $hours[$i][2])[1]);

                if ($currentTime < $timeStartDecimal) {
                    // Before
                    $status = 'offline';
                    $message = 'Back in a few hours';
                } elseif ($timeEndDecimal < $currentTime) {
                    // After
                    $status = 'offline';
                    $message = 'Back in a few hours';

                // if ($)
                } else {
                    $status = 'online';
                    $message = 'Online';
                }
            }
        }

        return response()->json([
            'data' => [
                'status'  => $status,
                'message' => $message,
            ],
        ]);
    }
}
