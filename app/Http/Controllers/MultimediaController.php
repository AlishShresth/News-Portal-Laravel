<?php

namespace App\Http\Controllers;

use App\Http\Requests\MultimediaRequest;
use App\Models\Multimedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MultimediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MultimediaRequest $request)
    {
        try{
            $path = $request->file('file')->store('uploads', 'public');
            $multimedia = Multimedia::create([
                'type' => $request->file->getMimeType(),
                'path' => $path,
                'alt_text' => $request->alt_text,
                'caption' => $request->caption,
            ]);
            return response()->json(['message' => 'File uploaded successfully', 'data' => $multimedia], 201);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to upload file'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
