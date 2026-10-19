@extends('admin.includes.master')
@section('title', 'Payment Gateway Details')

@section('content')

    <div class="app-content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h3 class="mb-0">Payment Gateway Details</h3>
                </div>

                <div class="col-sm-6 text-end">

                    <a href="{{ route('admin.payment-settings.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>

                    <a href="{{ route('admin.payment-settings.edit', $paymentSetting) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                </div>
            </div>
        </div>
    </div>

    <div class="app-content">
        <div class="container-fluid">

            <div class="card card-success">

                <div class="card-header">
                    <h3 class="card-title">Gateway Information</h3>
                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>
                            <th width="250">Gateway</th>
                            <td>{{ $paymentSetting->gateway }}</td>
                        </tr>

                        <tr>
                            <th>Display Name</th>
                            <td>{{ $paymentSetting->display_name }}</td>
                        </tr>

                        <tr>
                            <th>Key ID</th>
                            <td>{{ $paymentSetting->key_id ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Key Secret</th>
                            <td>{{ $paymentSetting->key_secret ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Client ID</th>
                            <td>{{ $paymentSetting->client_id ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Client Secret</th>
                            <td>{{ $paymentSetting->client_secret ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Merchant ID</th>
                            <td>{{ $paymentSetting->merchant_id ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Webhook Secret</th>
                            <td>{{ $paymentSetting->webhook_secret ?: '-' }}</td>
                        </tr>

                        <tr>
                            <th>Currency</th>
                            <td>{{ $paymentSetting->currency }}</td>
                        </tr>

                        <tr>
                            <th>Sandbox Mode</th>
                            <td>
                                <span class="badge bg-{{ $paymentSetting->sandbox_mode ? 'warning' : 'secondary' }}">
                                    {{ $paymentSetting->sandbox_mode ? 'Enabled' : 'Disabled' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-{{ $paymentSetting->is_active ? 'success' : 'danger' }}">
                                    {{ $paymentSetting->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Created At</th>
                            <td>{{ $paymentSetting->created_at->format('d M Y h:i A') }}</td>
                        </tr>

                        <tr>
                            <th>Updated At</th>
                            <td>{{ $paymentSetting->updated_at->format('d M Y h:i A') }}</td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>
    </div>

@endsection
