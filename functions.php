<?php
/**
 * Blokken functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development
 * and http://codex.wordpress.org/Child_Themes), you can override certain
 * functions (those wrapped in a function_exists() call) by defining them first
 * in your child theme's functions.php file. The child theme's functions.php
 * file is included before the parent theme's file, so the child theme
 * functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * see http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Blokken 1.0
 */

/**
 * Sets up the content width value based on the theme's design.
 * @see blokken_content_width() for template-specific adjustments.
 */
if ( ! isset( $content_width ) )
	$content_width = 604;

/**
 * Adds support for a custom header image.
 */
//require get_template_directory() . '/inc/custom-header.php';


/**
 * Sets up theme defaults and registers the various WordPress features that
 * Blokken supports.
 *
 * @uses load_theme_textdomain() For translation/localization support.
 * @uses add_editor_style() To add Visual Editor stylesheets.
 * @uses add_theme_support() To add support for automatic feed links, post
 * formats, and post thumbnails.
 * @uses register_nav_menu() To add support for a navigation menu.
 * @uses set_post_thumbnail_size() To set a custom post thumbnail size.
 *
 * @since Blokken 1.0
 *
 * @return void
 */
function blokken_setup() {
	/*
	 * Makes Blokken available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Blokken, use a find and
	 * replace to change 'blokken' to the name of your theme in all
	 * template files.
	 */
	load_theme_textdomain( 'blokken', get_template_directory() . '/languages' );

	/*
	 * This theme styles the visual editor to resemble the theme style,
	 * specifically font, colors, icons, and column width.
	 */
	add_editor_style( array( 'css/editor-style.css', 'fonts/genericons.css', blokken_fonts_url() ) );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support( 'automatic-feed-links' );


	/*
	 * This theme supports all available post formats by default.
	 * See http://codex.wordpress.org/Post_Formats
	 */

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
 * Returns the Google font stylesheet URL, if available.
 *
 * The use of Source Sans Pro and Bitter by default is localized. For languages
 * that use characters not supported by the font, the font can be disabled.
 *
 * @since Blokken 1.0
 *
 * @return string Font stylesheet or empty string if disabled.
 */
function blokken_fonts_url() {
	$fonts_url = '';

	/* Translators: If there are characters in your language that are not
	 * supported by Source Sans Pro, translate this to 'off'. Do not translate
	 * into your own language.
	 */
	$source_sans_pro = _x( 'on', 'Source Sans Pro font: on or off', 'blokken' );

	/* Translators: If there are characters in your language that are not
	 * supported by Bitter, translate this to 'off'. Do not translate into your
	 * own language.
	 */
	$bitter = _x( 'on', 'Bitter font: on or off', 'blokken' );

	if ( 'off' !== $source_sans_pro || 'off' !== $bitter ) {
		$font_families = array();

		if ( 'off' !== $source_sans_pro )
			$font_families[] = 'Source Sans Pro:300,400,700,300italic,400italic,700italic';

		if ( 'off' !== $bitter )
			$font_families[] = 'Bitter:400,700';

		$query_args = array(
			'family' => urlencode( implode( '|', $font_families ) ),
			'subset' => urlencode( 'latin,latin-ext' ),
		);
		$fonts_url = add_query_arg( $query_args, "//fonts.googleapis.com/css" );
	}

	return $fonts_url;
}

/**
 * Enqueues scripts and styles for front end.
 *
 * @since Blokken 1.0
 *
 * @return void
 */
function blokken_scripts_styles() {
	// Add Genericons font, used in the main stylesheet.
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.css', array(), '3.0.0' );

	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap-theme.css', array(), '3.0.0' );

	wp_enqueue_style( 'blokken-style', get_stylesheet_uri(), array(), '2013-07-18' );

	wp_enqueue_script( 'bootstrap-js', get_template_directory_uri() . '/js/bootstrap.js' );

}

add_action( 'wp_enqueue_scripts', 'blokken_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Blokken 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
//function blokken_wp_title( $title, $sep ) {
//	global $paged, $page;
//
//	if ( is_feed() )
//		return $title;
//
//	// Add the site name.
//	$title .= get_bloginfo( 'name' );
//
//	// Add the site description for the home/front page.
//	$site_description = get_bloginfo( 'description', 'display' );
//	if ( $site_description && ( is_home() || is_front_page() ) )
//		$title = "$title $sep $site_description";
//
//	// Add a page number if necessary.
//	if ( $paged >= 2 || $page >= 2 )
//		$title = "$title $sep " . sprintf( __( 'Page %s', 'blokken' ), max( $paged, $page ) );
//
//	return $title;
//}
//add_filter( 'wp_title', 'blokken_wp_title', 10, 2 );

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
function blokken_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'blokken_customize_register' );

/**
 * Binds JavaScript handlers to make Customizer preview reload changes
 * asynchronously.
 *
 * @since Blokken 1.0
 */
function blokken_customize_preview_js() {
	wp_enqueue_script( 'blokken-customizer', get_template_directory_uri() . '/js/theme-customizer.js', array( 'customize-preview' ), '20130226', true );
}
add_action( 'customize_preview_init', 'blokken_customize_preview_js' );
