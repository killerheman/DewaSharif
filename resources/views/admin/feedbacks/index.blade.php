@extends('admin.includes.master')

@section('title', 'Customer Feedbacks & Inquiries | DewaSharif Admin')

@section('content')
<style>
    .btn-gradient-navy {
        background: linear-gradient(135deg, #0b132b 0%, #1c2541 45%, #1e40af 85%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 3px 8px rgba(30, 64, 175, 0.35);
    }
    .title-gradient-green {
        background: linear-gradient(135deg, #064e3b 0%, #047857 45%, #10b981 85%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }
    .custom-table-header {
        background: linear-gradient(135deg, #0b132b 0%, #1e293b 100%) !important;
        color: #f8fafc;
        border-bottom: 3px solid #3b82f6;
    }
    .custom-table-header th {
        padding: 14px 12px;
        font-size: 0.88rem;
        font-weight: 700;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }
    .table-aligned td {
        vertical-align: middle !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
    }
</style>

<main class="app-main">
    <div class="app-content-header py-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-chat-right-text-fill text-success me-2"></i><span class="title-gradient-green">Customer Feedback Inbox</span>
                    </h3>
                    <small class="text-muted">Real-time Feedback &amp; Suggestions from Hotel Guests, Cab Passengers &amp; Store Buyers</small>
                </div>
                <div class="col-sm-6 text-end">
                    <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-xs">
                        <i class="bi bi-inbox-fill text-primary me-1"></i> Total Feedbacks: {{ count($feedbacks) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 border-start border-success border-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2 fs-5"></i><strong>Success!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- STATS PILLS -->
            <div class="row g-3 mb-4">
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-primary border-4">
                        <small class="text-muted text-uppercase fw-bold">All Feedbacks</small>
                        <h3 class="mb-0 fw-bold text-dark">{{ $counts['total'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-success border-4">
                        <small class="text-muted text-uppercase fw-bold">Shop Feedbacks</small>
                        <h3 class="mb-0 fw-bold text-success">{{ $counts['shop'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-info border-4">
                        <small class="text-muted text-uppercase fw-bold">Hotel Feedbacks</small>
                        <h3 class="mb-0 fw-bold text-info">{{ $counts['hotel'] ?? 0 }}</h3>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-warning border-4">
                        <small class="text-muted text-uppercase fw-bold">Cab Feedbacks</small>
                        <h3 class="mb-0 fw-bold text-warning">{{ $counts['cab'] ?? 0 }}</h3>
                    </div>
                </div>
            </div>

            <!-- FEEDBACKS TABLE -->
            <div class="card card-outline card-primary shadow border-0 rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-envelope-open-fill me-2 text-primary"></i>Customer Feedback Submissions
                    </h5>
                    <!-- Filter buttons -->
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.feedbacks.index') }}" class="btn {{ empty(request('service_type')) || request('service_type') == 'all' ? 'btn-primary' : 'btn-outline-secondary' }}">All</a>
                        <a href="{{ route('admin.feedbacks.index', ['service_type' => 'shop']) }}" class="btn {{ request('service_type') == 'shop' ? 'btn-success' : 'btn-outline-secondary' }}">Shop</a>
                        <a href="{{ route('admin.feedbacks.index', ['service_type' => 'hotel']) }}" class="btn {{ request('service_type') == 'hotel' ? 'btn-info' : 'btn-outline-secondary' }}">Hotel</a>
                        <a href="{{ route('admin.feedbacks.index', ['service_type' => 'cab']) }}" class="btn {{ request('service_type') == 'cab' ? 'btn-warning' : 'btn-outline-secondary' }}">Cab</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-aligned">
                            <thead class="custom-table-header">
                                <tr>
                                    <th class="ps-3">#ID</th>
                                    <th>Service</th>
                                    <th>Customer Name</th>
                                    <th>Contact</th>
                                    <th>Subject / Feedback</th>
                                    <th>Rating</th>
                                    <th>Date</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($feedbacks as $fb)
                                    <tr>
                                        <td class="ps-3 fw-bold text-muted">#{{ $fb->id }}</td>
                                        <td>
                                            @if($fb->service_type === 'shop')
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-2.5 py-1 rounded-pill fw-bold">🛍️ Shop</span>
                                            @elseif($fb->service_type === 'hotel')
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info px-2.5 py-1 rounded-pill fw-bold">🏨 Hotel</span>
                                            @elseif($fb->service_type === 'cab')
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-2.5 py-1 rounded-pill fw-bold">🚖 Cab</span>
                                            @else
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1 rounded-pill fw-bold">🌐 General</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $fb->customer_name }}</strong>
                                        </td>
                                        <td>
                                            <div class="small fw-bold">{{ $fb->customer_phone ?? 'N/A' }}</div>
                                            <small class="text-muted">{{ $fb->customer_email ?? '' }}</small>
                                        </td>
                                        <td style="max-width: 320px;">
                                            @if(!empty($fb->subject))
                                                <div class="fw-bold text-dark small">{{ $fb->subject }}</div>
                                            @endif
                                            <div class="text-muted small" style="white-space: pre-wrap;">{{ $fb->message }}</div>
                                        </td>
                                        <td>
                                            @if(!empty($fb->rating))
                                                <span class="text-warning fw-bold">★ {{ $fb->rating }}/5</span>
                                            @else
                                                <span class="text-muted small">N/A</span>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ date('d M Y, h:i A', strtotime($fb->created_at ?? now())) }}</small>
                                        </td>
                                        <td class="text-end pe-3">
                                            <form action="{{ route('admin.feedbacks.toggle', $fb->id) }}" method="POST" class="d-inline me-1">
                                                @csrf
                                                <button type="submit" class="btn btn-sm {{ ($fb->status === 'resolved' || $fb->status === 'reviewed') ? 'btn-success' : 'btn-outline-warning' }} fw-bold rounded-pill" title="Click to toggle status">
                                                    @if($fb->status === 'resolved' || $fb->status === 'reviewed')
                                                        <i class="bi bi-check-circle-fill me-1"></i> Resolved
                                                    @else
                                                        <i class="bi bi-clock-history me-1"></i> Pending
                                                    @endif
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.feedbacks.destroy', $fb->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this customer feedback?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold rounded-pill">
                                                    <i class="bi bi-trash me-1"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">No feedback messages found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
