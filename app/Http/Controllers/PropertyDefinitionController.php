<?php

namespace App\Http\Controllers;

use App\Business;
use App\PropertyDefinition;
use Illuminate\Http\Request;

class PropertyDefinitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        return response()->json([
            'data' => $business->propertyDefinitions,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Business $business)
    {
        $this->authorize('update', $business);

        $validatedData = $request->validate([
            'name' => 'required|maxlength:256',
            'type' => 'required|in:text,number,boolean,string',
        ]);

        // return PropertyDefinition::create([
        //     'business_id' => $business->id,
        //     ...$validatedData
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\PropertyDefinition $propertyDefinition
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Business $business, PropertyDefinition $propertyDefinition)
    {
        $this->authorize('update', $business);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\PropertyDefinition  $propertyDefinition
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Business $business, PropertyDefinition $propertyDefinition)
    {
        $this->authorize('update', $business);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\PropertyDefinition $propertyDefinition
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Business $business, PropertyDefinition $propertyDefinition)
    {
        $this->authorize('update', $business);
    }
}
