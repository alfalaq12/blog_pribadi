<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['user', 'category'])
            ->latest()
            ->paginate(10);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required|max:500',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;

        while (Post::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $data = $request->all();
        $data['slug'] = $slug;
        $data['user_id'] = auth()->id();
        
        if ($request->is_published) {
            $data['published_at'] = now();
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/posts'), $imageName);
            $data['featured_image'] = 'posts/' . $imageName;
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dibuat.');
    }

    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required|max:500',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_published' => 'boolean',
        ]);

        $data = $request->all();
        
        // Update slug hanya jika title berubah
        if ($post->title !== $request->title) {
            $slug = Str::slug($request->title);
            $originalSlug = $slug;
            $counter = 1;

            while (Post::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            
            $data['slug'] = $slug;
        }

        // Set published_at jika status berubah ke published
        if ($request->is_published && !$post->is_published) {
            $data['published_at'] = now();
        } elseif (!$request->is_published) {
            $data['published_at'] = null;
        }

        // Handle featured image upload
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($post->featured_image && file_exists(public_path('storage/' . $post->featured_image))) {
                unlink(public_path('storage/' . $post->featured_image));
            }

            $image = $request->file('featured_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/posts'), $imageName);
            $data['featured_image'] = 'posts/' . $imageName;
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil diupdate.');
    }

    public function destroy(Post $post)
    {
        // Delete featured image
        if ($post->featured_image && file_exists(public_path('storage/' . $post->featured_image))) {
            unlink(public_path('storage/' . $post->featured_image));
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Post berhasil dihapus.');
    }
}