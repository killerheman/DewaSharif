@extends('admin.includes.master')
@section('title', 'Transactions')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Transactions</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card">

                <div class="card-header">

                    <form method="GET">

                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control"
                                    placeholder="Search Transaction..." value="{{ request('search') }}">
                            </div>

                            <div class="col-md-3">
                                <select name="gateway" class="form-select">
                                    <option value="">All Gateways</option>
                                    <option value="Razorpay" {{ request('gateway') == 'Razorpay' ? 'selected' : '' }}>Razorpay
                                    </option>
                                    <option value="PayPal" {{ request('gateway') == 'PayPal' ? 'selected' : '' }}>PayPal</option>
                                </select>
                            </div>

                            {{-- <div class="col-md-3">
                                <select name="payment_status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="Pending" {{ request('payment_status') == 'Pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="Paid" {{ request('payment_status') == 'Paid' ? 'selected' : '' }}>Paid
                                    </option>
                                    <option value="Failed" {{ request('payment_status') == 'Failed' ? 'selected' : '' }}>Failed
                                    </option>
                                    <option value="Refunded" {{ request('payment_status') == 'Refunded' ? 'selected' : '' }}>
                                        Refunded</option>
                                </select>
                            </div> --}}

                            <div class="col-md-2">
                                <button class="btn btn-primary">
                                    <i class="bi bi-search"></i>
                                </button>

                                <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                                    Reset
                                </a>
                            </div>

                        </div>

                    </form>

                </div>

                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped align-middle">

                        <thead>

                            <tr>
                                <th>Sr.No</th>
                                <th>Invoice</th>
                                <th>User</th>
                                <th>Gateway</th>
                                <th>Transaction ID</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th width="80">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($transactions as $transaction)
                                <tr>

                                    <td>{{ $loop->iteration + ($transactions->firstItem() - 1) }}</td>

                                    <td>{{ $transaction->invoice_no ?? '-' }}</td>

                                    <td>{{ $transaction->user->name ?? '-' }}</td>

                                    <td>{{ $transaction->gateway }}</td>

                                    <td>{{ $transaction->transaction_id ?? '-' }}</td>

                                    <td>₹ {{ number_format($transaction->amount, 2) }}</td>

                                    <td>
                                        @if ($transaction->payment_status == 'Paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($transaction->payment_status == 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($transaction->payment_status == 'Failed')
                                            <span class="badge bg-danger">Failed</span>
                                        @else
                                            <span class="badge bg-secondary">Refunded</span>
                                        @endif
                                    </td>

                                    <td>

                                        <a href="{{ route('admin.transactions.show', $transaction->id ?? 1) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        No transactions found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                    <div class="mt-3">
                        {{ $transactions->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
