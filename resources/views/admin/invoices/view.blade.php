@extends('admin.includes.master')
@section('title', 'Invoice & Billing')
@section('content')

    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">

                <div class="d-flex justify-content-between align-items-center">

                    <h1>
                        Invoice & Billing
                    </h1>

                    <a href="{{ route('admin.invoices.export') }}" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i>
                        Export CSV
                    </a>

                </div>

            </div>
        </div>


        <section class="content">
            <div class="container-fluid">

                <div class="card">

                    <div class="card-header">

                        <form method="GET" action="{{ route('admin.invoices.index') }}">

                            <div class="row">

                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search invoice..." value="{{ request('search') }}">
                                </div>

                                <div class="col-md-3">

                                    <select name="payment_status" class="form-control">

                                        <option value="">
                                            All Status
                                        </option>

                                        <option value="Pending"
                                            {{ request('payment_status') == 'Pending' ? 'selected' : '' }}>
                                            Pending
                                        </option>

                                        <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>
                                            Paid
                                        </option>

                                        <option value="Failed"
                                            {{ request('payment_status') == 'Failed' ? 'selected' : '' }}>
                                            Failed
                                        </option>

                                        <option value="Refunded"
                                            {{ request('payment_status') == 'Refunded' ? 'selected' : '' }}>
                                            Refunded
                                        </option>

                                    </select>

                                </div>


                                <div class="col-md-2">

                                    <button class="btn btn-primary w-100">
                                        <i class="bi bi-search"></i>
                                        Search
                                    </button>

                                </div>


                                <div class="col-md-2">

                                    <a href="{{ route('admin.invoices.index') }}" class="btn btn-secondary w-100">
                                        Reset
                                    </a>

                                </div>

                            </div>

                        </form>

                    </div>


                    <div class="card-body table-responsive">

                        <table class="table table-bordered table-striped">

                            <thead>

                                <tr>
                                    <th>S.No.</th>
                                    <th>Invoice No</th>
                                    <th>User</th>
                                    <th>Service</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>

                            </thead>


                            <tbody>

                                @forelse($invoices as $invoice)
                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $invoice->invoice_no }}
                                        </td>


                                        <td>
                                            {{ $invoice->user?->name ?? '-' }}
                                        </td>


                                        <td>
                                            {{ $invoice->service_type ?? '-' }}<br>
                                            {{ $invoice->service_name ?? '-' }}
                                        </td>


                                        <td>
                                            ₹ {{ number_format($invoice->net_amount, 2) }}
                                        </td>


                                        <td>

                                            @if ($invoice->payment_status == 'Paid')
                                                <span class="badge bg-success">
                                                    Paid
                                                </span>
                                            @elseif($invoice->payment_status == 'Pending')
                                                <span class="badge bg-warning">
                                                    Pending
                                                </span>
                                            @elseif($invoice->payment_status == 'Failed')
                                                <span class="badge bg-danger">
                                                    Failed
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    Refunded
                                                </span>
                                            @endif

                                        </td>


                                        <td>
                                            {{ $invoice->invoice_date?->format('d M Y') ?? '-' }}
                                        </td>


                                        <td>

                                            <a href="{{ route('admin.invoices.show', ['id' => $invoice->id, 'type' => $invoice->type ?? 'hotel']) }}"
                                                class="btn btn-sm btn-info" title="View Details" target="_blank">

                                                <i class="bi bi-eye"></i>

                                            </a>


                                            <a href="{{ route('admin.invoices.download', ['id' => $invoice->id, 'type' => $invoice->type ?? 'hotel']) }}"
                                                class="btn btn-sm btn-danger" title="Download PDF" target="_blank">

                                                <i class="bi bi-file-earmark-pdf"></i>

                                            </a>

                                            <form action="{{ route('admin.invoices.send-renewal-reminder', $invoice->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Send renewal reminder email to user?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" title="Send Renewal Reminder">
                                                    <i class="bi bi-bell"></i>
                                                </button>
                                            </form>

                                        </td>

                                    </tr>


                                @empty

                                    <tr>

                                        <td colspan="8" class="text-center">
                                            No invoices found
                                        </td>

                                    </tr>
                                @endforelse


                            </tbody>

                        </table>

                    </div>


                    <div class="card-footer">

                        {{ $invoices->links() }}

                    </div>


                </div>

            </div>
        </section>

    </div>

@endsection
