<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Educenter
 */

get_header(); ?>

<div class="content clearfix">
	<?php
		/**
		 * Breadcrumb 
		 *
	     * @since 1.0.0
	    */
		do_action( 'educenter_add_breadcrumb', 10 );
	?>

	<div class="container">

		<section class="error-404 not-found">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					
					<div class="error-inner">
						<h1><?php esc_html_e( '404', 'educenter' ); ?><span><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'educenter' ); ?></span></h1>

						<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'educenter' ); ?></p>
						<a class="btn primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><i class="fa fa-long-arrow-left"></i><?php esc_html_e( 'Go to home', 'educenter' ); ?></a>
					</div>
					
				</main><!-- #main -->
			</div><!-- #primary -->
		</section>

	</div>

</div>

<?php get_footer();