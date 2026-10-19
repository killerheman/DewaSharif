@extends('admin.includes.master')
@section('title', isset($offer) ? 'Edit Offer' : 'Add Offer')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">{{ isset($offer) ? 'Edit Offer' : 'Add Offer' }}</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">{{ isset($offer) ? 'Update Offer' : 'Create Offer' }}</h3>
                </div>

                <form action="{{ isset($offer) ? route('admin.offers.update', $offer) : route('admin.offers.store') }}"
                    method="POST">

                    @csrf
                    @if (isset($offer))
                        @method('PUT')
                    @endif

                    <div class="card-body">

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>

                                <input type="text" name="title"
                                    class="form-control @error('title') is-invalid @enderror"
                                    value="{{ old('title', isset($offer) ? $offer->title : '') }}">

                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Type</label>

                                <select name="type" class="form-select">
                                    <option value="common"
                                        {{ old('type', isset($offer) ? $offer->type : '') == 'common' ? 'selected' : '' }}>
                                        Common</option>
                                    <option value="individual"
                                        {{ old('type', isset($offer) ? $offer->type : '') == 'individual' ? 'selected' : '' }}>
                                        Individual</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">User</label>

                                <select name="user_id" class="form-select">
                                    <option value="">All Users</option>

                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id', isset($offer) ? $offer->user_id : '') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Message <span class="text-danger">*</span></label>

                                <textarea name="message" id="editor" rows="4" class="form-control">{{ old('message', isset($offer) ? $offer->message : '') }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Start Date</label>

                                <input type="date" name="start_date" class="form-control"
                                    value="{{ old('start_date', isset($offer) && $offer->start_date ? $offer->start_date->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">End Date</label>

                                <input type="date" name="end_date" class="form-control"
                                    value="{{ old('end_date', isset($offer) && $offer->end_date ? $offer->end_date->format('Y-m-d') : '') }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Show Before Login</label>

                                <select name="show_before_login" class="form-select">
                                    <option value="1"
                                        {{ old('show_before_login', isset($offer) ? $offer->show_before_login : 0) == 1 ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="0"
                                        {{ old('show_before_login', isset($offer) ? $offer->show_before_login : 0) == 0 ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Show After Login</label>

                                <select name="show_after_login" class="form-select">
                                    <option value="1"
                                        {{ old('show_after_login', isset($offer) ? $offer->show_after_login : 1) == 1 ? 'selected' : '' }}>
                                        Yes</option>
                                    <option value="0"
                                        {{ old('show_after_login', isset($offer) ? $offer->show_after_login : 1) == 0 ? 'selected' : '' }}>
                                        No</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label class="form-label">Status</label>

                                <select name="is_active" class="form-select">
                                    <option value="1"
                                        {{ old('is_active', isset($offer) ? $offer->is_active : 1) == 1 ? 'selected' : '' }}>
                                        Active</option>
                                    <option value="0"
                                        {{ old('is_active', isset($offer) ? $offer->is_active : 1) == 0 ? 'selected' : '' }}>
                                        Inactive</option>
                                </select>
                            </div>

                        </div>

                    </div>

                    <div class="card-footer">

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i>
                            {{ isset($offer) ? 'Update Offer' : 'Save Offer' }}
                        </button>

                        <a href="{{ route('admin.offers.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>

                    </div>

                </form>

            </div>

        </div>
    </div>

@endsection
