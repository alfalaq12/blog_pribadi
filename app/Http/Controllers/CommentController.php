<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|max:255',
            'author_email' => 'required|email|max:255',
            'content' => 'required|min:10|max:1000',
        ], [
            'author_name.required' => 'Nama wajib diisi',
            'author_email.required' => 'Email wajib diisi',
            'author_email.email' => 'Format email tidak valid',
            'content.required' => 'Komentar wajib diisi',
            'content.min' => 'Komentar minimal 10 karakter',
            'content.max' => 'Komentar maksimal 1000 karakter',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Comment::create([
            'content' => $request->content,
            'author_name' => $request->author_name,
            'author_email' => $request->author_email,
            'post_id' => $post->id,
            'is_approved' => false, // Perlu approval admin
        ]);

        return back()->with('success', 'Komentar Anda telah dikirim dan akan ditampilkan setelah disetujui admin.');
    }

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);
        return back()->with('success', 'Komentar telah disetujui.');
    }
}