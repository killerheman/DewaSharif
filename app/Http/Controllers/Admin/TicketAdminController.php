<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Helpers\DataStore;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class TicketAdminController extends Controller
{
    public function index()
    {
        $dataStoreTickets = DataStore::getCollection('tickets');

        try {
            $dbTickets = SupportTicket::with('user')->latest()->get();
            foreach ($dbTickets as $dbT) {
                $exists = false;
                foreach ($dataStoreTickets as $dsT) {
                    if (($dsT['ticket_id'] ?? '') === ($dbT->ticket_no ?? '')) {
                        $exists = true;
                        break;
                    }
                }
                if (!$exists) {
                    $dataStoreTickets[] = [
                        'id' => $dbT->id,
                        'ticket_id' => $dbT->ticket_no ?? 'TKT-' . $dbT->id,
                        'customer_name' => $dbT->user->name ?? 'Guest User',
                        'contact' => $dbT->user->email ?? 'N/A',
                        'subject' => $dbT->subject,
                        'message' => $dbT->message ?? 'No detail provided.',
                        'category' => 'General Support',
                        'priority' => 'Normal',
                        'status' => $dbT->status ?? 'Open',
                        'created_at' => $dbT->created_at ? $dbT->created_at->format('Y-m-d H:i:s') : date('Y-m-d H:i:s'),
                    ];
                }
            }
        } catch (\Throwable $e) {
            // Silence DB exception if table doesn't exist
        }

        $tickets = array_reverse($dataStoreTickets);

        return view('admin.tickets.index', compact('tickets'));
    }

    public function resolve($id)
    {
        DataStore::updateItem('tickets', $id, ['status' => 'Resolved']);

        try {
            SupportTicket::where('ticket_no', $id)->orWhere('id', $id)->update(['status' => 'Resolved']);
        } catch (\Throwable $e) {}

        return back()->with('success', "Support Ticket #{$id} marked as Resolved!");
    }

    public function updateStatus(Request $request, $id)
    {
        $status = $request->input('status', 'Resolved');
        DataStore::updateItem('tickets', $id, ['status' => $status]);

        try {
            SupportTicket::where('ticket_no', $id)->orWhere('id', $id)->update(['status' => $status]);
        } catch (\Throwable $e) {}

        return back()->with('success', "Support Ticket status updated to {$status}!");
    }

    public function reply(Request $request, $id)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $replyMessage = $request->input('reply');
        
        DataStore::updateItem('tickets', $id, [
            'admin_reply' => $replyMessage,
            'replied_at' => date('Y-m-d H:i:s'),
            'status' => 'In Progress'
        ]);

        try {
            $st = SupportTicket::where('ticket_no', $id)->orWhere('id', $id)->first();
            if ($st) {
                $st->replies()->create([
                    'user_id' => auth()->id() ?? 1,
                    'message' => $replyMessage
                ]);
                $st->update(['status' => 'In Progress']);
            }
        } catch (\Throwable $e) {}

        return back()->with('success', "Admin reply sent for Ticket #{$id}!");
    }

    public function destroy($id)
    {
        DataStore::deleteItem('tickets', $id);

        try {
            SupportTicket::where('ticket_no', $id)->orWhere('id', $id)->delete();
        } catch (\Throwable $e) {}

        return back()->with('success', "Support Ticket deleted successfully.");
    }
}

