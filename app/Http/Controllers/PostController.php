<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Like;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::latest()->get();

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(PostRequest $request)
    {
        $attr = $request->all();
        $attr['image'] = $request->file('image')->store('thumbnail');
        $attr['slug'] = Str::slug($attr['title']);
        Auth::user()->posts()->create($attr);

        return redirect(route('posts.index'))->with('success', 'Berhasil membuat sebuah post');
    }

    public function show(Post $post)
    {
        // $like = Like::where('');
        $userLikedPost = $post->likes()->whereUserId(Auth::id())->first();
        $post->loadCount(['likes','comments']);
        $user = User::get();
        // return $user->comments;
        // $userCommented = $post->comments;
        // return $userCommented; 
        // return User::with('comments')->get();
        return view('posts.show', compact('post','userLikedPost'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Post $post, PostRequest $request)
    {
        $this->authorize('update', $post);

        if ($request->image) {
            Storage::delete($post->image);
            $thumbnail = $request->file('image')->store('thumbnail');
        }else{
            $thumbnail = $post->image;
        }

        $post->update([
            'title' => $request->title,
            'image' => $thumbnail
        ]);

        return redirect(route('posts.show', $post))->with('success', 'Berhasil mengedit sebuah post');
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        Storage::delete($post->image);
        $post->delete();

        return redirect(route('posts.index'))->with('success', 'Berhasil menghapus sebuah post');
    }

    public function like(Post $post)
    {
        if (Like::whereUserId(Auth::Id())->wherePostId($post->id)->first()) {
            $post->likes()->whereUserId(Auth::Id())->delete();
        } else {
            $post->likes()->create([
                'user_id' => Auth::Id()
            ]);
        }

        return back();
    }

    public function storeComment(Post $post)
    {
        // return $post;
        $post->comments()->create([
            'user_id' => Auth::Id(),
            'body' => request('body')
        ]);

        return back()->with('success', 'Berhasil buat komentar');
    }
}
