@extends('admin.includes.master')

@php
    if (!function_exists('safeHotelAsset')) {
        function safeHotelAsset($path, $fallback) {
            if (empty($path)) {
                return asset($fallback);
            }
            if (is_string($path) && (str_starts_with($path, 'http://') || str_starts_with($path, 'https://'))) {
                if (str_contains($path, 'dewasharif.com/') || str_contains($path, '127.0.0.1') || str_contains($path, 'localhost')) {
                    $parsed = parse_url($path, PHP_URL_PATH);
                    if (!empty($parsed)) {
                        return asset(ltrim($parsed, '/'));
                    }
                }
                return $path;
            }
            return asset(ltrim($path, '/'));
        }
    }
@endphp

@section('title', 'Manage Hotels & Rooms | DewaSharif Admin')

@section('content')
<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0"><i class="bi bi-building text-warning me-2"></i>Hotels &amp; Room Master Management</h3>
                </div>
                <div class="col-sm-6 text-end">
                    <button class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addHotelModal">
                        <i class="bi bi-plus-circle me-1"></i> Add New Hotel Room Listing
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card card-outline card-warning shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0 fw-bold text-dark"><i class="bi bi-list-stars me-2 text-warning"></i>Hotels &amp; Guest Houses Master Directory</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-dark">
                                <tr>
                                    <th>#ID</th>
                                    <th>Hotel &amp; Room Details</th>
                                    <th>Room Specifications</th>
                                    <th>Price / Night</th>
                                    <th>Availability</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($hotels as $hotel)
                                    @php
                                        $hId = is_array($hotel) ? ($hotel['id'] ?? 1) : $hotel->id;
                                        $hName = is_array($hotel) ? ($hotel['name'] ?? 'Hotel') : $hotel->name;
                                        $hType = is_array($hotel) ? ($hotel['room_type'] ?? 'Deluxe AC Room') : ($hotel->room_type ?? 'Deluxe AC Room');
                                        $hAc = is_array($hotel) ? ($hotel['ac_type'] ?? 'AC') : ($hotel->ac_type ?? 'AC');
                                        $hBed = is_array($hotel) ? ($hotel['bed_type'] ?? 'Double Bed') : ($hotel->bed_type ?? 'Double Bed');
                                        $hAdults = is_array($hotel) ? ($hotel['max_adults'] ?? 2) : ($hotel->max_adults ?? 2);
                                        $hChildren = is_array($hotel) ? ($hotel['max_children'] ?? 1) : ($hotel->max_children ?? 1);
                                        $hBath = is_array($hotel) ? ($hotel['bath_type'] ?? 'Attached Western Bath') : ($hotel->bath_type ?? 'Attached Western Bath');
                                        $rawPriceVal = (float)(is_array($hotel) ? ($hotel['price_per_night'] ?? ($hotel['price'] ?? 0)) : ($hotel->price_per_night ?? ($hotel->price ?? 0)));
                                        $hPrice = $rawPriceVal > 0 ? $rawPriceVal : 1499;
                                        $hRooms = is_array($hotel) ? ($hotel['available_rooms'] ?? 10) : ($hotel->available_rooms ?? 10);
                                        $hLocation = is_array($hotel) ? ($hotel['location'] ?? ($hotel['distance'] ?? 'Near Dewa Sharif Dargah')) : ($hotel->location ?? 'Near Dewa Sharif Dargah');
                                        $hStatus = is_array($hotel) ? ($hotel['status'] ?? 'active') : ($hotel->status ?? 'active');
                                        $rawImgVal = is_array($hotel) ? ($hotel['image'] ?? ($hotel['image_main'] ?? null)) : ($hotel->image ?? ($hotel->image_main ?? null));
                                        $hImg = safeHotelAsset($rawImgVal, 'home/images/dewasharif/dewapage/guesthouse.jpg');
                                        $hAmenities = is_array($hotel) ? ($hotel['amenities'] ?? []) : ($hotel->amenities ?? []);
                                        if (is_string($hAmenities)) { $hAmenities = explode(',', $hAmenities); }
                                    @endphp
                                    <tr>
                                        <td>#HTL-{{ $hId }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $hImg }}" onerror="this.onerror=null; this.src='{{ asset('home/images/dewasharif/dewapage/guesthouse.jpg') }}'" class="rounded me-2 shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                                <div>
                                                    <strong class="d-block text-dark">{{ $hName }}</strong>
                                                    <small class="text-muted"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $hLocation }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex flex-wrap gap-1">
                                                <span class="badge {{ strtolower($hAc) == 'ac' ? 'bg-primary' : 'bg-secondary' }}">{{ $hAc }}</span>
                                                <span class="badge bg-info text-dark"><i class="bi bi-door-closed me-1"></i>{{ $hType }}</span>
                                                <span class="badge bg-dark"><i class="bi bi-badge-ad me-1"></i>{{ $hBed }}</span>
                                                <span class="badge bg-light text-dark border">👥 {{ $hAdults }} A / {{ $hChildren }} C</span>
                                                <span class="badge bg-warning text-dark"><i class="bi bi-droplet-fill me-1"></i>{{ $hBath }}</span>
                                            </div>
                                        </td>
                                        <td><strong class="text-success fs-6">₹{{ number_format($hPrice, 2) }}</strong> <small class="text-muted">/ night</small></td>
                                        <td>
                                            @if($hRooms > 0)
                                                <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>{{ $hRooms }} Rooms Left</span>
                                            @else
                                                <span class="badge bg-danger"><i class="bi bi-x-circle me-1"></i>Sold Out</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.hotels.toggle', $hId) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle Active/Inactive">
                                                    @if(strtolower($hStatus) === 'active')
                                                        <span class="badge bg-success" style="cursor: pointer;"><i class="bi bi-toggle-on me-1"></i> Active</span>
                                                    @else
                                                        <span class="badge bg-secondary" style="cursor: pointer;"><i class="bi bi-toggle-off me-1"></i> Inactive</span>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editHotelModal{{ $hId }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.hotels.destroy', $hId) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Are you sure you want to delete this hotel room?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Hotel Modal -->
                                    <div class="modal fade" id="editHotelModal{{ $hId }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.hotels.update', $hId) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Room Master &amp; Gallery — #HTL-{{ $hId }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Hotel / Guest House Name*</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $hName }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Room Category / Type*</label>
                                                            <select name="room_type" class="form-select">
                                                                <optgroup label="❄️ AC Categories">
                                                                    <option value="Single Bedroom AC" {{ $hType == 'Single Bedroom AC' ? 'selected' : '' }}>Single Bedroom AC</option>
                                                                    <option value="Queen Size AC" {{ $hType == 'Queen Size AC' ? 'selected' : '' }}>Queen Size AC</option>
                                                                    <option value="King Size AC" {{ $hType == 'King Size AC' ? 'selected' : '' }}>King Size AC</option>
                                                                    <option value="AC Hall (5+ Persons)" {{ $hType == 'AC Hall (5+ Persons)' ? 'selected' : '' }}>AC Hall (5+ Persons)</option>
                                                                </optgroup>
                                                                <optgroup label="🌿 Non-AC Categories">
                                                                    <option value="Single Non-AC" {{ $hType == 'Single Non-AC' ? 'selected' : '' }}>Single Non-AC</option>
                                                                    <option value="Queen Size Non-AC" {{ $hType == 'Queen Size Non-AC' ? 'selected' : '' }}>Queen Size Non-AC</option>
                                                                    <option value="King Size Non-AC" {{ $hType == 'King Size Non-AC' ? 'selected' : '' }}>King Size Non-AC</option>
                                                                    <option value="Non-AC Hall (5+ Persons)" {{ $hType == 'Non-AC Hall (5+ Persons)' ? 'selected' : '' }}>Non-AC Hall (5+ Persons)</option>
                                                                </optgroup>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">AC / Cooling Type*</label>
                                                            <select name="ac_type" class="form-select">
                                                                <option value="AC" {{ $hAc == 'AC' ? 'selected' : '' }}>❄️ AC (Air Conditioned)</option>
                                                                <option value="Non-AC" {{ $hAc == 'Non-AC' ? 'selected' : '' }}>🌿 Non-AC (Cooler / Fan)</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Bed Configuration*</label>
                                                            <select name="bed_type" class="form-select">
                                                                <option value="Single Bed" {{ $hBed == 'Single Bed' ? 'selected' : '' }}>Single Bed</option>
                                                                <option value="Double Bed" {{ $hBed == 'Double Bed' ? 'selected' : '' }}>Double Bed</option>
                                                                <option value="King Size Bed" {{ $hBed == 'King Size Bed' ? 'selected' : '' }}>King Size Bed</option>
                                                                <option value="4-Bedded Family Hall" {{ $hBed == '4-Bedded Family Hall' ? 'selected' : '' }}>4-Bedded Family Hall</option>
                                                                <option value="6-Bedded Group Hall" {{ $hBed == '6-Bedded Group Hall' ? 'selected' : '' }}>6-Bedded Group Hall</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Bathroom Type*</label>
                                                            <select name="bath_type" class="form-select">
                                                                <option value="Attached Western Bath" {{ $hBath == 'Attached Western Bath' ? 'selected' : '' }}>Attached Western Bath</option>
                                                                <option value="Attached Indian Bath" {{ $hBath == 'Attached Indian Bath' ? 'selected' : '' }}>Attached Indian Bath</option>
                                                                <option value="Shared Bathroom" {{ $hBath == 'Shared Bathroom' ? 'selected' : '' }}>Shared Bathroom</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Max Adults*</label>
                                                            <input type="number" name="max_adults" class="form-control" value="{{ $hAdults }}" min="1" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Max Children*</label>
                                                            <input type="number" name="max_children" class="form-control" value="{{ $hChildren }}" min="0" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Price / Night (₹)*</label>
                                                            <input type="number" step="0.01" name="price_per_night" class="form-control" value="{{ $hPrice }}" required>
                                                        </div>
                                                        
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Available Rooms Count*</label>
                                                            <input type="number" name="available_rooms" class="form-control" value="{{ $hRooms }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label fw-bold">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="active" {{ $hStatus == 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ $hStatus == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label fw-bold">Location / Address*</label>
                                                            <input type="text" name="location" class="form-control" value="{{ $hLocation }}" required>
                                                        </div>

                                                        <!-- AMENITIES CHECKBOXES -->
                                                        <div class="col-12">
                                                            <div class="p-3 bg-light rounded border">
                                                                <label class="form-label fw-bold text-dark mb-2"><i class="bi bi-star-fill text-warning me-1"></i> Room &amp; Hotel Amenities:</label>
                                                                <div class="row g-2">
                                                                    @php
                                                                        $allAmenities = ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Near Dargah Gate', 'Air Conditioner', 'LED TV', 'Room Service', 'CCTV Security'];
                                                                    @endphp
                                                                    @foreach($allAmenities as $amenity)
                                                                        <div class="col-md-3 col-6">
                                                                            <div class="form-check">
                                                                                <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity }}" id="edit_am_{{ $hId }}_{{ $loop->index }}" {{ in_array($amenity, $hAmenities) ? 'checked' : '' }}>
                                                                                <label class="form-check-label small fw-semibold" for="edit_am_{{ $hId }}_{{ $loop->index }}">{{ $amenity }}</label>
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- 5-PHOTO GALLERY SECTION FOR EDIT -->
                                                        <div class="col-12 mt-2">
                                                            <div class="p-3 bg-light rounded border">
                                                                <h6 class="fw-bold text-primary mb-3"><i class="bi bi-images me-2"></i>Update Hotel 5-Photo Gallery (Optional Uploads)</h6>
                                                                <div class="row g-3">
                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-bold text-dark small"><i class="bi bi-building text-success me-1"></i>1. Main Exterior / Outside View</label>
                                                                        <input type="file" name="file_image_main" class="form-control form-control-sm" accept="image/*">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-bold text-dark small"><i class="bi bi-bell-fill text-warning me-1"></i>2. Reception &amp; Lobby Area</label>
                                                                        <input type="file" name="file_image_reception" class="form-control form-control-sm" accept="image/*">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-bold text-dark small"><i class="bi bi-door-open-fill text-primary me-1"></i>3. Room Interior &amp; Bed View</label>
                                                                        <input type="file" name="file_image_room" class="form-control form-control-sm" accept="image/*">
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label class="form-label fw-bold text-dark small"><i class="bi bi-droplet-fill text-info me-1"></i>4. Bathroom &amp; Toilet View</label>
                                                                        <input type="file" name="file_image_bathroom" class="form-control form-control-sm" accept="image/*">
                                                                    </div>
                                                                    <div class="col-md-12">
                                                                        <label class="form-label fw-bold text-dark small"><i class="bi bi-sun-fill text-danger me-1"></i>5. Balcony / Extra View</label>
                                                                        <input type="file" name="file_image_extra" class="form-control form-control-sm" accept="image/*">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Update Room Master</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">No hotel listings found. Click "Add New Hotel Room Listing" to create one.</td>
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

<!-- Add Hotel Modal -->
<div class="modal fade" id="addHotelModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.hotels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Hotel Room Listing (Complete Room Master Setup)</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Hotel / Guest House Name*</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Al-Waris Deluxe Guest House" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Room Category / Type*</label>
                        <select name="room_type" class="form-select">
                            <optgroup label="❄️ AC Categories">
                                <option value="Single Bedroom AC">Single Bedroom AC</option>
                                <option value="Queen Size AC" selected>Queen Size AC</option>
                                <option value="King Size AC">King Size AC</option>
                                <option value="AC Hall (5+ Persons)">AC Hall (5+ Persons)</option>
                            </optgroup>
                            <optgroup label="🌿 Non-AC Categories">
                                <option value="Single Non-AC">Single Non-AC</option>
                                <option value="Queen Size Non-AC">Queen Size Non-AC</option>
                                <option value="King Size Non-AC">King Size Non-AC</option>
                                <option value="Non-AC Hall (5+ Persons)">Non-AC Hall (5+ Persons)</option>
                            </optgroup>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">AC / Cooling Type*</label>
                        <select name="ac_type" class="form-select">
                            <option value="AC">❄️ AC (Air Conditioned)</option>
                            <option value="Non-AC">🌿 Non-AC (Cooler / Fan)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Bed Configuration*</label>
                        <select name="bed_type" class="form-select">
                            <option value="Double Bed">Double Bed</option>
                            <option value="Single Bed">Single Bed</option>
                            <option value="King Size Bed">King Size Bed</option>
                            <option value="4-Bedded Family Hall">4-Bedded Family Hall</option>
                            <option value="6-Bedded Group Hall">6-Bedded Group Hall</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Bathroom Type*</label>
                        <select name="bath_type" class="form-select">
                            <option value="Attached Western Bath">Attached Western Bath</option>
                            <option value="Attached Indian Bath">Attached Indian Bath</option>
                            <option value="Shared Bathroom">Shared Bathroom</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Max Adults*</label>
                        <input type="number" name="max_adults" class="form-control" value="2" min="1" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Max Children*</label>
                        <input type="number" name="max_children" class="form-control" value="1" min="0" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Price / Night (₹)*</label>
                        <input type="number" step="0.01" name="price_per_night" class="form-control" placeholder="1499" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Available Rooms Count*</label>
                        <input type="number" name="available_rooms" class="form-control" placeholder="10" value="10" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-bold">Location / Address*</label>
                        <input type="text" name="location" class="form-control" placeholder="Near Dewa Sharif Dargah Gate No. 1" required>
                    </div>

                    <!-- AMENITIES CHECKBOXES -->
                    <div class="col-12">
                        <div class="p-3 bg-light rounded border">
                            <label class="form-label fw-bold text-dark mb-2"><i class="bi bi-star-fill text-warning me-1"></i> Room &amp; Hotel Amenities:</label>
                            <div class="row g-2">
                                @php
                                    $allAmenities = ['24/7 Power Backup', 'Free Wi-Fi', 'Geyser/Hot Water', 'Near Dargah Gate', 'Air Conditioner', 'LED TV', 'Room Service', 'CCTV Security'];
                                @endphp
                                @foreach($allAmenities as $amenity)
                                    <div class="col-md-3 col-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="amenities[]" value="{{ $amenity }}" id="add_am_{{ $loop->index }}" checked>
                                            <label class="form-check-label small fw-semibold" for="add_am_{{ $loop->index }}">{{ $amenity }}</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- 5-PHOTO GALLERY SECTION FOR ADD -->
                    <div class="col-12 mt-2">
                        <div class="p-3 bg-light rounded border">
                            <h6 class="fw-bold text-success mb-3"><i class="bi bi-images me-2"></i>Hotel 5-Photo Gallery (Optional File Uploads)</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small"><i class="bi bi-building text-success me-1"></i>1. Main Exterior / Outside View</label>
                                    <input type="file" name="file_image_main" class="form-control form-control-sm" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small"><i class="bi bi-bell-fill text-warning me-1"></i>2. Reception &amp; Lobby Area</label>
                                    <input type="file" name="file_image_reception" class="form-control form-control-sm" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small"><i class="bi bi-door-open-fill text-primary me-1"></i>3. Room Interior &amp; Bed View</label>
                                    <input type="file" name="file_image_room" class="form-control form-control-sm" accept="image/*">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-dark small"><i class="bi bi-droplet-fill text-info me-1"></i>4. Bathroom &amp; Toilet View</label>
                                    <input type="file" name="file_image_bathroom" class="form-control form-control-sm" accept="image/*">
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold text-dark small"><i class="bi bi-sun-fill text-danger me-1"></i>5. Balcony / Extra View</label>
                                    <input type="file" name="file_image_extra" class="form-control form-control-sm" accept="image/*">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-check-circle me-1"></i> Save Hotel Room Master</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

