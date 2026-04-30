<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with('author')->where('status', 'published');

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        $blogs = $query->orderBy('published_at', 'desc')->paginate(9)->withQueryString();

        $categories = Blog::where('status', 'published')
            ->select('category')
            ->distinct()
            ->pluck('category')
            ->filter();

        $featuredBlogs = Blog::where('status', 'published')
            ->orderBy('views', 'desc')
            ->take(3)
            ->get();

        return view('guest.blogs.index', compact('blogs', 'categories', 'featuredBlogs'));
    }

    public function show($slug)
    {
        $blog = Blog::with('author')->where('slug', $slug)->where('status', 'published')->firstOrFail();

        // Tambah view count
        $blog->increment('views');

        $relatedBlogs = Blog::where('category', $blog->category)
            ->where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('guest.blogs.show', compact('blog', 'relatedBlogs'));
    }
}
