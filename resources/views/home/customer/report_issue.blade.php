@extends('home.includes.master')

@section('content')
<div style="background: #f8fafc; padding: 40px 0 80px 0; min-height: 85vh;">
    <div class="container">
        
        <div class="row">
            <!-- LEFT SIDEBAR MATCHING HOSTLOK SCREENSHOT 2 -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('home.customer.includes.customer_sidebar')
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="col-lg-9 col-md-8">
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                    <h3 style="font-weight: 900; color: #0f172a; margin-bottom: 20px; font-size: 22px;">
                        Report an Issue
                    </h3>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert" style="background: #dcfce7; color: #15803d; border: 1.5px solid #86efac; padding: 15px 20px;">
                            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="line-height: 1;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('customer.reportIssue.store') }}" method="POST">
                        @csrf
                        
                        <div class="form-group mb-3">
                            <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Support Category *</label>
                            <select name="category" class="form-control" style="border-radius: 8px; border: 1px solid #cbd5e1; height: 44px; font-size: 14px;">
                                <option value="Hotel Booking Query">🏨 Hotel Booking / Guest House Stay Query</option>
                                <option value="Cab Duty & Pickups">🚖 Cab Duty Slip & Driver Pickup Issue</option>
                                <option value="Sacred Store Orders">🛍️ Sacred Store Product / Delivery Tracking</option>
                                <option value="Billing & Refund">💳 Billing, Tax Invoice & Direct Refund</option>
                                <option value="General Support" selected>❓ General Platform Inquiry</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Subject *</label>
                            <input type="text" name="subject" required class="form-control" placeholder="Enter subject" style="border-radius: 8px; border: 1px solid #cbd5e1; height: 44px; font-size: 14px;">
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Message *</label>
                            <textarea name="message" required class="form-control" rows="5" placeholder="Describe your issue in detail..." style="border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px;"></textarea>
                        </div>

                        <button type="submit" class="btn" style="background: #052c16; color: #ffffff; font-weight: 800; font-size: 14px; border-radius: 8px; padding: 10px 28px; border: none;">
                            Submit
                        </button>
                    </form>
                </div>

                <!-- MY TICKETS TABLE CARD MATCHING HOSTLOK SCREENSHOT 4 -->
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 25px; box-shadow: 0 4px 20px rgba(0,0,0,0.04); margin-top: 30px;">
                    <h4 style="font-weight: 900; color: #0f172a; margin-bottom: 18px; font-size: 20px;">
                        My Tickets
                    </h4>

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
