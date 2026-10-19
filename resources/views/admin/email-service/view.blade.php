@extends('admin.includes.master')

@section('title', 'All Email Services')

@section('content')

    <div class="card card-success">

        <div class="card-header">
            <h3 class="card-title">All Email Services</h3>

            <a href="{{ route('admin.email-services.create') }}" class="btn btn-success btn-sm float-end">
                <i class="bi bi-plus-circle"></i> Add Email Services
            </a>
        </div>


        <div class="card-body">


            <form method="GET" class="row mb-3">

                <div class="col-md-5">
                    <input type="text" name="search" class="form-control" placeholder="Search by Name..."
                        value="{{ request('search') }}">
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
                    <button class="btn btn-primary w-100">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>


                <div class="col-md-2">
                    <a href="{{ route('admin.email-services.index') }}" class="btn btn-secondary w-100">
                        Reset
                    </a>
                </div>

            </form>



            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-success">

                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Sort Order</th>
                            <th>Status</th>
                            <th width="150">Action</th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($services as $service)
                            <tr>

                                <td>
                                    {{ $loop->iteration + ($services->firstItem() - 1) }}
                                </td>

                                <td>
                                    {{ $service->name }}
                                </td>

                                <td>

                                    @if ($service->image)
                                        <img src="{{ asset($service->image) }}" width="60" class="img-thumbnail">
                                    @else
                                        -
                                    @endif

                                </td>

                                <td>
                                    {{ $service->sort_order }}
                                </td>

                                <td>

                                    @if ($service->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif

                                </td>

                                <td>
                                    <div class="d-flex flex-wrap gap-1">

                                        <a href="{{ route('admin.plans.byEmailService', $service) }}" class="btn btn-info btn-sm">
                                            Plan
                                        </a>

                                        <a href="{{ route('admin.faqs.byEmailService', $service) }}" class="btn btn-info btn-sm">
                                            FAQ
                                        </a>

                                        <a href="{{ route('admin.email-services.edit', $service) }}" class="btn btn-warning btn-sm">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <form action="{{ route('admin.email-services.destroy', $service) }}" method="POST"
                                            class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </button>

                                        </form>

                                    </div>
                                </td>

                            </tr>


                        @empty

                            <tr>
                                <td colspan="6" class="text-center">
                                    No Email Services Found.
                                </td>
                            </tr>
                        @endforelse


                    </tbody>

                </table>

            </div>


            {{ $services->withQueryString()->links() }}


        </div>

    </div>

@endsection
