<?php

namespace App\Http\Controllers;

use App\Automation;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class AutomationController extends Controller
{
    public function index(Request $request)
    {
        $automations = QueryBuilder::for(Automation::class)
            ->whereBusinessId($request->business_id)
            ->get();

        return response()->json([
            'data' => $automations,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'business_id'         => 'required|exists:businesses,id',
            'name'                => 'required|max:255',
            'active'              => 'required|boolean',
            'message'             => 'required',
            'logic'               => 'required|in:and,or',
            'filters.*.property'  => 'required',
            'filters.*.condition' => 'required',
        ]);

        $automation = Automation::create($validatedData);

        return response()->json([
            'data' => $automation,
        ]);
    }

    public function show(Automation $automation)
    {
        return response()->json([
            'data' => $automation,
        ]);
    }

    public function update(Request $request, Automation $automation)
    {
    }

    public function destroy(Automation $automation)
    {
    }
}
