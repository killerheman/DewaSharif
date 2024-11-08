@extends('home.includes.master')
@section('content')
<div class="container">
    <div class="maroon">
        <h1>*** Terms & Conditions ***</h1>
    </div>
    <div class="row">
        <form action="{{ route('privacy') }}" method="POST">
        <p>
            <h4>1. Introduction :</h4>
            At www.dewasharif.com, we are committed to protecting the privacy and personal information of our users.
            This Privacy Policy outlines how we collect, use, and safeguard your information when you use our website.

            <h4>2. Information We Collect :</h4>

            <i><h5>Personal  :</h5></i> We may collect personal details such as your name, email address, and other contact
            information when you voluntarily provide them (e.g., through contact forms or subscriptions).

            <i><h5>Usage Data :</h5></i> We automatically collect certain information about your device and usage patterns, including IP
            address, browser type, and pages visited. This helps us analyze website performance and enhance user
            experience.

            <h4>3. How We Use Your Information :</h4>
            To provide and maintain our website and services.
            To respond to your inquiries, comments, or requests.
            To improve our website content and functionality.
            To send occasional updates or newsletters if you have subscribed (you can opt out at any time).
            4. Cookies and Tracking Technologies
            www.dewasharif.com uses cookies to collect information about how our website is accessed and used. Cookies
            help us remember your preferences, enhance user experience, and understand visitor interactions. You may
            choose to disable cookies in your browser settings.

            <h4>5. Third-Party Links :</h4>
            Our website may contain links to third-party sites. www.dewasharif.com is not responsible for the privacy
            practices or content of these external websites. We encourage you to review their privacy policies before
            sharing personal information.

            <h4>6. Data Security :</h4>
            We implement industry-standard measures to protect your personal information from unauthorized access,
            disclosure, or misuse. However, please be aware that no method of data transmission or storage is entirely
            secure.

            <h4>7. Children’s Privacy :</h4>
            www.dewasharif.com is not intended for children under the age of 13. We do not knowingly collect personal
            information from children. If we discover that a child has provided us with personal information, we will
            take steps to delete it promptly.

            <h4> 8. Changes to This Privacy Policy :</h4>
            We may update our Privacy Policy from time to time. Changes will be posted on this page, and we encourage
            you to review it periodically.

            <h4>9. Contact Us :</h4>
            If you have any questions about this Privacy Policy, please contact us via the contact information provided
            on our website
        </p>


    </form>
    </div>

</div>
@endsection
