<script>// <![CDATA[
    !function (d, s, id) { var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https'; if (!d.getElementById(id)) { js = d.createElement(s); js.id = id; js.src = p + "://platform.twitter.com/widgets.js"; fjs.parentNode.insertBefore(js, fjs); } }(document, "script", "twitter-wjs");
    // ]]></script><noscript class="hidden">Javascipt has been disabled.</noscript>
<script src="{{ asset('home/js/anime.min.js') }}"></script><noscript class="hidden">Javascipt has been disabled.</noscript>
<script>
    var textWrapper = document.querySelector('.ml1 .letters');
    textWrapper.innerHTML = textWrapper.textContent.replace(/\S/g, "<span class='letter'>$&</span>");

    anime.timeline({ loop: true })
        .add({
            targets: '.ml1 .letter',
            scale: [0.3, 1],
            opacity: [0, 1],
            translateZ: 0,
            easing: "easeOutExpo",
            duration: 600,
            delay: (el, i) => 70 * (i + 1)
        })
        .add({
            targets: '.ml1 .line',
            scaleX: [0, 1],
            opacity: [0.5, 1],
            easing: "easeOutExpo",
            duration: 700,
            offset: '-=875',
            delay: (el, i, l) => 80 * (l - i)
        }).add({
            targets: '.ml1',
            opacity: 0,
            duration: 1000,
            easing: "easeOutExpo",
            delay: 2000
        });
</script><noscript class="hidden">Javascipt has been disabled.</noscript>

<script type="text/javascript" src="{{ asset('home/js/jquery.min.js') }}"></script>
<noscript class="hidden">Javascipt has been disabled.</noscript>
<script>
    var vid = document.getElementById("myVideo");
    function playVid() {
        vid.play();
    }
    function pauseVid() {
        vid.pause();
    }
</script><noscript class="hidden">Javascipt has been disabled.</noscript>

<script src="{{ asset('home/Scripts/jquery-ui.min.js') }}"></script>
<noscript class="hidden">
    Javascipt has been disabled.
</noscript>
<script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
<noscript class="hidden">
    Javascipt has been disabled.
</noscript>
<script type="text/javascript" src="{{ asset('home/Scripts/Calendar/caleandar.js') }}"></script>
<noscript class="hidden">
    Javascipt has been disabled.
</noscript>
<script src='{{ asset('home/site/writereaddata/config/pagesjsscript/en-home-template.js') }}'></script>

<!-- Include all below Javascript library for Dynamic Work and should not be removed from here. -->
<script type="text/javascript">
    $(function () {
        //$('#basicExampleModal').modal('show');
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('.skiper').click(function () {
            $('html, body').animate({ scrollTop: 650 }, 800);
            return false;
        });
    });
</script><noscript class="hidden">Javascipt has been disabled.</noscript>
<!--<script src="{{ asset('home/js/jquery.js') }}"></script>-->
<script src="{{ asset('home/js/animate.js') }}"></script><noscript class="hidden">Javascipt has been disabled.</noscript>
<script src="{{ asset('home/js/jquery.flipster.min.js') }}"></script>
<script>
    var coverflow = $("#coverflow").flipster();
    var carousel = $("#cityhighlight").flipster({
        style: 'carousel',
        spacing: -0.2,
        nav: false,
        buttons: true,
    });
</script>

<script>
    $(document).ready(function () {
        $('ul.nav li.dropdown').hover(function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeIn(150);
        }, function () {
            $(this).find('.dropdown-menu').stop(true, true).delay(50).fadeOut(150);
        });
    });
</script><noscript class="hidden">Javascipt has been disabled.</noscript>
<script type="text/javascript" src="{{ asset('home/js/jquery.cookie.js') }}"></script> <!--For Cookies-->
<noscript class="hidden">
    Your browser does not support JavaScript!
</noscript>
<script type="text/javascript" src="{{ asset('home/js/font-resize.js') }}"></script>
<noscript class="hidden">
    Your browser does not support JavaScript!
</noscript>
<script src="{{ asset('home/js/svg-map.js') }}"></script><noscript class="hidden">Javascipt has been disabled.</noscript>
<script src="frmErrorPage2416.html"></script><noscript class="hidden">Javascipt has been disabled.</noscript>
<script src="frmErrorPage2416.html"></script><noscript class="hidden">Javascipt has been disabled.</noscript>
<script src="{{ asset('home/js/three.min.js') }}"></script><noscript class="hidden">Javascipt has been disabled.</noscript>

<script src="{{ asset('home/en_Themes/owl.carousel.js') }}"></script><noscript class="hidden">Javascipt has been
    disabled.</noscript>
<!-- <script src="js/owl.carousel.js"></script>  -->
<script src="{{ asset('home/js/wow.min.js') }}"></script><noscript class="hidden">Javascipt has been disabled.</noscript>

<script type="text/javascript">
    new WOW().init();
</script><noscript class="hidden">Javascipt has been disabled.</noscript>
<script>
    $(window).scroll(function () {
        var height = $(window).scrollTop();
        if (height > 350) {
            $(".level--1").addClass("level--current");
            $(".level__pins").addClass("level__pins--active");
        }
        if (height < 350) {
            $(".level--1").removeClass("level--current");
            $(".level__pins").removeClass("level__pins--active");
        }

    });
</script><noscript class="hidden">Javascipt has been disabled.</noscript>

<!-- Designer Should paste all required scripts here only. -->



<noscript class="hidden">
    Javascipt has been disabled.
</noscript>
<script type="text/javascript">
    $(document).ready(function () {
        $('#upmap').hide();
        $('input[name="q"]').keypress(function (event) {
            debugger;
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13') {
                var v = $('input[name="q"]').val();
                if (v == "") {
                    return false;
                }
                event.stopPropagation();
            }
        });
        $('input[name="Subscribe"]').click(function () {
            //debugger;
            fnSubscribe();
        });
        function fnSubscribe() {
            var emailid = $('input[name="newsletteremail"]').val();
            var webdept = $('#hdnWbDept').val();
            var vridval = $('#hdnVerId').val();
            chk = /\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/;
            if (emailid == "") {
                isC = false;
                alert("Email Address is required.");
                return false;
            }
            if (chk.test(emailid)) {
            }
            else {
                alert("Invalid Email Address.");
                return false;
            }
            var data = { email: emailid, flag: 'en', wd: webdept, vrid: vridval };
            $.ajax({
                type: "POST",
                url: "./index.aspx/Insertnewsletter",
                data: JSON.stringify(data),
                contentType: "application/json; charset=utf-8",
                dataType: "json",
                success: function (response) {
                    alert("Subscribed successfully.");
                    $('input[name="newsletteremail"]').val('');
                },
                failure: function (response) {
                    alert(response.d);
                }
            });
        }
    });
</script>
<noscript class="hidden">
    Javascipt has been disabled.
</noscript>

<script type="text/javascript">
    var element = document.getElementById('calendar_elm');
    var webdptid = $("#hdnWbDept").val();

    if (element != null) {
        $.ajax({
            url: "Services/Service.asmx/GetAllEventCalendar",
            type: 'POST',
            dataType: "json",
            contentType: "application/json; charset=utf-8",
            data: "{ WebDeptId:" + webdptid + "}",
            success: function (data) {
                var html = '';
                var tData = JSON.parse(data.d);
                var events = [];
                $.each(tData, function (index) {
                    html = { 'Date': new Date(tData[index].FromDate.split('index.html')[2] + ',' + tData[index].FromDate.split('index.html')[1] + ',' + tData[index].FromDate.split('index.html')[0]), 'Title': tData[index].Title, 'Link': 'javascript:void(0)' };
                    events.push(html);
                });
                var settings = {};
                var element = document.getElementById('calendar_elm');
                caleandar(element, events, settings);
            }
        });
    }
</script>
<noscript class="hidden">
    Javascipt has been disabled.
</noscript>

<script type="text/javascript" src="{{ asset('home/site/writereaddata/config/sitejs.js') }}"></script>
<noscript class="hidden">
    Javascipt has been disabled.
</noscript>
<script src="{{ asset('home/en_Themes/myscript.js') }}"></script>
<noscript class="displaynoscript">This page uses Javascript. Your browser either doesn't support Javascript or
    you have it turned off. To see this page as it is meant to appear please use a Javascript enabled
    browser.</noscript>
