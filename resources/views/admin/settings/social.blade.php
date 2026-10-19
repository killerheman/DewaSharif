@extends('admin.includes.master')

@section('title', 'Social Links')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Social Links</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Social Media Links</h3>
                </div>

                <form action="{{ route('admin.settings.social.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Facebook</label>
                                <input type="url" name="facebook"
                                    class="form-control @error('facebook') is-invalid @enderror"
                                    value="{{ old('facebook', $setting->facebook) }}"
                                    placeholder="https://facebook.com/username">
                                @error('facebook')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Instagram</label>
                                <input type="url" name="instagram"
                                    class="form-control @error('instagram') is-invalid @enderror"
                                    value="{{ old('instagram', $setting->instagram) }}"
                                    placeholder="https://instagram.com/username">
                                @error('instagram')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">LinkedIn</label>
                                <input type="url" name="linkedin"
                                    class="form-control @error('linkedin') is-invalid @enderror"
                                    value="{{ old('linkedin', $setting->linkedin) }}"
                                    placeholder="https://linkedin.com/in/username">
                                @error('linkedin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Twitter (X)</label>
                                <input type="url" name="twitter"
                                    class="form-control @error('twitter') is-invalid @enderror"
                                    value="{{ old('twitter', $setting->twitter) }}" placeholder="https://x.com/username">
                                @error('twitter')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">YouTube</label>
                                <input type="url" name="youtube"
                                    class="form-control @error('youtube') is-invalid @enderror"
                                    value="{{ old('youtube', $setting->youtube) }}"
                                    placeholder="https://youtube.com/@channel">
                                @error('youtube')
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
