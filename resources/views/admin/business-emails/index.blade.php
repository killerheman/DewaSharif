@extends('admin.includes.master')
@section('title', 'Manage Business Emails')
@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Manage Business Emails</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Business Emails</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">All Subscribed Emails</h3>
                            <div class="card-tools">
                                <form action="{{ route('admin.business-emails.index') }}" method="GET" class="d-flex gap-2">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All ({{ $counts['all'] }})</option>
                                        <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Active ({{ $counts['active'] }})</option>
                                        <option value="suspended" {{ $status == 'suspended' ? 'selected' : '' }}>Suspended ({{ $counts['suspended'] }})</option>
                                        <option value="cancelled" {{ $status == 'cancelled' ? 'selected' : '' }}>Cancelled ({{ $counts['cancelled'] }})</option>
                                        <option value="expired" {{ $status == 'expired' ? 'selected' : '' }}>Expired ({{ $counts['expired'] }})</option>
                                    </select>
                                </form>
                            </div>
                        </div>

                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>User</th>
                                        <th>Plan Name</th>
                                        <th>Email Address</th>
                                        <th>Expiry Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($emails as $email)
                                        <tr>
                                            <td>{{ $email->id }}</td>
                                            <td>{{ $email->user->name ?? 'N/A' }}</td>
                                            <td>{{ $email->plan_name }}</td>
                                            <td><strong>{{ $email->email_address }}</strong></td>
                                            <td>{{ $email->expiry_date ? \Carbon\Carbon::parse($email->expiry_date)->format('d M, Y') : 'N/A' }}</td>
                                            <td>
                                                @if($email->status == 'active')
                                                    <span class="badge text-bg-success">Active</span>
                                                @elseif($email->status == 'suspended')
                                                    <span class="badge text-bg-warning">Suspended</span>
                                                @elseif($email->status == 'expired')
                                                    <span class="badge text-bg-secondary">Expired</span>
                                                @else
                                                    <span class="badge text-bg-danger">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.business-emails.edit', $email->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.business-emails.destroy', $email->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this email record?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No business emails found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix border-top">
                            {{ $emails->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
