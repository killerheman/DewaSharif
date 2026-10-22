@extends('admin.includes.master')

@section('title', 'WhatsApp Cloud API Settings - Dewa Sharif Admin')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-dark">
                        <i class="bi bi-whatsapp text-success me-2"></i>WhatsApp Cloud API Settings
                    </h3>
                    <p class="text-muted mb-0 small">Configure Meta WhatsApp Business Cloud API credentials, phone ID & test live message dispatch</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.settings.general') }}">Settings</a></li>
                        <li class="breadcrumb-item active">WhatsApp API</li>
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

                {{-- Left Column: Meta WhatsApp Credentials Form --}}
                <div class="col-lg-8">
                    <div class="card card-success card-outline shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h5 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-meta text-primary me-2"></i>Meta WhatsApp Cloud API Credentials
                            </h5>
                            @if(!empty($setting->whatsapp_token) && !empty($setting->whatsapp_phone_number_id))
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1 rounded-pill">
                                    <i class="bi bi-check2-circle me-1"></i>Configured
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3 py-1 rounded-pill">
                                    <i class="bi bi-exclamation-circle me-1"></i>Pending Setup
                                </span>
                            @endif
                        </div>

                        <form action="{{ route('admin.settings.whatsapp.update') }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="card-body p-4">

                                <div class="row g-3">

                                    {{-- WhatsApp Phone Number ID --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Phone Number ID <span class="text-danger">*</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">WHATSAPP_PHONE_NUMBER_ID</code>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-telephone-fill text-success"></i></span>
                                            <input type="text" name="whatsapp_phone_number_id" class="form-control @error('whatsapp_phone_number_id') is-invalid @enderror"
                                                value="{{ old('whatsapp_phone_number_id', $setting->whatsapp_phone_number_id) }}"
                                                placeholder="e.g. 1392454007281069" required autocomplete="off">
                                        </div>
                                        <div class="form-text text-muted small">Meta WhatsApp Cloud API Phone Number ID from App Setup.</div>
                                    </div>

                                    {{-- WhatsApp Business Account ID (Optional) --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Business Account ID <span class="text-muted small fw-normal">(Optional)</span></span>
                                            <code class="text-muted small font-monospace fw-normal" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">WHATSAPP_BUSINESS_ACCOUNT_ID</code>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-briefcase-fill text-primary"></i></span>
                                            <input type="text" name="whatsapp_business_account_id" class="form-control @error('whatsapp_business_account_id') is-invalid @enderror"
                                                value="{{ old('whatsapp_business_account_id', $setting->whatsapp_business_account_id) }}"
                                                placeholder="e.g. 102938475610293">
                                        </div>
                                        <div class="form-text text-muted small">Your Meta WhatsApp Business Account (WABA) identifier.</div>
                                    </div>

                                    {{-- WhatsApp Access Token --}}
                                    <div class="col-12">
                                        <div class="d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <label class="form-label fw-bold text-dark mb-0">
                                                Permanent / Temporary Access Token <span class="text-danger">*</span>
                                                <code class="text-muted small font-monospace fw-normal ms-2" style="font-size: 0.72rem; background: #f8f9fa; padding: 2px 6px; border-radius: 4px; border: 1px solid #e9ecef;">WHATSAPP_TOKEN</code>
                                            </label>
                                            <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" id="toggleTokenVisibility" style="font-size: 0.78rem;">
                                                <i class="bi bi-eye me-1" id="tokenEyeIcon"></i><span id="tokenEyeText">Show Token</span>
                                            </button>
                                        </div>
                                        <div class="position-relative">
                                            <textarea name="whatsapp_token" id="whatsapp_token" rows="3"
                                                class="form-control font-monospace @error('whatsapp_token') is-invalid @enderror"
                                                placeholder="Paste your EA... Meta Permanent Access Token or Temporary Token here"
                                                required style="-webkit-text-security: disc;">{{ old('whatsapp_token', $setting->whatsapp_token) }}</textarea>
                                        </div>
                                        <div class="form-text text-muted small">
                                            System User permanent token (recommended) or temporary 24-hr token generated from Meta Developer portal.
                                        </div>
                                    </div>

                                    <div class="col-12"><hr class="my-2 text-muted"></div>

                                    {{-- Public Support WhatsApp Number --}}
                                    @php
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $setting->whatsapp_number ?? '919648777223');
                                    @endphp
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Public Support WhatsApp Number</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-chat-dots-fill text-success"></i></span>
                                            <input type="text" name="whatsapp_number" id="whatsapp_number" class="form-control @error('whatsapp_number') is-invalid @enderror"
                                                value="{{ old('whatsapp_number', $setting->whatsapp_number ?? '+919648777223') }}"
                                                placeholder="+91 9648777223">
                                        </div>
                                        <div class="form-text text-muted small">The WhatsApp number displayed on frontend for visitors to click & chat.</div>
                                    </div>

                                    {{-- Public Click-to-Chat Link Preview --}}
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold text-dark d-flex align-items-center justify-content-between mb-1" style="min-height: 24px;">
                                            <span>Click-to-Chat Link <span class="badge bg-success-subtle text-success border border-success-subtle fw-normal ms-1" style="font-size: 0.7rem;">Live Preview</span></span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light text-muted"><i class="bi bi-link-45deg text-success"></i></span>
                                            <input type="text" id="wa_chat_link" class="form-control bg-light text-muted" readonly value="https://wa.me/{{ $cleanPhone }}">
                                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" id="wa_test_btn" class="btn btn-outline-success" title="Test Click-to-Chat in new tab">
                                                <i class="bi bi-box-arrow-up-right me-1"></i>Test
                                            </a>
                                        </div>
                                        <div class="form-text text-muted small">Auto-generated direct link used across the portal for customers.</div>
                                    </div>

                                </div>

                            </div>

                            <div class="card-footer bg-light py-3 d-flex align-items-center justify-content-between">
                                <span class="text-muted small">
                                    <i class="bi bi-info-circle me-1"></i>Saved to database and synchronized with <code>.env</code>.
                                </span>
                                <button type="submit" class="btn btn-success fw-bold px-4 py-2 shadow-sm">
                                    <i class="bi bi-check-circle-fill me-1"></i> Save WhatsApp Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Right Column: Live Test Message & Setup Guide --}}
                <div class="col-lg-4">

                    {{-- Live WhatsApp Test Card --}}
                    <div class="card card-success card-outline shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-whatsapp text-success me-2"></i>Send Test WhatsApp
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <p class="text-muted small mb-3">
                                Send a live test message to verify your Meta Cloud API Access Token and Phone Number ID in real-time.
                            </p>

                            <form action="{{ route('admin.settings.whatsapp.test') }}" method="POST">
                                @csrf

                                <div class="mb-3">
                                    <label for="test_phone" class="form-label fw-bold text-dark small">Recipient Mobile Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted">+91</span>
                                        <input type="text" name="test_phone" id="test_phone" class="form-control"
                                            placeholder="9876543210" required>
                                    </div>
                                    <div class="form-text text-muted small">Enter 10-digit mobile number (or full with country code).</div>
                                </div>

                                <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                                    <i class="bi bi-send-fill me-2"></i> Send Test WhatsApp
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Meta Cloud API Setup Guide --}}
                    <div class="card card-info card-outline shadow-sm rounded-3 mb-4">
                        <div class="card-header bg-white py-3 border-bottom">
                            <h5 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-book-half text-info me-2"></i>Meta Cloud API Setup Guide
                            </h5>
                        </div>
                        <div class="card-body p-3">
                            <ol class="small text-muted ps-3 mb-3" style="line-height: 1.6;">
                                <li class="mb-1">Log into <a href="https://developers.facebook.com/apps/" target="_blank" class="text-decoration-none fw-semibold">Meta for Developers</a>.</li>
                                <li class="mb-1">Click on your App &rarr; Navigate to <strong>WhatsApp &rarr; API Setup</strong>.</li>
                                <li class="mb-1">Copy the <strong>Phone number ID</strong> from Step 1.</li>
                                <li class="mb-1">Copy the <strong>Temporary Access Token</strong> (or generate a <strong>System User Permanent Token</strong> under Meta Business Settings).</li>
                                <li class="mb-1">Paste them in the fields on the left and click <strong>Save WhatsApp Settings</strong>.</li>
                                <li>Use the <strong>Send Test WhatsApp</strong> form above to verify delivery!</li>
                            </ol>
                            <div class="alert alert-warning py-2 px-3 small mb-0 rounded-2">
                                <i class="bi bi-info-circle me-1"></i><strong>Development Mode Notice:</strong> If your Meta App is in Development mode, ensure your test number is added to the <em>"To" recipient list</em> in Meta Developer Dashboard.
                            </div>
                        </div>
                    </div>

                    {{-- Automated Notifications Powered by WhatsApp --}}
                    <div class="card shadow-sm rounded-3 mb-4 border-0">
                        <div class="card-header bg-light py-3 border-bottom">
                            <h6 class="card-title fw-bold mb-0 text-dark">
                                <i class="bi bi-bell-fill text-warning me-2"></i>Automated Live Alerts
                            </h6>
                        </div>
                        <div class="card-body p-3 small text-muted">
                            <p class="mb-2">Your configured WhatsApp API automatically delivers:</p>
                            <ul class="ps-3 mb-0">
                                <li class="mb-1">Cab Booking Confirmations with Code & Invoice link</li>
                                <li class="mb-1">Driver & Vehicle Assignment Details with Driver Mobile</li>
                                <li class="mb-1">Degh Niyaz & Sacred Shop Order Confirmations</li>
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
    document.getElementById('toggleTokenVisibility').addEventListener('click', function() {
        var textarea = document.getElementById('whatsapp_token');
        var icon = document.getElementById('tokenEyeIcon');
        var text = document.getElementById('tokenEyeText');

        if (textarea.style.webkitTextSecurity === 'none') {
            textarea.style.webkitTextSecurity = 'disc';
            icon.className = 'bi bi-eye me-1';
            text.textContent = 'Show Token';
        } else {
            textarea.style.webkitTextSecurity = 'none';
            icon.className = 'bi bi-eye-slash me-1';
            text.textContent = 'Hide Token';
        }
    });

    // Auto update live WhatsApp link preview
    var phoneInput = document.getElementById('whatsapp_number');
    if (phoneInput) {
        phoneInput.addEventListener('input', function() {
            var clean = this.value.replace(/[^0-9]/g, '');
            var linkInput = document.getElementById('wa_chat_link');
            var testBtn = document.getElementById('wa_test_btn');
            var url = clean ? ('https://wa.me/' + clean) : 'https://wa.me/';
            if (linkInput) linkInput.value = url;
            if (testBtn) testBtn.href = url;
        });
    }
</script>
@endpush
