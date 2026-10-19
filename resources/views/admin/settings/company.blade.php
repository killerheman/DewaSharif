@extends('admin.includes.master')

@section('title', 'Company Settings')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Company Settings</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Company Information</h3>
                </div>

                <form action="{{ route('admin.settings.company.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Name</label>
                                <input type="text" name="company_name"
                                    class="form-control @error('company_name') is-invalid @enderror"
                                    value="{{ old('company_name', $setting->company_name) }}">
                                @error('company_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Email</label>
                                <input type="email" name="company_email"
                                    class="form-control @error('company_email') is-invalid @enderror"
                                    value="{{ old('company_email', $setting->company_email) }}">
                                @error('company_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Company Phone</label>
                                <input type="text" name="company_phone"
                                    class="form-control @error('company_phone') is-invalid @enderror"
                                    value="{{ old('company_phone', $setting->company_phone) }}">
                                @error('company_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">GST Number</label>
                                <input type="text" name="gst_number"
                                    class="form-control @error('gst_number') is-invalid @enderror"
                                    value="{{ old('gst_number', $setting->gst_number) }}">
                                @error('gst_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">PAN Number</label>
                                <input type="text" name="pan_number"
                                    class="form-control @error('pan_number') is-invalid @enderror"
                                    value="{{ old('pan_number', $setting->pan_number) }}">
                                @error('pan_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Header Logo</label>
                                <input type="file" name="logo"
                                    class="form-control @error('logo') is-invalid @enderror">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($setting->logo && file_exists(public_path($setting->logo)))
                                    <img src="{{ asset($setting->logo) }}" class="img-thumbnail mt-2 bg-dark"
                                        width="120">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Footer Logo</label>
                                <input type="file" name="footer_logo"
                                    class="form-control @error('footer_logo') is-invalid @enderror">
                                @error('footer_logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($setting->footer_logo && file_exists(public_path($setting->footer_logo)))
                                    <img src="{{ asset($setting->footer_logo) }}" class="img-thumbnail mt-2"
                                        width="120">
                                @else
                                    <img src="{{ asset('frontend/assets/images/hostlok-logo-footer.png') }}" class="img-thumbnail mt-2"
                                        width="120" title="Default Footer Logo">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Favicon</label>
                                <input type="file" name="favicon"
                                    class="form-control @error('favicon') is-invalid @enderror">
                                @error('favicon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @if ($setting->favicon && file_exists(public_path($setting->favicon)))
                                    <img src="{{ asset($setting->favicon) }}" class="img-thumbnail mt-2"
                                        width="50">
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">City</label>
                                <input type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ old('city', $setting->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">State</label>
                                <input type="text" name="state"
                                    class="form-control @error('state') is-invalid @enderror"
                                    value="{{ old('state', $setting->state) }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ old('country', $setting->country) }}">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Postal Code</label>
                                <input type="text" name="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    value="{{ old('postal_code', $setting->postal_code) }}">
                                @error('postal_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Address</label>
                                <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror">{{ old('address', $setting->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>





                        </div>

                    </div>

                    <div class="card-footer">
                        <button class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Update Settings
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection
