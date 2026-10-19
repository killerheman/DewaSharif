<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Notification::with('user');

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

        $notifications = $query->latest()->paginate(10)->withQueryString();

        return view('admin.notifications.view',compact('notifications'));
    }


    public function create()
    {
        $users = User::where('is_active',1)->get();

        return view('admin.notifications.add',compact('users'));
    }


    public function store(NotificationRequest $request)
    {
        Notification::create($request->validated());

        return redirect()
            ->route('admin.notifications.index')
            ->with('success','Notification created successfully.');
    }


    public function show(Notification $notification)
    {
        $notification->load('user');

        return view('admin.notifications.show',compact('notification'));
    }


    public function edit(Notification $notification)
    {
        $users = User::where('is_active',1)->get();

        return view('admin.notifications.add',compact('notification','users'));
    }


    public function update(NotificationRequest $request, Notification $notification)
    {
        $notification->update($request->validated());

        return redirect()
            ->route('admin.notifications.index')
            ->with('success','Notification updated successfully.');
    }


    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()
            ->route('admin.notifications.index')
            ->with('success','Notification deleted successfully.');
    }
}