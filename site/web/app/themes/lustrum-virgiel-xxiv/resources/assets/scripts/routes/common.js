export default {

    init() {
        // JavaScript to be fired on all pages
    },
    finalize() {

        /*global FB*/
        /*global updateStatusCallback*/

        $.ajaxSetup({ cache: true });

        $.getScript('https://connect.facebook.net/nl_NL/sdk.js', function(){
            FB.init({
                appId: '148485092478258',
                version: 'v2.7', // or v2.1, v2.2, v2.3, ...
            });
            $('#loginbutton,#feedbutton').removeAttr('disabled');
            FB.getLoginStatus(updateStatusCallback);
        });

        if ($("body").hasClass("has-hero")) {
            $('.site-header').addClass('hero-header').removeClass('z-depth-2');
            $(window).scroll(function(){
                if ($(window).scrollTop() >= $('.hero').height() * 0.4) {
                    $('.site-header').removeClass('hero-header').addClass('z-depth-2');
                }
                else {
                    $('.site-header').addClass('hero-header').removeClass('z-depth-2');
                }
            });
        }

        $(".fancy_title").lettering('words').children('span').lettering();

        $('.nav-close, #page-overlay').click(function(){
            $('header').removeClass("side-menu-open");
            $('html').removeClass("noscroll");
        });

        $('.header-toggle').click(function(){
            $('header').addClass("side-menu-open");
            $('html').addClass("noscroll");
        });

        $('.menu-item-has-children > a').click(function(){
            $(this).parent().toggleClass("submenu-open");
        });

        $(function() {
            $('.lazy').lazy();
        });

        $(".entry-content-asset").fitVids();

        if ($.isFunction($.fn.schedule) && $.isFunction($.fn.tcodeslick)) {
            $('.event-schedule').schedule({
                showLocations: true,
                keepAccordionsOpen: false,
                openFirstAccordion: false,
            });

            $('#days-carousel').tcodeslick({
                slidesToShow: 7,
                slidesToScroll: 7,
                infinite: false,
                prevArrow: '<a href="#" class="slick-prev"></a>',
                nextArrow: '<a href="#" class="slick-next"></a>',
                speed: 800,
                easing: 'swing',
            });
        }

    },
};