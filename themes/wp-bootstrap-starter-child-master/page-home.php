<?php
/**
* Template Name: Objects
*
* @package WordPress
* @subpackage real_estate
* @since Real Estate 1.0
*/

get_header(); ?>

	<section id="primary" class="content-area col-sm-12 col-lg-8">
		<div id="main" class="site-main" role="main">
            <div class="row">
            <?php 
                if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('header-sidebar') ) : 
                    echo do_shortcode( '[objects-list]' );
                endif;
            ?>
            </div>

            <div class="row">

			<?php $posts = get_posts( array(
                'numberposts' => 5,
                'category'    => 0,
                'orderby'     => 'date',
                'order'       => 'DESC',
                'include'     => array(),
                'exclude'     => array(),
                'meta_key'    => '',
                'meta_value'  =>'',
                'post_type'   => 'post',
                'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
                ) );
                
                foreach( $posts as $post ){
                    setup_postdata($post);
                    get_template_part( 'template-parts/content', 'search' );
                }
                
                wp_reset_postdata(); // сброс
            ?>
            </div>
		</div><!-- #main -->
	</section><!-- #primary -->

<?php
get_sidebar();
get_footer();