<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        try {
            $contacts = Contact::latest()->paginate(20);
        } catch (\Throwable $e) {
            $dsContacts = \App\Helpers\DataStore::getCollection('contacts');
            $items = collect($dsContacts)->map(function ($c) {
                return (object) [
                    'id' => $c['id'] ?? rand(100, 999),
                    'name' => $c['name'] ?? 'Pilgrim Visitor',
                    'email' => $c['email'] ?? 'visitor@dewasharif.com',
                    'mobile' => $c['mobile'] ?? ($c['phone'] ?? '+91 9648777223'),
                    'subject' => $c['subject'] ?? 'General Contact Inquiry',
                    'message' => $c['message'] ?? 'Inquiry details submitted via contact form.',
                    'created_at' => \Carbon\Carbon::parse($c['created_at'] ?? now()),
                ];
            });

            $page = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
            $perPage = 20;
            $contacts = new \Illuminate\Pagination\LengthAwarePaginator(
                $items->forPage($page, $perPage)->values(),
                $items->count(),
                $perPage,
                $page,
                ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
            );
        }

        return view('admin.contact.index', compact('contacts'));
    }

    public function destroy($id)
    {
        try {
            $contact = Contact::find($id);
            if ($contact) {
                $contact->delete();
            }
        } catch (\Throwable $e) {}

        \App\Helpers\DataStore::deleteItem('contacts', $id);

        return redirect()->route('admin.contacts')->with('success', 'Contact inquiry deleted successfully.');
    }

    public function reply(Request $request, $id)
    {
        $data = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $contact = null;
        try {
            $contact = Contact::find($id);
        } catch (\Throwable $e) {
        }

        if (!$contact) {
            $contactData = collect(\App\Helpers\DataStore::getCollection('contacts'))
                ->first(fn ($item) => (string) ($item['id'] ?? '') === (string) $id);
            $contact = $contactData ? (object) $contactData : null;
        }

        if (!$contact || empty($contact->email)) {
            return redirect()->route('admin.contacts')->with('error', 'Contact inquiry not found.');
        }

        try {
            \Illuminate\Support\Facades\Mail::to($contact->email)
                ->send(new \App\Mail\ContactReplyMail($data['message'], $data['subject']));
        } catch (\Throwable $e) {
            return redirect()->route('admin.contacts')->with('error', 'Reply could not be sent. Check the mail configuration and try again.');
        }

        \App\Helpers\DataStore::updateItem('contacts', $id, [
            'reply_subject' => $data['subject'],
            'reply_message' => $data['message'],
            'replied_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->route('admin.contacts')->with('success', 'Reply sent successfully.');
    }
}
