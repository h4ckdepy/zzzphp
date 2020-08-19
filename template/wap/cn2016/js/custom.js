// JavaScript Document
(function($) {
    $(window).load(function() {
        var nav = document.getElementById("nav");
        var links = nav.getElementsByTagName("li");
        var lilen = nav.getElementsByTagName("a");
        var currenturl = document.location.href;
        var last = 0;
        for (var i = 0; i < links.length; i++) {
            var linkurl = lilen[i].getAttribute("href");
            if (currenturl.indexOf(linkurl) != -1) {
                last = i;
            }
        }	
    });
$(document).ready(function() {
     $('.tabPanel ul li').click(function(){
          $(this).addClass('hit').siblings().removeClass('hit');
          $('.panes>div:eq('+$(this).index()+')').show().siblings().hide();    
		  $("#shenqing").hide();
		    $(".beizhu").text("");
     })
	 $("#showlibao").click(function(){$(".libao").slideToggle();})
})

    $(document).ready(function() {
        $(".pn a").click(function() {
            href = $(this).attr("href");
            if (href == "#") {
                alert("没有了");
                return false;
            }
        });
        //Share Links
        $(".share").slideToggle(200);
        $(".share-link").click(function() {
            $(this).parent().parent().find(".share").slideToggle(200);
            $(this).next("ul").slideToggle(200);
            if ($(this).find("span").html() == "-") $(this).find("span").html("+"); else $(this).find("span").html("-");
            return false;
        });
        window.addEventListener("load", function() {
            FastClick.attach(document.body);
        }, false);
        //Submenu Deploy//
        $(".swipebox").click(function() {
            $(".gallery").hide(0);
            $(".portfolio-wide").hide(0);
        });
        $(".open-left").click(function() {
            $(".show-left-sidebar").toggleClass("show-left-sidebar-ball");
            $(".show-right-sidebar").toggleClass("show-right-sidebar-ball");
            //$(this).toggleClass('remove-sidebar');
            if (snapper.state().state == "left") {
                snapper.close();
            } else {
                snapper.open("left");
            }
            return false;
        });
        $(".open-right").click(function() {
            $(".show-right-sidebar").toggleClass("show-right-sidebar-ball");
            $(".show-left-sidebar").toggleClass("show-left-sidebar-ball");
            //$(this).toggleClass('remove-sidebar');
            if (snapper.state().state == "right") {
                snapper.close();
            } else {
                snapper.open("right");
            }
            return false;
        });
        $("#content").click(function() {
            $(".show-left-sidebar").removeClass("show-left-sidebar-ball");
            $(".show-right-sidebar").removeClass("show-right-sidebar-ball");
        });
        $(".sidebar-close, .homepage-slider, .featured-slider, .swipebox").click(function() {
            snapper.close();
            $(".show-left-sidebar").removeClass("show-left-sidebar-ball");
            $(".show-right-sidebar").removeClass("show-right-sidebar-ball");
        });
        var snapper = new Snap({
            element:document.getElementById("content")
        });
        //Show Sidebar Button//
        $(".sidebar-form .contactTextarea, .sidebar-form .contactField").click(function() {
            $(".sidebar-form #contactSubmitButton").addClass("show-sidebar-form-button");
        });
        var endDate = "June 7, 2015 15:03:25";
        $(".countdown").countdown({
            date:endDate,
            render:function(data) {
                $(this.el).html("<div class='countdown-box box-years'><div class='countdown-years'>" + this.leadingZeros(data.years, 2) + "</div><span>years</span></div><div class='countdown-box box-days'><div class='countdown-days'>" + this.leadingZeros(data.days, 2) + "</div><span>days</span></div><div class='countdown-box box-hours'><div class='countdown-hours'>" + this.leadingZeros(data.hours, 2) + "</div><span>hours</span></div><div class='countdown-box box-minutes'><div class='countdown-minutes'>" + this.leadingZeros(data.min, 2) + "</div><span>min</span></div><div class='countdown-box box-seconds'><div class='countdown-seconds'>" + this.leadingZeros(data.sec, 2) + "</div><span>sec</span></div>");
            }
        });
        //Switches
        //Switches
        $(".switch-1").click(function() {
            $(this).toggleClass("switch-1-on");
        });
        $(".switch-2").click(function() {
            $(this).toggleClass("switch-2-on");
        });
        $(".switch-3").click(function() {
            $(this).toggleClass("switch-3-on");
        });
        $(".switch, .switch-icon").click(function() {
            $(this).parent().find(".switch-box-content").slideToggle(200);
            $(this).parent().find(".switch-box-subtitle").slideToggle(200);
        });
        //Animate.css scroll to begin animation //	
        var wow = new WOW({
            boxClass:"animate",
            // animated element css class (default is wow)
            animateClass:"animated",
            // animation css class (default is animated)
            offset:0,
            // distance to the element when triggering the animation (default is 0)
            mobile:true
        });
        wow.init();
        //Go up
        $(".footer-up").click(function() {
            $("#content").animate({
                scrollTop:0
            }, 800, "easeInOutQuad");
            return false;
        });
        //Portfolio//
        $(".adaptive-one-activate").click(function() {
            $(".portfolio-adaptive").removeClass("adaptive-three");
            $(".portfolio-adaptive").removeClass("adaptive-two");
            $(".portfolio-adaptive").addClass("adaptive-one");
            $(this).addClass("active-adaptive-style");
            $(".adaptive-two-activate, .adaptive-three-activate").removeClass("active-adaptive-style");
            return false;
        });
        $(".adaptive-two-activate").click(function() {
            $(".portfolio-adaptive").removeClass("adaptive-three");
            $(".portfolio-adaptive").addClass("adaptive-two");
            $(".portfolio-adaptive").removeClass("adaptive-one");
            $(this).addClass("active-adaptive-style");
            $(".adaptive-three-activate, .adaptive-one-activate").removeClass("active-adaptive-style");
            return false;
        });
        $(".adaptive-three-activate").click(function() {
            $(".portfolio-adaptive").addClass("adaptive-three");
            $(".portfolio-adaptive").removeClass("adaptive-two");
            $(".portfolio-adaptive").removeClass("adaptive-one");
            $(this).addClass("active-adaptive-style");
            $(".adaptive-two-activate, .adaptive-one-activate").removeClass("active-adaptive-style");
            return false;
        });
        //Close Sharebox//
        $(".open-sharebox").click(function() {
            $(".sharebox-wrapper").fadeIn(200);
        });
        $(".close-sharebox").click(function() {
            $(".sharebox-wrapper").fadeOut(200);
        });
        $(".open-loginbox").click(function() {
            $(".loginbox-wrapper").fadeIn(200);
        });
        $(".close-loginbox").click(function() {
            $(".loginbox-wrapper").fadeOut(200);
        });
        //Checkboxes
        $(".checkbox-one").click(function() {
            $(this).toggleClass("checkbox-one-checked");
            return false;
        });
        $(".checkbox-two").click(function() {
            $(this).toggleClass("checkbox-two-checked");
            return false;
        });
        $(".checkbox-three").click(function() {
            $(this).toggleClass("checkbox-three-checked");
            return false;
        });
        $(".radio-one").click(function() {
            $(this).toggleClass("radio-one-checked");
            return false;
        });
        $(".radio-two").click(function() {
            $(this).toggleClass("radio-two-checked");
            return false;
        });
        //Notifications
        $(".tap-dismiss-notification").click(function() {
            $(this).slideUp(200);
            return false;
        });
        $(".close-big-notification").click(function() {
            $(this).parent().slideUp(200);
            return false;
        });
        $(".notification-top").addClass("show-notification-top");
        $(".hide-top-notification").click(function() {
            $(".notification-top").removeClass("show-notification-top");
        });
        //Tabs 
        $(".tab-but-1").click(function() {
            $(".tab-but").removeClass("tab-active");
            $(".tab-but-1").addClass("tab-active");
            $(".tab-content").slideUp(200);
            $(".tab-content-1").slideDown(200);
            return false;
        });
        $(".tab-but-2").click(function() {
            $(".tab-but").removeClass("tab-active");
            $(".tab-but-2").addClass("tab-active");
            $(".tab-content").slideUp(200);
            $(".tab-content-2").slideDown(200);
            return false;
        });
        $(".tab-but-3").click(function() {
            $(".tab-but").removeClass("tab-active");
            $(".tab-but-3").addClass("tab-active");
            $(".tab-content").slideUp(200);
            $(".tab-content-3").slideDown(200);
            return false;
        });
        $(".tab-but-4").click(function() {
            $(".tab-but").removeClass("tab-active");
            $(".tab-but-4").addClass("tab-active");
            $(".tab-content").slideUp(200);
            $(".tab-content-4").slideDown(200);
            return false;
        });
        $(".tab-but-5").click(function() {
            $(".tab-but").removeClass("tab-active");
            $(".tab-but-5").addClass("tab-active");
            $(".tab-content").slideUp(200);
            $(".tab-content-5").slideDown(200);
            return false;
        });
        //Toggles
        $(".deploy-toggle-1").click(function() {
            $(this).parent().find(".toggle-content").slideToggle(200);
            $(this).toggleClass("toggle-1-active");
            return false;
        });
        $(".deploy-toggle-2").click(function() {
            $(this).parent().find(".toggle-content").slideToggle(200);
            $(this).toggleClass("toggle-2-active");
            return false;
        });
        $(".deploy-toggle-3").click(function() {
            $(this).parent().find(".toggle-content").slideToggle(200);
            $(this).find("em strong").toggleClass("toggle-3-active-ball");
            $(this).find("em").toggleClass("toggle-3-active-background");
            return false;
        });
        //Submenu Nav
        $(".submenu-nav-deploy").click(function() {
            $(this).toggleClass("submenu-nav-deploy-active");
            $(this).parent().find(".submenu-nav-items").slideToggle(200);
            return false;
        });
        //Sliding Door
        $(".sliding-door-top").click(function() {
            $(this).animate({
                left:"101%"
            }, 500, "easeInOutExpo");
            return false;
        });
        $(".sliding-door-bottom a em").click(function() {
            $(this).parent().parent().parent().find(".sliding-door-top").animate({
                left:"0px"
            }, 500, "easeOutBounce");
            return false;
        });
        /////////////////////////////////////////////////////////////////////////////////////////////
        //Detect user agent for known mobile devices and show hide elements for each specific element
        /////////////////////////////////////////////////////////////////////////////////////////////
        var isiPhone = navigator.userAgent.toLowerCase().indexOf("iphone");
        var isiPad = navigator.userAgent.toLowerCase().indexOf("ipad");
        var isiPod = navigator.userAgent.toLowerCase().indexOf("ipod");
        var isiAndroid = navigator.userAgent.toLowerCase().indexOf("android");
        if (isiPhone > -1) {
            $(".ipod-detected").hide();
            $(".ipad-detected").hide();
            $(".iphone-detected").show();
            $(".android-detected").hide();
        }
        if (isiPad > -1) {
            $(".ipod-detected").hide();
            $(".ipad-detected").show();
            $(".iphone-detected").hide();
            $(".android-detected").hide();
        }
        if (isiPod > -1) {
            $(".ipod-detected").show();
            $(".ipad-detected").hide();
            $(".iphone-detected").hide();
            $(".android-detected").hide();
        }
        if (isiAndroid > -1) {
            $(".ipod-detected").hide();
            $(".ipad-detected").hide();
            $(".iphone-detected").hide();
            $(".android-detected").show();
        }
        //Detect if iOS WebApp Engaged and permit navigation without deploying Safari
        (function(a, b, c) {
            if (c in b && b[c]) {
                var d, e = a.location, f = /^(a|html)$/i;
                a.addEventListener("click", function(a) {
                    d = a.target;
                    while (!f.test(d.nodeName)) d = d.parentNode;
                    "href" in d && (d.href.indexOf("http") || ~d.href.indexOf(e.host)) && (a.preventDefault(), 
                    e.href = d.href);
                }, !1);
            }
        })(document, window.navigator, "standalone");
        var owlStaffControls = $(".staff-slider");
        owlStaffControls.owlCarousel({
            //Basic Stuff
            items:3,
            itemsDesktop:[ 1199, 3 ],
            itemsDesktopSmall:[ 980, 3 ],
            itemsTablet:[ 768, 2 ],
            itemsTabletSmall:[ 480, 1 ],
            itemsMobile:[ 370, 1 ],
            singleItem:false,
            itemsScaleUp:false,
            slideSpeed:250,
            paginationSpeed:250,
            rewindSpeed:250,
            pagination:false,
            autoPlay:false,
            autoHeight:false
        });
        $(".next-staff").click(function() {
            owlStaffControls.trigger("owl.next");
            return false;
        });
        $(".prev-staff").click(function() {
            owlStaffControls.trigger("owl.prev");
            return false;
        });
        var owlFeaturedControls = $(".featured-slider");
        owlFeaturedControls.owlCarousel({
            //Basic Stuff
            items:3,
            itemsDesktop:[ 1199, 3 ],
            itemsDesktopSmall:[ 980, 3 ],
            itemsTablet:[ 768, 2 ],
            itemsTabletSmall:[ 480, 1 ],
            itemsMobile:[ 370, 1 ],
            singleItem:false,
            itemsScaleUp:false,
            slideSpeed:250,
            paginationSpeed:250,
            rewindSpeed:250,
            pagination:false,
            autoPlay:false,
            autoHeight:false
        });
        $(".next-featured").click(function() {
            owlFeaturedControls.trigger("owl.next");
            return false;
        });
        $(".prev-featured").click(function() {
            owlFeaturedControls.trigger("owl.prev");
            return false;
        });
        var owlQuoteSlider = $(".quote-slider");
        owlQuoteSlider.owlCarousel({
            items:1,
            itemsDesktop:[ 1199, 1 ],
            itemsDesktopSmall:[ 980, 1 ],
            itemsTablet:[ 768, 1 ],
            itemsTabletSmall:[ 480, 1 ],
            itemsMobile:[ 370, 1 ],
            singleItem:false,
            itemsScaleUp:false,
            slideSpeed:800,
            paginationSpeed:300,
            rewindSpeed:250,
            pagination:false,
            autoHeight:true,
            autoPlay:true
        });
        $(".next-quote").click(function() {
            owlQuoteSlider.trigger("owl.next");
            return false;
        });
        $(".prev-quote").click(function() {
            owlQuoteSlider.trigger("owl.prev");
            return false;
        });
        /////////////////
        //Image Gallery//
        /////////////////
        $(".swipebox").swipebox({
            useCSS:true,
            // false will force the use of jQuery for animations
            hideBarsDelay:3e3
        });
        $(".wide-gallery-item").swipebox({
            useCSS:true,
            // false will force the use of jQuery for animations
            hideBarsDelay:3e3
        });
        var time = 7;
        // time in seconds
        var $progressBar, $bar, $elem, isPause, tick, percentTime;
        //Init the carousel
        $(".homepage-slider").owlCarousel({
            slideSpeed:500,
            paginationSpeed:500,
            singleItem:true,
            pagination:false,
            afterInit:progressBar,
            afterMove:moved,
            startDragging:pauseOnDragging
        });
        //Init progressBar where elem is $("#owl-demo")
        function progressBar(elem) {
            $elem = elem;
            //build progress bar elements
            buildProgressBar();
            //start counting
            start();
        }
        //create div#progressBar and div#bar then prepend to $("#owl-demo")
        function buildProgressBar() {
            $progressBar = $("<div>", {
                id:"progressBar"
            });
            $bar = $("<div>", {
                id:"bar"
            });
            $progressBar.append($bar).prependTo($elem);
        }
        function start() {
            //reset timer
            percentTime = 0;
            isPause = false;
            //run interval every 0.01 second
            tick = setInterval(interval, 10);
        }
        function interval() {
            if (isPause === false) {
                percentTime += 1 / time;
                $bar.css({
                    width:percentTime + "%"
                });
                //if percentTime is equal or greater than 100
                if (percentTime >= 100) {
                    //slide to next item 
                    $elem.trigger("owl.next");
                }
            }
        }
        //pause while dragging 
        function pauseOnDragging() {
            isPause = true;
        }
        //moved callback
        function moved() {
            //clear interval
            clearTimeout(tick);
            //start again
            start();
        }
        // Custom Navigation Events
        $(".next-home").click(function() {
            $(".homepage-slider").trigger("owl.next");
            return false;
        });
        $(".prev-home").click(function() {
            $(".homepage-slider").trigger("owl.prev");
            return false;
        });
        var coverpage_height = 0;
        function initiate_coverpages() {
            coverpage_height = $(window).height();
            $(".coverpage").css({
                height:coverpage_height + 1
            });
        }
        initiate_coverpages();
        $(window).resize(function() {
            initiate_coverpages();
        });
        $.scrollIt({
            //upKey: 38,             // key code to navigate to the next section
            //downKey: 40,           // key code to navigate to the previous section
            scrollTime:700,
            // how long (in ms) the animation takes
            easing:"easeInOutExpo",
            // the easing function for animation
            activeClass:"active-coverpage"
        });
        $(function() {
            $("#homepage-nav").find("a").click(function(e) {
                e.preventDefault();
                $(this.hash).show();
                $(this.hash).siblings().hide();
                $("#homepage-nav").find("a").removeClass("active-homepage-tab");
                $(this).addClass("active-homepage-tab");
            }).filter(":first").click();
        });
    });
})(jQuery);
