<?php
/**
 * Dynamic css
*/
if ( ! function_exists( 'educenter_dynamic_css' ) ) {

    function educenter_dynamic_css() {
        
        $primary_color = get_theme_mod('educenter_primary_color', '#004A8D');
        
        $rgba = educenter_hex2rgba($primary_color, 0.92);

        $kingcabs_colors = '';


    /**
     *  Background Color
    */         
        $kingcabs_colors .= "
        
        .general-header .top-header,
        .ed-slider .ed-slide div .ed-slider-info a.slider-button,
        .ed-slider.slider-layout-2 .lSAction>a,

        .general-header .main-navigation>ul>li:before, 
        .general-header .main-navigation>ul>li.current_page_item:before,
        .general-header .main-navigation ul ul.sub-menu,

        .ed-pop-up .search-form input[type='submit'],

        .ed-services.layout-3 .ed-service-slide .col:before,

        .ed-about-us .ed-about-content .listing .icon-holder,

        .ed-cta.layout-1 .ed-cta-holder a.ed-button,

        .ed-cta.layout-1 .ed-cta-holder h2:before,

        h2.section-header:after,
        .ed-services.layout-2 .ed-service-left .ed-col-holder .col .icon-holder,

        .ed-button,

        section.ed-gallery .ed-gallery-wrapper .ed-gallery-item .ed-gallery-button,

        .ed-team-member .ed-team-col .ed-inner-wrap .ed-text-holder h3.ed-team-title:before,

        .ed-testimonials .lSPager.lSpg li a,
        .ed-blog .ed-blog-wrap .lSPager.lSpg li a,

        .ed-blog .ed-blog-wrap .ed-blog-col .ed-title h3:before,

        .ed-footer .bottom-footer,

        .goToTop,

        .nav-previous a, 
        .nav-next a,
        .page-numbers,

        #comments form input[type='submit'],

        .widget-ed-title h2:before,

        .widget_search .search-submit, 
        .widget_product_search input[type='submit'],

        .woocommerce #respond input#submit, 
        .woocommerce a.button, 
        .woocommerce button.button, 
        .woocommerce input.button,

        .woocommerce nav.woocommerce-pagination ul li a:focus, 
        .woocommerce nav.woocommerce-pagination ul li a:hover, 
        .woocommerce nav.woocommerce-pagination ul li span.current,

        .woocommerce #respond input#submit.alt, 
        .woocommerce a.button.alt, 
        .woocommerce button.button.alt, 
        .woocommerce input.button.alt,

        .wpcf7 input[type='submit'], 
        .wpcf7 input[type='button']{

            background-color: $primary_color;

        }\n";


        $kingcabs_colors .= "
        .woocommerce div.product .woocommerce-tabs ul.tabs li:hover, 
        .woocommerce div.product .woocommerce-tabs ul.tabs li.active{

            background-color: $primary_color !important;

        }\n";


         $kingcabs_colors .= "
        .ed-footer{

            background-color: $rgba;

        }\n";


    /**
     *  Color
    */
        $kingcabs_colors .= "

        .ed-about-us .ed-about-content .listing .text-holder h3 a:hover,

        .ed-courses .ed-text-holder span,

        section.ed-gallery .ed-gallery-wrapper .ed-gallery-item .ed-gallery-button a i,

        .ed-blog .ed-blog-wrap .ed-blog-col .ed-category-list a,

        .ed-blog .ed-blog-wrap .ed-blog-col .ed-bottom-wrap .ed-tag a:hover, 
        .ed-blog .ed-blog-wrap .ed-blog-col .ed-bottom-wrap .ed-share-wrap a:hover,
        .ed-blog .ed-blog-wrap .ed-blog-col .ed-meta-wrap .ed-author a:hover,

        .page-numbers.current,
        .page-numbers:hover,

        .widget_archive a:hover, 
        .widget_categories a:hover, 
        .widget_recent_entries a:hover, 
        .widget_meta a:hover, 
        .widget_product_categories a:hover, 
        .widget_recent_comments a:hover,

        .woocommerce #respond input#submit:hover, 
        .woocommerce a.button:hover, 
        .woocommerce button.button:hover, 
        .woocommerce input.button:hover,
        .woocommerce ul.products li.product .price,
        .woocommerce nav.woocommerce-pagination ul li .page-numbers,

        .woocommerce #respond input#submit.alt:hover, 
        .woocommerce a.button.alt:hover, 
        .woocommerce button.button.alt:hover, 
        .woocommerce input.button.alt:hover,

        .main-navigation .close-icon:hover{

            color: $primary_color;

        }\n";

    /**
     *  Border Color
    */
        $kingcabs_colors .= "

        .ed-slider .ed-slide div .ed-slider-info a.slider-button,

        .ed-pop-up .search-form input[type='submit'],

        .ed-cta.layout-1 .ed-cta-holder a.ed-button,

        .ed-services.layout-2 .ed-col-holder .col,

        .ed-button,

        .page-numbers,
        .page-numbers:hover,

        .ed-courses.layout-2 .ed-text-holder,

        .ed-testimonials .ed-testimonial-wrap.layout-1 .ed-test-slide .ed-img-holder,
        .ed-testimonials .ed-testimonial-wrap.layout-1 .ed-test-slide .ed-text-holder,

        .goToTop,

        #comments form input[type='submit'],


        .woocommerce #respond input#submit, 
        .woocommerce a.button, 
        .woocommerce button.button, 
        .woocommerce input.button,

        .woocommerce nav.woocommerce-pagination ul li,

        .cart_totals h2, 
        .cross-sells>h2, 
        .woocommerce-billing-fields h3, 
        .woocommerce-additional-fields h3, 
        .related>h2, 
        .upsells>h2, 
        .woocommerce-shipping-fields>h3,

        .woocommerce-cart .wc-proceed-to-checkout a.checkout-button,

        .woocommerce div.product .woocommerce-tabs ul.tabs:before,

        .wpcf7 input[type='submit'], 
        .wpcf7 input[type='button']{

            border-color: $primary_color;

        }\n";


        $kingcabs_colors .= "

        .nav-next a:after{

            border-left: 11px solid $primary_color;

        }\n";

        $kingcabs_colors .= "
        .nav-previous a:after{

            border-right: 11px solid $primary_color

        }\n";

        wp_add_inline_style( 'educenter-style', $kingcabs_colors );
    }
}
add_action( 'wp_enqueue_scripts', 'educenter_dynamic_css', 99 );