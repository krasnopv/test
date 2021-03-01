<?php
/*
Plugin Name: Real Estate
Plugin URI: http://realestate.com.zu
Description: Real estate plugin.
Version: 1.0
Author: Vasyl
Author URI: http://krasnopevtsev.com
*/

function realestate_post_type() {
    register_post_type('real_estate',
        array(
            'labels'      => array(
                'name'          => __('Объекты недвижимости', 'textdomain'),
                'singular_name' => __('Объект недвижимости', 'textdomain'),
            ),
                'public'      => true,
                'has_archive' => true,
        )
    );
}
add_action('init', 'realestate_post_type');

function register_district_taxonomy() {
     $labels = array(
         'name'              => _x( 'Районы', 'taxonomy general name' ),
         'singular_name'     => _x( 'Район', 'taxonomy singular name' ),
         'search_items'      => __( 'Искать Районы' ),
         'all_items'         => __( 'Все Районы' ),
         'parent_item'       => __( 'Родительские Районы' ),
         'parent_item_colon' => __( 'Родительский Район:' ),
         'edit_item'         => __( 'Изменить Район' ),
         'update_item'       => __( 'Обновить Район' ),
         'add_new_item'      => __( 'Добавить Район' ),
         'new_item_name'     => __( 'Новое имя Района' ),
         'menu_name'         => __( 'Район' ),
     );
     $args   = array(
         'hierarchical'      => true, // make it hierarchical (like categories)
         'labels'            => $labels,
         'show_ui'           => true,
         'show_admin_column' => true,
         'query_var'         => true,
         'rewrite'           => [ 'slug' => 'district' ],
     );
     register_taxonomy( 'district', [ 'real_estate' ], $args );
}
add_action( 'init', 'register_district_taxonomy' );

function object_posts(){
 
    $args = array(
        'post_type'      => 'real_estate',
        'posts_per_page' => '10',
        'publish_status' => 'published',
    );
 
    $query = new WP_Query($args);
 
    if($query->have_posts()) :
 
        while($query->have_posts()) :
 
            $query->the_post() ;
                     
            $fields = get_fields();

            // print_r($fields);

            $result .= '<div class="card col-4">';
            $result .= '    <img src="' . $fields['image_building']['url'] . '" class="card-img-top" alt="...">';
            $result .= '    <div class="card-body">';
            $result .= '        <h5 class="card-title">' . $fields['house'] . '</h5>';
            $result .= '        <p class="card-text">' . get_the_content() . '</p>';
            $result .= '        <a href="' . get_permalink() . '" class="btn btn-primary">Подробнее</a>';
            $result .= '    </div>';
            $result .= '</div>';
 
        endwhile;
 
        wp_reset_postdata();
 
    endif;
 
    return $result;
}
 
add_shortcode( 'objects-list', 'object_posts' );

    
function objects_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Objects widget', 'objects' ),
        'id' => 'objects_widget',
        'before_widget' => '<div>',
        'after_widget' => '</div>',
        'before_title' => '<h1>',
        'after_title' => '</h1>',
    ) );
}
add_action( 'widgets_init', 'objects_widgets_init' );

?>