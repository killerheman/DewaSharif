@extends('admin.includes.master')

@section('title', 'My Profile - Admin Panel')

@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-dark"><i class="bi bi-person-badge text-success me-2"></i>My Profile</h3>
                    <p class="text-muted mb-0 small">Manage your account information and preferences</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">My Profile</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @php
                $u = $user ?? auth()->user();
                $firstName = is_object($u) ? ($u->first_name ?? 'Shahzade') : 'Shahzade';
                $lastName = is_object($u) ? ($u->last_name ?? 'Alam') : 'Alam';
                $email = is_object($u) ? ($u->email ?? 'shahzade.alam707@gmail.com') : 'shahzade.alam707@gmail.com';
                $phone = is_object($u) ? ($u->phone ?? '+91 9648777223') : '+91 9648777223';
                $designation = is_object($u) ? ($u->designation ?? 'Platform Administrator') : 'Platform Administrator';
                $company = is_object($u) ? ($u->company ?? 'DewaSharif Management') : 'DewaSharif Management';
                $field = is_object($u) ? ($u->field ?? 'Individual') : 'Individual';
                $gender = is_object($u) ? ($u->gender ?? 'Male') : 'Male';
                $address = is_object($u) ? ($u->address ?? 'Dewa Sharif, Barabanki, UP - 225301') : 'Dewa Sharif, Barabanki, UP - 225301';
                $postalCode = is_object($u) ? ($u->postal_code ?? '225301') : '225301';
                $bio = is_object($u) ? ($u->bio ?? 'Lead Administrator & Manager for DewaSharif Portal.') : 'Lead Administrator & Manager for DewaSharif Portal.';
                
                $rawP = is_object($u) ? ($u->photo ?? null) : null;
                $photoPath = (!empty($rawP) && file_exists(public_path($rawP))) ? asset($rawP) : asset('home/images/dewasharif/dewalogos.png');
            @endphp

            <form action="{{ route('admin.profile.update', is_object($u) ? ($u->id ?? 1) : 1) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- PROFILE SUMMARY CARD -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            <i class="bi bi-person-circle text-primary me-2"></i>Profile Summary
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-lg-2 text-center mb-3 mb-lg-0">
                                <img src="{{ $photoPath }}" class="rounded-circle border shadow-sm p-1" width="120" height="120" style="object-fit: cover;" alt="User Photo">
                            </div>
                            <div class="col-lg-6">
                                <h4 class="fw-bold mb-1 text-dark">{{ $firstName }} {{ $lastName }}</h4>
                                <p class="text-muted mb-2"><i class="bi bi-envelope me-1"></i>{{ $email }}</p>
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                    🟢 Active Administrator
                                </span>
                            </div>
                            <div class="col-lg-4">
                                <label class="form-label fw-bold text-dark">Change Profile Photo</label>
                                <input type="file" name="photo" class="form-control" accept="image/*">
                                <small class="text-muted">JPG, PNG, WEBP max 5MB</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- PERSONAL & CONTACT INFORMATION -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            <i class="bi bi-card-heading text-success me-2"></i>Personal &amp; Contact Details
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">First Name *</label>
                                <input type="text" name="first_name" class="form-control" value="{{ old('first_name', $firstName) }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="{{ old('last_name', $lastName) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Email Address (Primary)</label>
                                <input type="email" class="form-control bg-light" value="{{ $email }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Phone / Mobile</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $phone) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Account Type / Field</label>
                                <select name="field" class="form-select">
                                    <option value="Individual" {{ $field === 'Individual' ? 'selected' : '' }}>Individual</option>
                                    <option value="Company" {{ $field === 'Company' ? 'selected' : '' }}>Company</option>
                                    <option value="Organization" {{ $field === 'Organization' ? 'selected' : '' }}>Organization</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="Male" {{ $gender === 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $gender === 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $gender === 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Designation</label>
                                <input type="text" name="designation" class="form-control" value="{{ old('designation', $designation) }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold text-dark">Company / Trust</label>
                                <input type="text" name="company" class="form-control" value="{{ old('company', $company) }}">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ADDRESS & BIO INFORMATION -->
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-header bg-white border-bottom py-3">
                        <h5 class="card-title fw-bold mb-0 text-dark">
                            <i class="bi bi-geo-alt-fill text-danger me-2"></i>Address &amp; Bio Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label fw-bold text-dark">Full Office / Personal Address</label>
                                <textarea name="address" class="form-control" rows="3">{{ old('address', $address) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold text-dark">Postal Code / PIN</label>
                                <input type="text" name="postal_code" class="form-control" value="{{ old('postal_code', $postalCode) }}">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-bold text-dark">About Administrator (Bio)</label>
                                <textarea name="bio" class="form-control" rows="4">{{ old('bio', $bio) }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mb-4">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary px-4 fw-bold">Cancel</a>
                    <button type="submit" class="btn btn-success px-4 fw-bold"><i class="bi bi-floppy me-1"></i> Update Profile</button>
                </div>
            </form>

        </div>
    </div>
</main>
@endsection
