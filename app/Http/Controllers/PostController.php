<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with(['user', 'comments.user']);

        if ($search = $request->query('search')) {
            $query->where('title', 'like', "%{$search}%")->orWhere('body', 'like', "%{$search}%");
        }

        $posts = $query->orderBy('id', 'desc')->paginate(5);
        
        if($request->wantsJson()){
            if ($posts->isEmpty()) return response()->json(['success' => false, 'message' => 'Not Found'], 404);
    
            return response()->json(['success' => true, 'data' => $posts]);
        }else{
            return view('list',compact('posts'));
        }
    }

    public function add(){

        return view('add');
    }

    public function show(Request $request, $id)
    {
        $post = Post::with(['user', 'comments.user'])->find($id);
        
        if($request->wantsJson()){
            if (!$post) return response()->json(['success' => false, 'message' => 'Not Found'], 404);
            return response()->json(['success' => true, 'data' => $post]);
        }else{
            if (!$post){
             Toastr::error('Post not found.');
             return redirect()->back();   
            }
            return view('edit',compact('post'));
        }
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post = auth()->user()->posts()->create($data);
        
        if($request->wantsJson()){
            return response()->json(['success' => true, 'message' => 'Post created successfully', 'data' => $post]);
        }

        Toastr::success('Post created successfully.');
        return redirect()->route('post.list');
    }

    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post || $post->user_id !== auth()->id()) {
            if($request->wantsJson()){
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            Toastr::error('Unauthorized.');
            return redirect()->back()->withInput();
        }

        $data = $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post->update($data);

        if($request->wantsJson()){
            return response()->json(['success' => true, 'message' => 'Post updated', 'data' => $post]);
        }

        Toastr::success('Post updated successfully.');
        return redirect()->route('post.list');
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::find($id);
        if (!$post || $post->user_id !== auth()->id()) {
            if($request->wantsJson()){
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            Toastr::error('Unauthorized.');
            return redirect()->back();
        }

        $post->delete();

        if($request->wantsJson()){
            return response()->json(['success' => true, 'message' => 'Post deleted']);
        }

        Toastr::success('Post deleted successfully.');
        return redirect()->route('post.list');
    }
}
