@extends('admin.includes.master')

@section('title', 'Store & Degh Orders Management | DewaSharif Admin')

@section('content')
<style>
    .badge-gradient-dark {
        background: linear-gradient(135deg, #0b132b 0%, #1e293b 50%, #1e40af 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.4);
    }
    .badge-silver-gradient {
        background: linear-gradient(135deg, #ffffff 0%, #f1f5f9 45%, #e2e8f0 75%, #cbd5e1 100%) !important;
        color: #0f172a !important;
        border: 1px solid #94a3b8 !important;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        font-family: monospace;
        font-size: 10.5px;
        font-weight: 700;
    }
</style>

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="bi bi-box-seam text-success me-2"></i>Sacred Store &amp; Degh Customer Orders</h3>
                    <small class="text-muted">Real-time Order Management, Dispatch Status &amp; Customer Billing</small>
                </div>
                <div class="col-sm-6 text-end">
                    <button type="button" class="btn btn-success fw-bold shadow-sm me-2" data-bs-toggle="modal" data-bs-target="#createCustomOrderModal">
                        <i class="bi bi-plus-circle-fill me-1"></i> Book Custom Degh / Order
                    </button>
                    <a href="{{ route('admin.shop.index') }}" class="btn btn-outline-primary fw-bold shadow-sm">
                        <i class="bi bi-shop me-1"></i> Manage Store Inventory
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <i class="bi bi-check-circle-fill fs-5 me-2"></i><strong>{{ session('success') }}</strong>
                        </div>
                        @if(session('new_invoice_id'))
                            <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => session('new_invoice_id')]) }}" target="_blank" class="btn btn-sm btn-dark text-warning fw-bold ms-3">
                                <i class="bi bi-printer-fill me-1"></i> Open / Print Invoice
                            </a>
                        @endif
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card card-outline card-success shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-list-stars text-success me-2"></i>Customer Orders &amp; Degh Bookings List</h5>
                    <span class="badge bg-primary fs-6">{{ count($orders) }} Orders Registered</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer &amp; Contact</th>
                                    <th>Degh / Item Details</th>
                                    <th>Niyaz / Delivery Schedule</th>
                                    <th>Total Billed</th>
                                    <th>Courier / Delivery Details</th>
                                    <th>Status</th>
                                    <th class="text-end" style="min-width: 275px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    @php
                                        $oId = is_array($order) ? ($order['id'] ?? 1) : $order->id;
                                        $rawName = is_array($order) ? ($order['customer_name'] ?? ($order['name'] ?? null)) : ($order->customer_name ?? ($order->name ?? null));
                                        $custName = !empty(trim($rawName ?? '')) ? trim($rawName) : 'Devotee Customer';
                                        
                                        $custPhone = is_array($order) ? ($order['customer_phone'] ?? ($order['phone'] ?? '9648777223')) : ($order->customer_phone ?? ($order->phone ?? '9648777223'));
                                        $custAltPhone = is_array($order) ? ($order['alternate_phone'] ?? null) : ($order->alternate_phone ?? null);
                                        if (empty($custAltPhone) && !empty(is_array($order) ? ($order['customer_whatsapp'] ?? null) : ($order->customer_whatsapp ?? null))) {
                                            $altCand = is_array($order) ? $order['customer_whatsapp'] : $order->customer_whatsapp;
                                            if ($altCand !== $custPhone) $custAltPhone = $altCand;
                                        }
                                        $address = is_array($order) ? ($order['address'] ?? ($order['shipping_address'] ?? 'Dewa Sharif, UP')) : ($order->shipping_address ?? 'Dewa Sharif, UP');
                                        $itemsSummary = is_array($order) ? ($order['items_summary'] ?? 'Sacred Store Items') : ($order->items_summary ?? 'Sacred Store Items');
                                        $totalAmount = (float)(is_array($order) ? ($order['total_amount'] ?? ($order['amount'] ?? 599)) : ($order->total_amount ?? 599));
                                        $status = strtolower(is_array($order) ? ($order['status'] ?? ($order['order_status'] ?? 'processing')) : ($order->status ?? ($order->order_status ?? 'processing')));
                                        $courier = is_array($order) ? ($order['courier'] ?? ($order['courier_name'] ?? 'Not Dispatched')) : ($order->courier ?? ($order->courier_name ?? 'Not Dispatched'));
                                        $tracking = is_array($order) ? ($order['tracking'] ?? ($order['tracking_number'] ?? 'N/A')) : ($order->tracking ?? ($order->tracking_number ?? 'N/A'));
                                        $paymentMethod = is_array($order) ? ($order['payment_mode'] ?? ($order['payment_method'] ?? 'COD')) : ($order->payment_mode ?? ($order->payment_method ?? 'COD'));
                                        $paymentStatus = is_array($order) ? ($order['payment_status'] ?? 'pending') : ($order->payment_status ?? 'pending');
                                        
                                        $fatehaName = is_array($order) ? ($order['fateha_name'] ?? null) : ($order->fateha_name ?? null);
                                        $niyazDate = is_array($order) ? ($order['niyaz_date'] ?? null) : ($order->niyaz_date ?? null);
                                        $distributionType = is_array($order) ? ($order['distribution_type'] ?? null) : ($order->distribution_type ?? null);
                                        $isDegh = !empty(is_array($order) ? ($order['is_degh'] ?? 0) : ($order->is_degh ?? 0)) || !empty($fatehaName) || str_contains(strtolower($itemsSummary), 'degh') || str_contains(strtolower($itemsSummary), 'biryani') || str_contains(strtolower($itemsSummary), 'zarda') || str_contains(strtolower($itemsSummary), 'kheer');
                                        
                                        $subtotal = is_array($order) ? ($order['subtotal'] ?? 0) : ($order->subtotal ?? 0);
                                        $handlingFee = is_array($order) ? ($order['handling_fee'] ?? 0) : ($order->handling_fee ?? 0);
                                        $packagingFee = is_array($order) ? ($order['packaging_fee'] ?? 0) : ($order->packaging_fee ?? 0);
                                        $packagingType = is_array($order) ? ($order['packaging_type'] ?? 'none') : ($order->packaging_type ?? 'none');
                                        $distFee = (float)(is_array($order) ? ($order['distribution_fee'] ?? 0) : ($order->distribution_fee ?? 0));
                                        $deliveryFee = is_array($order) ? ($order['delivery_fee'] ?? 0) : ($order->delivery_fee ?? 0);
                                        $codFee = is_array($order) ? ($order['cod_fee'] ?? 0) : ($order->cod_fee ?? 0);
                                        $deliveryTier = is_array($order) ? ($order['delivery_tier'] ?? 'standard_courier') : ($order->delivery_tier ?? 'standard_courier');
                                        $cartItemsJson = is_array($order) ? ($order['cart_items_json'] ?? null) : ($order->cart_items_json ?? null);
                                        $parsedCart = !empty($cartItemsJson) ? (is_array($cartItemsJson) ? $cartItemsJson : json_decode($cartItemsJson, true)) : [];

                                        $rawPay = strtolower($paymentStatus);
                                        $paidAmt = is_array($order) ? ($order['paid_amount'] ?? null) : ($order->paid_amount ?? null);
                                        $paidAmt = ($paidAmt !== null && $paidAmt !== '') ? (float)$paidAmt : (in_array($rawPay, ['paid', 'completed', 'success']) ? (float)$totalAmount : 0);
                                        $dueAmt = max(0, (float)$totalAmount - $paidAmt);
                                        $isOrderPaid = (in_array($rawPay, ['paid', 'completed', 'success']) && $dueAmt <= 0) || ($paidAmt >= (float)$totalAmount && (float)$totalAmount > 0);
                                        $isOrderPartial = ($rawPay === 'partial') || ($paidAmt > 0 && $dueAmt > 0);
                                        $isOrderFailed = in_array($rawPay, ['failed', 'cancelled', 'rejected']);
                                        $oUtr = is_array($order) ? ($order['utr_number'] ?? null) : ($order->utr_number ?? null);

                                        $createdRaw = is_array($order) ? ($order['created_at'] ?? date('Y-m-d H:i')) : ($order->created_at ?? date('Y-m-d H:i'));
                                        $createdDate = date('d M Y H:i', strtotime($createdRaw));
                                        $createdDateOnly = date('d M Y', strtotime($createdRaw));

                                        $cleanWaPhone = preg_replace('/[^0-9]/', '', $custPhone);
                                        if(strlen($cleanWaPhone) === 10) $cleanWaPhone = '91' . $cleanWaPhone;
                                        $waOrderText = urlencode("Assalamu Alaikum {$custName}! Dewa Sharif Sacred Store se aapke " . ($isDegh ? "Degh Niyaz Order #DGH-{$oId}" : "Order #ORD-{$oId}") . " ka bill ready hai.Invoice dekhne ke liye yahan click karein: " . route('customer.invoice', ['type' => 'shop', 'id' => $oId]));
                                    @endphp
                                    <tr>
                                        <td>
                                            <strong class="d-block text-primary">{{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}</strong>
                                            <small class="text-muted"><i class="bi bi-clock me-1"></i>{{ $createdDate }}</small>
                                            @if($isDegh)
                                                <span class="badge bg-success mt-1 d-inline-block" style="font-size: 10px;"><i class="bi bi-star-fill text-warning me-1"></i>Degh Niyaz</span>
                                            @else
                                                <span class="badge bg-secondary mt-1 d-inline-block" style="font-size: 10px;">Store Order</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="d-block text-dark"><i class="bi bi-person-fill text-primary me-1"></i>{{ $custName }}</strong>
                                            <small class="d-block text-muted"><i class="bi bi-telephone-fill text-success me-1"></i>{{ $custPhone }}</small>
                                            @if(!empty($custAltPhone))
                                                <small class="d-block text-secondary"><i class="bi bi-telephone-plus text-primary me-1"></i>Alt: {{ $custAltPhone }}</small>
                                            @endif
                                            <small class="d-block text-truncate text-muted mt-0.5" style="max-width: 180px;" title="{{ $address }}"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $address }}</small>
                                        </td>
                                        <td>
                                            <strong class="d-block text-dark">{{ Str::limit($itemsSummary, 38) }}</strong>
                                            @if(!empty($fatehaName))
                                                <small class="d-block text-danger fw-bold"><i class="bi bi-heart-fill me-1"></i>Dua: {{ $fatehaName }}</small>
                                            @endif
                                            @if(!empty($distributionType))
                                                <span class="badge bg-light text-primary border mt-1 d-inline-block text-wrap text-start" style="font-size: 10.5px; max-width: 220px; line-height: 1.3;">
                                                    <i class="bi bi-compass me-1"></i>{{ Str::limit($distributionType, 30) }}
                                                    @if($distFee > 0)
                                                        <span class="badge ms-1" style="background:#fff3cd; color:#856404; font-size:9.5px; border:1px solid #ffeeba;">+₹{{ number_format($distFee) }}</span>
                                                    @endif
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($niyazDate))
                                                <strong class="d-block text-success"><i class="bi bi-calendar-event me-1"></i>{{ $niyazDate }}</strong>
                                            @else
                                                <strong class="d-block text-muted"><i class="bi bi-calendar me-1"></i>{{ $createdDateOnly }}</strong>
                                            @endif
                                            @if($deliveryTier === 'express_2_4h')
                                                <span class="badge bg-danger text-white mt-1 d-inline-block" style="font-size: 10px;">⚡ 2-4h URGENT</span>
                                            @elseif($deliveryTier === 'local_24h')
                                                <span class="badge bg-success text-white mt-1 d-inline-block" style="font-size: 10px;">🕒 24h LOCAL</span>
                                            @else
                                                <span class="badge bg-light text-muted border mt-1 d-inline-block" style="font-size: 10px;">🚚 STD COURIER</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-success fs-6 d-block">₹{{ number_format($totalAmount, 2) }}</strong>
                                            @if($isOrderPaid)
                                                <span class="badge bg-success mt-1 d-inline-block"><i class="bi bi-check-circle-fill me-1"></i>Paid</span>
                                            @elseif($isOrderPartial)
                                                <span class="badge bg-warning text-dark mt-1 d-inline-block"><i class="bi bi-pie-chart-fill me-1 text-primary"></i>Partial Paid</span>
                                                <small class="d-block text-success fw-bold" style="font-size: 10.5px;">Adv: ₹{{ number_format($paidAmt) }}</small>
                                                <small class="d-block text-danger fw-bold" style="font-size: 10.5px;">Due: ₹{{ number_format($dueAmt) }}</small>
                                            @elseif($isOrderFailed)
                                                <span class="badge bg-danger mt-1 d-inline-block"><i class="bi bi-x-circle-fill me-1"></i>Payment Failed</span>
                                            @else
                                                <span class="badge bg-warning text-dark mt-1 d-inline-block"><i class="bi bi-clock-history me-1"></i>Pending Payment</span>
                                            @endif
                                            @if(!empty($oUtr))
                                                <small class="badge badge-silver-gradient d-block mt-1 text-wrap">UTR: {{ $oUtr }}</small>
                                            @elseif(!empty($paymentMethod) && str_contains($paymentMethod, 'UPI'))
                                                <small class="badge bg-light text-dark border d-block mt-1">UPI / QR</small>
                                            @endif
                                        </td>
                                        <td>
                                            @if($courier !== 'Not Dispatched' && !empty($courier))
                                                <span class="badge bg-info text-dark mb-1 d-inline-block"><i class="bi bi-box-seam me-1"></i>{{ Str::limit($courier, 20) }}</span>
                                                <small class="d-block text-muted">AWB: <strong>{{ $tracking }}</strong></small>
                                            @else
                                                <span class="badge bg-warning text-dark text-center d-inline-block py-1 px-2 lh-sm shadow-sm" style="font-size: 11px;">
                                                    <i class="bi bi-clock-history me-1"></i>Pending<br>Dispatch
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($status === 'delivered')
                                                <span class="badge bg-success shadow-sm"><i class="bi bi-house-check-fill me-1"></i> Delivered</span>
                                            @elseif($status === 'cooking / tayyari me hai')
                                                <span class="badge bg-warning text-dark shadow-sm"><i class="bi bi-fire me-1"></i> Cooking / Prep</span>
                                            @elseif($status === 'dispatched')
                                                <span class="badge bg-primary shadow-sm"><i class="bi bi-truck me-1"></i> Dispatched</span>
                                            @elseif($status === 'distributed at dargah sharif')
                                                <span class="badge bg-success shadow-sm"><i class="bi bi-check2-all me-1"></i> Distributed</span>
                                            @elseif($status === 'out for delivery')
                                                <span class="badge bg-info text-dark shadow-sm"><i class="bi bi-bicycle me-1"></i> Out for Delivery</span>
                                            @elseif($status === 'cancelled')
                                                <span class="badge bg-danger shadow-sm"><i class="bi bi-x-circle-fill me-1"></i> Cancelled</span>
                                            @else
                                                <span class="badge bg-secondary shadow-sm"><i class="bi bi-clock-history me-1"></i> Processing</span>
                                            @endif
                                            <button type="button" class="btn btn-xs btn-link p-0 ms-1 text-muted" data-bs-toggle="modal" data-bs-target="#statusModal{{ $oId }}" title="Quick Change Status">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div style="display: inline-grid; grid-template-columns: repeat(3, 88px); gap: 4px; vertical-align: middle;">
                                                <!-- Row 1: View, Edit, Delete -->
                                                <button type="button" class="btn btn-sm btn-info text-white fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" data-bs-toggle="modal" data-bs-target="#viewOrderModal{{ $oId }}" title="View Order Details" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-eye-fill me-1"></i> View
                                                </button>

                                                <button type="button" class="btn btn-sm btn-warning text-dark fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" data-bs-toggle="modal" data-bs-target="#editOrderModal{{ $oId }}" title="Edit Order Details & Payment Split" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>

                                                <form action="{{ route('admin.shop.order.destroy', $oId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Are you sure you want to permanently delete order {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="Delete Order" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-trash-fill me-1"></i> Delete
                                                    </button>
                                                </form>

                                                <!-- Row 2: Approve, Reject, Dispatch -->
                                                <form action="{{ route('admin.shop.order.approve', $oId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Approve order {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}? Customer invoice will show verified payment.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $isOrderPaid ? 'btn-outline-success' : ($isOrderPartial ? 'btn-warning text-dark' : 'btn-success') }} fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="{{ $isOrderPaid ? 'Already Paid & Verified (Click to Re-confirm)' : ($isOrderPartial ? 'Approve & Confirm Advance Payment' : 'Approve & Confirm Paid') }}" style="font-size: 11px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-check-circle-fill me-1"></i> {{ $isOrderPaid ? '✓ Paid' : ($isOrderPartial ? '✓ Approve Adv' : 'Approve') }}
                                                    </button>
                                                </form>

                                                <form action="{{ route('admin.shop.order.reject', $oId) }}" method="POST" class="m-0 p-0 w-100" onsubmit="return confirm('Reject order {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}? Payment will be marked FAILED and invoice VOIDED.');">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm {{ $isOrderFailed ? 'btn-outline-danger disabled' : 'btn-danger' }} fw-bold d-flex align-items-center justify-content-center shadow-sm w-100" title="Reject / Mark Failed (Fake UTR)" style="font-size: 11px; height: 28px; padding: 0 4px;">
                                                        <i class="bi bi-x-circle-fill me-1"></i> Reject
                                                    </button>
                                                </form>

                                                <button type="button" class="btn btn-sm btn-primary fw-bold d-flex align-items-center justify-content-center shadow-sm w-100 m-0" data-bs-toggle="modal" data-bs-target="#dispatchModal{{ $oId }}" title="Assign Courier & Dispatch" style="font-size: 11.5px; height: 28px; padding: 0 4px;">
                                                    <i class="bi bi-send-fill me-1"></i> Dispatch
                                                </button>

                                                <!-- Row 3: Tax Invoice & WhatsApp Bill -->
                                                <div style="grid-column: span 3; display: flex; gap: 4px; width: 100%;">
                                                    <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => $oId]) }}" target="_blank" class="btn btn-sm btn-dark text-warning fw-bold d-flex align-items-center justify-content-center shadow-sm flex-fill" style="height: 28px; font-size: 11.5px; padding: 0 4px;" title="Print Tax Invoice">
                                                        <i class="bi bi-printer me-1"></i> Tax Invoice
                                                    </a>
                                                    <a href="https://wa.me/{{ $cleanWaPhone }}?text={{ $waOrderText }}" target="_blank" class="btn btn-sm text-white fw-bold d-flex align-items-center justify-content-center shadow-sm flex-fill" style="height: 28px; font-size: 11.5px; background-color: #25D366; border-color: #25D366; padding: 0 4px;" title="Send Bill to Devotee on WhatsApp">
                                                        <i class="bi bi-whatsapp me-1"></i> WhatsApp
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">No customer orders found in Sacred Store database.</td>
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

<!-- ALL ORDER MODALS (Cleanly Placed Outside Table to Prevent DOM Breakage) -->
@foreach($orders as $order)
    @php
        $oId = is_array($order) ? ($order['id'] ?? 1) : $order->id;
        $rawName = is_array($order) ? ($order['customer_name'] ?? ($order['name'] ?? null)) : ($order->customer_name ?? ($order->name ?? null));
        $custName = !empty(trim($rawName ?? '')) ? trim($rawName) : 'Devotee Customer';
        
        $custPhone = is_array($order) ? ($order['customer_phone'] ?? ($order['phone'] ?? '9648777223')) : ($order->customer_phone ?? ($order->phone ?? '9648777223'));
        $custAltPhone = is_array($order) ? ($order['alternate_phone'] ?? '') : ($order->alternate_phone ?? '');
        if (empty($custAltPhone) && !empty(is_array($order) ? ($order['customer_whatsapp'] ?? null) : ($order->customer_whatsapp ?? null))) {
            $altCand = is_array($order) ? $order['customer_whatsapp'] : $order->customer_whatsapp;
            if ($altCand !== $custPhone) $custAltPhone = $altCand;
        }
        $address = is_array($order) ? ($order['address'] ?? ($order['shipping_address'] ?? 'Dewa Sharif, UP')) : ($order->shipping_address ?? 'Dewa Sharif, UP');
        $itemsSummary = is_array($order) ? ($order['items_summary'] ?? 'Sacred Store Items') : ($order->items_summary ?? 'Sacred Store Items');
        $totalAmount = (float)(is_array($order) ? ($order['total_amount'] ?? ($order['amount'] ?? 599)) : ($order->total_amount ?? 599));
        $status = strtolower(is_array($order) ? ($order['status'] ?? ($order['order_status'] ?? 'processing')) : ($order->status ?? ($order->order_status ?? 'processing')));
        $courier = is_array($order) ? ($order['courier'] ?? ($order['courier_name'] ?? 'Not Dispatched')) : ($order->courier ?? ($order->courier_name ?? 'Not Dispatched'));
        $tracking = is_array($order) ? ($order['tracking'] ?? ($order['tracking_number'] ?? 'N/A')) : ($order->tracking ?? ($order->tracking_number ?? 'N/A'));
        $paymentMethod = is_array($order) ? ($order['payment_mode'] ?? ($order['payment_method'] ?? 'COD')) : ($order->payment_mode ?? ($order->payment_method ?? 'COD'));
        $paymentStatus = is_array($order) ? ($order['payment_status'] ?? 'pending') : ($order->payment_status ?? 'pending');
        
        $fatehaName = is_array($order) ? ($order['fateha_name'] ?? null) : ($order->fateha_name ?? null);
        $niyazDate = is_array($order) ? ($order['niyaz_date'] ?? null) : ($order->niyaz_date ?? null);
        $distributionType = is_array($order) ? ($order['distribution_type'] ?? null) : ($order->distribution_type ?? null);
        $isDegh = !empty(is_array($order) ? ($order['is_degh'] ?? 0) : ($order->is_degh ?? 0)) || !empty($fatehaName) || str_contains(strtolower($itemsSummary), 'degh') || str_contains(strtolower($itemsSummary), 'biryani') || str_contains(strtolower($itemsSummary), 'zarda') || str_contains(strtolower($itemsSummary), 'kheer');
        
        $cartItemsJson = is_array($order) ? ($order['cart_items_json'] ?? null) : ($order->cart_items_json ?? null);
        $parsedCart = !empty($cartItemsJson) ? (is_array($cartItemsJson) ? $cartItemsJson : json_decode($cartItemsJson, true)) : [];

        $rawPay = strtolower($paymentStatus);
        $paidAmt = is_array($order) ? ($order['paid_amount'] ?? null) : ($order->paid_amount ?? null);
        $paidAmt = ($paidAmt !== null && $paidAmt !== '') ? (float)$paidAmt : (in_array($rawPay, ['paid', 'completed', 'success']) ? (float)$totalAmount : 0);
        $dueAmt = max(0, (float)$totalAmount - $paidAmt);
        $isOrderPaid = in_array($rawPay, ['paid', 'completed', 'success']) || ($paidAmt >= (float)$totalAmount && (float)$totalAmount > 0);
        $isOrderPartial = ($rawPay === 'partial') || ($paidAmt > 0 && $paidAmt < (float)$totalAmount);
        $isOrderFailed = in_array($rawPay, ['failed', 'cancelled', 'rejected']);
        $oUtr = is_array($order) ? ($order['utr_number'] ?? null) : ($order->utr_number ?? null);

        $cleanWaPhone = preg_replace('/[^0-9]/', '', $custPhone);
        if(strlen($cleanWaPhone) === 10) $cleanWaPhone = '91' . $cleanWaPhone;
        $waOrderText = urlencode("Assalamu Alaikum {$custName}! Dewa Sharif Sacred Store se aapke " . ($isDegh ? "Degh Niyaz Order #DGH-{$oId}" : "Order #ORD-{$oId}") . " ka bill ready hai.Invoice dekhne ke liye yahan click karein: " . route('customer.invoice', ['type' => 'shop', 'id' => $oId]));
    @endphp

    <!-- 1. VIEW ORDER DETAILS MODAL -->
    <div class="modal fade" id="viewOrderModal{{ $oId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start shadow-lg">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-box-seam me-2 text-warning"></i>Order Summary: {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <!-- Customer Info Card -->
                    <div class="p-3 mb-3 bg-light rounded border">
                        <div class="row g-2">
                            <div class="col-6">
                                <small class="text-muted d-block">Customer Name</small>
                                <strong class="text-dark">{{ $custName }}</strong>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Phone / WhatsApp</small>
                                <strong class="text-success">{{ $custPhone }}</strong>
                                @if(!empty($custAltPhone))
                                    <small class="d-block text-muted">Alt: {{ $custAltPhone }}</small>
                                @endif
                            </div>
                            <div class="col-12 mt-1">
                                <small class="text-muted d-block">Address</small>
                                <strong class="text-dark">{{ $address }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Degh / Package Details Card -->
                    <div class="p-3 mb-3 bg-light rounded border">
                        <div class="row g-2">
                            <div class="col-12">
                                <small class="text-muted d-block">Offering / Package Name</small>
                                <strong class="text-dark fs-6">{{ $itemsSummary }}</strong>
                            </div>
                            @if(!empty($fatehaName))
                                <div class="col-6">
                                    <small class="text-muted d-block">🤲 Niyaz Ba-Naam (Fateha/Dua)</small>
                                    <strong class="text-danger">{{ $fatehaName }}</strong>
                                </div>
                            @endif
                            @if(!empty($niyazDate))
                                <div class="col-6">
                                    <small class="text-muted d-block">📅 Scheduled Date</small>
                                    <strong class="text-success">{{ $niyazDate }}</strong>
                                </div>
                            @endif
                            @if(!empty($distributionType))
                                <div class="col-12 mt-1">
                                    <small class="text-muted d-block">🕌 Distribution Mode</small>
                                    <strong class="text-primary">{{ $distributionType }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Billing & Payment Details Card -->
                    <div class="p-3 mb-3 bg-light rounded border">
                        <div class="row g-2">
                            <div class="col-4">
                                <small class="text-muted d-block">Total Billed</small>
                                <strong class="text-success fs-5">₹{{ number_format($totalAmount, 2) }}</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Advance Paid</small>
                                <strong class="text-primary fs-5">₹{{ number_format($paidAmt, 2) }}</strong>
                            </div>
                            <div class="col-4">
                                <small class="text-muted d-block">Remaining Balance Due</small>
                                <strong class="{{ $dueAmt > 0 ? 'text-danger' : 'text-success' }} fs-5">₹{{ number_format($dueAmt, 2) }}</strong>
                            </div>
                            <div class="col-6 mt-2">
                                <small class="text-muted d-block">Payment Mode</small>
                                <strong class="text-dark">{{ $paymentMethod }}</strong>
                            </div>
                            <div class="col-6 mt-2">
                                <small class="text-muted d-block">Payment Status</small>
                                <span class="badge {{ $isOrderPaid ? 'bg-success' : ($isOrderPartial ? 'bg-warning text-dark' : 'bg-danger') }}">{{ strtoupper($paymentStatus) }}</span>
                                @if(!empty($oUtr))
                                    <small class="text-muted ms-1">(UTR: {{ $oUtr }})</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Items List (if available) -->
                    @if(!empty($parsedCart) && is_array($parsedCart) && count($parsedCart) > 0)
                        <div class="table-responsive border rounded mb-2 bg-white">
                            <table class="table table-sm table-striped align-middle mb-0" style="font-size: 0.85rem;">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th class="text-center">Rate</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-end pe-3">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($parsedCart as $cItem)
                                        @php
                                            $iName = $cItem['name'] ?? ($cItem['title'] ?? 'Sacred Item');
                                            $iQty = (int)($cItem['quantity'] ?? ($cItem['qty'] ?? 1));
                                            $iPrice = (float)($cItem['price'] ?? 0);
                                        @endphp
                                        <tr>
                                            <td class="fw-semibold text-dark">{{ $iName }}</td>
                                            <td class="text-center">₹{{ number_format($iPrice, 2) }}</td>
                                            <td class="text-center">{{ $iQty }}</td>
                                            <td class="text-end pe-3 fw-bold text-success">₹{{ number_format($iQty * $iPrice, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif

                    <div class="d-flex gap-2 mt-3">
                        <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => $oId]) }}" target="_blank" class="btn btn-primary w-50 fw-bold">
                            <i class="bi bi-receipt me-1"></i> View Tax Invoice
                        </a>
                        <a href="https://wa.me/{{ $cleanWaPhone }}?text={{ $waOrderText }}" target="_blank" class="btn btn-success w-50 fw-bold">
                            <i class="bi bi-whatsapp me-1"></i> WhatsApp Bill
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 2. EDIT ORDER & BILLING DETAILS MODAL (Exact Cab Structure, No Cutoff) -->
    <div class="modal fade" id="editOrderModal{{ $oId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content text-start shadow-lg">
                <form action="{{ route('admin.shop.order.update', $oId) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-warning text-dark">
                        <h5 class="modal-title fw-bold">
                            <i class="bi bi-pencil-square me-2"></i>Edit Order &amp; Billing ({{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }})
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="alert alert-light border border-warning shadow-xs mb-3 py-2 small d-flex align-items-center">
                            <i class="bi bi-info-circle-fill text-warning fs-5 me-2"></i>
                            <span>Yahan se aap Customer details, Degh Niyaz, Advance/Half Payment aur Status update kar sakte hain. Changes save hote hi Tax Invoice me bhi reflect ho jayenge.</span>
                        </div>

                        <div class="row g-3">
                            <!-- Section 1: Customer Details -->
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-2 border-bottom pb-1">
                                    <i class="bi bi-person-circle me-1"></i> Customer Information
                                </h6>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Customer Full Name *</label>
                                <input type="text" name="customer_name" class="form-control" value="{{ $custName }}" placeholder="e.g. Mohd Amir Khan" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Customer Mobile Number *</label>
                                <input type="text" name="customer_phone" class="form-control" value="{{ $custPhone }}" placeholder="10 Digits" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">WhatsApp / Alternate Mobile Number</label>
                                <input type="text" name="alternate_phone" class="form-control" value="{{ $custAltPhone }}" placeholder="Optional alternate number">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Address *</label>
                                <input type="text" name="shipping_address" class="form-control" value="{{ $address }}" placeholder="e.g. Astana Gate, Dewa Sharif, UP" required>
                            </div>

                            <!-- Section 2: Degh Niyaz & Offering Details -->
                            <div class="col-12 mt-3">
                                <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-2">
                                    <h6 class="fw-bold text-success mb-0">
                                        <i class="bi bi-star-fill text-warning me-1"></i> Degh Niyaz &amp; Sacred Offering Details
                                    </h6>
                                    <div class="form-check form-switch mb-0">
                                        <input class="form-check-input" type="checkbox" name="is_degh" value="1" id="is_degh_edit_{{ $oId }}" {{ $isDegh ? 'checked' : '' }}>
                                        <label class="form-check-label small fw-bold text-success" for="is_degh_edit_{{ $oId }}">Sacred Degh Order</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold small text-muted">Offering / Package Name (Items Summary) *</label>
                                <input type="text" name="items_summary" class="form-control fw-bold" value="{{ $itemsSummary }}" placeholder="e.g. Special Warsi Chicken Biryani Degh (10 Kg Chicken + 10 Kg Rice)" required>
                                <small class="text-muted d-block" style="font-size: 11px;">Yeh naam Customer ke Tax Invoice par print hoga.</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">🤲 Niyaz Ba-Naam (Fateha/Dua)</label>
                                <input type="text" name="fateha_name" class="form-control" value="{{ $fatehaName }}" placeholder="e.g. Sheikh Rashid Ali &amp; Family">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">📅 Scheduled Niyaz Date &amp; Time</label>
                                @php
                                    $pickerVal = '';
                                    if (!empty($niyazDate)) {
                                        try {
                                            $pickerVal = \Carbon\Carbon::parse($niyazDate)->format('Y-m-d\TH:i');
                                        } catch (\Throwable $e) {
                                            $pickerVal = \Carbon\Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i');
                                        }
                                    } else {
                                        $pickerVal = \Carbon\Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i');
                                    }
                                @endphp
                                <input type="datetime-local" name="niyaz_date" class="form-control fw-bold" value="{{ $pickerVal }}" required>
                                <small class="text-muted d-block" style="font-size: 11px;">Calendar icon se real time aur date choose karein.</small>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold small text-muted">🕌 Distribution Mode</label>
                                <select name="distribution_type" id="edit_dist_type_{{ $oId }}" class="form-select" onchange="onEditDistributionTypeChange('{{ $oId }}')">
                                    <option value="Direct Handover / Self Collection at Dewa Sharif" data-fee="0" {{ ($distributionType == 'Direct Handover / Self Collection at Dewa Sharif' || empty($distributionType)) ? 'selected' : '' }}>🟢 1. Direct Handover / Self Collection (₹0 Extra)</option>
                                    <option value="Packed Takeaway Handover (Devotee Self-Distribution)" data-fee="0" {{ ($distributionType == 'Packed Takeaway Handover (Devotee Self-Distribution)' || $distributionType == 'Parcel Packing / Takeaway to Customer') ? 'selected' : '' }}>📦 2. Packed Takeaway Handover (Devotee Distributes - ₹0)</option>
                                    <option value="Dargah Sharif Me Langar Taqseem (Managed Distribution Service)" data-fee="500" {{ ($distributionType == 'Dargah Sharif Me Langar Taqseem (Managed Distribution Service)' || $distributionType == 'Dargah Sharif Me Langar Taqseem (Distribute to Zaireen & Devotees)') ? 'selected' : '' }}>🕌 3. Dargah Sharif Langar Taqseem (Managed - +₹500 / Degh)</option>
                                    <option value="Dewa Sharif Hotel / Guest House Handover" data-fee="0" {{ $distributionType == 'Dewa Sharif Hotel / Guest House Handover' ? 'selected' : '' }}>🏨 Dewa Sharif Hotel / Guest House Handover (₹0)</option>
                                    <option value="Direct Home Courier Delivery" data-fee="0" {{ $distributionType == 'Direct Home Courier Delivery' ? 'selected' : '' }}>🚚 Direct Home Courier Delivery</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-muted">Distribution Fee (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">₹</span>
                                    <input type="number" step="0.01" min="0" name="distribution_fee" id="edit_dist_fee_{{ $oId }}" class="form-control fw-bold" value="{{ (float)$distFee }}">
                                </div>
                                <small class="text-muted d-block" style="font-size: 11px;">Dargah Taqseem par ₹500/degh. Khaas dost ke liye 0 bhi kar sakte hain.</small>
                            </div>
                            <div class="col-md-7">
                                <label class="form-label fw-bold small text-muted">📦 Packaging / Serving Option</label>
                                <select name="packaging_type" id="edit_pkg_type_{{ $oId }}" class="form-select" onchange="onEditPackagingTypeChange('{{ $oId }}')">
                                    <option value="none" data-fee="0" {{ empty($packagingType) || $packagingType == 'none' ? 'selected' : '' }}>🟢 Khula Langar (Direct Handover - ₹0)</option>
                                    <option value="complimentary" data-fee="0" {{ ($packagingType ?? '') == 'complimentary' ? 'selected' : '' }}>🎁 Complimentary / Free Packaging (- ₹0)</option>
                                    <option value="polythin" data-fee="300" {{ $packagingType == 'polythin' ? 'selected' : '' }}>🛍️ Polythin Pouches (+₹300 / Degh)</option>
                                    <option value="box" data-fee="600" {{ in_array($packagingType, ['box', 'dabba']) ? 'selected' : '' }}>🍱 Container Box / Dabba (+₹600 / Degh)</option>
                                    <option value="katori" data-fee="300" {{ $packagingType == 'katori' ? 'selected' : '' }}>🥣 Disposable Katori Bowls (+₹300 / Degh)</option>
                                    <option value="mitti_katori" data-fee="600" {{ $packagingType == 'mitti_katori' ? 'selected' : '' }}>🏺 Sacred Mitti Katori Bowls (+₹600 / Degh)</option>
                                    <option value="custom" data-fee="" {{ $packagingType == 'custom' ? 'selected' : '' }}>✏️ Custom Packaging Fee (Manual Entry)</option>
                                </select>
                            </div>
                            <div class="col-md-5">
                                <label class="form-label fw-bold small text-muted">Packaging Fee (₹)</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">₹</span>
                                    <input type="number" step="0.01" min="0" name="packaging_fee" id="edit_pkg_fee_{{ $oId }}" class="form-control fw-bold" value="{{ (float)$packagingFee }}">
                                </div>
                                <small class="text-muted d-block" style="font-size: 11px;">Agar ₹0 rahega to Invoice/PDF par parcel ka green badge hide rahega.</small>
                            </div>

                            <!-- Section 3: Financials & Partial Payment Split -->
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold text-success mb-2 border-bottom pb-1">
                                    <i class="bi bi-wallet2 me-1"></i> Payment &amp; Partial / Advance Split
                                </h6>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Total Billed Price (₹) *</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">₹</span>
                                    <input type="number" step="0.01" min="0" name="total_amount" id="edit_total_{{ $oId }}" class="form-control fw-bold text-success fs-6" value="{{ $totalAmount }}" oninput="calcOrderDue('{{ $oId }}')" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Advance Received / Paid (₹) *</label>
                                <div class="input-group">
                                    <span class="input-group-text fw-bold">₹</span>
                                    <input type="number" step="0.01" min="0" name="paid_amount" id="edit_paid_{{ $oId }}" class="form-control fw-bold text-primary fs-6" value="{{ $paidAmt }}" oninput="calcOrderDue('{{ $oId }}')" required>
                                </div>
                                <small class="text-muted d-block" style="font-size: 11px;">Half payment ya full advance amount likhein.</small>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Payment Status *</label>
                                <select name="payment_status" id="edit_pay_status_{{ $oId }}" class="form-select fw-bold {{ $isOrderPaid ? 'border-success text-success' : ($isOrderPartial ? 'border-warning text-dark' : ($isOrderFailed ? 'border-danger text-danger' : 'border-secondary')) }}">
                                    <option value="partial" {{ $isOrderPartial ? 'selected' : '' }}>🟡 PARTIAL (Advance Paid, Due Balance)</option>
                                    <option value="paid" {{ $isOrderPaid ? 'selected' : '' }}>✅ PAID (Mark as Full Paid &amp; Verified)</option>
                                    <option value="pending" {{ (!$isOrderPaid && !$isOrderPartial && !$isOrderFailed) ? 'selected' : '' }}>⏳ PENDING (Awaiting Payment)</option>
                                    <option value="failed" {{ $isOrderFailed ? 'selected' : '' }}>❌ FAILED / VOID (Payment Failed)</option>
                                </select>
                            </div>

                            <!-- Live Calculation Banner -->
                            <div class="col-12">
                                <div id="edit_due_box_{{ $oId }}" class="{{ $isOrderPaid ? 'alert alert-success' : ($isOrderPartial ? 'alert alert-warning' : 'alert alert-secondary') }} py-2 mb-0 small fw-bold">
                                    @if($isOrderPaid)
                                        <i class="bi bi-check-circle-fill me-1"></i> Fully Paid (₹{{ number_format($paidAmt, 2) }}) &bull; No Balance Due
                                    @elseif($isOrderPartial)
                                        <i class="bi bi-pie-chart-fill me-1"></i> Partial Advance Received: ₹{{ number_format($paidAmt, 2) }} &bull; <span class="text-danger">Remaining Balance Due: ₹{{ number_format($dueAmt, 2) }}</span>
                                    @else
                                        <i class="bi bi-hourglass-split me-1"></i> Advance: ₹{{ number_format($paidAmt, 2) }} &bull; Total Balance Due: ₹{{ number_format($dueAmt, 2) }}
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Payment Mode</label>
                                <select name="payment_mode" class="form-select">
                                    <option value="SBI UPI / PhonePe QR" {{ (str_contains($paymentMethod, 'UPI') || str_contains($paymentMethod, 'PhonePe')) ? 'selected' : '' }}>📱 SBI UPI / PhonePe QR Scan</option>
                                    <option value="Cash Advance (Naqd Dewa Office)" {{ str_contains(strtolower($paymentMethod), 'cash') ? 'selected' : '' }}>💵 Cash Advance (Naqd Dewa Office)</option>
                                    <option value="Razorpay Online" {{ str_contains($paymentMethod, 'Razorpay') ? 'selected' : '' }}>💳 Razorpay Online Gateway</option>
                                    <option value="Direct Bank Transfer (NEFT/IMPS)" {{ str_contains($paymentMethod, 'Bank') ? 'selected' : '' }}>🏦 Direct Bank Transfer (NEFT / IMPS)</option>
                                    <option value="Cash on Delivery (COD)" {{ $paymentMethod === 'COD' ? 'selected' : '' }}>📦 Cash on Delivery (COD)</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold small text-muted">Payment UTR / Transaction Note</label>
                                <input type="text" name="utr_number" class="form-control" value="{{ $oUtr }}" placeholder="e.g. 430192847192 or Naqd Recvd by Manager">
                            </div>

                            <!-- Section 4: Order Status & Dispatch Info -->
                            <div class="col-12 mt-3">
                                <h6 class="fw-bold text-dark mb-2 border-bottom pb-1">
                                    <i class="bi bi-truck me-1 text-primary"></i> Order Status &amp; Dispatch Details
                                </h6>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Order Status *</label>
                                <select name="order_status" class="form-select fw-semibold">
                                    <option value="processing" {{ $status === 'processing' ? 'selected' : '' }}>🟡 Processing</option>
                                    <option value="cooking / tayyari me hai" {{ $status === 'cooking / tayyari me hai' ? 'selected' : '' }}>🍳 Cooking / Tayyari Me Hai</option>
                                    <option value="dispatched" {{ $status === 'dispatched' ? 'selected' : '' }}>🔷 Dispatched</option>
                                    <option value="distributed at dargah sharif" {{ $status === 'distributed at dargah sharif' ? 'selected' : '' }}>🕌 Distributed at Dargah Sharif</option>
                                    <option value="out for delivery" {{ $status === 'out for delivery' ? 'selected' : '' }}>🚚 Out for Delivery</option>
                                    <option value="delivered" {{ $status === 'delivered' ? 'selected' : '' }}>🟢 Delivered</option>
                                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>🔴 Cancelled</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Courier / Handler Name</label>
                                <input type="text" name="courier_name" class="form-control" value="{{ $courier !== 'Not Dispatched' ? $courier : ($isDegh ? 'Dargah Sharif Langarkhana' : 'DTDC Express') }}" placeholder="Courier partner">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold small text-muted">Tracking AWB / Reference #</label>
                                <input type="text" name="tracking_number" class="form-control" value="{{ $tracking !== 'N/A' ? $tracking : '' }}" placeholder="AWB Tracking #">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light d-flex justify-content-between">
                        <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => $oId]) }}" target="_blank" class="btn btn-outline-primary fw-bold">
                            <i class="bi bi-printer me-1"></i> Preview / Print Tax Invoice
                        </a>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-success fw-bold px-4">
                                <i class="bi bi-check-circle-fill me-1"></i> Save Changes &amp; Update Bill
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 3. DISPATCH ORDER MODAL -->
    <div class="modal fade" id="dispatchModal{{ $oId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('admin.shop.dispatch', $oId) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold"><i class="bi bi-box-seam me-2"></i>Dispatch Order {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3 text-start">
                        <div class="col-12 bg-light p-3 rounded border border-primary">
                            <strong>Customer:</strong> {{ $custName }} ({{ $custPhone }})<br>
                            <small class="text-muted"><strong>Address:</strong> {{ $address }}</small>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Select Courier / Delivery Method*</label>
                            <select name="courier_name" class="form-select fw-semibold" required>
                                <option value="Dargah Sharif Langarkhana (Zaireen Distribution)" {{ $courier === 'Dargah Sharif Langarkhana (Zaireen Distribution)' ? 'selected' : '' }}>🕌 Dargah Sharif Langarkhana (Zaireen Distribution)</option>
                                <option value="Dewa Sharif Hotel/Guest House Handover" {{ $courier === 'Dewa Sharif Hotel/Guest House Handover' ? 'selected' : '' }}>🏨 Dewa Sharif Hotel/Guest House Handover</option>
                                <option value="DTDC Express" {{ $courier === 'DTDC Express' ? 'selected' : '' }}>🚚 DTDC Express</option>
                                <option value="Shadowfax Logistics" {{ $courier === 'Shadowfax Logistics' ? 'selected' : '' }}>📦 Shadowfax Logistics</option>
                                <option value="Blue Dart" {{ $courier === 'Blue Dart' ? 'selected' : '' }}>✈️ Blue Dart Express</option>
                                <option value="Delhivery Courier" {{ $courier === 'Delhivery Courier' ? 'selected' : '' }}>🚚 Delhivery</option>
                                <option value="India Post (Speed Post)" {{ $courier === 'India Post (Speed Post)' ? 'selected' : '' }}>📮 India Post (Speed Post)</option>
                                <option value="Self Delivery / Local Hand Delivery (Dewa Sharif)" {{ $courier === 'Self Delivery / Local Hand Delivery (Dewa Sharif)' ? 'selected' : '' }}>🚶‍♂️ Self Delivery / Local Hand Delivery</option>
                                <option value="Store Rider (Same-Day)" {{ $courier === 'Store Rider (Same-Day)' ? 'selected' : '' }}>🏍️ Store Rider (Same-Day Urgent Delivery)</option>
                                <option value="Other Courier Partner" {{ $courier === 'Other Courier Partner' ? 'selected' : '' }}>📦 Other Courier / Delivery Partner</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Tracking AWB # / Delivery Note*</label>
                            <input type="text" name="tracking_number" class="form-control" value="{{ $tracking !== 'N/A' ? $tracking : 'DT'.rand(10000000, 99999999).'IN' }}" placeholder="e.g. DT12345678IN or Hand Delivered" required>
                            <small class="text-muted">Enter Courier Waybill tracking number OR delivery notes for self-delivery.</small>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Order Status Update</label>
                            <select name="status" class="form-select fw-semibold">
                                <option value="Dispatched" selected>Dispatched (In-Transit)</option>
                                <option value="Distributed at Dargah Sharif">Distributed at Dargah Sharif</option>
                                <option value="Out for Delivery">Out for Delivery</option>
                                <option value="Delivered">Delivered &amp; Handed Over</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold">Dispatch Notes / Remarks (Optional)</label>
                            <textarea name="dispatch_notes" class="form-control" rows="2" placeholder="e.g. Package packed securely in Dewa Sharif Store."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-check-circle me-1"></i> Save &amp; Dispatch Order</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- 4. QUICK STATUS MODAL -->
    <div class="modal fade" id="statusModal{{ $oId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content border-0 shadow-lg">
                <form action="{{ route('admin.shop.order.status', $oId) }}" method="POST">
                    @csrf
                    <div class="modal-header bg-secondary text-white py-2">
                        <h6 class="modal-title fw-bold mb-0"><i class="bi bi-sliders me-1"></i>Update Order Status</h6>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-start py-3">
                        <label class="form-label fw-bold small text-muted">Status for {{ $isDegh ? '#DGH-' : '#ORD-' }}{{ $oId }}</label>
                        <select name="status" class="form-select fw-semibold">
                            <option value="Processing" {{ $status === 'processing' ? 'selected' : '' }}>🟡 Processing</option>
                            <option value="Cooking / Tayyari Me Hai" {{ $status === 'cooking / tayyari me hai' ? 'selected' : '' }}>🍳 Cooking / Tayyari Me Hai</option>
                            <option value="Dispatched" {{ $status === 'dispatched' ? 'selected' : '' }}>🔷 Dispatched</option>
                            <option value="Distributed at Dargah Sharif" {{ $status === 'distributed at dargah sharif' ? 'selected' : '' }}>🕌 Distributed at Dargah Sharif</option>
                            <option value="Out for Delivery" {{ $status === 'out for delivery' ? 'selected' : '' }}>🚚 Out for Delivery</option>
                            <option value="Delivered" {{ $status === 'delivered' ? 'selected' : '' }}>🟢 Delivered</option>
                            <option value="Cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>🔴 Cancelled</option>
                        </select>
                    </div>
                    <div class="modal-footer py-2">
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-sm btn-primary fw-bold">Update Status</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<!-- 5. BOOK CUSTOM DEGH NIYAZ / STORE ORDER MODAL -->
<div class="modal fade" id="createCustomOrderModal" tabindex="-1" aria-labelledby="createCustomOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content text-start shadow-lg">
            <form action="{{ route('admin.shop.order.custom') }}" method="POST">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title fw-bold" id="createCustomOrderModalLabel">
                        <i class="bi bi-plus-circle-fill me-2"></i>Book Custom Degh Niyaz / Store Order (Admin Direct)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-light border border-success shadow-xs mb-3 py-2 small d-flex align-items-center">
                        <i class="bi bi-info-circle-fill text-success fs-5 me-2"></i>
                        <span>Admin direct booking portal: Yahan se aap custom Biryani / Degh / Chadar book kar sakte hain aur Half payment (Advance) ya Full payment bill generate karke customer ko print ya WhatsApp de sakte hain.</span>
                    </div>

                    <!-- Fast Preset Selector -->
                    <div class="mb-3 p-3 bg-light rounded border">
                        <label class="form-label small fw-bold text-dark">
                            <i class="bi bi-magic text-primary me-1"></i> Quick Select Offering / Package (Auto-Fills Name &amp; Price):
                        </label>
                        <select class="form-select fw-semibold" onchange="applyCustomProduct(this)">
                            <option value="">-- Choose Degh / Product OR Fill Details Manually Below --</option>
                            @if(isset($availableProducts) && count($availableProducts) > 0)
                                @foreach($availableProducts as $prod)
                                    @php
                                        $pName = is_array($prod) ? ($prod['name'] ?? '') : ($prod->name ?? '');
                                        $pPrice = (float)(is_array($prod) ? ($prod['price'] ?? 0) : ($prod->price ?? 0));
                                        $pIsDegh = str_contains(strtolower($pName), 'degh') || str_contains(strtolower($pName), 'biryani') || str_contains(strtolower($pName), 'zarda') || str_contains(strtolower($pName), 'kheer') ? '1' : '0';
                                    @endphp
                                    <option value="{{ is_array($prod) ? ($prod['id'] ?? 1) : $prod->id }}" data-name="{{ $pName }}" data-price="{{ $pPrice }}" data-is-degh="{{ $pIsDegh }}">
                                        {{ $pIsDegh === '1' ? '🍲 DEGH: ' : '🛍️ ITEM: ' }}{{ $pName }} — ₹{{ number_format($pPrice) }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="row g-3">
                        <!-- Customer Details -->
                        <div class="col-12">
                            <h6 class="fw-bold text-primary mb-2 border-bottom pb-1">
                                <i class="bi bi-person-circle me-1"></i> Customer Information
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Customer Full Name *</label>
                            <input type="text" name="customer_name" class="form-control" placeholder="e.g. Haji Mohd. Zameer" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Customer Mobile Number *</label>
                            <input type="text" name="customer_phone" class="form-control" placeholder="e.g. 9648777223" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">WhatsApp / Alternate Mobile Number</label>
                            <input type="text" name="alternate_phone" class="form-control" placeholder="Optional alternate number">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Delivery / Shipping Address *</label>
                            <input type="text" name="shipping_address" class="form-control" value="Dargah Dewa Sharif / Dewa Sharif UP" required>
                        </div>

                        <!-- Degh Niyaz Details -->
                        <div class="col-12 mt-3">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-1 mb-2">
                                <h6 class="fw-bold text-success mb-0">
                                    <i class="bi bi-star-fill text-warning me-1"></i> Degh Niyaz &amp; Sacred Offering Details
                                </h6>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" name="is_degh" value="1" id="custom_is_degh" checked>
                                    <label class="form-check-label small fw-bold text-success" for="custom_is_degh">Sacred Degh Order</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Degh Offering / Item Name *</label>
                            <input type="text" name="items_summary" id="custom_items_summary" class="form-control fw-bold" placeholder="e.g. Warsi Chicken Biryani Degh (10 Kg Chicken + 10 Kg Rice)" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">🤲 Niyaz Ba-Naam (Fateha/Dua)</label>
                            <input type="text" name="fateha_name" class="form-control" placeholder="e.g. Haji Mohd. Zameer &amp; Marhoomeen">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">📅 Scheduled Date &amp; Time</label>
                            <input type="datetime-local" name="niyaz_date" class="form-control fw-bold" value="{{ \Carbon\Carbon::now('Asia/Kolkata')->format('Y-m-d\TH:i') }}" required>
                            <small class="text-muted d-block" style="font-size: 11px;">Calendar icon se real time aur date choose karein.</small>
                        </div>
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-muted">🕌 Distribution Mode</label>
                            <select name="distribution_type" id="custom_distribution_type" class="form-select" onchange="onCustomDistributionTypeChange()">
                                <option value="Direct Handover / Self Collection at Dewa Sharif" data-fee="0" selected>🟢 1. Direct Handover / Self Collection (₹0 Extra)</option>
                                <option value="Packed Takeaway Handover (Devotee Self-Distribution)" data-fee="0">📦 2. Packed Takeaway Handover (Devotee Distributes - ₹0)</option>
                                <option value="Dargah Sharif Me Langar Taqseem (Managed Distribution Service)" data-fee="500">🕌 3. Dargah Sharif Langar Taqseem (Managed - +₹500 / Degh)</option>
                                <option value="Dewa Sharif Hotel / Guest House Handover" data-fee="0">🏨 Dewa Sharif Hotel Handover</option>
                                <option value="Direct Home Courier Delivery" data-fee="0">🚚 Direct Courier Delivery</option>
                            </select>
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-muted">Distribution Fee (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" step="0.01" min="0" name="distribution_fee" id="custom_distribution_fee" class="form-control fw-bold" value="0.00">
                            </div>
                            <small class="text-muted d-block" style="font-size: 11px;">Dargah Taqseem par ₹500/degh. Khaas dost ke liye 0 bhi kar sakte hain.</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">📦 Packaging / Serving Option</label>
                            <select name="packaging_type" id="custom_packaging_type" class="form-select" onchange="onCustomPackagingChange()">
                                <option value="none" data-fee="0" selected>🟢 Khula Langar (Direct Taqseem - ₹0)</option>
                                <option value="complimentary" data-fee="0">🎁 Complimentary / Free Packaging (Khas Dost - ₹0)</option>
                                <option value="polythin" data-fee="300">🛍️ Polythin Pouches (+₹300 / Degh)</option>
                                <option value="box" data-fee="600">🍱 Container Box / Dabba (+₹600 / Degh)</option>
                                <option value="katori" data-fee="300">🥣 Disposable Katori Bowls (+₹300 / Degh)</option>
                                <option value="mitti_katori" data-fee="600">🏺 Sacred Mitti Katori Bowls (+₹600 / Degh)</option>
                                <option value="custom" data-fee="">✏️ Custom Packaging Fee (Manual Entry)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Packaging Fee (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" step="0.01" min="0" name="packaging_fee" id="custom_packaging_fee" class="form-control fw-bold" value="0.00">
                            </div>
                            <small class="text-muted d-block" style="font-size: 11px;">Agar ₹0 rahega to Invoice/PDF par parcel ka green badge hide rahega.</small>
                        </div>

                        <!-- Financials / Advance Partial Payment -->
                        <div class="col-12 mt-3">
                            <h6 class="fw-bold text-success mb-2 border-bottom pb-1">
                                <i class="bi bi-wallet2 me-1"></i> Payment &amp; Advance Split
                            </h6>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Total Price (₹) *</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" step="0.01" min="0" name="total_amount" id="custom_total_amount" class="form-control fw-bold text-success fs-6" placeholder="e.g. 5500" oninput="calcCustomNewDue()" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Advance / Paid Amount (₹) *</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" step="0.01" min="0" name="paid_amount" id="custom_paid_amount" class="form-control fw-bold text-primary fs-6" placeholder="e.g. 2500" oninput="calcCustomNewDue()" required>
                            </div>
                            <small class="text-muted d-block" style="font-size: 11px;">Half payment ya full advance amount likhein.</small>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Payment Status *</label>
                            <select name="payment_status" id="custom_payment_status" class="form-select fw-bold">
                                <option value="partial" selected>🟡 Partial / Advance Paid</option>
                                <option value="paid">🟢 Full Paid</option>
                                <option value="pending">🟠 Pending Payment</option>
                            </select>
                        </div>

                        <!-- Dynamic Balance Due Display -->
                        <div class="col-12">
                            <div id="custom_due_box" class="alert alert-warning py-2 mb-0 small fw-bold">
                                <i class="bi bi-calculator me-1"></i> Enter Total Price &amp; Advance to calculate remaining balance due.
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Payment Mode</label>
                            <select name="payment_mode" class="form-select">
                                <option value="SBI UPI / PhonePe QR" selected>📱 SBI UPI / PhonePe QR Scan</option>
                                <option value="Cash Advance (Naqd Dargah/Office)">💵 Cash Advance (Naqd Dewa Office)</option>
                                <option value="Direct Bank Transfer (NEFT/IMPS)">🏦 Direct Bank Transfer (NEFT / IMPS)</option>
                                <option value="Razorpay Online">💳 Razorpay Online Gateway</option>
                                <option value="Cash on Delivery (COD)">📦 Cash on Delivery (COD)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Payment UTR / Reference Note</label>
                            <input type="text" name="utr_number" class="form-control" placeholder="e.g. 430192847192 or Naqd Advance">
                        </div>

                        <!-- Status & Courier -->
                        <div class="col-12 mt-3">
                            <h6 class="fw-bold text-dark mb-2 border-bottom pb-1">
                                <i class="bi bi-truck me-1 text-primary"></i> Workflow &amp; Delivery Option
                            </h6>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Initial Order Status</label>
                            <select name="order_status" class="form-select fw-semibold">
                                <option value="processing" selected>🟡 Processing</option>
                                <option value="cooking / tayyari me hai">🍳 Cooking / Tayyari Me Hai</option>
                                <option value="dispatched">🔷 Dispatched</option>
                                <option value="delivered">🟢 Delivered</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Courier / Handler Option</label>
                            <input type="text" name="courier_name" class="form-control" value="Dargah Sharif Langarkhana (Zaireen Distribution)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success fw-bold px-4">
                        <i class="bi bi-check-circle-fill me-1"></i> Save Custom Booking &amp; Generate Bill
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function calcOrderDue(orderId) {
    const totalEl = document.getElementById('edit_total_' + orderId);
    const paidEl = document.getElementById('edit_paid_' + orderId);
    const dueBox = document.getElementById('edit_due_box_' + orderId);
    const statusSelect = document.getElementById('edit_pay_status_' + orderId);
    
    if (!totalEl || !paidEl || !dueBox) return;
    
    const total = parseFloat(totalEl.value) || 0;
    const paid = parseFloat(paidEl.value) || 0;
    const due = Math.max(0, total - paid);
    
    if (paid >= total && total > 0) {
        dueBox.className = 'alert alert-success py-2 mb-0 small fw-bold';
        dueBox.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Full Amount Entered (₹' + paid.toLocaleString('en-IN') + ') &bull; No Balance Due';
        if (statusSelect && statusSelect.value !== 'failed') {
            statusSelect.value = 'paid';
        }
    } else if (paid > 0 && paid < total) {
        dueBox.className = 'alert alert-warning py-2 mb-0 small fw-bold';
        dueBox.innerHTML = '<i class="bi bi-pie-chart-fill me-1"></i> Advance Entered: ₹' + paid.toLocaleString('en-IN') + ' &bull; <span class="text-danger">Remaining Balance Due: ₹' + due.toLocaleString('en-IN') + '</span>';
        if (statusSelect && statusSelect.value !== 'failed') {
            statusSelect.value = 'partial';
        }
    } else {
        dueBox.className = 'alert alert-secondary py-2 mb-0 small fw-bold';
        dueBox.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Advance: ₹' + paid.toLocaleString('en-IN') + ' &bull; Total Balance Due: ₹' + total.toLocaleString('en-IN');
        if (statusSelect && statusSelect.value !== 'failed') {
            statusSelect.value = 'pending';
        }
    }
}

function calcCustomNewDue() {
    const totalEl = document.getElementById('custom_total_amount');
    const paidEl = document.getElementById('custom_paid_amount');
    const dueBox = document.getElementById('custom_due_box');
    
    if (!totalEl || !paidEl || !dueBox) return;
    
    const total = parseFloat(totalEl.value) || 0;
    const paid = parseFloat(paidEl.value) || 0;
    const due = Math.max(0, total - paid);
    
    if (paid >= total && total > 0) {
        dueBox.className = 'alert alert-success py-2 mb-0 small fw-bold';
        dueBox.innerHTML = '<i class="bi bi-check-circle-fill me-1"></i> Full Amount Entered (₹' + paid.toLocaleString('en-IN') + ') &bull; No Balance Due';
    } else if (paid > 0 && paid < total) {
        dueBox.className = 'alert alert-warning py-2 mb-0 small fw-bold';
        dueBox.innerHTML = '<i class="bi bi-pie-chart-fill me-1"></i> Advance Entered: ₹' + paid.toLocaleString('en-IN') + ' &bull; <span class="text-danger">Remaining Balance Due: ₹' + due.toLocaleString('en-IN') + '</span>';
    } else {
        dueBox.className = 'alert alert-secondary py-2 mb-0 small fw-bold';
        dueBox.innerHTML = '<i class="bi bi-hourglass-split me-1"></i> Advance: ₹' + paid.toLocaleString('en-IN') + ' &bull; Total Balance Due: ₹' + total.toLocaleString('en-IN');
    }
}

function applyCustomProduct(select) {
    const opt = select.options[select.selectedIndex];
    if (!opt || !opt.value) return;
    
    const name = opt.getAttribute('data-name');
    const price = opt.getAttribute('data-price');
    const isDegh = opt.getAttribute('data-is-degh');
    
    if (name) {
        document.getElementById('custom_items_summary').value = name;
    }
    if (price) {
        document.getElementById('custom_total_amount').value = price;
        // Default half payment as advance for convenience
        const half = Math.round(parseFloat(price) / 2);
        document.getElementById('custom_paid_amount').value = half;
    }
    const deghCheck = document.getElementById('custom_is_degh');
    if (deghCheck) {
        deghCheck.checked = (isDegh === '1');
    }
    
    calcCustomNewDue();
}

function onEditPackagingTypeChange(orderId) {
    const pkgSelect = document.getElementById('edit_pkg_type_' + orderId);
    const pkgFeeInput = document.getElementById('edit_pkg_fee_' + orderId);
    if (!pkgSelect || !pkgFeeInput) return;
    
    const opt = pkgSelect.options[pkgSelect.selectedIndex];
    const feeAttr = opt.getAttribute('data-fee');
    if (feeAttr !== null && feeAttr !== '') {
        pkgFeeInput.value = (parseFloat(feeAttr) || 0).toFixed(2);
    }
}

function onCustomPackagingChange() {
    const pkgSelect = document.getElementById('custom_packaging_type');
    const pkgFeeInput = document.getElementById('custom_packaging_fee');
    if (!pkgSelect || !pkgFeeInput) return;
    
    const opt = pkgSelect.options[pkgSelect.selectedIndex];
    const feeAttr = opt.getAttribute('data-fee');
    if (feeAttr !== null && feeAttr !== '') {
        pkgFeeInput.value = (parseFloat(feeAttr) || 0).toFixed(2);
    }
}

function onEditDistributionTypeChange(orderId) {
    const distSelect = document.getElementById('edit_dist_type_' + orderId);
    const distFeeInput = document.getElementById('edit_dist_fee_' + orderId);
    if (!distSelect || !distFeeInput) return;
    
    const opt = distSelect.options[distSelect.selectedIndex];
    const feeAttr = opt.getAttribute('data-fee');
    if (feeAttr !== null && feeAttr !== '') {
        distFeeInput.value = (parseFloat(feeAttr) || 0).toFixed(2);
    }
}

function onCustomDistributionTypeChange() {
    const distSelect = document.getElementById('custom_distribution_type');
    const distFeeInput = document.getElementById('custom_distribution_fee');
    if (!distSelect || !distFeeInput) return;
    
    const opt = distSelect.options[distSelect.selectedIndex];
    const feeAttr = opt.getAttribute('data-fee');
    if (feeAttr !== null && feeAttr !== '') {
        distFeeInput.value = (parseFloat(feeAttr) || 0).toFixed(2);
    }
}
</script>
@endsection
