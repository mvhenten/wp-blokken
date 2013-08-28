<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme and one of the
 * two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Blokken 1.0
 */

get_header(); ?>
<div class="container" id="header">
	<div class="row" id="brand">
		<div class="col-md-12 col-sm-6" id="menu">
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => 'nav',
				'menu_class' => 'nav nav-pills pull-right',
				'container_class' => 'row' )
			); ?>
		</div>
		<div class="col-md-12 col-sm-6">
			<?php if ( get_header_image() ) : ?>

			<div id="logo-image">
			  <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php bloginfo( 'name' ); ?>" /></a>
			</div><!-- end of #logo -->

			<?php else: ?>

			<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
				<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
			</a>

			<?php endif; ?>
		</div>
	</div>
</div>

<div class="container" id="content">
	<div class="row">
		<div class="col-md-8 col-md-push-4">
			<?php if ( have_posts() ) : ?>
				<?php /* The loop */ ?>
				<?php if( ! ( is_single() || is_page() ) ): ?>
				<div id="tag-filter">
					<?php $tags = get_tags(); ?>
					<form method="get">
                        <fieldset>
                            <legend><span onclick="$('.form-body,.form-controls').toggle()" area-hidden="true" class="toggle-display">hide</span> category filter</legend>
                            <div class="form-body">
                            <?php
                                $checked = isset( $_GET['tag'] ) ? explode(',', $_GET['tag'] ) : array();
                                $checked = array_fill_keys( $checked, 'checked="checked"' );
                            ?>

                            <?php foreach( $tags as $tag ): ?>
                            <input style="display:none;" <?php echo isset( $checked[$tag->slug] ) ? $checked[$tag->slug] : '' ?> id="filter-tag-<?php echo $tag->slug ?>" type="checkbox" value="<?php echo $tag->slug ?>" />
                            <label for="filter-tag-<?php echo $tag->slug ?>" class="<?php echo isset( $checked[$tag->slug] ) ? 'active' : ''; ?>">
                                <?php echo $tag->name ?>
                            </label>
                            <?php endforeach; ?>
                            </div>
                            <div class="form-controls">
                                <input type="reset" value="clear" onclick="document.location.href='/'; return false;" /><input type="submit" value="filter" />
                            </div>
                        </fieldset>
                        <input id="filter-tags" value="" name="tag" type="hidden" />
					</form>
				</div>
				<?php endif; ?>
				<?php while ( have_posts() ) : the_post(); ?>
                    <?php $type = get_post_type( get_the_ID() ); ?>

                    <?php if( $type == 'blokken_quote' ): ?>
					<div class="row entry quote">
						<div class="col-md-9">
							<h4 class="entry-title">
								<a href="<?php echo get_post_meta( get_the_ID(), '_blokken_quote_link', true ); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h4>
                        </div>
                    </div>
                    <?php continue; endif;?>

					<div class="row entry">
						<div class="col-md-9">
							<h4 class="entry-title">
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
							</h4>

							<?php if ( is_search() ) : // Only display Excerpts for Search ?>
							<div class="entry-summary">
								<?php the_excerpt(); ?>
							</div><!-- .entry-summary -->
							<?php else : ?>
							<div class="entry-content">
								<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'blokken' ) ); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'blokken' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
							</div><!-- .entry-content -->
							<?php endif; ?>
						</div>
						<div class="col-md-3 post-meta">
                            <div class="date">
                                <?php echo get_the_date(); ?>
                            </div>
							<div class="post-tag-list">
                                <?php the_tags('<div>','</div><div>','</div>'); ?>
							</div>
							<br/>
							<?php edit_post_link( __( 'Edit', 'blokken' ), '<span class="edit-link">', '</span>' ); ?>
						</div>
					</div>
				<?php endwhile; ?>
			<?php endif; ?>
		</div>
		<div class="col-md-3 col-md-pull-8">
			<?php dynamic_sidebar( 'sidebar-2' ); ?>
		</div>
	</div>
</div>

<script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>

<?php get_footer(); ?>