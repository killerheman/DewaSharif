@extends('admin.includes.master')
@section('title', 'Payment Gateways')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Payment Gateways</h3>
                </div>

                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.payment-settings.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add Gateway
                    </a>
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

                            <div class="col-md-5">
                                <input type="text" name="search" class="form-control" placeholder="Search Gateway..."
                                    value="{{ request('search') }}">
                            </div>

                            <div class="col-md-3">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <button class="btn btn-primary">
                                    <i class="bi bi-search"></i> Search
                                </button>

                                <a href="{{ route('admin.payment-settings.index') }}" class="btn btn-secondary">
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
                                <th>Sr. No.</th>
                                <th>Gateway</th>
                                <th>Display Name</th>
                                <th>Currency</th>
                                <th>Sandbox</th>
                                <th>Status</th>
                                <th width="150">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($paymentSettings as $paymentSetting)
                                <tr>

                                    <td>{{ $loop->iteration + ($paymentSettings->firstItem() - 1) }}</td>

                                    <td>{{ $paymentSetting->gateway }}</td>

                                    <td>{{ $paymentSetting->display_name ?? $paymentSetting->gateway }}</td>

                                    <td>{{ $paymentSetting->currency }}</td>

                                    <td>
                                        @if (!empty($paymentSetting->sandbox_mode))
                                            <span class="badge bg-warning">Enabled</span>
                                        @else
                                            <span class="badge bg-secondary">Disabled</span>
                                        @endif
                                    </td>

                                    <td>
                                        <form action="{{ route('admin.payment-settings.toggle', $paymentSetting->id ?? 1) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle Active/Inactive">
                                                @if ($paymentSetting->is_active)
                                                    <span class="badge bg-success" style="cursor: pointer;"><i class="bi bi-toggle-on me-1"></i> Active</span>
                                                @else
                                                    <span class="badge bg-danger" style="cursor: pointer;"><i class="bi bi-toggle-off me-1"></i> Inactive</span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>

                                    <td>

                                        <a href="{{ route('admin.payment-settings.show', $paymentSetting->id ?? 1) }}"
                                            class="btn btn-info btn-sm">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('admin.payment-settings.edit', $paymentSetting->id ?? 1) }}"
                                            class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>

                                        <form action="{{ route('admin.payment-settings.destroy', $paymentSetting->id ?? 1) }}"
                                            method="POST" class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Delete this payment gateway?')">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        No payment gateways found.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                    <div class="mt-3">
                        {{ $paymentSettings->links() }}
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection
