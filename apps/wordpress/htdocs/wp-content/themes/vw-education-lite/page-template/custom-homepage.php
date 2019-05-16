<?php
/**
 * Template Name: Custom home page
 */

get_header(); ?>

<?php do_action( 'vw_education_lite_above_slider' ); ?>

<?php /** slider section **/ ?>

<?php if( get_theme_mod('vw_education_lite_slider_hide_show') != ''){ ?>
  <section id="slider">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"> 
      <?php $pages = array();
        for ( $count = 1; $count <= 4; $count++ ) {
          $mod = intval( get_theme_mod( 'vw_education_lite_slider_page' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $pages[] = $mod;
          }
        }
        if( !empty($pages) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $pages,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $i = 1;
      ?>     
      <div class="carousel-inner" role="listbox">
        <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
          <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
            <img src="<?php the_post_thumbnail_url('full'); ?>"/>
            <div class="carousel-caption">
              <div class="inner_carousel">
                <h2><?php the_title(); ?></h2>
                <p><?php $excerpt = get_the_excerpt(); echo esc_html( vw_education_lite_string_limit_words( $excerpt, esc_attr(get_theme_mod('vw_education_lite_slider_excerpt_number','30')))); ?></p>
                <div class="more-btn">              
                  <a href="<?php the_permalink(); ?>"><?php esc_html_e('Know More','vw-education-lite'); ?></a>
                </div>
              </div>
            </div>
          </div>
        <?php $i++; endwhile; 
        wp_reset_postdata();?>
      </div>
      <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
      endif;?>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
      </a>
    </div>  
    <div class="clearfix"></div>
  </section> 
<?php }?>

<?php do_action( 'vw_education_lite_below_slider' ); ?>

<?php if( get_theme_mod( 'vw_education_lite_sec1_title') != '' || get_theme_mod( 'vw_education_lite_courses_settings' )!= ''){ ?>
  <section id="our-courses">    
    <div class="container">
      <div class="text-center">
        <?php if( get_theme_mod('vw_education_lite_sec1_title') != ''){ ?>     
          <h3><?php echo esc_html(get_theme_mod('vw_education_lite_sec1_title','')); ?></h3>
          <img src="<?php echo esc_url(get_theme_mod('vw_education_lite_sec_border',get_template_directory_uri().'/images/title-border.png')); ?>" alt="">
        <?php }?>
      </div>
      <div class="row">
        <?php $pages = array();
        for ( $count = 0; $count <= 2; $count++ ) {
          $mod = intval( get_theme_mod( 'vw_education_lite_courses_settings' . $count ));
          if ( 'page-none-selected' != $mod ) {
            $pages[] = $mod;
          }
        }
        if( !empty($pages) ) :
          $args = array(
            'post_type' => 'page',
            'post__in' => $pages,
            'orderby' => 'post__in'
          );
          $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $count = 0;
            while ( $query->have_posts() ) : $query->the_post(); ?>
              <div class="col-lg-4 col-md-4">
                <div class="course-content">
                <div class="box-image text-center">
                  <img src="<?php the_post_thumbnail_url('full'); ?>"/>                  
                </div>
                <div class="box-content">
                  <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                </div>
                </div>
              </div>
            <?php $count++; endwhile; 
            wp_reset_postdata();?>
          <?php else : ?>
              <div class="no-postfound"></div>
          <?php endif;
        endif;?>
      </div>
      <div class="clearfix"></div>
    </div> 
  </section>
<?php }?>

<?php do_action( 'vw_education_lite_below_course_section' ); ?>

<div id="content-vw" class="container">
  <?php while ( have_posts() ) : the_post(); ?>
    <?php the_content(); ?>
  <?php endwhile; // end of the loop. ?>
</div>

<?php get_footer(); ?>