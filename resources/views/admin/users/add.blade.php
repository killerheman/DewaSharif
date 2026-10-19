@extends('admin.includes.master')

@section('title', isset($user) ? 'Edit User' : 'Add User')

@section('content')

    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">
                <i class="bi bi-person-plus-fill"></i>
                {{ isset($user) ? 'Edit User' : 'Add New User' }}
            </h3>

            <div class="card-tools">
                <a href="{{ route('admin.users.index') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <form action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" method="POST"
            enctype="multipart/form-data">

            @csrf

            @isset($user)
                @method('PUT')
            @endisset

            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control"
                            value="{{ old('first_name', $user->first_name ?? '') }}" placeholder="Enter First Name" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                            value="{{ old('last_name', $user->last_name ?? '') }}" placeholder="Enter Last Name">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Field <span class="text-danger">*</span></label>
                        <select name="field" class="form-select" required>
                            <option value="Individual" @selected(old('field', $user->field ?? '') == 'Individual')>Individual</option>
                            <option value="Company" @selected(old('field', $user->field ?? '') == 'Company')>Company</option>
                            <option value="Organization" @selected(old('field', $user->field ?? '') == 'Organization')>Organization</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control"
                            value="{{ old('email', $user->email ?? '') }}" placeholder="Enter Email">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control"
                            value="{{ old('phone', $user->phone ?? '') }}" placeholder="Enter Phone">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Profile Photo</label>
                        <input type="file" name="photo" class="form-control">

                        @isset($user)
                            @if ($user->photo)
                                @php
                                    $usrImg = str_starts_with($user->photo, 'uploads/') 
                                        ? asset($user->photo) 
                                        : asset('storage/' . $user->photo);
                                @endphp
                                <img src="{{ $usrImg }}" width="80" class="rounded mt-2">
                            @endif
                        @endisset

                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Password @if (!isset($user))
                                <span class="text-danger">*</span>
                            @endif
                        </label>
                        <input type="password" name="password" class="form-control" placeholder="Enter Password">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm Password">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Designation</label>
                        <input type="text" name="designation" class="form-control"
                            value="{{ old('designation', $user->designation ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Company</label>
                        <input type="text" name="company" class="form-control"
                            value="{{ old('company', $user->company ?? '') }}">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>

                        <select name="gender" class="form-select">

                            <option value="">Select Gender</option>

                            <option value="Male" @selected(old('gender', $user->gender ?? '') == 'Male')>Male</option>

                            <option value="Female" @selected(old('gender', $user->gender ?? '') == 'Female')>Female</option>

                            <option value="Other" @selected(old('gender', $user->gender ?? '') == 'Other')>Other</option>

                        </select>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>

                        <select name="is_active" class="form-select">

                            <option value="1" @selected(old('is_active', $user->is_active ?? 1) == 1)>Active</option>

                            <option value="0" @selected(old('is_active', $user->is_active ?? 1) == 0)>Inactive</option>

                        </select>

                    </div>


                    <div class="col-md-6 mb-3">
                        <label class="form-label">Country</label>
                        <select name="country_id" id="country" class="form-select">
                            <option value="">Select Country</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">State</label>
                        <select name="state_id" id="state" class="form-select">
                            <option value="">Select State</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">City</label>
                        <select name="city_id" id="city" class="form-select">
                            <option value="">Select City</option>
                        </select>
                    </div>


                    <div class="col-md-6 mb-3">

                        <label class="form-label">Postal Code</label>

                        <input type="text" name="postal_code" class="form-control"
                            value="{{ old('postal_code', $user->postal_code ?? '') }}">

                    </div>

                    <div class="col-md-6 mb-3">

                        <label class="form-label">Bio</label>

                        <textarea name="bio" rows="3" class="form-control">{{ old('bio', $user->bio ?? '') }}</textarea>

                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>

                        <textarea name="address" rows="3" class="form-control">{{ old('address', $user->address ?? '') }}</textarea>

                    </div>

                </div>

            </div>

            <div class="card-footer text-end">

                <button class="btn btn-success">

                    <i class="bi bi-check-circle"></i>

                    {{ isset($user) ? 'Update User' : 'Save User' }}

                </button>

            </div>

        </form>

    </div>
@endsection

<input type="hidden" id="old_country" value="{{ old('country_id', $user->country_id ?? '') }}">
<input type="hidden" id="old_state" value="{{ old('state_id', $user->state_id ?? '') }}">
<input type="hidden" id="old_city" value="{{ old('city_id', $user->city_id ?? '') }}">

@push('scripts')
    <script>
        $(function() {

            $.get("{{ route('admin.countries') }}", function(data) {
                $.each(data, function(i, c) {
                    $('#country').append(`<option value="${c.id}">${c.name}</option>`);
                });
            });

            $('#country').on('change', function() {

                let id = $(this).val();

                $('#state').html('<option value="">Select State</option>');
                $('#city').html('<option value="">Select City</option>');

                if (id) {
                    $.get("{{ url('admin/states') }}/" + id, function(data) {
                        $.each(data, function(i, s) {
                            $('#state').append(
                                `<option value="${s.id}">${s.name}</option>`);
                        });
                    });
                }

            });

            $('#state').on('change', function() {

                let id = $(this).val();

                $('#city').html('<option value="">Select City</option>');

                if (id) {
                    $.get("{{ url('admin/cities') }}/" + id, function(data) {
                        $.each(data, function(i, c) {
                            $('#city').append(`<option value="${c.id}">${c.name}</option>`);
                        });
                    });
                }

            });

        });
    </script>
@endpush
