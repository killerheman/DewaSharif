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
                            <h4 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 22px;">⭐ My Reviews &amp; Ratings</h4>
                            <small class="text-muted">Manage your personal feedback across Sacred Products, Hotels &amp; Cabs</small>
                        </div>
                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill font-weight-bold">
                            Total: {{ count($myReviews) }} Reviews
                        </span>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert" style="border-radius: 10px;">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    @endif

                    @forelse($myReviews as $rev)
                        <div style="background: #ffffff; border-radius: 14px; border: 1.5px solid #e2e8f0; padding: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); margin-bottom: 16px;">
                            <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                                <div>
                                    @if($rev->service_type === 'shop')
                                        <span style="font-size: 11px; font-weight: 800; color: #166534; background: #dcfce7; padding: 3px 10px; border-radius: 6px;">
                                            🛍️ SACRED PRODUCT
                                        </span>
                                    @elseif($rev->service_type === 'hotel')
                                        <span style="font-size: 11px; font-weight: 800; color: #075985; background: #e0f2fe; padding: 3px 10px; border-radius: 6px;">
                                            🏨 HOTEL STAY
                                        </span>
                                    @else
                                        <span style="font-size: 11px; font-weight: 800; color: #854d0e; background: #fef9c3; padding: 3px 10px; border-radius: 6px;">
                                            🚖 CAB SERVICE
                                        </span>
                                    @endif

                                    <h5 style="font-weight: 900; color: #0f172a; margin-top: 8px; margin-bottom: 4px; font-size: 17px;">
                                        {{ $rev->item_name ?? 'Sacred Offering' }}
                                    </h5>
                                    
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <span style="color: #f59e0b; font-size: 16px;">
                                            @for($i = 1; $i <= 5; $i++)
                                                {{ $i <= $rev->rating ? '★' : '☆' }}
                                            @endfor
                                        </span>
                                        <strong style="font-size: 13px; color: #334155;">{{ $rev->rating }}.0</strong>
                                        @if(!empty($rev->title))
                                            <span style="font-size: 13.5px; font-weight: 800; color: #0f172a; margin-left: 6px;">"{{ $rev->title }}"</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="text-right">
                                    <span style="font-size: 11.5px; color: #64748b; display: block;">
                                        {{ date('M d, Y', strtotime($rev->created_at ?? now())) }}
                                    </span>
                                    <span style="font-size: 11px; font-weight: 700; color: {{ strtolower($rev->status) === 'approved' ? '#16a34a' : '#ea580c' }}; background: {{ strtolower($rev->status) === 'approved' ? '#f0fdf4' : '#fff7ed' }}; padding: 2px 8px; border-radius: 4px; display: inline-block; margin-top: 4px;">
                                        ● {{ ucfirst($rev->status ?? 'approved') }}
                                    </span>
                                </div>
                            </div>

                            <p style="font-size: 14px; color: #475569; line-height: 1.5; margin-bottom: 14px; background: #f8fafc; padding: 12px; border-radius: 8px;">
                                "{{ $rev->comment }}"
                            </p>

                            <div class="d-flex justify-content-end gap-2">
                                <!-- Edit Button Trigger Modal -->
                                <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold px-3" data-toggle="modal" data-target="#editMyRev{{ $rev->id }}" style="border-radius: 6px;">
                                    <i class="fa fa-pencil"></i> Edit Review
                                </button>

                                <!-- Delete Form -->
                                <form action="{{ route('customer.reviews.destroy', $rev->id) }}" method="POST" onsubmit="return confirm('Do you really want to delete your review?');" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold px-3" style="border-radius: 6px;">
                                        <i class="fa fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- EDIT REVIEW MODAL FOR CUSTOMER -->
                        <div class="modal fade" id="editMyRev{{ $rev->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content" style="border-radius: 16px; overflow: hidden;">
                                    <form action="{{ route('customer.reviews.update', $rev->id) }}" method="POST">
                                        @csrf
                                        <div class="modal-header" style="background: #0f172a; color: #ffffff;">
                                            <h5 class="modal-title font-weight-bold">Edit Review: {{ $rev->item_name }}</h5>
                                            <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <div class="form-group">
                                                <label class="font-weight-bold">Your Rating (1 to 5 Stars)</label>
                                                <select name="rating" class="form-control font-weight-bold">
                                                    <option value="5" {{ $rev->rating == 5 ? 'selected' : '' }}>★★★★★ 5 Stars (Excellent Experience)</option>
                                                    <option value="4" {{ $rev->rating == 4 ? 'selected' : '' }}>★★★★☆ 4 Stars (Good)</option>
                                                    <option value="3" {{ $rev->rating == 3 ? 'selected' : '' }}>★★★☆☆ 3 Stars (Average)</option>
                                                    <option value="2" {{ $rev->rating == 2 ? 'selected' : '' }}>★★☆☆☆ 2 Stars (Below Expectations)</option>
                                                    <option value="1" {{ $rev->rating == 1 ? 'selected' : '' }}>★☆☆☆☆ 1 Star (Poor)</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Headline / Short Title</label>
                                                <input type="text" name="title" class="form-control" value="{{ $rev->title }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="font-weight-bold">Your Comments / Experience*</label>
                                                <textarea name="comment" class="form-control" rows="4" required>{{ $rev->comment }}</textarea>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary font-weight-bold" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary font-weight-bold px-4" style="background: #16a34a; border-color: #16a34a;">
                                                Update Review
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fa fa-star-o text-muted mb-2" style="font-size: 40px;"></i>
                            <h5 class="text-muted font-weight-bold">No Reviews Submitted Yet</h5>
                            <p class="text-muted small">When you book a Hotel, Cab, or Sacred Shop product, your verified reviews will appear here.</p>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
