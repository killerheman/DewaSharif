@extends('admin.includes.master')

@section('title', 'Manage Cabs & Taxi Fleet | DewaSharif Admin')

@section('content')
    <main class="app-main">
        <div class="app-content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="mb-0"><i class="bi bi-car-front text-success me-2"></i>Cabs &amp; Taxi Fleet Management
                        </h3>
                    </div>
                    <div class="col-sm-6 text-end">
                        <button class="btn btn-success fw-bold shadow-sm" data-bs-toggle="modal"
                            data-bs-target="#addCabRouteModal">
                            <i class="bi bi-plus-circle me-1"></i> Add New Cab Route &amp; Fleet
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

                <div class="card card-outline card-success shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0 fw-bold text-dark"><i
                                class="bi bi-card-checklist me-2 text-success"></i>Active Taxi Routes &amp; Driver Fleet
                            Directory</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#ID</th>
                                        <th>Route Details</th>
                                        <th>Vehicle Specifications</th>
                                        <th>Total Fare</th>
                                        <th>Driver Verification (Aadhaar/DL)</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($cabs as $cab)
                                        @php
                                            $cId = is_array($cab) ? ($cab['id'] ?? 1) : $cab->id;
                                            $cRoute = is_array($cab) ? ($cab['route_name'] ?? ($cab['route'] ?? 'Lucknow ↔ Dewa Sharif')) : ($cab->route_name ?? 'Lucknow ↔ Dewa Sharif');
                                            $cPickup = is_array($cab) ? ($cab['pickup'] ?? 'Lucknow Airport') : ($cab->pickup ?? 'Lucknow Airport');
                                            $cDest = is_array($cab) ? ($cab['destination'] ?? 'Dewa Sharif Dargah') : ($cab->destination ?? 'Dewa Sharif Dargah');
                                            $cType = is_array($cab) ? ($cab['vehicle_type'] ?? ($cab['title'] ?? 'Sedan')) : ($cab->vehicle_type ?? 'Sedan');
                                            $cModel = is_array($cab) ? ($cab['vehicle_name'] ?? 'Swift Dzire') : ($cab->vehicle_name ?? 'Swift Dzire');
                                            $cNumber = is_array($cab) ? ($cab['vehicle_number'] ?? 'UP 32 AB 1234') : ($cab->vehicle_number ?? 'UP 32 AB 1234');
                                            $cAc = is_array($cab) ? ($cab['ac_option'] ?? 'AC') : ($cab->ac_option ?? 'AC');
                                            $cCapacity = is_array($cab) ? ($cab['seating_capacity'] ?? ($cab['capacity'] ?? '4 Passengers')) : ($cab->seating_capacity ?? '4 Passengers');
                                            $cToll = is_array($cab) ? ($cab['toll_status'] ?? 'Toll Tax Included') : ($cab->toll_status ?? 'Toll Tax Included');
                                            $cFare = is_array($cab) ? ($cab['price'] ?? ($cab['fare'] ?? 1499)) : ($cab->price ?? 1499);
                                            $cDriver = is_array($cab) ? ($cab['driver_name'] ?? 'Ramesh Kumar') : ($cab->driver_name ?? 'Ramesh Kumar');
                                            $cPhone = is_array($cab) ? ($cab['driver_phone'] ?? '9876543210') : ($cab->driver_phone ?? '9876543210');
                                            $cAadhaar = is_array($cab) ? ($cab['driver_aadhaar'] ?? '1234 5678 9012') : ($cab->driver_aadhaar ?? '1234 5678 9012');
                                            $cDl = is_array($cab) ? ($cab['driver_dl'] ?? 'UP32-2022-0089123') : ($cab->driver_dl ?? 'UP32-2022-0089123');
                                            $cStatus = is_array($cab) ? ($cab['status'] ?? 'Active') : ($cab->status ?? 'Active');
                                        @endphp
                                        <tr>
                                            <td>#CAB-{{ $cId }}</td>
                                            <td>
                                                <strong class="d-block text-primary">{{ $cRoute }}</strong>
                                                <small class="text-muted"><i
                                                        class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $cPickup }} ➔
                                                    {{ $cDest }}</small>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <span class="badge bg-dark"><i
                                                            class="bi bi-car-front me-1"></i>{{ $cType }}</span>
                                                    <span class="badge bg-secondary">{{ $cModel }} ({{ $cNumber }})</span>
                                                    <span
                                                        class="badge {{ strtolower($cAc) == 'ac' ? 'bg-primary' : 'bg-warning text-dark' }}">{{ $cAc }}</span>
                                                    <span class="badge bg-info text-dark">👥 {{ $cCapacity }}</span>
                                                    <span class="badge bg-light text-dark border">🛣️ {{ $cToll }}</span>
                                                </div>
                                            </td>
                                            <td><strong class="text-success fs-6">₹{{ number_format($cFare, 2) }}</strong></td>
                                            <td>
                                                <strong class="d-block text-dark"><i
                                                        class="bi bi-person-badge-fill text-success me-1"></i>{{ $cDriver }}</strong>
                                                <small class="d-block text-muted"><i
                                                        class="bi bi-telephone me-1"></i>{{ $cPhone }}</small>
                                                <small class="d-block text-primary">🪪 Aadhaar: {{ $cAadhaar }}</small>
                                                <small class="d-block text-secondary">📄 DL: {{ $cDl }}</small>
                                            </td>
                                            <td>
                                                <form action="{{ route('admin.cabs.route.toggle', $cId) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="border-0 bg-transparent p-0"
                                                        title="Click to toggle Active/Inactive">
                                                        @if(strtolower($cStatus) === 'active')
                                                            <span class="badge bg-success" style="cursor: pointer;"><i
                                                                    class="bi bi-toggle-on me-1"></i> Active</span>
                                                        @else
                                                            <span class="badge bg-secondary" style="cursor: pointer;"><i
                                                                    class="bi bi-toggle-off me-1"></i> Inactive</span>
                                                        @endif
                                                    </button>
                                                </form>
                                            </td>
                                            <td class="text-end text-nowrap">
                                                <div class="d-inline-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                                        data-bs-target="#editCabModal{{ $cId }}">
                                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                                    </button>
                                                    <form action="{{ route('admin.cabs.destroy', $cId) }}" method="POST"
                                                        class="d-inline m-0"
                                                        onsubmit="return confirm('Delete this taxi route record?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Cab Route Modal -->
                                        <div class="modal fade" id="editCabModal{{ $cId }}" tabindex="-1">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.cabs.route.update', $cId) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit
                                                                Taxi Route &amp; Driver Fleet Details — #CAB-{{ $cId }}</h5>
                                                            <button type="button" class="btn-close btn-close-white"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body row g-3">
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Route Name /
                                                                    Description*</label>
                                                                <input type="text" name="route_name" class="form-control"
                                                                    value="{{ $cRoute }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">AC / Cooling Option*</label>
                                                                <select name="ac_option" class="form-select ac-option-select"
                                                                    data-target-vehicle="#edit_vehicle_type_{{ $cId }}">
                                                                    <option value="AC" {{ $cAc == 'AC' ? 'selected' : '' }}>❄️ AC
                                                                        (Air Conditioned)</option>
                                                                    <option value="Non-AC" {{ $cAc == 'Non-AC' ? 'selected' : '' }}>🌿 Non-AC</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Vehicle Category /
                                                                    Type*</label>
                                                                <select name="vehicle_type" id="edit_vehicle_type_{{ $cId }}"
                                                                    class="form-select vehicle-type-select"
                                                                    data-target="#edit_seating_capacity_{{ $cId }}">
                                                                    <option value="Omni Van (Standard)" data-ac="both"
                                                                        data-capacity="7 Passengers + 1 Driver (Total 8)" {{ (str_contains($cType, 'Omni') || str_contains($cType, 'Standard')) ? 'selected' : '' }}>Omni Van (Standard)
                                                                    </option>
                                                                    <option
                                                                        value="Dzire etc which is available (Semi Deluxe - Sedan)"
                                                                        data-ac="both"
                                                                        data-capacity="4 Passengers + 1 Driver (Total 5)" {{ (str_contains($cType, 'Dzire') || str_contains($cType, 'Semi Deluxe')) ? 'selected' : '' }}>Dzire etc which is
                                                                        available (Semi Deluxe - Sedan)</option>
                                                                    {{-- <option
                                                                        value="Verna etc which is available (Deluxe - Sedan)"
                                                                        data-ac="both"
                                                                        data-capacity="4 Passengers + 1 Driver (Total 5)" {{ (str_contains($cType, 'Verna') || str_contains($cType, 'Deluxe')) ? 'selected' : '' }}>Verna etc which is
                                                                        available (Deluxe - Sedan)</option> --}}
                                                                    <option value="Ertiga etc which is available (SUV)"
                                                                        data-ac="both"
                                                                        data-capacity="7 Passengers + 1 Driver (Total 8)" {{ (str_contains($cType, 'Ertiga') || str_contains($cType, 'SUV')) ? 'selected' : '' }}>Ertiga etc which is
                                                                        available (SUV)</option>
                                                                    <option value="Mahindra Pickup (Goods & Dala)"
                                                                        data-ac="both"
                                                                        data-capacity="1 Passengers + 1 Driver + Goods" {{ (str_contains($cType, 'Pickup') || str_contains($cType, 'Mahindra')) ? 'selected' : '' }}>Mahindra Pickup (Goods
                                                                        &amp; Dala)</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Seating Capacity with Driver</label>
                                                                <input type="text" name="seating_capacity"
                                                                    id="edit_seating_capacity_{{ $cId }}" class="form-control"
                                                                    value="{{ $cCapacity }}">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Pickup Location*</label>
                                                                <input type="text" name="pickup" class="form-control"
                                                                    value="{{ $cPickup }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Destination Location*</label>
                                                                <input type="text" name="destination" class="form-control"
                                                                    value="{{ $cDest }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Vehicle Model / Name <span class="text-muted fw-normal">(Optional)</span></label>
                                                                <input type="text" name="vehicle_name" class="form-control"
                                                                    value="{{ $cModel }}" placeholder="e.g. Swift Dzire">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Vehicle Number Plate <span class="text-muted fw-normal">(Optional)</span></label>
                                                                <input type="text" name="vehicle_number" class="form-control"
                                                                    value="{{ $cNumber }}" placeholder="e.g. UP 32 AB 1234">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Total Route Fare (₹)*</label>
                                                                <input type="number" step="0.01" name="price"
                                                                    class="form-control" value="{{ $cFare }}" required>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Toll Tax &amp; Parking
                                                                    Status*</label>
                                                                <select name="toll_status" class="form-select">
                                                                    <option value="Toll Tax Included" {{ $cToll == 'Toll Tax Included' ? 'selected' : '' }}>Toll Tax Included in Fare
                                                                    </option>
                                                                    <option value="Extra at Toll Booth" {{ $cToll == 'Extra at Toll Booth' ? 'selected' : '' }}>Extra at Toll Booth
                                                                    </option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Driver Name <span class="text-muted fw-normal">(Optional)</span></label>
                                                                <input type="text" name="driver_name" class="form-control"
                                                                    value="{{ $cDriver }}" placeholder="e.g. Ramesh Kumar">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold">Driver Phone / WhatsApp <span class="text-muted fw-normal">(Optional)</span></label>
                                                                <input type="text" name="driver_phone" class="form-control"
                                                                    value="{{ $cPhone }}" placeholder="e.g. 9876543210">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold text-primary">Driver Aadhaar Card No <span class="text-muted fw-normal">(Optional)</span></label>
                                                                <input type="text" name="driver_aadhaar" class="form-control"
                                                                    value="{{ $cAadhaar }}" placeholder="1234 5678 9012">
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label class="form-label fw-bold text-secondary">Driver Driving License (DL) No <span class="text-muted fw-normal">(Optional)</span></label>
                                                                <input type="text" name="driver_dl" class="form-control"
                                                                    value="{{ $cDl }}" placeholder="UP32-2022-0089123">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary fw-bold"><i
                                                                    class="bi bi-save me-1"></i> Update Route Details</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">No taxi routes configured. Click
                                                "Add New Cab Route &amp; Fleet" to create one.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- PICKUP & DROP PLACES DIRECTORY MANAGEMENT CARD -->
                <div class="card card-outline card-info shadow-sm mt-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0 fw-bold text-dark">
                                <i class="bi bi-geo-alt-fill me-2 text-info"></i>Pickup &amp; Drop Places Directory (Dropdown Places Master List)
                            </h5>
                            <small class="text-muted">Manage places shown in Pickup and Drop dropdowns on frontend (/cabs)</small>
                        </div>
                        <div>
                            <button class="btn btn-sm btn-info text-white fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                                <i class="bi bi-plus-circle me-1"></i> Add New Location / Place
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#ID</th>
                                        <th>Location / Place Name</th>
                                        <th>Dropdown Category</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($locations as $loc)
                                        @php
                                            $lId = is_array($loc) ? ($loc['id'] ?? 1) : $loc->id;
                                            $lName = is_array($loc) ? ($loc['name'] ?? '') : ($loc->name ?? '');
                                            $lType = is_array($loc) ? ($loc['type'] ?? 'Both') : ($loc->type ?? 'Both');
                                        @endphp
                                        <tr>
                                            <td>#LOC-{{ $lId }}</td>
                                            <td>
                                                <strong class="text-dark"><i class="bi bi-geo-alt-fill text-danger me-1"></i>{{ $lName }}</strong>
                                            </td>
                                            <td>
                                                @if(strtolower($lType) === 'pickup')
                                                    <span class="badge bg-success"><i class="bi bi-box-arrow-in-right me-1"></i> Pickup Only</span>
                                                @elseif(strtolower($lType) === 'drop')
                                                    <span class="badge bg-primary"><i class="bi bi-box-arrow-right me-1"></i> Drop Only</span>
                                                @else
                                                    <span class="badge text-white" style="background-color: #6f42c1;"><i class="bi bi-arrow-left-right me-1"></i> Both Pickup &amp; Drop</span>
                                                @endif
                                            </td>
                                            <td class="text-end text-nowrap">
                                                <div class="d-inline-flex align-items-center gap-1">
                                                    <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editLocationModal{{ $lId }}">
                                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                                    </button>
                                                    <form action="{{ route('admin.cabs.locations.destroy', $lId) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Remove this place from dropdown location directory?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Location Modal -->
                                        <div class="modal fade" id="editLocationModal{{ $lId }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.cabs.locations.update', $lId) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Location / Place — #LOC-{{ $lId }}</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold">Location / Place Name*</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $lName }}" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold">Dropdown Availability Category*</label>
                                                                <select name="type" class="form-select">
                                                                    <option value="Both" {{ $lType == 'Both' ? 'selected' : '' }}>Both Pickup &amp; Drop Dropdowns</option>
                                                                    <option value="Pickup" {{ $lType == 'Pickup' ? 'selected' : '' }}>Pickup Dropdown Only</option>
                                                                    <option value="Drop" {{ $lType == 'Drop' ? 'selected' : '' }}>Drop Dropdown Only</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Save Location Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-3 text-muted">No pickup/drop locations configured. Click "Add New Location / Place" to add one.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Location Modal -->
                <div class="modal fade" id="addLocationModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.cabs.locations.store') }}" method="POST">
                                @csrf
                                <div class="modal-header bg-info text-white">
                                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Pickup / Drop Place</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Location / Place Name*</label>
                                        <input type="text" name="name" class="form-control" placeholder="e.g., Ayodhya Dham Railway Station" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Dropdown Availability Category*</label>
                                        <select name="type" class="form-select">
                                            <option value="Both" selected>Both Pickup &amp; Drop Dropdowns</option>
                                            <option value="Pickup">Pickup Dropdown Only</option>
                                            <option value="Drop">Drop Dropdown Only</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-info text-white fw-bold"><i class="bi bi-check-circle me-1"></i> Add Location</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- BRANDED VEHICLES FLEET MANAGEMENT CARD -->
            <div class="card card-outline card-primary shadow-sm mt-4">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-truck-front-fill me-2 text-primary"></i>Branded Vehicle Models Fleet (Individual Fixed Price &amp; Active/Inactive Control)
                    </h5>
                    <div>
                        <button class="btn btn-sm btn-primary fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addVehicleModal">
                            <i class="bi bi-plus-circle me-1"></i> Add New Vehicle Model
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>#ID</th>
                                    <th>Vehicle Photo</th>
                                    <th>Vehicle Model Name</th>
                                    <th>Category &amp; Capacity</th>
                                    <th>Status (Active/Inactive)</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vehicles as $v)
                                    @php
                                        $vId = is_array($v) ? ($v['id'] ?? 1) : $v->id;
                                        $vName = is_array($v) ? ($v['name'] ?? 'Car Model') : ($v->name ?? 'Car Model');
                                        $vType = is_array($v) ? ($v['type'] ?? 'Sedan') : ($v->type ?? 'Sedan');
                                        $vCapacity = is_array($v) ? ($v['capacity'] ?? '4 Passengers + 1 Driver') : ($v->capacity ?? '4 Passengers + 1 Driver');
                                        $vPrice = is_array($v) ? ($v['price'] ?? ($v['fare'] ?? 1400)) : ($v->price ?? 1400);
                                        $vImg = is_array($v) ? ($v['image'] ?? asset('home/images/dewasharif/dewapage/cab_dzire.jpg')) : ($v->image ?? asset('home/images/dewasharif/dewapage/cab_dzire.jpg'));
                                        $vStatus = is_array($v) ? ($v['status'] ?? 'Active') : ($v->status ?? 'Active');
                                    @endphp
                                    <tr>
                                        <td>#VEH-{{ $vId }}</td>
                                        <td>
                                            <img src="{{ $vImg }}" alt="{{ $vName }}" style="width: 75px; height: 48px; object-fit: cover; border-radius: 6px; border: 1px solid #cbd5e1;">
                                        </td>
                                        <td>
                                            <strong class="text-dark d-block">{{ $vName }}</strong>
                                            <small class="text-success fw-bold">✓ dewasharif.com Branded White</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-dark">{{ $vType }}</span>
                                            <span class="badge bg-info text-dark ms-1">👥 {{ $vCapacity }}</span>
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.cabs.vehicles.toggle', $vId) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle Active/Inactive">
                                                    @if(strtolower($vStatus) === 'active')
                                                        <span class="badge bg-success" style="cursor: pointer; padding: 6px 12px; font-size: 12px;"><i class="bi bi-toggle-on me-1"></i> Active</span>
                                                    @else
                                                        <span class="badge bg-danger" style="cursor: pointer; padding: 6px 12px; font-size: 12px;"><i class="bi bi-toggle-off me-1"></i> Inactive</span>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end text-nowrap">
                                            <div class="d-inline-flex align-items-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editVehicleModal{{ $vId }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.cabs.vehicles.destroy', $vId) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Delete this vehicle model?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash me-1"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Vehicle Model Modal -->
                                    <div class="modal fade" id="editVehicleModal{{ $vId }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.cabs.vehicles.update', $vId) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header bg-primary text-white">
                                                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Vehicle Model — #VEH-{{ $vId }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body row g-3">
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Vehicle Model Name*</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $vName }}" required>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <label class="form-label fw-bold">Category / Type*</label>
                                                            <input type="text" name="type" class="form-control" value="{{ $vType }}" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Seating Capacity Details*</label>
                                                            <input type="text" name="capacity" class="form-control" value="{{ $vCapacity }}" required>
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label fw-bold">Vehicle Photo Image URL</label>
                                                            <input type="text" name="image" class="form-control" value="{{ $vImg }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Save Vehicle Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-3 text-muted">No vehicle models configured. Click "Add New Vehicle Model" to add one.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Add New Vehicle Model Modal -->
            <div class="modal fade" id="addVehicleModal" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('admin.cabs.vehicles.store') }}" method="POST">
                            @csrf
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Vehicle Model</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold">Vehicle Model Name*</label>
                                    <input type="text" name="name" class="form-control" placeholder="e.g., Dzire etc which is available (Semi Deluxe - Sedan)" required>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label fw-bold">Category / Type*</label>
                                    <input type="text" name="type" class="form-control" placeholder="e.g., Compact Sedan" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Seating Capacity Details*</label>
                                    <input type="text" name="capacity" class="form-control" placeholder="4 Passengers + 1 Driver" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-bold">Vehicle Photo Image URL</label>
                                    <input type="text" name="image" class="form-control" placeholder="/home/images/dewasharif/dewapage/cab_dzire.jpg">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-check-circle me-1"></i> Add Vehicle Model</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- DEDICATED LOCAL DEWA SHRINE E-RICKSHAW MANAGEMENT CARD -->
                <div class="card card-outline card-warning shadow-sm mt-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            <i class="bi bi-ev-front-fill me-2 text-warning"></i>Local Dewa Shrine E-Rickshaw Sightseeing
                            Service (Dewa and Nearby Visiting Places)
                        </h5><br>
                        <div>
                            @php
                                $eStatus = strtolower($erickshaw['status'] ?? 'active');
                            @endphp
                            <form action="{{ route('admin.cabs.erickshaw.toggle') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                    class="btn btn-sm {{ $eStatus === 'active' ? 'btn-success' : 'btn-danger' }} fw-bold">
                                    <i class="bi {{ $eStatus === 'active' ? 'bi-toggle-on' : 'bi-toggle-off' }} me-1"></i>
                                    Service Status: {{ strtoupper($eStatus) }} (Click to Toggle On/Off)
                                </button>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.cabs.erickshaw.toggle') }}" method="POST" class="row g-3">
                            @csrf
                            <div class="col-md-8">
                                <label class="form-label fw-bold">Full Reserve E-Rickshaw Fare (₹)</label>
                                <input type="number" step="0.01" name="full_rickshaw_fare" class="form-control"
                                    value="{{ $erickshaw['full_rickshaw_fare'] ?? 150 }}" required>
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-warning fw-bold w-100">
                                    <i class="bi bi-check-circle-fill me-1"></i> Save E-Rickshaw Fares
                                </button>
                            </div>
                            <div class="col-12">
                                <small class="text-muted"><i class="bi bi-info-circle me-1"></i> Yeh service customer
                                    frontend par <strong>"Local Dewa Shrine E-Rickshaw Sightseeing (Dewa and Nearby Visiting
                                        Places)"</strong> badge card me dikhti hai. Admin ise single click se
                                    Active/Inactive toggle kar sakta hai.</small>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- AIRPORT & SIGHTSEEING PARKING POLICY INSTRUCTIONS CARD -->
                <div class="card card-outline card-warning shadow-sm mt-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0 fw-bold text-dark">
                            <i class="bi bi-info-circle-fill me-2 text-warning"></i>Airport &amp; Sightseeing Parking Policy Instructions
                        </h5>
                        <span class="badge {{ ($parkingPolicy['status'] ?? 'Active') === 'Active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ $parkingPolicy['status'] ?? 'Active' }}
                        </span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.cabs.parking.update') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="status" id="parkingPolicyStatus" value="Active" {{ ($parkingPolicy['status'] ?? 'Active') === 'Active' ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="parkingPolicyStatus">Enable Parking Instruction Note on Checkout, Voucher PDF &amp; WhatsApp</label>
                                    </div>
                                    <small class="text-muted d-block mt-1">When active, this instruction note is clearly displayed on Airport and Sightseeing bookings. Note: This charge is NOT added to the online bill, but paid directly by passenger as per actual receipt.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">✈️ Airport Parking Instruction Note:</label>
                                    <textarea name="airport_note" class="form-control" rows="3" required>{{ $parkingPolicy['airport_note'] ?? 'Airport entry & waiting: Initial 10 minutes free. Exceeding 10 mins parking charges payable by passenger directly as per actual airport parking receipt.' }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">🏛️ Lucknow Sightseeing Tour Parking Note:</label>
                                    <textarea name="sightseeing_note" class="form-control" rows="3" required>{{ $parkingPolicy['sightseeing_note'] ?? 'City Sightseeing Tour: Historical monument & tourist spot parking charges payable by passenger as per actual receipt.' }}</textarea>
                                </div>
                                <div class="col-12 text-end">
                                    <button type="submit" class="btn btn-warning fw-bold px-4">
                                        <i class="bi bi-save me-1"></i> Save Parking Policy Settings
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- CAB LOCATIONS DIRECTORY MANAGEMENT CARD -->
                <div class="card card-outline card-primary shadow-sm mt-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0 fw-bold text-dark">
                                <i class="bi bi-geo-alt-fill me-2 text-primary"></i>Cab Pickup &amp; Drop Locations Directory
                            </h5>
                            <small class="text-muted d-block mt-1">Manage allowed station, airport &amp; outstation locations shown in frontend calculator dropdowns.</small>
                        </div>
                        <button class="btn btn-primary btn-sm fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#addLocationModal">
                            <i class="bi bi-plus-circle me-1"></i> Add New Location
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle mb-0">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#ID</th>
                                        <th>Location Name</th>
                                        <th>Allowed Purpose</th>
                                        <th>Status</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($locations as $loc)
                                        @php
                                            $lId = is_array($loc) ? ($loc['id'] ?? 1) : $loc->id;
                                            $lName = is_array($loc) ? ($loc['name'] ?? 'Location') : ($loc->name ?? 'Location');
                                            $lType = is_array($loc) ? ($loc['type'] ?? 'Both') : ($loc->type ?? 'Both');
                                            $lStatus = is_array($loc) ? ($loc['status'] ?? 'Active') : ($loc->status ?? 'Active');
                                        @endphp
                                        <tr>
                                            <td>#LOC-{{ $lId }}</td>
                                            <td>
                                                <strong class="text-dark fs-6">{{ $lName }}</strong>
                                            </td>
                                            <td>
                                                @if(strtolower($lType) === 'both')
                                                    <span class="badge bg-success"><i class="bi bi-arrow-left-right me-1"></i> Pickup &amp; Drop Both</span>
                                                @elseif(strtolower($lType) === 'pickup')
                                                    <span class="badge bg-primary"><i class="bi bi-box-arrow-in-right me-1"></i> Pickup Only</span>
                                                @else
                                                    <span class="badge bg-info text-dark"><i class="bi bi-box-arrow-right me-1"></i> Drop Only</span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-success">{{ $lStatus }}</span>
                                            </td>
                                            <td class="text-end text-nowrap">
                                                <div class="d-inline-flex align-items-center gap-2">
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#editLocationModal{{ $lId }}">
                                                        <i class="bi bi-pencil-square me-1"></i> Edit
                                                    </button>
                                                    <form action="{{ route('admin.cabs.locations.destroy', $lId) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Delete this location from directory?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="bi bi-trash me-1"></i> Delete
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Location Modal -->
                                        <div class="modal fade" id="editLocationModal{{ $lId }}" tabindex="-1">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.cabs.locations.update', $lId) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Edit Location — #LOC-{{ $lId }}</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body row g-3">
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold">Location Name*</label>
                                                                <input type="text" name="name" class="form-control" value="{{ $lName }}" required>
                                                            </div>
                                                            <div class="col-12">
                                                                <label class="form-label fw-bold">Allowed Purpose*</label>
                                                                <select name="type" class="form-select">
                                                                    <option value="Both" {{ strtolower($lType) === 'both' ? 'selected' : '' }}>Pickup &amp; Drop Both</option>
                                                                    <option value="Pickup" {{ strtolower($lType) === 'pickup' ? 'selected' : '' }}>Pickup Only</option>
                                                                    <option value="Drop" {{ strtolower($lType) === 'drop' ? 'selected' : '' }}>Drop Only</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-save me-1"></i> Save Changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-3 text-muted">No custom locations added yet. Click "Add New Location" above.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Add Location Modal -->
                <div class="modal fade" id="addLocationModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('admin.cabs.locations.store') }}" method="POST">
                                @csrf
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Cab Location</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body row g-3">
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Location Name*</label>
                                        <input type="text" name="name" class="form-control" placeholder="e.g. Lucknow Charbagh Railway Station / Dewa Sharif" required>
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label fw-bold">Allowed Purpose*</label>
                                        <select name="type" class="form-select">
                                            <option value="Both" selected>Pickup &amp; Drop Both</option>
                                            <option value="Pickup">Pickup Only</option>
                                            <option value="Drop">Drop Only</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-check-circle me-1"></i> Add Location</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Add Cab Route Modal -->
    <div class="modal fade" id="addCabRouteModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('admin.cabs.route.store') }}" method="POST">
                    @csrf
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Add New Cab Route &amp; Driver Fleet
                            Verification</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Route Name / Description*</label>
                            <input type="text" name="route_name" class="form-control"
                                placeholder="e.g., Lucknow Airport to Dewa Sharif Dargah" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">AC / Cooling Option*</label>
                            <select name="ac_option" id="add_ac_option" class="form-select ac-option-select"
                                data-target-vehicle="#add_vehicle_type">
                                <option value="AC" selected>❄️ AC (Air Conditioned)</option>
                                <option value="Non-AC">🌿 Non-AC</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Vehicle Category / Type*</label>
                            <select name="vehicle_type" id="add_vehicle_type" class="form-select vehicle-type-select"
                                data-target="#add_seating_capacity">
                                <option value="Omni Van (Standard)" data-ac="both"
                                    data-capacity="7 Passengers + 1 Driver (Total 8)">Omni Van (Standard)</option>
                                <option value="Dzire etc which is available (Semi Deluxe - Sedan)" data-ac="both"
                                    data-capacity="4 Passengers + 1 Driver (Total 5)" selected>Dzire etc which is available
                                    (Semi Deluxe - Sedan)</option>
                                {{-- <option value="Verna etc which is available (Deluxe - Sedan)" data-ac="both"
                                    data-capacity="4 Passengers + 1 Driver (Total 5)">Verna etc which is available (Deluxe -
                                    Sedan)</option> --}}
                                <option value="Ertiga etc which is available (SUV)" data-ac="both"
                                    data-capacity="7 Passengers + 1 Driver (Total 8)">Ertiga etc which is available (SUV)
                                </option>
                                <option value="Mahindra Pickup (Goods & Dala)" data-ac="both"
                                    data-capacity="1 Passengers + 1 Driver + Goods">Mahindra Pickup (Goods &amp; Dala)
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Seating Capacity with Driver</label>
                            <input type="text" name="seating_capacity" id="add_seating_capacity" class="form-control"
                                placeholder="4 Passengers + 1 Driver (Total 5)" value="4 Passengers + 1 Driver (Total 5)">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Pickup Location*</label>
                            <input type="text" name="pickup" class="form-control"
                                placeholder="Lucknow Airport / Railway Station" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Destination Location*</label>
                            <input type="text" name="destination" class="form-control" placeholder="Dewa Sharif Dargah"
                                required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Vehicle Model / Name <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="text" name="vehicle_name" class="form-control"
                                placeholder="e.g., Maruti Swift Dzire">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Vehicle Number Plate <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="text" name="vehicle_number" class="form-control" placeholder="e.g., UP 32 AB 1234">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Total Route Fare (₹)*</label>
                            <input type="number" step="0.01" name="price" class="form-control" placeholder="1499" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Toll Tax &amp; Parking Status*</label>
                            <select name="toll_status" class="form-select">
                                <option value="Toll Tax Included">Toll Tax Included in Fare</option>
                                <option value="Extra at Toll Booth">Extra at Toll Booth</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Driver Name <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="text" name="driver_name" class="form-control" placeholder="Ramesh Kumar">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Driver Phone / WhatsApp <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="text" name="driver_phone" class="form-control" placeholder="9876543210">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-primary">Driver Aadhaar Card No <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="text" name="driver_aadhaar" class="form-control" placeholder="1234 5678 9012">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-secondary">Driver Driving License (DL) No <span class="text-muted fw-normal">(Optional)</span></label>
                            <input type="text" name="driver_dl" class="form-control" placeholder="UP32-2022-0089123">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success fw-bold"><i class="bi bi-check-circle me-1"></i> Save
                            Cab Route &amp; Fleet</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function filterVehicleOptions(acSelectEl) {
                var targetVehicleId = acSelectEl.getAttribute('data-target-vehicle');
                var vehicleSelect = targetVehicleId ? document.querySelector(targetVehicleId) : acSelectEl.closest('.modal-body, form').querySelector('.vehicle-type-select');
                if (!vehicleSelect) return;
                Array.from(vehicleSelect.options).forEach(function (opt) {
                    opt.style.display = '';
                    opt.disabled = false;
                });
                return;
                var acValue = (acSelectEl.value || '').toLowerCase();
                var targetVehicleId = acSelectEl.getAttribute('data-target-vehicle');
                var vehicleSelect = targetVehicleId ? document.querySelector(targetVehicleId) : acSelectEl.closest('.modal-body, form').querySelector('.vehicle-type-select');
                if (!vehicleSelect) return;

                var firstValidOption = null;
                var hasSelectedVisible = false;

                Array.from(vehicleSelect.options).forEach(function (opt) {
                    var acTag = (opt.getAttribute('data-ac') || 'both').toLowerCase();
                    var show = false;

                    if (acValue === 'non-ac') {
                        if (acTag === 'non-ac' || acTag === 'both') {
                            show = true;
                        }
                    } else {
                        if (acTag === 'ac' || acTag === 'both') {
                            show = true;
                        }
                    }

                    if (show) {
                        opt.style.display = '';
                        opt.disabled = false;
                        if (!firstValidOption) firstValidOption = opt;
                        if (opt.selected) hasSelectedVisible = true;
                    } else {
                        opt.style.display = 'none';
                        opt.disabled = true;
                    }
                });

                if (!hasSelectedVisible && firstValidOption) {
                    vehicleSelect.value = firstValidOption.value;
                    vehicleSelect.dispatchEvent(new Event('change'));
                }
            }

            document.querySelectorAll('.ac-option-select').forEach(function (acEl) {
                acEl.addEventListener('change', function () {
                    filterVehicleOptions(this);
                });
                filterVehicleOptions(acEl);
            });

            document.querySelectorAll('.vehicle-type-select').forEach(function (selectEl) {
                selectEl.addEventListener('change', function () {
                    var targetId = this.getAttribute('data-target');
                    var selectedOption = this.options[this.selectedIndex];
                    if (selectedOption && !selectedOption.disabled) {
                        var capacity = selectedOption.getAttribute('data-capacity');
                        if (targetId && capacity) {
                            var targetInput = document.querySelector(targetId);
                            if (targetInput) {
                                targetInput.value = capacity;
                            }
                        }
                    }
                });
            });

            document.querySelectorAll('.modal').forEach(function (modalEl) {
                modalEl.addEventListener('shown.bs.modal', function () {
                    var acEl = modalEl.querySelector('.ac-option-select');
                    if (acEl) filterVehicleOptions(acEl);
                });
            });
        });
    </script>
@endsection