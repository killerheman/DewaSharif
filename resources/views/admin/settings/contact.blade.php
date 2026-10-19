@extends('admin.includes.master')

@section('title', 'Contact Settings')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Contact Settings</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Contact Information</h3>
                </div>

                <form action="{{ route('admin.settings.contact.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Support Email</label>
                                <input type="email" name="support_email"
                                    class="form-control @error('support_email') is-invalid @enderror"
                                    value="{{ old('support_email', $setting->support_email) }}"
                                    placeholder="e.g. hostloksupport@gmail.com">
                                @error('support_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sales Email</label>
                                <input type="email" name="sales_email"
                                    class="form-control @error('sales_email') is-invalid @enderror"
                                    value="{{ old('sales_email', $setting->sales_email) }}"
                                    placeholder="e.g. hostloksales@gmail.com">
                                @error('sales_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Billing Email</label>
                                <input type="email" name="billing_email"
                                    class="form-control @error('billing_email') is-invalid @enderror"
                                    value="{{ old('billing_email', $setting->billing_email) }}"
                                    placeholder="e.g. billing@hostlok.com">
                                @error('billing_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Technical Support Phone</label>
                                <input type="text" name="support_phone"
                                    class="form-control @error('support_phone') is-invalid @enderror"
                                    value="{{ old('support_phone', $setting->support_phone) }}"
                                    placeholder="e.g. 45664561472">
                                @error('support_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sales Support Phone</label>
                                <input type="text" name="sales_phone"
                                    class="form-control @error('sales_phone') is-invalid @enderror"
                                    value="{{ old('sales_phone', $setting->sales_phone) }}"
                                    placeholder="e.g. +91-7077860707">
                                @error('sales_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Phone</label>
                                <input type="text" name="website_phone"
                                    class="form-control @error('website_phone') is-invalid @enderror"
                                    value="{{ old('website_phone', $setting->website_phone ?? $setting->phone) }}"
                                    placeholder="e.g. +91 84476 85933">
                                @error('website_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp</label>
                                <input type="text" name="whatsapp"
                                    class="form-control @error('whatsapp') is-invalid @enderror"
                                    value="{{ old('whatsapp', $setting->whatsapp) }}"
                                    placeholder="e.g. +91 3652635214">
                                @error('whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Office Hours</label>
                                <input type="text" name="office_hours"
                                    class="form-control @error('office_hours') is-invalid @enderror"
                                    value="{{ old('office_hours', $setting->office_hours) }}"
                                    placeholder="e.g. Mon-Fri : 11:00 AM - 4:00 PM">
                                @error('office_hours')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Update Settings
                        </button>
                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection