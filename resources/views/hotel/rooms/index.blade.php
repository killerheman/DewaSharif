@extends('hotel.includes.master')

@section('title', 'Manage Hotel Rooms')

@section('content')
<div class="row align-items-center mb-4 g-3">
    <div class="col-md-6">
        <h3 class="fw-bold text-dark mb-1">
            🛏️ Rooms &amp; Inventory Management
        </h3>
        <p class="text-muted mb-0" style="font-size: 13.5px;">
            Set rates, room photos (up to 6 slots), availability, and amenities for {{ $partner->hotel_name }}.
        </p>
    </div>
    <div class="col-md-6 text-md-end">
        <a href="{{ route('hotel.rooms.create') }}" class="btn btn-success fw-bold shadow-sm">
            <i class="bi bi-plus-circle me-1"></i> Add New Room Listing
        </a>
    </div>
</div>

<div class="row g-4">
    @forelse($rooms as $room)
        @php
            $rId = is_array($room) ? ($room['id'] ?? 1) : $room->id;
            $rType = is_array($room) ? ($room['room_type'] ?? ($room['category_name'] ?? 'Deluxe AC Room')) : ($room->room_type ?? 'Deluxe AC Room');
            $rPrice = (float)(is_array($room) ? ($room['price_per_night'] ?? ($room['price'] ?? 1499)) : ($room->price_per_night ?? ($room->price ?? 1499)));
            $rMrp = (float)(is_array($room) ? ($room['mrp'] ?? round($rPrice * 1.35)) : ($room->mrp ?? round($rPrice * 1.35)));
            $rAvail = (int)(is_array($room) ? ($room['available_rooms'] ?? 5) : ($room->available_rooms ?? 5));
            $rAc = is_array($room) ? ($room['ac_type'] ?? 'AC') : ($room->ac_type ?? 'AC');
            $rBed = is_array($room) ? ($room['bed_type'] ?? 'Double Bed') : ($room->bed_type ?? 'Double Bed');
            $rAdults = is_array($room) ? ($room['max_adults'] ?? 2) : ($room->max_adults ?? 2);
            $rBath = is_array($room) ? ($room['bath_type'] ?? 'Attached Western Bath') : ($room->bath_type ?? 'Attached Western Bath');
            $rStatus = strtolower(is_array($room) ? ($room['status'] ?? 'active') : ($room->status ?? 'active'));
            $isActive = ($rStatus === 'active');

            // Images
            $img1 = is_array($room) ? ($room['image'] ?? ($room['image_main'] ?? null)) : ($room->image ?? ($room->image_main ?? null));
            $img2 = is_array($room) ? ($room['image_reception'] ?? null) : ($room->image_reception ?? null);
            $img3 = is_array($room) ? ($room['image_room'] ?? null) : ($room->image_room ?? null);
            $img4 = is_array($room) ? ($room['image_bathroom'] ?? null) : ($room->image_bathroom ?? null);
            $img5 = is_array($room) ? ($room['image_extra'] ?? null) : ($room->image_extra ?? null);
            $img6 = is_array($room) ? ($room['image_6'] ?? null) : ($room->image_6 ?? null);

            $imgSrc = $img1 ? asset($img1) : asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg');
            $discountPct = ($rMrp > $rPrice) ? round((($rMrp - $rPrice) / $rMrp) * 100) : 0;
            $partnerNet = round($rPrice * 0.80, 2);
        @endphp
        <div class="col-lg-6 col-xl-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 16px;">
                <div class="position-relative">
                    <img src="{{ $imgSrc }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/guesthouse.jpg') }}'" class="card-img-top" style="height: 200px; object-fit: cover;">
                    <div class="position-absolute top-0 start-0 m-3 d-flex gap-1 flex-wrap">
                        <span class="badge {{ $isActive ? 'bg-success' : 'bg-secondary' }} shadow-sm">
                            {{ $isActive ? '● ACTIVE' : '⏸ PAUSED' }}
                        </span>
                        <span class="badge bg-dark shadow-sm">{{ $rAc }}</span>
                    </div>
                    @if($discountPct > 0)
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-danger shadow-sm">{{ $discountPct }}% OFF</span>
                        </div>
                    @endif
                    <div class="position-absolute bottom-0 start-0 end-0 p-2 text-white d-flex justify-content-between align-items-center" style="background: linear-gradient(0deg, rgba(0,0,0,0.8) 0%, transparent 100%);">
                        <small class="fw-semibold"><i class="bi bi-people-fill me-1"></i>Max {{ $rAdults }} Adults</small>
                        <small class="fw-semibold"><i class="bi bi-door-open-fill me-1"></i>{{ $rAvail }} Rooms Left</small>
                    </div>
                </div>

                <div class="card-body p-3 d-flex flex-column justify-content-between">
                    <div>
                        <h5 class="fw-bold text-dark mb-1">{{ $rType }}</h5>
                        <p class="text-muted mb-2" style="font-size: 12.5px;">
                            <i class="bi bi-card-checklist text-primary me-1"></i>{{ $rBed }} • {{ $rBath }}
                        </p>

                        <!-- Photo mini strip -->
                        <div class="d-flex gap-1 mb-3">
                            @foreach([$img1, $img2, $img3, $img4, $img5, $img6] as $idx => $extraImg)
                                @if(!empty($extraImg))
                                    <img src="{{ asset($extraImg) }}" onerror="this.style.display='none'" class="rounded border" style="width: 38px; height: 32px; object-fit: cover;" title="Photo Slot {{ $idx + 1 }}">
                                @endif
                            @endforeach
                        </div>

                        <!-- Price Breakdown -->
                        <div class="p-2 rounded-3 mb-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="d-flex justify-content-between align-items-baseline">
                                <div>
                                    <span class="fs-4 fw-bold text-dark">₹{{ number_format($rPrice, 2) }}</span>
                                    @if($rMrp > $rPrice)
                                        <small class="text-muted text-decoration-line-through ms-1">₹{{ number_format($rMrp) }}</small>
                                    @endif
                                    <small class="text-muted d-block" style="font-size: 11px;">Guest Selling Price / Night</small>
                                </div>
                                <div class="text-end">
                                    <span class="fw-bold text-success fs-5">₹{{ number_format($partnerNet, 2) }}</span>
                                    <small class="text-muted d-block" style="font-size: 11px;">Your 80% Payout</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center pt-2 border-top gap-2">
                        <form action="{{ route('hotel.rooms.toggle', $rId) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="btn btn-sm {{ $isActive ? 'btn-outline-secondary' : 'btn-outline-success' }} fw-bold" style="border-radius: 8px;">
                                <i class="bi {{ $isActive ? 'bi-pause-fill' : 'bi-play-fill' }} me-1"></i>
                                {{ $isActive ? 'Pause Room' : 'Activate' }}
                            </button>
                        </form>
                        <a href="{{ route('hotel.rooms.edit', $rId) }}" class="btn btn-sm btn-primary fw-bold" style="border-radius: 8px;">
                            <i class="bi bi-pencil-square me-1"></i> Edit Room
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <div class="p-5 bg-white rounded-4 shadow-sm">
                <i class="bi bi-door-closed text-muted fs-1 d-block mb-3"></i>
                <h5 class="fw-bold text-dark">No Rooms Listed Yet</h5>
                <p class="text-muted mb-3" style="font-size: 14px;">Add your guest house rooms, pricing, and 6 photos to start receiving online devotee bookings.</p>
                <a href="{{ route('hotel.rooms.create') }}" class="btn btn-success fw-bold px-4">
                    <i class="bi bi-plus-circle me-1"></i> List First Room
                </a>
            </div>
        </div>
    @endforelse
</div>
@endsection
