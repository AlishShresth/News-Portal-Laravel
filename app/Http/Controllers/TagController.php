<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tags = Tag::all();
            return response()->json(['data' => $tags], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to fetch tags'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TagRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $slug = Str::slug($validatedData['name']);
            $count = 1;
            while(Tag::where('slug', $slug)->exists()){
                $slug = Str::slug($validatedData['name']) . '-' . $count;
                $count++;
            }
            $validatedData['slug'] = $slug;
            $tag = Tag::create($validatedData);
            return response()->json(['data' => $tag, 'message' => 'Tag created successfully'], 201);
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to create tag'],500);
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
    public function destroy(Tag $tag)
    {
        try{
            $tag->delete();
            return response()->json(['message' => 'Tag deleted successfully'], 200);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => 'Failed to delete tag'], 500);
        }
    }
}
