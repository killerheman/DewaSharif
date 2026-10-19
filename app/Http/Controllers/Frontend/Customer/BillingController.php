<?php

namespace App\Http\Controllers\Frontend\Customer;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Setting;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Fetch unique payment_ids for this user
        $paymentIds = Invoice::where('user_id', $userId)
            ->whereNotNull('payment_id')
            ->select('payment_id', \Illuminate\Support\Facades\DB::raw('MAX(id) as max_id'))
            ->groupBy('payment_id')
            ->orderBy('max_id', 'desc')
            ->pluck('payment_id');

        $groupedInvoices = [];
        $processedIds = [];

        foreach ($paymentIds as $pid) {
            $items = Invoice::where('user_id', $userId)
                ->where('payment_id', $pid)
                ->orderBy('id', 'asc')
                ->get();

            if ($items->count() > 0) {
                foreach ($items as $it) {
                    $processedIds[] = $it->id;
                }

                $primary = $items->first();
                $groupedInvoices[] = [
                    'primary_invoice' => $primary,
                    'payment_id' => $pid,
                    'items' => $items,
                    'total_amount' => $items->sum('amount'),
                    'total_gst' => $items->sum('gst'),
                    'total_net' => $items->sum('net_amount'),
                    'invoice_date' => $primary->invoice_date ?? $primary->created_at,
                    'payment_status' => $primary->payment_status ?? 'Paid',
                ];
            }
        }

        // 2. Fetch standalone invoices without payment_id
        $standaloneInvoices = Invoice::where('user_id', $userId)
            ->whereNotIn('id', $processedIds)
            ->latest()
            ->get();

        foreach ($standaloneInvoices as $sInv) {
            $groupedInvoices[] = [
                'primary_invoice' => $sInv,
                'payment_id' => $sInv->payment_id,
                'items' => collect([$sInv]),
                'total_amount' => $sInv->amount,
                'total_gst' => $sInv->gst,
                'total_net' => $sInv->net_amount,
                'invoice_date' => $sInv->invoice_date ?? $sInv->created_at,
                'payment_status' => $sInv->payment_status ?? 'Paid',
            ];
        }

        // Paginate manually
        $page = request()->get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        $invoices = new \Illuminate\Pagination\LengthAwarePaginator(
            array_slice($groupedInvoices, $offset, $perPage, true),
            count($groupedInvoices),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('frontend.customer.my-billing', compact('invoices'));
    }

    /**
     * Download Invoice as PDF
     */
    public function download(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access to invoice.');
        }

        $invoice->load(['user', 'user.country', 'user.state', 'user.city']);
        $setting = Setting::first();

        $pdf = Pdf::loadView('frontend.customer.invoice-pdf', compact('invoice', 'setting'));

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'invoice-' . $invoice->invoice_no . '.pdf', [
            'Content-Type' => 'application/pdf',
        ]);
    }

    public function downloadPdf(Invoice $invoice)
    {
        return $this->download($invoice);
    }

    public function exportCsv()
    {
        $invoices = Invoice::where('user_id', auth()->id())
            ->latest()
            ->get();

        $filename = 'invoices-' . date('Y-m-d') . '.csv';

        return response()->streamDownload(function () use ($invoices) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Invoice No',
                'Payment ID',
                'Service Type',
                'Service Name',
                'Period',
                'Amount',
                'GST (18%)',
                'Total Amount',
                'Payment Status',
                'Billing Address',
                'Invoice Date'
            ]);

            foreach ($invoices as $invoice) {

                fputcsv($handle, [
                    $invoice->id,
                    $invoice->invoice_no,
                    $invoice->payment_id ?? '-',
                    $invoice->service_type ?? '-',
                    $invoice->service_name ?? '-',
                    $invoice->period ?? '-',
                    $invoice->amount,
                    $invoice->gst,
                    $invoice->net_amount,
                    $invoice->payment_status,
                    $invoice->billing_address ?? '-',
                    $invoice->invoice_date ?? $invoice->created_at->format('Y-m-d')
                ]);
            }

            fclose($handle);
        }, $filename);
    }

    public function downloadCsv(Invoice $invoice)
    {
        if ($invoice->user_id !== auth()->id()) {
            abort(403);
        }

        $filename = 'invoice-' . $invoice->invoice_no . '.csv';

        return response()->streamDownload(function () use ($invoice) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['HOSTLOK INVOICE PAYMENT RECEIPT']);
            fputcsv($handle, []);
            fputcsv($handle, ['Invoice No', $invoice->invoice_no]);
            fputcsv($handle, ['Payment ID', $invoice->payment_id ?? '-']);
            fputcsv($handle, ['Customer Name', auth()->user()->name]);
            fputcsv($handle, ['Customer Email', auth()->user()->email]);
            fputcsv($handle, ['Customer Phone', auth()->user()->phone ?? '-']);
            fputcsv($handle, ['Service Type', $invoice->service_type ?? '-']);
            fputcsv($handle, ['Service Name', $invoice->service_name ?? '-']);
            fputcsv($handle, ['Period', $invoice->period ?? '-']);
            fputcsv($handle, ['Amount', $invoice->amount]);
            fputcsv($handle, ['GST (18%)', $invoice->gst]);
            fputcsv($handle, ['Total Amount', $invoice->net_amount]);
            fputcsv($handle, ['Payment Status', $invoice->payment_status ?? 'Paid']);
            fputcsv($handle, ['Billing Address', $invoice->billing_address ?? (auth()->user()->address ?? '-')]);
            fputcsv($handle, ['Invoice Date', $invoice->invoice_date ?? $invoice->created_at->format('Y-m-d')]);

            fclose($handle);
        }, $filename);
    }
}
