@extends('admin.includes.master')

@section('title', 'API Settings')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">API Settings</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">API Configuration</h3>
                </div>

                <form action="{{ route('admin.settings.api.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            {{-- Domain API --}}
                            <div class="col-12 mb-2">
                                <h5 class="text-success">Domain Registration API</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">API URL</label>
                                <input type="text" name="domain_api_url"
                                    class="form-control @error('domain_api_url') is-invalid @enderror"
                                    value="{{ old('domain_api_url', $setting->domain_api_url) }}">
                                @error('domain_api_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">API Key</label>
                                <input type="text" name="domain_api_key"
                                    class="form-control @error('domain_api_key') is-invalid @enderror"
                                    value="{{ old('domain_api_key', $setting->domain_api_key) }}">
                                @error('domain_api_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Google OAuth --}}
                            <div class="col-12 mb-2 mt-2">
                                <h5 class="text-success">Google OAuth</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Google Client ID</label>
                                <input type="text" name="google_client_id"
                                    class="form-control @error('google_client_id') is-invalid @enderror"
                                    value="{{ old('google_client_id', $setting->google_client_id) }}">
                                @error('google_client_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Google Client Secret</label>
                                <input type="text" name="google_client_secret"
                                    class="form-control @error('google_client_secret') is-invalid @enderror"
                                    value="{{ old('google_client_secret', $setting->google_client_secret) }}">
                                @error('google_client_secret')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Google reCAPTCHA --}}
                            <div class="col-12 mb-2 mt-2">
                                <h5 class="text-success">Google reCAPTCHA</h5>
                                <hr>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Site Key</label>
                                <input type="text" name="recaptcha_site_key"
                                    class="form-control @error('recaptcha_site_key') is-invalid @enderror"
                                    value="{{ old('recaptcha_site_key', $setting->recaptcha_site_key) }}">
                                @error('recaptcha_site_key')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Secret Key</label>
                                <input type="text" name="recaptcha_secret_key"
                                    class="form-control @error('recaptcha_secret_key') is-invalid @enderror"
                                    value="{{ old('recaptcha_secret_key', $setting->recaptcha_secret_key) }}">
                                @error('recaptcha_secret_key')
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
