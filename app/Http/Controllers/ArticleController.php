<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $articles = Article::with(['user', 'category', 'tags'])->paginate(10);
            return response()->json(['data' => $articles], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' =>
            'Failed to fetch articles'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $slug = Str::slug($validatedData['title']);
            
            // Check if slug exists
            $count = 1;
            while (Article::where('slug', $slug)->exists()) {
                $slug = Str::slug($validatedData['title']) . '-' . $count;
                $count++;
            }
            
            $validatedData['slug'] = $slug;
            $article = Article::create($validatedData);
    
            if ($request->has('tags')) {
                $article->tags()->attach($request->tags);
            }
            return response()->json(['data' => $article, 'message' => 'Article created successfully'], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to create article'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        try{
            if (!$article) {
                return response()->json(['message' => 'Article not found'], 404);
            }
    
            $article->load(['user', 'category', 
            'tags', 'comments']);
            return response()->json(['data' => $article], 200);
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to fetch article'], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        try{
            $article->update($request->validated());
            $article->tags()->sync($request->tags);
            return response()->json(['data' => $article, 'message' => 'Article updated successfully'], 200);
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to update article'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        try{
            $article->delete();
            return response()->json(['message' => 'Article deleted successfully'], 200);
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to delete article'], 500);
        }
    }
}
