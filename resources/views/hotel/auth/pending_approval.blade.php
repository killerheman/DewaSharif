<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account Under Verification - DewaSharif.com</title>
    <link rel="icon" href="{{ asset('home/images/dewasharif/dewa-round-logo.png') }}" type="image/png">
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #052c16 0%, #031c0e 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .pending-card {
            max-width: 500px;
            background: #ffffff;
            border-radius: 20px;
            padding: 40px 32px;
            text-align: center;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>
<body>
    <div class="pending-card">
        <div class="mb-3">
            <span class="d-inline-flex align-items-center justify-content-center bg-warning bg-opacity-10 text-warning rounded-circle" style="width: 72px; height: 72px; font-size: 36px;">
                <i class="bi bi-hourglass-split"></i>
            </span>
        </div>
        <h4 class="fw-bold text-dark mb-2">Partner Application Under Review</h4>
        <p class="text-muted mb-4" style="font-size: 14px;">
            Thank you, <strong>{{ $partner->name }}</strong>! Your hotel listing for <strong>{{ $partner->hotel_name }}</strong> has been submitted. DewaSharif Admin is verifying your property details. You will receive an approval alert shortly.
        </p>
        <div class="p-3 bg-light rounded-3 mb-4 text-start" style="font-size: 13px;">
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Registered Phone:</span>
                <strong>{{ $partner->phone }}</strong>
            </div>
            <div class="d-flex justify-content-between mb-1">
                <span class="text-muted">Email:</span>
                <strong>{{ $partner->email }}</strong>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted">Payout Rate:</span>
                <strong class="text-success">80% Net to Hotel</strong>
            </div>
        </div>
        <form action="{{ route('hotel.logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100 fw-bold">
                <i class="bi bi-box-arrow-right me-1"></i> Sign Out
            </button>
        </form>
    </div>
</body>
</html>
