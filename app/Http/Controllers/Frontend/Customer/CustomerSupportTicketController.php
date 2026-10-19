<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;

class CustomerSupportTicketController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.customer.tickets.index', compact('tickets'));
    }


    public function show(SupportTicket $ticket)
    {
        abort_if($ticket->user_id != auth()->id(), 403);

        $ticket->load([
            'replies.user'
        ]);

        return view('frontend.customer.tickets.show', compact('ticket'));
    }

    public function destroy(SupportTicket $ticket)
    {
        abort_if($ticket->user_id != auth()->id(), 403);

        $ticket->delete();

        return redirect()
            ->back()
            ->with('success', 'Ticket deleted successfully.');
    }
}
