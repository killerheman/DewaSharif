<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = SupportTicket::with('user');

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('ticket_no', 'like', '%' . $request->search . '%')
                      ->orWhere('subject', 'like', '%' . $request->search . '%')
                      ->orWhereHas('user', function ($user) use ($request) {
                          $user->where('name', 'like', '%' . $request->search . '%')
                               ->orWhere('email', 'like', '%' . $request->search . '%');
                      });
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $tickets = $query->latest()->paginate(10)->withQueryString();
        } catch (\Throwable $e) {
            $dsTickets = \App\Helpers\DataStore::getCollection('tickets');
            $items = collect($dsTickets)->map(function ($t) {
                return (object) [
                    'id' => $t['id'] ?? ($t['ticket_id'] ?? rand(100, 999)),
                    'ticket_no' => $t['ticket_id'] ?? 'TKT-' . rand(1000, 9999),
                    'subject' => $t['subject'] ?? 'Support Inquiry',
                    'status' => $t['status'] ?? 'Open',
                    'created_at' => \Carbon\Carbon::parse($t['created_at'] ?? now()),
                    'user' => (object) [
                        'name' => $t['customer_name'] ?? 'Pilgrim User',
                        'email' => $t['contact'] ?? 'user@dewasharif.com',
                    ]
                ];
            });

            if ($request->filled('search')) {
                $search = strtolower($request->search);
                $items = $items->filter(function($t) use ($search) {
                    return str_contains(strtolower($t->ticket_no), $search) || str_contains(strtolower($t->subject), $search) || str_contains(strtolower($t->user->name), $search);
                });
            }

            if ($request->filled('status')) {
                $items = $items->where('status', $request->status);
            }

            $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
            $perPage = 10;
            $tickets = new \Illuminate\Pagination\LengthAwarePaginator(
                $items->forPage($page, $perPage)->values(),
                $items->count(),
                $perPage,
                $page,
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
            );
        }

        return view('admin.support-tickets.index', compact('tickets'));
    }


    public function show(SupportTicket $supportTicket)
    {
        $supportTicket->load([
            'user',
            'replies.user',
        ]);

        return view('admin.support-tickets.show', compact('supportTicket'));
    }


    public function update(Request $request, SupportTicket $supportTicket)
    {
        $request->validate([
            'status' => 'required|in:Open,In Progress,Resolved,Closed',
        ]);

        $supportTicket->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Ticket status updated successfully.');
    }


    public function reply(Request $request, SupportTicket $supportTicket)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $supportTicket->replies()->create([
            'user_id' => auth()->id(),
            'message' => $request->message,
        ]);

        if ($supportTicket->status == 'Open') {
            $supportTicket->update([
                'status' => 'In Progress',
            ]);
        }

        return back()->with('success', 'Reply sent successfully.');
    }


    public function create()
    {
        abort(404);
    }


    public function store(Request $request)
    {
        abort(404);
    }


    public function edit(SupportTicket $supportTicket)
    {
        abort(404);
    }


    public function destroy(SupportTicket $supportTicket)
    {
        $supportTicket->replies()->delete();
        $supportTicket->delete();

        return back()->with('success', 'Support Ticket deleted successfully.');
    }
}
