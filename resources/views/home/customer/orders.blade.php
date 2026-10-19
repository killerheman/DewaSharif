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
                            <h4 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 22px;">🛍️ My Sacred Store Orders</h4>
                            <small class="text-muted">Authentic Chadar, Attar &amp; Tabarruk deliveries</small>
                        </div>
                        <a href="{{ route('shops') }}" class="btn btn-sm btn-primary font-weight-bold px-3" style="border-radius: 8px;">+ Visit Sacred Store</a>
                    </div>

                    @forelse($shopOrders as $order)
                        <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 16px;">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-3 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                                <div>
                                    <span style="font-size: 11px; font-weight: 800; color: #86198f; background: #fae8ff; padding: 3px 10px; border-radius: 6px;">
                                        📦 {{ strtoupper($order['status'] ?? 'DISPATCHED') }}
                                    </span>
                                    <h4 style="font-weight: 900; color: #0f172a; margin-top: 8px; margin-bottom: 4px; font-size: 19px;">
                                        {{ $order['items_summary'] ?? 'Pure Rooh-e-Waris Attar & Shahi Velvet Chadar' }}
                                    </h4>
                                    <p style="font-size: 13px; color: #64748b; margin: 0;">
                                        Order ID: <strong>#{{ $order['order_code'] ?? ($order['order_id'] ?? 'DWS-ORD-2026-0001') }}</strong> | Tracking: <strong>{{ $order['tracking'] ?? ($order['tracking_no'] ?? 'DT123456789IN') }}</strong>
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span style="font-size: 22px; font-weight: 900; color: #052c16; display: block;">₹{{ number_format($order['total_amount'] ?? ($order['amount'] ?? 1497)) }}</span>
                                    <span style="font-size: 11px; color: #16a34a; font-weight: 700; background: #dcfce7; padding: 2px 8px; border-radius: 4px;">Paid Online</span>
                                </div>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <p style="font-size: 13.5px; color: #334155; margin-bottom: 6px;">
                                        📍 <strong>Delivery Address:</strong> {{ $order['address'] ?? 'Dewa Sharif, Barabanki' }}
                                    </p>
                                    <p style="font-size: 13.5px; color: #334155; margin-bottom: 0;">
                                        🚚 <strong>Courier Status:</strong> Dispatched via {{ $order['courier'] ?? 'DTDC Express' }}. Delivery expected in 2-3 business days.
                                    </p>
                                </div>
                                <div class="col-md-4 text-md-right mt-3 mt-md-0">
                                    <a href="{{ route('customer.invoice', ['type' => 'shop', 'id' => $order['id'] ?? 1]) }}" target="_blank" class="btn" style="background: #86198f; color: #ffffff; font-weight: 800; font-size: 13px; border-radius: 8px; padding: 9px 16px;">
                                        📥 Receipt PDF
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fa fa-shopping-bag text-muted mb-2" style="font-size: 40px;"></i>
                            <h5>No Sacred Store Orders Found</h5>
                            <a href="{{ route('shops') }}" class="btn btn-primary font-weight-bold mt-2">Browse Sacred Shop</a>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
