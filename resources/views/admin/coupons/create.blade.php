@extends('admin.includes.master')

@section('title', 'Add New Coupon')

@section('content')
<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Add New Coupon</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Coupon Code</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code') }}" required style="text-transform: uppercase;">
                    @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Discount Type</label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="fixed" @selected(old('type') == 'fixed')>Fixed Amount (₹)</option>
                        <option value="percent" @selected(old('type') == 'percent')>Percentage (%)</option>
                    </select>
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Discount Value</label>
                    <input type="number" step="0.01" name="value" class="form-control @error('value') is-invalid @enderror" value="{{ old('value') }}" required>
                    @error('value') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Expiry Date (Optional)</label>
                    <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" value="{{ old('expiry_date') }}">
                    @error('expiry_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="is_active" value="1" id="isActive" checked>
                        <label class="form-check-label" for="isActive">
                            Is Active?
                        </label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Save Coupon</button>
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
