<?php
/**
 * Template Name:Page with Left Sidebar
 */

get_header(); ?>

<?php do_action( 'vw_education_lite_pageleft_top' ); ?>

<div class="container">
    <div class="middle-align row">       
		<div id="sidebar" class="col-md-4">
			<?php dynamic_sidebar('sidebar-2'); ?>
            <div class="clearfix"></div>  
		</div>		 
		<div class="col-md-8" id="content-vw" >
			<?php while ( have_posts() ) : the_post(); ?>
                <h1><?php the_title(); ?></h1>
                <?php the_content();?>
            <?php endwhile; // end of the loop. ?>
            <?php
                //If comments are open or we have at least one comment, load up the comment template
                if ( comments_open() || '0' != get_comments_number() )
                    comments_template();
            ?>
        </div>
        <div class="clearfix"></div>    
    </div>
</div>

<?php do_action( 'vw_education_lite_pageleft_bottom' ); ?>

<?php get_footer(); ?>