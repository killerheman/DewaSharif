@extends('admin.includes.master')

@section('title', 'Manage Sacred Shop Products | DewaSharif Admin')

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
        transition: all 0.25s ease-in-out;
    }
    .btn-gradient-green:hover {
        background: linear-gradient(135deg, #047857 0%, #059669 50%, #10b981 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 5px 14px rgba(16, 185, 129, 0.5);
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
        font-weight: 700;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 6px rgba(4, 120, 87, 0.35);
    }
    .badge-gradient-blue {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #3b82f6 100%) !important;
        color: #ffffff !important;
        font-weight: 600;
        padding: 6px 12px;
        box-shadow: 0 2px 6px rgba(37, 99, 235, 0.35);
    }
    .badge-gradient-red {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 50%, #991b1b 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 5px rgba(220, 38, 38, 0.35);
    }
    .badge-gradient-yellow {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 50%, #d97706 100%) !important;
        color: #1e1b4b !important;
        font-weight: 700;
        box-shadow: 0 2px 5px rgba(245, 158, 11, 0.35);
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
                        <i class="bi bi-box-seam text-success me-2"></i><span class="title-gradient-green">Sacred Shop Product Catalogue</span>
                    </h3>
                    <small class="text-muted">Manage Attar, Mitti Bartan, Islamic Items &amp; Degh Niyaz Offerings (Live DB)</small>
                </div>
                <div class="col-sm-6 text-end">
                    <button class="btn btn-outline-primary me-2 rounded-pill px-3 py-2 fw-bold shadow-xs" data-bs-toggle="modal" data-bs-target="#globalSettingsModal">
                        <i class="bi bi-gear-fill me-1"></i> Delivery &amp; Fee Settings
                    </button>
                    <a href="{{ route('admin.shop.categories') }}" class="btn btn-outline-success me-2 rounded-pill px-3 py-2 fw-bold shadow-xs">
                        <i class="bi bi-tags-fill me-1"></i> Manage Categories
                    </a>
                    <button class="btn btn-gradient-green fw-bold px-3 py-2 shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addProductModal">
                        <i class="bi bi-plus-circle me-1"></i> Add New Product
                    </button>
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

            <style>
.cat-filter-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
}
.cat-filter-card:active {
    transform: scale(0.99);
}

/* TALL & BALANCED MODAL STYLING FOR ADD & EDIT PRODUCT (NO HORIZONTAL STRIP LOOK) */
.product-modal-dialog {
    max-width: 980px !important;
    width: 94vw !important;
    margin: 2.5vh auto !important;
    height: 95vh !important;
}
.product-modal-dialog .modal-content {
    height: 95vh !important;
    max-height: 95vh !important;
    display: flex !important;
    flex-direction: column !important;
}
.product-modal-dialog .modal-header {
    flex-shrink: 0 !important;
}
.product-modal-dialog .modal-body {
    flex: 1 1 auto !important;
    overflow-y: auto !important;
    max-height: none !important;
    padding: 1.5rem !important;
}
.product-modal-dialog .modal-footer {
    flex-shrink: 0 !important;
}
</style>
<!-- QUICK CATEGORY ACTIVE/INACTIVE BAR & FILTER (3 PER ROW, CURATED 5-COLOR SYSTEM) -->
            <div class="card shadow-sm border-0 rounded-4 mb-4" style="background: #ffffff; border-top: 4px solid #10b981 !important;">
                <div class="card-body p-3 p-md-4">
                    <!-- Header Bar -->
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom">
                        <div>
                            <h5 class="fw-bold text-dark mb-1 d-flex align-items-center">
                                <i class="bi bi-funnel-fill text-success me-2 fs-5"></i> Category Quick Switch &amp; Filter
                            </h5>
                            <small class="text-muted">Click any category card below to filter products in real-time. Click <strong>✓ Live / ⏳ Soon</strong> badge to toggle instant store visibility.</small>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <button type="button" 
                                    class="btn btn-sm px-3 py-1.5 rounded-pill fw-bold shadow-xs cat-all-btn active" 
                                    id="btnFilterAll" 
                                    onclick="filterCategoryTable('all', this)"
                                    style="background: #1e293b; color: #ffffff; border: 1.5px solid #1e293b; font-size: 13px; transition: all 0.2s ease;">
                                <i class="bi bi-grid-fill me-1"></i> All Products ({{ count($products) }})
                            </button>
                            <a href="{{ route('admin.shop.categories') }}" class="btn btn-sm btn-outline-success rounded-pill px-3 py-1.5 fw-bold shadow-xs" style="font-size: 13px;">
                                <i class="bi bi-gear-wide-connected me-1"></i> Manage Details →
                            </a>
                        </div>
                    </div>

                    <!-- 3 Categories Per Row Grid -->
                    @php
                        // Curated 5-Color System: Green, Blue, Yellow, Red, Gray
                        $colorPaletteMap = [
                            'degh-niyaz-langar' => '#059669', // Green
                            'food-health' => '#059669',       // Green

                            'islamic-products' => '#2563eb',  // Blue
                            'electronics' => '#0284c7',       // Sky Blue
                            'home-appliances' => '#1d4ed8',   // Royal Blue

                            'warsi-attar-khushbu' => '#d97706',   // Yellow / Amber
                            'mitti-bartan-clay-pots' => '#b45309', // Warm Amber
                            'jewellery' => '#f59e0b',             // Gold / Yellow
                            'pets-food-accessories' => '#d97706', // Yellow / Amber

                            'beauty' => '#e11d48',                // Red / Rose
                            'sufi-clothing-attire' => '#be123c',  // Deep Crimson Red
                            'scenery-paintings-calligraphy' => '#dc2626', // Vibrant Red
                            'toys' => '#e11d48',                  // Red
                        ];
                        $fallbackColors = ['#059669', '#2563eb', '#d97706', '#e11d48', '#475569'];
                    @endphp

                    <div class="row" style="--bs-gutter-x: 12px; --bs-gutter-y: 12px;">
                        @foreach($categories as $idx => $sc)
                            @php
                                $isCatActive = strtolower($sc->status ?? 'active') === 'active';
                                $themeColor = $colorPaletteMap[$sc->slug] ?? $fallbackColors[$idx % count($fallbackColors)];
                            @endphp
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="cat-filter-card p-2.5 px-3 rounded-3 d-flex align-items-center justify-content-between h-100 shadow-xs"
                                     data-cat="{{ $sc->slug }}"
                                     data-color="{{ $themeColor }}"
                                     onclick="filterCategoryTable('{{ $sc->slug }}', this)"
                                     style="cursor: pointer; background: #ffffff; border: 1.5px solid {{ $themeColor }}; transition: all 0.22s cubic-bezier(0.4, 0, 0.2, 1); min-height: 48px;">
                                    
                                    <!-- Left: Dot + Category Name -->
                                    <div class="d-flex align-items-center me-2 overflow-hidden flex-grow-1">
                                        <span class="cat-indicator-dot me-2 rounded-circle flex-shrink-0" style="width: 10px; height: 10px; background: {{ $themeColor }}; transition: all 0.2s ease;"></span>
                                        <span class="cat-name-text fw-bold text-truncate" style="color: {{ $themeColor }}; font-size: 13.5px;" title="{{ $sc->name }}">
                                            {{ $sc->name }}
                                        </span>
                                    </div>

                                    <!-- Right: Live / Soon Switch Button -->
                                    <div class="flex-shrink-0 ms-2" onclick="event.stopPropagation();">
                                        <form action="{{ route('admin.shop.categories.toggle', $sc->id) }}" method="POST" class="m-0 p-0">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm py-1 px-2.5 rounded-pill fw-bold border-0 shadow-xs cat-status-badge"
                                                    style="{{ $isCatActive ? 'background: #10b981; color: #ffffff;' : 'background: #f1f5f9; color: #64748b; border: 1px solid #cbd5e1 !important;' }}; font-size: 11px;"
                                                    title="Click to toggle {{ $sc->name }} Live / Soon">
                                                {{ $isCatActive ? '✓ Live' : '⏳ Soon' }}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card card-outline card-primary shadow border-0 rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>E-Commerce Products &amp; Offerings Inventory
                    </h5>
                    <span class="badge btn-gradient-navy px-3 py-2 rounded-pill">Total Items: {{ count($products) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-aligned">
                            <thead class="custom-table-header">
                                <tr>
                                    <th class="ps-3">#ID / SKU</th>
                                    <th>Product Item</th>
                                    <th>Category</th>
                                    <th>Price / MRP (% OFF)</th>
                                    <th>Stock</th>
                                    <th>Policy</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    @php
                                        $cat = is_array($product) ? ($product['category'] ?? ($product['category_slug'] ?? 'attar')) : ($product->category ?? ($product->category_slug ?? 'attar'));
                                        $isDegh = $cat === 'degh';
                                        $prodId = is_array($product) ? ($product['id'] ?? 1) : $product->id;
                                        $prodSku = is_array($product) ? ($product['sku'] ?? null) : ($product->sku ?? null);
                                        $prodPolicy = is_array($product) ? ($product['return_policy'] ?? 'non_returnable') : ($product->return_policy ?? 'non_returnable');
                                        
                                        $rawImg = is_array($product) ? ($product['image'] ?? ($product['thumbnail'] ?? '')) : ($product->image ?? ($product->thumbnail ?? ''));
                                        $imgSrc = preg_replace('#^https?://[^/]+#', '', $rawImg);
                                        $imgSrc = '/' . ltrim($imgSrc, '/');

                                        $pPrice = (float)(is_array($product) ? ($product['price'] ?? 299) : $product->price);
                                        $pMrp = (float)(is_array($product) ? ($product['mrp'] ?? $pPrice) : ($product->mrp ?? $pPrice));
                                        $customOff = is_array($product) ? ($product['discount_percent'] ?? null) : ($product->discount_percent ?? null);
                                        $pOff = (!empty($customOff) && (int)$customOff > 0) ? (int)$customOff : (($pMrp > $pPrice) ? round((($pMrp - $pPrice) / $pMrp) * 100) : 0);
                                        
                                        $matchedCat = collect($categories)->firstWhere('slug', $cat);
                                        $catName = $matchedCat ? $matchedCat->name : ucfirst($cat);
                                        $catColor = $matchedCat->theme_color ?? ($isDegh ? '#10b981' : '#3b82f6');
                                    @endphp
                                    <tr class="prod-row cat-row-{{ $cat }}" data-cat="{{ $cat }}">
                                        <td class="ps-3">
                                             <strong class="text-dark font-mono d-block">{{ $isDegh ? '#DGH-' : '#PRD-' }}{{ $prodId }}</strong>
                                            @if(!empty($prodSku))
                                                <small class="badge bg-light text-secondary border font-mono" style="font-size: 10px;">{{ $prodSku }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ $imgSrc }}" onerror="this.onerror=null; this.src='/home/images/dewasharif/dewapage/{{ $isDegh ? 'degh_niyaz.jpg' : 'attar_bottle.jpg' }}';" class="rounded-3 me-2 border" style="width: 48px; height: 48px; object-fit: cover;">
                                                <div>
                                                    <strong class="d-block text-dark">{{ is_array($product) ? ($product['name'] ?? 'Product') : $product->name }}</strong>
                                                    <small class="text-muted">{{ is_array($product) ? ($product['volume_ml'] ?? ($product['fabric_material'] ?? 'Pure Quality')) : ($product->volume_ml ?? 'Pure Quality') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge text-uppercase px-2.5 py-1.5 shadow-xs" style="background: {{ $catColor }}; color: #ffffff;">
                                                {{ $catName }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong class="text-success fs-6 fw-bold">₹{{ number_format($pPrice, 2) }}</strong>
                                            @if($pOff > 0 || $pMrp > $pPrice)
                                                <div class="d-flex align-items-center gap-1 mt-0.5">
                                                    @if($pMrp > $pPrice)
                                                        <small class="text-muted text-decoration-line-through">₹{{ number_format($pMrp, 2) }}</small>
                                                    @endif
                                                    @if($pOff > 0)
                                                        <span class="badge bg-danger-subtle text-danger fw-bold border border-danger-subtle px-1.5 py-0.5" style="font-size: 10.5px;">
                                                            🔥 {{ $pOff }}% OFF
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                            <div class="mt-1 small" style="font-size: 10.5px; color: #64748b; line-height: 1.3;">
                                                <span title="Handling Fee">🛡️ ₹{{ number_format((float)(is_array($product) ? ($product['handling_fee'] ?? 10) : ($product->handling_fee ?? 10)), 0) }}</span> | 
                                                <span title="Packaging Fee">📦 ₹{{ number_format((float)(is_array($product) ? ($product['packaging_fee'] ?? 20) : ($product->packaging_fee ?? 20)), 0) }}</span> | 
                                                <span title="Courier Fee">🚚 ₹{{ number_format((float)(is_array($product) ? ($product['delivery_fee'] ?? 40) : ($product->delivery_fee ?? 40)), 0) }}</span>
                                            </div>
                                        </td>
                                        @php
                                            $adminStock = (int)(is_array($product) ? ($product['stock_quantity'] ?? ($product['stock'] ?? 0)) : ($product->stock_quantity ?? ($product->stock ?? 0)));
                                        @endphp
                                        <td>
                                            @if($adminStock <= 0)
                                                <span class="badge bg-danger shadow-sm px-2.5" style="height: 30px; display: inline-flex; align-items: center; font-weight: 800; font-size: 0.78rem;">
                                                    <i class="bi bi-x-circle-fill me-1"></i> Out of Stock
                                                </span>
                                            @elseif($adminStock <= 5)
                                                <span class="badge badge-gradient-yellow text-dark shadow-sm px-2.5" style="height: 30px; display: inline-flex; align-items: center; font-weight: 800; font-size: 0.78rem;">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Low Stock ({{ $adminStock }})
                                                </span>
                                            @else
                                                <span class="badge badge-gradient-green shadow-sm px-2.5" style="height: 30px; display: inline-flex; align-items: center; font-weight: 700; font-size: 0.78rem;">
                                                    <i class="bi bi-check-circle-fill me-1"></i> {{ $adminStock }} In Stock
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($prodPolicy === 'non_returnable')
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 py-1" style="font-size: 11px;" title="Non-Returnable: Sacred Tabarruk / Food">
                                                    <i class="bi bi-shield-x me-1"></i>No Return
                                                </span>
                                            @elseif($prodPolicy === 'replacement_48h')
                                                <span class="badge bg-warning-subtle text-dark border border-warning-subtle px-2 py-1" style="font-size: 11px;" title="48 Hours Transit Damage Replacement">
                                                    <i class="bi bi-arrow-repeat me-1"></i>48h Replace
                                                </span>
                                            @elseif($prodPolicy === 'exchange_7d')
                                                <span class="badge bg-info-subtle text-primary border border-info-subtle px-2 py-1" style="font-size: 11px;" title="7 Days Size Exchange">
                                                    <i class="bi bi-arrow-left-right me-1"></i>7d Exchange
                                                </span>
                                            @elseif($prodPolicy === 'return_7d')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1" style="font-size: 11px;" title="7 Days Return & Refund">
                                                    <i class="bi bi-arrow-counterclockwise me-1"></i>7d Return
                                                </span>
                                            @else
                                                <span class="badge bg-secondary-subtle text-secondary border px-2 py-1" style="font-size: 11px;">
                                                    Final Sale
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.shop.product.toggle', $prodId) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle Active/Inactive">
                                                    @if(strtolower(is_array($product) ? ($product['status'] ?? 'active') : ($product->status ?? 'active')) === 'active')
                                                        <span class="badge badge-gradient-green px-2.5 shadow-sm" style="cursor: pointer; height: 30px; display: inline-flex; align-items: center;"><i class="bi bi-toggle-on me-1 fs-6"></i> Active</span>
                                                    @else
                                                        <span class="badge bg-secondary px-2.5 shadow-sm" style="cursor: pointer; height: 30px; display: inline-flex; align-items: center;"><i class="bi bi-toggle-off me-1 fs-6"></i> Inactive</span>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="btn-group shadow-sm rounded-3 overflow-hidden" style="height: 32px;">
                                                <button class="btn btn-sm btn-gradient-navy px-3 font-bold d-inline-flex align-items-center" style="height: 32px;" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $prodId }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.shop.destroy', $prodId) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product item?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-gradient-red px-2.5 d-inline-flex align-items-center justify-content-center" style="height: 32px; border-radius: 0;" title="Delete Product">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- Edit Product Modal -->
                                    <div class="modal fade" id="editProductModal{{ $prodId }}" tabindex="-1">
                                        <div class="modal-dialog product-modal-dialog modal-dialog-scrollable">
                                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                                <form action="{{ route('admin.shop.product.update', $prodId) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header btn-gradient-navy text-white py-3 px-4">
                                                        <h5 class="modal-title fw-bold d-flex align-items-center">
                                                            <i class="bi bi-pencil-square me-2"></i>Edit Product: {{ is_array($product) ? ($product['name'] ?? '') : $product->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body p-4 text-start">
                                                        <div class="row g-3">
                                                            <!-- Row 1: Name & SKU -->
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-tag-fill text-primary me-1"></i> Product Name*</label>
                                                                <input type="text" name="name" class="form-control" value="{{ is_array($product) ? ($product['name'] ?? '') : $product->name }}" required>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-upc-scan text-secondary me-1"></i> SKU / Item Code</label>
                                                                <input type="text" name="sku" class="form-control font-mono" value="{{ $prodSku }}" placeholder="e.g. #ATT-01">
                                                            </div>

                                                            <!-- Row 2: Category & Return Policy -->
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-grid-fill text-success me-1"></i> Category*</label>
                                                                <select name="category" class="form-select fw-bold">
                                                                    @foreach($categories as $c)
                                                                        <option value="{{ $c->slug }}" {{ ((is_array($product) ? ($product['category'] ?? ($product['category_slug'] ?? '')) : ($product->category ?? ($product->category_slug ?? ''))) == $c->slug) ? 'selected' : '' }}>
                                                                            {{ $c->name }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-shield-check text-info me-1"></i> Return / Replacement Policy*</label>
                                                                <select name="return_policy" class="form-select fw-bold">
                                                                    <option value="non_returnable" {{ $prodPolicy === 'non_returnable' ? 'selected' : '' }}>🛡️ Non-Returnable (Sacred Tabarruk / Food / Niyaz)</option>
                                                                    <option value="replacement_48h" {{ $prodPolicy === 'replacement_48h' ? 'selected' : '' }}>🔄 Replacement Only (48h Transit Damage / Fragile)</option>
                                                                    <option value="exchange_7d" {{ $prodPolicy === 'exchange_7d' ? 'selected' : '' }}>📦 7 Days Size Exchange (Clothing / Wearables)</option>
                                                                    <option value="return_7d" {{ $prodPolicy === 'return_7d' ? 'selected' : '' }}>↩️ 7 Days Return &amp; Refund (Retail Items)</option>
                                                                    <option value="no_return" {{ $prodPolicy === 'no_return' ? 'selected' : '' }}>🚫 Final Sale - No Return / No Replacement</option>
                                                                </select>
                                                            </div>

                                                            <!-- Row 3: Selling Price & MRP Price -->
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-success mb-1"><i class="bi bi-currency-rupee me-1"></i> Selling Price (₹)*</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text fw-bold text-success bg-success-subtle border-success-subtle">₹</span>
                                                                    <input type="number" step="0.01" name="price" id="edit_price_{{ $prodId }}" oninput="calcEditDiscount({{ $prodId }})" class="form-control fw-bold text-success" value="{{ $pPrice }}" required>
                                                                </div>
                                                                <small class="text-muted" style="font-size: 11px;">Final discounted selling price customer pays</small>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-secondary mb-1"><i class="bi bi-tags me-1"></i> Original MRP Price (₹)</label>
                                                                <div class="input-group">
                                                                    <span class="input-group-text fw-bold text-secondary bg-light">₹</span>
                                                                    <input type="number" step="0.01" name="mrp" id="edit_mrp_{{ $prodId }}" oninput="calcEditDiscount({{ $prodId }})" class="form-control fw-bold text-secondary" value="{{ $pMrp }}" placeholder="e.g. 399">
                                                                </div>
                                                                <small class="text-muted" style="font-size: 11px;">Original market / printed MRP price</small>
                                                            </div>

                                                            <!-- Row 4: Discount % & Stock Quantity -->
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-danger mb-1"><i class="bi bi-fire me-1"></i> Discount % OFF (Auto or Custom)</label>
                                                                <div class="input-group">
                                                                    <input type="number" step="1" min="0" max="99" name="discount_percent" id="edit_off_{{ $prodId }}" oninput="onEditDiscountInput({{ $prodId }})" class="form-control fw-bold text-danger" value="{{ is_array($product) ? ($product['discount_percent'] ?? $pOff) : ($product->discount_percent ?? $pOff) }}" placeholder="e.g. 25">
                                                                    <span class="input-group-text fw-bold text-danger bg-danger-subtle border-danger-subtle">% OFF</span>
                                                                </div>
                                                                <small class="text-muted" style="font-size: 11px;">Type custom % or auto-calculated from Price/MRP</small>
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-boxes text-primary me-1"></i> Stock Quantity*</label>
                                                                <div class="input-group">
                                                                    <input type="number" name="stock" class="form-control fw-bold" value="{{ $adminStock }}" required min="0">
                                                                    <span class="input-group-text text-muted bg-light">Units</span>
                                                                </div>
                                                                <small class="text-muted" style="font-size: 11px;">Units currently in stock</small>
                                                            </div>

                                                            <!-- Row 5: Volume / Weight & Fabric / Material -->
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-droplet-half text-info me-1"></i> Volume ML / Weight / Pack Size</label>
                                                                <input type="text" name="volume_ml" class="form-control" value="{{ is_array($product) ? ($product['volume_ml'] ?? '') : ($product->volume_ml ?? '') }}" placeholder="e.g. 12ml / 50 Kg / 500g">
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-layers text-secondary me-1"></i> Fabric / Material</label>
                                                                <input type="text" name="fabric_material" class="form-control" value="{{ is_array($product) ? ($product['fabric_material'] ?? '') : ($product->fabric_material ?? '') }}" placeholder="e.g. Pure Clay / Pure Brass / Velvet">
                                                            </div>

                                                            <!-- Row 6: Size Options & Star Rating -->
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-sliders text-warning me-1"></i> Size Options</label>
                                                                <input type="text" name="size_options" class="form-control" value="{{ is_array($product) ? ($product['size_options'] ?? '') : ($product->size_options ?? '') }}" placeholder="e.g. 6ml, 12ml, 25ml or S, M, L">
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-warning-emphasis mb-1"><i class="bi bi-star-fill text-warning me-1"></i> Star Rating (1.0 to 5.0)</label>
                                                                <input type="number" step="0.1" min="1.0" max="5.0" name="rating" class="form-control" value="{{ is_array($product) ? ($product['rating'] ?? 5.0) : ($product->rating ?? 5.0) }}" placeholder="5.0">
                                                            </div>

                                                            <!-- Row 7: Reviews & Featured Status -->
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-chat-quote-fill text-primary me-1"></i> Reviews / Bookings Text</label>
                                                                <input type="text" name="reviews_count" class="form-control" value="{{ is_array($product) ? ($product['reviews_count'] ?? '240+ Niyaz Bookings') : ($product->reviews_count ?? '240+ Niyaz Bookings') }}" placeholder="e.g. 240+ Niyaz Bookings">
                                                            </div>
                                                            <div class="col-md-6 col-12">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-award-fill text-warning me-1"></i> Featured Product Status</label>
                                                                <div class="form-check form-switch p-2 bg-light rounded-3 border d-flex align-items-center" style="min-height: 38px;">
                                                                    <input class="form-check-input ms-1 me-3 fs-5" type="checkbox" name="is_featured" value="1" id="edit_featured_{{ $prodId }}" {{ !empty(is_array($product) ? ($product['is_featured'] ?? null) : ($product->is_featured ?? null)) ? 'checked' : '' }}>
                                                                    <label class="form-check-label fw-bold small text-dark mb-0" for="edit_featured_{{ $prodId }}">
                                                                        ⭐ Mark as Featured (Highlight on Sacred Bazaar)
                                                                    </label>
                                                                </div>
                                                            </div>

                                                            <!-- 5 OPTIONAL PRODUCT IMAGES & GALLERY (1 ROW ME 2 - COL-6) -->
                                                            @php
                                                                $rawGal = is_array($product) ? ($product['gallery_images'] ?? '[]') : ($product->gallery_images ?? '[]');
                                                                $prodGallery = is_array($rawGal) ? $rawGal : (json_decode($rawGal, true) ?: []);
                                                            @endphp
                                                            <div class="col-12 my-2">
                                                                <div class="card p-4 rounded-4 border shadow-sm" style="background: #f8fafc; border: 1.5px solid #cbd5e1 !important;">
                                                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom">
                                                                        <div>
                                                                            <h6 class="fw-bold text-dark mb-1 d-flex align-items-center">
                                                                                <i class="bi bi-images text-primary me-2 fs-5"></i> Product Photos &amp; Gallery (Up to 5 Images, Optional)
                                                                            </h6>
                                                                            <small class="text-muted">Aap 1 se lekar 5 tak images upload kar sakte hain. Jitni upload karenge utni hi product gallery me show hongi.</small>
                                                                        </div>
                                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 rounded-pill fw-bold">
                                                                            1 to 5 Photos Supported
                                                                        </span>
                                                                    </div>

                                                                    <!-- Quick Multi-Upload Banner -->
                                                                    <div class="p-3 mb-4 rounded-3 border shadow-xs" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfeff 100%); border: 1.5px dashed #10b981 !important;">
                                                                        <div class="row align-items-center">
                                                                            <div class="col-md-5 col-12 mb-2 mb-md-0">
                                                                                <span class="fw-bold text-success d-flex align-items-center mb-1">
                                                                                    <i class="bi bi-cloud-arrow-up-fill fs-5 me-2"></i> ⚡ Quick Multi-Upload (Select up to 5 at once)
                                                                                </span>
                                                                                <small class="text-muted d-block">Ek sath multiple images select karein ya niche individual slots use karein:</small>
                                                                            </div>
                                                                            <div class="col-md-7 col-12">
                                                                                <input type="file" name="gallery_files[]" class="form-control" accept="image/*" multiple>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!-- 5 Image Slots: 1 Row Me 2 (col-md-6) -->
                                                                    <div class="row g-3">
                                                                        <!-- Slot 1: Main Cover Photo -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #a7f3d0 !important;">
                                                                                <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                                                    <span class="badge bg-success text-white fw-bold px-2.5 py-1">
                                                                                        <i class="bi bi-star-fill text-warning me-1"></i> Photo 1: Main Cover / Thumbnail*
                                                                                    </span>
                                                                                    <img src="{{ $imgSrc }}" class="rounded border shadow-xs" style="width: 36px; height: 36px; object-fit: cover;" onerror="this.style.display='none'">
                                                                                </div>
                                                                                <div class="mb-2">
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File from Computer / Phone:</label>
                                                                                    <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*">
                                                                                </div>
                                                                                <div>
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 1 URL:</label>
                                                                                    <input type="text" name="image" class="form-control form-control-sm" value="{{ is_array($product) ? ($product['image'] ?? ($product['thumbnail'] ?? '')) : ($product->image ?? ($product->thumbnail ?? '')) }}" placeholder="Or enter Image 1 URL">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Slot 2 -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #c7d2fe !important;">
                                                                                <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2.5 py-1">
                                                                                        <i class="bi bi-image text-primary me-1"></i> Photo 2 (Optional)
                                                                                    </span>
                                                                                    @if(!empty($prodGallery[0]))
                                                                                        <img src="{{ $prodGallery[0] }}" class="rounded border shadow-xs" style="width: 36px; height: 36px; object-fit: cover;" onerror="this.style.display='none'">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="mb-2">
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File:</label>
                                                                                    <input type="file" name="gallery_file_2" class="form-control form-control-sm" accept="image/*">
                                                                                </div>
                                                                                <div>
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 2 URL:</label>
                                                                                    <input type="text" name="gallery_url_2" class="form-control form-control-sm" value="{{ $prodGallery[0] ?? '' }}" placeholder="Or Image 2 URL">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Slot 3 -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #bae6fd !important;">
                                                                                <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                                                    <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle fw-bold px-2.5 py-1">
                                                                                        <i class="bi bi-image text-info me-1"></i> Photo 3 (Optional)
                                                                                    </span>
                                                                                    @if(!empty($prodGallery[1]))
                                                                                        <img src="{{ $prodGallery[1] }}" class="rounded border shadow-xs" style="width: 36px; height: 36px; object-fit: cover;" onerror="this.style.display='none'">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="mb-2">
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File:</label>
                                                                                    <input type="file" name="gallery_file_3" class="form-control form-control-sm" accept="image/*">
                                                                                </div>
                                                                                <div>
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 3 URL:</label>
                                                                                    <input type="text" name="gallery_url_3" class="form-control form-control-sm" value="{{ $prodGallery[1] ?? '' }}" placeholder="Or Image 3 URL">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Slot 4 -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #fde68a !important;">
                                                                                <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fw-bold px-2.5 py-1">
                                                                                        <i class="bi bi-image text-warning me-1"></i> Photo 4 (Optional)
                                                                                    </span>
                                                                                    @if(!empty($prodGallery[2]))
                                                                                        <img src="{{ $prodGallery[2] }}" class="rounded border shadow-xs" style="width: 36px; height: 36px; object-fit: cover;" onerror="this.style.display='none'">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="mb-2">
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File:</label>
                                                                                    <input type="file" name="gallery_file_4" class="form-control form-control-sm" accept="image/*">
                                                                                </div>
                                                                                <div>
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 4 URL:</label>
                                                                                    <input type="text" name="gallery_url_4" class="form-control form-control-sm" value="{{ $prodGallery[2] ?? '' }}" placeholder="Or Image 4 URL">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Slot 5 -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #e9d5ff !important;">
                                                                                <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                                                    <span class="badge fw-bold px-2.5 py-1" style="background:#f3e8ff; color:#7e22ce; border: 1px solid #d8b4fe;">
                                                                                        <i class="bi bi-image me-1"></i> Photo 5 (Optional)
                                                                                    </span>
                                                                                    @if(!empty($prodGallery[3]))
                                                                                        <img src="{{ $prodGallery[3] }}" class="rounded border shadow-xs" style="width: 36px; height: 36px; object-fit: cover;" onerror="this.style.display='none'">
                                                                                    @endif
                                                                                </div>
                                                                                <div class="mb-2">
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File:</label>
                                                                                    <input type="file" name="gallery_file_5" class="form-control form-control-sm" accept="image/*">
                                                                                </div>
                                                                                <div>
                                                                                    <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 5 URL:</label>
                                                                                    <input type="text" name="gallery_url_5" class="form-control form-control-sm" value="{{ $prodGallery[3] ?? '' }}" placeholder="Or Image 5 URL">
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Slot 6: Gallery Tips & Guidelines -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 rounded-3 border h-100 shadow-xs d-flex flex-column justify-content-center" style="background: #ffffff; border: 1.5px dashed #94a3b8 !important;">
                                                                                <h6 class="fw-bold text-dark mb-2 d-flex align-items-center">
                                                                                    <i class="bi bi-lightbulb-fill text-warning me-2 fs-5"></i> Gallery Pro Tips &amp; Rules
                                                                                </h6>
                                                                                <ul class="list-unstyled small text-muted mb-0" style="font-size: 12px; line-height: 1.7;">
                                                                                    <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Formats:</strong> JPG, PNG, WEBP, AVIF supported.</li>
                                                                                    <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Optional:</strong> Khali slots product details me nahi dikhenge.</li>
                                                                                    <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Interactive:</strong> Customer thumbnails par click karke dekhega.</li>
                                                                                    <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Safe:</strong> Nayi upload na karne par purani images surakshit rahengi.</li>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- DELIVERY, PACKAGING & HANDLING CHARGES: 1 ROW ME 2 (col-md-6) -->
                                                            <div class="col-12 my-2">
                                                                <div class="card p-4 rounded-4 border shadow-sm" style="background: #f8fafc; border: 1.5px solid #cbd5e1 !important;">
                                                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom">
                                                                        <div>
                                                                            <h6 class="fw-bold text-dark mb-1 d-flex align-items-center">
                                                                                <i class="bi bi-truck text-primary me-2 fs-5"></i> Product-Level Delivery, Packaging &amp; Handling Charges (Optional)
                                                                            </h6>
                                                                            <small class="text-muted">Defaults Global Settings se aate hain. Is product par specific rate lagane ke liye yahan badal sakte hain.</small>
                                                                        </div>
                                                                        <span class="badge bg-secondary-subtle text-secondary border px-2.5 py-1 rounded-pill">Product Custom Rates</span>
                                                                    </div>

                                                                    <div class="row g-3">
                                                                        <!-- Row 1: Handling & Packaging -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 bg-white rounded-3 border h-100 shadow-xs">
                                                                                <label class="form-label small fw-bold text-dark d-flex align-items-center justify-content-between mb-1.5">
                                                                                    <span>🛡️ Handling Fee (₹)</span>
                                                                                    <span class="badge bg-light text-muted border">Per Item</span>
                                                                                </label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text fw-bold text-secondary bg-light">₹</span>
                                                                                    <input type="number" step="0.01" name="handling_fee" class="form-control fw-bold" value="{{ is_array($product) ? ($product['handling_fee'] ?? 10.00) : ($product->handling_fee ?? 10.00) }}">
                                                                                </div>
                                                                                <small class="text-muted mt-1 d-block" style="font-size: 11px;">Sacred item handling &amp; hygiene care</small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 bg-white rounded-3 border h-100 shadow-xs">
                                                                                <label class="form-label small fw-bold text-dark d-flex align-items-center justify-content-between mb-1.5">
                                                                                    <span>📦 Packaging Fee (₹)</span>
                                                                                    <span class="badge bg-light text-muted border">Per Item</span>
                                                                                </label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text fw-bold text-secondary bg-light">₹</span>
                                                                                    <input type="number" step="0.01" name="packaging_fee" class="form-control fw-bold" value="{{ is_array($product) ? ($product['packaging_fee'] ?? 20.00) : ($product->packaging_fee ?? 20.00) }}">
                                                                                </div>
                                                                                <small class="text-muted mt-1 d-block" style="font-size: 11px;">Bubble wrap, box &amp; fragile protection</small>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Row 2: Standard Courier & Express Local -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 bg-white rounded-3 border h-100 shadow-xs">
                                                                                <label class="form-label small fw-bold text-dark d-flex align-items-center justify-content-between mb-1.5">
                                                                                    <span>🚚 All-India Standard Courier (₹)</span>
                                                                                    <span class="badge bg-secondary-subtle text-dark border">Outstation</span>
                                                                                </label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text fw-bold text-secondary bg-light">₹</span>
                                                                                    <input type="number" step="0.01" name="delivery_fee" class="form-control fw-bold" value="{{ is_array($product) ? ($product['delivery_fee'] ?? 40.00) : ($product->delivery_fee ?? 40.00) }}">
                                                                                </div>
                                                                                <small class="text-muted mt-1 d-block" style="font-size: 11px;">Shiprocket / DTDC All India Courier</small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 bg-white rounded-3 border h-100 shadow-xs" style="border-left: 3.5px solid #10b981 !important;">
                                                                                <label class="form-label small fw-bold text-success d-flex align-items-center justify-content-between mb-1.5">
                                                                                    <span>⚡ 2-4 Hours Express Local (₹)</span>
                                                                                    <span class="badge bg-success-subtle text-success border border-success-subtle">Dewa Pincode 225301</span>
                                                                                </label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text fw-bold text-success bg-success-subtle">₹</span>
                                                                                    <input type="number" step="0.01" name="same_day_fee_2_4h" class="form-control fw-bold text-success" value="{{ is_array($product) ? ($product['same_day_fee_2_4h'] ?? 35.00) : ($product->same_day_fee_2_4h ?? 35.00) }}">
                                                                                </div>
                                                                                <small class="text-muted mt-1 d-block" style="font-size: 11px;">Superfast delivery to Dewa Hotels / Homes</small>
                                                                            </div>
                                                                        </div>

                                                                        <!-- Row 3: 24h Normal Local & COD Fee -->
                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 bg-white rounded-3 border h-100 shadow-xs" style="border-left: 3.5px solid #3b82f6 !important;">
                                                                                <label class="form-label small fw-bold text-primary d-flex align-items-center justify-content-between mb-1.5">
                                                                                    <span>🕒 24 Hours Normal Local (₹)</span>
                                                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Dewa Pincode 225301</span>
                                                                                </label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text fw-bold text-primary bg-primary-subtle">₹</span>
                                                                                    <input type="number" step="0.01" name="local_fee_24h" class="form-control fw-bold text-primary" value="{{ is_array($product) ? ($product['local_fee_24h'] ?? 20.00) : ($product->local_fee_24h ?? 20.00) }}">
                                                                                </div>
                                                                                <small class="text-muted mt-1 d-block" style="font-size: 11px;">Next-day relaxed local delivery</small>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-md-6 col-12">
                                                                            <div class="p-3 bg-white rounded-3 border h-100 shadow-xs" style="border-left: 3.5px solid #ef4444 !important;">
                                                                                <label class="form-label small fw-bold text-danger d-flex align-items-center justify-content-between mb-1.5">
                                                                                    <span>💵 COD Convenience Extra (₹)</span>
                                                                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Cash On Delivery</span>
                                                                                </label>
                                                                                <div class="input-group">
                                                                                    <span class="input-group-text fw-bold text-danger bg-danger-subtle">₹</span>
                                                                                    <input type="number" step="0.01" name="cod_fee" class="form-control fw-bold text-danger" value="{{ is_array($product) ? ($product['cod_fee'] ?? 30.00) : ($product->cod_fee ?? 30.00) }}">
                                                                                </div>
                                                                                <small class="text-muted mt-1 d-block" style="font-size: 11px;">Added only when customer selects COD</small>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Product Description -->
                                                            <div class="col-12 mt-2">
                                                                <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-file-text-fill text-primary me-1"></i> Product Description &amp; Sacred Details</label>
                                                                <textarea name="description" class="form-control" rows="3" placeholder="Enter detailed description for customers...">{{ is_array($product) ? ($product['description'] ?? '') : ($product->description ?? '') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer bg-light py-3 px-4 border-top">
                                                        <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-gradient-navy fw-bold px-4"><i class="bi bi-save me-1"></i> Update Product</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-4 text-muted">No products found in catalogue. Click "Add New Product" to add items.</td>
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

<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog product-modal-dialog modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <form action="{{ route('admin.shop.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header btn-gradient-green text-white py-3 px-4">
                    <h5 class="modal-title fw-bold d-flex align-items-center">
                        <i class="bi bi-plus-circle me-2"></i>Add New Product to Sacred Shop
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    <div class="row g-3">
                        <!-- Row 1: Name & SKU -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-tag-fill text-success me-1"></i> Product Name*</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g., Pure Warisi Gulab Attar" required>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-upc-scan text-secondary me-1"></i> SKU / Item Code</label>
                            <input type="text" name="sku" class="form-control font-mono" placeholder="e.g. #ATT-01">
                        </div>

                        <!-- Row 2: Category & Return Policy -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-grid-fill text-success me-1"></i> Category*</label>
                            <select name="category" class="form-select fw-bold" required>
                                @foreach($categories as $c)
                                    <option value="{{ $c->slug }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-shield-check text-info me-1"></i> Return / Replacement Policy*</label>
                            <select name="return_policy" class="form-select fw-bold">
                                <option value="non_returnable" selected>🛡️ Non-Returnable (Sacred Tabarruk / Food / Niyaz)</option>
                                <option value="replacement_48h">🔄 Replacement Only (48h Transit Damage / Fragile)</option>
                                <option value="exchange_7d">📦 7 Days Size Exchange (Clothing / Wearables)</option>
                                <option value="return_7d">↩️ 7 Days Return &amp; Refund (Retail Items)</option>
                                <option value="no_return">🚫 Final Sale - No Return / No Replacement</option>
                            </select>
                        </div>

                        <!-- Row 3: Selling Price & MRP Price -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-success mb-1"><i class="bi bi-currency-rupee me-1"></i> Selling Price (₹)*</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold text-success bg-success-subtle border-success-subtle">₹</span>
                                <input type="number" step="0.01" name="price" id="add_price" oninput="calcAddDiscount()" class="form-control fw-bold text-success" placeholder="299" required>
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Final discounted selling price customer pays</small>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-secondary mb-1"><i class="bi bi-tags me-1"></i> Original MRP Price (₹)</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold text-secondary bg-light">₹</span>
                                <input type="number" step="0.01" name="mrp" id="add_mrp" oninput="calcAddDiscount()" class="form-control fw-bold text-secondary" placeholder="399">
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Original market / printed MRP price</small>
                        </div>

                        <!-- Row 4: Discount % & Stock Quantity -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-danger mb-1"><i class="bi bi-fire me-1"></i> Discount % OFF (Auto or Custom)</label>
                            <div class="input-group">
                                <input type="number" step="1" min="0" max="99" name="discount_percent" id="add_discount_percent" oninput="onAddDiscountInput()" class="form-control fw-bold text-danger" placeholder="e.g. 25">
                                <span class="input-group-text fw-bold text-danger bg-danger-subtle border-danger-subtle">% OFF</span>
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Type custom % or auto-calculated from Price/MRP</small>
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-boxes text-primary me-1"></i> Stock Quantity*</label>
                            <div class="input-group">
                                <input type="number" name="stock" class="form-control fw-bold" placeholder="50" value="50" required min="0">
                                <span class="input-group-text text-muted bg-light">Units</span>
                            </div>
                            <small class="text-muted" style="font-size: 11px;">Available inventory in stock</small>
                        </div>

                        <!-- Row 5: Volume / Weight & Fabric / Material -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-droplet-half text-info me-1"></i> Volume ML / Weight / Pack Size</label>
                            <input type="text" name="volume_ml" class="form-control" placeholder="12 ml / 500g / 50 Kg">
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-layers text-secondary me-1"></i> Fabric / Material</label>
                            <input type="text" name="fabric_material" class="form-control" placeholder="e.g. Pure Clay / Pure Cotton / Attar">
                        </div>

                        <!-- Row 6: Size Options & Star Rating -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-sliders text-warning me-1"></i> Size Options</label>
                            <input type="text" name="size_options" class="form-control" placeholder="e.g. 6ml, 12ml or S, M, L">
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-warning-emphasis mb-1"><i class="bi bi-star-fill text-warning me-1"></i> Star Rating (1.0 to 5.0)</label>
                            <input type="number" step="0.1" min="1.0" max="5.0" name="rating" class="form-control" value="5.0" placeholder="5.0">
                        </div>

                        <!-- Row 7: Reviews & Featured Status -->
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-chat-quote-fill text-primary me-1"></i> Reviews / Bookings Text</label>
                            <input type="text" name="reviews_count" class="form-control" placeholder="e.g. 240+ Niyaz Bookings" value="240+ Niyaz Bookings">
                        </div>
                        <div class="col-md-6 col-12">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-award-fill text-warning me-1"></i> Featured Product Status</label>
                            <div class="form-check form-switch p-2 bg-light rounded-3 border d-flex align-items-center" style="min-height: 38px;">
                                <input class="form-check-input ms-1 me-3 fs-5" type="checkbox" name="is_featured" value="1" id="add_featured">
                                <label class="form-check-label fw-bold small text-dark mb-0" for="add_featured">
                                    ⭐ Mark as Featured (Highlight on Sacred Bazaar)
                                </label>
                            </div>
                        </div>

                        <!-- 5 OPTIONAL PRODUCT IMAGES & GALLERY (1 ROW ME 2 - COL-6) -->
                        <div class="col-12 my-2">
                            <div class="card p-4 rounded-4 border shadow-sm" style="background: #f8fafc; border: 1.5px solid #cbd5e1 !important;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1 d-flex align-items-center">
                                            <i class="bi bi-images text-primary me-2 fs-5"></i> Product Photos &amp; Gallery (Up to 5 Images, Optional)
                                        </h6>
                                        <small class="text-muted">Aap 1 se lekar 5 tak images upload kar sakte hain. Jitni upload karenge utni hi product gallery me show hongi.</small>
                                    </div>
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 rounded-pill fw-bold">
                                        1 to 5 Photos Supported
                                    </span>
                                </div>

                                <!-- Quick Multi-Upload Banner -->
                                <div class="p-3 mb-4 rounded-3 border shadow-xs" style="background: linear-gradient(135deg, #f0fdf4 0%, #ecfeff 100%); border: 1.5px dashed #10b981 !important;">
                                    <div class="row align-items-center">
                                        <div class="col-md-5 col-12 mb-2 mb-md-0">
                                            <span class="fw-bold text-success d-flex align-items-center mb-1">
                                                <i class="bi bi-cloud-arrow-up-fill fs-5 me-2"></i> ⚡ Quick Multi-Upload (Select up to 5 at once)
                                            </span>
                                            <small class="text-muted d-block">Ek sath multiple images select karein ya niche individual slots use karein:</small>
                                        </div>
                                        <div class="col-md-7 col-12">
                                            <input type="file" name="gallery_files[]" class="form-control" accept="image/*" multiple>
                                        </div>
                                    </div>
                                </div>

                                <!-- 5 Image Slots: 1 Row Me 2 (col-md-6) -->
                                <div class="row g-3">
                                    <!-- Slot 1: Main Cover Photo -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #a7f3d0 !important;">
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="badge bg-success text-white fw-bold px-2.5 py-1">
                                                    <i class="bi bi-star-fill text-warning me-1"></i> Photo 1: Main Cover / Thumbnail*
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File from Computer / Phone:</label>
                                                <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 1 URL:</label>
                                                <input type="text" name="image" class="form-control form-control-sm" placeholder="Or enter Image 1 URL">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slot 2 -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #c7d2fe !important;">
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle fw-bold px-2.5 py-1">
                                                    <i class="bi bi-image text-primary me-1"></i> Photo 2 (Optional)
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File:</label>
                                                <input type="file" name="gallery_file_2" class="form-control form-control-sm" accept="image/*">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 2 URL:</label>
                                                <input type="text" name="gallery_url_2" class="form-control form-control-sm" placeholder="Or Image 2 URL">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slot 3 -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #bae6fd !important;">
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="badge bg-info-subtle text-info-emphasis border border-info-subtle fw-bold px-2.5 py-1">
                                                    <i class="bi bi-image text-info me-1"></i> Photo 3 (Optional)
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File:</label>
                                                <input type="file" name="gallery_file_3" class="form-control form-control-sm" accept="image/*">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 3 URL:</label>
                                                <input type="text" name="gallery_url_3" class="form-control form-control-sm" placeholder="Or Image 3 URL">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slot 4 -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #fde68a !important;">
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle fw-bold px-2.5 py-1">
                                                    <i class="bi bi-image text-warning me-1"></i> Photo 4 (Optional)
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File:</label>
                                                <input type="file" name="gallery_file_4" class="form-control form-control-sm" accept="image/*">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 4 URL:</label>
                                                <input type="text" name="gallery_url_4" class="form-control form-control-sm" placeholder="Or Image 4 URL">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slot 5 -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 rounded-3 border h-100 shadow-xs" style="background: #ffffff; border: 1.5px solid #e9d5ff !important;">
                                            <div class="d-flex align-items-center justify-content-between mb-2 pb-1 border-bottom">
                                                <span class="badge fw-bold px-2.5 py-1" style="background:#f3e8ff; color:#7e22ce; border: 1px solid #d8b4fe;">
                                                    <i class="bi bi-image me-1"></i> Photo 5 (Optional)
                                                </span>
                                            </div>
                                            <div class="mb-2">
                                                <label class="form-label small fw-bold text-secondary mb-1">📁 Upload File:</label>
                                                <input type="file" name="gallery_file_5" class="form-control form-control-sm" accept="image/*">
                                            </div>
                                            <div>
                                                <label class="form-label small fw-bold text-secondary mb-1">🌐 Or Image 5 URL:</label>
                                                <input type="text" name="gallery_url_5" class="form-control form-control-sm" placeholder="Or Image 5 URL">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Slot 6: Gallery Tips & Guidelines -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 rounded-3 border h-100 shadow-xs d-flex flex-column justify-content-center" style="background: #ffffff; border: 1.5px dashed #94a3b8 !important;">
                                            <h6 class="fw-bold text-dark mb-2 d-flex align-items-center">
                                                <i class="bi bi-lightbulb-fill text-warning me-2 fs-5"></i> Gallery Pro Tips &amp; Rules
                                            </h6>
                                            <ul class="list-unstyled small text-muted mb-0" style="font-size: 12px; line-height: 1.7;">
                                                <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Formats:</strong> JPG, PNG, WEBP, AVIF supported.</li>
                                                <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Optional:</strong> Khali slots product details me nahi dikhenge.</li>
                                                <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Interactive:</strong> Customer thumbnails par click karke dekhega.</li>
                                                <li><i class="bi bi-check-circle-fill text-success me-1.5"></i> <strong>Safe:</strong> Nayi upload na karne par purani images surakshit rahengi.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DELIVERY, PACKAGING & HANDLING CHARGES: 1 ROW ME 2 (col-md-6) -->
                        <div class="col-12 my-2">
                            <div class="card p-4 rounded-4 border shadow-sm" style="background: #f8fafc; border: 1.5px solid #cbd5e1 !important;">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3 pb-2 border-bottom">
                                    <div>
                                        <h6 class="fw-bold text-dark mb-1 d-flex align-items-center">
                                            <i class="bi bi-truck text-primary me-2 fs-5"></i> Product-Level Delivery, Packaging &amp; Handling Charges (Optional)
                                        </h6>
                                        <small class="text-muted">Defaults Global Settings se aate hain. Is product par specific rate lagane ke liye yahan badal sakte hain.</small>
                                    </div>
                                    <span class="badge bg-secondary-subtle text-secondary border px-2.5 py-1 rounded-pill">Product Custom Rates</span>
                                </div>

                                <div class="row g-3">
                                    <!-- Row 1: Handling & Packaging -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 bg-white rounded-3 border h-100 shadow-xs">
                                            <label class="form-label small fw-bold text-dark d-flex align-items-center justify-content-between mb-1.5">
                                                <span>🛡️ Handling Fee (₹)</span>
                                                <span class="badge bg-light text-muted border">Per Item</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text fw-bold text-secondary bg-light">₹</span>
                                                <input type="number" step="0.01" name="handling_fee" class="form-control fw-bold" value="{{ $shopSettings['default_handling_fee'] ?? 10.00 }}" placeholder="10.00">
                                            </div>
                                            <small class="text-muted mt-1 d-block" style="font-size: 11px;">Sacred item handling &amp; hygiene care</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="p-3 bg-white rounded-3 border h-100 shadow-xs">
                                            <label class="form-label small fw-bold text-dark d-flex align-items-center justify-content-between mb-1.5">
                                                <span>📦 Packaging Fee (₹)</span>
                                                <span class="badge bg-light text-muted border">Per Item</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text fw-bold text-secondary bg-light">₹</span>
                                                <input type="number" step="0.01" name="packaging_fee" class="form-control fw-bold" value="{{ $shopSettings['default_packaging_fee'] ?? 20.00 }}" placeholder="20.00">
                                            </div>
                                            <small class="text-muted mt-1 d-block" style="font-size: 11px;">Bubble wrap, box &amp; fragile protection</small>
                                        </div>
                                    </div>

                                    <!-- Row 2: Standard Courier & Express Local -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 bg-white rounded-3 border h-100 shadow-xs">
                                            <label class="form-label small fw-bold text-dark d-flex align-items-center justify-content-between mb-1.5">
                                                <span>🚚 All-India Standard Courier (₹)</span>
                                                <span class="badge bg-secondary-subtle text-dark border">Outstation</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text fw-bold text-secondary bg-light">₹</span>
                                                <input type="number" step="0.01" name="delivery_fee" class="form-control fw-bold" value="{{ $shopSettings['standard_courier_fee'] ?? 40.00 }}" placeholder="40.00">
                                            </div>
                                            <small class="text-muted mt-1 d-block" style="font-size: 11px;">Shiprocket / DTDC All India Courier</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="p-3 bg-white rounded-3 border h-100 shadow-xs" style="border-left: 3.5px solid #10b981 !important;">
                                            <label class="form-label small fw-bold text-success d-flex align-items-center justify-content-between mb-1.5">
                                                <span>⚡ 2-4 Hours Express Local (₹)</span>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle">Dewa Pincode 225301</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text fw-bold text-success bg-success-subtle">₹</span>
                                                <input type="number" step="0.01" name="same_day_fee_2_4h" class="form-control fw-bold text-success" value="{{ $shopSettings['express_2_4h_fee'] ?? 35.00 }}" placeholder="35.00">
                                            </div>
                                            <small class="text-muted mt-1 d-block" style="font-size: 11px;">Superfast delivery to Dewa Hotels / Homes</small>
                                        </div>
                                    </div>

                                    <!-- Row 3: 24h Normal Local & COD Fee -->
                                    <div class="col-md-6 col-12">
                                        <div class="p-3 bg-white rounded-3 border h-100 shadow-xs" style="border-left: 3.5px solid #3b82f6 !important;">
                                            <label class="form-label small fw-bold text-primary d-flex align-items-center justify-content-between mb-1.5">
                                                <span>🕒 24 Hours Normal Local (₹)</span>
                                                <span class="badge bg-primary-subtle text-primary border border-primary-subtle">Dewa Pincode 225301</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text fw-bold text-primary bg-primary-subtle">₹</span>
                                                <input type="number" step="0.01" name="local_fee_24h" class="form-control fw-bold text-primary" value="{{ $shopSettings['local_24h_fee'] ?? 20.00 }}" placeholder="20.00">
                                            </div>
                                            <small class="text-muted mt-1 d-block" style="font-size: 11px;">Next-day relaxed local delivery</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="p-3 bg-white rounded-3 border h-100 shadow-xs" style="border-left: 3.5px solid #ef4444 !important;">
                                            <label class="form-label small fw-bold text-danger d-flex align-items-center justify-content-between mb-1.5">
                                                <span>💵 COD Convenience Extra (₹)</span>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle">Cash On Delivery</span>
                                            </label>
                                            <div class="input-group">
                                                <span class="input-group-text fw-bold text-danger bg-danger-subtle">₹</span>
                                                <input type="number" step="0.01" name="cod_fee" class="form-control fw-bold text-danger" value="{{ $shopSettings['cod_extra_fee'] ?? 30.00 }}" placeholder="30.00">
                                            </div>
                                            <small class="text-muted mt-1 d-block" style="font-size: 11px;">Added only when customer selects COD</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Product Description -->
                        <div class="col-12 mt-2">
                            <label class="form-label fw-bold text-dark mb-1"><i class="bi bi-file-text-fill text-success me-1"></i> Product Description &amp; Sacred Details</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Enter detailed description for customers..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light py-3 px-4 border-top">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-green fw-bold px-4"><i class="bi bi-check-circle me-1"></i> Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Global Delivery & Fee Settings Modal -->
<div class="modal fade" id="globalSettingsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.shop.settings.update') }}" method="POST">
                @csrf
                <div class="modal-header btn-gradient-navy text-white">
                    <h5 class="modal-title fw-bold">
                        <i class="bi bi-gear-fill me-2"></i>Global Store Delivery &amp; Fee Settings (Dynamic)
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3 text-start">
                    <div class="col-12">
                        <div class="alert alert-info py-2 px-3 small mb-0 border-0 shadow-xs">
                            💡 <strong>Dynamic Rates:</strong> Yeh default rates hain. Jab customer checkout karega to use yahi rates lagenge (unless aapne kisi product par alag se override kiya ho). Yahan se badalte hi website par turant live ho jayenge!
                        </div>
                    </div>
                    
                    <div class="col-md-6 col-12">
                        <div class="card p-3 border-success-subtle shadow-xs h-100">
                            <h6 class="fw-bold text-success mb-2">⚡ Dewa Sharif Town Same-Day (2–4 Hours)</h6>
                            <p class="small text-muted mb-2">Local fast delivery to hotels / guest houses / residence in Dewa Sharif (Pincode 225301).</p>
                            <label class="form-label small fw-bold">Express Rate (₹)*</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" step="0.01" name="express_2_4h_fee" class="form-control font-bold" value="{{ $shopSettings['express_2_4h_fee'] ?? 35.00 }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="card p-3 border-primary-subtle shadow-xs h-100">
                            <h6 class="fw-bold text-primary mb-2">🕒 Dewa Sharif Normal Local (Within 24 Hours)</h6>
                            <p class="small text-muted mb-2">Next-day local delivery for devotees / residents who are not in rush.</p>
                            <label class="form-label small fw-bold">Local 24h Rate (₹)*</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" step="0.01" name="local_fee_24h" class="form-control font-bold" value="{{ $shopSettings['local_24h_fee'] ?? 20.00 }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="card p-3 border-secondary-subtle shadow-xs h-100">
                            <h6 class="fw-bold text-dark mb-2">🚚 All-India Standard Courier Delivery</h6>
                            <p class="small text-muted mb-2">For outstation orders across India (Lucknow, Delhi, Mumbai, Bihar etc.) via Shiprocket / DTDC.</p>
                            <label class="form-label small fw-bold">Standard Courier Rate (₹)*</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" step="0.01" name="standard_courier_fee" class="form-control font-bold" value="{{ $shopSettings['standard_courier_fee'] ?? 40.00 }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="card p-3 border-danger-subtle shadow-xs h-100">
                            <h6 class="fw-bold text-danger mb-2">💵 Cash on Delivery (COD) Convenience Fee</h6>
                            <p class="small text-muted mb-2">Extra charge added on COD orders to cover courier cash collection fee and encourage online UPI payment.</p>
                            <label class="form-label small fw-bold">COD Extra Fee (₹)*</label>
                            <div class="input-group">
                                <span class="input-group-text fw-bold">₹</span>
                                <input type="number" step="0.01" name="cod_extra_fee" class="form-control font-bold" value="{{ $shopSettings['cod_extra_fee'] ?? 30.00 }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">🛡️ Default Handling Fee (₹)</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">₹</span>
                            <input type="number" step="0.01" name="default_handling_fee" class="form-control" value="{{ $shopSettings['default_handling_fee'] ?? 10.00 }}" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">📦 Default Packaging Fee (₹)</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">₹</span>
                            <input type="number" step="0.01" name="default_packaging_fee" class="form-control" value="{{ $shopSettings['default_packaging_fee'] ?? 20.00 }}" required>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <label class="form-label small fw-bold">🎁 Free Shipping Above (₹)</label>
                        <div class="input-group">
                            <span class="input-group-text fw-bold">₹</span>
                            <input type="number" step="0.01" name="free_delivery_threshold" class="form-control" value="{{ $shopSettings['free_delivery_threshold'] ?? 999.00 }}" placeholder="999 (0 to disable)">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-navy fw-bold px-4">
                        <i class="bi bi-save me-1"></i> Save Global Settings
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function filterCategoryTable(catSlug, triggerEl) {
        // 1. Reset all category cards to default clean state
        document.querySelectorAll('.cat-filter-card').forEach(function(card) {
            card.classList.remove('is-active');
            var baseColor = card.getAttribute('data-color') || '#2563eb';
            card.style.background = '#ffffff';
            card.style.borderColor = baseColor;
            card.style.transform = '';
            card.style.boxShadow = '';

            var nameEl = card.querySelector('.cat-name-text');
            if (nameEl) {
                nameEl.style.color = baseColor;
            }

            var dotEl = card.querySelector('.cat-indicator-dot');
            if (dotEl) {
                dotEl.style.background = baseColor;
            }

            var badge = card.querySelector('.cat-status-badge');
            if (badge) {
                var isLive = badge.innerText.indexOf('Live') !== -1;
                badge.style.background = isLive ? '#10b981' : '#f1f5f9';
                badge.style.color = isLive ? '#ffffff' : '#64748b';
                badge.style.border = isLive ? 'none' : '1px solid #cbd5e1';
            }
        });

        // 2. Handle 'All' Button state
        var btnAll = document.getElementById('btnFilterAll');
        if (btnAll) {
            if (catSlug === 'all') {
                btnAll.style.background = '#1e293b';
                btnAll.style.color = '#ffffff';
                btnAll.style.borderColor = '#1e293b';
                btnAll.classList.add('active');
            } else {
                btnAll.style.background = '#ffffff';
                btnAll.style.color = '#475569';
                btnAll.style.borderColor = '#cbd5e1';
                btnAll.classList.remove('active');
            }
        }

        // 3. Highlight the clicked category card with its solid color & PURE WHITE FONT
        if (triggerEl && catSlug !== 'all') {
            var activeCard = triggerEl.classList.contains('cat-filter-card') ? triggerEl : triggerEl.closest('.cat-filter-card');
            if (activeCard) {
                activeCard.classList.add('is-active');
                var activeColor = activeCard.getAttribute('data-color') || '#2563eb';
                activeCard.style.background = activeColor;
                activeCard.style.borderColor = activeColor;
                activeCard.style.transform = 'translateY(-2px)';
                activeCard.style.boxShadow = '0 6px 16px rgba(0, 0, 0, 0.18)';

                var nameEl = activeCard.querySelector('.cat-name-text');
                if (nameEl) {
                    nameEl.style.color = '#ffffff'; // 100% Crisp White Font!
                }

                var dotEl = activeCard.querySelector('.cat-indicator-dot');
                if (dotEl) {
                    dotEl.style.background = '#ffffff';
                }

                var badge = activeCard.querySelector('.cat-status-badge');
                if (badge) {
                    badge.style.background = 'rgba(255, 255, 255, 0.28)';
                    badge.style.color = '#ffffff';
                    badge.style.border = '1px solid rgba(255, 255, 255, 0.6)';
                }
            }
        }

        // 4. Filter Product Rows in Table
        var rows = document.querySelectorAll('.prod-row');
        rows.forEach(function(row) {
            if (catSlug === 'all') {
                row.style.display = '';
            } else {
                if (row.classList.contains('cat-row-' + catSlug)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }

    // Add Modal: Auto-calculate % OFF when Price or MRP changed
    function calcAddDiscount() {
        var price = parseFloat(document.getElementById('add_price').value) || 0;
        var mrp = parseFloat(document.getElementById('add_mrp').value) || 0;
        var offInput = document.getElementById('add_discount_percent');
        if (offInput) {
            if (mrp > price && mrp > 0) {
                var off = Math.round(((mrp - price) / mrp) * 100);
                offInput.value = off;
            } else {
                offInput.value = 0;
            }
        }
    }

    // Add Modal: Auto-adjust Price when custom % OFF typed directly
    function onAddDiscountInput() {
        var offInput = document.getElementById('add_discount_percent');
        var off = parseFloat(offInput ? offInput.value : 0) || 0;
        var mrp = parseFloat(document.getElementById('add_mrp').value) || 0;
        var priceInput = document.getElementById('add_price');
        if (mrp > 0 && off >= 0 && off < 100 && priceInput) {
            priceInput.value = (mrp * (1 - off / 100)).toFixed(2);
        }
    }

    // Edit Modal: Auto-calculate % OFF when Price or MRP changed
    function calcEditDiscount(id) {
        var price = parseFloat(document.getElementById('edit_price_' + id).value) || 0;
        var mrp = parseFloat(document.getElementById('edit_mrp_' + id).value) || 0;
        var offInput = document.getElementById('edit_off_' + id);
        if (offInput) {
            if (mrp > price && mrp > 0) {
                var off = Math.round(((mrp - price) / mrp) * 100);
                offInput.value = off;
            } else {
                offInput.value = 0;
            }
        }
    }

    // Edit Modal: Auto-adjust Price when custom % OFF typed directly
    function onEditDiscountInput(id) {
        var offInput = document.getElementById('edit_off_' + id);
        var off = parseFloat(offInput ? offInput.value : 0) || 0;
        var mrp = parseFloat(document.getElementById('edit_mrp_' + id).value) || 0;
        var priceInput = document.getElementById('edit_price_' + id);
        if (mrp > 0 && off >= 0 && off < 100 && priceInput) {
            priceInput.value = (mrp * (1 - off / 100)).toFixed(2);
        }
    }
</script>
@endsection
