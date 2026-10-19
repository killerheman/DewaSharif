<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\BlogRequest;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $blogs = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.blog.view', compact('blogs'));
    }

    public function create()
    {
        $nextSortOrder = (Blog::max('sort_order') ?? 0) + 1;

        return view('admin.blog.add', compact('nextSortOrder'));
    }

    public function store(BlogRequest $request)
    {
        $data = $request->validated();

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/blog'), $name);
            $data['image'] = 'uploads/blog/'.$name;
        }

        if (empty($data['sort_order'])) {
            $data['sort_order'] = (Blog::max('sort_order') ?? 0) + 1;
        }

        $data['date'] = now();

        Blog::create($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog created successfully.');
    }

    public function show(Blog $blog)
    {
        return view('admin.blog.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.add', compact('blog'));
    }

    public function update(BlogRequest $request, Blog $blog)
    {
        $data = $request->validated();

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->where('id', '!=', $blog->id)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        $data['slug'] = $slug;

        if ($request->hasFile('image')) {

            if ($blog->image && file_exists(public_path($blog->image))) {
                @unlink(public_path($blog->image));
            }

            $file = $request->file('image');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/blog'), $name);
            $data['image'] = 'uploads/blog/'.$name;
        }

        $blog->update($data);

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image && file_exists(public_path($blog->image))) {
            @unlink(public_path($blog->image));
        }

        $blog->delete();

        return redirect()
            ->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully.');
    }
}