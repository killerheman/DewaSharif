@extends('admin.includes.master')
@section('title','View Notification')
@section('content')

<div class="app-content-header">
<div class="container-fluid">
<div class="row">

<div class="col-sm-6">
<h3 class="mb-0">Notification Details</h3>
</div>

<div class="col-sm-6 text-end">

<a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">
<i class="bi bi-arrow-left-circle"></i> Back
</a>

<a href="{{ route('admin.notifications.edit',$notification) }}" class="btn btn-warning">
<i class="bi bi-pencil-square"></i> Edit
</a>

</div>

</div>
</div>
</div>


<div class="app-content">
<div class="container-fluid">

<div class="card card-success">

<div class="card-header">
<h3 class="card-title">Notification Information</h3>
</div>


<div class="card-body">

<table class="table table-bordered">

<tr>
<th width="220">Title</th>
<td>{{ $notification->title }}</td>
</tr>

<tr>
<th>Type</th>
<td>
@if($notification->type=='common')
<span class="badge bg-primary">Common</span>
@else
<span class="badge bg-info">Individual</span>
@endif
</td>
</tr>

<tr>
<th>User</th>
<td>{{ $notification->user?->name ?? 'All Users' }}</td>
</tr>

<tr>
<th>Email</th>
<td>{{ $notification->user?->email ?? '-' }}</td>
</tr>

<tr>
<th>Message</th>
<td>{{ $notification->message }}</td>
</tr>

<tr>
<th>Start Date</th>
<td>{{ $notification->start_date?->format('d M Y') ?? '-' }}</td>
</tr>

<tr>
<th>End Date</th>
<td>{{ $notification->end_date?->format('d M Y') ?? '-' }}</td>
</tr>

<tr>
<th>Status</th>
<td>
@if($notification->is_active)
<span class="badge bg-success">Active</span>
@else
<span class="badge bg-danger">Inactive</span>
@endif
</td>
</tr>

<tr>
<th>Created At</th>
<td>{{ $notification->created_at->format('d M Y, h:i A') }}</td>
</tr>

</table>

</div>

</div>

</div>
</div>

@endsection