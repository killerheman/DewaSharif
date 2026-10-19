@extends('admin.includes.master')
@section('title', 'Free Email Requests')
@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Free Email Requests</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Free Email Requests</li>
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
                            <h3 class="card-title">All Requests</h3>
                            <div class="card-tools">
                                <form action="{{ route('admin.free-email-requests.index') }}" method="GET" class="d-flex gap-2">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>All ({{ $counts['all'] }})</option>
                                        <option value="pending" {{ $status == 'pending' ? 'selected' : '' }}>Pending ({{ $counts['pending'] }})</option>
                                        <option value="approved" {{ $status == 'approved' ? 'selected' : '' }}>Approved ({{ $counts['approved'] }})</option>
                                        <option value="rejected" {{ $status == 'rejected' ? 'selected' : '' }}>Rejected ({{ $counts['rejected'] }})</option>
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
                                        <th>Domain</th>
                                        <th>Email Requested</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($requests as $request)
                                        <tr>
                                            <td>{{ $request->id }}</td>
                                            <td>{{ $request->user->name ?? 'N/A' }}</td>
                                            <td>{{ $request->domain_name }}</td>
                                            <td>{{ $request->desired_email . '@' . $request->domain_name }}</td>
                                            <td>
                                                @if($request->status == 'pending')
                                                    <span class="badge text-bg-warning">Pending</span>
                                                @elseif($request->status == 'approved')
                                                    <span class="badge text-bg-success">Approved</span>
                                                @else
                                                    <span class="badge text-bg-danger">Rejected</span>
                                                @endif
                                            </td>
                                            <td>{{ $request->created_at->format('d M, Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin.free-email-requests.show', $request->id) }}" class="btn btn-sm btn-primary">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                                <form action="{{ route('admin.free-email-requests.destroy', $request->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this request?');">
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
                                            <td colspan="7" class="text-center">No requests found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix border-top">
                            {{ $requests->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
