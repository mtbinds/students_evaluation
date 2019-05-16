<?php
/**
 * The template part for displaying gallery post
 *
 * @package VW Education Lite
 * @subpackage vw-education-lite
 * @since VW Education Lite 1.0
 */
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="services-box">
    <div class="service-image">
      <?php
        if ( ! is_single() ) {

          // If not a single post, highlight the gallery.
          if ( get_post_gallery() ) {
            echo '<div class="entry-gallery">';
              echo ( get_post_gallery() );
            echo '</div>';
          };

        };
      ?>
    </div>
    <div class="service-text">
      <h3><?php the_title(); ?></h3>
      <p><?php $excerpt = get_the_excerpt(); echo esc_html( vw_education_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('vw_education_lite_excerpt_number','30')))); ?></p>
      <div class="read-btn">
        <a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Read More','vw-education-lite'); ?>"><?php esc_html_e('Read More','vw-education-lite'); ?></a>  
      </div>  
    </div>
  </div>
  <div class="clearfix"></div>
</div>