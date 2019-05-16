<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package VW Education Lite
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta name="viewport" content="width=device-width">
  <link rel="profile" href="<?php echo esc_url( __( 'http://gmpg.org/xfn/11', 'vw-education-lite' ) ); ?>">
  
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
   
<div class="top-bar">
	<div class="container">
    <div class="row">
      <div class="col-lg-3 col-md-3 phone">
        <?php if(get_theme_mod('vw_education_lite_cont_phone','') != '') { ?>
          <i class="fas fa-mobile-alt"></i><span><?php echo esc_html( get_theme_mod('vw_education_lite_cont_phone','') ); ?></span>
        <?php } ?>
      </div>		
  		<div class="col-lg-3 col-md-3 phone">
        <?php if(get_theme_mod('vw_education_lite_cont_email','') != '') { ?>
          <i class="far fa-envelope"></i><a href="mailto:<?php echo esc_attr(get_theme_mod('vw_education_lite_cont_email','')); ?>"><span><?php echo esc_html(get_theme_mod('vw_education_lite_cont_email','')); ?></a></span>
        <?php } ?>
      </div>
      <div class="col-lg-6 col-md-6">
        <?php dynamic_sidebar( 'social-icon' ); ?>
      </div>
    </div>
  </div>
</div><!-- top-bar -->
  <div class="toggle"><a class="toggleMenu" href="#"><?php esc_html_e('Menu','vw-education-lite'); ?></a></div>
  <div class="header">
    <div class="row m-0">
      <div class="col-lg-1 col-md-1 menu-bar-left"></div>
      <div class="logo text-center col-lg-2 col-md-2">
        <div class="logo_box">
          <?php if( has_custom_logo() ){ vw_education_lite_the_custom_logo();
            }else{ ?>
            <h1 class="text-center"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
            <?php $description = get_bloginfo( 'description', 'display' );
            if ( $description || is_customize_preview() ) : ?>
              <p class="site-description"><?php echo esc_html($description); ?></p>
          <?php endif; } ?>
        </div>
      </div>
      <div class="col-lg-9 col-md-9 p-0 ">
        <div class="nav">
          <div class="container">
            <?php wp_nav_menu( array('theme_location'  => 'primary') ); ?>
            <div class="clearfix"></div>
          </div>      
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>

  <?php if ( is_singular() && has_post_thumbnail() ) : ?>
    <?php
      $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'vw-education-lite-post-image-cover' );
      $post_image = $thumb['0'];
    ?>
    <div class="header-image bg-image" style="background-image: url(<?php echo esc_url( $post_image ); ?>)">
      <?php the_post_thumbnail( 'vw-education-lite-post-image' ); ?>
    </div>

  <?php elseif ( get_header_image() ) : ?>
  <div class="header-image bg-image" style="background-image: url(<?php header_image(); ?>)">
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
      <img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
    </a>
  </div>
  <?php endif; // End header image check. ?>