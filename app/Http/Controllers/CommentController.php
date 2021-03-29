<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Http\Requests\CommentStoreRequest;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(CommentRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->json(Comment::create($request->validated()), 201);
    }

    public function update(Comment $comment, CommentRequest $request): \Illuminate\Http\JsonResponse
    {
        $comment->update($request->validated());
        return response()->json($comment);
    }

    public function delete(Comment $comment)
    {
        $comment->delete();
    }
}
