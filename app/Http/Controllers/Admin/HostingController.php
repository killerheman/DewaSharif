<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HostingRequest;
use App\Models\Hosting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;


use App\Models\HostingCategory;

class HostingController extends Controller
{

    public function index(Request $request)
    {
        $hostings = Hosting::when($request->filled('search'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->search . '%');
        })
        ->when($request->filled('status'), function ($query) use ($request) {
            $query->where('is_active', (bool) $request->status);
        })
        ->orderBy('sort_order', 'asc')
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('admin.hosting.view', compact('hostings'));
    }



    public function create()
    {
        $nextSortOrder = (Hosting::max('sort_order') ?? 0)+1;
        $categories = HostingCategory::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('admin.hosting.add',compact('nextSortOrder', 'categories'));
    }



    public function store(HostingRequest $request)
    {
        $data = $request->validated();

        $slug = Str::slug($request->name);

        // If a soft-deleted hosting exists with this slug, rename its slug so the new hosting can use the clean slug
        $trashed = Hosting::onlyTrashed()->where('slug', $slug)->first();
        if ($trashed) {
            $trashed->slug = $slug . '-deleted-' . time();
            $trashed->save();
        }

        $originalSlug = $slug;
        $count = 1;
        while (Hosting::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        $data['slug'] = $slug;

        $uploadedFiles = [];
        foreach(['banner_image_1','banner_image_2','image'] as $img)
        {
            if($request->hasFile($img))
            {
                $file = $request->file($img);
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/hosting'),$name);
                $data[$img] = 'uploads/hosting/'.$name;
                $uploadedFiles[] = $data[$img];
            }
        }

        $data['is_active'] = (bool) $request->input('is_active', 1);

        try {
            Hosting::create($data);
        } catch (\Exception $e) {
            foreach($uploadedFiles as $uploadedFile) {
                if(File::exists(public_path($uploadedFile))) {
                    File::delete(public_path($uploadedFile));
                }
            }
            return redirect()->back()
                ->withInput($request->except(['banner_image_1', 'banner_image_2', 'image']))
                ->withErrors(['error' => 'Failed to add hosting: ' . $e->getMessage()]);
        }

        Alert::success('Success','Hosting Added Successfully.');

        return redirect()->route('admin.hostings.index');
    }





    public function show(Hosting $hosting)
    {
        return view('admin.hosting.show',compact('hosting'));
    }





    public function edit(Hosting $hosting)
    {
        $nextSortOrder = (Hosting::max('sort_order') ?? 0)+1;
        $categories = HostingCategory::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('admin.hosting.add',compact('hosting','nextSortOrder', 'categories'));
    }





    public function update(HostingRequest $request,Hosting $hosting)
    {

        $data = $request->validated();

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Hosting::where('slug', $slug)->where('id', '!=', $hosting->id)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }
        $data['slug'] = $slug;



        foreach(['banner_image_1','banner_image_2','image'] as $img)
        {

            if($request->hasFile($img))
            {

                if($hosting->$img && File::exists(public_path($hosting->$img)))
                {
                    File::delete(public_path($hosting->$img));
                }


                $file = $request->file($img);

                $name = time().'_'.$file->getClientOriginalName();

                $file->move(public_path('uploads/hosting'),$name);

                $data[$img] = 'uploads/hosting/'.$name;

            }

        }



        $data['is_active'] = (bool) $request->input('is_active', 1);


        $hosting->update($data);



        Alert::success('Success','Hosting Updated Successfully.');

        return redirect()->route('admin.hostings.index');

    }





    public function destroy(Hosting $hosting)
    {

        foreach(['banner_image_1','banner_image_2','image'] as $img)
        {

            if($hosting->$img && File::exists(public_path($hosting->$img)))
            {
                File::delete(public_path($hosting->$img));
            }

        }


        $hosting->slug = $hosting->slug . '-deleted-' . time();
        $hosting->save();
        $hosting->delete();

        Alert::success('Success','Hosting Deleted Successfully.');

        return redirect()->route('admin.hostings.index');

    }

    public function toggleStatus(Hosting $hosting)
    {
        $hosting->is_active = !$hosting->is_active;
        $hosting->save();

        return response()->json([
            'success' => true,
            'is_active' => $hosting->is_active,
            'message' => 'Hosting status updated successfully.'
        ]);
    }

}
