import fitty from 'fitty/dist/fitty.min.js';

export default {

    init() {
        document.documentElement.classList.add('js');

        $(".fancy_title").lettering('words').children('span').lettering();
    },
    finalize() {
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

        $(".sidebar .widget_media_video").fitVids();

        $('ul.tabs li').click(function(){
            var tab_id = $(this).attr('data-tab');

            $('ul.tabs li').removeClass('current');
            $('.dag-content').removeClass('current');

            $(this).addClass('current');
            $("#"+tab_id).addClass('current');
        })

        fitty('.font-fit');
        fitty('.page-template.template-lustrumevenement .fancy_title', {
            maxSize: 250,
        });

        fitty('body:not(.page-template) .fancy_title', {
            maxSize: 160,
        });

        fitty('.page-template.template-lustrumsubevenement .fancy_title', {
            maxSize: 160,
        });

        (function(h,o,t,j,a,r){
            h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
            h._hjSettings={hjid:865384,hjsv:6};
            a=o.getElementsByTagName('head')[0];
            r=o.createElement('script');r.async=1;
            r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
            a.appendChild(r);
        })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');

        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth',
                    block: 'center',
                });
            });
        });
    },
};