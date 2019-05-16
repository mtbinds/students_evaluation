<?php
/**
 * The template part for displaying video post
 *
 * @package VW Education Lite
 * @subpackage vw-education-lite
 * @since VW Education Lite 1.0
 */
?>

<?php
  $content = apply_filters( 'the_content', get_the_content() );
  $video = false;

  // Only get video from the content if a playlist isn't present.
  if ( false === strpos( $content, 'wp-playlist-script' ) ) {
    $video = get_media_embedded_in_content( $content, array( 'video', 'object', 'embed', 'iframe' ) );
  }
?>

<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="services-box">
    <div class="service-image">
      <?php
        if ( ! is_single() ) {

          // If not a single post, highlight the video file.
          if ( ! empty( $video ) ) {
            foreach ( $video as $video_html ) {
              echo '<div class="entry-video">';
                echo $video_html;
              echo '</div>';
            }
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