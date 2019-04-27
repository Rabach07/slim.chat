<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $business = Business::find($request->business_id);

        $this->authorize('update', $business);

        $request->validate([
            'file' => 'required|mimetypes:text/csv,text/plain',
        ]);

        Storage::putFileAs('business_imports', $request->file('file'), $business->app_id.'.csv');

        $handle = fopen(storage_path('app/business_imports/'.$business->app_id.'.csv'), 'r');
        $headers = null;
        $records = 0;
        while ($line = fgetcsv($handle, 0, ',')) {
            if (! $headers) {
                $headers = $line;
            } else {
                ++$records;
            }
        }

        $properties = [];
        foreach ($headers as $header) {
            array_push($properties, [
                'original' => $header,
                'parsed'   => str_replace('-', '_', Str::slug($header)),
                'type'     => 'Text',
                'keep'     => true,
            ]);
        }

        return response()->json([
            'data' => [
                'number_of_records' => $records,
                'properties'        => $properties,
            ],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
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
