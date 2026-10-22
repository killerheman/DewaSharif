@extends('home.includes.master')

@section('content')
@php
    $rawPhone = $profile['phone'] ?? '7398072236';
    $cleanPhone = preg_replace('/^\+?(?:91)?\s*/', '', $rawPhone);
    $displayPhone = '+91 ' . ($cleanPhone ?: '7398072236');
    $displayUserId = '#' . (7000 + (int)($profile['id'] ?? 1));
@endphp

<div style="background: #f8fafc; padding: 40px 0 80px 0; min-height: 85vh;">
    <div class="container">
        
        <div class="row">
            <!-- LEFT SIDEBAR -->
            <div class="col-lg-3 col-md-4 mb-4">
                @include('home.customer.includes.customer_sidebar')
            </div>

            <!-- MAIN CONTENT AREA -->
            <div class="col-lg-9 col-md-8">
                <div style="background: #ffffff; border-radius: 18px; border: 1.5px solid #e2e8f0; padding: 35px; box-shadow: 0 4px 20px rgba(0,0,0,0.03);">
                    
                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert" style="background: #dcfce7; color: #15803d; border: 1.5px solid #86efac; padding: 14px 20px; font-weight: 700; border-radius: 10px;">
                        ✔ {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="line-height: 1;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    @if(empty($editMode))
                    <!-- ========================================== -->
                    <!-- READ-ONLY VIEW MODE -->
                    <!-- ========================================== -->
                    <div class="d-flex justify-content-between align-items-center" style="border-bottom: 2px solid #f1f5f9; padding-bottom: 24px; margin-bottom: 28px; gap: 15px; flex-wrap: wrap;">
                        <h3 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 23px; letter-spacing: -0.3px; line-height: 1.2;">
                            My Account Information
                        </h3>
                        <a href="{{ route('customer.account', ['edit' => 1]) }}" class="btn" style="background: #052c16; color: #ffffff; font-weight: 800; font-size: 13px; border-radius: 8px; padding: 8px 20px; border: none; box-shadow: 0 3px 10px rgba(5,44,22,0.2); white-space: nowrap; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; line-height: 1.2;">
                            <i class="fa fa-pencil-square-o"></i> Edit Profile
                        </a>
                    </div>

                    <!-- 1-ROW LIST (DARK LABEL, CLEAN GREEN TEXT FOR DATA) -->
                    <div class="row" style="font-size: 15px; color: #334155;">
                        
                        <!-- USER ID -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 14px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block;">User ID</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 15px; display: inline-block;">{{ $displayUserId }}</strong>
                            </div>
                        </div>

                        <!-- FULL NAME -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 14px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block;">Full Name</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 15px; display: inline-block;">{{ $profile['name'] ?? 'User' }}</strong>
                            </div>
                        </div>

                        <!-- EMAIL ADDRESS -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 14px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block;">Email Address</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 14.5px; display: inline-block;">{{ $profile['email'] ?? 'shahzade.alam707@gmail.com' }}</strong>
                            </div>
                        </div>

                        <!-- PHONE NUMBER -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 14px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block;">Phone Number</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 14.5px; display: inline-block;">{{ $displayPhone }}</strong>
                            </div>
                        </div>

                        <!-- COUNTRY -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 14px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block;">Country</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 14.5px; display: inline-block;">{{ $profile['country'] ?? 'India' }}</strong>
                            </div>
                        </div>

                        <!-- STATE / PROVINCE -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 14px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block;">State / Province</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 14.5px; display: inline-block;">{{ $profile['state'] ?? 'Uttar Pradesh' }}</strong>
                            </div>
                        </div>

                        <!-- CITY -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 14px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block;">City</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 14.5px; display: inline-block;">{{ $profile['city'] ?? 'Barabanki' }}</strong>
                            </div>
                        </div>

                        <!-- POSTAL / ZIP CODE -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 14px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block;">Postal / ZIP Code</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 14.5px; display: inline-block;">{{ $profile['pincode'] ?? '225301' }}</strong>
                            </div>
                        </div>

                        <!-- ADDRESS -->
                        <div class="col-12 mb-3">
                            <div style="background: #f8fafc; padding: 16px 24px; border-radius: 10px; border: 1px solid #f1f5f9; display: flex; align-items: flex-start; gap: 20px;">
                                <span style="color: #0f172a; font-weight: 900; font-size: 14.5px; width: 180px; min-width: 160px; display: inline-block; pt-1;">Full Address</span>
                                <strong style="color: #15803d; font-weight: 800; font-size: 14px; display: inline-block; line-height: 1.6;">{{ $profile['address'] ?? 'House No 6 , Mohalla Kachehran 2, Dewa Sharif, Barabanki, UP - 225301' }}</strong>
                            </div>
                        </div>

                    </div>

                    <!-- CHANGE PASSWORD BAR -->
                    <div onclick="window.location.href='{{ route('customer.changePassword') }}'" style="background: #ffffff; border-radius: 12px; border-left: 5px solid #052c16; padding: 18px 24px; margin-top: 20px; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 15px; box-shadow: 0 2px 12px rgba(0,0,0,0.03); border-top: 1px solid #f1f5f9; border-right: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; cursor: pointer;">
                        <div style="font-size: 15px; font-weight: 700; color: #334155;">
                            Change Password: <span style="letter-spacing: 3px; color: #64748b; font-weight: 900;">*********</span>
                        </div>
                        <div>
                            <a href="{{ route('customer.changePassword') }}" class="btn" style="background: #052c16; color: #ffffff; font-weight: 800; font-size: 13px; border-radius: 8px; padding: 8px 20px; border: none; box-shadow: 0 3px 10px rgba(5,44,22,0.2); white-space: nowrap; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; line-height: 1.2;">
                                <i class="fa fa-key"></i> Change Password
                            </a>
                        </div>
                    </div>

                    @else
                    <!-- ========================================== -->
                    <!-- EDIT FORM MODE (PREVIOUS DEDICATED LAYOUT RESTORED) -->
                    <!-- ========================================== -->
                    <div class="d-flex justify-content-between align-items-center" style="border-bottom: 2px solid #f1f5f9; padding-bottom: 24px; margin-bottom: 28px; gap: 15px; flex-wrap: wrap;">
                        <div>
                            <h3 style="font-weight: 900; color: #0f172a; margin: 0; font-size: 23px; letter-spacing: -0.3px; line-height: 1.2;">
                                Edit My Account Information
                            </h3>
                            <small style="color: #64748b; font-size: 13px; font-weight: 600;">Update your profile details &amp; contact address below.</small>
                        </div>
                    </div>

                    <form action="{{ route('customer.account.store') }}" method="POST" enctype="multipart/form-data" id="profileUpdateForm" autocomplete="off" onsubmit="submitProfileFormAjax(event)">
                        @csrf
                        <input type="hidden" name="avatar_base64" id="avatar_base64">
                        <input type="hidden" name="remove_avatar" id="remove_avatar" value="0">

                        <!-- WHATSAPP STYLE INTERACTIVE PROFILE PHOTO EDIT -->
                        <div class="text-center" style="border-bottom: 1.5px solid #f1f5f9; padding-bottom: 24px; margin-bottom: 35px;">
                            <div style="position: relative; display: inline-block; cursor: pointer;">
                                <label for="avatar-file-input" style="cursor: pointer; margin: 0; display: block; position: relative;" title="Click to change profile photo">
                                    <div id="avatar-preview-initials" style="width: 110px; height: 110px; background: linear-gradient(135deg, #052c16 0%, #16a34a 100%); color: #ffffff; font-size: 42px; font-weight: 900; border-radius: 50%; display: {{ !empty($profile['avatar']) ? 'none' : 'flex' }}; align-items: center; justify-content: center; border: 3.5px solid #052c16; box-shadow: 0 8px 20px rgba(5,44,22,0.2);">
                                        {{ strtoupper(substr($profile['name'] ?? 'S', 0, 1)) }}
                                    </div>
                                    <img id="avatar-preview-img" src="{{ $profile['avatar'] ?? '' }}" style="width: 110px; height: 110px; border-radius: 50%; object-fit: cover; border: 3.5px solid #052c16; box-shadow: 0 8px 20px rgba(5,44,22,0.2); display: {{ !empty($profile['avatar']) ? 'block' : 'none' }}; transition: transform 0.2s ease;">
                                    
                                    <!-- CAMERA BADGE ICON -->
                                    <span style="position: absolute; bottom: 4px; right: 4px; background: #052c16; color: #ffffff; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 15px; border: 2.5px solid #ffffff; box-shadow: 0 4px 10px rgba(0,0,0,0.3);">
                                        📷
                                    </span>
                                </label>
                                <input type="file" name="avatar" id="avatar-file-input" accept="image/*" style="display: none;" onchange="handleImagePreview(this)">
                            </div>
                            <div class="mt-3 text-center" style="display: flex; flex-direction: column; align-items: center; gap: 8px;">
                                <label for="avatar-file-input" style="color: #052c16; font-size: 13.5px; font-weight: 800; cursor: pointer; text-decoration: underline; margin: 0;">
                                    📷 Change Photo
                                </label>
                                <button type="button" id="btn-remove-avatar" onclick="handleRemovePhoto()" style="background: none; border: none; color: #dc2626; font-size: 13px; font-weight: 800; cursor: pointer; text-decoration: underline; padding: 0; margin: 0; display: {{ !empty($profile['avatar']) ? 'inline-block' : 'none' }};">
                                    🗑️ Remove Photo
                                </button>
                            </div>
                        </div>

                        <!-- 2-COLUMN FORM INPUTS -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 700; color: #334155; font-size: 13.5px;">First Name *</label>
                                <input type="text" name="first_name" class="form-control" autocomplete="off" value="{{ $profile['first_name'] ?? 'Shahzade' }}" required style="border-radius: 8px; height: 44px; font-size: 14px; border: 1.5px solid #cbd5e1;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Last Name</label>
                                <input type="text" name="last_name" class="form-control" autocomplete="off" value="{{ $profile['last_name'] ?? 'Alam' }}" style="border-radius: 8px; height: 44px; font-size: 14px; border: 1.5px solid #cbd5e1;">
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Email Address *</label>
                                <input type="email" name="email" class="form-control" autocomplete="off" value="{{ $profile['email'] ?? 'shahzade.alam707@gmail.com' }}" required style="border-radius: 8px; height: 44px; font-size: 14px; border: 1.5px solid #cbd5e1;">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Phone Number *</label>
                                <input type="text" name="phone" class="form-control" autocomplete="off" value="{{ $cleanPhone }}" required style="border-radius: 8px; height: 44px; font-size: 14px; border: 1.5px solid #cbd5e1;">
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Country *</label>
                                <select id="chk_country" name="country" class="form-control" onchange="onWorldCountryChange()" style="border-radius: 8px; height: 44px; font-size: 14px; border: 1.5px solid #cbd5e1;">
                                    <option value="{{ $profile['country'] ?? 'India' }}">{{ $profile['country'] ?? 'India' }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 700; color: #334155; font-size: 13.5px;">State / Province</label>
                                <select id="chk_state" name="state" class="form-control" onchange="onWorldStateChange()" style="border-radius: 8px; height: 44px; font-size: 14px; border: 1.5px solid #cbd5e1;">
                                    <option value="{{ $profile['state'] ?? 'Uttar Pradesh' }}">{{ $profile['state'] ?? 'Uttar Pradesh' }}</option>
                                </select>
                            </div>
                        </div><br>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 700; color: #334155; font-size: 13.5px;">City</label>
                                <select id="chk_city" name="city" class="form-control" style="border-radius: 8px; height: 44px; font-size: 14px; border: 1.5px solid #cbd5e1;">
                                    <option value="{{ $profile['city'] ?? 'Barabanki' }}">{{ $profile['city'] ?? 'Barabanki' }}</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Postal / ZIP Code</label>
                                <input type="text" name="pincode" class="form-control" autocomplete="off" value="{{ $profile['pincode'] ?? '225301' }}" style="border-radius: 8px; height: 44px; font-size: 14px; border: 1.5px solid #cbd5e1;">
                            </div>
                        </div><br>

                        <div class="form-group mb-4">
                            <label style="font-weight: 700; color: #334155; font-size: 13.5px;">Full Address</label>
                            <textarea name="address" class="form-control" rows="3" autocomplete="off" style="border-radius: 8px; font-size: 14px; border: 1.5px solid #cbd5e1;">{{ $profile['address'] ?? 'House No 6 , Mohalla Kachehran 2, Dewa Sharif, Barabanki, UP - 225301' }}</textarea>
                        </div>

                        <!-- ACTION BUTTONS -->
                        <div class="d-flex justify-content-end align-items-center gap-3 mt-4 pt-3" style="border-top: 1px solid #f1f5f9;">
                            <a href="{{ route('customer.account') }}" class="btn" style="background: #ef4444; color: #ffffff; font-weight: 800; font-size: 14px; border-radius: 8px; padding: 10px 24px; text-decoration: none; margin-right: 10px; border: none; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.25);">
                                Cancel
                            </a>
                            <button type="submit" class="btn" style="background: #052c16; color: #ffffff; font-weight: 800; font-size: 14px; border-radius: 8px; padding: 10px 26px; border: none; box-shadow: 0 4px 12px rgba(5,44,22,0.25);">
                                ✔ Update Profile
                            </button>
                        </div>
                    </form>
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>

<!-- CHANGE PASSWORD / EMAIL RESET MODAL -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
            <div class="modal-header" style="border-bottom: 1px solid #f1f5f9; padding: 20px 25px;">
                <h5 class="modal-title font-weight-bold" id="changePasswordModalLabel" style="color: #0f172a; font-size: 18px; font-weight: 900;">
                    🔑 Account Security &amp; Password
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="line-height: 1;">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body" style="padding: 25px;">
                <!-- OPTION 1: EMAIL RESET LINK -->
                <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 12px; padding: 18px; margin-bottom: 20px;">
                    <h6 style="font-weight: 800; color: #052c16; margin-bottom: 6px; font-size: 14px;">
                        📧 Instant Email Password Reset
                    </h6>
                    <p style="font-size: 13px; color: #374151; margin-bottom: 12px; line-height: 1.5;">
                        Click below to dispatch a secure password reset link to your registered email address <strong>({{ $profile['email'] ?? 'shahzade.alam707@gmail.com' }})</strong>.
                    </p>
                    <form action="{{ route('customer.account.password') }}" method="POST">
                        @csrf
                        <input type="hidden" name="reset_type" value="email_reset">
                        <button type="submit" class="btn btn-sm text-white font-weight-bold w-100" style="background: #052c16; border: none; border-radius: 8px; padding: 10px;">
                            🚀 Send Reset Link to My Email
                        </button>
                    </form>
                </div>

                <div class="text-center my-3 text-muted" style="font-size: 12px; font-weight: 700; position: relative;">
                    <span style="background: #fff; padding: 0 10px; position: relative; z-index: 1;">OR SET NEW PASSWORD DIRECTLY</span>
                    <hr style="position: absolute; top: 50%; left: 0; right: 0; margin: 0; z-index: 0;">
                </div>

                <!-- OPTION 2: DIRECT PASSWORD CHANGE FORM -->
                <form action="{{ route('customer.account.password') }}" method="POST">
                    @csrf
                    <input type="hidden" name="reset_type" value="password_change">
                    <div class="form-group mb-3">
                        <label style="font-weight: 700; color: #334155; font-size: 13px;" for="cust_acc_new_password">New Password *</label>
                        <div style="position: relative;">
                            <input type="password" name="new_password" id="cust_acc_new_password" required minlength="6" class="form-control" placeholder="Enter new password" style="border-radius: 8px; height: 44px; border: 1.5px solid #cbd5e1; padding-right: 44px;">
                            <button type="button" class="toggle-password-btn" data-target="cust_acc_new_password" title="Show / Hide Password" aria-label="Toggle password visibility" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; font-size: 16px; cursor: pointer; padding: 4px; z-index: 5;">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group mb-4">
                        <label style="font-weight: 700; color: #334155; font-size: 13px;" for="cust_acc_confirm_password">Confirm New Password *</label>
                        <div style="position: relative;">
                            <input type="password" name="confirm_password" id="cust_acc_confirm_password" required minlength="6" class="form-control" placeholder="Re-enter new password" style="border-radius: 8px; height: 44px; border: 1.5px solid #cbd5e1; padding-right: 44px;">
                            <button type="button" class="toggle-password-btn" data-target="cust_acc_confirm_password" title="Show / Hide Password" aria-label="Toggle password visibility" style="position: absolute; right: 10px; top: 50%; transform: translateY(-50%); background: none; border: none; color: #64748b; font-size: 16px; cursor: pointer; padding: 4px; z-index: 5;">
                                <i class="fa fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="btn text-white font-weight-bold w-100" style="background: #052c16; border: none; border-radius: 8px; height: 44px; font-size: 14px;">
                        Update Password Now
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function handleImagePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            var img = document.getElementById('avatar-preview-img');
            var initials = document.getElementById('avatar-preview-initials');
            var base64Input = document.getElementById('avatar-base64');
            var removeInput = document.getElementById('remove_avatar');
            var btnRemove = document.getElementById('btn-remove-avatar');
            
            if (img) {
                img.src = e.target.result;
                img.style.display = 'block';
            }
            if (initials) {
                initials.style.display = 'none';
            }
            if (base64Input) {
                base64Input.value = e.target.result;
            }
            if (removeInput) {
                removeInput.value = '0';
            }
            if (btnRemove) {
                btnRemove.style.display = 'inline-block';
            }
        };
        reader.readAsDataURL(input.files[0]);
    }
}

function handleRemovePhoto() {
    var img = document.getElementById('avatar-preview-img');
    var initials = document.getElementById('avatar-preview-initials');
    var base64Input = document.getElementById('avatar-base64');
    var fileInput = document.getElementById('avatar-file-input');
    var removeInput = document.getElementById('remove_avatar');
    var btnRemove = document.getElementById('btn-remove-avatar');

    if (img) {
        img.src = '';
        img.style.display = 'none';
    }
    if (initials) {
        initials.style.display = 'flex';
    }
    if (base64Input) base64Input.value = '';
    if (fileInput) fileInput.value = '';
    if (removeInput) removeInput.value = '1';
    if (btnRemove) btnRemove.style.display = 'none';
}

function submitProfileFormAjax(e) {
    e.preventDefault();
    var form = document.getElementById('profileUpdateForm');
    if (!form) return;
    
    var btn = form.querySelector('button[type="submit"]');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '⏳ Updating...';
    }

    var formData = new FormData(form);

    fetch(form.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(function(res) {
        return res.json().catch(function() { return { status: true }; });
    })
    .then(function(data) {
        window.location.href = "{{ route('customer.account') }}";
    })
    .catch(function(err) {
        window.location.href = "{{ route('customer.account') }}";
    });
}

var initialProfileCountry = "{{ $profile['country'] ?? 'India' }}";
var initialProfileState = "{{ $profile['state'] ?? 'Uttar Pradesh' }}";
var initialProfileCity = "{{ $profile['city'] ?? 'Barabanki' }}";

var worldCountriesCache = [];
var worldStatesCache = {};
var worldCitiesCache = {};
var isInitialLoad = true;

function loadWorldCountries() {
    var countrySel = document.getElementById('chk_country');
    if (!countrySel) return;

    fetch('https://countriesnow.space/api/v0.1/countries/iso')
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json && json.data && Array.isArray(json.data) && json.data.length > 0) {
                worldCountriesCache = json.data;
                renderWorldCountryOptions(json.data);
            } else {
                onWorldCountryChange();
            }
        })
        .catch(function(err) {
            console.log("Using fallback country select", err);
            onWorldCountryChange();
        });
}

function renderWorldCountryOptions(countriesList) {
    var countrySel = document.getElementById('chk_country');
    if (!countrySel) return;
    var targetCountry = isInitialLoad ? initialProfileCountry : (countrySel.value || initialProfileCountry);
    countrySel.innerHTML = '';

    var matched = false;
    countriesList.forEach(function(c) {
        var cName = c.name || c.country;
        var opt = document.createElement('option');
        opt.value = cName;
        opt.textContent = (c.Iso2 ? (c.Iso2 + ' ') : '') + cName;
        if (cName.toLowerCase() === targetCountry.toLowerCase() || 
            (targetCountry.toLowerCase() === 'uae' && cName.toLowerCase().includes('united arab emirates')) ||
            (targetCountry.toLowerCase() === 'usa' && cName.toLowerCase().includes('united states'))) {
            opt.selected = true;
            matched = true;
        }
        countrySel.appendChild(opt);
    });

    if (!matched && targetCountry) {
        var opt = document.createElement('option');
        opt.value = targetCountry;
        opt.textContent = targetCountry;
        opt.selected = true;
        countrySel.appendChild(opt);
    }

    onWorldCountryChange();
}

function onWorldCountryChange() {
    var countrySel = document.getElementById('chk_country');
    var stateSel = document.getElementById('chk_state');
    var citySel = document.getElementById('chk_city');
    if (!countrySel || !stateSel) return;

    var selectedCountry = countrySel.value || "India";
    stateSel.innerHTML = '<option value="">⏳ Loading States...</option>';
    if (citySel) citySel.innerHTML = '<option value="">⏳ Select State First</option>';

    if (worldStatesCache[selectedCountry]) {
        renderWorldStateOptions(selectedCountry, worldStatesCache[selectedCountry]);
        return;
    }

    fetch('/api/location/states/' + encodeURIComponent(selectedCountry))
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json && json.status && Array.isArray(json.data) && json.data.length > 0) {
                var stateNames = json.data.map(function(s) { return s.name; });
                worldStatesCache[selectedCountry] = stateNames;
                renderWorldStateOptions(selectedCountry, stateNames);
            } else {
                fetchExternalStates(selectedCountry);
            }
        })
        .catch(function() {
            fetchExternalStates(selectedCountry);
        });
}

function fetchExternalStates(selectedCountry) {
    fetch('https://countriesnow.space/api/v0.1/countries/states', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ country: selectedCountry })
    })
    .then(function(res) { return res.json(); })
    .then(function(json) {
        if (json && json.data && json.data.states && Array.isArray(json.data.states) && json.data.states.length > 0) {
            var stateNames = json.data.states.map(function(s) { return s.name; });
            worldStatesCache[selectedCountry] = stateNames;
            renderWorldStateOptions(selectedCountry, stateNames);
        } else {
            renderWorldStateOptions(selectedCountry, [initialProfileState || "Main State / Region"]);
        }
    })
    .catch(function(err) {
        renderWorldStateOptions(selectedCountry, [initialProfileState || "Uttar Pradesh", "Delhi", "Maharashtra", "Other State"]);
    });
}

function renderWorldStateOptions(country, statesList) {
    var stateSel = document.getElementById('chk_state');
    if (!stateSel) return;
    stateSel.innerHTML = '';

    var targetState = isInitialLoad ? initialProfileState : (stateSel.value || initialProfileState);

    if (!statesList || statesList.length === 0) {
        statesList = [targetState || "General Region"];
    }

    var matched = false;
    statesList.forEach(function(stName) {
        var opt = document.createElement('option');
        opt.value = stName;
        opt.textContent = stName;
        if (stName.toLowerCase() === targetState.toLowerCase()) {
            opt.selected = true;
            matched = true;
        }
        stateSel.appendChild(opt);
    });

    if (!matched && targetState) {
        var opt = document.createElement('option');
        opt.value = targetState;
        opt.textContent = targetState;
        opt.selected = true;
        stateSel.appendChild(opt);
    }

    onWorldStateChange();
}

function onWorldStateChange() {
    var countrySel = document.getElementById('chk_country');
    var stateSel = document.getElementById('chk_state');
    var citySel = document.getElementById('chk_city');
    if (!countrySel || !stateSel || !citySel) return;

    var selectedCountry = countrySel.value || "India";
    var selectedState = stateSel.value || "Uttar Pradesh";
    var cacheKey = selectedCountry + '_' + selectedState;

    citySel.innerHTML = '<option value="">⏳ Loading Cities...</option>';

    if (worldCitiesCache[cacheKey]) {
        renderWorldCityOptions(selectedCountry, selectedState, worldCitiesCache[cacheKey]);
        return;
    }

    fetch('/api/location/cities/' + encodeURIComponent(selectedState))
        .then(function(res) { return res.json(); })
        .then(function(json) {
            if (json && json.status && Array.isArray(json.data) && json.data.length > 0) {
                var cityNames = json.data.map(function(c) { return c.name; });
                worldCitiesCache[cacheKey] = cityNames;
                renderWorldCityOptions(selectedCountry, selectedState, cityNames);
            } else {
                fetchExternalCities(selectedCountry, selectedState);
            }
        })
        .catch(function() {
            fetchExternalCities(selectedCountry, selectedState);
        });
}

function fetchExternalCities(selectedCountry, selectedState) {
    var cacheKey = selectedCountry + '_' + selectedState;
    fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ country: selectedCountry, state: selectedState })
    })
    .then(function(res) { return res.json(); })
    .then(function(json) {
        if (json && json.data && Array.isArray(json.data) && json.data.length > 0) {
            worldCitiesCache[cacheKey] = json.data;
            renderWorldCityOptions(selectedCountry, selectedState, json.data);
        } else {
            fetchCountryLevelCities(selectedCountry, selectedState);
        }
    })
    .catch(function() {
        fetchCountryLevelCities(selectedCountry, selectedState);
    });
}

function fetchCountryLevelCities(country, state) {
    var cacheKey = country + '_' + state;
    fetch('https://countriesnow.space/api/v0.1/countries/cities', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ country: country })
    })
    .then(function(res) { return res.json(); })
    .then(function(json) {
        if (json && json.data && Array.isArray(json.data) && json.data.length > 0) {
            worldCitiesCache[cacheKey] = json.data;
            renderWorldCityOptions(country, state, json.data);
        } else {
            renderWorldCityOptions(country, state, [initialProfileCity || "Barabanki", "Lucknow", "Other City"]);
        }
    })
    .catch(function() {
        renderWorldCityOptions(country, state, [initialProfileCity || "Barabanki", "Lucknow", "Other City"]);
    });
}

function renderWorldCityOptions(country, state, citiesList) {
    var citySel = document.getElementById('chk_city');
    if (!citySel) return;
    citySel.innerHTML = '';

    var targetCity = isInitialLoad ? initialProfileCity : (citySel.value || initialProfileCity);

    if (!citiesList || citiesList.length === 0) {
        citiesList = [targetCity || "General City"];
    }

    var matched = false;
    citiesList.forEach(function(cName) {
        var opt = document.createElement('option');
        opt.value = cName;
        opt.textContent = cName;
        if (cName.toLowerCase() === targetCity.toLowerCase()) {
            opt.selected = true;
            matched = true;
        }
        citySel.appendChild(opt);
    });

    if (!matched && targetCity) {
        var opt = document.createElement('option');
        opt.value = targetCity;
        opt.textContent = targetCity;
        opt.selected = true;
        citySel.appendChild(opt);
    }

    isInitialLoad = false;
}

document.addEventListener("DOMContentLoaded", function() {
    loadWorldCountries();
});
</script>
@endsection
