@extends('admin.includes.master')

@section('title', 'User Details')

@section('content')

    <div class="container-fluid">

        <div class="row">

            {{-- Left Profile Card --}}
            <div class="col-md-4">

                <div class="card card-success">

                    <div class="card-header">
                        <h3 class="card-title">
                            <i class="bi bi-person-circle"></i>
                            User Profile
                        </h3>
                    </div>

                    <div class="card-body text-center">

                        @if ($user->photo)
                            @php
                                $usrImg = str_starts_with($user->photo, 'uploads/') 
                                    ? asset($user->photo) 
                                    : asset('storage/' . $user->photo);
                            @endphp
                            <img src="{{ $usrImg }}" class="img-fluid rounded-circle shadow"
                                style="width:160px;height:160px;object-fit:cover;">
                        @else
                            <img src="{{ asset('admin/assets/img/default-user.png') }}" class="img-fluid rounded-circle shadow"
                                style="width:160px;height:160px;object-fit:cover;">
                        @endif

                        <h4 class="mt-3">{{ $user->name }}</h4>

                        <p class="text-muted">
                            {{ $user->designation ?? 'No Designation' }}
                        </p>

                        @if ($user->is_active)
                            <span class="badge bg-success">
                                Active
                            </span>
                        @else
                            <span class="badge bg-danger">
                                Inactive
                            </span>
                        @endif

                    </div>

                </div>

            </div>


            {{-- Right Details Card --}}
            <div class="col-md-8">

                <div class="card card-success">

                    <div class="card-header">

                        <h3 class="card-title">

                            <i class="bi bi-info-circle"></i>

                            User Information

                        </h3>

                    </div>

                    <div class="card-body">

                        <table class="table table-bordered">

                            <tr>
                                <th width="220">First Name</th>
                                <td>{{ $user->first_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Last Name</th>
                                <td>{{ $user->last_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Field</th>
                                <td>{{ $user->field ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>

                            <tr>
                                <th>Phone</th>
                                <td>{{ $user->phone ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Designation</th>
                                <td>{{ $user->designation ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Company</th>
                                <td>{{ $user->company ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Gender</th>
                                <td>{{ $user->gender ?? '-' }}</td>
                            </tr>


                            <tr>
                                <th>Country</th>
                                <td>{{ $user->country?->name ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>State</th>
                                <td>{{ $user->state?->name ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>City</th>
                                <td>{{ $user->city?->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Postal Code</th>
                                <td>{{ $user->postal_code ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Bio</th>
                                <td>{{ $user->bio ?? '-' }}</td>
                            </tr>

                            <tr>
                                <th>Address</th>
                                <td>{{ $user->address ?? '-' }}</td>
                            </tr>

                            {{-- <tr>
                            <th>Login Status</th>
                            <td>

                                @if ($user->login_status == 'online')

                                    <span class="badge bg-success">
                                        Online
                                    </span>

                                @else

                                    <span class="badge bg-secondary">
                                        Offline
                                    </span>

                                @endif

                            </td>
                        </tr> --}}

                            {{-- <tr>
                            <th>Last Login</th>
                            <td>

                                {{ $user->last_login_at ? $user->last_login_at->format('d M Y h:i A') : 'Never Logged In' }}

                            </td>
                        </tr> --}}

                            <tr>
                                <th>Created At</th>
                                <td>

                                    {{ $user->created_at->format('d M Y h:i A') }}

                                </td>
                            </tr>

                        </table>

                    </div>

                    <div class="card-footer text-end">

                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">

                            <i class="bi bi-pencil"></i>

                            Edit

                        </a>

                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">

                            <i class="bi bi-arrow-left"></i>

                            Back

                        </a>

                    </div>

                </div>

            </div>

        </div>


    </div>

@endsection
