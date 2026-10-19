<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServerCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class ServerCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = ServerCategory::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->orderBy('sort_order', 'asc')
        ->paginate(15)
        ->withQueryString();

        $nextSortOrder = (ServerCategory::max('sort_order') ?? 0) + 1;

        return view('admin.server-category.index', compact('categories', 'nextSortOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (ServerCategory::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        ServerCategory::create([
            'name'       => $request->name,
            'slug'       => $slug,
            'sort_order' => $request->sort_order ?? ((ServerCategory::max('sort_order') ?? 0) + 1),
            'is_active'  => $request->has('is_active') ? true : false,
        ]);

        Alert::success('Success', 'Server Category Added Successfully.');
        return redirect()->route('admin.server-categories.index');
    }

    public function edit(ServerCategory $serverCategory)
    {
        $editCategory = $serverCategory;
        $categories = ServerCategory::orderBy('sort_order', 'asc')->paginate(15);
        $nextSortOrder = $serverCategory->sort_order;

        return view('admin.server-category.index', compact('editCategory', 'categories', 'nextSortOrder'));
    }

    public function update(Request $request, ServerCategory $serverCategory)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (ServerCategory::withTrashed()->where('slug', $slug)->where('id', '!=', $serverCategory->id)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $serverCategory->update([
            'name'       => $request->name,
            'slug'       => $slug,
            'sort_order' => $request->sort_order ?? $serverCategory->sort_order,
            'is_active'  => $request->has('is_active') ? true : false,
        ]);

        Alert::success('Success', 'Server Category Updated Successfully.');
        return redirect()->route('admin.server-categories.index');
    }

    public function destroy(ServerCategory $serverCategory)
    {
        $serverCategory->delete();
        Alert::success('Success', 'Server Category Deleted Successfully.');
        return redirect()->route('admin.server-categories.index');
    }
}
