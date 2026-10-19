@extends('admin.includes.master')

@section('title', isset($hosting) ? 'FAQs — ' . $hosting->name : (isset($server) ? 'FAQs — ' . $server->name : (isset($emailService) ? 'FAQs — ' . $emailService->name : 'FAQs')))

@section('content')

    <div class="card card-success">

        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title mb-0">
                <i class="bi bi-question-circle me-1"></i>
                @if(isset($hosting))
                    FAQs &mdash; {{ $hosting->name }}
                @elseif(isset($server))
                    FAQs &mdash; {{ $server->name }}
                @elseif(isset($emailService))
                    FAQs &mdash; {{ $emailService->name }}
                @else
                    FAQs
                @endif
            </h3>

            @isset($hosting)
                <a href="{{ route('admin.hostings.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Hostings
                </a>
            @endisset
            @isset($server)
                <a href="{{ route('admin.servers.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Servers
                </a>
            @endisset
            @isset($emailService)
                <a href="{{ route('admin.email-services.index') }}" class="btn btn-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Email Services
                </a>
            @endisset
        </div>

        <div class="card-body">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            {{-- Add / Edit Form --}}
            <form action="{{ isset($editFaq) ? route('admin.faqs.update', $editFaq) : route('admin.faqs.store') }}"
                method="POST">
                @csrf
                @if(isset($editFaq)) @method('PUT') @endif

                {{-- Hidden polymorphic fields --}}
                @isset($hosting)
                    <input type="hidden" name="common_id" value="{{ $hosting->id }}">
                    <input type="hidden" name="common_type" value="{{ \App\Models\Hosting::class }}">
                @elseif(isset($server))
                    <input type="hidden" name="common_id" value="{{ $server->id }}">
                    <input type="hidden" name="common_type" value="{{ \App\Models\Server::class }}">
                @elseif(isset($emailService))
                    <input type="hidden" name="common_id" value="{{ $emailService->id }}">
                    <input type="hidden" name="common_type" value="{{ \App\Models\EmailService::class }}">
                @elseif(isset($editFaq))
                    <input type="hidden" name="common_id" value="{{ $editFaq->common_id }}">
                    <input type="hidden" name="common_type" value="{{ $editFaq->common_type }}">
                @endisset

                <div class="row g-3">

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Question <span class="text-danger">*</span></label>
                        <input type="text" name="question"
                            class="form-control @error('question') is-invalid @enderror"
                            placeholder="Enter FAQ question"
                            value="{{ old('question', $editFaq->question ?? '') }}">
                        @error('question')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Answer <span class="text-danger">*</span></label>
                        <textarea name="answer" id="editor" rows="4"
                            class="form-control @error('answer') is-invalid @enderror"
                            placeholder="Enter FAQ answer">{{ old('answer', $editFaq->answer ?? '') }}</textarea>
                        @error('answer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Sort Order</label>
                        <input type="number" name="sort_order"
                            class="form-control @error('sort_order') is-invalid @enderror"
                            value="{{ old('sort_order', $editFaq->sort_order ?? ($nextSortOrder ?? 1)) }}">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 d-flex align-items-end">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                id="is_active"
                                {{ old('is_active', $editFaq->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>

                </div>

                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-{{ isset($editFaq) ? 'check-circle' : 'plus-circle' }}"></i>
                        {{ isset($editFaq) ? 'Update FAQ' : 'Save FAQ' }}
                    </button>

                    @isset($editFaq)
                        @if(isset($hosting))
                            <a href="{{ route('admin.faqs.byHosting', $hosting) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        @elseif(isset($server))
                            <a href="{{ route('admin.faqs.byServer', $server) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        @elseif(isset($emailService))
                            <a href="{{ route('admin.faqs.byEmailService', $emailService) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        @else
                            <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Cancel
                            </a>
                        @endif
                    @endisset
                </div>

            </form>


            <hr>


            @forelse($faqs as $index => $faq)
                <div class="accordion mb-2" id="faq_accordion_{{ $faq->id }}">
                    <div class="accordion-item border rounded shadow-sm">

                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed fw-semibold" type="button"
                                data-bs-toggle="collapse"
                                data-bs-target="#faq_collapse_{{ $faq->id }}"
                                aria-expanded="false"
                                aria-controls="faq_collapse_{{ $faq->id }}">

                                <span class="badge bg-secondary me-2">#{{ $faqs->firstItem() + $index }}</span>
                                {{ $faq->question }}

                                <span class="ms-auto me-3 d-flex align-items-center gap-2">
                                    @if($faq->is_active)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                    <span class="badge bg-light text-dark border">Sort: {{ $faq->sort_order }}</span>
                                </span>

                            </button>
                        </h2>

                        <div id="faq_collapse_{{ $faq->id }}" class="accordion-collapse collapse">
                            <div class="accordion-body">

                                <p class="mb-3 text-muted" style="white-space: pre-line;">{{ $faq->answer }}</p>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.faqs.edit', $faq) }}{{ isset($hosting) ? '?hosting=' . $hosting->id : (isset($server) ? '?server=' . $server->id : (isset($emailService) ? '?email_service=' . $emailService->id : '')) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST"
                                        onsubmit="return confirm('Is FAQ ko delete karna chahte hain?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            @empty
                <div class="text-center text-muted py-5">
                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                    No FAQs found.
                </div>
            @endforelse

            {{ $faqs->links() }}


        </div>

    </div>

@endsection
