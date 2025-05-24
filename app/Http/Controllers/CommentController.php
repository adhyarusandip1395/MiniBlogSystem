<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class CommentController extends Controller
{
    public function index($id)
    {
        $post = Post::find($id);
        if (!$post) return response()->json(['success' => false, 'message' => 'Post not found'], 404);
        return response()->json(['success' => true, 'data' => $post->comments()->with('user')->get()]);
    }

    public function store(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post) return response()->json(['success' => false, 'message' => 'Post not found'], 404);

        $data = $request->validate([
            'comment_text' => 'required'
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'comment_text' => $data['comment_text']
        ]);

        return response()->json(['success' => true, 'message' => 'Comment added', 'data' => $comment]);
    }
}
