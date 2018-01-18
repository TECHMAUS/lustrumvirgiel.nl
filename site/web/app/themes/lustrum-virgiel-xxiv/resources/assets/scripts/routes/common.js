export default {
    init() {
        // JavaScript to be fired on all pages
    },
    finalize() {
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
    },
};