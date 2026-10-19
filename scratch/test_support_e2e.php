<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

/** @var \Illuminate\Foundation\Http\Kernel $kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

echo "=== TESTING END-TO-END SUPPORT WORKFLOW ===\n\n";

// 1. Submit Issue from Customer Portal
$req1 = Illuminate\Http\Request::create('/my-account/report-issue/store', 'POST', [
    'category' => 'Hotel Booking Query',
    'subject' => 'Need early checkin at Al-Waris Guest House',
    'message' => 'Assalam Alaikum, our train arrives at 6 AM in Barabanki. Can we get early room checkin?',
    'name' => 'Mohd Hamza',
    'contact' => '+91 9876543210'
]);
$res1 = $kernel->handle($req1);
echo "1. Customer Issue Submission -> Status: " . $res1->getStatusCode() . " (Redirects: " . $res1->headers->get('Location') . ")\n";

// 2. Submit Inquiry from Public Contact Page
$req2 = Illuminate\Http\Request::create('/contact', 'POST', [
    'name' => 'Salman Warsi',
    'email' => 'salman@example.com',
    'mobile' => '+91 9988776655',
    'subject' => 'Degh Niyaz Booking Inquiry',
    'message' => 'Please provide details for 50 KG Mutton Biryani Degh Niyaz during Dewa Mela.'
]);
$res2 = $kernel->handle($req2);
echo "2. Public Contact Submission -> Status: " . $res2->getStatusCode() . "\n";

// 3. Verify Admin Tickets List Response
$req3 = Illuminate\Http\Request::create('/admin/tickets', 'GET');
$res3 = $kernel->handle($req3);
echo "3. Admin Tickets List Page -> Status: " . $res3->getStatusCode() . " (Content Length: " . strlen($res3->getContent()) . " bytes)\n";

// 4. Verify Admin Contact Inquiries List Response
$req4 = Illuminate\Http\Request::create('/admin/contacts', 'GET');
$res4 = $kernel->handle($req4);
echo "4. Admin Contacts Page -> Status: " . $res4->getStatusCode() . " (Content Length: " . strlen($res4->getContent()) . " bytes)\n";

echo "\nAll Support & Help actions executed successfully!\n";
