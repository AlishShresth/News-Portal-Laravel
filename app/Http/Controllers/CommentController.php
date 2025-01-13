<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentController extends Controller
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
    public function store(CommentRequest $request)
    {
        try{
            $comment = Comment::create($request->validated());
            return response()->json(['data' => $comment, 'message' => 'Comment added successfully'],201);
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message'=>'Failed to add comment'],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        try{

            $comment->update($request->validated());
            return response()->json(['data' => $comment, 'message' => 'Comment updated successfully'], 200);
        } catch (\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to update comment'] ,500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        try{
            $comment->delete();
            return response()->json(['message' => 'Comment deleted successfully'], 200);
        } catch(\Exception $e){
            Log::error($e->getMessage());
            return response()->json(['error' => $e->getMessage(), 'message' => 'Failed to delete comment'], 500);
        }
    }
}
