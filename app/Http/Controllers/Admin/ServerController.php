<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServerRequest;
use App\Models\Server;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\ServerCategory;

class ServerController extends Controller
{

    public function index(Request $request)
    {
        $servers = Server::when($request->search,function($q) use($request){
            $q->where('name','like','%'.$request->search.'%');
        })
        ->when($request->filled('status'), function($q) use($request){
            $q->where('is_active', $request->status);
        })
        ->orderBy('sort_order','asc')
        ->latest()
        ->paginate(10)
        ->withQueryString();

        return view('admin.server.view',compact('servers'));
    }


    public function create()
    {
        $nextSortOrder = (Server::max('sort_order') ?? 0)+1;
        $categories = ServerCategory::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('admin.server.add',compact('nextSortOrder', 'categories'));
    }


    public function store(ServerRequest $request)
    {
        $data = $request->validated();

        $slug = Str::slug($request->name);

        $trashed = Server::onlyTrashed()->where('slug', $slug)->first();
        if ($trashed) {
            $trashed->slug = $slug . '-deleted-' . time();
            $trashed->save();
        }

        $originalSlug = $slug;
        $count = 1;
        while (Server::withTrashed()->where('slug', $slug)->exists()) {
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
                $file->move(public_path('uploads/server'),$name);
                $data[$img] = 'uploads/server/'.$name;
                $uploadedFiles[] = $data[$img];
            }
        }

        $data['sort_order'] ??= (Server::max('sort_order') ?? 0)+1;
        $data['is_active'] = (bool) $request->input('is_active', 1);

        try {
            Server::create($data);
        } catch (\Exception $e) {
            foreach($uploadedFiles as $uploadedFile) {
                if(File::exists(public_path($uploadedFile))) {
                    File::delete(public_path($uploadedFile));
                }
            }
            return redirect()->back()
                ->withInput($request->except(['banner_image_1', 'banner_image_2', 'image']))
                ->withErrors(['error' => 'Failed to add server: ' . $e->getMessage()]);
        }

        Alert::success('Success','Server Added Successfully.');

        return redirect()->route('admin.servers.index');
    }


    public function show(Server $server)
    {
        return view('admin.server.show',compact('server'));
    }


    public function edit(Server $server)
    {
        $nextSortOrder = (Server::max('sort_order') ?? 0)+1;
        $categories = ServerCategory::where('is_active', true)->orderBy('sort_order', 'asc')->get();

        return view('admin.server.add',compact('server','nextSortOrder', 'categories'));
    }


    public function update(ServerRequest $request,Server $server)
    {
        $data = $request->validated();

        $data['slug'] = $server->slug;


        foreach(['banner_image_1','banner_image_2','image'] as $img)
        {
            if($request->hasFile($img))
            {

                if($server->$img && File::exists(public_path($server->$img)))
                {
                    File::delete(public_path($server->$img));
                }


                $file = $request->file($img);

                $name = time().'_'.$file->getClientOriginalName();

                $file->move(public_path('uploads/server'),$name);

                $data[$img] = 'uploads/server/'.$name;
            }
        }


        $data['is_active'] = (bool) $request->input('is_active', 1);


        $server->update($data);


        Alert::success('Success','Server Updated Successfully.');

        return redirect()->route('admin.servers.index');
    }


    public function destroy(Server $server)
    {

        foreach(['banner_image_1','banner_image_2','image'] as $img)
        {
            if($server->$img && File::exists(public_path($server->$img)))
            {
                File::delete(public_path($server->$img));
            }
        }


        $server->slug = $server->slug . '-deleted-' . time();
        $server->save();
        $server->delete();

        Alert::success('Success','Server Deleted Successfully.');

        return redirect()->route('admin.servers.index');
    }

}
