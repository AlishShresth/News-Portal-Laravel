<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            // Find all categories
            $categories = Category::all();

            // Return success response
            return response()->json(['data' => $categories], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            // Return error response
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to fetch categories'], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        try {
            // Validate data
            $validatedData = $request->validated();

            // Create slug
            $slug=Str::slug($validatedData['name']);
            $count = 1;
            while(Category::where('slug', $slug)->exists()){
                $slug = Str::slug($validatedData['name']) . '-' . $count;
                $count++;
            }
            $validatedData['slug'] = $slug;

            // Create category
            $category = Category::create($validatedData);

            // Return success response
            return response()->json(['data' => $category, 'message' => 'Category created successfully'], 201);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            // Return error response
            return response()->json(['error' => 'Failed to create category'], 500);
        }
    }

    public function show(Category $category){
        try{
            // Find category and load articles
            $category->load(['articles', 'articles.user', 'articles.multimedia']);

            // Return success response
            return response()->json(['data' => $category], 200);
        } catch(\Exception $e){
            Log::error('Category not found: ' . $e->getMessage());
            
            // Return error response
            return response()->json(['error' => $e->getMessage(),
            'message' => 'Failed to fetch category'], 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try{
            // validate data
            $validatedData = $request->validated();

            // update slug if needed
            if($request->name){
                $slug = Str::slug($validatedData['name']);
                $count = 1;
                while (Category::where('slug', $slug)->exists()) {
                    $slug = Str::slug($validatedData['title']) . '-' . $count;
                    $count++;
                }
                $validatedData['slug'] = $slug;
            }

            // Merge default values for missing fields
            $data = array_merge($category->only([
                'name', 'description'
            ]), $validatedData);

            // Update the category
            $category->update($data);

            // Return success response
            return response()->json(['data'=>$category, 'message' => 'Category updated successfully'], 200);
        } catch(\Exception $e){
            Log::error($e->getMessage());

            // Return error response
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to update category'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try{
            $category->delete();
            return response()->json(['message'=>'Category deleted successfully'], 200);
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to delete category'], 500);
        }
    }
}
