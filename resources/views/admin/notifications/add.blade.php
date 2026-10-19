@extends('admin.includes.master')
@section('title', isset($notification) ? 'Edit Notification' : 'Add Notification')

@section('content')

<div class="app-content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <h3 class="mb-0">{{ isset($notification) ? 'Edit Notification' : 'Add Notification' }}</h3>
            </div>
            <div class="col-sm-6 text-end">
                <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
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
                <h3 class="card-title">{{ isset($notification) ? 'Update Notification' : 'Create Notification' }}</h3>
            </div>

            <form action="{{ isset($notification) ? route('admin.notifications.update',$notification) : route('admin.notifications.store') }}" method="POST">

                @csrf
                @if(isset($notification))
                    @method('PUT')
                @endif

                <div class="card-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title <span class="text-danger">*</span></label>

                            <input type="text" name="title"
                                class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title', isset($notification) ? $notification->title : '') }}">

                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Type <span class="text-danger">*</span></label>

                            <select name="type" class="form-select">
                                <option value="common" {{ old('type', isset($notification) ? $notification->type : '') == 'common' ? 'selected' : '' }}>Common</option>
                                <option value="individual" {{ old('type', isset($notification) ? $notification->type : '') == 'individual' ? 'selected' : '' }}>Individual</option>
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Select User</label>

                            <select name="user_id" class="form-select">
                                <option value="">Select User</option>

                                @foreach($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('user_id', isset($notification) ? $notification->user_id : '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach

                            </select>
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">Start Date</label>

                            <input type="date" name="start_date" class="form-control"
                                value="{{ old('start_date', isset($notification) && $notification->start_date ? $notification->start_date->format('Y-m-d') : '') }}">
                        </div>

                        <div class="col-md-3 mb-3">
                            <label class="form-label">End Date</label>

                            <input type="date" name="end_date" class="form-control"
                                value="{{ old('end_date', isset($notification) && $notification->end_date ? $notification->end_date->format('Y-m-d') : '') }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Message <span class="text-danger">*</span></label>

                            <textarea name="message" id="editor" rows="5" class="form-control">{{ old('message', isset($notification) ? $notification->message : '') }}</textarea>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>

                            <select name="is_active" class="form-select">
                                <option value="1" {{ old('is_active', isset($notification) ? $notification->is_active : 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('is_active', isset($notification) ? $notification->is_active : 1) == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                    </div>

                </div>

                <div class="card-footer">

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle"></i>
                        {{ isset($notification) ? 'Update Notification' : 'Save Notification' }}
                    </button>

                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>
</div>

@endsection