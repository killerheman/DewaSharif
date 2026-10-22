@extends('home.includes.master')

@section('content')
<div style="background: #f8fafc; padding: 40px 0 80px 0; min-height: 85vh;">
    <div class="container">
        
        <div class="row">
            <!-- LEFT SIDEBAR -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('home.customer.includes.customer_sidebar')
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="col-lg-9 col-md-8">
                <div style="background: #ffffff; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.04);">
                    <div style="border-bottom: 2px solid #f1f5f9; padding-bottom: 20px; margin-bottom: 25px;">
                        <h3 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 22px; display: flex; align-items: center; gap: 10px;">
                            <i class="fa fa-key" style="color: #16a34a;"></i> Change Account Password
                        </h3>
                        <p style="color: #64748b; font-size: 13.5px; margin: 5px 0 0 0; font-weight: 600;">
                            Update your login password or request an instant email reset link for enhanced security.
                        </p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert" style="background: #dcfce7; color: #15803d; border: 1.5px solid #86efac; padding: 15px 20px; border-radius: 10px;">
                            <i class="fa fa-check-circle me-2"></i> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="line-height: 1;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show rounded-3 shadow-sm mb-4" role="alert" style="background: #fef2f2; color: #991b1b; border: 1.5px solid #fca5a5; padding: 15px 20px; border-radius: 10px;">
                            <i class="fa fa-exclamation-triangle me-2"></i> {{ session('error') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="line-height: 1;">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-3 shadow-sm mb-4" style="background: #fef2f2; color: #991b1b; border: 1.5px solid #fca5a5; padding: 15px 20px; border-radius: 10px;">
                            <ul class="mb-0" style="padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- OPTION 1: DIRECT PASSWORD CHANGE FORM -->
                    <form action="{{ route('customer.changePassword.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reset_type" value="password_change">

                        <div class="form-group mb-3">
                            <label style="font-weight: 700; color: #334155; font-size: 13.5px;" for="cust_current_password">Current Password *</label>
                            <div style="position: relative;">
                                <input type="password" name="password" id="cust_current_password" class="form-control" placeholder="Enter your current password" style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-size: 14px; padding-right: 44px;">
                                <button type="button" class="toggle-password-btn" data-target="cust_current_password" title="Show / Hide Password" aria-label="Toggle password visibility" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; font-size: 16px; cursor: pointer; padding: 4px; z-index: 5;">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label style="font-weight: 700; color: #334155; font-size: 13.5px;" for="cust_new_password">New Password *</label>
                            <div style="position: relative;">
                                <input type="password" name="new_password" id="cust_new_password" required minlength="6" class="form-control" placeholder="Enter new password (min 6 characters)" style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-size: 14px; padding-right: 44px;">
                                <button type="button" class="toggle-password-btn" data-target="cust_new_password" title="Show / Hide Password" aria-label="Toggle password visibility" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; font-size: 16px; cursor: pointer; padding: 4px; z-index: 5;">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label style="font-weight: 700; color: #334155; font-size: 13.5px;" for="cust_confirm_password">Confirm New Password *</label>
                            <div style="position: relative;">
                                <input type="password" name="confirm_password" id="cust_confirm_password" required minlength="6" class="form-control" placeholder="Re-enter new password" style="border-radius: 8px; border: 1.5px solid #cbd5e1; height: 46px; font-size: 14px; padding-right: 44px;">
                                <button type="button" class="toggle-password-btn" data-target="cust_confirm_password" title="Show / Hide Password" aria-label="Toggle password visibility" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; font-size: 16px; cursor: pointer; padding: 4px; z-index: 5;">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <button type="submit" class="btn" style="background: #052c16; color: #ffffff; font-weight: 800; font-size: 14px; border-radius: 8px; padding: 12px 30px; border: none; box-shadow: 0 4px 12px rgba(5,44,22,0.25);">
                                <i class="fa fa-key me-1"></i> Update Password Now
                            </button>
                            <a href="{{ route('customer.account') }}" class="btn" style="background: #f1f5f9; color: #334155; font-weight: 700; font-size: 14px; border-radius: 8px; padding: 12px 24px; border: 1px solid #cbd5e1; text-decoration: none;">
                                Cancel
                            </a>
                        </div>
                    </form>

                    <!-- OPTION 2: EMAIL RESET LINK CARD -->
                    <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 14px; padding: 22px; margin-top: 35px;">
                        <h6 style="font-weight: 800; color: #052c16; margin-bottom: 8px; font-size: 15px; display: flex; align-items: center; gap: 8px;">
                            <i class="fa fa-envelope" style="color: #16a34a;"></i> Instant Email Password Reset Link
                        </h6>
                        <p style="font-size: 13.5px; color: #374151; margin-bottom: 15px; line-height: 1.6;">
                            Forgotten your current password? Click below to send an instant secure password reset link to your registered email address <strong>({{ $profile['email'] ?? 'shahzade.alam707@gmail.com' }})</strong>.
                        </p>
                        <form action="{{ route('customer.changePassword.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="reset_type" value="email_reset">
                            <button type="submit" class="btn text-white font-weight-bold" style="background: #16a34a; border: none; border-radius: 8px; padding: 10px 22px; font-size: 13.5px; box-shadow: 0 3px 10px rgba(22,163,74,0.2);">
                                🚀 Send Reset Link to My Email
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection
