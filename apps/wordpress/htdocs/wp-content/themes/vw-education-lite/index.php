<?php
/**
 * The template for displaying home page.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * @package  VW Education Lite
 */

get_header(); ?>
 
<div class="container">
  <?php
    $left_right = get_theme_mod( 'vw_education_lite_theme_options','One Column');
    if($left_right == 'Left Sidebar'){ ?>
    <div class="row">
      <div class="col-md-4"><?php get_sidebar(); ?></div>
      <div id="blog_education" class="col-md-8">
                
        <?php if ( have_posts() ) :
          /* Start the Loop */
            
            while ( have_posts() ) : the_post();

              get_template_part( 'template-parts/content', get_post_format() ); 
            
            endwhile;
            wp_reset_postdata();
            else :

              get_template_part( 'no-results' );

            endif; 
        ?>
        <div class="navigation">
          <?php
              // Previous/next page navigation.
              the_posts_pagination( array(
                  'prev_text'          => __( 'Previous page', 'vw-education-lite' ),
                  'next_text'          => __( 'Next page', 'vw-education-lite' ),
                  'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'vw-education-lite' ) . ' </span>',
              ) );
          ?>
            <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
  <?php }else if($left_right == 'Right Sidebar'){ ?>
    <div class="row">
      <div id="blog_education" class="col-md-8">
                  
        <?php if ( have_posts() ) :
          /* Start the Loop */
            
            while ( have_posts() ) : the_post();

              get_template_part( 'template-parts/content', get_post_format() ); 
            
            endwhile;
            wp_reset_postdata();
            else :

              get_template_part( 'no-results' ); 

            endif; 
        ?>
        <div class="navigation">
          <?php
              // Previous/next page navigation.
              the_posts_pagination( array(
                  'prev_text'          => __( 'Previous page', 'vw-education-lite' ),
                  'next_text'          => __( 'Next page', 'vw-education-lite' ),
                  'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'vw-education-lite' ) . ' </span>',
              ) );
          ?>
            <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-4"><?php get_sidebar(); ?></div>
    </div>
  <?php }else if($left_right == 'One Column'){ ?>
    <div id="blog_education">
                
      <?php if ( have_posts() ) :
        /* Start the Loop */
          
          while ( have_posts() ) : the_post();

            get_template_part( 'template-parts/content', get_post_format() ); 
          
          endwhile;
          wp_reset_postdata();
          else :

            get_template_part( 'no-results' );

          endif; 
      ?>
      <div class="navigation">
        <?php
            // Previous/next page navigation.
            the_posts_pagination( array(
                'prev_text'          => __( 'Previous page', 'vw-education-lite' ),
                'next_text'          => __( 'Next page', 'vw-education-lite' ),
                'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'vw-education-lite' ) . ' </span>',
            ) );
        ?>
          <div class="clearfix"></div>
      </div>
    </div>
  <?php }else if($left_right == 'Three Columns'){ ?>
    <div class="row">
      <div id="sidebar" class="col-md-3"><?php dynamic_sidebar('sidebar-1');?></div>
      <div id="blog_education" class="col-md-6">
                  
        <?php if ( have_posts() ) :
          /* Start the Loop */
            
            while ( have_posts() ) : the_post();

              get_template_part( 'template-parts/content', get_post_format() ); 
            
            endwhile;
            wp_reset_postdata();
            else :

              get_template_part( 'no-results' ); 

            endif; 
        ?>
        <div class="navigation">
          <?php
              // Previous/next page navigation.
              the_posts_pagination( array(
                  'prev_text'          => __( 'Previous page', 'vw-education-lite' ),
                  'next_text'          => __( 'Next page', 'vw-education-lite' ),
                  'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'vw-education-lite' ) . ' </span>',
              ) );
          ?>
            <div class="clearfix"></div>
        </div>
      </div>
      <div id="sidebar" class="col-md-3"><?php dynamic_sidebar('sidebar-2');?></div>
    </div>
  <?php }else if($left_right == 'Four Columns'){ ?>
    <div class="row">
      <div id="sidebar" class="col-md-3"><?php dynamic_sidebar('sidebar-1');?></div>
      <div id="blog_education" class="col-md-3">
                  
        <?php if ( have_posts() ) :
          /* Start the Loop */
            
            while ( have_posts() ) : the_post();

              get_template_part( 'template-parts/content', get_post_format() ); 
            
            endwhile;
            wp_reset_postdata();
            else :

              get_template_part( 'no-results' ); 

            endif; 
        ?>
        <div class="navigation">
          <?php
              // Previous/next page navigation.
              the_posts_pagination( array(
                  'prev_text'          => __( 'Previous page', 'vw-education-lite' ),
                  'next_text'          => __( 'Next page', 'vw-education-lite' ),
                  'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'vw-education-lite' ) . ' </span>',
              ) );
          ?>
            <div class="clearfix"></div>
        </div>
      </div>
      <div id="sidebar" class="col-md-3"><?php dynamic_sidebar('sidebar-2');?></div>
      <div id="sidebar" class="col-md-3"><?php dynamic_sidebar('sidebar-3');?></div>
    </div>
  <?php }else if($left_right == 'Grid Layout'){ ?>
    <div class="row">
      <div id="blog_education_ind_grid" class="col-md-9">
        <div class="row">
          <?php if ( have_posts() ) :
            /* Start the Loop */
              
              while ( have_posts() ) : the_post();

                get_template_part( 'template-parts/grid-layout' ); 
              
              endwhile;
              wp_reset_postdata();
              else :

                get_template_part( 'no-results' );

              endif; 
          ?>
        </div>
        <div class="navigation">
          <?php
              // Previous/next page navigation.
              the_posts_pagination( array(
                  'prev_text'          => __( 'Previous page', 'vw-education-lite' ),
                  'next_text'          => __( 'Next page', 'vw-education-lite' ),
                  'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'vw-education-lite' ) . ' </span>',
              ) );
          ?>
          <div class="clearfix"></div>
        </div>
      </div>
      <div class="col-md-3"><?php get_sidebar(); ?></div>
    </div>
  <?php } ?>
</div>
<div class="clearfix"></div>

<?php get_footer(); ?>