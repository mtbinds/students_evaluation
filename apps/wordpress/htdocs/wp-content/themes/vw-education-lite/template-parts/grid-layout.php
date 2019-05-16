<?php
/**
 * The template part for displaying grid layout
 *
 * @package VW Education Lite
 * @subpackage vw-education-lite
 * @since VW Education Lite 1.0
 */
?>
<div class="col-lg-4 col-md-4">
	<div id="post-<?php the_ID(); ?>" <?php post_class('inner-service'); ?>>	
		<div class="services-box">
	    	<div class="service-image">
	          	<?php 
	            	if(has_post_thumbnail()) { 
	              		the_post_thumbnail(); 
	            	}
	            ?>
	      	</div>
	    	<div class="service-text">
	        	<h3><?php the_title(); ?></h3>	        	
				<p><?php the_excerpt();?></p>
	        	<div class="read-btn">
			      	<a href="<?php the_permalink(); ?>" title="<?php esc_attr_e('Read More','vw-education-lite'); ?>"><?php esc_html_e('Read More','vw-education-lite'); ?></a>  
			    </div>   
	      	</div>
	    </div>
    </div>    
</div>