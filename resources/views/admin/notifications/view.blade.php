@extends('admin.includes.master')
@section('title', 'Notification List')
@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Notification List</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.notifications.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add Notification
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Notification List</h3>
                </div>

                <div class="card-body">

                    <form method="GET" action="{{ route('admin.notifications.index') }}">
                        <div class="row mb-3">

                            <div class="col-md-4">
                                <input type="text" name="search" class="form-control" placeholder="Search..."
                                    value="{{ request('search') }}">
                            </div>

                            <div class="col-md-3">
                                <select name="type" class="form-select">
                                    <option value="">All Type</option>
                                    <option value="common" {{ request('type') == 'common' ? 'selected' : '' }}>Common</option>
                                    <option value="individual" {{ request('type') == 'individual' ? 'selected' : '' }}>Individual
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-2">
                                <select name="status" class="form-select">
                                    <option value="">All Status</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>

                            <div class="col-md-1">
                                <button class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>

                            <div class="col-md-2">
                                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary w-100">
                                    Reset
                                </a>
                            </div>

                        </div>
                    </form>


                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-success">
                                <tr>
                                    <th>S.No.</th>
                                    <th>Title</th>
                                    <th>Type</th>
                                    <th>User</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($notifications as $notification)
                                    <tr>

                                        <td>{{ $loop->iteration + ($notifications->firstItem() - 1) }}</td>

                                        <td>{{ $notification->title }}</td>

                                        <td>
                                            @if ($notification->type == 'common')
                                                <span class="badge bg-primary">Common</span>
                                            @else
                                                <span class="badge bg-info">Individual</span>
                                            @endif
                                        </td>

                                        <td>{{ $notification->user?->name ?? 'All Users' }}</td>

                                        <td>
                                            {{ $notification->created_at->format('d M Y') }}
                                        </td>

                                        <td>
                                            @if ($notification->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td>

                                            <a href="{{ route('admin.notifications.show', $notification) }}"
                                                class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.notifications.edit', $notification) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('admin.notifications.destroy', $notification) }}"
                                                method="POST" class="d-inline"
                                                onsubmit="return confirm('Delete this notification?')">

                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="7" class="text-center text-muted">
                                            No Notification Found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $notifications->withQueryString()->links() }}
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
