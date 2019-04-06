<?php

namespace App\Http\Controllers;

use App\Business;
use App\Events\BusinessUpdated;
use App\Setting;
use Illuminate\Http\Request;

class BusinessSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Business $business)
    {
        $this->authorize('view', $business);

        return $business->settings;
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business, $setting)
    {
        $this->authorize('view', $business);

        return $business->settings[$setting];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business, $setting)
    {
        $this->authorize('update', $business);

        $setting = Setting::firstOrCreate([
            'business_id' => $business->id,
            'name'        => $setting,
        ]);

        $setting->update([
            'value' => $request->value,
        ]);

        event(new BusinessUpdated($business));

        return $setting;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
