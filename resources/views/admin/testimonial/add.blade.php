@extends('admin.includes.master')

@section('title', isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($testimonial) ? 'Edit Testimonial' : 'Add Testimonial' }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
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
                        {{ isset($testimonial) ? 'Update Testimonial' : 'Create Testimonial' }}
                    </h3>
                </div>

                <form
                    action="{{ isset($testimonial) ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}"
                    method="POST" enctype="multipart/form-data">

                    @csrf
                    @isset($testimonial)
                        @method('PUT')
                    @endisset

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', $testimonial->title ?? '') }}">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Designation</label>
                                <input type="text" name="designation"
                                    class="form-control @error('designation') is-invalid @enderror"
                                    value="{{ old('designation', $testimonial->designation ?? '') }}">
                                @error('designation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Thumb Image</label>
                                <input type="file" name="thumb_image"
                                    class="form-control @error('thumb_image') is-invalid @enderror">
                                @error('thumb_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                @isset($testimonial)
                                    @if ($testimonial->thumb_image)
                                        @if (\Illuminate\Support\Str::startsWith($testimonial->thumb_image, 'uploads/'))
                                            <img src="{{ asset($testimonial->thumb_image) }}" class="img-thumbnail mt-2" width="100">
                                        @else
                                            <img src="{{ asset('storage/' . $testimonial->thumb_image) }}" class="img-thumbnail mt-2" width="100">
                                        @endif
                                    @endif
                                @endisset
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Star Rating</label>
                                <select name="star_rating" class="form-select">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <option value="{{ $i }}"
                                            {{ old('star_rating', $testimonial->star_rating ?? 5) == $i ? 'selected' : '' }}>
                                            {{ $i }} Star
                                        </option>
                                    @endfor
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Sort Order</label>
                                <input type="number" name="sort_order" class="form-control"
                                    value="{{ old('sort_order', $testimonial->sort_order ?? ($nextSortOrder ?? 1)) }}">
                            </div>

                            <div class="col-md-6 mb-3">

                                <label class="form-label">Description</label>

                                <textarea name="description" id="editor" class="form-control" rows="5">{{ old('description', $testimonial->description ?? '') }}</textarea>

                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image ALT</label>
                                <input type="text" name="image_alt" class="form-control"
                                    value="{{ old('image_alt', $testimonial->image_alt ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Image Title</label>
                                <input type="text" name="image_title" class="form-control"
                                    value="{{ old('image_title', $testimonial->image_title ?? '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select name="is_active" class="form-select">
                                    <option value="1"
                                        {{ old('is_active', $testimonial->is_active ?? 1) == 1 ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0"
                                        {{ old('is_active', $testimonial->is_active ?? 1) == 0 ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">

                        <button class="btn btn-success">
                            <i class="bi bi-check-circle"></i>
                            {{ isset($testimonial) ? 'Update Testimonial' : 'Save Testimonial' }}
                        </button>

                        <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection
