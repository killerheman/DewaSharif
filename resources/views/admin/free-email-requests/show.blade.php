@extends('admin.includes.master')
@section('title', 'View Free Email Request')
@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Free Email Request Details</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.free-email-requests.index') }}">Free Email Requests</a></li>
                        <li class="breadcrumb-item active" aria-current="page">View</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Request Information</h3>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">Status</th>
                                    <td>
                                        @if($freeEmailRequest->status == 'pending')
                                            <span class="badge text-bg-warning">Pending</span>
                                        @elseif($freeEmailRequest->status == 'approved')
                                            <span class="badge text-bg-success">Approved</span>
                                        @else
                                            <span class="badge text-bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>User</th>
                                    <td>{{ $freeEmailRequest->user->name ?? 'N/A' }} ({{ $freeEmailRequest->user->email ?? '' }})</td>
                                </tr>
                                <tr>
                                    <th>Domain Name</th>
                                    <td>{{ $freeEmailRequest->domain_name }}</td>
                                </tr>
                                <tr>
                                    <th>Desired Email</th>
                                    <td><strong>{{ $freeEmailRequest->desired_email . '@' . $freeEmailRequest->domain_name }}</strong></td>
                                </tr>
                                <tr>
                                    <th>Company Name</th>
                                    <td>{{ $freeEmailRequest->company_name ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Message</th>
                                    <td>{{ $freeEmailRequest->message ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Requested On</th>
                                    <td>{{ $freeEmailRequest->created_at->format('d M, Y H:i A') }}</td>
                                </tr>
                                @if($freeEmailRequest->admin_note)
                                <tr>
                                    <th>Admin Note</th>
                                    <td>{{ $freeEmailRequest->admin_note }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>

                @if($freeEmailRequest->status == 'pending')
                <div class="col-md-4">
                    <div class="card card-warning card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Action</h3>
                        </div>
                        <div class="card-body">
                            <p class="text-muted small mb-3">Approving this request will automatically create a 1-year free email plan for the user in the system.</p>
                            
                            <form action="{{ route('admin.free-email-requests.approve', $freeEmailRequest->id) }}" method="POST" class="mb-3">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Admin Note (Optional)</label>
                                    <textarea name="admin_note" class="form-control" rows="2" placeholder="Note to user or internal reference..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100" onclick="return confirm('Are you sure you want to approve this request?');">
                                    <i class="bi bi-check-circle"></i> Approve & Activate
                                </button>
                            </form>

                            <hr>

                            <form action="{{ route('admin.free-email-requests.reject', $freeEmailRequest->id) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Rejection Reason</label>
                                    <textarea name="admin_note" class="form-control" rows="2" placeholder="Tell the user why this was rejected..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to reject this request?');">
                                    <i class="bi bi-x-circle"></i> Reject Request
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
