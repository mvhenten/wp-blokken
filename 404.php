<?php
/**
 * The template for displaying 404 pages (Not Found).
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Blokken 1.0
 */

get_header(); ?>

<h2><?php _e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'blokken' ); ?></h2>
<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'blokken' ); ?></p>

<?php get_search_form(); ?>

<?php get_footer(); ?>