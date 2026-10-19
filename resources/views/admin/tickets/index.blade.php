@extends('admin.includes.master')

@section('title', 'Customer Support Tickets')

@section('content')

<main class="app-main">
    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <h3 class="mb-0 fw-bold text-dark"><i class="bi bi-headset me-2 text-primary"></i>Customer Support Tickets</h3>
                    <p class="text-muted mb-0 small">Manage, resolve & reply to pilgrim & customer tickets</p>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Support Tickets</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">
            
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="card shadow-sm border-0 rounded-3 mb-4">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-bold mb-0 text-dark">
                        <i class="bi bi-ticket-perforated text-primary me-2"></i>All Tickets ({{ count($tickets) }})
                    </h5>
                    <div>
                        <a href="{{ route('admin.support-tickets.index') }}" class="btn btn-outline-secondary btn-sm rounded-2 me-2">
                            <i class="bi bi-list-task me-1"></i> DB Support Tickets
                        </a>
                        <a href="{{ route('admin.contacts') }}" class="btn btn-outline-info btn-sm rounded-2">
                            <i class="bi bi-envelope-open me-1"></i> Contact Inquiries
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-3">Ticket ID</th>
                                    <th>Customer & Contact</th>
                                    <th>Category</th>
                                    <th>Subject & Message</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tickets as $index => $ticket)
                                    @php
                                        $ticketId = $ticket['ticket_id'] ?? ($ticket['id'] ?? ('TKT-' . ($index + 1)));
                                        $status = $ticket['status'] ?? 'Open';
                                        $contactNo = $ticket['contact'] ?? '+91 9648777223';
                                        $cleanPhone = preg_replace('/[^0-9]/', '', $contactNo);
                                        if (strlen($cleanPhone) == 10) {
                                            $cleanPhone = '91' . $cleanPhone;
                                        }
                                    @endphp
                                    <tr>
                                        <td class="ps-3 fw-bold text-primary">
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">
                                                {{ $ticketId }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="fw-bold text-dark">{{ $ticket['customer_name'] ?? 'Pilgrim User' }}</div>
                                            <small class="text-muted"><i class="bi bi-telephone-fill me-1 small"></i>{{ $contactNo }}</small>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill">
                                                {{ $ticket['category'] ?? 'General Support' }}
                                            </span>
                                        </td>
                                        <td style="max-width: 280px;">
                                            <div class="fw-semibold text-dark text-truncate">{{ $ticket['subject'] ?? 'No Subject' }}</div>
                                            <div class="text-muted small text-truncate" title="{{ $ticket['message'] ?? '' }}">
                                                {{ $ticket['message'] ?? 'No detail provided.' }}
                                            </div>
                                            @if(!empty($ticket['admin_reply']))
                                                <div class="mt-1 p-1 px-2 rounded bg-light border-start border-3 border-success small text-success">
                                                    <strong>Admin Reply:</strong> {{ Str::limit($ticket['admin_reply'], 40) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @php $priority = $ticket['priority'] ?? 'High'; @endphp
                                            @if($priority === 'High' || $priority === 'Urgent')
                                                <span class="badge bg-danger text-white px-2 py-1">High</span>
                                            @elseif($priority === 'Medium')
                                                <span class="badge bg-warning text-dark px-2 py-1">Medium</span>
                                            @else
                                                <span class="badge bg-info text-white px-2 py-1">Normal</span>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.tickets.updateStatus', $ticketId) }}" method="POST" class="d-inline">
                                                @csrf
                                                <select name="status" onchange="this.form.submit()" class="form-select form-select-sm fw-bold border-0 
                                                    @if($status === 'Open') bg-danger-subtle text-danger 
                                                    @elseif($status === 'In Progress') bg-warning-subtle text-warning-emphasis 
                                                    @elseif($status === 'Resolved') bg-success-subtle text-success 
                                                    @else bg-secondary-subtle text-secondary @endif" style="width: auto; font-size: 12px; cursor: pointer;">
                                                    <option value="Open" {{ $status === 'Open' ? 'selected' : '' }}>🔴 Open</option>
                                                    <option value="In Progress" {{ $status === 'In Progress' ? 'selected' : '' }}>🟡 In Progress</option>
                                                    <option value="Resolved" {{ $status === 'Resolved' ? 'selected' : '' }}>🟢 Resolved</option>
                                                    <option value="Closed" {{ $status === 'Closed' ? 'selected' : '' }}>⚪ Closed</option>
                                                </select>
                                            </form>
                                        </td>
                                        <td class="small text-muted text-nowrap">
                                            {{ !empty($ticket['created_at']) ? date('d M Y, h:i A', strtotime($ticket['created_at'])) : 'Recent' }}
                                        </td>
                                        <td class="text-end pe-3 text-nowrap">
                                            <a href="https://wa.me/{{ $cleanPhone }}?text=Assalam%20Alaikum%20{{ urlencode($ticket['customer_name'] ?? 'User') }},%20Regarding%20your%20ticket%20{{ $ticketId }}:%20" 
                                               target="_blank" class="btn btn-sm btn-success rounded-circle me-1" title="WhatsApp Customer">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                            
                                            <button type="button" class="btn btn-sm btn-primary rounded-circle me-1" 
                                                    onclick="openReplyModal('{{ $ticketId }}', '{{ addslashes($ticket['customer_name'] ?? 'User') }}', '{{ addslashes($ticket['subject'] ?? '') }}')" title="Reply Ticket">
                                                <i class="bi bi-reply-fill"></i>
                                            </button>

                                            <form action="{{ route('admin.tickets.destroy', $ticketId) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete ticket #{{ $ticketId }}?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" title="Delete Ticket">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center py-5">
                                            <i class="bi bi-ticket-detailed text-muted fs-1 d-block mb-2"></i>
                                            <h6 class="text-muted fw-normal">No support tickets found yet.</h6>
                                        </td>
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

<!-- Reply Modal -->
<div class="modal fade" id="ticketReplyModal" tabindex="-1" aria-labelledby="ticketReplyModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <form id="ticketReplyForm" method="POST" action="">
          @csrf
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title fw-bold" id="ticketReplyModalLabel"><i class="bi bi-reply-all me-2"></i>Reply to Ticket</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <p class="mb-2"><strong>Ticket ID: </strong> <span id="replyModalTicketId" class="text-primary fw-bold"></span></p>
            <p class="mb-2"><strong>Customer: </strong> <span id="replyModalCustomerName"></span></p>
            <p class="mb-3"><strong>Subject: </strong> <span id="replyModalSubject" class="text-muted"></span></p>

            <div class="mb-3">
                <label for="adminReplyText" class="form-label fw-semibold">Admin Response / Note *</label>
                <textarea class="form-control" id="adminReplyText" name="reply" rows="4" placeholder="Enter resolution details or message for customer..." required></textarea>
            </div>
          </div>
          <div class="modal-footer bg-light">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary fw-bold"><i class="bi bi-send-fill me-1"></i> Submit Reply</button>
          </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
    function openReplyModal(ticketId, customerName, subject) {
        var form = document.getElementById('ticketReplyForm');
        form.action = "{{ url('admin/tickets') }}/" + ticketId + "/reply";
        document.getElementById('replyModalTicketId').innerText = "#" + ticketId;
        document.getElementById('replyModalCustomerName').innerText = customerName;
        document.getElementById('replyModalSubject').innerText = subject;
        var replyModal = new bootstrap.Modal(document.getElementById('ticketReplyModal'));
        replyModal.show();
    }
</script>
@endpush

@endsection
