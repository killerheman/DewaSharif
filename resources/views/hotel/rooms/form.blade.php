@extends('hotel.includes.master')

@section('title', ($isEdit ? 'Edit Room Listing' : 'List New Room') . ' - DewaSharif')

@section('content')
@php
    $rId = $room ? (is_array($room) ? ($room['id'] ?? 1) : $room->id) : null;
    $rType = $room ? (is_array($room) ? ($room['room_type'] ?? ($room['category_name'] ?? 'Deluxe AC Room')) : ($room->room_type ?? 'Deluxe AC Room')) : old('room_type', 'Queen Size AC');
    $rPrice = $room ? (float)(is_array($room) ? ($room['price_per_night'] ?? ($room['price'] ?? 1499)) : ($room->price_per_night ?? 1499)) : (float)old('price_per_night', 1499);
    $rMrp = $room ? (float)(is_array($room) ? ($room['mrp'] ?? 1999) : ($room->mrp ?? 1999)) : (float)old('mrp', 1999);
    $rRooms = $room ? (int)(is_array($room) ? ($room['available_rooms'] ?? 5) : ($room->available_rooms ?? 5)) : (int)old('available_rooms', 5);
    $rAc = $room ? (is_array($room) ? ($room['ac_type'] ?? 'AC') : ($room->ac_type ?? 'AC')) : old('ac_type', 'AC');
    $rBed = $room ? (is_array($room) ? ($room['bed_type'] ?? 'Double Bed') : ($room->bed_type ?? 'Double Bed')) : old('bed_type', 'Double Bed');
    $rAdults = $room ? (int)(is_array($room) ? ($room['max_adults'] ?? 2) : ($room->max_adults ?? 2)) : (int)old('max_adults', 2);
    $rChildren = $room ? (int)(is_array($room) ? ($room['max_children'] ?? 1) : ($room->max_children ?? 1)) : (int)old('max_children', 1);
    $rBath = $room ? (is_array($room) ? ($room['bath_type'] ?? 'Attached Western Bath') : ($room->bath_type ?? 'Attached Western Bath')) : old('bath_type', 'Attached Western Bath');
    $rLocation = $room ? (is_array($room) ? ($room['location'] ?? ($room['distance'] ?? 'Near Dewa Sharif Dargah Gate')) : ($room->location ?? 'Near Dewa Sharif Dargah Gate')) : old('location', 'Near Dewa Sharif Dargah Gate');
    $rStatus = $room ? (is_array($room) ? ($room['status'] ?? 'active') : ($room->status ?? 'active')) : old('status', 'active');

    $rAmenities = $room ? (is_array($room) ? ($room['amenities'] ?? []) : ($room->amenities ?? [])) : ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Near Dargah Gate'];
    if (is_string($rAmenities)) { $rAmenities = explode(',', $rAmenities); }
    $rAmenities = array_map('trim', (array)$rAmenities);

    $allPresetAmenities = [
        '24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Near Dargah Gate',
        'Air Conditioner', 'CCTV Security', 'Room Service / Tea', 'RO Drinking Water',
        'Clean Fresh Linens', 'Western Toilet', 'Television (TV)', 'Elevator / Lift'
    ];
@endphp

<div class="row justify-content-center">
    <div class="col-xl-10">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <a href="{{ route('hotel.rooms') }}" class="btn btn-sm btn-outline-secondary mb-2">
                    <i class="bi bi-arrow-left me-1"></i> Back to Rooms Catalogue
                </a>
                <h3 class="fw-bold text-dark mb-0">
                    {{ $isEdit ? '✏️ Edit Room: ' . $rType : '➕ Add New Room Master Listing' }}
                </h3>
                <small class="text-muted">Property: <strong>{{ $partner->hotel_name }}</strong></small>
            </div>
            @if($isEdit)
                <span class="badge {{ $rStatus === 'active' ? 'bg-success' : 'bg-secondary' }} fs-6 px-3 py-2">
                    {{ strtoupper($rStatus) }}
                </span>
            @endif
        </div>

        @if($errors->any())
            <div class="alert alert-danger shadow-sm border-0 mb-4" style="border-radius: 12px;">
                <h6 class="fw-bold mb-1"><i class="bi bi-exclamation-octagon me-1"></i> Please fix the following errors:</h6>
                <ul class="mb-0 ps-3" style="font-size: 13.5px;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $isEdit ? route('hotel.rooms.update', $rId) : route('hotel.rooms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- 1. PHOTO UPLOADS (6 SLOTS: 1 REQUIRED, 5 OPTIONAL) -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0" style="border-radius: 16px 16px 0 0;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="fw-bold text-dark mb-0"><i class="bi bi-camera-fill text-primary me-2"></i>Room Photos (6 Slots)</h5>
                            <small class="text-muted"><strong>Photo 1 is Required</strong> for the main catalogue card. Photos 2 to 6 are Optional.</small>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary fw-bold">1 Required + 5 Optional</span>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <!-- Slot 1 (REQUIRED) -->
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded-3 p-3 h-100 position-relative" style="background: #f8fafc; border: 2px dashed #3b82f6 !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-primary" style="font-size: 13px;">📸 Photo 1 (Main Cover)</strong>
                                    <span class="badge bg-danger">REQUIRED</span>
                                </div>
                                <input type="file" name="file_image_1" class="form-control mb-2" accept="image/*" onchange="previewImg(this, 'preview_1')" {{ $isEdit ? '' : 'required' }}>
                                <div class="text-center">
                                    @php
                                        $curImg1 = $room ? (is_array($room) ? ($room['image'] ?? ($room['image_main'] ?? null)) : ($room->image ?? ($room->image_main ?? null))) : null;
                                    @endphp
                                    <img id="preview_1" src="{{ $curImg1 ? asset($curImg1) : asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg') }}" class="rounded shadow-sm" style="width: 100%; height: 110px; object-fit: cover;">
                                </div>
                                <small class="text-muted d-block text-center mt-1" style="font-size: 11px;">Primary hero display</small>
                            </div>
                        </div>

                        <!-- Slot 2 (OPTIONAL: Reception / Building) -->
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded-3 p-3 h-100" style="background: #f8fafc;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-dark" style="font-size: 13px;">📸 Photo 2 (Reception / Entry)</strong>
                                    <span class="badge bg-light text-muted border">OPTIONAL</span>
                                </div>
                                <input type="file" name="file_image_2" class="form-control mb-2" accept="image/*" onchange="previewImg(this, 'preview_2')">
                                <div class="text-center">
                                    @php
                                        $curImg2 = $room ? (is_array($room) ? ($room['image_reception'] ?? null) : ($room->image_reception ?? null)) : null;
                                    @endphp
                                    <img id="preview_2" src="{{ $curImg2 ? asset($curImg2) : asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg') }}" class="rounded shadow-sm" style="width: 100%; height: 110px; object-fit: cover;">
                                </div>
                                <small class="text-muted d-block text-center mt-1" style="font-size: 11px;">Lobby &amp; front gate</small>
                            </div>
                        </div>

                        <!-- Slot 3 (OPTIONAL: Bedroom View) -->
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded-3 p-3 h-100" style="background: #f8fafc;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-dark" style="font-size: 13px;">📸 Photo 3 (Bed &amp; Interior)</strong>
                                    <span class="badge bg-light text-muted border">OPTIONAL</span>
                                </div>
                                <input type="file" name="file_image_3" class="form-control mb-2" accept="image/*" onchange="previewImg(this, 'preview_3')">
                                <div class="text-center">
                                    @php
                                        $curImg3 = $room ? (is_array($room) ? ($room['image_room'] ?? null) : ($room->image_room ?? null)) : null;
                                    @endphp
                                    <img id="preview_3" src="{{ $curImg3 ? asset($curImg3) : asset('home/images/dewasharif/dewapage/deluxe_room.jpg') }}" class="rounded shadow-sm" style="width: 100%; height: 110px; object-fit: cover;">
                                </div>
                                <small class="text-muted d-block text-center mt-1" style="font-size: 11px;">Mattress, bed &amp; decor</small>
                            </div>
                        </div>

                        <!-- Slot 4 (OPTIONAL: Bathroom) -->
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded-3 p-3 h-100" style="background: #f8fafc;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-dark" style="font-size: 13px;">📸 Photo 4 (Clean Bathroom)</strong>
                                    <span class="badge bg-light text-muted border">OPTIONAL</span>
                                </div>
                                <input type="file" name="file_image_4" class="form-control mb-2" accept="image/*" onchange="previewImg(this, 'preview_4')">
                                <div class="text-center">
                                    @php
                                        $curImg4 = $room ? (is_array($room) ? ($room['image_bathroom'] ?? null) : ($room->image_bathroom ?? null)) : null;
                                    @endphp
                                    <img id="preview_4" src="{{ $curImg4 ? asset($curImg4) : asset('home/images/dewasharif/dewapage/standard_room.jpg') }}" class="rounded shadow-sm" style="width: 100%; height: 110px; object-fit: cover;">
                                </div>
                                <small class="text-muted d-block text-center mt-1" style="font-size: 11px;">Geyser &amp; sanitary fittings</small>
                            </div>
                        </div>

                        <!-- Slot 5 (OPTIONAL: Balcony / Gallery) -->
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded-3 p-3 h-100" style="background: #f8fafc;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-dark" style="font-size: 13px;">📸 Photo 5 (Balcony / View)</strong>
                                    <span class="badge bg-light text-muted border">OPTIONAL</span>
                                </div>
                                <input type="file" name="file_image_5" class="form-control mb-2" accept="image/*" onchange="previewImg(this, 'preview_5')">
                                <div class="text-center">
                                    @php
                                        $curImg5 = $room ? (is_array($room) ? ($room['image_extra'] ?? null) : ($room->image_extra ?? null)) : null;
                                    @endphp
                                    <img id="preview_5" src="{{ $curImg5 ? asset($curImg5) : asset('home/images/dewasharif/dewapage/deluxe_room.jpg') }}" class="rounded shadow-sm" style="width: 100%; height: 110px; object-fit: cover;">
                                </div>
                                <small class="text-muted d-block text-center mt-1" style="font-size: 11px;">Window / Dargah view</small>
                            </div>
                        </div>

                        <!-- Slot 6 (OPTIONAL: Additional Hall / Angle) -->
                        <div class="col-md-4 col-sm-6">
                            <div class="border rounded-3 p-3 h-100" style="background: #f8fafc;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <strong class="text-dark" style="font-size: 13px;">📸 Photo 6 (Extra Angle)</strong>
                                    <span class="badge bg-light text-muted border">OPTIONAL</span>
                                </div>
                                <input type="file" name="file_image_6" class="form-control mb-2" accept="image/*" onchange="previewImg(this, 'preview_6')">
                                <div class="text-center">
                                    @php
                                        $curImg6 = $room ? (is_array($room) ? ($room['image_6'] ?? null) : ($room->image_6 ?? null)) : null;
                                    @endphp
                                    <img id="preview_6" src="{{ $curImg6 ? asset($curImg6) : asset('home/images/dewasharif/dewapage/hero_hotel_bg.jpg') }}" class="rounded shadow-sm" style="width: 100%; height: 110px; object-fit: cover;">
                                </div>
                                <small class="text-muted d-block text-center mt-1" style="font-size: 11px;">Corridor or seating</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. PRICING & AUTO % OFF & 80% LIVE PROFIT CALCULATOR -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px; background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%); border: 1.5px solid #e2e8f0;">
                <div class="card-header bg-transparent py-3 border-0">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-tag-fill text-success me-2"></i>Room Pricing &amp; Net Revenue Split</h5>
                    <small class="text-muted">Enter your desired Selling Price. The system will auto-calculate your 80% take-home payout.</small>
                </div>
                <div class="card-body p-4 pt-1">
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Selling Price / Night (₹) *</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white fw-bold">₹</span>
                                <input type="number" id="inputSellingPrice" name="price_per_night" class="form-control fw-bold fs-5 text-dark" value="{{ $rPrice }}" min="100" step="50" required oninput="calcPricing()">
                            </div>
                            <small class="text-muted" style="font-size: 11.5px;">Actual tariff paid by booking devotee</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Original Tariff / MRP (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white fw-bold">₹</span>
                                <input type="number" id="inputMrp" name="mrp" class="form-control text-muted" value="{{ $rMrp }}" min="100" step="50" oninput="calcPricing()">
                            </div>
                            <small class="text-muted" style="font-size: 11.5px;">Shown crossed out on site</small>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Discount Badge</label>
                            <div>
                                <span id="discountBadge" class="badge bg-danger fs-6 px-3 py-2">0% OFF</span>
                            </div>
                            <small class="text-muted" style="font-size: 11.5px;">Auto-calculated from MRP &amp; Price</small>
                        </div>

                        <!-- Live 80% Payout Preview Box -->
                        <div class="col-12 mt-3">
                            <div class="p-3 rounded-3" style="background: #ecfdf5; border: 1.5px solid #a7f3d0;">
                                <div class="row align-items-center">
                                    <div class="col-md-8">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-wallet2 text-success fs-4"></i>
                                            <div>
                                                <strong class="text-dark" style="font-size: 14px;">Your Guaranteed 80% Take-Home Profit:</strong>
                                                <p class="text-muted mb-0" style="font-size: 12px;">DewaSharif platform fee is strictly 20%. You receive ₹<span id="partnerEarnPreview">1,199.20</span> per night directly in your bank account.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                        <span class="fs-4 fw-bold text-success" id="partnerEarnBig">₹1,199.20</span>
                                        <span class="badge bg-success bg-opacity-25 text-success ms-1">80% Net</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. ROOM SPECIFICATIONS & INVENTORY -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-sliders text-primary me-2"></i>Room Category, Capacity &amp; Inventory</h5>
                </div>
                <div class="card-body p-4 pt-1">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Room Type / Category Name *</label>
                            <select name="room_type" class="form-select" required>
                                <option value="Single Bedroom AC" {{ $rType === 'Single Bedroom AC' ? 'selected' : '' }}>Single Bedroom AC</option>
                                <option value="Queen Size AC" {{ $rType === 'Queen Size AC' || $rType === 'Deluxe AC Room' ? 'selected' : '' }}>Queen Size AC (Deluxe)</option>
                                <option value="King Size AC" {{ $rType === 'King Size AC' || $rType === 'Super Deluxe AC' ? 'selected' : '' }}>King Size AC (Super Deluxe)</option>
                                <option value="AC Hall (5+ Persons)" {{ $rType === 'AC Hall (5+ Persons)' ? 'selected' : '' }}>AC Family Hall (5+ Devotees)</option>
                                <option value="Single Non-AC" {{ $rType === 'Single Non-AC' ? 'selected' : '' }}>Single Non-AC</option>
                                <option value="Queen Size Non-AC" {{ $rType === 'Queen Size Non-AC' ? 'selected' : '' }}>Queen Size Non-AC</option>
                                <option value="King Size Non-AC" {{ $rType === 'King Size Non-AC' ? 'selected' : '' }}>King Size Non-AC</option>
                                <option value="Non-AC Hall (5+ Persons)" {{ $rType === 'Non-AC Hall (5+ Persons)' ? 'selected' : '' }}>Non-AC Family Hall (5+ Devotees)</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Cooling Type</label>
                            <select name="ac_type" class="form-select">
                                <option value="AC" {{ $rAc === 'AC' ? 'selected' : '' }}>AC (Air Conditioner)</option>
                                <option value="Non-AC" {{ $rAc === 'Non-AC' ? 'selected' : '' }}>Non-AC (Ceiling Fan)</option>
                                <option value="Air Cooler" {{ $rAc === 'Air Cooler' ? 'selected' : '' }}>Air Cooler</option>
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Bed Configuration</label>
                            <select name="bed_type" class="form-select">
                                <option value="Double Bed" {{ $rBed === 'Double Bed' ? 'selected' : '' }}>Double Bed</option>
                                <option value="King Bed" {{ $rBed === 'King Bed' ? 'selected' : '' }}>King Size Bed</option>
                                <option value="2 Single Beds" {{ $rBed === '2 Single Beds' ? 'selected' : '' }}>2 Single Beds</option>
                                <option value="3 Beds Family" {{ $rBed === '3 Beds Family' ? 'selected' : '' }}>3 Beds Family</option>
                                <option value="5+ Mattresses (Hall)" {{ $rBed === '5+ Mattresses (Hall)' ? 'selected' : '' }}>5+ Mattresses (Hall)</option>
                            </select>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Max Adults Allowed</label>
                            <input type="number" name="max_adults" class="form-control" value="{{ $rAdults }}" min="1" max="25" required>
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Max Children Allowed</label>
                            <input type="number" name="max_children" class="form-control" value="{{ $rChildren }}" min="0" max="15">
                        </div>

                        <div class="col-md-4 col-sm-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Available Rooms (Inventory) *</label>
                            <input type="number" name="available_rooms" class="form-control fw-bold" value="{{ $rRooms }}" min="1" max="100" required>
                            <small class="text-muted" style="font-size: 11px;">Auto-decrements on online booking</small>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Bathroom Specification</label>
                            <select name="bath_type" class="form-select">
                                <option value="Attached Western Bath" {{ $rBath === 'Attached Western Bath' ? 'selected' : '' }}>Attached Western Bath</option>
                                <option value="Attached Indian Style Bath" {{ $rBath === 'Attached Indian Style Bath' ? 'selected' : '' }}>Attached Indian Style Bath</option>
                                <option value="Common Bath on Floor" {{ $rBath === 'Common Bath on Floor' ? 'selected' : '' }}>Common Bath on Floor</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-dark" style="font-size: 13px;">Proximity / Location Description</label>
                            <input type="text" name="location" class="form-control" value="{{ $rLocation }}" placeholder="e.g. 100 meters from Dargah Sharif Gate No. 2">
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. AMENITIES CHECKBOXES (12 PRE-BUILT OPTIONS) -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-0" style="border-radius: 16px 16px 0 0;">
                    <h5 class="fw-bold text-dark mb-0"><i class="bi bi-check2-square text-success me-2"></i>Select Included Amenities (Printed on Voucher)</h5>
                </div>
                <div class="card-body p-4 pt-1">
                    <div class="row g-3">
                        @foreach($allPresetAmenities as $amenity)
                            <div class="col-md-4 col-sm-6">
                                <div class="form-check p-2 border rounded-3 h-100" style="background: #f8fafc;">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="amenities[]" value="{{ $amenity }}" id="amenity_{{ md5($amenity) }}" {{ in_array($amenity, $rAmenities) ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-dark" for="amenity_{{ md5($amenity) }}" style="font-size: 13px; cursor: pointer;">
                                        {{ $amenity }}
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-5">
                <a href="{{ route('hotel.rooms') }}" class="btn btn-outline-secondary px-4 fw-bold">Cancel</a>
                <button type="submit" class="btn btn-success fw-bold px-5 py-2 shadow" style="border-radius: 10px; font-size: 16px;">
                    <i class="bi bi-cloud-arrow-up-fill me-1"></i> {{ $isEdit ? 'Save Changes' : 'Publish Room Listing' }}
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImg(input, targetId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(targetId).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function calcPricing() {
        const sellingPrice = parseFloat(document.getElementById('inputSellingPrice').value) || 0;
        const mrp = parseFloat(document.getElementById('inputMrp').value) || 0;

        // Auto discount %
        let disc = 0;
        if (mrp > sellingPrice && mrp > 0) {
            disc = Math.round(((mrp - sellingPrice) / mrp) * 100);
        }
        document.getElementById('discountBadge').innerText = disc + '% OFF';

        // 80% partner net calculation
        const partnerEarn = (sellingPrice * 0.80).toFixed(2);
        document.getElementById('partnerEarnPreview').innerText = Number(partnerEarn).toLocaleString('en-IN', {minimumFractionDigits: 2});
        document.getElementById('partnerEarnBig').innerText = '₹' + Number(partnerEarn).toLocaleString('en-IN', {minimumFractionDigits: 2});
    }

    document.addEventListener('DOMContentLoaded', calcPricing);
</script>
@endsection
