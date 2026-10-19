<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    public function index(Request $request)
    {
        $query = Testimonial::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        if ($request->status !== null && $request->status !== '') {
            $query->where('is_active', $request->status);
        }

        $testimonials = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.testimonial.view', compact('testimonials'));
    }

    public function create()
    {
        $nextSortOrder = (Testimonial::max('sort_order') ?? 0) + 1;

        return view('admin.testimonial.add', compact('nextSortOrder'));
    }

    public function store(TestimonialRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('thumb_image')) {
            $file = $request->file('thumb_image');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/testimonial'), $name);
            $data['thumb_image'] = 'uploads/testimonial/'.$name;
        }

        if (empty($data['sort_order'])) {
            $data['sort_order'] = (Testimonial::max('sort_order') ?? 0) + 1;
        }

        $data['date'] = now();

        Testimonial::create($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial created successfully.');
    }

    public function show(Testimonial $testimonial)
    {
        return view('admin.testimonial.show', compact('testimonial'));
    }

        public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonial.add', compact('testimonial'));
    }

    public function update(TestimonialRequest $request, Testimonial $testimonial)
    {
        $data = $request->validated();

        if ($request->hasFile('thumb_image')) {

            if ($testimonial->thumb_image && file_exists(public_path($testimonial->thumb_image))) {
                @unlink(public_path($testimonial->thumb_image));
            }

            $file = $request->file('thumb_image');
            $name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/testimonial'), $name);
            $data['thumb_image'] = 'uploads/testimonial/'.$name;
        }

        $testimonial->update($data);

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial updated successfully.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->thumb_image && file_exists(public_path($testimonial->thumb_image))) {
            @unlink(public_path($testimonial->thumb_image));
        }

        $testimonial->delete();

        return redirect()
            ->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully.');
    }
}