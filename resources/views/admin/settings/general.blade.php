@extends('admin.includes.master')

@section('title', 'General Settings')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">General Settings</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">General Settings</h3>
                </div>

                <form action="{{ route('admin.settings.general.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Website Name</label>
                                <input type="text" name="website_name"
                                    class="form-control @error('website_name') is-invalid @enderror"
                                    value="{{ old('website_name', $setting->website_name) }}">
                                @error('website_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Website URL</label>
                                <input type="url" name="website_url"
                                    class="form-control @error('website_url') is-invalid @enderror"
                                    value="{{ old('website_url', $setting->website_url) }}">
                                @error('website_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Website Email</label>
                                <input type="email" name="website_email"
                                    class="form-control @error('website_email') is-invalid @enderror"
                                    value="{{ old('website_email', $setting->website_email) }}">
                                @error('website_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Website Phone</label>
                                <input type="text" name="website_phone"
                                    class="form-control @error('website_phone') is-invalid @enderror"
                                    value="{{ old('website_phone', $setting->website_phone) }}">
                                @error('website_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">WhatsApp Number</label>
                                <input type="text" name="whatsapp"
                                    class="form-control @error('whatsapp') is-invalid @enderror"
                                    value="{{ old('whatsapp', $setting->whatsapp) }}">
                                @error('whatsapp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Website Address</label>
                                <textarea name="address" rows="2"
                                    class="form-control @error('address') is-invalid @enderror">{{ old('address', $setting->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- <div class="col-md-4 mb-3">
                                        <label class="form-label">Timezone</label>
                                        <input type="text" name="timezone"
                                            class="form-control @error('timezone') is-invalid @enderror"
                                            value="{{ old('timezone', $setting->timezone) }}">
                                        @error('timezone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> -->

                            <!-- <div class="col-md-4 mb-3">
                                        <label class="form-label">Currency</label>
                                        <input type="text" name="currency"
                                            class="form-control @error('currency') is-invalid @enderror"
                                            value="{{ old('currency', $setting->currency) }}">
                                        @error('currency')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label class="form-label">Language</label>
                                        <input type="text" name="language"
                                            class="form-control @error('language') is-invalid @enderror"
                                            value="{{ old('language', $setting->language) }}">
                                        @error('language')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div> -->

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Daily Backup Fee (₹)</label>
                                <input type="number" step="0.01" name="daily_backup_fee"
                                    class="form-control @error('daily_backup_fee') is-invalid @enderror"
                                    value="{{ old('daily_backup_fee', $setting->daily_backup_fee ?? 0) }}">
                                @error('daily_backup_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Domain Privacy Protection Fee (₹)</label>
                                <input type="number" step="0.01" name="domain_privacy_fee"
                                    class="form-control @error('domain_privacy_fee') is-invalid @enderror"
                                    value="{{ old('domain_privacy_fee', $setting->domain_privacy_fee ?? 0) }}">
                                @error('domain_privacy_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Server Auto Backup Fee (₹)</label>
                                <input type="number" step="0.01" name="server_backup_fee"
                                    class="form-control @error('server_backup_fee') is-invalid @enderror"
                                    value="{{ old('server_backup_fee', $setting->server_backup_fee ?? 199.00) }}">
                                @error('server_backup_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Server Security Suite Fee (₹)</label>
                                <input type="number" step="0.01" name="server_security_fee"
                                    class="form-control @error('server_security_fee') is-invalid @enderror"
                                    value="{{ old('server_security_fee', $setting->server_security_fee ?? 299.00) }}">
                                @error('server_security_fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Header Promo Announcement Bar Section --}}
                            <div class="col-12 my-3">
                                <hr>
                                <h5 class="fw-bold text-success mb-3"><i class="bi bi-megaphone-fill me-2"></i> Header Promo Announcement Bar</h5>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Show Header Promo Bar</label>
                                <select name="promo_bar_enabled" class="form-select @error('promo_bar_enabled') is-invalid @enderror">
                                    <option value="1" {{ old('promo_bar_enabled', $setting->promo_bar_enabled ?? 0) == 1 ? 'selected' : '' }}>Enabled (Show Banner)</option>
                                    <option value="0" {{ old('promo_bar_enabled', $setting->promo_bar_enabled ?? 0) == 0 ? 'selected' : '' }}>Disabled (Hide Banner)</option>
                                </select>
                                @error('promo_bar_enabled')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-5 mb-3">
                                <label class="form-label">Promo Announcement Text</label>
                                <input type="text" name="promo_bar_text"
                                    class="form-control @error('promo_bar_text') is-invalid @enderror"
                                    placeholder="e.g. 🎉 Special Offer! Get 10% OFF on all Hosting Plans"
                                    value="{{ old('promo_bar_text', $setting->promo_bar_text ?? '') }}">
                                @error('promo_bar_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Promo Coupon Code</label>
                                <input type="text" name="promo_bar_coupon"
                                    class="form-control @error('promo_bar_coupon') is-invalid @enderror"
                                    placeholder="e.g. HOSTLOK10"
                                    value="{{ old('promo_bar_coupon', $setting->promo_bar_coupon ?? '') }}">
                                @error('promo_bar_coupon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <hr>
                            </div>

                            <div class="col-md-8 mb-3">
                                <label class="form-label">Copyright</label>
                                <input type="text" name="copyright"
                                    class="form-control @error('copyright') is-invalid @enderror"
                                    value="{{ old('copyright', $setting->copyright) }}">
                                @error('copyright')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ old('is_active', $setting->is_active) ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="0" {{ !old('is_active', $setting->is_active) ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let wrapper = document.getElementById('capabilities-wrapper');
            let addBtn = document.getElementById('add-capability-btn');

            if (addBtn && wrapper) {
                addBtn.addEventListener('click', function() {
                    let index = wrapper.querySelectorAll('.capability-row').length;
                    let template = `
                        <div class="card mb-3 capability-row border border-light-subtle shadow-sm">
                            <div class="card-body bg-light p-3">
                                <div class="row align-items-center">
                                    <div class="col-md-3 mb-2">
                                        <label class="form-label small fw-semibold mb-1">FontAwesome Icon Class</label>
                                        <div class="input-group input-group-sm">
                                            <span class="input-group-text"><i class="fa-solid fa-check"></i></span>
                                            <input type="text" name="key_capabilities_items[${index}][icon]" class="form-control" placeholder="fa-solid fa-server" value="fa-solid fa-check">
                                        </div>
                                        <small class="text-muted" style="font-size: 0.75rem;">e.g. <code>fa-solid fa-bolt</code></small>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label small fw-semibold mb-1">Capability Heading</label>
                                        <input type="text" name="key_capabilities_items[${index}][heading]" class="form-control form-control-sm" placeholder="Feature Heading" value="">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="form-label small fw-semibold mb-1">Short Description</label>
                                        <input type="text" name="key_capabilities_items[${index}][desc]" class="form-control form-control-sm" placeholder="Short Description" value="">
                                    </div>
                                    <div class="col-md-1 mb-2 text-end">
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-capability-btn" style="margin-top: 22px;" title="Remove Item">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    wrapper.insertAdjacentHTML('beforeend', template);
                });

                wrapper.addEventListener('click', function(e) {
                    if (e.target.closest('.remove-capability-btn')) {
                        let row = e.target.closest('.capability-row');
                        if (row) row.remove();
                    }
                });
            }
        });
    </script>

@endsection