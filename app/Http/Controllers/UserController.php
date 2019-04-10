<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return response()->json([
            'data' => auth()->user(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,id,'.auth()->user()->id,
        ]);

        auth()->user()->update($validatedData);

        return response()->json([
            'data' => auth()->user(),
        ]);
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
