@extends('partials.layout')
@section('styles')
    <style>
        body {
            background-color: #f8f9fa;
        }

        .login-container {
            min-width: 800px;
            max-width: 800px;

        }
    </style>
@endsection
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card login-container shadow p-4">
            @if (auth()->user()->id == $post->user_id)
                <h4 class="text-center mb-4">Update Post</h4>
            @else
                <h4 class="text-center mb-4">View Post</h4>
            @endif
            <form action="{{ route('post.update', $post->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" value="{{ old('title') ?? $post->title }}"
                        @if (auth()->user()->id != $post->user_id) disabled @endif class="form-control" id="title"
                        placeholder="Enter Title" autocomplete="off">
                    @error('title')
                        <span class="text-danger ml-2">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Body <span class="text-danger">*</span></label>
                    <textarea name="body" class="form-control" id="body" placeholder="Enter body"
                        @if (auth()->user()->id != $post->user_id) disabled @endif autocomplete="off">{{ old('body') ?? $post->body }}</textarea>
                    @error('body')
                        <span class="text-danger ml-2">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="row">
                    @if (auth()->user()->id == $post->user_id)
                        <div class="col text-end">
                            <button type="submit" class="btn btn-primary w-50 mt-4">Update</button>
                        </div>
                        <div class="col text-left">
                            <a href="{{ route('post.list') }}"><button type="button"
                                    class="btn btn-secondary w-50 mt-4">Back</button></a>
                        </div>
                    @else
                        <div class="col text-center">
                            <a href="{{ route('post.list') }}"><button type="button"
                                    class="btn btn-secondary w-25 mt-4">Back</button></a>
                        </div>
                    @endif
                </div>
            </form>
            <form action="{{ route('comment.store', $post->id) }}" method="post">  
                @csrf
                <div class="row mt-5">
                    <div class="col">
                        <div class="mb-3">
                            <label for="comment_text" class="form-label">Comment <span class="text-danger">*</span></label>
                            <textarea name="comment_text" class="form-control" id="comment_text" placeholder="Enter comment" autocomplete="off"></textarea>
                            @error('comment_text')
                                <span class="text-danger ml-2">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col text-end">
                                <button type="submit" class="btn btn-primary w-25 mt-4">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            <div class="row mt-5">
                <div class="col table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" style="min-width: 200px; max-width:200px;">Comments</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($post->comments as $comment)
                                <tr>
                                    <td style="min-width: 200px; max-width:200px;">{{ $comment->comment_text }}</td>
                                    <td class="text-end text-muted" style="font-size: 12px;">By {{ $comment->user->name }} ({{ $comment->created_at->diffForHumans() }})</td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center">No comments found</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection
