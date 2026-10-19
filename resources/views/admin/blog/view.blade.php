@extends('admin.includes.master')

@section('title', 'Blogs')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Blogs</h3>
                </div>

                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.blogs.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add Blog
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Blogs List</h3>
                </div>

                <div class="card-body">

                    <form method="GET" class="row mb-3">

                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" value="{{ request('search') }}"
                                placeholder="Search Title / Slug">
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
                            <a href="{{ route('admin.blogs.index') }}" class="btn btn-secondary w-100">
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
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Sort</th>
                                    <th width="170">Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($blogs as $blog)
                                    <tr>

                                        <td>{{ $loop->iteration + ($blogs->firstItem() - 1) }}</td>

                                        <td>
                                            @if ($blog->image)
                                                @if (\Illuminate\Support\Str::startsWith($blog->image, 'uploads/'))
                                                    <img src="{{ asset($blog->image) }}" width="70" class="img-thumbnail">
                                                @else
                                                    <img src="{{ asset('storage/' . $blog->image) }}" width="70" class="img-thumbnail">
                                                @endif
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ $blog->title }}</strong><br>
                                            <small class="text-muted">{{ $blog->slug }}</small>
                                        </td>

                                        <td>
                                            {{ $blog->date ? $blog->date->format('d M Y') : 'N/A' }}
                                        </td>

                                        <td>
                                            @if ($blog->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td>{{ $blog->sort_order }}</td>

                                        <td>

                                            <a href="{{ route('admin.blogs.show', $blog) }}" class="btn btn-info btn-sm" title="View Blog">
                                                <i class="bi bi-eye" title="View Blog"></i>
                                            </a>

                                            <a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-warning btn-sm" title="Edit Blog">
                                                <i class="bi bi-pencil-square" title="Edit Blog"></i>
                                            </a>

                                            <form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST"
                                                class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm" title="Delete Blog"
                                                    onclick="return confirm('Delete this blog?')">
                                                    <i class="bi bi-trash" title="Delete Blog"></i>
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            No blogs found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{ $blogs->links() }}

                </div>

            </div>

        </div>
    </div>

@endsection
