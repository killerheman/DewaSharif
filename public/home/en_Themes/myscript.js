

$(document).keypress(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {
        //alert('You pressed a "enter" key in textbox');
        $(".scrolldown").trigger("click");
    }
});
jQuery(function () {
    jQuery('#showall').click(function () {
      jQuery('.targetDiv').show();
    });
    jQuery('.showSingle').click(function () {
      jQuery('.targetDiv').hide();
      jQuery('.point' + $(this).attr('target')).show();
    });
  });
$(window).scroll(function () {
    var height = $(window).scrollTop();
    if (height > 150) {
        $(".top-nav").addClass("pwdFxd");
    }
    if (height < 150) {
        $(".top-nav").removeClass("pwdFxd");
    }
});


$(document).ready(function () {
    $(".mega-dropdown > .dropdown-toggle").attr("href", "javascript:void(0)")
    $(".backbtn").click(function () {
        window.history.go(-1);
        return false;
    });

    /*$('.scrolldown').keypress(function (e) {
    var key = e.which;
    if(key == 13)  // the enter key code
    {
    //$('input[name = butAssignProd]').click();
    alert("aaa")
    return false;
    }
    });    */

    // $(".about-tag").append('<div class="menu-action col-md-12"><img alt="menu-sevron" src="images/tourismicon.png"><div class="menuacttitle">A unique opportunity to explore Uttar Pradesh</div></div>');
    // $(".dest-tag").append('<div class="menu-action col-md-12"><img alt="menu-sevron" src="images/tourismicon.png"><div class="menuacttitle">Meet the locals and learn the secrets of cities.</div></div>');
    // $(".exp-tag").append('<div class="menu-action col-md-12"><img alt="menu-sevron" src="images/tourismicon.png"><div class="menuacttitle">Experience the natural wonders of Uttar Pradesh – sublime and serene.</div></div>');
    // $(".plan-tag").append('<div class="menu-action col-md-12"><img alt="menu-sevron" src="images/tourismicon.png"><div class="menuacttitle">Wherever you go, go with all your heart</div></div>');
    // $(".online-tag").append('<div class="menu-action col-md-12"><img alt="menu-sevron" src="images/tourismicon.png"><div class="menuacttitle">Choose your tours, ride and hotels</div></div>');

    $(".scrolldown").click(function () {
        $(this).toggleClass('slect');
        $(".landing-wrap").addClass("wraphide");
        $(".webtop-section").addClass("show");
    });

    $(".nav-tabs li a").click(function () {
        $(".nav-tabs li a").removeClass("active");
    });

    $(".search .sopen").click(function () {
        $(".searchdiv").fadeToggle("slow");
    });

    $(".sidebarbutton .sidebarhide").click(function () {
        $(".sidebarmenu").toggleClass("sidebaropen")
    });

    $(".news .toggle").click(function () {
        $("#vticker ul").toggleClass("scroll");
    });

    $(".news .toggle2").click(function () {
        $("#tender ul").toggleClass("scroll");
    });

    $('.pagedata table').wrap('<div class="table-responsive">');
    $(".pagedata table").addClass("table table-bordered table-striped");
    $(".removetblclass table").removeClass("table table-bordered table-striped");
    $("ul.entender").addClass("newsscroll");


    $(".pure-js-lightbox-container li").wrap('<div class="col-xs-6 col-md-6 col-sm-6 col-lg-3 photo-gallery">');

    $(".sitemap ul").removeClass("nav navbar-nav");
    $(".sitemap li").removeClass("dropdown mega-dropdown menu-heading");
    $(".sitemap li").removeClass("dropdown-submenu col-md-4 col-md-3");
    $(".sitemap li a").removeClass("dropdown-toggle");
    $(".sitemap ul ul").removeClass("dropdown-menu mega-dropdown-menu");
    $(".sitemap ul").removeAttr("id", "menu");



    if ($.cookie("css")) {
        $("#theme").attr("href", $.cookie("css"));
    }
    $(".defTheme").click(function () {
        $("#theme").attr("href", $(this).attr('href'));
        $.cookie("css", $(this).attr('href'));
        return false;
    });

    $(".hi-btn").click(function () {
        var cfrm = confirm("Do you want to change website language in Hindi?");
        if (cfrm == true) {
            window.location(this.window.url + "/hi");
            return true;
        }
        else if (cfrm == false) {
            return false;
        }
        //alert(crm);
    });

    var comp = new RegExp(location.host);
    $('a').each(function () {
        if (comp.test($(this).attr('href'))) {
            // a link that contains the current host
            $(this).addClass('local');
        }
        else {
            // a link that does not contain the current host
            $(this).addClass('external');
        }
    });

    $('a').filter(function () {
        return this.hostname && this.hostname !== location.hostname;
    }).attr('target', '_blank').attr('rel', 'noopener');



    $(window).scroll(function () {
        var height = $(window).scrollTop();
        if (height > 132) {
            $(".logo-section").addClass("menuFxd");
        }
        if (height < 132) {
            $(".logo-section").removeClass("menuFxd");
        }
    });
    //alert("test")


    $('a.hellotest').click(function (e) {

        e.preventDefault();
    });

    $(window).load(function () {
        //	$("div").delegate( "form", "load", function() {
        $('#edit-name').val('');
        $('#edit-mail').val('');
    });

    $(document).ready(function () {

        $('a').each(function () {

            if (location.href === this.href) {
                $(this).addClass('selected');
                $('a').not(this).addClass('none');
                return false;
            }

        });
    });



    /* IMAGE CAPTION */

    $(".grid-stack img").each(function () {
        var imageCaption = $(this).attr("title");
        if (imageCaption != '') {
            var imgWidth = $(this).width();
            var imgHeight = $(this).height();
            var position = $(this).position();
            var positionTop = (position.top + imgHeight - 26);
            $("<span class='title-caption'><em>" + imageCaption + "</em></span>").css({
                "position": "absolute", "top": positionTop + "px",

                "left": "18px", "width": imgWidth + "px"
            }).insertAfter(this);
        }
        var num = imageCaption;
        var mnum = num.indexOf("/");
        var title = num.substr(0, mnum)
        $(this).attr('title', title);
        $(this).attr('alt', title);
    });

    $(".title-caption em").each(function () {
        var num = $(this).html();
        var mnum = num.indexOf("/");
        var title = num.substr(0, mnum)
        $(this).html(title)
    });

    $(".grid-stack-item-content a").each(function (index) {
        var numm = $(this).attr('data-caption')
        var mnumm = numm.indexOf("/");
        var titlef = numm.substr(0, mnumm)
        $(this).attr('data-caption', titlef);
        $(this).on("click", function () {
            //
            //alert($(this).attr('data-caption'));
            // For the boolean value
            //$(".fancybox-caption__body").hide()
            //var num = $(this).html();
            //var mnum = num.indexOf("/");
            //var title = num.substr(mnum+1, num.length)
            //$(this).html(title)
        });

    });

    ///////////////////////////
    /////////yaksh js//////////
    ///////////////////////////

    function showList(e) {
        var $gridCont = $('.grid-container');
        e.preventDefault();
        $gridCont.hasClass('list-view') ? $gridCont.removeClass('list-view') : $gridCont.addClass('list-view');
    }
    function gridList(e) {
        var $gridCont = $('.grid-container')
        e.preventDefault();
        $gridCont.removeClass('list-view');
    }

    $(document).on('click', '.btn-grid', gridList);
    $(document).on('click', '.btn-list', showList);





    var selector = '.btn_within';

    $(selector).on('click', function () {
        $(selector).removeClass('btn-active');
        $(this).addClass('btn-active');
    });
});


