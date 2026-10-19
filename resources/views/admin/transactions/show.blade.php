@extends('admin.includes.master')
@section('title', 'Transaction Details')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Transaction Details</h3>
                </div>

                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Transaction Information</h3>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>
                            <th width="250">Invoice No</th>
                            <td>{{ $transaction->invoice_no ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>User</th>
                            <td>{{ $transaction->user->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Gateway</th>
                            <td>{{ $transaction->gateway }}</td>
                        </tr>

                        <tr>
                            <th>Gateway Type</th>
                            <td>{{ $transaction->gateway_type }}</td>
                        </tr>

                        <tr>
                            <th>Order ID</th>
                            <td>{{ $transaction->order_id ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Payment ID</th>
                            <td>{{ $transaction->payment_id ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Transaction ID</th>
                            <td>{{ $transaction->transaction_id ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Amount</th>
                            <td>₹ {{ number_format($transaction->amount, 2) }}</td>
                        </tr>

                        <tr>
                            <th>GST</th>
                            <td>₹ {{ number_format($transaction->gst, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Vendor Amount</th>
                            <td>₹ {{ number_format($transaction->vendor_amount, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Net Amount</th>
                            <td>₹ {{ number_format($transaction->net_amount, 2) }}</td>
                        </tr>

                        <tr>
                            <th>Currency</th>
                            <td>{{ $transaction->currency }}</td>
                        </tr>

                        <tr>
                            <th>Payment Status</th>
                            <td>
                                <span
                                    class="badge bg-{{ $transaction->payment_status == 'Paid' ? 'success' : ($transaction->payment_status == 'Pending' ? 'warning' : ($transaction->payment_status == 'Failed' ? 'danger' : 'secondary')) }}">
                                    {{ $transaction->payment_status }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Paid At</th>
                            <td>{{ $transaction->paid_at ? \Carbon\Carbon::parse($transaction->paid_at)->format('d M Y h:i A') : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>API Response</th>
                            <td>
                                <pre class="mb-0">{{ json_encode($transaction->response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                            </td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $transaction->created_at->format('d M Y h:i A') }}</td>
                        </tr>

                        <tr>
                            <th>Updated At</th>
                            <td>{{ $transaction->updated_at->format('d M Y h:i A') }}</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>
    </div>

@endsection
