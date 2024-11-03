<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class PostController extends Controller
{
    public function index(): View
    {
        return view(
            'posts.index',
            [
                'posts' => Post::with('user')->latest()->get(),
            ]
        );
    }

    public function store(PostRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $request->user()->posts()->create($validated);
        return redirect(route('posts.index'));
    }

    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);
        return view('posts.edit', [
            'post' => $post,
        ]);
    }

    public function update(PostRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);
        $validated = $request->validated();
        $post->update($validated);
        return redirect(route('posts.index'));
    }

    public function delete(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);
        $post->delete();
        Session::flash('message', 'delete the post');
        return redirect(route('posts.index'));
    }
}
