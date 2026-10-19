@extends('home.includes.master')

@section('content')
<div style="background: #f8fafc; padding: 40px 0 80px 0; min-height: 85vh;">
    <div class="container">
        
        <div class="row">
            <!-- LEFT SIDEBAR -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('home.customer.includes.customer_sidebar')
            </div>

            <!-- MAIN CONTENT AREA MATCHING HOSTLOK SCREENSHOT 5 -->
            <div class="col-lg-9 col-md-8">
                
                <div class="mb-3">
                    <h3 style="font-weight: 900; color: #0f172a; margin-bottom: 4px; font-size: 22px;">
                        Ticket Details
                    </h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb bg-transparent p-0 m-0" style="font-size: 13px; font-weight: 600;">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}" style="color: #052c16; text-decoration: none;">🏠 Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.dashboard') }}" style="color: #052c16; text-decoration: none;">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('customer.reportIssue') }}" style="color: #052c16; text-decoration: none;">Report an Issue</a></li>
                            <li class="breadcrumb-item active text-muted" aria-current="page">Details</li>
                        </ol>
                    </nav>
                </div>

                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                    <h2 style="font-weight: 900; color: #0f172a; margin-bottom: 15px; font-size: 24px; letter-spacing: -0.5px;">
                        {{ $ticket['ticket_no'] ?? ($ticket['ticket_id'] ?? 'SUP-000011') }}
                    </h2>

                    <div style="border-top: 1px solid #f1f5f9; pt-3; margin-top: 15px; padding-top: 15px;">
                        <h4 style="font-weight: 800; color: #1e293b; font-size: 18px; margin-bottom: 6px;">
                            {{ $ticket['subject'] ?? 'General Issue Query' }}
                        </h4>
                        <p style="color: #64748b; font-size: 14px; margin-bottom: 15px; line-height: 1.6;">
                            {{ $ticket['message'] ?? 'No message content.' }}
                        </p>

                        <div class="mb-4">
                            <span style="font-weight: 700; color: #475569; font-size: 13.5px; margin-right: 8px;">Status:</span>
                            @if(strtolower($ticket['status'] ?? 'open') === 'resolved')
                                <span class="badge" style="background: #dcfce7; color: #15803d; font-size: 12px; font-weight: 800; padding: 5px 12px; border-radius: 6px;">Resolved</span>
                            @else
                                <span class="badge" style="background: #fee2e2; color: #ef4444; font-size: 12px; font-weight: 800; padding: 5px 12px; border-radius: 6px;">Open</span>
                            @endif
                        </div>

                        <!-- CONVERSATION BOX MATCHING SCREENSHOT 5 -->
                        <div style="background: #f0fdf4; border: 1px solid #dcfce7; border-radius: 12px; padding: 20px; margin-bottom: 25px;">
                            <h5 style="font-weight: 900; color: #065f46; margin-bottom: 12px; font-size: 16px;">
                                Conversation
                            </h5>
                            @if(!empty($ticket['reply']))
                                <div class="p-3 bg-white rounded-3 border mb-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <strong style="color: #052c16; font-size: 13.5px;">🎧 DewaSharif Support Desk Response:</strong>
                                        <small class="text-muted">{{ $ticket['reply_at'] ?? date('d M Y') }}</small>
                                    </div>
                                    <p style="color: #334155; font-size: 14px; margin: 0; white-space: pre-line;">{{ $ticket['reply'] }}</p>
                                </div>
                            @else
                                <p style="color: #047857; font-size: 14px; margin: 0; font-weight: 500;">
                                    No reply yet. Our support team is reviewing your ticket and will update you shortly.
                                </p>
                            @endif
                        </div>

                        <a href="{{ route('customer.reportIssue') }}" class="btn" style="background: #052c16; color: #ffffff; font-weight: 800; font-size: 14px; border-radius: 8px; padding: 9px 24px; border: none;">
                            Back
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
