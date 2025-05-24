@extends('partials.layout')
@section('styles')
<style>
    body {
    background-color: #f8f9fa;
    }
    .login-container {
        min-width: 400px;
        max-width: 400px;
    
    }
</style>
@endsection
@section('content')
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="card login-container shadow p-4">
            <h4 class="text-center mb-4">Add Post</h4>
           <form action="{{ route('post.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" value="{{ old('title') }}" class="form-control" id="title" placeholder="Enter Title" autocomplete="off" >
                    @error('title')
                        <span class="text-danger ml-2">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="body" class="form-label">Body</label>
                    <textarea name="body" value="{{ old('body') }}" class="form-control" id="body" placeholder="Enter body" autocomplete="off" ></textarea>
                    @error('body')
                        <span class="text-danger ml-2">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
                <div class="row">
                    <div class="col text-end">
                        <button type="submit" class="btn btn-primary w-50 mt-4">Submit</button>
                    </div>
                    <div class="col text-left">
                        <a href="{{ route('post.list') }}"><button type="button" class="btn btn-secondary w-50 mt-4">Back</button></a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')

@endsection