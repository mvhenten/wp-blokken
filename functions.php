<?php
/**
 * Blokken functions and definitions.
 *
 * @package Blokken
 * @since Blokken 1.0
 */


add_action( 'init', 'blokken_create_post_type' );

function blokken_create_post_type() {
	register_post_type( 'blokken_quote',

		array(
			'labels' => array(
				'name' => __( 'Quotes' ),
				'singular_name' => __( 'Quote' )
			),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title'),
            'taxonomies' => array('post_tag')
		)
	);
}

function blokken_add_custom_box() {
   $screens = array( 'blokken_quote' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'blokken_quote_link',
            __( 'Quote link', 'blokken_textdomain' ),
            'blokken_quote_field_html',
            $screen
        );
    }
}

add_action( 'add_meta_boxes', 'blokken_add_custom_box' );

function blokken_quote_field_html( $post ) {

  /*
   * Use get_post_meta to retrieve an existing value
   * from the database and use the value for the form.
   */
  $value = get_post_meta( $post->ID, '_blokken_quote_link', true );

  echo '<label for="blokken_quote_field">';
       _e("Edit the url this quote refers to:", 'blokken_textdomain' );
  echo '</label><br/>';
  echo '<input size="75" placeholder="http://example.com" type="text" id="blokken_quote_field" name="blokken_quote_field" value="' . esc_attr( $value ) . '" size="25" />';

}

function blokken_save_postdata( $post_id ) {
    if( isset( $_POST['blokken_quote_field'] ) ){
        // IMPORTANT! Sanitize user input.
        $mydata = sanitize_text_field( $_POST['blokken_quote_field'] );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_blokken_quote_link', $mydata );
    }
}

add_action( 'save_post', 'blokken_save_postdata' );


function blokken_add_quotes_to_query( $query ) {
	if ( $query->is_main_query() ){
		$query->set( 'post_type', array( 'post', 'blokken_quote' ) );
	}

	return $query;
}

add_action( 'pre_get_posts', 'blokken_add_quotes_to_query' );

function blokken_setup() {
	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menu( 'primary', __( 'Navigation Menu', 'blokken' ) );


	$args = array(
		'default-image'          => '',

		// Set height and width, with a maximum value for the width.
		'height'                 => 100,
		'width'                  => 940,
		'max-width'              => 940,

		// Support flexible height and width.
		'flex-height'            => true,
		'flex-width'             => true,

		// Random image rotation off by default.
		'random-default'         => false,
	);

	add_theme_support( 'custom-header', $args );

	add_theme_support( 'custom-background', array(
		'default-color' => 'e6e6e6',
	) );

	/*
	 * This theme uses a custom image size for featured images, displayed on
	 * "standard" posts and pages.
	 */
	add_theme_support( 'post-thumbnails' );

	set_post_thumbnail_size( 604, 270, true );

	// This theme uses its own gallery styles.
	add_filter( 'use_default_gallery_style', '__return_false' );
}

add_action( 'after_setup_theme', 'blokken_setup' );


/**
 * Enqueues scripts and styles for front end.
 *
 * @since Blokken 1.0
 *
 * @return void
 */
function blokken_scripts_styles() {

	wp_enqueue_style( 'blokken-style', get_stylesheet_uri(), array(), '2013-07-18' );
}

add_action( 'wp_enqueue_scripts', 'blokken_scripts_styles' );

/**
 * Registers two widget areas.
 *
 * @since Blokken 1.0
 *
 * @return void
 */
function blokken_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Main Widget Area', 'blokken' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Appears in the footer section of the site.', 'blokken' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Secondary Widget Area', 'blokken' ),
		'id'            => 'sidebar-2',
		'description'   => __( 'Appears on posts and pages in the sidebar.', 'blokken' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}
add_action( 'widgets_init', 'blokken_widgets_init' );

$args = array(
	'flex-width'    => true,
	'flex-height'    => true,
    'width'         => 940,
	'height'        => 100,
	'uploads'       => true,
	'default-image' => get_template_directory_uri() . '/header.jpg',
);
add_theme_support( 'custom-header', $args );


/**
 * Add postMessage support for site title and description for the Customizer.
 *
 * @since Blokken 1.0
 *
 * @param WP_Customize_Manager $wp_customize Customizer object.
 * @return void
 */
//function blokken_customize_register( $wp_customize ) {
//	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
//	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
//	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
//}
//add_action( 'customize_register', 'blokken_customize_register' );

///**
// * Binds JavaScript handlers to make Customizer preview reload changes
// * asynchronously.
// *
// * @since Blokken 1.0
// */
//function blokken_customize_preview_js() {
//	wp_enqueue_script( 'blokken-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
//}
//add_action( 'customize_preview_init', 'blokken_customize_preview_js' );
