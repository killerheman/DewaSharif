@extends('home.includes.master')
@section('content')
<div class="container">
    <div class="maroon">
        <h1>*** Terms & Conditions ***</h1>
    </div>
    <div class="row">
        <form action="{{ route('terms') }}" method="POST">
        <p>
        <h4> 1. Use of Religious Content :</h4>
        The content on <a href="www.dewasharif.com"></a> is for informational and personal use only, specifically
        intended to
        support and educate users about religious practices and knowledge. Any reproduction, distribution, or
        commercial use of this content is strictly prohibited without prior permission.

        <h4> 2. Respectful Interaction :</h4>
        We encourage respectful engagement with all religious content and interactive features on the site,
        including forums or comment sections. Any behavior that is disruptive, offensive, or disrespectful may
        result in restricted access to the website.

        <h4> 3. No Misinterpretation or Misrepresentation :</h4>
        <a href="www.dewasharif.com"></a> aims to provide authentic and accurate religious information. Users should not
        misrepresent or spread misleading interpretations of the website’s content. Any misrepresentation or
        unauthorized sharing of information is discouraged.

        <h4> 4. Liability Disclaimer :</h4>
        The website provides religious content for guidance and education, and users are advised to seek
        personalized guidance as needed. <a href="www.dewasharif.com"></a> is not responsible for individual
        interpretations or
        actions taken based on the content provided.

        <h4> 5. Privacy and Data Handling :</h4>
        User privacy is a priority. We collect minimal personal data as required to improve user experience and
        ensure secure access. No personal information will be shared or sold, except as required by law. Please
        refer to our Privacy Policy for more details.

        <h4> 6. Modifications to Terms :</h4>
        <a href="www.dewasharif.com"></a> reserves the right to update these Terms and Conditions as necessary.
        </p>

    </form>

    </div>

</div>
@endsection
