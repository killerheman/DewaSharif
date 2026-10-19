@extends('admin.includes.master')

@section('title', 'Support Tickets')

@section('content')

    <div class="content-wrapper">


        <section class="content-header">

            <div class="container-fluid">

                <div class="row mb-2">

                    <div class="col-sm-6">

                        <h1>
                            Support Tickets
                        </h1>

                    </div>


                    <div class="col-sm-6">

                        <ol class="breadcrumb float-sm-right">

                            <li class="breadcrumb-item">
                                <a href="{{ route('admin.dashboard') }}">
                                    Dashboard
                                </a>
                            </li>

                            <li class="breadcrumb-item active">
                                Support Tickets
                            </li>

                        </ol>

                    </div>


                </div>

            </div>

        </section>



        <section class="content">

            <div class="container-fluid">


                <div class="card">


                    <div class="card-header">

                        <h3 class="card-title">
                            Support Tickets List
                        </h3>

                    </div>



                    <div class="card-body">


                        <form method="GET">

                            <div class="row mb-3">


                                <div class="col-md-5">

                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search ticket/customer..." value="{{ request('search') }}">

                                </div>



                                <div class="col-md-3">

                                    <select name="status" class="form-control">


                                        <option value="">
                                            All Status
                                        </option>


                                        @foreach (['Open', 'In Progress', 'Resolved', 'Closed'] as $status)
                                            <option value="{{ $status }}"
                                                {{ request('status') == $status ? 'selected' : '' }}>

                                                {{ $status }}

                                            </option>
                                        @endforeach


                                    </select>

                                </div>



                                <div class="col-md-2">

                                    <button class="btn btn-primary">
                                        Search
                                    </button>

                                </div>


                            </div>

                        </form>




                        <div class="table-responsive">


                            <table class="table table-bordered table-striped">


                                <thead>

                                    <tr>

                                        <th>Sr. No.</th>
                                        <th>Ticket No</th>
                                        <th>Customer</th>
                                        <th>Subject</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th width="100">Action</th>

                                    </tr>

                                </thead>



                                <tbody>


                                    @forelse($tickets as $ticket)
                                        <tr>


                                            <td>
                                                {{ $loop->iteration }}
                                            </td>


                                            <td>
                                                {{ $ticket->ticket_no }}
                                            </td>



                                            <td>

                                                {{ $ticket->user->name ?? '-' }}

                                                <br>

                                                <small>
                                                    {{ $ticket->user->email ?? '' }}
                                                </small>

                                            </td>



                                            <td>

                                                {{ $ticket->subject }}

                                            </td>



                                            <td>


                                                @if ($ticket->status == 'Open')
                                                    <span class="badge bg-danger">
                                                        Open
                                                    </span>
                                                @elseif($ticket->status == 'In Progress')
                                                    <span class="badge bg-warning text-dark">
                                                        In Progress
                                                    </span>
                                                @elseif($ticket->status == 'Resolved')
                                                    <span class="badge bg-success">
                                                        Resolved
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        Closed
                                                    </span>
                                                @endif


                                            </td>

                                            <td>

                                                {{ $ticket->created_at->format('d M Y, h:i A') }}

                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center gap-1">
                                                    <a href="{{ route('admin.support-tickets.show', $ticket->id) }}"
                                                        class="btn btn-sm btn-primary text-nowrap">
                                                        <i class="bi bi-chat-left-text me-1"></i> Manage Ticket
                                                    </a>

                                                    <form action="{{ route('admin.support-tickets.destroy', $ticket->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger text-nowrap" title="Delete Ticket">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>


                                        </tr>



                                    @empty


                                        <tr>

                                            <td colspan="7" class="text-center">

                                                No tickets found.

                                            </td>

                                        </tr>
                                    @endforelse


                                </tbody>


                            </table>


                        </div>



                        <div class="mt-3">

                            {{ $tickets->links() }}

                        </div>



                    </div>


                </div>


            </div>


        </section>


    </div>


@endsection
