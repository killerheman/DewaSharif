@extends('admin.includes.master')

@section('title', 'Manage Customer Reviews & Ratings | DewaSharif Admin')

@section('content')
<style>
    .btn-gradient-navy {
        background: linear-gradient(135deg, #0b132b 0%, #1c2541 45%, #1e40af 85%, #3b82f6 100%) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 3px 8px rgba(30, 64, 175, 0.35);
        transition: all 0.25s ease-in-out;
    }
    .btn-gradient-navy:hover {
        background: linear-gradient(135deg, #1c2541 0%, #1e40af 50%, #2563eb 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(37, 99, 235, 0.5);
    }
    .btn-gradient-green {
        background: linear-gradient(135deg, #064e3b 0%, #047857 45%, #10b981 85%, #34d399 100%) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 3px 8px rgba(4, 120, 87, 0.35);
    }
    .badge-gradient-green {
        background: linear-gradient(135deg, #064e3b 0%, #047857 45%, #10b981 85%, #34d399 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
    }
    .badge-gradient-yellow {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%) !important;
        color: #1e1b4b !important;
        font-weight: 800;
    }
    .badge-gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
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
                        <i class="bi bi-star-fill text-warning me-2"></i><span class="title-gradient-green">Customer Reviews &amp; Ratings</span>
                    </h3>
                    <small class="text-muted">Manage Real-Time Customer Reviews on Sacred Products, Hotels &amp; Cabs</small>
                </div>
                <div class="col-sm-6 text-end">
                    <button type="button" class="btn btn-sm btn-gradient-green text-white font-weight-bold px-3 py-2 rounded-pill shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#addNewReviewModal">
                        <i class="bi bi-plus-circle-fill me-1"></i> Add New Review
                    </button>
                    <span class="badge bg-white text-dark border px-3 py-2 rounded-pill shadow-xs">
                        <i class="bi bi-shield-check text-success me-1"></i> Admin Moderation Active
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

            <!-- STATS CARDS -->
            <div class="row g-3 mb-4">
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-primary border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Total Reviews</small>
                                <h3 class="mb-0 fw-bold text-dark">{{ $counts['total'] ?? 0 }}</h3>
                            </div>
                            <i class="bi bi-chat-quote-fill fs-2 text-primary opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-success border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Store Products</small>
                                <h3 class="mb-0 fw-bold text-success">{{ $counts['shop'] ?? 0 }}</h3>
                            </div>
                            <i class="bi bi-bag-check-fill fs-2 text-success opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-info border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Hotel Bookings</small>
                                <h3 class="mb-0 fw-bold text-info">{{ $counts['hotel'] ?? 0 }}</h3>
                            </div>
                            <i class="bi bi-building-fill fs-2 text-info opacity-50"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="card border-0 shadow-sm rounded-3 p-3 bg-white border-start border-warning border-4">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted text-uppercase fw-bold">Cab Rides</small>
                                <h3 class="mb-0 fw-bold text-warning">{{ $counts['cab'] ?? 0 }}</h3>
                            </div>
                            <i class="bi bi-taxi-front-fill fs-2 text-warning opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FILTER BAR -->
            <div class="card border-0 shadow-sm rounded-3 mb-4 bg-white p-3">
                <form action="{{ route('admin.reviews.index') }}" method="GET" class="row g-2 align-items-center">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted mb-1">Service Type</label>
                        <select name="service_type" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="all" {{ request('service_type') == 'all' ? 'selected' : '' }}>All Services</option>
                            <option value="shop" {{ request('service_type') == 'shop' ? 'selected' : '' }}>🛍️ Sacred Shop Products</option>
                            <option value="hotel" {{ request('service_type') == 'hotel' ? 'selected' : '' }}>🏨 Hotels &amp; Rooms</option>
                            <option value="cab" {{ request('service_type') == 'cab' ? 'selected' : '' }}>🚖 Cab &amp; Taxi Rides</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted mb-1">Status</label>
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Statuses</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>✓ Approved (Live)</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending Moderation</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-bold text-muted mb-1">Search Keyword</label>
                        <input type="text" name="search" class="form-control form-control-sm" placeholder="Customer name, item, or comment text..." value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end pt-3">
                        <button type="submit" class="btn btn-sm btn-primary w-100 fw-bold">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- REVIEWS TABLE -->
            <div class="card card-outline card-primary shadow border-0 rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-chat-heart-fill me-2 text-danger"></i>Customer Reviews List
                    </h5>
                    <span class="badge btn-gradient-navy px-3 py-2 rounded-pill">Total: {{ count($reviews) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-aligned">
                            <thead class="custom-table-header">
                                <tr>
                                    <th class="ps-3">#ID</th>
                                    <th>Service</th>
                                    <th>Target Item</th>
                                    <th>Customer Info</th>
                                    <th>Rating</th>
                                    <th>Review Content</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($reviews as $r)
                                    <tr>
                                        <td class="ps-3 fw-bold text-muted">#{{ $r->id }}</td>
                                        <td>
                                            @if($r->service_type === 'shop')
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-2.5 py-1 rounded-pill fw-bold">🛍️ Shop</span>
                                            @elseif($r->service_type === 'hotel')
                                                <span class="badge bg-info bg-opacity-10 text-info border border-info px-2.5 py-1 rounded-pill fw-bold">🏨 Hotel</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-2.5 py-1 rounded-pill fw-bold">🚖 Cab</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-dark">{{ $r->item_name ?? 'Service Booking' }}</strong>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $r->customer_name }}</div>
                                            <small class="text-muted">{{ $r->customer_phone ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            <span class="text-warning fw-bold fs-6">
                                                @for($i = 1; $i <= 5; $i++)
                                                    {{ $i <= $r->rating ? '★' : '☆' }}
                                                @endfor
                                            </span>
                                            <span class="badge bg-light text-dark ms-1">({{ $r->rating }}/5)</span>
                                        </td>
                                        <td style="max-width: 280px;">
                                            @if(!empty($r->title))
                                                <div class="fw-bold text-dark small">{{ $r->title }}</div>
                                            @endif
                                            <div class="text-muted small text-truncate" title="{{ $r->comment }}">{{ $r->comment }}</div>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.reviews.toggle', $r->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @if(strtolower($r->status) === 'approved')
                                                    <button type="submit" class="badge badge-gradient-green border-0 px-3 py-1.5 rounded-pill shadow-xs cursor-pointer" title="Click to Unpublish / Mark Pending">
                                                        <i class="bi bi-check-circle me-1"></i> Approved
                                                    </button>
                                                @else
                                                    <button type="submit" class="badge badge-gradient-yellow border-0 px-3 py-1.5 rounded-pill shadow-xs cursor-pointer" title="Click to Approve / Publish">
                                                        <i class="bi bi-clock-history me-1"></i> Pending
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ date('d M Y', strtotime($r->created_at ?? now())) }}</small>
                                        </td>
                                        <td class="text-end pe-3">
                                            <!-- Edit Review Modal Trigger -->
                                            <button class="btn btn-sm btn-outline-primary fw-bold rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#editReviewModal{{ $r->id }}" title="Edit Review">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>

                                            <!-- Delete Review Form -->
                                            <form action="{{ route('admin.reviews.destroy', $r->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete this review?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold rounded-pill" title="Delete Review">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- EDIT REVIEW MODAL -->
                                    <div class="modal fade" id="editReviewModal{{ $r->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.reviews.update', $r->id) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header btn-gradient-navy text-white">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Customer Review #{{ $r->id }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body row g-3 text-start">
                                                        <div class="col-12">
                                                            <label class="form-label font-bold">Item / Service*</label>
                                                            <input type="text" name="item_name" class="form-control" value="{{ $r->item_name }}" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label font-bold">Star Rating (1 to 5)*</label>
                                                            <select name="rating" class="form-select font-bold">
                                                                <option value="5" {{ $r->rating == 5 ? 'selected' : '' }}>★★★★★ 5 Stars (Excellent)</option>
                                                                <option value="4" {{ $r->rating == 4 ? 'selected' : '' }}>★★★★☆ 4 Stars (Very Good)</option>
                                                                <option value="3" {{ $r->rating == 3 ? 'selected' : '' }}>★★★☆☆ 3 Stars (Average)</option>
                                                                <option value="2" {{ $r->rating == 2 ? 'selected' : '' }}>★★☆☆☆ 2 Stars (Poor)</option>
                                                                <option value="1" {{ $r->rating == 1 ? 'selected' : '' }}>★☆☆☆☆ 1 Star (Very Poor)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label font-bold">Review Title / Headline</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $r->title }}">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label font-bold">Customer Comment / Feedback*</label>
                                                            <textarea name="comment" class="form-control" rows="4" required>{{ $r->comment }}</textarea>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label font-bold">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="approved" {{ strtolower($r->status) === 'approved' ? 'selected' : '' }}>Approved (Visible Live)</option>
                                                                <option value="pending" {{ strtolower($r->status) === 'pending' ? 'selected' : '' }}>Pending Moderation</option>
                                                                <option value="rejected" {{ strtolower($r->status) === 'rejected' ? 'selected' : '' }}>Rejected (Hidden)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-gradient-navy fw-bold"><i class="bi bi-save me-1"></i> Update Review</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">No reviews match your filter.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD NEW REVIEW MODAL (ADMIN) -->
    <div class="modal fade" id="addNewReviewModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('admin.reviews.store') }}" method="POST">
                    @csrf
                    <div class="modal-header btn-gradient-navy text-white">
                        <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Add Customer Review &amp; Rating</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3 text-start">
                        <div class="col-md-6">
                            <label class="form-label font-bold">Service Type*</label>
                            <select name="service_type" class="form-select font-bold" required>
                                <option value="shop" selected>🛍️ Shop (Degh / Sacred Store)</option>
                                <option value="hotel">🏨 Hotel &amp; Guest House</option>
                                <option value="cab">🚖 Cab &amp; Taxi Service</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-bold">Star Rating (1 to 5)*</label>
                            <select name="rating" class="form-select font-bold" required>
                                <option value="5" selected>★★★★★ 5 Stars (Excellent)</option>
                                <option value="4">★★★★☆ 4 Stars (Very Good)</option>
                                <option value="3">★★★☆☆ 3 Stars (Average)</option>
                                <option value="2">★★☆☆☆ 2 Stars (Poor)</option>
                                <option value="1">★☆☆☆☆ 1 Star (Very Poor)</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label font-bold">Target Item / Service Name*</label>
                            <input type="text" name="item_name" class="form-control" placeholder="e.g. Warsi Mutton Biryani (Ultra Premium) ya Degh Niyaz" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-bold">Customer Name*</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="e.g. Haji Mohammad Rizwan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label font-bold">Customer Phone (Optional)</label>
                            <input type="text" name="customer_phone" class="form-control" placeholder="e.g. 9876543210">
                        </div>
                        <div class="col-12">
                            <label class="form-label font-bold">Review Title / Headline</label>
                            <input type="text" name="title" class="form-control" placeholder="e.g. Zabardast Warsi Zaiqa aur Roohani Sukoon!">
                        </div>
                        <div class="col-12">
                            <label class="form-label font-bold">Review Comment / Feedback*</label>
                            <textarea name="comment" class="form-control" rows="4" placeholder="Likhien apna feedback..." required></textarea>
                        </div>
                        <div class="col-12">
                            <label class="form-label font-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="approved" selected>Approved (Visible Live Immediately)</option>
                                <option value="pending">Pending Moderation</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient-green fw-bold text-white"><i class="bi bi-check-circle me-1"></i> Save &amp; Publish Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
