<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package VW Education Lite
 */
?>
        <div class="footer-widgets">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-3">
                        <?php dynamic_sidebar('footer-1');?>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <?php dynamic_sidebar('footer-2');?>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <?php dynamic_sidebar('footer-3');?>
                    </div>
                    <div class="col-md-3 col-sm-3">
                        <?php dynamic_sidebar('footer-4');?>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrapper">
            <div class="copyright">
                <p><?php echo esc_html(get_theme_mod('vw_education_lite_footer_copy',__('Professional WordPress Themes By','vw-education-lite'))); ?> <?php vw_education_lite_credit(); ?></p>
            </div>
            <div class="clear"></div>  
        </div>
<?php wp_footer(); ?>
</body>
</html>