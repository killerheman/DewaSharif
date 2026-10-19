@extends('admin.includes.master')

@section('title', 'Support Ticket Details')

@section('content')

    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-6">
                        <h1>Support Ticket</h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.support-tickets.index') }}">Tickets</a>
                            </li>
                            <li class="breadcrumb-item active">View</li>
                        </ol>
                    </div>

                </div>
            </div>
        </section>


        <section class="content">
            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-8">

                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">
                                    {{ $supportTicket->ticket_no }}
                                </h3>
                            </div>


                            <div class="card-body">

                                <h5>{{ $supportTicket->subject }}</h5>

                                <p>
                                    {{ $supportTicket->message }}
                                </p>

                                <hr>

                                <strong>Customer:</strong>
                                {{ $supportTicket->user->name ?? '-' }}

                                <br>

                                <strong>Email:</strong>
                                {{ $supportTicket->user->email ?? '-' }}

                            </div>

                        </div>


                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">Conversation</h3>
                            </div>


                            <div class="card-body">

                                @forelse($supportTicket->replies as $reply)
                                    <div class="mb-3">

                                        <strong>
                                            {{ $reply->user->name ?? 'User' }}
                                        </strong>

                                        <p class="mb-1">
                                            {{ $reply->message }}
                                        </p>

                                        <small class="text-muted">
                                            {{ $reply->created_at->format('d M Y h:i A') }}
                                        </small>

                                    </div>

                                    <hr>

                                @empty

                                    <p class="text-muted">
                                        No replies yet.
                                    </p>
                                @endforelse

                            </div>

                        </div>


                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">Reply</h3>
                            </div>


                            <div class="card-body">

                                <form action="{{ route('admin.support-tickets.reply', $supportTicket->id) }}"
                                    method="POST">

                                    @csrf

                                    <textarea name="message" class="form-control" rows="5" placeholder="Write reply..." required></textarea>

                                    <button class="btn btn-primary mt-3">
                                        Send Reply
                                    </button>

                                </form>

                            </div>

                        </div>


                    </div>


                    <div class="col-md-4">


                        <div class="card">

                            <div class="card-header">
                                <h3 class="card-title">Status</h3>
                            </div>


                            <div class="card-body">

                                <form action="{{ route('admin.support-tickets.update', $supportTicket->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('PUT')


                                    <select name="status" class="form-control">

                                        @foreach (['Open', 'In Progress', 'Resolved', 'Closed'] as $status)
                                            <option value="{{ $status }}"
                                                {{ $supportTicket->status == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach

                                    </select>


                                    <button class="btn btn-success mt-3">
                                        Update
                                    </button>


                                </form>

                            </div>

                        </div>


                    </div>

                </div>

            </div>
        </section>

    </div>

@endsection
