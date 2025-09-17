@extends('home.includes.master')
@section('content')
<section id="banner">
    <video width="300" height="150" id="myVideo" loop="loop" muted="" autoplay="autoplay">
        <source src="{{ asset('home/images/dewasharif/topvideo/Makkah Madina.mp4') }}" type="video/mp4" />
    </video>
    <div class="videocontrol">
        <button onclick="playVid()" type="button"><i class="fa fa-play" aria-hidden="true"></i></button>
        <button onclick="pauseVid()" type="button"><i class="fa fa-pause" aria-hidden="true"></i></button>
    </div>
</section>

<section class="important-event">
    <div class="container">
        <div class="title">
            <h1 style="color:#0cff8a"><b>What&rsquo;s New</b> in <b>DEWA SHARIF </b>?</h1>
            <p style="color:#03be64">Jashn-E-Eid Milad-Un-Nabi</p>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <img src="{{ asset('home/images/dewasharif/event/event-1.jpeg') }}" 
                     class="img-fluid" style="height:300px; object-fit:cover;">
            </div>
            <div class="col-md-3 col-sm-6">
                <img src="{{ asset('home/images/dewasharif/event/event-2.jpg') }}" 
                     class="img-fluid" style="height:300px; object-fit:cover;">
            </div>
            <div class="col-md-3 col-sm-6">
                <img src="{{ asset('home/images/dewasharif/event/event-3.jpeg') }}" 
                     class="img-fluid" style="height:300px; object-fit:cover;">
            </div>
            <div class="col-md-3 col-sm-6">
                <img src="{{ asset('home/images/dewasharif/event/event-7.jpeg') }}" 
                     class="img-fluid" style="height:300px; object-fit:cover;">
            </div>
        </div>
    </div>
    <div class="explorebg2">
        <img src="{{ asset('home/images/Festive_Delights_divider.png') }}" alt="Background" title="Background" />
    </div>
</section>


<section id="explore">
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <h2>"Dewa Sharif:<b> A Legacy of Love, Faith, Spirituality, Humanity, Peace And Devotion"</b></h2>
                <ul class="letters">
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/1.png') }}" alt="DEVOTION"
                                title="DEVOTION" /></a>
                        <p>DEVOTION</p>
                    </li>
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/2.png') }}" alt="EDUCATION"
                                title="EDUCATION" /></a>
                        <p>EDUCATION</p>
                    </li>
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/3.png') }}" alt="WARSI" title="WARSI" /></a>
                        <p>WARSI</p>
                    </li>
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/4.png') }}" alt="AZAAN" title="AZAAN" /></a>
                        <p>AZAAN</p>
                    </li>
                </ul>
                <ul class="letters">
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/5.png') }}" alt="SPRITUALITY"
                                title="SPRITUALITY" /></a>
                        <p>SPRITUALITY</p>
                    </li>
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/6.png') }}" alt="HUMANITY"
                                title="HUMANITY" /></a>
                        <p>HUMANITY</p>
                    </li>
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/7.png') }}" alt="AWLIYA" title="AWLIYA" /></a>
                        <p>AWLIYA</p>
                    </li>
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/8.png') }}" alt="RELIGIOUS"
                                title="RELIGIOUS" /></a>
                        <p>RELIGIOUS</p>
                    </li>
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/9.png') }}" alt="ISLAM" title="ISLAM" /></a>
                        <p>ISLAM</p>
                    </li>
                    <li><a href="#">
                            <img src="{{ asset('home/images/dewasharif/10.png') }}" alt="FAITH" title="FAITH" /></a>
                        <p>FAITH</p>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 leader">
                <ul>
                    <li><img src="home/images/dewasharif/walidsahab.jpeg" alt="Father"
                            title="Barkat Ali" />
                        <h4>BARKAT ALI <br>[FATHER]</h4>
                          <p><b><i>Barkat Ali KiranaStore</i></b> <br /> <b>www.dewasharif.com</b></p>
                    </li>

                <ul>

            </div>
            <div class="col-md-2 leader ">
                <ul>
                    <li><img src="home/images/dewasharif/shahzade.jpeg" alt="Shahzade Alam"
                            title="Shahzade Alam" />
                        <h4>Shahzade Alam <br>[مشرت وارثی]</h4>
                        <p><b><i>Software Developer</i></b> <br /> <b>www.dewasharif.com</b></p>
                    </li>
                <ul>
            </div>
        </div>
    </div>
    <div class="explorebg2">
        <img src="{{ asset('home/images/explorebg2.png')}}" alt="Background" title="Background" />
    </div>

</section>

<div class="kumbh-25">
    <div class="kumbhshape-1"><img src="{{ asset('home/images/kumbh-2.png') }}" alt="" /></div>
    <video height="30%" width="100%" autoplay loop muted>
        <source src="{{ asset('home/images/dewasharif/pagebackground/Eid.mp4') }}" type="video/mp4">
    </video>
    <div class="kumbhshape-2"><img src="{{ asset('home/images/kumbh-1.png') }}" alt="" /></div>
</div>


<section id="festive">
    <div class="container">
        <div class="title">
            <p style="color: #0a5c36">Checkout <i>Festivals </i> &amp; <i>Events </i> of <b><i>Islam </i></b> &
                <b><i>Dewa Sharif</i></b></p>
            <h1 style="color: #03be64"> <b>Islamic Festive Seasons</b></h1>
        </div>
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-tabs tabs-left">
                    <li><a href="#January" data-toggle="tab">January</a></li>
                    <li><a href="#Febuary" data-toggle="tab">February</a></li>
                    <li><a href="#March" data-toggle="tab">March</a></li>
                    <li><a href="#April" data-toggle="tab">April</a></li>
                    <li><a href="#May" data-toggle="tab">May</a></li>
                    <li><a href="#June" data-toggle="tab">June</a></li>
                </ul>
            </div>
            <div class="col-md-6">
                <div class="tab-content festivetab">
                    <div class="tab-pane" id="January">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/makarsankranti.jpg') }}" alt="Image of Makar Sankranti"
                                    title="Makar Sankranti" />
                                <ul class="description">
                                    <li>15, January</li>
                                    <li>Makar Sankranti</li>
                                </ul>
                            </li>
                            <li><img src="{{ asset('home/downloadmedia/siteContent/638616836518823820.jpg') }}"
                                    alt="Image of Ram Mahotsav Ayodhya" title="Ram Mahotsav Ayodhya" />
                                <ul class="description">
                                    <li>14, January 2024 to 24, March 2024</li>
                                    <li>Ramotsav Ayodhya</li>
                                    <li></li>
                                </ul>
                            </li>
                            <li><img src="{{ asset('home/images/republicfest.jpg') }}" alt="Image of Republic Day"
                                    title="Republic Day" />
                                <ul class="description">
                                    <li>26 January</li>
                                    <li>Republic Day Holiday</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="Febuary">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/downloadmedia/siteContent/638616836527190001.jpg') }}"
                                    alt="Images of Mauni Amavasya Fair" title="Mauni Amavasya Fair" />
                                <ul class="description">
                                    <li>14 February</li>
                                    <li>Vasant Panchami</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="March">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/shivratratifest.jpg') }}" alt="Image of Mahashivratri"
                                    title="" />
                                <ul class="description">
                                    <li>8 March</li>
                                    <li>Mahashivratri Festival, Lakhimpur</li>
                                </ul>
                            </li>
                            <li><img src="{{ asset('home/downloadmedia/siteContent/Year_2024/638616836534354221.jpg') }}"
                                    alt="Image of Holi" title="Holi" />
                                <ul class="description">
                                    <li>24, 25 March</li>
                                    <li>Holi</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="April">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/downloadmedia/siteContent/Year_2024/638616836537688102.jpg') }}"
                                    alt="Image of Ram Navami" title="Ram Navami" caption="false" width="570"
                                    height="469" />
                                <ul class="description">
                                    <li>17 April</li>
                                    <li>Ram Navami</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="May">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/budthfestival.jpg') }}"
                                    alt="Image of Buddha Purnima Celebrations" title="Buddha Purnima Celebrations" />
                                <ul class="description">
                                    <li>23 May</li>
                                    <li>Buddha Purnima Celebrations, kushinagar</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="June">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/magofesteveal.jpg') }}"
                                    alt="Image of Uttar Pradesh Mango Festival" title="Uttar Pradesh Mango Festival" />
                                <ul class="description">
                                    <li>June</li>
                                    <li>Uttar Pradesh Mango Festival</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="July">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/servanafest.jpg') }}" alt="Image of Shravana"
                                    title="Shravana" />
                                <ul class="description">
                                    <li>July</li>
                                    <li>Shravana</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="August">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/kylasmela.jpg') }}" alt="Image of Kailash Mela"
                                    title="Kailash Mela" />
                                <ul class="description">
                                    <li>12 August</li>
                                    <li>Kailash Mela, Sikandra, Agra</li>
                                </ul>
                            </li>
                            <li><img src="{{ asset('home/images/15augustfest.jpg') }}" alt="Image of Independence Day"
                                    title="Independence Day" />
                                <ul class="description">
                                    <li>15 August</li>
                                    <li>Independence Day</li>
                                </ul>
                            </li>
                            <li><img src="{{ asset('home/images/rakshbandhanfest.jpg') }}" alt="Image of Raksha Bandhan"
                                    title="Raksha Bandhan" />
                                <ul class="description">
                                    <li>19 August</li>
                                    <li>Raksha Bandhan</li>
                                </ul>
                            </li>
                            <li><img src="{{ asset('home/images/janmasthami.jpg') }}" alt="Image of Janmashtami"
                                    title="Janmashtami" />
                                <ul class="description">
                                    <li>26 August</li>
                                    <li>Janmashtami</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane active" id="September">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/dewasharif/dewamelaevent1.jpg') }}"
                                    alt="Dewa Sharif URS" title="Dewa Sharif URS 2024" />
                                <ul class="description">
                                    {{--  <li>18 October to 27 October</li>
                                    <li>Dewa Sharif URS 2024</li>  --}}
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="October">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/depawalifest.jpg') }}" alt="Image of Diwali"
                                    title="Diwali" />
                                <ul class="description">
                                    <li>31 October</li>
                                    <li>Diwali</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="November">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/guyruparv.jpg') }}" alt="Image of Guru Nanak Gurpurab"
                                    title="Guru Nanak Gurpurab" />
                                <ul class="description">
                                    <li>15 November</li>
                                    <li>Guru Nanak Gurpurab</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="tab-pane" id="December">
                        <ul class="festivals owl-carousel">
                            <li><img src="{{ asset('home/images/crismaxdayfestivel.jpg') }}"
                                    alt="Image of Christmas Day" title="Christmas Day" />
                                <ul class="description">
                                    <li>25 December</li>
                                    <li>Christmas Day</li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <ul class="nav nav-tabs tabs-left">
                    <li><a href="#July" data-toggle="tab">July</a></li>
                    <li><a href="#August" data-toggle="tab">August</a></li>
                    <li><a href="#September" data-toggle="tab">September</a></li>
                    <li><a href="#October" data-toggle="tab">October</a></li>
                    <li><a href="#November" data-toggle="tab">November</a></li>
                    <li><a href="#December" data-toggle="tab">December</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>


<section id="trip">
    <div class="explorebg">
        <img src="{{ asset('home/images/tribg1.png') }}" alt="Image of background" title="background" />
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 trip-plan">
                <h2>Plan Your Trip</h2>
                <ul>
                    <li><a href="#" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/hotel.png') }}" alt="Hotel" title="Image of Hotel" />
                            Hotel Accommodation
                        </a>
                    </li>
                    <li><a href="#" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/bus.png') }}" alt="Taxi/Bus"
                                title="Image of Taxi/Bus" /> Taxi / Bus
                        </a>
                    </li>
                    <li><a href="#" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/guide.png') }}" alt="Authorised Travel Guides"
                                title="Image of Authorised Travel Guides" /> Authorised Travel Guides
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="explorebg2">
        <img src="{{ asset('home/images/tribg2.png') }}" alt="Image of background" title="background" />
    </div>
</section>
<section id="trip2">
    <div class="container">
        <div class="row">
            <div class="col-md-12 trip-plan">
                <!-- <h2 style="color: #0a5c36; text-align: center;">Coming Soon <b>***Eid Milaad-Un-Nabi***</b></h2> -->

                <ul style="display: flex; flex-wrap: wrap; gap: 20px; list-style: none; padding: 0; margin-top: 20px; justify-content: center; align-items: center;">

                     <li style="text-align: center;">
                        <a href="{{ route('allah') }}" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/allah.jpg') }}" alt="Allah S.W.T" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                            <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Allah (S.W.T)</span>
                        </a>
                    </li>


                    <li style="text-align: center;">
                        <a href="{{ route('hazratmuhammad') }}" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/muhammad.jpg') }}" alt="Hz. Muhammad" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                            <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Hz. Muhammad (S.A.W)</span>
                        </a>
                    </li>
                    <li style="text-align: center;">
                        <a href="{{ route('khanaekaaba') }}" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/kaba2.jpg') }}" alt="Khana-e-Kaaba" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                            <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Khana-e-Ka'aba</span>
                        </a>
                    </li>
                    <li style="text-align: center;">
                        <a href="{{ route('muhammad') }}" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/jumapic.jpg') }}" alt="Hotel" title="Image of Hotel" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                            <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Raoza-E-Rasool (S.A.W)</span>
                        </a>
                    </li>

                    <li style="text-align: center;">
                        <a href="{{ route('hajiwarisalishah') }}" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/melalogo.jpg') }}" alt="Haji Waris Ali Shah R.A." style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                            <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Haji Waris Ali Shah R.A.</span>
                        </a>
                    </li>
                    <li style="text-align: center;">
                        <a href="https://dewasharif.com" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/icons/panjatanpaak.jpg') }}" alt="Panjatan Pak" style="width: 80px; height: 80px; object-fit: cover; border-radius: 10px;" />
                            <span style="display: block; margin-top: 8px; font-weight: 500; color: #333;">Panjatan Pak</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</section>


{{-- <section id="festive" style="padding: 40px 0; background: url('{{ asset('home/images/explorebg2.png') }}') no-repeat center center; background-size: cover;">
    <div class="container" style="position: relative; z-index: 2;">
        <div class="title" style="text-align: center; margin-bottom: 30px;">
            <p style="color: #0a5c36; font-size: 18px;">
                <b><i>مالی تعاون کریں</i></b> -&nbsp;&nbsp; <b><i>कृपया सहयोग करें</i></b> -&nbsp;&nbsp; <b><i>Kindly Contribute</i></b> -&nbsp;&nbsp; for this website:
            </p>
            <h1 style="color: #03be64; font-weight: bold; font-size: 32px;">www.dewasharif.com</h1>
        </div>
        <div class="row" style="align-items: center;">
            <!-- Left Side Content -->
            <div class="col-md-8 col-12" style="padding: 20px;">
                <div style="font-size: 16px; color: #0a5c36;">
                   <p>
                     <strong>Urdu:</strong><b>"اگر آپ چاہتے ہیں کہ یہ ویب سائٹ آئندہ بھی چلتی رہے اور لوگوں تک مفید دینی معلومات، تقریبات، اور اپڈیٹس پہنچتی رہیں، تو آپ اس کارِ خیر میں اپنا حصہ ڈال سکتے ہیں۔ نیچے دیے گئے QR کوڈ یا UPI ID <strong>ashz82462@ybl</strong> کے ذریعے تعاون کریں۔ آپ کا چھوٹا سا تعاون بھی بہت قیمتی ہے۔ جزاکم اللہ خیراً!"</b>
                   </p><br><br><h1><center><b>****************************</b></center></h1><br><br>
                   <p>
                     <strong>हिन्दी:</strong> देवाशरीफ की यह वेबसाइट आप सभी के लिए एक आध्यात्मिक जानकारी का स्रोत है। यदि आप चाहते हैं कि यह वेबसाइट भविष्य में भी चलती रहे और नई जानकारी व अपडेट्स देती रहे, तो कृपया सहयोग करें। आप नीचे दिए गए QR कोड या UPI ID <strong>ashz82462@ybl</strong> के माध्यम से अपना योगदान दे सकते हैं।
                   </p><br><br><h1><center><b>****************************</b></center></h1><br><br>
                   <p>
                     <strong>English:</strong> This Dewasharif website is a spiritual source of knowledge for all. To keep it alive and updated for the future, your support is valuable. Please consider contributing via the QR code below or through UPI ID <strong>ashz82462@ybl</strong>.
                   </p>

                </div>
            </div>

            <!-- Right Side Image -->
            <div class="col-md-4 col-12" style="padding: 20px;">
                <img src="{{ asset('home/images/dewasharif/qr.jpeg') }}" alt="Dewa Sharif URS" title="Dewa Sharif URS 2024"
                    style="width: 100%; max-height: 80%; object-fit: cover; border-radius: 8px;" />
            </div>
        </div>
    </div>
</section> --}}

<section id="unfold">
    <div class="container">
        <div class="title">
            <p style="color: #0a5c36">Dive In And Discover</p>
            <h1 style="color: #03be64"><b>Visual Library</b></h1>
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-6">
                <div class="pcard">
                    <a href="#" target="_blank" rel="noopener">
                        <img src="{{ asset('home/images/1.jpg') }}" alt="Blog" class="img-fluid" />
                    </a>
                    <div class="box text-center">
                        <a href="#" target="_blank" rel="noopener">
                            <img src="{{ asset('home/images/blog.png') }}" alt="Blog" class="img-fluid" />
                        </a>
                        <h4><a href="#">Blog</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="pcard">
                    <a href="#" rel="noopener">
                        <img src="{{ asset('home/images/2.jpg') }}" alt="Photo Gallery" class="img-fluid" />
                    </a>
                    <div class="box text-center">
                        <a href="#"><img src="{{ asset('home/images/Visual_Library1.png') }}" alt="Photo Gallery" class="img-fluid" /></a>
                        <h4><a href="#">Photo Gallery</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="pcard">
                    <a href="#" rel="noopener">
                        <img src="{{ asset('home/images/3.jpg') }}" alt="Video Gallery" class="img-fluid" />
                    </a>
                    <div class="box text-center">
                        <a href="#"><img src="{{ asset('home/images/Visual_Library2.png') }}" alt="Video Gallery" class="img-fluid" /></a>
                        <h4><a href="#">Video Gallery</a></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="pcard">
                    <a href="#" rel="noopener">
                        <img src="{{ asset('home/images/dewasharif/india.jpg') }}" alt="India" class="img-fluid" />
                    </a>
                    <div class="box text-center">
                        <a href="#"><img src="{{ asset('home/images/icons/oneday.png') }}" alt="India" class="img-fluid" /></a>
                        <h4><a href="#">India</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="explorebg2">
        <img src="{{ asset('home/images/unfoldbg.png') }}" alt="Image of Background" />
    </div>
</section>


<section id="connect">
    <div class="container">
        <div class="row ">
            <div class="col-md-12 ">
                <div class="text-center title">
                    <span class="arrow1"><img src="{{ asset('home/images/arrow1.png') }}" /></span>
                    <h1><b>Connect </b> &amp; <b>Engage</b></h1>
                    <span class="arrow2"><img src="{{ asset('home/images/arrow2.png') }}" /></span>
                </div>

                <ul class="sm-icon" style="padding-left: 2px">
                    <li><a href="https://www.facebook.com/dewasharif707?mibextid=ZbWKwL" target="_blank" rel="noopener"
                            class="external none" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                    <li><a href="https://x.com/dewasharif707?t=V7INlftOKGRvkXpyxt8hcg&s=09" target="_blank"
                            rel="noopener" class="external none" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                    <li><a href="https://www.instagram.com/dewa.sharif707/profilecard/?igsh=NzR1YjdubmRndGJ5"
                            target="_blank" rel="noopener" class="external none" title="Instagram"><i
                                class="fa fa-instagram"></i></a></li>
                    <li><a href="https://www.youtube.com/@DewaSharif707" target="_blank" rel="noopener"
                            class="external none" title="YouTube"><i class="fa fa-youtube-play"></i></a></li>
                    <li>
                        <a href="#" target="_blank" rel="noopener" class="external none" title="UP Tourism Blog"
                            style="position: relative;">
                            <img src="{{ asset('home/images/blog.png') }}"
                                style="filter: contrast(0%) brightness(20%); width: 74px;" />
                            <span
                                style="position: absolute; font-size: 10px; color: #000; left: 0; right: -28px; bottom: -10px; text-transform: uppercase; font-weight: 800;">blog</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="explorebg2">
        <img src="{{ asset('home/images/connectbg.png') }}" alt="Image of background" title="background" />
    </div>
</section>

<section id="branding">
    <div class="container">
        <div class="title">
            <h1 style="color: #074121"><b>Mother</b> is the <b>Fragrance</b> of <b>Love</b> <i><b>- MASHARRAT WARSI
                    </b></i></h1>
        </div>

    </div>
</section>
@endsection
