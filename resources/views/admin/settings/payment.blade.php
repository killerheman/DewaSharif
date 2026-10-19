@extends('admin.includes.master')

@section('title', 'Payment Settings')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Payment Settings</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Payment Gateway Configuration</h3>
                </div>

                <form action="{{ route('admin.settings.payment.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <div class="col-12">
                                <h5 class="mb-3 text-success">Razorpay</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Key ID</label>
                                <input type="text" name="razorpay_key"
                                    class="form-control @error('razorpay_key') is-invalid @enderror"
                                    value="{{ old('razorpay_key', $setting->razorpay_key) }}">
                                @error('razorpay_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Key Secret</label>
                                <input type="text" name="razorpay_secret"
                                    class="form-control @error('razorpay_secret') is-invalid @enderror"
                                    value="{{ old('razorpay_secret', $setting->razorpay_secret) }}">
                                @error('razorpay_secret')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- <hr>

                                            <div class="col-12">
                                                <h5 class="mb-3 text-success">PayPal</h5>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Client ID</label>
                                                <input type="text" name="paypal_client_id"
                                                    class="form-control @error('paypal_client_id') is-invalid @enderror"
                                                    value="{{ old('paypal_client_id', $setting->paypal_client_id) }}">
                                                @error('paypal_client_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Client Secret</label>
                                                <input type="text" name="paypal_secret"
                                                    class="form-control @error('paypal_secret') is-invalid @enderror"
                                                    value="{{ old('paypal_secret', $setting->paypal_secret) }}">
                                                @error('paypal_secret')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <hr>

                                            <div class="col-12">
                                                <h5 class="mb-3 text-success">PhonePe</h5>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Merchant ID</label>
                                                <input type="text" name="phonepe_merchant_id"
                                                    class="form-control @error('phonepe_merchant_id') is-invalid @enderror"
                                                    value="{{ old('phonepe_merchant_id', $setting->phonepe_merchant_id) }}">
                                                @error('phonepe_merchant_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Salt Key</label>
                                                <input type="text" name="phonepe_salt"
                                                    class="form-control @error('phonepe_salt') is-invalid @enderror"
                                                    value="{{ old('phonepe_salt', $setting->phonepe_salt) }}">
                                                @error('phonepe_salt')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <hr>

                                            <div class="col-12">
                                                <h5 class="mb-3 text-success">PayU</h5>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Key</label>
                                                <input type="text" name="payu_key"
                                                    class="form-control @error('payu_key') is-invalid @enderror"
                                                    value="{{ old('payu_key', $setting->payu_key) }}">
                                                @error('payu_key')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label class="form-label">Salt</label>
                                                <input type="text" name="payu_salt"
                                                    class="form-control @error('payu_salt') is-invalid @enderror"
                                                    value="{{ old('payu_salt', $setting->payu_salt) }}">
                                                @error('payu_salt')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div> -->

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