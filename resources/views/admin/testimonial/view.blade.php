@extends('admin.includes.master')

@section('title', 'Testimonials')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Testimonials</h3>
                </div>

                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.testimonials.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add Testimonial
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Testimonials List</h3>
                </div>

                <div class="card-body">

                    <form method="GET" class="row mb-3">

                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Search Title / Designation">
                        </div>

                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">All Status</option>
                                <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary w-100">
                                <i class="bi bi-search"></i> Search
                            </button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary w-100">
                                Reset
                            </a>
                        </div>

                    </form>

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-success">
                                <tr>
                                    <th width="60">S.No.</th>
                                    <th width="90">Image</th>
                                    <th>Title</th>
                                    <th>Designation</th>
                                    <th>Rating</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Sort</th>
                                    <th width="170">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($testimonials as $testimonial)
                                    <tr>

                                        <td>{{ $loop->iteration + ($testimonials->firstItem() - 1) }}</td>

                                        <td>
                                            @if ($testimonial->thumb_image)
                                                @if (\Illuminate\Support\Str::startsWith($testimonial->thumb_image, 'uploads/'))
                                                    <img src="{{ asset($testimonial->thumb_image) }}" class="img-thumbnail" width="70">
                                                @else
                                                    <img src="{{ asset('storage/' . $testimonial->thumb_image) }}" class="img-thumbnail" width="70">
                                                @endif
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        <td>{{ $testimonial->title }}</td>

                                        <td>{{ $testimonial->designation ?: 'N/A' }}</td>

                                        <td>
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($i <= $testimonial->star_rating)
                                                    <i class="bi bi-star-fill" style="color: #22C55E !important;"></i>
                                                @else
                                                    <i class="bi bi-star-fill" style="color: #CCCCCC !important;"></i>
                                                @endif
                                            @endfor
                                        </td>

                                        <td>
                                            {{ $testimonial->date ? $testimonial->date->format('d M Y') : 'N/A' }}
                                        </td>

                                        <td>
                                            @if ($testimonial->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td>{{ $testimonial->sort_order }}</td>

                                        <td>

                                            <a href="{{ route('admin.testimonials.show', $testimonial) }}"
                                                class="btn btn-info btn-sm" title="View Testimonial">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.testimonials.edit', $testimonial) }}"
                                                class="btn btn-warning btn-sm" title="Edit Testimonial">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}"
                                                method="POST" class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm" title="Delete Testimonial"
                                                    onclick="return confirm('Delete this testimonial?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="9" class="text-center text-muted">
                                            No testimonials found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{ $testimonials->links() }}

                </div>

            </div>

        </div>
    </div>

@endsection
