<?php

namespace App\Http\Controllers;

use App\Business;
use App\Events\BusinessUpdated;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'data' => auth()->user()->businesses,
        ]);
    }

    public function show(Request $request, Business $business)
    {
        $this->authorize('view', $business);

        $business = Business::find($business->id)->with('settings', 'propertyDefinitions')->first();

        return response()->json([
            'data' => $business,
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', $business);

        // TODO Store business
    }

    public function update(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $business->update($request->all());

        event(new BusinessUpdated($business));

        return response()->json([
            'data' => $business,
        ]);
    }

    public function destroy(Request $request, Business $business)
    {
        // TODO Delete business
    }
}
