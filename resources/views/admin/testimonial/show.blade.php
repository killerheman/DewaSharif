@extends('admin.includes.master')

@section('title', 'Testimonial Details')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Testimonial Details</h3>
                </div>

                <div class="col-sm-6 text-end">

                    <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Back
                    </a>

                    <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Testimonial Information</h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-4 text-center">
                            @if ($testimonial->thumb_image)
                                @if (\Illuminate\Support\Str::startsWith($testimonial->thumb_image, 'uploads/'))
                                    <img src="{{ asset($testimonial->thumb_image) }}"
                                        alt="{{ $testimonial->image_alt ?? $testimonial->title }}"
                                        class="img-fluid rounded shadow"
                                        width="250">
                                @else
                                    <img src="{{ asset('storage/' . $testimonial->thumb_image) }}"
                                        alt="{{ $testimonial->image_alt ?? $testimonial->title }}"
                                        class="img-fluid rounded shadow"
                                        width="250">
                                @endif
                            @else
                                <img src="{{ asset('admin/dist/assets/img/no-image.png') }}"
                                    class="img-fluid rounded shadow"
                                    width="250">
                            @endif
                        </div>

                        <div class="col-md-8">

                            <table class="table table-bordered">

                                <tr>
                                    <th width="220">Title</th>
                                    <td>{{ $testimonial->title }}</td>
                                </tr>

                                <tr>
                                    <th>Designation</th>
                                    <td>{{ $testimonial->designation ?: 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Star Rating</th>
                                    <td>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $testimonial->star_rating)
                                                <i class="bi bi-star-fill" style="color: #22C55E !important;"></i>
                                            @else
                                                <i class="bi bi-star-fill" style="color: #CCCCCC !important;"></i>
                                            @endif
                                        @endfor
                                    </td>
                                </tr>

                                <tr>
                                    <th>Date</th>
                                    <td>{{ $testimonial->date ? $testimonial->date->format('d M Y') : 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Image ALT</th>
                                    <td>{{ $testimonial->image_alt ?: 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Image Title</th>
                                    <td>{{ $testimonial->image_title ?: 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Sort Order</th>
                                    <td>{{ $testimonial->sort_order }}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($testimonial->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $testimonial->created_at->format('d M Y, h:i A') }}</td>
                                </tr>

                                {{-- <tr>
                                <th>Updated At</th>
                                <td>{{ $testimonial->updated_at->format('d M Y, h:i A') }}</td>
                            </tr> --}}

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
