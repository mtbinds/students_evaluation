/**
 * Educenter Theme Custom Js
*/
jQuery(document).ready( function($){


    /**
     * Header Sticky sidebar
    */
    var headersticky = educenter_ajax_script.headersticky;

    
    if( headersticky == 1 ){
        try{
            $(".bottom-header").sticky({ topSpacing: 0 });
        }
        catch(e){
            //console.log( e );
        }
    }

    /**
     * Widget Sticky sidebar
    */
    var sidebarstick = educenter_ajax_script.sidebarstick;

    if( sidebarstick == 1 ){
        try{
            $('.content-area').theiaStickySidebar({
                additionalMarginTop: 30
            });

            $('.widget-area').theiaStickySidebar({
                additionalMarginTop: 30
            });
        }
        catch(e){
            //console.log( e );
        }
    }
    
    /**
     * Search Popup
    */
    $('.search').click(function() {
        $('.ed-pop-up').toggleClass('active');
    });

    $('.search-overlay').click(function() {
        $('.ed-pop-up').removeClass('active');
    });


    /**
     * Main Banner Slider
    */
    $(".slider-layout-2 .ed-slide").lightSlider({
        item: 1,
        slideMove: 1,
        slideMargin: 0,
        loop: true,
        auto: true,
        pager: false,
        controls: true,
        slideEndAnimation:true,
        speed:1200,
        pause:3000
    });

    /**
     * Features Services Area
    */
    $(".ed-service-slide").lightSlider({
        item: 3,
        autoWidth: false,
        slideMove: 1,
        slideMargin: 20,
        loop: true,
        controls: false,
        adaptiveHeight: true,
        pager: true,
        onSliderLoad: function() {
            $('.ed-service-slide').removeClass('cS-hidden');
        },
        responsive: [{
                breakpoint: 1100,
                settings: {
                    item: 2,
                    slideMove: 1,
                    slideMargin: 20,
                }
            },
            {
                breakpoint: 640,
                settings: {
                    item: 1,
                    slideMove: 1,
                    slideMargin: 0,
                }
            }
        ]
    });


    /**
     * Counter
    */
    $('.counter').counterUp({
        delay: 10,
        time: 1000,
        offset: 70,
        beginAt: 100,
        formatter: function (n) {
          return n.replace(/,/g, '.');
        }
    });

    /**
     * Latest News Blog Area
    */
    $(".ed-blog-slider").lightSlider({
        item: 3,
        autoWidth: false,
        slideMove: 1,
        slideMargin: 10,
        loop: true,
        controls: true,
        adaptiveHeight: true,
        pager: true,
        onSliderLoad: function() {
            $('.ed-blog-slider').removeClass('cS-hidden');
        },
        responsive: [{
                breakpoint: 870,
                settings: {
                    item: 2,
                    slideMove: 1,
                    slideMargin: 10,
                }
            },
            {
                breakpoint: 570,
                settings: {
                    item: 1,
                    slideMove: 1,
                    slideMargin: 2,
                }
            }
        ]
    });


    /**
     * Our Team Member
    */
    $(".ed-team-wrapper").lightSlider({
        item: 3,
        autoWidth: false,
        slideMove: 1,
        slideMargin: 10,
        loop: true,
        controls: false,
        adaptiveHeight: false,
        pager: true,
        onSliderLoad: function() {
            $('.ed-team-wrapper').removeClass('cS-hidden');
        },
        responsive: [{
                breakpoint: 870,
                settings: {
                    item: 2,
                    slideMove: 1,
                    slideMargin: 10,
                }
            },
            {
                breakpoint: 570,
                settings: {
                    item: 1,
                    slideMove: 1,
                    slideMargin: 2,
                }
            }
        ]
    });


    /**
     * Our Testimonials
    */
    $(".ed-testimonial-wrap").lightSlider({
        item: 3,
        autoWidth: false,
        slideMove: 1,
        slideMargin: 30,
        loop: true,
        controls: false,
        adaptiveHeight: false,
        pager: true,
        onSliderLoad: function() {
            $('.ed-testimonial-wrap').removeClass('cS-hidden');
        },
        responsive: [{
                breakpoint: 870,
                settings: {
                    item: 2,
                    slideMove: 1,
                    slideMargin: 20,
                }
            },
            {
                breakpoint: 570,
                settings: {
                    item: 1,
                    slideMove: 1,
                    slideMargin: 2,
                }
            }
        ]
    });


    /**
     * Gallery Light Box
    */
    $("a[rel^='edugallery']").prettyPhoto({
        theme: 'light_rounded',
        slideshow: 5000,
        autoplay_slideshow: false,
        keyboard_shortcuts: true,
        deeplinking : false,
        default_width: 500,
        default_height: 344,
    });


     /**
     * Superfish Nav
    */
    jQuery('ul.nav').superfish({
        delay: 100,
        speed:'fast',
        speedOut:'fast',
    });


    /**
     * Toggle nav
    */
    $('.header-nav-search .toggle-button').on('click', function() {
        $('body').addClass('menu-active');
    });
    $('.close-icon').on('click', function() {
        $('body').removeClass('menu-active');
    });

    /**
     * Scroll To Top
    */
    $("#footer").on('click', '.goToTop', function(e){
        e.preventDefault();
        $('html,body').animate({
            scrollTop: 0,
        },'slow');
    });
    
    // Show/Hide Button on Window Scroll event.
    $(window).on('scroll', function(){
        var fromTop = $(this).scrollTop();
        var display = 'none';
        if(fromTop > 650){
            display = 'block';
        }
        $('#scrollTop').css({'display': display});
    });

});