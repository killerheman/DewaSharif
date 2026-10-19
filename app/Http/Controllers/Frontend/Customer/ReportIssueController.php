<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReportIssueRequest;
use App\Models\SupportTicket;

class ReportIssueController extends Controller
{
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('frontend.customer.report-issue', compact('tickets'));
    }

    public function store(ReportIssueRequest $request)
    {
        $maxRetry = 10;
        $created = false;

        for ($i = 0; $i < $maxRetry; $i++) {
            try {
                SupportTicket::create([
                    'user_id'   => auth()->id(),
                    'ticket_no' => $this->generateTicketNumber($i),
                    'subject'   => $request->subject,
                    'message'   => $request->message,
                    'status'    => 'Open',
                ]);
                $created = true;
                break;
            } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                continue;
            } catch (\Exception $e) {
                if (str_contains($e->getMessage(), '1062') || str_contains($e->getMessage(), 'Duplicate entry')) {
                    continue;
                }
                throw $e;
            }
        }

        if (!$created) {
            return back()->with('error', 'Unable to generate unique ticket number. Please try again.');
        }

        return redirect()
            ->route('customer.report.issue')
            ->with('success', 'Your report has been submitted to us. You will get a response shortly.');
    }

    private function generateTicketNumber(int $offset = 0): string
    {
        $maxNumber = SupportTicket::pluck('ticket_no')
            ->map(function ($no) {
                return (int) preg_replace('/[^0-9]/', '', (string)$no);
            })
            ->max();

        $number = ($maxNumber ? $maxNumber : 0) + 1 + $offset;

        do {
            $ticketNo = 'SUP-' . str_pad($number, 6, '0', STR_PAD_LEFT);
            $exists = SupportTicket::whereRaw('LOWER(TRIM(ticket_no)) = ?', [strtolower(trim($ticketNo))])->exists();
            if ($exists) {
                $number++;
            }
        } while ($exists);

        return $ticketNo;
    }
}
