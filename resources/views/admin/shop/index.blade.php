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
                    <small class="text-muted">Manage Attar, Sufi Clothing, Mitti Bartan &amp; Degh Niyaz Offerings</small>
                </div>
                <div class="col-sm-6 text-end">
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

            <div class="card card-outline card-primary shadow border-0 rounded-3">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                    <h5 class="card-title mb-0 fw-bold text-dark">
                        <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>E-Commerce Products &amp; Degh Inventory
                    </h5>
                    <span class="badge btn-gradient-navy px-3 py-2 rounded-pill">Total Items: {{ count($products) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-aligned">
                            <thead class="custom-table-header">
                                <tr>
                                    <th class="ps-3">#Product ID</th>
                                    <th>Product Item</th>
                                    <th>Category</th>
                                    <th>Price / MRP</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($products as $product)
                                    @php
                                        $cat = is_array($product) ? ($product['category'] ?? ($product['category_slug'] ?? 'attar')) : ($product->category ?? ($product->category_slug ?? 'attar'));
                                        $isDegh = $cat === 'degh';
                                    @endphp
                                    @php
                                        $rawImg = is_array($product) ? ($product['image'] ?? ($product['thumbnail'] ?? '')) : ($product->image ?? ($product->thumbnail ?? ''));
                                        $imgSrc = preg_replace('#^https?://[^/]+#', '', $rawImg);
                                        $imgSrc = '/' . ltrim($imgSrc, '/');
                                    @endphp
                                    <tr>
                                        <td class="ps-3">
                                            <strong class="text-dark font-mono">{{ $isDegh ? '#DGH-' : '#PRD-' }}{{ is_array($product) ? ($product['id'] ?? 1) : $product->id }}</strong>
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
                                            @if($isDegh)
                                                <span class="badge badge-gradient-green text-uppercase px-2.5 py-1.5"><i class="bi bi-fire me-1"></i>Degh Niyaz</span>
                                            @elseif($cat === 'attar')
                                                <span class="badge badge-gradient-green text-uppercase px-2.5 py-1.5">🌸 Warsi Attar</span>
                                            @elseif($cat === 'islamic')
                                                <span class="badge badge-gradient-yellow text-uppercase px-2.5 py-1.5">🌙 Islamic Items</span>
                                            @elseif($cat === 'clothing')
                                                <span class="badge badge-gradient-red text-uppercase px-2.5 py-1.5">👕 Sufi Clothing</span>
                                            @elseif($cat === 'clay')
                                                <span class="badge badge-gradient-yellow text-dark text-uppercase px-2.5 py-1.5">🏺 Mitti Bartan</span>
                                            @else
                                                <span class="badge badge-gradient-blue text-uppercase px-2.5 py-1.5">{{ $cat }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <strong class="text-success fs-6 fw-bold">₹{{ number_format(is_array($product) ? ($product['price'] ?? 299) : $product->price, 2) }}</strong>
                                            @if(is_array($product) ? isset($product['mrp']) : isset($product->mrp))
                                                <small class="text-muted text-decoration-line-through d-block">₹{{ number_format(is_array($product) ? $product['mrp'] : $product->mrp, 2) }}</small>
                                            @endif
                                        </td>
                                        @php
                                            $adminStock = (int)(is_array($product) ? ($product['stock_quantity'] ?? ($product['stock'] ?? 0)) : ($product->stock_quantity ?? ($product->stock ?? 0)));
                                        @endphp
                                        <td>
                                            @if($adminStock <= 0)
                                                <span class="badge bg-danger shadow-sm px-2.5" style="height: 32px; display: inline-flex; align-items: center; font-weight: 800; font-size: 0.8rem;">
                                                    <i class="bi bi-x-circle-fill me-1"></i> Out of Stock (0)
                                                </span>
                                            @elseif($adminStock <= 5)
                                                <span class="badge badge-gradient-yellow text-dark shadow-sm px-2.5" style="height: 32px; display: inline-flex; align-items: center; font-weight: 800; font-size: 0.8rem;">
                                                    <i class="bi bi-exclamation-triangle-fill me-1"></i> Low Stock ({{ $adminStock }})
                                                </span>
                                            @else
                                                <span class="badge badge-gradient-green shadow-sm px-2.5" style="height: 32px; display: inline-flex; align-items: center; font-weight: 700; font-size: 0.8rem;">
                                                    <i class="bi bi-check-circle-fill me-1"></i> {{ $adminStock }} In Stock
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.shop.product.toggle', is_array($product) ? $product['id'] : $product->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="border-0 bg-transparent p-0" title="Click to toggle Active/Inactive">
                                                    @if(strtolower(is_array($product) ? ($product['status'] ?? 'active') : ($product->status ?? 'active')) === 'active')
                                                        <span class="badge badge-gradient-green px-2.5 shadow-sm" style="cursor: pointer; height: 32px; display: inline-flex; align-items: center;"><i class="bi bi-toggle-on me-1 fs-6"></i> Active</span>
                                                    @else
                                                        <span class="badge bg-secondary px-2.5 shadow-sm" style="cursor: pointer; height: 32px; display: inline-flex; align-items: center;"><i class="bi bi-toggle-off me-1 fs-6"></i> Inactive</span>
                                                    @endif
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end pe-3">
                                            <div class="btn-group shadow-sm rounded-3 overflow-hidden" style="height: 32px;">
                                                <button class="btn btn-sm btn-gradient-navy px-3 font-bold d-inline-flex align-items-center" style="height: 32px;" data-bs-toggle="modal" data-bs-target="#editProductModal{{ is_array($product) ? $product['id'] : $product->id }}">
                                                    <i class="bi bi-pencil-square me-1"></i> Edit
                                                </button>
                                                <form action="{{ route('admin.shop.destroy', is_array($product) ? $product['id'] : $product->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this product item?');">
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
                                    <div class="modal fade" id="editProductModal{{ is_array($product) ? $product['id'] : $product->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.shop.product.update', is_array($product) ? $product['id'] : $product->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header btn-gradient-navy text-white">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Product Details</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Product Name*</label>
                                                            <input type="text" name="name" class="form-control" value="{{ is_array($product) ? ($product['name'] ?? '') : $product->name }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Category*</label>
                                                            <select name="category" class="form-select font-bold">
                                                                @foreach($categories as $c)
                                                                    <option value="{{ $c->slug }}" {{ ((is_array($product) ? ($product['category'] ?? ($product['category_slug'] ?? '')) : ($product->category ?? ($product->category_slug ?? ''))) == $c->slug) ? 'selected' : '' }}>
                                                                        {{ $c->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Selling Price (₹)*</label>
                                                            <input type="number" step="0.01" name="price" class="form-control" value="{{ is_array($product) ? ($product['price'] ?? 299) : $product->price }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">MRP Price (₹)</label>
                                                            <input type="number" step="0.01" name="mrp" class="form-control" value="{{ is_array($product) ? ($product['mrp'] ?? 399) : ($product->mrp ?? 399) }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Stock Quantity*</label>
                                                            <input type="number" name="stock" class="form-control" value="{{ is_array($product) ? ($product['stock_quantity'] ?? ($product['stock'] ?? 50)) : ($product->stock_quantity ?? ($product->stock ?? 50)) }}" required min="0">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Volume ML / Size</label>
                                                            <input type="text" name="volume_ml" class="form-control" value="{{ is_array($product) ? ($product['volume_ml'] ?? '') : ($product->volume_ml ?? '') }}" placeholder="e.g. 12ml / Large">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Fabric / Material</label>
                                                            <input type="text" name="fabric_material" class="form-control" value="{{ is_array($product) ? ($product['fabric_material'] ?? '') : ($product->fabric_material ?? '') }}" placeholder="e.g. Pure Cotton / Pure Attar">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Size Options</label>
                                                            <input type="text" name="size_options" class="form-control" value="{{ is_array($product) ? ($product['size_options'] ?? '') : ($product->size_options ?? '') }}" placeholder="e.g. S, M, L, XL or 6ml, 12ml">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Upload Product Image (File)</label>
                                                            <input type="file" name="image_file" class="form-control" accept="image/*">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Or Image URL</label>
                                                            <input type="text" name="image" class="form-control" value="{{ is_array($product) ? ($product['image'] ?? ($product['thumbnail'] ?? '')) : ($product->image ?? ($product->thumbnail ?? '')) }}">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold text-success">⭐ Star Rating (e.g. 5.0, 4.9)</label>
                                                            <input type="number" step="0.1" min="1.0" max="5.0" name="rating" class="form-control" value="{{ is_array($product) ? ($product['rating'] ?? 5.0) : ($product->rating ?? 5.0) }}" placeholder="5.0">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold text-success">💬 Reviews / Bookings Text</label>
                                                            <input type="text" name="reviews_count" class="form-control" value="{{ is_array($product) ? ($product['reviews_count'] ?? '240+ Niyaz Bookings') : ($product->reviews_count ?? '240+ Niyaz Bookings') }}" placeholder="e.g. 240+ Niyaz Bookings">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label font-bold">Product Description &amp; Sacred Details</label>
                                                            <textarea name="description" class="form-control" rows="3" placeholder="Enter detailed description for customers...">{{ is_array($product) ? ($product['description'] ?? '') : ($product->description ?? '') }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-gradient-navy fw-bold"><i class="bi bi-save me-1"></i> Update Product</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No products found in catalogue. Click "Add New Product" to add items.</td>
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.shop.product.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header btn-gradient-green text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Add New Product to Sacred Shop</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label font-bold">Product Name*</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g., Pure Warisi Gulab Attar" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Category*</label>
                        <select name="category" class="form-select font-bold">
                            @foreach($categories as $c)
                                <option value="{{ $c->slug }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Selling Price (₹)*</label>
                        <input type="number" step="0.01" name="price" class="form-control" placeholder="299" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">MRP Price (₹)</label>
                        <input type="number" step="0.01" name="mrp" class="form-control" placeholder="399">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Stock Quantity*</label>
                        <input type="number" name="stock" class="form-control" placeholder="50" value="50" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Volume ML / Size</label>
                        <input type="text" name="volume_ml" class="form-control" placeholder="12 ml / Medium">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Fabric / Material</label>
                        <input type="text" name="fabric_material" class="form-control" placeholder="e.g. Pure Cotton / Pure Attar">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Size Options</label>
                        <input type="text" name="size_options" class="form-control" placeholder="e.g. S, M, L, XL or 6ml, 12ml">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Upload Product Image (File)</label>
                        <input type="file" name="image_file" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Or Product Image URL</label>
                        <input type="text" name="image" class="form-control" placeholder="https://domain.com/path/to/image.jpg">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold text-success">⭐ Star Rating (e.g. 5.0, 4.9)</label>
                        <input type="number" step="0.1" min="1.0" max="5.0" name="rating" class="form-control" value="5.0" placeholder="5.0">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold text-success">💬 Reviews / Bookings Text</label>
                        <input type="text" name="reviews_count" class="form-control" placeholder="e.g. 240+ Niyaz Bookings" value="240+ Niyaz Bookings">
                    </div>
                    <div class="col-12">
                        <label class="form-label font-bold">Product Description &amp; Sacred Details</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Enter detailed description for customers..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-green fw-bold px-3"><i class="bi bi-check-circle me-1"></i> Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
