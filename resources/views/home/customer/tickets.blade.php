@extends('home.includes.master')

@section('content')
<div style="background: #f8fafc; padding: 40px 0 80px 0; min-height: 85vh;">
    <div class="container">
        
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-4">
                @include('home.customer.includes.customer_sidebar')
            </div>

            <div class="col-lg-9 col-md-8">
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                        <div>
                            <h4 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 22px;">🎫 My Support Tickets</h4>
                            <small class="text-muted">Track your reported issues &amp; admin responses</small>
                        </div>
                        <a href="{{ route('customer.reportIssue') }}" class="btn btn-sm btn-success font-weight-bold px-3" style="border-radius: 8px;">+ Report New Issue</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle" style="margin: 0; font-size: 14px;">
                            <thead style="background: #f8fafc; border-bottom: 2px solid #e2e8f0;">
                                <tr>
                                    <th style="font-weight: 800; color: #475569; padding: 12px 14px; width: 70px;">Sr. No.</th>
                                    <th style="font-weight: 800; color: #475569; padding: 12px 14px;">Ticket No</th>
                                    <th style="font-weight: 800; color: #475569; padding: 12px 14px;">Subject</th>
                                    <th style="font-weight: 800; color: #475569; padding: 12px 14px; width: 100px;">Status</th>
                                    <th style="font-weight: 800; color: #475569; padding: 12px 14px; width: 180px;">Date</th>
                                    <th style="font-weight: 800; color: #475569; padding: 12px 14px; text-align: center; width: 150px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $index => $t)
                                    <tr style="border-bottom: 1px solid #f1f5f9;">
                                        <td style="font-weight: 700; color: #64748b; padding: 14px; vertical-align: middle;">
                                            {{ $index + 1 }}
                                        </td>
                                        <td style="font-weight: 800; color: #0f172a; padding: 14px; vertical-align: middle;">
                                            {{ $t['ticket_no'] ?? ($t['ticket_id'] ?? 'SUP-000011') }}
                                        </td>
                                        <td style="font-weight: 600; color: #334155; padding: 14px; vertical-align: middle;">
                                            {{ $t['subject'] ?? 'Support Inquiry' }}
                                        </td>
                                        <td style="padding: 14px; vertical-align: middle;">
                                            @if(strtolower($t['status'] ?? 'open') === 'resolved')
                                                <span class="badge" style="background: #dcfce7; color: #15803d; font-weight: 800; font-size: 11.5px; padding: 4px 10px; border-radius: 6px;">Resolved</span>
                                            @else
                                                <span class="badge" style="background: #ef4444; color: #ffffff; font-weight: 800; font-size: 11.5px; padding: 4px 10px; border-radius: 6px;">Open</span>
                                            @endif
                                        </td>
                                        <td style="font-size: 13px; color: #64748b; padding: 14px; vertical-align: middle; white-space: nowrap;">
                                            {{ date('d M Y, h:i A', strtotime($t['created_at'] ?? 'now')) }}
                                        </td>
                                        <td style="padding: 14px; vertical-align: middle; text-align: center; white-space: nowrap;">
                                            <a href="{{ route('customer.tickets.show', $t['id'] ?? 1) }}" class="btn btn-sm font-weight-bold me-1" style="background: #052c16; color: #ffffff; border-radius: 6px; padding: 5px 12px; font-size: 12.5px; text-decoration: none; border: none;">
                                                View
                                            </a>
                                            <form action="{{ route('customer.tickets.destroy', $t['id'] ?? 1) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Are you sure you want to delete this ticket?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm font-weight-bold" style="background: #ef4444; color: #ffffff; border-radius: 6px; padding: 5px 12px; font-size: 12.5px; border: none;">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-muted">
                                            <i class="fa fa-ticket text-muted mb-2" style="font-size: 30px; display: block;"></i>
                                            No support tickets submitted yet.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
