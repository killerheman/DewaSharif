@extends('admin.includes.master')

@section('title', 'Contact Inquiries')

@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Contact Inquiries</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">All Inquiries</h3>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">{{ session('error') }}</div>
                            @endif
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Subject</th>
                                        <th>Message</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts as $contact)
                                        <tr>
                                            <td>{{ $contact->created_at->format('d M, Y h:i A') }}</td>
                                            <td>{{ $contact->name }}</td>
                                            <td>{{ $contact->email }}</td>
                                            <td>{{ $contact->mobile }}</td>
                                            <td>{{ $contact->subject }}</td>
                                            <td title="{{ $contact->message }}">{{ Str::limit($contact->message, 50) }}</td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-primary" onclick="openReplyModal(this)" data-contact-id="{{ $contact->id }}" data-contact-email="{{ $contact->email }}">
                                                    <i class="bi bi-reply"></i>
                                                </button>
                                                <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this inquiry?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No inquiries found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            
                            <div class="mt-3">
                                {{ $contacts->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="replyForm" method="POST" action="">
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="replyModalLabel">Reply to Inquiry</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p><strong>To: </strong> <span id="replyToEmail"></span></p>
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" value="Reply to your inquiry" required>
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Send Reply</button>
          </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
    function openReplyModal(button) {
        var id = button.dataset.contactId;
        var email = button.dataset.contactEmail;
        var form = document.getElementById('replyForm');
        // Construct the route dynamically
        form.action = "{{ url('admin/contacts') }}/" + id + "/reply";
        document.getElementById('replyToEmail').innerText = email;
        var replyModal = new bootstrap.Modal(document.getElementById('replyModal'));
        replyModal.show();
    }
</script>
@endpush

@endsection
