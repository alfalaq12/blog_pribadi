<?php
namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->published()
            ->latest('published_at')
            ->paginate(6);

        $categories = Category::withCount('posts')->get();
        
        $featuredPost = Post::with(['user', 'category'])
            ->published()
            ->latest('published_at')
            ->first();

        return view('home', compact('posts', 'categories', 'featuredPost'));
    }
}