@extends('admin.includes.master')

@section('title', 'Change Password - DewaSharif Admin')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-dark"><i class="bi bi-key-fill text-success me-2"></i>Change Password</h3>
                    <p class="text-muted mb-0 small">Update your admin account password for enhanced security</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.profile.index') }}">My Account</a></li>
                        <li class="breadcrumb-item active">Change Password</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            
            <div class="row justify-content-center">
                <div class="col-md-6">

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm mb-4">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card shadow-sm border-0 rounded-3 mb-4">
                        <div class="card-header bg-white border-bottom py-3">
                            <h5 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-shield-lock text-primary me-2"></i>Security &amp; Password Update
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('admin.change.password.store') }}" method="POST">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold text-dark">Current Password *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Enter current password" required>
                                        <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="password" title="Show / Hide Password" aria-label="Toggle password visibility">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="newpassword" class="form-label fw-bold text-dark">New Password *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-key"></i></span>
                                        <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="Enter new password (min 6 chars)" required>
                                        <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="newpassword" title="Show / Hide Password" aria-label="Toggle password visibility">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="newpassword_confirmation" class="form-label fw-bold text-dark">Confirm New Password *</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-shield-check"></i></span>
                                        <input type="password" name="newpassword_confirmation" id="newpassword_confirmation" class="form-control" placeholder="Re-enter new password" required>
                                        <button class="btn btn-outline-secondary toggle-password-btn" type="button" data-target="newpassword_confirmation" title="Show / Hide Password" aria-label="Toggle password visibility">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-success btn-lg fw-bold">
                                        <i class="bi bi-check-circle-fill me-1"></i> Update Password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</main>
@endsection
