@extends('home.includes.master')
@section('content')
<div class="container">
    <div class="maroon">
        <h1>*** DOs & Don’ts ***</h1>
    </div>
    <div class="row">
        <form action="{{ route('dosanddonts') }}" method="POST">
        <p>
        <h4>DOs :</h4>

        <i>
            <h5>Engage Respectfully :</h5>
        </i> Interact with content, comments, and other users respectfully, keeping in mind that www.dewasharif.com is a
        space for religious learning and spiritual reflection.

        <i>
            <h5> Use Content for Personal Growth :</h5>
        </i> Feel free to use the articles, guides, and resources for personal and educational growth.

        <i>
            <h5>Credit the Website :</h5>
        </i> If sharing any content or quotes on social media, always credit www.dewasharif.com as the source.

        <i>
            <h5>Report Issues :</h5>
        </i> If you notice any incorrect information or encounter issues, contact us so we can address them promptly.

        <i>
            <h5>Review Our Policies :</h5>
        </i> Make sure to read our Terms and Conditions, Privacy Policy, and Disclaimer to understand the guidelines for
        using this website.

        <h4> DON’Ts :</h4>

        <i>
            <h5> Do Not Misrepresent Information :</h5>
        </i> Avoid using or sharing the content in a way that misrepresents the teachings, messages, or values presented
        on the site.

        <i>
            <h5> Do Not Modify Content :</h5>
        </i> Do not alter or adapt the website’s content for unauthorized or commercial use.

        <i>
            <h5> Avoid Spamming :</h5>
        </i> Refrain from posting irrelevant or promotional comments in forums, comment sections, or contact forms.

        <i>
            <h5> Do Not Engage in Disruptive Behavior :</h5>
        </i> Avoid any behavior that might disrupt the learning environment or disrespect other users.

        <i>
            <h5> Do Not Share Personal Information :</h5>
        </i> For your safety, avoid sharing sensitive or personal information in public sections of the website.
        </p>

    </form>

    </div>

</div>
@endsection