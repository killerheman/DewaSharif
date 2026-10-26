@extends('admin.includes.master')

@section('title', 'Store Customer Orders | DewaSharif Admin')

@section('content')
<style>
    .btn-gradient-white {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 50%, #cbd5e1 100%) !important;
        color: #0f172a !important;
        border: none !important;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: all 0.2s ease-in-out;
    }
    .btn-gradient-white:hover {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
        color: #0284c7 !important;
    }
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
    .btn-gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%) !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 2px 5px rgba(220, 38, 38, 0.3);
        transition: all 0.2s ease-in-out;
    }
    .btn-gradient-red:hover {
        background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(220, 38, 38, 0.4);
    }
    .badge-gradient-green {
        background: linear-gradient(135deg, #064e3b 0%, #047857 45%, #10b981 85%, #34d399 100%) !important;
        color: #ffffff !important;
        font-weight: 600;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 6px rgba(4, 120, 87, 0.35);
    }
    .badge-gradient-yellow {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #ee8916ff 100%) !important;
        color: #1e1b4b !important;
        font-weight: 700;
        box-shadow: 0 2px 5px rgba(245, 158, 11, 0.35);
    }
    .badge-gradient-navy {
        background: linear-gradient(135deg, #0b132b 0%, #1e3a8a 50%, #2563eb 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 5px rgba(30, 58, 138, 0.3);
    }
    .title-gradient-green {
        background: linear-gradient(135deg, #064e3b 0%, #047857 45%, #10b981 85%, #059669 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        font-weight: 800;
    }
    .badge-gradient-dark {
        background: linear-gradient(135deg, #0b132b 0%, #1e293b 50%, #1e40af 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.4);
    }
    .table-aligned td {
        vertical-align: middle !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
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
</style>

<main class="app-main">
    <div class="app-content-header py-3">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-receipt text-success me-2"></i><span class="title-gradient-green">Sacred Store Customer Orders</span>
                    </h3>
                    <small class="text-muted">Real-time Order Management, Dispatch Status &amp; Customer Billing</small>
                </div>
                <div class="col-sm-6 text-end">
                    <span class="badge bg-dark text-info fs-6 px-3 py-2 shadow-sm rounded-pill border border-info">
                        <i class="bi bi-box-seam me-1"></i> Live Orders &amp; Dispatch Portal
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

            <div class="card card-outline card-primary shadow border-0 rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-list-stars me-2 text-primary fs-5"></i>Customer Orders List
                    </h5>
                    <!-- Dark Slate Navy Gradient Total Orders Badge -->
                    <span class="badge badge-gradient-dark fs-6 px-3 py-1.5 rounded-pill border border-primary">Total Orders: {{ count($orders) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-aligned">
                            <thead class="custom-table-header">
                                <tr>
                                    <th class="ps-3">Order #</th>
                                    <th>Customer Info</th>
                                    <th>Shipping Address</th>
                                    <th class="text-center">Items</th>
                                    <th>Total Billed</th>
                                    <th>Payment Status</th>
                                    <th>Order Status</th>
                                    <th>Courier / Delivery Details</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    @php
                                        $oId = is_array($order) ? ($order['id'] ?? 1) : $order->id;
                                        $custName = is_array($order) ? ($order['customer_name'] ?? 'Customer') : ($order->customer_name ?? 'Customer');
                                        $custPhone = is_array($order) ? ($order['customer_phone'] ?? '9648777223') : ($order->customer_phone ?? '9648777223');
                                        $custAltPhone = is_array($order) ? ($order['alternate_phone'] ?? null) : ($order->alternate_phone ?? null);
                                        if (empty($custAltPhone) && !empty(is_array($order) ? ($order['customer_whatsapp'] ?? null) : ($order->customer_whatsapp ?? null))) {
                                            $altCand = is_array($order) ? $order['customer_whatsapp'] : $order->customer_whatsapp;
                                            if ($altCand !== $custPhone) $custAltPhone = $altCand;
                                        }
                                        $address = is_array($order) ? ($order['address'] ?? ($order['shipping_address'] ?? 'Dewa Sharif, UP')) : ($order->shipping_address ?? 'Dewa Sharif, UP');
                                        $itemsSummary = is_array($order) ? ($order['items_summary'] ?? 'Sacred Store Items') : ($order->items_summary ?? 'Sacred Store Items');
                                        $totalAmount = is_array($order) ? ($order['total_amount'] ?? ($order['amount'] ?? 599)) : ($order->total_amount ?? 599);
                                        $status = strtolower(is_array($order) ? ($order['status'] ?? 'processing') : ($order->status ?? 'processing'));
                                        $courier = is_array($order) ? ($order['courier'] ?? 'Not Dispatched') : ($order->courier ?? 'Not Dispatched');
                                        $tracking = is_array($order) ? ($order['tracking'] ?? 'N/A') : ($order->tracking ?? 'N/A');
                                        $paymentMethod = is_array($order) ? ($order['payment_method'] ?? 'COD') : ($order->payment_method ?? 'COD');
                                        $paymentStatus = is_array($order) ? ($order['payment_status'] ?? ($paymentMethod === 'Razorpay Online' ? 'Paid' : 'Pending (COD)')) : ($order->payment_status ?? 'Pending (COD)');
                                        $fatehaName = is_array($order) ? ($order['fateha_name'] ?? null) : ($order->fateha_name ?? null);
                                        $niyazDate = is_array($order) ? ($order['niyaz_date'] ?? null) : ($order->niyaz_date ?? null);
                                        $distributionType = is_array($order) ? ($order['distribution_type'] ?? null) : ($order->distribution_type ?? null);
                                        $isDegh = !empty($fatehaName) || str_contains(strtolower($itemsSummary), 'degh') || str_contains(strtolower($itemsSummary), 'biryani') || str_contains(strtolower($itemsSummary), 'zarda') || str_contains(strtolower($itemsSummary), 'kheer');
                                    @endphp
                                    <tr>
                                        <td class="ps-3">
                                            <strong class="text-dark font-bold">{{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}</strong>
                                            <br><small class="text-muted"><i class="bi bi-clock me-1"></i>{{ is_array($order) ? ($order['created_at'] ?? date('Y-m-d H:i')) : ($order->created_at ?? date('Y-m-d H:i')) }}</small>
                                            @if($isDegh)
                                                <br><span class="badge bg-success bg-opacity-10 text-success border border-success mt-1" style="font-size: 0.68rem; font-weight: 800;">DEGH NIYAZ</span>
                                            @endif
                                        </td>
                                        <td>
                                            <!-- Green Gradient Customer Name Badge -->
                                            <span class="badge badge-gradient-green px-2.5 mb-1 d-inline-flex align-items-center shadow-sm" style="height: 34px; font-size: 0.82rem;">
                                                <i class="bi bi-person-fill me-1"></i>{{ $custName }}
                                            </span>
                                            <br><small class="text-muted font-mono"><i class="bi bi-telephone-fill me-1 text-success"></i>{{ $custPhone }}</small>
                                            @php
                                                $cleanWaPhone = preg_replace('/[^0-9]/', '', $custPhone);
                                                if(strlen($cleanWaPhone) === 10) $cleanWaPhone = '91' . $cleanWaPhone;
                                                $waOrderText = urlencode("Assalamu Alaikum {$custName}! Dewa Sharif Sacred Store se aapke Order " . ($isDegh ? '#DGH-' : '#ORD-') . "{$oId} ke confirmation ke silsile me baat karni hai.");
                                            @endphp
                                            <br><a href="https://wa.me/{{ $cleanWaPhone }}?text={{ $waOrderText }}" target="_blank" class="badge bg-success text-white text-decoration-none mt-1 shadow-xs d-inline-flex align-items-center" style="font-size: 10.5px; font-weight: 700; padding: 3px 8px;">
                                                <i class="bi bi-whatsapp me-1"></i>WhatsApp Confirm
                                            </a>
                                            @if(!empty($custAltPhone))
                                                <br><small class="text-secondary font-mono" style="font-size: 0.74rem;"><i class="bi bi-telephone-plus me-1 text-primary"></i>Alt: {{ $custAltPhone }}</small>
                                            @endif
                                            @if(!empty($fatehaName))
                                                <br><small class="text-dark fw-bold" style="font-size: 0.76rem;"><i class="bi bi-heart-fill text-danger me-1"></i>Dua: {{ $fatehaName }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <small class="text-dark d-inline-block text-truncate fw-semibold" style="max-width: 170px;" title="{{ $address }}">
                                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $address }}
                                            </small>
                                            @if(!empty($distributionType))
                                                <br><small class="text-primary fw-bold" style="font-size: 0.72rem;"><i class="bi bi-compass me-1"></i>{{ Str::limit($distributionType, 22) }}</small>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <!-- Red Gradient View Items Button -->
                                            <button class="btn btn-sm btn-gradient-red rounded-3 px-3 font-semibold text-nowrap d-inline-flex align-items-center justify-content-center" style="height: 34px;" data-bs-toggle="modal" data-bs-target="#viewOrderModal{{ $oId }}">
                                                <i class="bi bi-eye me-1"></i> View Items
                                            </button>
                                        </td>
                                        <td>
                                            <strong class="text-success fs-6 fw-bold">₹{{ number_format($totalAmount, 2) }}</strong>
                                            <br><small class="text-muted">{{ $paymentMethod }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $rawPay = strtolower($paymentStatus);
                                                $isOrderPaid = in_array($rawPay, ['paid', 'completed', 'success']);
                                                $isOrderFailed = in_array($rawPay, ['failed', 'cancelled', 'rejected']);
                                                $oUtr = is_array($order) ? ($order['utr_number'] ?? null) : ($order->utr_number ?? null);
                                            @endphp
                                            @if($isOrderPaid)
                                                <span class="badge bg-success shadow-sm px-2.5 d-inline-flex align-items-center" style="height: 34px; font-size: 0.82rem;"><i class="bi bi-check-circle-fill me-1"></i> Paid</span>
                                            @elseif($isOrderFailed)
                                                <span class="badge bg-danger shadow-sm px-2.5 d-inline-flex align-items-center" style="height: 34px; font-size: 0.82rem;"><i class="bi bi-x-circle-fill me-1"></i> Payment Failed</span>
                                            @else
                                                <span class="badge bg-warning text-dark shadow-sm px-2.5 d-inline-flex align-items-center" style="height: 34px; font-size: 0.82rem;"><i class="bi bi-hourglass-split me-1"></i> Pending UTR</span>
                                            @endif
                                            @if(!empty($oUtr))
                                                <br><small class="badge d-inline-block mt-1" style="background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 45%, #e2e8f0 75%, #cbd5e1 100%) !important; color: #0f172a !important; border: 1px solid #94a3b8 !important; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); font-family: monospace; font-size: 10.5px; font-weight: 700;">UTR: {{ $oUtr }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-inline-flex align-items-center" style="height: 34px;">
                                                @if($status === 'delivered')
                                                    <span class="badge bg-success shadow-sm px-2.5 d-inline-flex align-items-center" style="height: 34px; font-size: 0.82rem;"><i class="bi bi-house-check-fill me-1"></i> Delivered</span>
                                                @elseif($status === 'dispatched')
                                                    <!-- Yellow Gradient Dispatched Badge -->
                                                    <span class="badge badge-gradient-yellow px-2.5 d-inline-flex align-items-center" style="height: 34px; font-size: 0.82rem;"><i class="bi bi-truck me-1"></i> Dispatched</span>
                                                @elseif($status === 'out for delivery')
                                                    <span class="badge bg-primary shadow-sm px-2.5 d-inline-flex align-items-center" style="height: 34px; font-size: 0.82rem;"><i class="bi bi-bicycle me-1"></i> Out for Delivery</span>
                                                @elseif($status === 'cancelled')
                                                    <span class="badge bg-danger shadow-sm px-2.5 d-inline-flex align-items-center" style="height: 34px; font-size: 0.82rem;"><i class="bi bi-x-circle-fill me-1"></i> Cancelled</span>
                                                @else
                                                    <span class="badge bg-warning text-dark shadow-sm px-2.5 d-inline-flex align-items-center" style="height: 34px; font-size: 0.82rem;"><i class="bi bi-clock-history me-1"></i> Processing</span>
                                                @endif
                                                
                                                <!-- Quick Change Status Trigger -->
                                                <button class="btn btn-link btn-sm p-0 ms-1.5 text-decoration-none d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#statusModal{{ $oId }}" title="Change Status">
                                                    <i class="bi bi-pencil-square text-secondary fs-6"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            @if($courier !== 'Not Dispatched')
                                                <strong class="text-dark small d-block mb-0"><i class="bi bi-box-seam me-1 text-primary"></i>{{ $courier }}</strong>
                                                <small class="text-muted d-block" style="font-size: 0.78rem;">Ref: {{ $tracking }}</small>
                                            @else
                                                <span class="text-muted small"><em>Not assigned yet</em></span>
                                            @endif
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="btn-group shadow-sm rounded-3 overflow-hidden" style="height: 34px;">
                                                <!-- 1-Click Approve Button -->
                                                <form action="{{ route('admin.shop.order.approve', $oId) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve Order {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }} as PAID?');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $isOrderPaid ? 'btn-outline-success disabled' : 'btn-success' }} d-inline-flex align-items-center justify-content-center px-2.5 rounded-0" style="height: 34px;" title="Approve & Confirm Paid">
                                                        <i class="bi bi-check-circle-fill"></i>
                                                    </button>
                                                </form>

                                                <!-- 1-Click Reject Button -->
                                                <form action="{{ route('admin.shop.order.reject', $oId) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject Order {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}? Payment will be marked FAILED and invoice VOIDED.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $isOrderFailed ? 'btn-outline-danger disabled' : 'btn-danger' }} d-inline-flex align-items-center justify-content-center px-2.5 rounded-0" style="height: 34px;" title="Reject Order (Payment Failed / Fake UTR)">
                                                        <i class="bi bi-x-circle-fill"></i>
                                                    </button>
                                                </form>

                                                <!-- Dark Light Navy Blue Gradient Dispatch Button -->
                                                <button class="btn btn-sm btn-gradient-navy font-bold px-3 text-nowrap d-inline-flex align-items-center rounded-0" style="height: 34px;" data-bs-toggle="modal" data-bs-target="#dispatchModal{{ $oId }}">
                                                    <i class="bi bi-send-fill me-1"></i> Dispatch Order
                                                </button>
                                                <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => $oId]) }}" target="_blank" class="btn btn-sm btn-gradient-white d-inline-flex align-items-center justify-content-center px-2.5 rounded-0" style="height: 34px;" title="View / Print Official Invoice">
                                                    <i class="bi bi-printer"></i>
                                                </a>
                                                <form action="{{ route('admin.shop.order.destroy', $oId) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete Order {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-gradient-red d-inline-flex align-items-center justify-content-center px-2.5" style="height: 34px; border-radius: 0;" title="Delete Order">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Dispatch / Delivery Modal -->
                                    <div class="modal fade" id="dispatchModal{{ $oId }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content border-0 shadow-lg rounded-3">
                                                <form action="{{ route('admin.shop.dispatch', $oId) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header btn-gradient-navy text-white">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-box-seam me-2"></i>Dispatch Order {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body row g-3">
                                                        <div class="col-12 bg-light p-3 rounded-3 border border-primary">
                                                            <strong>Customer:</strong> {{ $custName }} ({{ $custPhone }})<br>
                                                            <small class="text-muted"><strong>Address:</strong> {{ $address }}</small>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label class="form-label font-bold">Select Courier / Delivery Method*</label>
                                                            <select name="courier_name" class="form-select font-bold" required>
                                                                <option value="Dargah Sharif Langarkhana (Zaireen Distribution)" {{ $courier === 'Dargah Sharif Langarkhana (Zaireen Distribution)' ? 'selected' : '' }}>🕌 Dargah Sharif Langarkhana (Zaireen Distribution)</option>
                                                                <option value="Dewa Sharif Hotel/Guest House Handover" {{ $courier === 'Dewa Sharif Hotel/Guest House Handover' ? 'selected' : '' }}>🏨 Dewa Sharif Hotel/Guest House Handover</option>
                                                                <option value="DTDC Express" {{ $courier === 'DTDC Express' ? 'selected' : '' }}>🚚 DTDC Express</option>
                                                                <option value="Shadowfax Logistics" {{ $courier === 'Shadowfax Logistics' ? 'selected' : '' }}>📦 Shadowfax Logistics</option>
                                                                <option value="Blue Dart" {{ $courier === 'Blue Dart' ? 'selected' : '' }}>✈️ Blue Dart Express</option>
                                                                <option value="Delhivery Courier" {{ $courier === 'Delhivery Courier' ? 'selected' : '' }}>🚚 Delhivery</option>
                                                                <option value="India Post (Speed Post)" {{ $courier === 'India Post (Speed Post)' ? 'selected' : '' }}>📮 India Post (Speed Post)</option>
                                                                <option value="Self Delivery / Local Hand Delivery (Dewa Sharif)" {{ $courier === 'Self Delivery / Local Hand Delivery (Dewa Sharif)' ? 'selected' : '' }}>🚶‍♂️ Self Delivery / Local Hand Delivery (Dewa Sharif Nearby)</option>
                                                                <option value="Store Rider (Same-Day)" {{ $courier === 'Store Rider (Same-Day)' ? 'selected' : '' }}>🏍️ Store Rider (Same-Day Urgent Delivery)</option>
                                                                <option value="Other Courier Partner" {{ $courier === 'Other Courier Partner' ? 'selected' : '' }}>📦 Other Courier / Delivery Partner</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label class="form-label font-bold">Tracking AWB # / Delivery Note*</label>
                                                            <input type="text" name="tracking_number" class="form-control" value="{{ $tracking !== 'N/A' ? $tracking : 'DT'.rand(10000000, 99999999).'IN' }}" placeholder="e.g. DT12345678IN or Hand Delivered by Store Staff" required>
                                                            <small class="text-muted">Enter Courier Waybill tracking number OR delivery notes for self-delivery.</small>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label class="form-label font-bold">Order Status Update</label>
                                                            <select name="status" class="form-select font-bold">
                                                                <option value="Dispatched" selected>Dispatched (In-Transit)</option>
                                                                <option value="Distributed at Dargah Sharif">Distributed at Dargah Sharif</option>
                                                                <option value="Out for Delivery">Out for Delivery</option>
                                                                <option value="Delivered">Delivered &amp; Handed Over</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <label class="form-label font-bold">Dispatch Notes / Remarks (Optional)</label>
                                                            <textarea name="dispatch_notes" class="form-control" rows="2" placeholder="e.g. Package packed securely in Dewa Sharif Store."></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-gradient-navy font-bold"><i class="bi bi-check-circle me-1"></i> Save &amp; Dispatch Order</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- View Order Details Modal -->
                                    <div class="modal fade" id="viewOrderModal{{ $oId }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content border-0 shadow-lg rounded-3">
                                                <div class="modal-header btn-gradient-red text-white">
                                                    <h5 class="modal-title fw-bold"><i class="bi bi-bag-check me-2"></i>Order Details {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if($isDegh || !empty($fatehaName))
                                                    <!-- Degh Niyaz Special Detail Card -->
                                                    <div class="p-3 mb-3 rounded-3" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 100%); border: 1.5px solid #86efac;">
                                                        <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom border-success border-opacity-25">
                                                            <h6 class="fw-bold text-success mb-0"><i class="bi bi-star-fill text-warning me-1"></i> Sacred Degh Niyaz &amp; Dua Details</h6>
                                                            <span class="badge bg-success">Parcel / Langar Ready</span>
                                                        </div>
                                                        <div class="row g-2 small">
                                                            <div class="col-md-4">
                                                                <span class="text-muted d-block">🤲 Niyaz Ba-Naam:</span>
                                                                <strong class="text-dark fs-6">{{ $fatehaName ?: 'Special Fateha & Dua' }}</strong>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="text-muted d-block">📅 Scheduled Date:</span>
                                                                <strong class="text-dark fs-6">{{ $niyazDate ?: 'Urs / Nauchandi' }}</strong>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <span class="text-muted d-block">🕌 Distribution Mode:</span>
                                                                <strong class="text-success fs-6">{{ $distributionType ?: 'Dargah Sharif Me Langar Taqseem' }}</strong>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endif

                                                    <div class="row g-3 mb-3">
                                                        <div class="col-md-6 border-end">
                                                            <h6 class="text-primary font-bold"><i class="bi bi-person-circle me-1"></i> Customer Information</h6>
                                                            <p class="mb-1"><strong>Name:</strong> {{ $custName }}</p>
                                                            <p class="mb-1"><strong>Phone:</strong> {{ $custPhone }}</p>
                                                            @if(!empty($custAltPhone))
                                                                <p class="mb-1"><strong>Alternate Contact:</strong> {{ $custAltPhone }}</p>
                                                            @endif
                                                            <p class="mb-1"><strong>Delivery Address:</strong> {{ $address }}</p>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <h6 class="text-primary font-bold"><i class="bi bi-credit-card me-1"></i> Payment &amp; Delivery Status</h6>
                                                            <p class="mb-1"><strong>Total Billed Amount:</strong> ₹{{ number_format($totalAmount, 2) }}</p>
                                                            <p class="mb-1"><strong>Payment Mode:</strong> {{ $paymentMethod }}</p>
                                                            <p class="mb-1"><strong>Payment Status:</strong> 
                                                                <span class="badge {{ strtolower($paymentStatus) === 'paid' ? 'bg-success' : 'bg-warning text-dark' }}">{{ $paymentStatus }}</span>
                                                            </p>
                                                            <p class="mb-1"><strong>Current Status:</strong> <span class="badge bg-secondary text-uppercase">{{ $status }}</span></p>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <h6 class="font-bold text-dark"><i class="bi bi-box-seam me-1 text-warning"></i> Order Items Summary</h6>
                                                    <div class="bg-light p-3 rounded">
                                                        <p class="mb-0 fs-6 font-bold">{{ $itemsSummary }}</p>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => $oId]) }}" target="_blank" class="btn btn-outline-primary fw-bold me-auto">
                                                        <i class="bi bi-printer me-1"></i> View Official Invoice
                                                    </a>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Quick Change Status Modal -->
                                    <div class="modal fade" id="statusModal{{ $oId }}" tabindex="-1">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content border-0 shadow-lg rounded-3">
                                                <form action="{{ route('admin.shop.order.status', $oId) }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header btn-gradient-navy text-white">
                                                        <h6 class="modal-title font-bold text-white"><i class="bi bi-sliders me-1"></i>Update Order Status</h6>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <label class="form-label font-bold">Status for {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}</label>
                                                        <select name="status" class="form-select font-bold">
                                                            <option value="Processing" {{ $status === 'processing' ? 'selected' : '' }}>🟡 Processing</option>
                                                            <option value="Cooking / Tayyari Me Hai" {{ $status === 'cooking / tayyari me hai' ? 'selected' : '' }}>🍳 Cooking / Tayyari Me Hai</option>
                                                            <option value="Dispatched" {{ $status === 'dispatched' ? 'selected' : '' }}>🔷 Dispatched</option>
                                                            <option value="Distributed at Dargah Sharif" {{ $status === 'distributed at dargah sharif' ? 'selected' : '' }}>🕌 Distributed at Dargah Sharif</option>
                                                            <option value="Out for Delivery" {{ $status === 'out for delivery' ? 'selected' : '' }}>🚚 Out for Delivery</option>
                                                            <option value="Delivered" {{ $status === 'delivered' ? 'selected' : '' }}>🟢 Delivered</option>
                                                            <option value="Cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>🔴 Cancelled</option>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-sm btn-gradient-navy font-bold text-white">Update Status</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center py-4 text-muted">No customer orders found in Sacred Store database.</td>
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

