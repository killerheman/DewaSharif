<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HostingCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class HostingCategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = HostingCategory::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->orderBy('sort_order', 'asc')
        ->paginate(15)
        ->withQueryString();

        $nextSortOrder = (HostingCategory::max('sort_order') ?? 0) + 1;

        return view('admin.hosting-category.index', compact('categories', 'nextSortOrder'));
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
        while (HostingCategory::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        HostingCategory::create([
            'name'       => $request->name,
            'slug'       => $slug,
            'sort_order' => $request->sort_order ?? ((HostingCategory::max('sort_order') ?? 0) + 1),
            'is_active'  => $request->has('is_active') ? true : false,
        ]);

        Alert::success('Success', 'Hosting Category Added Successfully.');
        return redirect()->route('admin.hosting-categories.index');
    }

    public function edit(HostingCategory $hostingCategory)
    {
        $editCategory = $hostingCategory;
        $categories = HostingCategory::orderBy('sort_order', 'asc')->paginate(15);
        $nextSortOrder = $hostingCategory->sort_order;

        return view('admin.hosting-category.index', compact('editCategory', 'categories', 'nextSortOrder'));
    }

    public function update(Request $request, HostingCategory $hostingCategory)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'is_active'  => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (HostingCategory::withTrashed()->where('slug', $slug)->where('id', '!=', $hostingCategory->id)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        $hostingCategory->update([
            'name'       => $request->name,
            'slug'       => $slug,
            'sort_order' => $request->sort_order ?? $hostingCategory->sort_order,
            'is_active'  => $request->has('is_active') ? true : false,
        ]);

        Alert::success('Success', 'Hosting Category Updated Successfully.');
        return redirect()->route('admin.hosting-categories.index');
    }

    public function destroy(HostingCategory $hostingCategory)
    {
        $hostingCategory->delete();
        Alert::success('Success', 'Hosting Category Deleted Successfully.');
        return redirect()->route('admin.hosting-categories.index');
    }
}
