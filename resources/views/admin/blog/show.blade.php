@extends('admin.includes.master')

@section('title', 'Blog Details')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Blog Details</h3>
                </div>

                <div class="col-sm-6 text-end">

                    <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left-circle"></i> Back
                    </a>

                    <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning">
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
                    <h3 class="card-title">Blog Information</h3>
                </div>

                <div class="card-body">

                    <div class="row">

                        {{-- <div class="col-md-4 text-center">

                        @if ($blog->image)
                            <img src="{{ asset('storage/'.$blog->image) }}"
                                alt="{{ $blog->image_alt ?? $blog->title }}"
                                class="img-fluid rounded shadow"
                                width="250">
                        @else
                            <img src="{{ asset('admin/dist/assets/img/no-image.png') }}"
                                class="img-fluid rounded shadow"
                                width="250">
                        @endif

                    </div> --}}

                        <div class="col-md-8">

                            <table class="table table-bordered">

                                <tr>
                                    <th width="220">Title</th>
                                    <td>{{ $blog->title }}</td>
                                </tr>

                                <tr>
                                    <th>Slug</th>
                                    <td>
                                        <span class="badge bg-secondary">
                                            {{ $blog->slug }}
                                        </span>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Description</th>
                                    <td>{!! $blog->description ?: 'N/A' !!}</td>
                                </tr>

                                <tr>
                                    <th>Date</th>
                                    <td>{{ $blog->date ? $blog->date->format('d M Y') : 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Meta Title</th>
                                    <td>{{ $blog->meta_title ?: 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Meta Description</th>
                                    <td>{{ $blog->meta_description ?: 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Meta Keywords</th>
                                    <td>{{ $blog->meta_keywords ?: 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Image ALT</th>
                                    <td>{{ $blog->image_alt ?: 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Image Title</th>
                                    <td>{{ $blog->image_title ?: 'N/A' }}</td>
                                </tr>

                                <tr>
                                    <th>Sort Order</th>
                                    <td>{{ $blog->sort_order }}</td>
                                </tr>

                                <tr>
                                    <th>Status</th>
                                    <td>
                                        @if ($blog->is_active)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-danger">Inactive</span>
                                        @endif
                                    </td>
                                </tr>

                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $blog->created_at->format('d M Y, h:i A') }}</td>
                                </tr>

                                {{-- <tr>
                                <th>Updated At</th>
                                <td>{{ $blog->updated_at->format('d M Y, h:i A') }}</td>
                            </tr> --}}

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
