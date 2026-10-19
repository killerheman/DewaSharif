@extends('admin.includes.master')

@section('title', 'Users Management')

@section('content')

    <div class="container-fluid">

        <div class="card card-success">

            <div class="card-header">

                <h3 class="card-title">
                    <i class="bi bi-people-fill"></i>
                    Users Management
                </h3>

                <div class="card-tools">

                    <a href="{{ route('admin.users.export') }}" class="btn btn-info btn-sm me-1">
                        <i class="bi bi-download"></i>
                        Download CSV
                    </a>

                    <a href="{{ route('admin.users.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i>
                        Add User
                    </a>

                </div>

            </div>

            <div class="card-body">

                <form action="{{ route('admin.users.index') }}" method="GET">

                    <div class="row mb-3">

                        <div class="col-md-4">

                            <input type="text" name="search" class="form-control"
                                placeholder="Search Name / Email / Phone..." value="{{ request('search') }}">

                        </div>

                        <div class="col-md-3">

                            <select name="status" class="form-select">

                                <option value="">All Status</option>

                                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                        </div>

                        <div class="col-md-2">

                            <button class="btn btn-success w-100">

                                <i class="bi bi-search"></i>

                                Search

                            </button>

                        </div>

                        <div class="col-md-2">

                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary w-100">

                                Reset

                            </a>

                        </div>

                    </div>

                </form>

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle">

                        <thead class="table-success">

                            <tr>

                                <th width="60">S.No.</th>

                                <th width="80">Photo</th>

                                <th>Name</th>

                                <th>Email</th>

                                <th>Phone</th>

                                <th>Designation</th>

                                <th>Status</th>

                                <th width="180">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @forelse($users as $user)
                                <tr>

                                    <td>
                                        {{ $users->firstItem() + $loop->index }}
                                    </td>

                                    <td>

                                        @if ($user->photo)
                                            @php
                                                $usrImg = str_starts_with($user->photo, 'uploads/') 
                                                    ? asset($user->photo) 
                                                    : asset('storage/' . $user->photo);
                                            @endphp
                                            <img src="{{ $usrImg }}" width="45" height="45"
                                                class="rounded-circle" style="object-fit:cover;">
                                        @else
                                            <img src="{{ asset('admin/assets/img/default-user.png') }}" width="45"
                                                height="45" class="rounded-circle">
                                        @endif

                                    </td>

                                    <td>

                                        <strong>{{ $user->name }}</strong>

                                    </td>

                                    <td>{{ $user->email }}</td>

                                    <td>{{ $user->phone ?? '-' }}</td>

                                    <td>{{ $user->designation ?? '-' }}</td>

                                    <td>
                                        <form action="{{ route('admin.users.toggle', is_object($user) ? ($user->id ?? 1) : 1) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle Active/Inactive">
                                                @if ($user->is_active)
                                                    <span class="badge bg-success" style="cursor: pointer;"><i class="bi bi-toggle-on me-1"></i> Active</span>
                                                @else
                                                    <span class="badge bg-danger" style="cursor: pointer;"><i class="bi bi-toggle-off me-1"></i> Inactive</span>
                                                @endif
                                            </button>
                                        </form>
                                    </td>

                                    <td>

                                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-info btn-sm">

                                            <i class="bi bi-eye"></i>

                                        </a>

                                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button onclick="return confirm('Delete this user?')"
                                                class="btn btn-danger btn-sm">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="8" class="text-center text-muted">

                                        No Users Found.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3">

                    {{ $users->withQueryString()->links() }}

                </div>

            </div>

        </div>



    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session('success') }}'
                });
            });
        </script>
    @endif

@endsection
