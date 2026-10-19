<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class EmailServiceController extends Controller
{
    public function index(Request $request)
    {
        $services = EmailService::when($request->search, function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->when($request->status !== null && $request->status !== '', function ($query) use ($request) {
            $query->where('is_active', $request->status);
        })
        ->orderBy('sort_order', 'asc')
        ->paginate(10)
        ->withQueryString();

        return view('admin.email-service.view', compact('services'));
    }

    public function create()
    {
        $nextSortOrder = (EmailService::max('sort_order') ?? 0) + 1;
        return view('admin.email-service.add', compact('nextSortOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'banner_title'       => 'nullable|string|max:255',
            'banner_description' => 'nullable|string',
            'plan_subtitle'       => 'nullable|string',
            'banner_service'     => 'nullable|string|max:255',
            'description'        => 'nullable|string',
            'banner_image_1'     => 'nullable|image|max:5120',
            'banner_image_2'     => 'nullable|image|max:5120',
            'image'              => 'nullable|image|max:5120',
            'icon'               => 'nullable|string|max:255',
            'icon_image'         => 'nullable|image|max:5120',
            'sort_order'         => 'nullable|integer',
            'is_active'          => 'nullable|boolean',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
            'meta_keywords'      => 'nullable|string',
            'image_alt'          => 'nullable|string|max:255',
            'image_title'        => 'nullable|string|max:255',
        ], [
            'banner_image_1.image' => 'Banner Image 1 must be a valid image.',
            'banner_image_1.max'   => 'Banner Image 1 must not exceed 5 MB.',
            'banner_image_2.image' => 'Banner Image 2 must be a valid image.',
            'banner_image_2.max'   => 'Banner Image 2 must not exceed 5 MB.',
            'image.image'          => 'Service Image must be a valid image.',
            'image.max'            => 'Service Image must not exceed 5 MB.',
            'icon_image.image'     => 'Icon Image must be a valid image.',
            'icon_image.max'       => 'Icon Image must not exceed 5 MB.',
        ]);

        $data = $request->except(['banner_image_1', 'banner_image_2', 'image', 'icon_image', '_token']);

        $slug = Str::slug($request->name);
        $trashed = EmailService::onlyTrashed()->where('slug', $slug)->first();
        if ($trashed) {
            $trashed->slug = $slug . '-deleted-' . time();
            $trashed->save();
        }

        $originalSlug = $slug;
        $count = 1;
        while (EmailService::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        $data['slug'] = $slug;

        foreach (['banner_image_1', 'banner_image_2', 'image', 'icon_image'] as $img) {
            if ($request->hasFile($img)) {
                $file = $request->file($img);
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/email_service'), $name);
                $data[$img] = 'uploads/email_service/' . $name;
            }
        }

        $data['is_active'] = $request->has('is_active') ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? ((EmailService::max('sort_order') ?? 0) + 1);

        EmailService::create($data);

        return redirect()->route('admin.email-services.index')->with('success', 'Email Service Created Successfully');
    }

    public function edit(EmailService $emailService)
    {
        return view('admin.email-service.edit', compact('emailService'));
    }

    public function update(Request $request, EmailService $emailService)
    {
        $request->validate([
            'name'               => 'required|string|max:255',
            'banner_title'       => 'nullable|string|max:255',
            'banner_description' => 'nullable|string',
            'plan_subtitle'       => 'nullable|string',
            'banner_service'     => 'nullable|string|max:255',
            'description'        => 'nullable|string',
            'banner_image_1'     => 'nullable|image|max:5120',
            'banner_image_2'     => 'nullable|image|max:5120',
            'image'              => 'nullable|image|max:5120',
            'icon'               => 'nullable|string|max:255',
            'icon_image'         => 'nullable|image|max:5120',
            'sort_order'         => 'nullable|integer',
            'is_active'          => 'nullable|boolean',
            'meta_title'         => 'nullable|string|max:255',
            'meta_description'   => 'nullable|string',
            'meta_keywords'      => 'nullable|string',
            'image_alt'          => 'nullable|string|max:255',
            'image_title'        => 'nullable|string|max:255',
        ], [
            'banner_image_1.image' => 'Banner Image 1 must be a valid image.',
            'banner_image_1.max'   => 'Banner Image 1 must not exceed 5 MB.',
            'banner_image_2.image' => 'Banner Image 2 must be a valid image.',
            'banner_image_2.max'   => 'Banner Image 2 must not exceed 5 MB.',
            'image.image'          => 'Service Image must be a valid image.',
            'image.max'            => 'Service Image must not exceed 5 MB.',
            'icon_image.image'     => 'Icon Image must be a valid image.',
            'icon_image.max'       => 'Icon Image must not exceed 5 MB.',
        ]);

        $data = $request->except(['banner_image_1', 'banner_image_2', 'image', 'icon_image', '_token', '_method']);

        if ($request->name !== $emailService->name) {
            $slug = Str::slug($request->name);
            $originalSlug = $slug;
            $count = 1;
            while (EmailService::withTrashed()->where('slug', $slug)->where('id', '!=', $emailService->id)->exists()) {
                $slug = "{$originalSlug}-{$count}";
                $count++;
            }
            $data['slug'] = $slug;
        }

        foreach (['banner_image_1', 'banner_image_2', 'image', 'icon_image'] as $img) {
            if ($request->hasFile($img)) {
                if ($emailService->$img && File::exists(public_path($emailService->$img))) {
                    File::delete(public_path($emailService->$img));
                }
                $file = $request->file($img);
                $name = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('uploads/email_service'), $name);
                $data[$img] = 'uploads/email_service/' . $name;
            }
        }

        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $emailService->update($data);

        return redirect()->route('admin.email-services.index')->with('success', 'Email Service Updated Successfully');
    }

    public function destroy(EmailService $emailService)
    {
        // Append timestamp to slug upon soft-deleting so slug can be freely reused
        $emailService->slug = $emailService->slug . '-deleted-' . time();
        $emailService->save();

        $emailService->delete();

        return redirect()->route('admin.email-services.index')->with('success', 'Email Service Deleted Successfully');
    }
}
