@extends('admin.includes.master')
@section('title', 'Edit Business Email')
@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Edit Business Email</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.business-emails.index') }}">Business Emails</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8 mx-auto">
                    <div class="card card-primary card-outline mb-4">
                        <div class="card-header">
                            <h3 class="card-title">Email Subscription Details</h3>
                        </div>
                        <form action="{{ route('admin.business-emails.update', $businessEmail->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">User</label>
                                        <input type="text" class="form-control" value="{{ $businessEmail->user->name ?? 'N/A' }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Plan Name</label>
                                        <input type="text" class="form-control" value="{{ $businessEmail->plan_name }}" disabled>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Email Address</label>
                                        <input type="text" class="form-control" value="{{ $businessEmail->email_address }}" disabled>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Registration Date</label>
                                        <input type="date" class="form-control" value="{{ $businessEmail->registration_date }}" disabled>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Provider Login / App ID (Optional)</label>
                                    <input type="text" name="provider_email_id" class="form-control" value="{{ old('provider_email_id', $businessEmail->provider_email_id) }}" placeholder="e.g., Google Workspace ID or Office 365 Tenant ID">
                                    <small class="text-muted">Store any external provider ID reference here.</small>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Expiry Date</label>
                                    <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date', $businessEmail->expiry_date) }}">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-select" required>
                                        <option value="active" {{ $businessEmail->status == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="suspended" {{ $businessEmail->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                                        <option value="cancelled" {{ $businessEmail->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="expired" {{ $businessEmail->status == 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Update Details</button>
                                <a href="{{ route('admin.business-emails.index') }}" class="btn btn-default float-end">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
