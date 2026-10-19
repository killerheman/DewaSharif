@extends('admin.includes.master')

@section('title', 'Offer List')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Offer List</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.offers.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Add Offer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Offer List</h3>
                </div>

                <div class="card-body">

                    <form method="GET" action="{{ route('admin.offers.index') }}">
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
                                <button class="btn btn-primary w-100">
                                    <i class="bi bi-search"></i> Search
                                </button>
                            </div>

                            <div class="col-md-2">
                                <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary w-100">
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
                                    <th>Period</th>
                                    <th>Status</th>
                                    <th width="150">Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($offers as $offer)
                                    <tr>

                                        <td>{{ $loop->iteration + ($offers->firstItem() - 1) }}</td>

                                        <td>{{ $offer->title }}</td>

                                        <td>
                                            @if ($offer->type == 'common')
                                                <span class="badge bg-primary">Common</span>
                                            @else
                                                <span class="badge bg-info">Individual</span>
                                            @endif
                                        </td>

                                        <td>{{ $offer->user?->name ?? 'All Users' }}</td>

                                        <td>
                                            {{ $offer->start_date?->format('d M Y') ?? '-' }}
                                            <br>
                                            {{ $offer->end_date?->format('d M Y') ?? '-' }}
                                        </td>

                                        <td>
                                            @if ($offer->is_active)
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-danger">Inactive</span>
                                            @endif
                                        </td>

                                        <td>

                                            <a href="{{ route('admin.offers.show', $offer) }}" class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.offers.edit', $offer) }}"
                                                class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>

                                            <form action="{{ route('admin.offers.destroy', $offer) }}" method="POST"
                                                class="d-inline" onsubmit="return confirm('Delete this offer?')">
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
                                            No Offer Found.
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div class="d-flex justify-content-end mt-3">
                        {{ $offers->withQueryString()->links() }}
                    </div>

                </div>

            </div>

        </div>
    </div>

@endsection
