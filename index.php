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
<div class="layout-container" id="header">
	<div class="row" id="brand">
		<div class="col-md-12 col-sm-6" id="menu">
			<?php wp_nav_menu( array(
				'theme_location' => 'primary',
				'container' => 'main-menu',
				'menu_class' => 'menu-item',
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

<div class="layout-container" id="content">
    <div class="col col-25">
        <div class="col-pad-right fix-wrapper">
			<div class="fixed">
				<?php dynamic_sidebar( 'sidebar-2' ); ?>
				<form role="search" method="get" class="blokken-search" action="/">
					<div>
						<input class="input-text" type="text" value="" name="s" id="s" placeholder="Search. then hit enter.">
						<input class="input-submit" type="submit" value="Search">
					</div>
				</form>
			</div>
        </div>
    </div>

    <div class="col col-75">
        <?php if(! have_posts() ): ?>
            <div class="col col-70">
                <div class="entry">
                    <div class="quote">
                        <h4 class="entry-title"><a target="_blank" href="http://encrypted.google.com">I have climbed highest mountains I have run through the fields <br/>But I still haven't found what I'm looking for...</a></h4>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if ( have_posts() ) : ?>
            <?php /* The loop */ ?>
            <?php if( ! ( is_single() || is_page() ) ): ?>
            <div class="col col-100">
                <div id="tag-filter">
                    <?php $tags = get_tags(); ?>
                    <form id="tag-filter" method="get">
                        <fieldset>
                            <legend><span onclick="$('.form-body,.form-controls').toggle(); _toggleText( this, 'hide','show')" area-hidden="true" class="toggle-display">hide</span> category filter</legend>
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
						<script>
							function _toggleText( el, a, b ) {
								if ( $(el).text() == a ) $(el).html(b);
								else $(el).html(a);
							}

							$(document).ready(function(){
								function _fadeControls() {
									var len = $('#tag-filter form').serializeArray()[0].value.length;

									$('#tag-filter .form-controls').fadeTo( 400, 0 < len ? 1 : 0.5 );
								}

								$('#tag-filter input').change( _fadeControls );
								_fadeControls();
							});
						</script>
                    </form>
                </div>
            </div>
			<div class="clear" ></div>
            <?php endif; ?>
            <?php while ( have_posts() ) : the_post(); ?>
                <?php $type = get_post_type( get_the_ID() ); ?>

                <div class="col col-70">
					<?php
						$categories = get_the_category();

						$cats = array();
						foreach( $categories as $cat ){
							$cats[] = $cat->name;
						}
						$meta = get_post_meta( get_the_ID(), 'hotglue', true );
					?>
                    <div class="entry <?php echo $meta ? 'hotglue' : '' ?>">
					<?php if( $meta ): ?>
					<a class="hotglue-link" title="edit me in hotglue" href="<?php echo $meta ?>">edit me in hotglue</a>
					<?php endif; ?>
                    <?php if( $type == 'blokken_quote' ): ?>
                        <div class="quote">
                            <h4 class="entry-title"><a target="_blank" href="<?php echo get_post_meta( get_the_ID(), '_blokken_quote_link', true ); ?>" rel="bookmark"><?php the_title(); ?></a></h4>
                        </div>
                    <?php else: ?>
                        <h4 class="entry-title">
                            <a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a>
                        </h4>

						<div class="entry-content">
							<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'blokken' ) ); ?>
							<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'blokken' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
						</div><!-- .entry-content -->
                    <?php endif;?>
                    </div>
					<?php if( is_single() ): ?>
						<div class="blokken-comments">
							<?php comments_template( '', true ); ?>
						</div>
					<?php endif; ?>
                </div>


                <div class="col col-30">
                    <div class="col-pad-left post-meta">
                        <div class="date">
							<?php $count = get_comments_number() ?>
							<?php if( $count ): ?>
								<a href="<?php the_permalink(); ?>" rel="bookmark"><?php $count == 1 ? printf('%d comment', $count ) :printf('%d comments', $count ) ?></a>
							<?php else: ?>
								<a href="<?php the_permalink(); ?>" rel="bookmark">comment</a>
							<?php endif; ?>
                        </div>
                        <div class="post-tag-list">
                            <?php the_tags('<div>','</div><div>','</div>'); ?>
                        </div>
                        <br/>
                        <?php edit_post_link( __( 'Edit', 'blokken' ), '<span class="edit-link">', '</span>' ); ?>
                    </div>
                </div>
                <hr class="post-separator" />
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>