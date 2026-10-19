@extends('admin.includes.master')

@section('title', 'Invoice Details')

@section('content')

<div class="content-wrapper">

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Invoice Details</h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card">

                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">
                        Invoice #{{ $invoice->invoice_no }}
                    </h3>

                    <div class="d-flex align-items-center gap-2">
                        <form action="{{ route('admin.invoices.send-renewal-reminder', $invoice->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Send renewal reminder email to client?')">
                                <i class="bi bi-envelope-fill"></i>
                                Send Renewal Reminder
                            </button>
                        </form>

                        <a href="{{ route('admin.invoices.download', $invoice->id) }}"
                            class="btn btn-danger">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Download PDF
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6">

                            <h5>User Details</h5>

                            <table class="table table-bordered">

                                <tr>
                                    <th>Name</th>
                                    <td>{{ $invoice->user?->name ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Email</th>
                                    <td>{{ $invoice->user?->email ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Billing Address</th>
                                    <td>{{ $invoice->billing_address ?? '-' }}</td>
                                </tr>

                            </table>

                        </div>


                        <div class="col-md-6">

                            <h5>Invoice Details</h5>

                            <table class="table table-bordered">

                                <tr>
                                    <th>Invoice No</th>
                                    <td>{{ $invoice->invoice_no }}</td>
                                </tr>

                                <tr>
                                    <th>Service Type</th>
                                    <td>{{ $invoice->service_type ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Service Name</th>
                                    <td>{{ $invoice->service_name ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Period</th>
                                    <td>{{ $invoice->period ?? '-' }}</td>
                                </tr>

                                <tr>
                                    <th>Invoice Date</th>
                                    <td>
                                        {{ $invoice->invoice_date?->format('d M Y') ?? '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Payment Status</th>
                                    <td>
                                        @if($invoice->payment_status == 'Paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($invoice->payment_status == 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($invoice->payment_status == 'Failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-secondary">Refunded</span>
                                        @endif
                                    </td>
                                </tr>

                            </table>

                        </div>

                    </div>


                    <hr>


                    <h5>Payment Details</h5>

                    <table class="table table-bordered">

                        <tr>
                            <th>Order ID</th>
                            <td>{{ $invoice->order_id ?? ($invoice->razorpay_order_id ?? '-') }}</td>
                        </tr>

                        <tr>
                            <th>Payment ID</th>
                            <td>{{ $invoice->payment_id ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Subscription ID</th>
                            <td>{{ $invoice->subscription_id ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Amount</th>
                            <td>₹ {{ number_format($invoice->amount, 2) }}</td>
                        </tr>

                        <tr>
                            <th>GST</th>
                            <td>₹ {{ number_format($invoice->gst, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Vendor Amount</th>
                            <td>₹ {{ number_format($invoice->vendor_amount, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Net Total Amount</th>
                            <td>
                                <strong>
                                    ₹ {{ number_format($invoice->net_amount, 2) }}
                                </strong>
                            </td>
                        </tr>

                    </table>


                    <h5>Plan Features</h5>

                    <div class="border rounded p-3">
                        {!! nl2br(e($invoice->plan_features)) !!}
                    </div>

                </div>

            </div>

        </div>
    </section>

</div>

@endsection