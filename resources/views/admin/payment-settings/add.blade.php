@extends('admin.includes.master')
@section('title', isset($paymentSetting) ? 'Edit Payment Gateway' : 'Add Payment Gateway')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($paymentSetting) ? 'Edit Payment Gateway' : 'Add Payment Gateway' }}</h3>
                </div>

                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.payment-settings.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">
                        {{ isset($paymentSetting) ? 'Update Payment Gateway' : 'Create Payment Gateway' }}
                    </h3>
                </div>

                <form
                    action="{{ isset($paymentSetting) ? route('admin.payment-settings.update', $paymentSetting) : route('admin.payment-settings.store') }}"
                    method="POST">

                    @csrf
                    @isset($paymentSetting)
                        @method('PUT')
                    @endisset

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Gateway <span class="text-danger">*</span></label>

                                <select name="gateway" class="form-select @error('gateway') is-invalid @enderror">
                                    <option value="">Select Gateway</option>
                                    <option value="Razorpay"
                                        {{ old('gateway', $paymentSetting->gateway ?? '') == 'Razorpay' ? 'selected' : '' }}>
                                        Razorpay
                                    </option>
                                    <option value="PayPal"
                                        {{ old('gateway', $paymentSetting->gateway ?? '') == 'PayPal' ? 'selected' : '' }}>
                                        PayPal
                                    </option>
                                </select>

                                @error('gateway')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Display Name <span class="text-danger">*</span></label>

                                <input type="text" name="display_name"
                                    class="form-control @error('display_name') is-invalid @enderror"
                                    value="{{ old('display_name', $paymentSetting->display_name ?? '') }}">

                                @error('display_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Key ID</label>

                                <input type="text" name="key_id" class="form-control"
                                    value="{{ old('key_id', $paymentSetting->key_id ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Key Secret</label>

                                <input type="text" name="key_secret" class="form-control"
                                    value="{{ old('key_secret', $paymentSetting->key_secret ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client ID</label>

                                <input type="text" name="client_id" class="form-control"
                                    value="{{ old('client_id', $paymentSetting->client_id ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Client Secret</label>

                                <input type="text" name="client_secret" class="form-control"
                                    value="{{ old('client_secret', $paymentSetting->client_secret ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Merchant ID</label>

                                <input type="text" name="merchant_id" class="form-control"
                                    value="{{ old('merchant_id', $paymentSetting->merchant_id ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Webhook Secret</label>

                                <input type="text" name="webhook_secret" class="form-control"
                                    value="{{ old('webhook_secret', $paymentSetting->webhook_secret ?? '') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Currency</label>

                                <select name="currency" class="form-select">
                                    <option value="INR"
                                        {{ old('currency', $paymentSetting->currency ?? 'INR') == 'INR' ? 'selected' : '' }}>
                                        INR
                                        (₹)</option>
                                    <option value="USD"
                                        {{ old('currency', $paymentSetting->currency ?? '') == 'USD' ? 'selected' : '' }}>
                                        USD ($)
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Sandbox Mode</label>

                                <select name="sandbox_mode" class="form-select">
                                    <option value="1"
                                        {{ old('sandbox_mode', $paymentSetting->sandbox_mode ?? 1) == 1 ? 'selected' : '' }}>
                                        Enabled</option>
                                    <option value="0"
                                        {{ old('sandbox_mode', $paymentSetting->sandbox_mode ?? 1) == 0 ? 'selected' : '' }}>
                                        Disabled</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>

                                <select name="is_active" class="form-select">
                                    <option value="1"
                                        {{ old('is_active', $paymentSetting->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0"
                                        {{ old('is_active', $paymentSetting->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">

                        <button class="btn btn-success">
                            <i class="bi bi-check-circle"></i>
                            {{ isset($paymentSetting) ? 'Update Gateway' : 'Save Gateway' }}
                        </button>

                        <a href="{{ route('admin.payment-settings.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection
