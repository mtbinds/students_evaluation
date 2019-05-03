<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package VW Education Lite
 */

get_header(); ?>

<div id="content-vw">
    <div class="container">
        <div class="page-content">
            <h1><?php printf( '<strong>%s</strong> %s', esc_html__( '404', 'vw-education-lite' ), esc_html__( 'Not Found', 'vw-education-lite' ) ) ?></h1>
            <p class="text-404"><?php esc_html_e( 'Looks like you have taken a wrong turn&hellip', 'vw-education-lite' ); ?></p>
            <p class="text-404"><?php esc_html_e( 'Dont worry&hellip it happens to the best of us.', 'vw-education-lite' ); ?></p>
            <div class="read-moresec">
                <a href="<?php echo esc_url( home_url() ); ?>" class="button hvr-sweep-to-right"><?php esc_html_e( 'Back to Home Page', 'vw-education-lite' ); ?></a>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<?php get_footer(); ?>