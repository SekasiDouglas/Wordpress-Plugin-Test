<?php
/**
 * Plugin name: Custom Post Type About Cars 
 * Plugin URI: https://www.github.com/SekasiDouglas
 * Description: The Custom post type will be storing data about cars.
 * Author: Sekasi Douglas
 * Author URI: https://www.github.com/SekasiDouglas
 * version: 0.1.0
 * License: GPL2 or later.
 * text-domain: douglas
 */

// If this file is access directly, abort!!!
defined( 'ABSPATH' ) or die( 'Unauthorized Access' );


function douglas_register_post_type() {

	$labels = array(
		'name' => __( ‘Cars’, ‘douglas’ ),
		'singular_name' => __( 'Car', ‘douglas’ ),
		'add_new' => __( 'New Car', ‘douglas’ ),
		'add_new_item' => __( 'Add New Car', ‘douglas’ ),
		'edit_item' => __( 'Edit Car', ‘douglas’ ),
		'new_item' => __( 'New Car', ‘douglas’ ),
		'view_item' => __( 'View Cars', ‘douglas’ ),
		'search_items' => __( 'Search Cars', ‘douglas’ ),
		'not_found' =>  __( 'No Cars Found', ‘douglas’ ),
		'not_found_in_trash' => __( 'No Cars found in Trash', ‘douglas’ ),
	   );

	   $args = array(
		'labels' => $labels,
		'has_archive' => true,
		'public' => true,
		'show_in_menu' => true,
		'show_in_admin_bar' => true,
		'show_in_nav_menus' => true,
		'can_export' => true,
		'exclude_from_search' => false,
		'hierarchical' => false,
		'supports' => array(
		 'title',
		 'editor',
		 'excerpt',
		 'custom-fields',
		 'thumbnail',
		 'page-attributes'
		),
		'taxonomies' => 'category',
		'rewrite'   => array( 'slug' => 'Car' ),
		‘show_in_rest’ => true
	   );

	   register_post_type( ‘kinsta_book', $args );
}

add_action( 'admin_menu', 'douglas_register_post_type' );


add_action( 'add_meta_boxes', 'Car_meta_box_add' );
function Car_meta_box_add()
{
    add_meta_box( 'Car_meta_box_id', 'My First Meta Box', 'Car_meta_box', 'post', 'normal', 'high' );
}

function Car_meta_box( $post )
{
$values = get_post_custom( $post->ID );
$text = isset( $values['Car_meta_box_text'] ) ? esc_attr( $values['Car_meta_box_text'][0] ) : ”;
$text = isset( $values['carColor_meta_box_text'] ) ? esc_attr( $values['carColor_meta_box_text'][0] ) : ”;

    ?>
<p>
    <label for="Car_meta_box_text">Car Model</label>
    <input type="text" name="Car_meta_box_text" id="Car_meta_box_text" value="<?php echo $text; ?>" />
        </p>
     <p>
    <label for="carColor_meta_box_text">Car Color</label>
    <input type="text" name="carColor_meta_box_text" id="carColor_meta_box_text" value="<?php echo $text; ?>" />
        </p>
    <?php        
}


add_action( 'save_post', 'Car_meta_box_save' );
function Car_meta_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if our none isn't there, or we can't verify it, bail
    if( !isset( $_POST['meta_box_nonce'] ) || !wp_verify_nonce( $_POST['meta_box_nonce'], 'my_meta_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
     
    // now we can actually save the data
    $allowed = array( 
        'a' => array( // on allow a tags
            'href' => array() // and those anchors can only have href attribute
        )
    );
     
    // Make sure your data is set before trying to save it
    if( isset( $_POST['Car_meta_box_text'] ) )
        update_post_meta( $post_id, 'Car_meta_box_text', wp_kses( $_POST['Car_meta_box_text'], $allowed ) );
         
    if( isset( $_POST['carColor_meta_box_text'] ) )
        update_post_meta( $post_id, 'carColor_meta_box_text', wp_kses( $_POST['carColor_meta_box_text'], $allowed ) );
       
}



?>