<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Models\User;
use Illuminate\Http\Request;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $query = Offer::with('user');

        if($request->filled('search')){
            $search = $request->search;

            $query->where(function($q) use($search){
                $q->where('title','like',"%{$search}%")
                  ->orWhere('message','like',"%{$search}%");
            });
        }

        if($request->filled('type')){
            $query->where('type',$request->type);
        }

        if($request->filled('status')){
            $query->where('is_active',$request->status);
        }

        $offers = $query->latest()->paginate(10)->withQueryString();

        return view('admin.offers.view',compact('offers'));
    }


    public function create()
    {
        $users = User::where('is_active',1)->get();

        return view('admin.offers.add',compact('users'));
    }


    public function store(OfferRequest $request)
    {
        Offer::create($request->validated());

        return redirect()
            ->route('admin.offers.index')
            ->with('success','Offer created successfully.');
    }


    public function show(Offer $offer)
    {
        $offer->load('user');

        return view('admin.offers.show',compact('offer'));
    }


    public function edit(Offer $offer)
    {
        $users = User::where('is_active',1)->get();

        return view('admin.offers.add',compact('offer','users'));
    }


    public function update(OfferRequest $request, Offer $offer)
    {
        $offer->update($request->validated());

        return redirect()
            ->route('admin.offers.index')
            ->with('success','Offer updated successfully.');
    }


    public function destroy(Offer $offer)
    {
        $offer->delete();

        return redirect()
            ->route('admin.offers.index')
            ->with('success','Offer deleted successfully.');
    }
}