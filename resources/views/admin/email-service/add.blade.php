@extends('admin.includes.master')

@section('title', 'Add Email Services')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Add Email Services</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.email-services.index') }}" class="btn btn-secondary">
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
                    <h3 class="card-title">Create Email Services</h3>
                </div>

                <form action="{{ route('admin.email-services.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" placeholder="e.g. Google Gmail Suite" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Banner Service (Separate by comma)</label>
                                <input type="text" name="banner_service" class="form-control" value="{{ old('banner_service') }}" placeholder="e.g. Custom Branded Domain Email, 10 GB to 50 GB SSD Storage">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Banner Title</label>
                                <input type="text" name="banner_title" class="form-control" value="{{ old('banner_title') }}" placeholder="e.g. HostLok brings you Google Workspace Plans">
                            </div>

                             <div class="col-md-6 mb-3">
                                <label class="form-label">Card Icon Class</label>
                                <input type="text" name="icon" class="form-control" value="{{ old('icon') }}" placeholder="e.g. bi bi-google, bi bi-microsoft, bi bi-envelope-at">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Banner Description</label>
                                <textarea name="banner_description" rows="3" class="form-control" placeholder="Brief introduction...">{{ old('banner_description') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Service Description</label>
                                <textarea name="description" rows="5" class="form-control summernote" placeholder="Detailed service description...">{{ old('description') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Banner Image 1</label>
                                <input type="file" name="banner_image_1" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Banner Image 2</label>
                                <input type="file" name="banner_image_2" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Main Image</label>
                                <input type="file" name="image" class="form-control">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $nextSortOrder ?? 1) }}">
                            </div>

                            <div class="col-md-6 mb-3 d-flex align-items-center">
                                <div class="form-check mt-4">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
                                    <label class="form-check-label fw-bold" for="isActive">Active Status</label>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <hr>
                                <h5 class="fw-bold text-success mb-3"><i class="bi bi-search me-2"></i> SEO & Metadata</h5>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image Alt</label>
                                <input type="text" name="image_alt" class="form-control" value="{{ old('image_alt') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image Title</label>
                                <input type="text" name="image_title" class="form-control" value="{{ old('image_title') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <textarea name="meta_keywords" class="form-control" rows="2">{{ old('meta_keywords') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-success">Save Email Service</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
