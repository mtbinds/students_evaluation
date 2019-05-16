<?php
/**
 * The template part for displaying content
 *
 * @package VW Education Lite
 * @subpackage vw-education-lite
 * @since VW Education Lite 1.0
 */
?>
<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>
  <div class="services-box">
    <div class="service-text">
      <h3><?php the_title(); ?></h3>
      <div class="post-info">
        <?php if(get_theme_mod('vw_education_lite_toggle_postdate',true)==1){ ?>
          <span class="entry-date"><i class="fas fa-calendar-alt"></i><?php echo get_the_date(); ?></span>
        <?php } ?>
        <?php if(get_theme_mod('vw_education_lite_toggle_author',true)==1){ ?>
          <i class="far fa-user"></i><span class="entry-author"><a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' )) ); ?>"><?php the_author(); ?></a></span>
        <?php } ?>
        <?php if(get_theme_mod('vw_education_lite_toggle_comments',true)==1){ ?>
      <i class="fas fa-comments"></i><span class="entry-comments"><?php comments_number( __('0 Comments','vw-education-lite'), __('0 Comments','vw-education-lite'), __('% Comments','vw-education-lite')); ?></span>
    <?php } ?>
      </div>
      <p><?php $excerpt = get_the_excerpt(); echo esc_html( vw_education_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('vw_education_lite_excerpt_number','30')))); ?></p>
      <div class="read-btn">
      	<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Read More','vw-education-lite'); ?>"><?php esc_html_e('Read More','vw-education-lite'); ?></a>  
      </div>   
    </div>
  </div>
  <div class="clearfix"></div>
</div>