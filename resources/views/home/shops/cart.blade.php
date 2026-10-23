@extends('home.includes.master')

@section('content')
<div style="background: #f8fafc; min-height: 90vh; padding-bottom: 80px;">

    <!-- TOP HEADER SPACER -->
    <div style="height: 60px; width: 100%;"></div>

    <!-- TOP ANNOUNCEMENT BAR -->
    <!-- <div style="background: #111827; color: #f59e0b; padding: 10px 0; font-size: 13px; font-weight: 700; text-align: center; border-bottom: 2px solid #f59e0b;">
        🚚 FREE Express Shipping Across India on Orders Above ₹499 | 100% Guaranteed Sacred &amp; Original Quality
    </div> -->

    <div class="container" style="margin-top: 40px;">
        
        <!-- BREADCRUMB & PAGE HEADING -->
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px; flex-wrap: wrap; gap: 10px;">
            <div>
                <a href="{{ route('shops') }}" style="color: #0284c7; text-decoration: none; font-weight: 700; font-size: 13.5px;">← Back to E-Commerce Shop</a>
                <h2 style="font-weight: 900; color: #0f172a; margin-top: 6px; margin-bottom: 0; font-size: 28px;">
                    🛒 Your Shopping Cart
                </h2>
            </div>
            <a href="{{ route('shops') }}" class="btn" style="background: #fef3c7; color: #92400e; font-weight: 800; border-radius: 8px; padding: 8px 16px; font-size: 13.5px; border: 1px solid #fde68a;">
                + Add More Sacred Products
            </a>
        </div>

        <div class="row g-4">
            
            <!-- LEFT COLUMN: CART ITEMS LIST -->
            <div class="col-lg-8 col-12">
                <div style="background: #ffffff; border-radius: 14px; padding: 24px; border: 1.5px solid #e2e8f0; box-shadow: 0 6px 20px rgba(0,0,0,0.05);">
                    <h5 style="font-weight: 900; color: #0f172a; margin-bottom: 20px; border-bottom: 2px solid #f1f5f9; padding-bottom: 12px; font-size: 18px;">
                        Cart Items (<span class="cart-count-badge">0</span>)
                    </h5>

                    <div id="pageCartItemsList">
                        <!-- Dynamic items loaded via JavaScript -->
                    </div>
                </div>
            </div>

            <!-- RIGHT COLUMN: ORDER SUMMARY BOX -->
            <div class="col-lg-4 col-12">
                <div style="background: #ffffff; border-radius: 14px; padding: 24px; border: 1.5px solid #cbd5e1; box-shadow: 0 8px 25px rgba(0,0,0,0.08); position: sticky; top: 80px;">
                    <h5 style="font-weight: 900; color: #0f172a; margin-bottom: 18px; border-bottom: 2px solid #f1f5f9; padding-bottom: 10px; font-size: 18px;">
                        Order Summary
                    </h5>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 14px; color: #64748b; font-weight: 600;">
                        <span>Items Subtotal:</span>
                        <span style="font-weight: 800; color: #0f172a;" id="pageCartSubtotal">₹0</span>
                    </div>

                    <!-- <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; font-size: 14px; color: #64748b; font-weight: 600;">
                        <span>Express Delivery:</span>
                        <span style="font-weight: 800; color: #16a34a;">FREE</span>
                    </div> -->

                    <!-- COUPON CODE INPUT -->
                    <div style="margin: 16px 0;">
                        <label style="font-size: 12.5px; font-weight: 800; color: #334155; margin-bottom: 6px; display: block;">🏷️ Have a Promo / Coupon Code?</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="couponInput" placeholder="EXAMPLE: DEWASHARIF10 " style="flex-grow: 1; border-radius: 8px; border: 1.5px solid #cbd5e1; padding: 0 12px; font-weight: 700; height: 40px; font-size: 13px; text-transform: uppercase;">
                            <button type="button" onclick="applyCoupon()" class="btn" style="background: #111827; color: #f59e0b; font-weight: 800; border-radius: 8px; padding: 0 16px; font-size: 13px; border: none;">
                                Apply
                            </button>
                        </div>
                        <span id="couponMsg" style="font-size: 12px; font-weight: 700; display: block; margin-top: 4px;"></span>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; background: #f8fafc; padding: 14px; border-radius: 10px; border: 1.5px solid #cbd5e1; margin-bottom: 20px;">
                        <span style="font-size: 16px; font-weight: 900; color: #111827;">Total Amount:</span>
                        <span style="font-size: 22px; font-weight: 900; color: #074121;" id="pageCartTotal">₹0</span>
                    </div>

                    <!-- ACTION BUTTONS -->
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        <a href="{{ route('shops.checkout') }}" class="btn w-100" style="background: linear-gradient(135deg, #059669 0%, #10b981 50%, #047857 100%); color: #ffffff; font-weight: 900; border-radius: 10px; min-height: 48px; height: auto; padding: 12px 14px; font-size: 15px; border: none; box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4); text-align: center; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; white-space: normal !important; line-height: 1.35; box-sizing: border-box; flex-wrap: wrap;">
                            <span>🚀 Proceed to Checkout (Pay Online)</span>
                        </a>

                        <!-- BUTTON 2: PHONEPE / UPI QR CODE PAYMENT (YELLOW WITH WHITE TEXT) -->
                        <button type="button" onclick="openCartQrModal()" class="btn w-100 font-extrabold" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #ffffff; font-weight: 900; border-radius: 10px; min-height: 48px; height: auto; padding: 12px 14px; font-size: 14.5px; border: none; box-shadow: 0 4px 14px rgba(245, 158, 11, 0.45); display: flex; align-items: center; justify-content: center; gap: 8px; text-shadow: 0 1px 2px rgba(0,0,0,0.25); white-space: normal !important; text-align: center; line-height: 1.35; box-sizing: border-box; flex-wrap: wrap;">
                            <i class="fa fa-qrcode" style="font-size: 20px; flex-shrink: 0;"></i>
                            <span>Pay via QR (PhonePe / GPay / Paytm)</span>
                        </button>

                        <button type="button" onclick="checkoutWhatsAppOrder()" class="btn w-100" style="background: #25D366; color: #ffffff; font-weight: 900; border-radius: 10px; min-height: 48px; height: auto; padding: 12px 14px; font-size: 14.5px; border: none; box-shadow: 0 4px 15px rgba(37, 211, 102, 0.35); display: flex; align-items: center; justify-content: center; gap: 8px; white-space: normal !important; text-align: center; line-height: 1.35; box-sizing: border-box; flex-wrap: wrap;">
                            <i class="fa fa-whatsapp" style="font-size: 19px; flex-shrink: 0;"></i>
                            <span>Order via WhatsApp Direct</span>
                        </button>
                    </div>

                    <!-- <div style="margin-top: 20px; border-top: 1px solid #e2e8f0; padding-top: 14px; font-size: 12px; color: #64748b; font-weight: 600; text-align: center; display: flex; flex-direction: column; gap: 6px;">
                        <span>🔒 100% Secure Razorpay &amp; PhonePe Gateway</span>
                        <span>🚚 Free Express Delivery Across India</span>
                    </div> -->

                </div>
            </div>

        </div>

    </div>
</div>

<script>
    window.appliedDiscount = 0;

    function getCartData() {
        var raw = localStorage.getItem('dewa_cart');
        var data = [];
        try {
            if (raw) {
                data = JSON.parse(raw);
            }
        } catch(e) {
            data = [];
        }

        if (!Array.isArray(data)) {
            data = [];
        }

        return data.map(function(item) {
            var cleanImg = (item.image || '').replace(/^https?:\/\/[^\/]+/, '');
            if (!cleanImg.startsWith('/')) cleanImg = '/' + cleanImg;
            return {
                id: item.id || 1,
                name: item.name || "Sacred Item",
                price: parseFloat(item.price) || 0,
                image: cleanImg || "/home/images/dewasharif/dewapage/attar_bottle.jpg",
                qty: parseInt(item.qty) || 1,
                maxStock: parseInt(item.maxStock) || 999
            };
        });
    }

    function renderCartPage() {
        var cart = getCartData();
        var totalQty = cart.reduce(function(sum, item) { return sum + item.qty; }, 0);

        var badges = document.querySelectorAll('.cart-count-badge');
        badges.forEach(function(b) { b.textContent = totalQty; });

        var itemsContainer = document.getElementById('pageCartItemsList');
        if (!itemsContainer) return;

        var html = '';
        var subtotal = 0;

        if (cart.length === 0) {
            html = '<div style="text-align: center; padding: 50px 0; color: #64748b;">' +
                   '<span style="font-size: 55px; display: block; margin-bottom: 12px;">🛍️</span>' +
                   '<h4 style="font-weight: 900; color: #0f172a; margin-bottom: 8px;">Your Shopping Cart is Empty</h4>' +
                   '<p style="font-size: 14px; margin-bottom: 20px;">Browse sacred products &amp; add items to your cart!</p>' +
                   '<a href="{{ route("shops") }}" class="btn" style="background: linear-gradient(135deg, #059669 0%, #10b981 50%, #047857 100%); color: #ffffff; font-weight: 900; border-radius: 8px; padding: 10px 24px; text-decoration: none; display: inline-block;">Explore Shop Now</a>' +
                   '</div>';
        } else {
            cart.forEach(function(item, index) {
                var itemTotal = item.price * item.qty;
                subtotal += itemTotal;
                html += '<div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1.5px solid #f1f5f9; padding-bottom: 16px; margin-bottom: 16px; flex-wrap: wrap; gap: 15px;">' +
                        '<div style="display: flex; align-items: center; gap: 16px; max-width: 420px;">' +
                        '<img src="' + item.image + '" onerror="this.onerror=null; this.src=\'/home/images/dewasharif/dewapage/attar_bottle.jpg\';" style="width: 70px; height: 70px; object-fit: cover; border-radius: 10px; border: 1.5px solid #cbd5e1; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">' +
                        '<div>' +
                        '<h6 style="font-weight: 900; margin: 0; font-size: 15.5px; color: #0f172a; line-height: 1.3;">' + item.name + '</h6>' +
                        '<span style="font-size: 13.5px; color: #64748b; font-weight: 700; display: block; margin-top: 4px;">Price: ₹' + item.price + '</span>' +
                        '</div>' +
                        '</div>' +
                        '<div style="display: flex; align-items: center; gap: 20px;">' +
                        '<div style="display: flex; align-items: center; gap: 8px; background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 8px; padding: 2px 6px;">' +
                        '<button type="button" onclick="changeCartQty(' + index + ', -1)" class="btn btn-sm" style="font-weight: 900; border: none; background: transparent; width: 28px; height: 28px; padding: 0; font-size: 16px; color: #0f172a;">-</button>' +
                        '<span style="font-weight: 900; font-size: 15px; min-width: 24px; text-align: center; color: #0f172a;">' + item.qty + '</span>' +
                        '<button type="button" onclick="changeCartQty(' + index + ', 1)" class="btn btn-sm" style="font-weight: 900; border: none; background: transparent; width: 28px; height: 28px; padding: 0; font-size: 16px; color: #0f172a;">+</button>' +
                        '</div>' +
                        '<span style="font-size: 18px; font-weight: 900; color: #074121; min-width: 80px; text-align: right;">₹' + itemTotal + '</span>' +
                        '<button type="button" onclick="removeCartItem(' + index + ')" class="btn btn-sm" style="color: #ef4444; font-weight: 900; font-size: 18px; border: none; background: #fef2f2; padding: 4px 10px; border-radius: 6px; cursor: pointer;" title="Remove Item">&times;</button>' +
                        '</div>' +
                        '</div>';
            });
        }

        itemsContainer.innerHTML = html;

        var discountVal = window.appliedDiscount || 0;
        var finalTotal = Math.max(0, subtotal - discountVal);

        var subtotalEl = document.getElementById('pageCartSubtotal');
        if (subtotalEl) subtotalEl.textContent = '₹' + subtotal;

        var totalEl = document.getElementById('pageCartTotal');
        if (totalEl) totalEl.textContent = '₹' + finalTotal;
    }

    function changeCartQty(index, delta) {
        var cart = getCartData();
        if (cart[index]) {
            if (delta > 0 && cart[index].maxStock && cart[index].qty >= cart[index].maxStock) {
                alert("Only " + cart[index].maxStock + " units available in stock for '" + cart[index].name + "'.");
                return;
            }
            cart[index].qty += delta;
            if (cart[index].qty <= 0) {
                cart.splice(index, 1);
            }
            localStorage.setItem('dewa_cart', JSON.stringify(cart));
            renderCartPage();
        }
    }

    function removeCartItem(index) {
        var cart = getCartData();
        if (cart[index]) {
            cart.splice(index, 1);
            localStorage.setItem('dewa_cart', JSON.stringify(cart));
            renderCartPage();
        }
    }

    function applyCoupon() {
        var input = document.getElementById('couponInput');
        var msg = document.getElementById('couponMsg');
        if (!input) return;
        var code = input.value.trim().toUpperCase();
        if (!code) {
            alert('Please enter a coupon code.');
            return;
        }

        var cart = getCartData();
        var subtotal = cart.reduce(function(sum, item) { return sum + (item.price * item.qty); }, 0);

        fetch("{{ route('shops.coupon') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({ code: code, subtotal: subtotal })
        })
        .then(function(res) { return res.json(); })
        .then(function(res) {
            if (res.success) {
                window.appliedDiscount = res.discount;
                if (msg) {
                    msg.style.color = '#16a34a';
                    msg.textContent = '🎉 ' + res.message;
                }
                renderCartPage();
            } else {
                if (msg) {
                    msg.style.color = '#ef4444';
                    msg.textContent = '❌ ' + (res.message || 'Invalid coupon code.');
                }
            }
        })
        .catch(function() {
            alert('Could not verify coupon. Please try again.');
        });
    }

    function checkoutWhatsAppOrder() {
        var cart = getCartData();
        if (cart.length === 0) {
            alert('Aapka Cart khaali hai!');
            return;
        }
        var summary = cart.map(function(i) { return "• " + i.name + " (Qty: " + i.qty + ") - ₹" + (i.price * i.qty); }).join("\n");
        var subtotal = cart.reduce(function(sum, i) { return sum + (i.price * i.qty); }, 0);
        var discountVal = window.appliedDiscount || 0;
        var finalTotal = Math.max(0, subtotal - discountVal);

        var msg = "Assalamu Alaikum Shahzade Bhai!\n\n" +
                  "Main dewasharif.com Online Shop se ye items order karna chahta hun:\n\n" +
                  summary + "\n\n" +
                  "💰 Total Amount: ₹" + finalTotal + "\n\n" +
                  "Kripya delivery details aur dispatch time confirm karein. Shukriya!";

        window.open("https://wa.me/919648777223?text=" + encodeURIComponent(msg), '_blank');
    }

    function generateDynamicUpi(amount, note) {
        var upiId = '9648777223@ybl';
        var payeeName = 'SHAHZADE ALAM';
        var cleanAmount = (parseFloat(amount) || 0).toFixed(2);
        var noteText = note || 'Dewa Sharif Store Cart';
        
        var upiUri = 'upi://pay?pa=' + encodeURIComponent(upiId) +
                     '&pn=' + encodeURIComponent(payeeName) +
                     '&am=' + encodeURIComponent(cleanAmount) +
                     '&cu=INR' +
                     '&tn=' + encodeURIComponent(noteText);
                     
        var qrImgUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=260x260&margin=8&data=' + encodeURIComponent(upiUri);
        return {
            uri: upiUri,
            qr: qrImgUrl,
            amount: cleanAmount
        };
    }

    function openCartQrModal() {
        var cart = getCartData();
        if (cart.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Cart is Empty',
                text: 'Aapka Cart khaali hai! Kripya pehle items add karein.',
                confirmButtonColor: '#052c16'
            });
            return;
        }

        var subtotal = cart.reduce(function(sum, i) { return sum + (i.price * i.qty); }, 0);
        var discountVal = window.appliedDiscount || 0;
        var finalTotal = Math.max(0, subtotal - discountVal);
        var formattedTotal = Number(finalTotal).toLocaleString('en-IN');

        $('#cartQrPayAmountText').text('₹' + formattedTotal);

        var upiData = generateDynamicUpi(finalTotal, 'Dewa Sharif Store Cart');
        $('#cartDynamicQrImg').attr('src', upiData.qr);
        $('#cartDirectUpiBtn').attr('href', upiData.uri);
        $('#cartDirectUpiAmount').text('₹' + formattedTotal);

        $('#cartQrModalOverlay').css('display', 'flex');
    }

    function closeCartQrModal() {
        $('#cartQrModalOverlay').hide();
    }

    function copyUpiId(btn) {
        var upi = '9648777223@ybl';
        if (navigator.clipboard && window.isSecureContext) {
            navigator.clipboard.writeText(upi);
        } else {
            var tempInput = document.createElement('input');
            tempInput.value = upi;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
        }
        if (btn) {
            var originalHtml = btn.innerHTML;
            btn.innerHTML = '<i class="fa fa-check"></i> Copied!';
            btn.style.background = '#16a34a';
            setTimeout(function() {
                btn.innerHTML = originalHtml;
                btn.style.background = '#0f172a';
            }, 2000);
        }
    }

    function sendCartQrWhatsApp() {
        var name = ($('#cart_qr_name').val() || '').trim();
        var phone = ($('#cart_qr_phone').val() || '').trim();
        var address = ($('#cart_qr_address').val() || '').trim();
        var city = ($('#cart_qr_city').val() || '').trim() || 'Barabanki';
        var pincode = ($('#cart_qr_pincode').val() || '').trim() || '225301';

        var cart = getCartData();
        var subtotal = cart.reduce(function(sum, i) { return sum + (i.price * i.qty); }, 0);
        var discountVal = window.appliedDiscount || 0;
        var finalTotal = Math.max(0, subtotal - discountVal);
        var itemsSummary = cart.map(function(item){ return "• " + item.name + " (Qty: " + item.qty + ") - ₹" + (item.price * item.qty); }).join("\n");

        if (name && phone && address) {
            $.ajax({
                url: "{{ route('shops.book') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    name: name,
                    phone: phone,
                    address: address,
                    city: city,
                    state: 'Uttar Pradesh',
                    pincode: pincode,
                    items_summary: cart.map(function(item){ return item.name + ' (x' + item.qty + ')'; }).join(', '),
                    amount: finalTotal,
                    payment_id: 'PhonePe QR (Screenshot on WhatsApp)',
                    cart_items: localStorage.getItem('dewa_cart')
                }
            });
        }

        closeCartQrModal();
        localStorage.removeItem('dewa_cart');

        var custStr = (name || "Customer") + (phone ? " (" + phone + ")" : "");
        var addrStr = address ? (address + ", " + city + " - " + pincode) : "Will provide in WhatsApp chat";
        var text = "Assalamu Alaikum Dewa Sharif Store!\n\n" +
                   "Maine PhonePe QR se payment kar diya hai:\n" +
                   "💰 Total Paid: ₹" + Number(finalTotal).toLocaleString('en-IN') + "\n\n" +
                   "📦 Items Ordered:\n" + itemsSummary + "\n\n" +
                   "👤 Customer: " + custStr + "\n" +
                   "📍 Address: " + addrStr + "\n\n" +
                   "Maine payment ka screenshot WhatsApp par attach kar diya hai. Kripya order dispatch confirm karein. Shukriya!";

        window.open("https://wa.me/919648777223?text=" + encodeURIComponent(text), '_blank');
        setTimeout(function() {
            window.location.href = "{{ route('customer.orders') }}";
        }, 1500);
    }

    function triggerCartSuccessOverlay(response, amount, custInfo) {
        $('#succBookingCode').text('#' + (response.booking_code || 'DWS-ORD-2026'));
        $('#succAmountPaid').text('₹' + parseFloat(amount).toLocaleString('en-IN'));
        $('#succCustomerInfo').text(custInfo);

        $('#cartPaymentSuccessOverlay').css('display', 'flex');

        var secondsLeft = 5;
        $('#succCountdown').text(secondsLeft);
        $('#succProgressBar').css('width', '100%');

        var targetUrl = response.redirect_url || "{{ route('customer.orders') }}";

        $('#btnGoDashboard').off('click').on('click', function() {
            window.location.href = targetUrl;
        });

        var timerInt = setInterval(function() {
            secondsLeft--;
            if (secondsLeft < 0) secondsLeft = 0;
            $('#succCountdown').text(secondsLeft);
            var pct = (secondsLeft / 5) * 100;
            $('#succProgressBar').css('width', pct + '%');

            if (secondsLeft <= 0) {
                clearInterval(timerInt);
                window.location.href = targetUrl;
            }
        }, 1000);
    }

    document.addEventListener("DOMContentLoaded", function() {
        renderCartPage();
    });
</script>

<!-- CART PHONEPE / UPI QR CODE MODAL OVERLAY -->
<div id="cartQrModalOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(8px); z-index: 999999; align-items: center; justify-content: center; padding: 20px; box-sizing: border-box;">
    <div style="background: #ffffff; width: 100%; max-width: 490px; border-radius: 24px; padding: 28px 24px; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.35); position: relative; max-height: 90vh; overflow-y: auto; animation: popIn 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        
        <!-- CLOSE BUTTON (X) -->
        <button type="button" onclick="closeCartQrModal()" style="position: absolute; top: 16px; right: 18px; background: #f1f5f9; border: none; width: 34px; height: 34px; border-radius: 50%; font-size: 18px; font-weight: bold; color: #475569; cursor: pointer; display: flex; align-items: center; justify-content: center; transition: all 0.2s;" onmouseover="this.style.background='#e2e8f0'" onmouseout="this.style.background='#f1f5f9'">
            ✕
        </button>

        <!-- HEADER BADGE -->
        <div style="display: inline-flex; align-items: center; gap: 8px; background: #fef3c7; border: 1.5px solid #fde68a; padding: 6px 16px; border-radius: 30px; margin-bottom: 12px;">
            <i class="fa fa-qrcode" style="color: #b45309; font-size: 16px;"></i>
            <span style="font-size: 12px; font-weight: 800; color: #92400e; text-transform: uppercase; letter-spacing: 0.5px;">PhonePe &amp; All UPI Apps Accepted</span>
        </div>

        <h4 style="font-weight: 900; color: #0f172a; margin-bottom: 4px; font-size: 20px; text-align: center !important;">
            Scan &amp; Pay via QR Code
        </h4>
        <p style="font-size: 13.5px; color: #64748b; margin-bottom: 14px; text-align: center !important; width: 100%; display: block; margin-left: auto; margin-right: auto;">
            Pay directly to Merchant: <strong style="color: #0f172a;">SHAHZADE ALAM</strong>
        </p>

        <!-- AMOUNT TO PAY BANNER -->
        <div style="background: linear-gradient(135deg, #052c16 0%, #074121 100%); color: #ffffff; border-radius: 12px; padding: 12px; margin-bottom: 14px; text-align: center;">
            <span style="font-size: 11.5px; font-weight: 700; opacity: 0.85; text-transform: uppercase; letter-spacing: 0.5px; display: block;">Total Amount to Pay</span>
            <span style="font-size: 26px; font-weight: 900; color: #4ade80;" id="cartQrPayAmountText">₹0</span>
        </div>

        <!-- DYNAMIC QR IMAGE WITH AUTO AMOUNT EMBEDDED -->
        <div style="background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 16px; padding: 12px; margin-bottom: 14px; display: inline-block; max-width: 290px; width: 100%; box-sizing: border-box;">
            <div style="position: relative; width: 220px; height: 220px; margin: 0 auto; background: #ffffff; border-radius: 10px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(0,0,0,0.06); overflow: hidden;">
                <img id="cartDynamicQrImg" 
                     src="{{ asset('home/images/dewasharif/phonepe_qr.jpg') }}" 
                     alt="PhonePe Dynamic QR Code" 
                     onerror="this.src='{{ asset('home/images/dewasharif/phonepe_qr.jpg') }}'"
                     style="width: 100%; height: 100%; object-fit: contain; display: block;">
            </div>
            <div style="margin-top: 8px; font-size: 11px; font-weight: 800; color: #15803d; background: #dcfce7; padding: 4px 10px; border-radius: 6px; display: inline-block;">
                ✔ Amount Pre-filled on Scan
            </div>
            <div style="margin-top: 6px; font-size: 11.5px; font-weight: 700; color: #475569; text-align: center;">
                📱 PhonePe • Google Pay • Paytm • BHIM
            </div>
            
            <!-- UPI ID BOX WITH 1-CLICK COPY -->
            <div style="background: #ffffff; border: 1.5px solid #cbd5e1; border-radius: 10px; padding: 7px 10px; margin-top: 10px; display: flex; align-items: center; justify-content: space-between; gap: 8px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                <div style="text-align: left; overflow: hidden;">
                    <span style="font-size: 10px; font-weight: 800; color: #64748b; text-transform: uppercase; display: block; line-height: 1;">UPI ID</span>
                    <span style="font-size: 13px; font-weight: 900; color: #0f172a; font-family: monospace; letter-spacing: 0.2px;">9648777223@ybl</span>
                </div>
                <button type="button" onclick="copyUpiId(this)" style="background: #0f172a; color: #ffffff; border: none; padding: 6px 12px; border-radius: 6px; font-size: 11.5px; font-weight: 800; cursor: pointer; display: flex; align-items: center; gap: 4px; transition: all 0.2s; white-space: nowrap;">
                    <i class="fa fa-clone"></i> <span>Copy</span>
                </button>
            </div>
        </div>

        <!-- 1-TAP DIRECT UPI APP PAYMENT BUTTON (MOBILE FRIENDLY) -->
        <div style="margin-bottom: 12px;">
            <a id="cartDirectUpiBtn" 
               href="upi://pay?pa=9648777223@ybl&pn=SHAHZADE%20ALAM&cu=INR&tn=Dewa%20Sharif%20Store%20Cart" 
               class="btn w-100 font-extrabold" 
               style="background: linear-gradient(135deg, #5f259f 0%, #3f156d 100%); color: #ffffff; border-radius: 10px; padding: 12px 14px; font-size: 13.5px; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 14px rgba(95, 37, 159, 0.35); white-space: normal !important; text-align: center; flex-wrap: wrap; line-height: 1.35; box-sizing: border-box;">
                <i class="fa fa-mobile" style="font-size: 22px; flex-shrink: 0;"></i>
                <span>Tap to Pay <strong id="cartDirectUpiAmount">₹0</strong> via PhonePe / GPay</span>
            </a>
            <small style="color: #64748b; font-size: 11px; display: block; margin-top: 4px;">(If on mobile, tap above to open UPI app directly without scanning)</small>
        </div>

        <!-- QUICK DELIVERY DETAILS -->
        <div style="background: #f8fafc; border-radius: 12px; padding: 14px; border: 1.5px solid #e2e8f0; margin-bottom: 14px; text-align: left;">
            <span style="font-size: 12.5px; font-weight: 800; color: #0f172a; display: block; margin-bottom: 10px;">
                📦 Quick Delivery Address (Optional):
            </span>
            <div class="row" style="margin-left: -5px; margin-right: -5px;">
                <div class="col-6" style="padding-left: 5px; padding-right: 5px; margin-bottom: 8px;">
                    <input type="text" id="cart_qr_name" class="form-control" placeholder="Full Name" style="height: 38px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                </div>
                <div class="col-6" style="padding-left: 5px; padding-right: 5px; margin-bottom: 8px;">
                    <input type="tel" id="cart_qr_phone" class="form-control" placeholder="Mobile No." style="height: 38px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                </div>
                <div class="col-12" style="padding-left: 5px; padding-right: 5px; margin-bottom: 8px;">
                    <input type="text" id="cart_qr_address" class="form-control" placeholder="Street Address / House No." style="height: 38px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                </div>
                <div class="col-6" style="padding-left: 5px; padding-right: 5px;">
                    <input type="text" id="cart_qr_city" class="form-control" placeholder="City (e.g. Barabanki)" style="height: 38px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                </div>
                <div class="col-6" style="padding-left: 5px; padding-right: 5px;">
                    <input type="text" id="cart_qr_pincode" class="form-control" placeholder="Pincode (e.g. 225301)" style="height: 38px; font-size: 13px; font-weight: 600; border-radius: 6px;">
                </div>
            </div>
        </div>

        <div style="background: #f0fdf4; border: 1.5px solid #bbf7d0; border-radius: 12px; padding: 12px 14px; margin-bottom: 16px; text-align: center;">
            <span style="font-size: 12.5px; font-weight: 700; color: #166534; display: block;">
                📸 Payment karne ke baad neeche diye button se screenshot WhatsApp par bhejein.
            </span>
        </div>

        <!-- SINGLE ACTION BUTTON IN MODAL -->
        <div>
            <button type="button" onclick="sendCartQrWhatsApp()" class="btn w-100 font-extrabold" style="background: #25D366; color: #ffffff; font-weight: 900; border-radius: 10px; min-height: 48px; height: auto; padding: 12px 14px; font-size: 14px; border: none; box-shadow: 0 4px 16px rgba(37, 211, 102, 0.4); display: flex; align-items: center; justify-content: center; gap: 8px; white-space: normal !important; text-align: center; line-height: 1.35; flex-wrap: wrap; box-sizing: border-box;">
                <i class="fa fa-whatsapp" style="font-size: 20px; flex-shrink: 0;"></i>
                <span>Send Screenshot &amp; Confirm on WhatsApp</span>
            </button>
        </div>

    </div>
</div>

<!-- CART PAYMENT SUCCESS MODAL OVERLAY -->
<div id="cartPaymentSuccessOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(17, 24, 39, 0.88); backdrop-filter: blur(8px); z-index: 999999; align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; width: 100%; max-width: 500px; border-radius: 24px; padding: 35px 30px; text-align: center; box-shadow: 0 25px 60px rgba(0,0,0,0.35); position: relative; animation: popIn 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);">
        
        <!-- Animated Green Success Checkmark Badge -->
        <div style="width: 85px; height: 85px; background: #dcfce7; color: #16a34a; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px auto; font-size: 42px; box-shadow: 0 10px 25px rgba(22,163,74,0.3); border: 3.5px solid #22c55e;">
            ✓
        </div>

        <h3 style="font-weight: 900; color: #111827; margin-bottom: 6px; font-size: 24px; letter-spacing: -0.3px;">
            🎉 Payment Successful!
        </h3>
        <p style="color: #64748b; font-weight: 600; font-size: 14px; margin-bottom: 20px;">
            Money Credited to Dewa Sharif Store (SBI A/C). Order placed!
        </p>

        <!-- Details Summary Box -->
        <div style="background: #f8fafc; border-radius: 16px; border: 1.5px solid #e2e8f0; padding: 18px; margin-bottom: 22px; text-align: left; font-size: 13.5px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: #64748b; font-weight: 700;">Order Reference:</span>
                <span style="font-weight: 900; color: #0f172a;" id="succBookingCode">#DWS-ORD-2026</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                <span style="color: #64748b; font-weight: 700;">Amount Paid:</span>
                <span style="font-weight: 900; color: #16a34a; font-size: 16px;" id="succAmountPaid">₹0</span>
            </div>
            <div style="display: flex; justify-content: space-between;">
                <span style="color: #64748b; font-weight: 700;">Customer / Contact:</span>
                <span style="font-weight: 800; color: #334155;" id="succCustomerInfo">-</span>
            </div>
        </div>

        <!-- 5-Second Countdown Bar -->
        <div style="margin-bottom: 22px;">
            <p style="font-weight: 800; color: #111827; font-size: 14px; margin-bottom: 10px;">
                ⌛ Redirecting to your Orders Dashboard in <span id="succCountdown" style="color: #e11d48; font-size: 18px; font-weight: 900;">5</span> seconds...
            </p>
            <div style="width: 100%; height: 8px; background: #e2e8f0; border-radius: 10px; overflow: hidden;">
                <div id="succProgressBar" style="width: 100%; height: 100%; background: linear-gradient(90deg, #16a34a, #22c55e); transition: width 1s linear;"></div>
            </div>
        </div>

        <!-- Action Button -->
        <div style="display: flex; gap: 12px; justify-content: center;">
            <button type="button" id="btnGoDashboard" class="btn" style="background: #111827; color: #f59e0b; font-weight: 900; font-size: 14px; padding: 12px 24px; border-radius: 10px; flex: 1; border: none; box-shadow: 0 4px 12px rgba(17,24,39,0.3);">
                🚀 Go to Orders Dashboard Now
            </button>
        </div>

    </div>
</div>

<style>
@keyframes popIn {
    0% { transform: scale(0.7); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
@endsection
