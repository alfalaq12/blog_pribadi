<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'draft_posts' => Post::where('is_published', false)->count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('is_approved', false)->count(),
            'total_categories' => Category::count(),
        ];

        $recent_posts = Post::with(['user', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $pending_comments = Comment::with('post')
            ->where('is_approved', false)
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_posts', 'pending_comments'));
    }
}