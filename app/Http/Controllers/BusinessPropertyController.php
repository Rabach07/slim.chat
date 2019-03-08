<?php

namespace App\Http\Controllers;

use App\Business;
use App\Visitor;
use Illuminate\Http\Request;

class BusinessPropertyController extends Controller
{
    public function index(Request $request, Business $business)
    {
        $this->authorize('view', $business);

        $properties = collect();

        Visitor::with('properties')->chunk(100, function ($visitors) use (&$properties) {
            foreach ($visitors as $visitor) {
                $properties = $properties->merge($visitor->properties->pluck('name'));
            }

            $properties = $properties->unique()->values();
        });

        return response()->json([
            'data' => $properties,
        ]);
    }
}
