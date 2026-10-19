@extends('admin.includes.master')

@section('title', 'SEO Settings')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">SEO Settings</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Website SEO Configuration</h3>
                </div>

                <form action="{{ route('admin.settings.seo.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Default Meta Title</label>
                                <input type="text" name="meta_title"
                                    class="form-control @error('meta_title') is-invalid @enderror"
                                    value="{{ old('meta_title', $setting->meta_title) }}">
                                @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" rows="4" class="form-control @error('meta_description') is-invalid @enderror">{{ old('meta_description', $setting->meta_description) }}</textarea>
                                @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <textarea name="meta_keywords" rows="3" class="form-control @error('meta_keywords') is-invalid @enderror">{{ old('meta_keywords', $setting->meta_keywords) }}</textarea>
                                @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Comma separated keywords.</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Google Analytics ID</label>
                                <input type="text" name="google_analytics"
                                    class="form-control @error('google_analytics') is-invalid @enderror"
                                    value="{{ old('google_analytics', $setting->google_analytics) }}"
                                    placeholder="G-XXXXXXXXXX">
                                @error('google_analytics')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Google Tag Manager ID</label>
                                <input type="text" name="google_tag_manager"
                                    class="form-control @error('google_tag_manager') is-invalid @enderror"
                                    value="{{ old('google_tag_manager', $setting->google_tag_manager) }}"
                                    placeholder="GTM-XXXXXXX">
                                @error('google_tag_manager')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Google Site Verification</label>
                                <textarea name="google_site_verification" rows="3"
                                    class="form-control @error('google_site_verification') is-invalid @enderror">{{ old('google_site_verification', $setting->google_site_verification) }}</textarea>
                                @error('google_site_verification')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Robots.txt Content</label>
                                <textarea name="robots_content" rows="6" class="form-control @error('robots_content') is-invalid @enderror">{{ old('robots_content', $setting->robots_content) }}</textarea>
                                @error('robots_content')
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
