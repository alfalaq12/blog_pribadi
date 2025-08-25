<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show(Post $post)
    {
        // Pastikan post sudah published
        if (!$post->is_published) {
            abort(404);
        }

        $relatedPosts = Post::with(['user', 'category'])
            ->published()
            ->where('category_id', $post->category_id)
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('posts.show', compact('post', 'relatedPosts'));
    }

    public function category(Category $category)
    {
        $posts = Post::with(['user', 'category'])
            ->published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(6);

        return view('posts.category', compact('posts', 'category'));
    }
}