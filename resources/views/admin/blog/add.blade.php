@extends('admin.includes.master')

@section('title', isset($blog) ? 'Edit Blog' : 'Add Blog')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($blog) ? 'Edit Blog' : 'Add Blog' }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
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
                        {{ isset($blog) ? 'Update Blog' : 'Create Blog' }}
                    </h3>
                </div>

                <form action="{{ isset($blog) ? route('admin.blogs.update', $blog) : route('admin.blogs.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @isset($blog)
                        @method('PUT')
                    @endisset

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $blog->title ?? '') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image"
                                    class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @isset($blog)
                                    @if ($blog->image)
                                        @if (\Illuminate\Support\Str::startsWith($blog->image, 'uploads/'))
                                            <img src="{{ asset($blog->image) }}" class="img-thumbnail mt-2" width="100">
                                        @else
                                            <img src="{{ asset('storage/' . $blog->image) }}" class="img-thumbnail mt-2" width="100">
                                        @endif
                                    @endif
                                @endisset
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description <span class="text-danger">*</span></label>
                                <textarea name="description" id="editor" rows="8" class="form-control">{{ old('description', $blog->description ?? '') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" name="meta_title" class="form-control"
                                    value="{{ old('meta_title', $blog->meta_title ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image ALT</label>
                                <input type="text" name="image_alt" class="form-control"
                                    value="{{ old('image_alt', $blog->image_alt ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image Title</label>
                                <input type="text" name="image_title" class="form-control"
                                    value="{{ old('image_title', $blog->image_title ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order', $blog->sort_order ?? ($nextSortOrder ?? 1)) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea name="meta_description" rows="3" class="form-control">{{ old('meta_description', $blog->meta_description ?? '') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <textarea name="meta_keywords" rows="3" class="form-control">{{ old('meta_keywords', $blog->meta_keywords ?? '') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" {{ old('is_active', $blog->is_active ?? 1) == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0" {{ old('is_active', $blog->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">

                        <button class="btn btn-success">
                            <i class="bi bi-check-circle"></i>
                            {{ isset($blog) ? 'Update Blog' : 'Save Blog' }}
                        </button>

                        <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection
