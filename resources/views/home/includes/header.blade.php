<header>
    <section class="logo-section">
        <div class="container-fluid p0">
            <div class="row g-0">

                <!-- LOGO -->
                <div class="col-md-3 col-xs-12">
                    <div class="logo">
                        <a href="#">
                            <img src="{{ asset('home/images/dewasharif/anim_dewa_logo2.gif') }}"
                                 class="img-responsive"
                                 alt="Logo of Dewa sharif Dot Com"
                                 title="Dewa Sharif" />
                        </a>
                    </div>
                </div>

                <!-- MENU + TRANSLATE -->
                <div class="col-md-9 col-xs-12">
                    <nav class="navbar navbar-inverse" role="navigation">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#main-navbar">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>

                        <div class="collapse navbar-collapse" id="main-navbar">
                            <ul class="nav navbar-nav">

                                <!-- ABOUT -->
                                <li class="dropdown mega-dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">About US <span class="caret"></span></a>
                                    <ul class="dropdown-menu mega-dropdown-menu about-tag">
                                        <li class="col-md-4"><a href="{{ route('about') }}">Dewa Sharif</a></li>
                                        <li class="col-md-4"><a href="{{ route('artandcraft') }}">Art & Craft</a></li>
                                        <li class="col-md-4"><a href="{{ route('artandculture') }}">Art & Culture</a></li>
                                        <li class="col-md-4"><a href="{{ route('auditorium') }}">Auditorium</a></li>
                                        <li class="col-md-4"><a href="{{ route('bank') }}">Banks</a></li>
                                        <li class="col-md-4"><a href="{{ route('collegeslist') }}">Educations</a></li>
                                        <li class="col-md-4"><a href="{{ route('docters') }}">Docters</a></li>
                                        <li class="col-md-4"><a href="{{ route('eidgaah') }}">Eidgaah</a></li>
                                        <li class="col-md-4"><a href="{{ route('guesthouse') }}">Guest House & Hotels</a></li>
                                        <li class="col-md-4"><a href="{{ route('hajiwarisalishah') }}">Hazrat Haji Waris Ali Shah</a></li>
                                        <li class="col-md-4"><a href="{{ route('history') }}">History</a></li>
                                        <li class="col-md-4"><a href="{{ route('hospitals') }}">Hospitals</a></li>
                                        <li class="col-md-4"><a href="{{ route('langarkhana') }}">Langarkhana</a></li>
                                        <li class="col-md-4"><a href="{{ route('mazar') }}">Mazaar</a></li>
                                        <li class="col-md-4"><a href="{{ route('mela') }}">Mela</a></li>
                                        <li class="col-md-4"><a href="{{ route('mosquedargah') }}">Masjid-Al-Waris</a></li>
                                        <li class="col-md-4"><a href="{{ route('numaisground') }}">Numais</a></li>
                                        <li class="col-md-4"><a href="{{ route('postoffice') }}">Post Office</a></li>
                                        <li class="col-md-4"><a href="{{ route('qawwaliplace') }}">Qawwali Place</a></li>
                                        <li class="col-md-4"><a href="{{ route('qurbanalishah') }}">Hazrat Qurban Ali Shah</a></li>
                                        <li class="col-md-4"><a href="{{ route('safayiheroes') }}">Cleaners Staff</a></li>
                                        <li class="col-md-4"><a href="{{ route('samakhana') }}">Samakhana</a></li>
                                        <li class="col-md-4"><a href="{{ route('shahwilayatshah') }}">Hazrat Shah Wilayat Shah</a></li>
                                        <li class="col-md-4"><a href="{{ route('sufism') }}">Sufism</a></li>
                                        <li class="col-md-4"><a href="{{ route('thana') }}">Thana</a></li>
                                        <li class="col-md-4"><a href="{{ route('townarea') }}">Town Area</a></li>
                                        <li class="col-md-4"><a href="{{ route('trustoffice') }}">Trust Office</a></li>
                                        <li class="col-md-4"><a href="{{ route('wazukhana') }}">Wazukhana</a></li>
                                    </ul>
                                </li>

                                <!-- BUZURGAN-E-ISLAM -->
                                <li class="dropdown mega-dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Buzurgan-E-Islam <span class="caret"></span></a>
                                    <ul class="dropdown-menu mega-dropdown-menu dest-tag">
                                        <li class="col-md-6 menu-heading">
                                            <a href="#">Awlia-Allah</a>
                                            <ul>
                                                <li><a href="{{ route('aalahazrat') }}">A'ala Hazrat</a></li>
                                                <li><a href="{{ route('abdulqadirgilani') }}">Abdul Qadir Jilani</a></li>
                                                <li><a href="{{ route('dataganjbaksh') }}">DataGanj Baksh</a></li>
                                                <li><a href="{{ route('hajiali') }}">Haji Ali</a></li>
                                                <li><a href="{{ route('hazratbal') }}">HazratBal</a></li>
                                                <li><a href="{{ route('hazratnizamuddin') }}">Hazrat Nizamuddin</a></li>
                                                <li><a href="{{ route('hazrattajuddin') }}">Hazrat Tajuddin</a></li>
                                                <li><a href="{{ route('khammanpeer') }}">Khamman Peer</a></li>
                                                <li><a href="{{ route('muinuddinchisti') }}">Muinuddin Chisti</a></li>
                                                <li><a href="{{ route('syedmasoodghazi') }}">Syed Masood Ghazi</a></li>
                                            </ul>
                                        </li>
                                        <li class="col-md-6 menu-heading">
                                            <a href="#">Ahlebayt-Sahaba</a>
                                            <ul>
                                                <li><a href="{{ route('muhammad') }}">Prophet Muhammad (PBUH)</a></li>
                                                <li><a href="{{ route('fatima') }}">Fatima Al-Zahra</a></li>
                                                <li><a href="{{ route('ali') }}">Ali Ibn Abi Talib</a></li>
                                                <li><a href="{{ route('hasan') }}">Hasan Ibn Ali</a></li>
                                                <li><a href="{{ route('husain') }}">Husayn Ibn Ali</a></li>
                                                <li><a href="{{ route('khadija') }}">Khadijah</a></li>
                                                <li><a href="{{ route('aisha') }}">Aisha</a></li>
                                                <li><a href="{{ route('hafsa') }}">Hafsa</a></li>
                                                <li><a href="{{ route('ummesalma') }}">Umme Salmah</a></li>
                                                <li><a href="{{ route('abbas') }}">Abbas</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>

                                <!-- ONLINE BOOKING -->
                                <li><a href="#">Online Booking</a></li>

                                <!-- REGISTER BUSINESS -->
                                <li><a href="#">Register-Business</a></li>

                                <!-- GOOGLE TRANSLATE -->
                                <li class="google-translate-wrapper">
                                    <div id="google_translate_element"></div>
                                </li>

                            </ul>
                        </div>
                    </nav>
                </div>

            </div>
        </div>
    </section>
</header>

<!-- ===================== CSS ===================== -->
<style>
.p0 { padding: 0; }
.g-0 { margin: 0; }

.logo { padding: 15px; }
.logo img { max-height: 60px; }

/* Mega menu hover on desktop */
@media (min-width: 768px) {
    .dropdown:hover .dropdown-menu { display: block; }
    .navbar-nav > li:hover > a,
    .mega-dropdown-menu li a:hover,
    .mega-dropdown-menu .menu-heading > a:hover {
        background-color: #074121 !important;
        color: #fff !important;
    }
}

/* Mobile: show collapse menu properly */
@media (max-width: 767px) {
    .dropdown-menu { display: none; }
    .dropdown.open .dropdown-menu { display: block; }
}

/* Google Translate */
.google-translate-wrapper { padding: 10px 0; }
#google_translate_element select { padding: 4px; }
</style>

<!-- ===================== JS ===================== -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- Google Translate -->
<script type="text/javascript">
function googleTranslateElementInit() {
    new google.translate.TranslateElement(
        {pageLanguage: 'en'},
        'google_translate_element'
    );
}
</script>
<script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
