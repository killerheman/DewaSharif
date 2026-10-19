@extends('admin.includes.master')

@section('title', 'Manage Store Categories | DewaSharif Admin')

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
    .badge-gradient-green {
        background: linear-gradient(135deg, #064e3b 0%, #047857 45%, #10b981 85%, #34d399 100%) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: 0 2px 6px rgba(4, 120, 87, 0.35);
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
                        <i class="bi bi-tags-fill text-success me-2"></i><span class="title-gradient-green">Store Categories Management</span>
                    </h3>
                    <small class="text-muted">Manage Shop Categories, Colors, Badges, Features &amp; Real-Time Dynamic Home Cards</small>
                </div>
                <div class="col-sm-6 text-end">
                    <a href="{{ route('admin.shop.index') }}" class="btn btn-outline-secondary me-2 rounded-pill px-3 py-2 fw-bold">
                        <i class="bi bi-arrow-left me-1"></i> Products Catalogue
                    </a>
                    <button class="btn btn-gradient-green fw-bold px-3 py-2 shadow-sm rounded-pill" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                        <i class="bi bi-plus-circle me-1"></i> Add New Category
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
                        <i class="bi bi-grid-3x3-gap-fill me-2 text-primary"></i>Sacred Shop Categories (MySQL Real-Time Dynamic)
                    </h5>
                    <span class="badge btn-gradient-navy px-3 py-2 rounded-pill">Total Categories: {{ count($categories) }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 table-aligned">
                            <thead class="custom-table-header">
                                <tr>
                                    <th class="ps-3">#Order</th>
                                    <th>Category Icon / Image</th>
                                    <th>Category Name</th>
                                    <th>Slug URL</th>
                                    <th>Theme Color &amp; Badge</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $cat)
                                    <tr>
                                        <td class="ps-3 fw-bold text-muted">
                                            <span class="badge bg-light text-dark border px-2 py-1 fs-7">#{{ $cat->order_num ?? $cat->id }}</span>
                                        </td>
                                        <td>
                                            <div style="width: 52px; height: 52px; border-radius: 10px; overflow: hidden; border: 2px solid {{ $cat->theme_color ?? '#e2e8f0' }}; background: #f8fafc; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 6px rgba(0,0,0,0.1);">
                                                @if(!empty($cat->image))
                                                    <img src="{{ $cat->image }}" alt="{{ $cat->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <i class="bi bi-box-seam text-secondary fs-4"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-dark fs-6">{{ $cat->name }}</strong>
                                            @if(!empty($cat->description))
                                                <div class="text-muted small text-truncate" style="max-width: 250px;">{{ $cat->description }}</div>
                                            @endif
                                        </td>
                                        <td>
                                            <code class="px-2 py-1 bg-light rounded text-primary fw-bold">/shops/{{ $cat->slug }}</code>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <span style="display: inline-block; width: 18px; height: 18px; border-radius: 50%; background: {{ $cat->theme_color ?? '#10b981' }}; border: 2px solid #fff; box-shadow: 0 1px 4px rgba(0,0,0,0.3);"></span>
                                                <span class="small fw-bold" style="color: {{ $cat->theme_color ?? '#333' }};">
                                                    {{ $cat->badge_text ?? 'STANDARD' }}
                                                </span>
                                            </div>
                                            @if(!empty($cat->tag_text))
                                                <small class="text-muted d-block mt-0.5">Tag: <span class="badge bg-secondary-subtle text-secondary">{{ $cat->tag_text }}</span></small>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.shop.categories.toggle', $cat->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @if(strtolower($cat->status) === 'active')
                                                    <button type="submit" class="badge badge-gradient-green border-0 px-3 py-1.5 rounded-pill shadow-xs cursor-pointer" title="Click to Toggle">
                                                        <i class="bi bi-check-circle me-1"></i> Active
                                                    </button>
                                                @else
                                                    <button type="submit" class="badge badge-gradient-red border-0 px-3 py-1.5 rounded-pill shadow-xs cursor-pointer" title="Click to Toggle">
                                                        <i class="bi bi-x-circle me-1"></i> Inactive
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                        <td class="text-end pe-3">
                                            <button class="btn btn-sm btn-outline-primary fw-bold rounded-pill me-1" data-bs-toggle="modal" data-bs-target="#editCatModal{{ $cat->id }}">
                                                <i class="bi bi-pencil-square"></i> Edit
                                            </button>

                                            <form action="{{ route('admin.shop.categories.destroy', $cat->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category? Any assigned products will remain.');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger fw-bold rounded-pill">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Category Modal -->
                                    <div class="modal fade" id="editCatModal{{ $cat->id }}" tabindex="-1">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.shop.categories.update', $cat->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-header btn-gradient-navy text-white">
                                                        <h5 class="modal-title fw-bold"><i class="bi bi-pencil-square me-2"></i>Edit Category: {{ $cat->name }}</h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body row g-3 text-start">
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Category Name*</label>
                                                            <input type="text" name="name" class="form-control" value="{{ $cat->name }}" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label font-bold">Slug URL*</label>
                                                            <input type="text" name="slug" class="form-control" value="{{ $cat->slug }}" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label font-bold">Order / Sequence*</label>
                                                            <input type="number" step="0.5" name="order_num" class="form-control" value="{{ $cat->order_num ?? 10 }}">
                                                        </div>

                                                        <div class="col-md-4">
                                                            <label class="form-label font-bold">Theme Color (Hex)</label>
                                                            <div class="input-group">
                                                                <input type="color" class="form-control form-control-color" value="{{ $cat->theme_color ?? '#10b981' }}" onchange="document.getElementById('hex_{{ $cat->id }}').value = this.value">
                                                                <input type="text" id="hex_{{ $cat->id }}" name="theme_color" class="form-control" value="{{ $cat->theme_color ?? '#10b981' }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label font-bold">Top Badge Text</label>
                                                            <input type="text" name="badge_text" class="form-control" value="{{ $cat->badge_text ?? '' }}" placeholder="e.g. 🌙 TABARRUKAT">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label font-bold">Image Corner Tag</label>
                                                            <input type="text" name="tag_text" class="form-control" value="{{ $cat->tag_text ?? '' }}" placeholder="e.g. Starting ₹199">
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label font-bold">Short Card Description</label>
                                                            <textarea name="description" class="form-control" rows="2" placeholder="Brief 1-2 sentence description shown on the home page card">{{ $cat->description ?? '' }}</textarea>
                                                        </div>

                                                        <div class="col-12">
                                                            <label class="form-label font-bold">Card Features (3 Bullet Points, 1 per line)</label>
                                                            <textarea name="features" class="form-control" rows="3" placeholder="✔ Feature 1&#10;✔ Feature 2&#10;✔ Feature 3">{{ $cat->features ?? '' }}</textarea>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Button CTA Text</label>
                                                            <input type="text" name="button_text" class="form-control" value="{{ $cat->button_text ?? "Explore {$cat->name} →" }}">
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Status</label>
                                                            <select name="status" class="form-select">
                                                                <option value="active" {{ strtolower($cat->status) === 'active' ? 'selected' : '' }}>Active</option>
                                                                <option value="inactive" {{ strtolower($cat->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Upload Category Icon / Image File</label>
                                                            <input type="file" name="image_file" class="form-control" accept="image/*">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label font-bold">Or Image URL</label>
                                                            <input type="text" name="image" class="form-control" value="{{ $cat->image }}">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-gradient-navy fw-bold px-4"><i class="bi bi-save me-1"></i> Save Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">No categories found. Click "Add New Category" above.</td>
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

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.shop.categories.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header btn-gradient-green text-white">
                    <h5 class="modal-title fw-bold"><i class="bi bi-plus-circle me-2"></i>Create New Shop Category</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body row g-3">
                    <div class="col-md-6">
                        <label class="form-label font-bold">Category Name*</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Scenery, Paintings & Calligraphy" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-bold">Slug URL (Optional)</label>
                        <input type="text" name="slug" class="form-control" placeholder="e.g. calligraphy">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label font-bold">Order / Sequence*</label>
                        <input type="number" step="0.5" name="order_num" class="form-control" value="16" placeholder="e.g. 10">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label font-bold">Theme Color (Hex)</label>
                        <div class="input-group">
                            <input type="color" class="form-control form-control-color" value="#10b981" onchange="document.getElementById('new_hex').value = this.value">
                            <input type="text" id="new_hex" name="theme_color" class="form-control" value="#10b981">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-bold">Top Badge Text</label>
                        <input type="text" name="badge_text" class="form-control" placeholder="e.g. 🎨 ART & CALLIGRAPHY">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label font-bold">Image Corner Tag</label>
                        <input type="text" name="tag_text" class="form-control" placeholder="e.g. Handcrafted Frames">
                    </div>

                    <div class="col-12">
                        <label class="form-label font-bold">Short Card Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Brief 1-2 sentence description shown on the home page card"></textarea>
                    </div>

                    <div class="col-12">
                        <label class="form-label font-bold">Card Features (3 Bullet Points, 1 per line)</label>
                        <textarea name="features" class="form-control" rows="3" placeholder="✔ 100% Genuine Quality&#10;✔ Fast Delivery&#10;✔ Authentic Craftsmen"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label font-bold">Button CTA Text</label>
                        <input type="text" name="button_text" class="form-control" placeholder="e.g. Explore Category →">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label font-bold">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" selected>Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label font-bold">Upload Category Icon / Image File</label>
                        <input type="file" name="image_file" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label font-bold">Or Image URL</label>
                        <input type="text" name="image" class="form-control" placeholder="/home/images/dewasharif/dewapage/example.jpg">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-gradient-green fw-bold px-4"><i class="bi bi-check-circle me-1"></i> Save Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
