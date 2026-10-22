@extends('admin.includes.master')

@section('title', 'SMTP Mail Settings - Dewa Sharif Admin')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-envelope-at-fill text-success me-2"></i>SMTP Mail Settings
                    </h3>
                    <p class="text-muted mb-0 small">Configure outgoing SMTP mail server, email credentials, and test live delivery</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.settings.general') }}">Settings</a></li>
                        <li class="breadcrumb-item active">SMTP Mail</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5 align-middle"></i>
                    <strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2 fs-5 align-middle"></i>
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (isset($errors) && $errors->any())
                <div class="alert alert-danger rounded-3 shadow-sm mb-4">
                    <div class="fw-bold mb-1"><i class="bi bi-shield-exclamation me-1"></i>Please fix the following errors:</div>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="row">

                {{-- Left Column: Main SMTP Configuration Form --}}
                <div class="col-lg-8">
                    <div class="card card-success card-outline shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-sliders2 text-success me-2"></i>Outgoing Mail Server (SMTP) Configuration
                            </h5>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                Active: {{ strtoupper($setting->mail_mailer ?? 'SMTP') }}
                            </span>
                        </div>

                        <form action="{{ route('admin.settings.smtp.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body p-4">

                                <div class="row g-3">

                                    {{-- Mail Driver --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Mail Driver <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">MAIL_MAILER</code>
                                        </label>
                                        <select name="mail_mailer" class="form-select @error('mail_mailer') is-invalid @enderror" required>
                                            <option value="smtp" {{ old('mail_mailer', $setting->mail_mailer) === 'smtp' ? 'selected' : '' }}>
                                                SMTP (Recommended for Gmail, cPanel, SendGrid)
                                            </option>
                                            <option value="sendmail" {{ old('mail_mailer', $setting->mail_mailer) === 'sendmail' ? 'selected' : '' }}>
                                                Sendmail (Server default sendmail binary)
                                            </option>
                                            <option value="log" {{ old('mail_mailer', $setting->mail_mailer) === 'log' ? 'selected' : '' }}>
                                                Log (Testing only - logs emails to storage/logs)
                                            </option>
                                        </select>
                                        <div class="form-text text-muted small">Select SMTP to deliver live emails over network.</div>
                                    </div>

                                    {{-- Mail Encryption --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Encryption <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">MAIL_ENCRYPTION</code>
                                        </label>
                                        <select name="mail_encryption" class="form-select @error('mail_encryption') is-invalid @enderror" required>
                                            <option value="tls" {{ old('mail_encryption', $setting->mail_encryption) === 'tls' ? 'selected' : '' }}>
                                                TLS (Port 587 - Standard & Recommended)
                                            </option>
                                            <option value="ssl" {{ old('mail_encryption', $setting->mail_encryption) === 'ssl' ? 'selected' : '' }}>
                                                SSL (Port 465 - Legacy Secure)
                                            </option>
                                            <option value="none" {{ old('mail_encryption', $setting->mail_encryption) === 'none' ? 'selected' : '' }}>
                                                None (Port 25 - Unencrypted)
                                            </option>
                                        </select>
                                        <div class="form-text text-muted small">Choose TLS for Port 587 or SSL for Port 465.</div>
                                    </div>

                                    {{-- Mail Host --}}
                                    <div class="col-md-8">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Mail Host <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">MAIL_HOST</code>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-hdd-network"></i></span>
                                            <input type="text" name="mail_host" class="form-control @error('mail_host') is-invalid @enderror"
                                                value="{{ old('mail_host', $setting->mail_host) }}" placeholder="e.g. smtp.gmail.com" required>
                                        </div>
                                        <div class="form-text text-muted small">e.g. <code>smtp.gmail.com</code> for Gmail, or <code>mail.yourdomain.com</code> for cPanel.</div>
                                    </div>

                                    {{-- Mail Port --}}
                                    <div class="col-md-4">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Port <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">MAIL_PORT</code>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-ethernet"></i></span>
                                            <input type="number" name="mail_port" class="form-control @error('mail_port') is-invalid @enderror"
                                                value="{{ old('mail_port', $setting->mail_port) }}" placeholder="587" required>
                                        </div>
                                        <div class="form-text text-muted small">Usually <code>587</code> (TLS) or <code>465</code> (SSL).</div>
                                    </div>

                                    {{-- Mail Username --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>SMTP Username <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">MAIL_USERNAME</code>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-person-fill"></i></span>
                                            <input type="text" name="mail_username" class="form-control @error('mail_username') is-invalid @enderror"
                                                value="{{ old('mail_username', $setting->mail_username) }}" placeholder="e.g. info@dewasharif.com" required autocomplete="off">
                                        </div>
                                        <div class="form-text text-muted small">Full email address used to log into your SMTP server.</div>
                                    </div>

                                    {{-- Mail Password with Eye Toggle --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>SMTP Password <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">MAIL_PASSWORD</code>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-key-fill"></i></span>
                                            <input type="password" name="mail_password" id="mail_password" class="form-control @error('mail_password') is-invalid @enderror"
                                                value="{{ old('mail_password', $setting->mail_password) }}" placeholder="Enter SMTP password or App Password" required autocomplete="new-password">
                                            <button type="button" class="btn btn-outline-secondary" id="toggleMailPassword" title="Show / Hide Password" aria-label="Toggle password visibility">
                                                <i class="bi bi-eye" id="mailPasswordEyeIcon"></i>
                                            </button>
                                        </div>
                                        <div class="form-text text-muted small">For Gmail, use a 16-character Google App Password.</div>
                                    </div>

                                    <div class="col-12"><hr class="my-2 text-muted"></div>

                                    {{-- From Address --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Sender Email (From) <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">MAIL_FROM_ADDRESS</code>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope-at"></i></span>
                                            <input type="email" name="mail_from_address" class="form-control @error('mail_from_address') is-invalid @enderror"
                                                value="{{ old('mail_from_address', $setting->mail_from_address) }}" placeholder="e.g. info@dewasharif.com" required>
                                        </div>
                                        <div class="form-text text-muted small">Email address shown as "From" to recipients.</div>
                                    </div>

                                    {{-- From Name --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Sender Name <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">MAIL_FROM_NAME</code>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-building"></i></span>
                                            <input type="text" name="mail_from_name" class="form-control @error('mail_from_name') is-invalid @enderror"
                                                value="{{ old('mail_from_name', $setting->mail_from_name) }}" placeholder="DEWASHARIF" required>
                                        </div>
                                        <div class="form-text text-muted small">The brand or sender name displayed in recipient inboxes.</div>
                                    </div>

                                </div>

                            </div>

                            <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-between">
                                <span class="text-muted small">
                                    <i class="bi bi-info-circle me-1"></i>Settings will be saved to database and synchronized with <code>.env</code>.
                                </span>
                                <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1"></i> Save SMTP Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right Column: Live Test Email & Quick Setup Guide --}}
                <div class="col-lg-4">

                    {{-- Live Test Email Card --}}
                    <div class="card card-primary card-outline shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-send-check-fill text-primary me-2"></i>Send Test Email
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-3">
                                Verify your live SMTP connection by sending a real test message to any email address before using it in production.
                            </p>

                            <form action="{{ route('admin.settings.smtp.test') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="test_email" class="form-label fw-bold text-dark small">Recipient Email Address</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted"><i class="bi bi-envelope"></i></span>
                                        <input type="email" name="test_email" id="test_email" class="form-control"
                                            placeholder="your-email@gmail.com" required>
                                    </div>
                                    <div class="form-text text-muted small">Enter the email where you want to receive the test.</div>
                                </div>

                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-sm">
                                    <i class="bi bi-send-fill me-2"></i> Send Live Test Email
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Gmail SMTP Instructions Card --}}
                    <div class="card card-info card-outline shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-google text-danger me-2"></i>Gmail SMTP Setup Guide
                            </h5>
                        </div>
                        <div class="card-body p-3">
                            <ol class="small text-muted ps-3 mb-3" style="line-height: 1.6;">
                                <li class="mb-1">Go to your <a href="https://myaccount.google.com/security" target="_blank" class="text-decoration-none fw-semibold">Google Account Security</a>.</li>
                                <li class="mb-1">Ensure <strong>2-Step Verification</strong> is switched <strong>ON</strong>.</li>
                                <li class="mb-1">Search for <strong>"App passwords"</strong> in Google Account.</li>
                                <li class="mb-1">Create a new App Password (name it e.g. <em>DewaSharif Portal</em>).</li>
                                <li class="mb-1">Google will generate a <strong>16-character code</strong> (e.g. <code>vjkx ttyt eoky qhhu</code>).</li>
                                <li>Paste this 16-character code directly into the <strong>SMTP Password</strong> field above!</li>
                            </ol>
                            <div class="bg-light p-2 rounded-2 border small">
                                <strong>Recommended Gmail Values:</strong><br>
                                <code>Host:</code> smtp.gmail.com<br>
                                <code>Port:</code> 587<br>
                                <code>Encryption:</code> TLS
                            </div>
                        </div>
                    </div>

                    {{-- cPanel / Custom Domain Instructions Card --}}
                    <div class="card shadow-sm rounded-3 mb-4 border-0">
                        <div class="card-header bg-light py-3 border-bottom">
                            <h6 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-globe2 text-secondary me-2"></i>cPanel / Custom Domain Mail
                            </h6>
                        </div>
                        <div class="card-body p-3 small text-muted">
                            <p class="mb-2">For custom domain webmails (e.g. <code>info@dewasharif.com</code>):</p>
                            <ul class="ps-3 mb-0">
                                <li><code>Host:</code> mail.dewasharif.com</li>
                                <li><code>Port:</code> 465 (SSL) or 587 (TLS)</li>
                                <li><code>Username:</code> Full email address</li>
                                <li><code>Password:</code> Webmail inbox password</li>
                            </ul>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.getElementById('toggleMailPassword')?.addEventListener('click', function() {
        var input = document.getElementById('mail_password');
        var icon = document.getElementById('mailPasswordEyeIcon');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    });
</script>
@endpush

