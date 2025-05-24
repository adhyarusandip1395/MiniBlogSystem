@extends('partials.layout')
@section('styles')
<style>
    body {
    background-color: #f8f9fa;
    }
    th,td{
        text-align: center;
    }
</style>
@endsection
@section('content')
    <div class="container mt-5 p-5">
        <div class="row">
            <div class="col text-end mb-2">
                <button class="btn btn-primary" onclick="window.location.href='{{ route('post.add') }}'">Create</button>
                <button class="btn btn-danger" onclick="window.location.href='{{ route('customer.logout') }}'">Logout</button>
            </div>
        </div>
        <div class="card shadow p-4">
            <h4 class="text-center mb-4">Posts</h4>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Sr no</th>
                        <th scope="col">Title</th>
                        <th scope="col">Body</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($posts as $post)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $post->title }}</td>
                            <td>{{ $post->body }}</td>
                            <td>
                                <a href="{{ route('post.edit', $post->id) }}" class="btn btn-primary">Edit</a>
                                <form action="{{ route('post.delete', $post->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No posts found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            @if($posts->hasPages())
                <div class="row">
                    <div class="col d-flex justify-content-center">
                        {{ $posts->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
@section('scripts')

@endsection