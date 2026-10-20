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
                    <div class="mb-4 pb-2" style="border-bottom: 1px solid #f1f5f9;">
                        <h4 style="font-weight: 900; color: #0b5e36; margin: 0; font-size: 22px;">💳 Invoices &amp; Payment History</h4>
                    </div><br>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle" style="font-size: 13.5px; border-radius: 8px; overflow: hidden;">
                            <thead style="background-color: #0b5e36 !important; color: #ffffff !important; font-weight: 800;">
                                <tr>
                                    <th style="background-color: #0b5e36 !important; color: #ffffff !important; padding: 14px 16px; border: none; font-weight: 800;">Invoice #</th>
                                    <th style="background-color: #0b5e36 !important; color: #ffffff !important; padding: 14px 16px; border: none; font-weight: 800;">Service Description</th>
                                    <th style="background-color: #0b5e36 !important; color: #ffffff !important; padding: 14px 16px; border: none; font-weight: 800;">Date</th>
                                    <th style="background-color: #0b5e36 !important; color: #ffffff !important; padding: 14px 16px; border: none; font-weight: 800;">Amount</th>
                                    <th style="background-color: #0b5e36 !important; color: #ffffff !important; padding: 14px 16px; border: none; font-weight: 800;">Status</th>
                                    <th style="background-color: #0b5e36 !important; color: #ffffff !important; padding: 14px 16px; border: none; font-weight: 800; text-align: center; width: 145px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                 @forelse($allInvoices as $inv)
                                <tr>
                                    <td class="font-weight-bold">{{ $inv['invoice_no'] ?? ('#' . $inv['code']) }}</td>
                                    <td>{{ $inv['title'] }}</td>
                                    <td>{{ $inv['date'] }}</td>
                                    <td class="font-weight-bold {{ $inv['status'] === 'FAILED / VOID' ? 'text-danger' : 'text-success' }}">₹{{ number_format($inv['amount']) }}</td>
                                    <td>
                                        @if($inv['status'] === 'PAID')
                                            <span class="badge" style="background: #dcfce7; color: #16a34a; padding: 5px 12px; border-radius: 12px; font-size: 11.5px; font-weight: 800;">✔ PAID</span>
                                        @elseif($inv['status'] === 'FAILED / VOID')
                                            <span class="badge" style="background: #fee2e2; color: #dc2626; padding: 5px 12px; border-radius: 12px; font-size: 11.5px; font-weight: 800;">❌ FAILED / VOID</span>
                                        @else
                                            <span class="badge" style="background: #fef3c7; color: #b45309; padding: 5px 12px; border-radius: 12px; font-size: 11.5px; font-weight: 800;">⏳ VERIFYING</span>
                                        @endif
                                    </td>
                                    <td class="text-center" style="width: 145px;">
                                        @php
                                            $btnBg = $inv['status'] === 'FAILED / VOID' ? '#dc2626' : '#0b5e36';
                                            $btnText = $inv['status'] === 'FAILED / VOID' 
                                                ? '❌ Void Doc' 
                                                : ($inv['type'] === 'cab' ? '📥 Duty Voucher' : ($inv['type'] === 'hotel' ? '📥 Invoice PDF' : '📥 Receipt PDF'));
                                        @endphp
                                        <a href="{{ route('customer.invoice', ['type' => $inv['type'], 'id' => $inv['id']]) }}" target="_blank" class="btn btn-sm text-white font-weight-bold d-inline-flex align-items-center justify-content-center" style="background: {{ $btnBg }}; color: #ffffff; border-radius: 6px; font-size: 11.5px; border: none; padding: 6px 10px; width: 128px; height: 32px; text-align: center; white-space: nowrap; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                                            {{ $btnText }}
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No billing records or invoices found.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
