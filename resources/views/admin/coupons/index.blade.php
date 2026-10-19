@extends('admin.includes.master')

@section('title', 'Manage Coupons')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold">Promos &amp; Coupons</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="card card-success border-0 shadow-sm rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-0">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fas fa-tags text-success me-2"></i> Active Discount Coupons</h5>
                    <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-success rounded-pill px-3 font-bold"><i class="fas fa-plus me-1"></i> Add New Coupon</a>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Code</th>
                                    <th>Discount Value</th>
                                    <th>Description / Offer</th>
                                    <th>Status</th>
                                    <th class="text-end pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($coupons as $coupon)
                                    @php
                                        $id = is_array($coupon) ? ($coupon['id'] ?? '') : $coupon->id;
                                        $code = is_array($coupon) ? ($coupon['code'] ?? '') : $coupon->code;
                                        $type = is_array($coupon) ? ($coupon['type'] ?? 'Percentage') : $coupon->type;
                                        $val = is_array($coupon) ? ($coupon['value'] ?? 0) : $coupon->value;
                                        $desc = is_array($coupon) ? ($coupon['description'] ?? '') : ($coupon->description ?? '');
                                        $status = is_array($coupon) ? ($coupon['status'] ?? 'Active') : ($coupon->is_active ? 'Active' : 'Inactive');
                                    @endphp
                                    <tr>
                                        <td>#{{ $id }}</td>
                                        <td><span class="badge bg-dark fs-6 font-monospace px-2 py-1">{{ $code }}</span></td>
                                        <td class="fw-bold text-success">
                                            @if(strtolower($type) === 'percent' || strtolower($type) === 'percentage')
                                                {{ $val }}% Off
                                            @else
                                                Flat ₹{{ number_format($val) }} Off
                                            @endif
                                        </td>
                                        <td>{{ $desc ?: 'Special Pilgrim Offer Coupon' }}</td>
                                        <td>
                                            <span class="badge bg-success">Active</span>
                                        </td>
                                        <td class="text-end pe-4">
                                            <form action="{{ route('admin.coupons.destroy', $id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete coupon {{ $code }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash me-1"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">No coupons created yet. Click "Add New Coupon" above to create one.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
