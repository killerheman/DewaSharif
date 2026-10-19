<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DomainRequest;
use App\Models\Domain;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        $query = Domain::query();

        if($request->filled('search')){
            $search = $request->search;

            $query->where(function($q) use($search){
                $q->where('extension','like',"%{$search}%")
                  ->orWhere('offer','like',"%{$search}%")
                  ->orWhere('registrar','like',"%{$search}%");
            });
        }

        if($request->filled('status')){
            $query->where('is_active',$request->status);
        }

        $domains = $query->orderBy('sort_order')
                         ->latest()
                         ->paginate(10)
                         ->withQueryString();

        $nextSortOrder = (Domain::max('sort_order') ?? 0) + 1;

        return view('admin.domains.view',compact('domains','nextSortOrder'));
    }

    public function create()
    {
        $nextSortOrder = (Domain::max('sort_order') ?? 0) + 1;

        return view('admin.domains.add',compact('nextSortOrder'));
    }

    public function store(DomainRequest $request)
    {
        Domain::create($request->validated());

        return redirect()
            ->route('admin.domains.index')
            ->with('success','Domain created successfully.');
    }

    public function show(Domain $domain)
    {
        return view('admin.domains.show',compact('domain'));
    }

    public function edit(Domain $domain)
    {
        $nextSortOrder = (Domain::max('sort_order') ?? 0) + 1;

        return view('admin.domains.add',compact('domain','nextSortOrder'));
    }

    public function update(DomainRequest $request, Domain $domain)
    {
        $domain->update($request->validated());

        return redirect()
            ->route('admin.domains.index')
            ->with('success','Domain updated successfully.');
    }

    public function destroy(Domain $domain)
    {
        $domain->delete();

        return redirect()
            ->route('admin.domains.index')
            ->with('success','Domain deleted successfully.');
    }

    public function registered(Request $request)
    {
        $query = \App\Models\DomainOrder::with('user');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('domain', 'like', "%{$search}%")
                  ->orWhere('payment_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $domains = $query->latest()->paginate(15)->withQueryString();

        return view('admin.domains.registered', compact('domains'));
    }
}