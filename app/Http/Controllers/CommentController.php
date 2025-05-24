<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Brian2694\Toastr\Facades\Toastr;

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

        if (!$post){
            if($request->wantsJson()){
                 return response()->json(['success' => false, 'message' => 'Post not found'], 404);
            }
            Toastr::error('Post not found.');
            return redirect()->back();
        }

        $data = $request->validate([
            'comment_text' => 'required'
        ]);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'comment_text' => $data['comment_text']
        ]);

        if($request->wantsJson()){
            return response()->json(['success' => true, 'message' => 'Comment added', 'data' => $comment]);
        }

        Toastr::success('Comment added successfully.');
        return redirect()->back();
    }
}
