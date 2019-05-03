<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package VW Education Lite
 */

get_header(); ?>

<div class="container">
    <?php
      $left_right = get_theme_mod( 'vw_education_lite_theme_options','Full Width');
      if($left_right == 'Left Sidebar'){ ?>
        <div class="row">
            <div class="col-md-4"><?php get_sidebar(); ?></div>
            <div id="blog_education" class="col-md-8">
                <div class="container">
                    <h1 class="entry-title"><?php printf( esc_html('Results For: %s', 'vw-education-lite' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                </div>
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
                <div class="container">
                    <h1 class="entry-title"><?php printf( esc_html('Results For: %s', 'vw-education-lite' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                </div>
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
    <?php }else if($left_right == 'Three Columns'){ ?>
        <div class="row">
            <div id="sidebar" class="col-md-3"><?php dynamic_sidebar('sidebar-1');?></div>
            <div id="blog_education" class="col-md-6">
                <div class="container">
                    <h1 class="entry-title"><?php printf( esc_html('Results For: %s', 'vw-education-lite' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                </div>
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
                <div class="container">
                   <h1 class="entry-title"><?php printf( esc_html('Results For: %s', 'vw-education-lite' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                </div>
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
    <?php }else if($left_right == 'One Columns'){ ?>
        <div id="blog_education">
            <div class="container">
               <h1 class="entry-title"><?php printf( esc_html('Results For: %s', 'vw-education-lite' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
            </div>
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
    <?php }else if($left_right == 'Grid Layout'){ ?>
        <div class="row">
            <div id="blog_education_grid" class="col-md-9">
                <div class="container">
                    <h1 class="entry-title"><?php printf( esc_html('Results For: %s', 'vw-education-lite' ), '<span>' . esc_html( get_search_query() ) . '</span>' ); ?></h1>
                </div>
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

<?php get_footer(); ?>