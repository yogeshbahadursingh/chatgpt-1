<?php
/**
 * Template: Insights Landing Page
 *
 * Template Name: Insights Landing
 *
 * @package PeoplePlanetThrive
 */

get_header();

// Get featured story (sticky post or first post)
$featured_args = array(
	'posts_per_page' => 1,
	'post__in'       => get_option( 'sticky_posts' ),
	'ignore_sticky_posts' => 1,
);
$featured_query = new WP_Query( $featured_args );

// If no sticky post, get the latest post
if ( ! $featured_query->have_posts() ) {
	$featured_args = array(
		'posts_per_page' => 1,
		'post_status'    => 'publish',
	);
	$featured_query = new WP_Query( $featured_args );
}

// Get content types (categories)
$content_types = get_categories( array(
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => true,
	'number'     => 6,
) );

// Get recent articles
$recent_args = array(
	'posts_per_page' => 6,
	'post_status'    => 'publish',
	'post__not_in'   => get_option( 'sticky_posts' ),
);
$recent_query = new WP_Query( $recent_args );
?>

<main class="wp-block-group site-main">
	
	<!-- Hero Section -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--deep-forest);color:white;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;text-align:center">
			<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Insights', 'people-planet-thrive' ); ?></h1>
			<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;max-width:720px;margin:0 auto;opacity:0.9">
				<?php esc_html_e( 'Expert analysis, commentary, and perspectives on the issues shaping our world.', 'people-planet-thrive' ); ?>
			</p>
		</div>
	</div>

	<!-- Featured Story -->
	<?php if ( $featured_query->have_posts() ) : $featured_query->the_post(); ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<div class="ppt-featured-story" style="display:grid;grid-template-columns:1fr 1fr;gap:var(--wp--preset--spacing--40);align-items:center">
				
				<!-- Featured Image -->
				<div>
					<?php if ( has_post_thumbnail() ) : ?>
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:4px;box-shadow:0 4px 12px rgba(0,0,0,0.1)' ) ); ?>
						</a>
					<?php endif; ?>
				</div>

				<!-- Featured Content -->
				<div>
					<span style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--heritage-gold);color:var(--wp--preset--color--deep-forest);border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--15)">
						<?php esc_html_e( 'Featured Story', 'people-planet-thrive' ); ?>
					</span>

					<h2 style="font-size:var(--wp--preset--font-size--40);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--15)">
						<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
					</h2>

					<!-- Author and Date -->
					<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
						<?php esc_html_e( 'By', 'people-planet-thrive' ); ?> 
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" style="color:var(--wp--preset--color--primary);text-decoration:none">
							<?php the_author(); ?>
						</a>
						<span style="margin:0 var(--wp--preset--spacing--10)">·</span>
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
					</div>

					<!-- Excerpt -->
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7;margin-bottom:var(--wp--preset--spacing--20);color:var(--wp--preset--color--text-light)">
						<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
					</div>

					<a href="<?php the_permalink(); ?>" class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Read Full Story', 'people-planet-thrive' ); ?></a>
				</div>

			</div>
		</div>
	<?php wp_reset_postdata(); endif; ?>

	<!-- Content Types -->
	<?php if ( ! empty( $content_types ) ) : ?>
		<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--40) var(--wp--preset--spacing--30)">
			<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
				<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin-bottom:var(--wp--preset--spacing--30);text-align:center"><?php esc_html_e( 'Explore by Topic', 'people-planet-thrive' ); ?></h2>
				<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,180px),1fr));gap:var(--wp--preset--spacing--20)">
					<?php foreach ( $content_types as $type ) : ?>
						<a href="<?php echo esc_url( get_category_link( $type->term_id ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--25);background-color:var(--wp--preset--color--white);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center;transition:transform 0.2s ease,box-shadow 0.2s ease">
							<h3 style="font-size:var(--wp--preset--font-size--18);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php echo esc_html( $type->name ); ?></h3>
							<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
								<?php echo esc_html( $type->count ); ?> <?php esc_html_e( 'articles', 'people-planet-thrive' ); ?>
							</div>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<!-- Recent Articles -->
	<?php if ( $recent_query->have_posts() ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--wp--preset--spacing--30)">
				<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin:0"><?php esc_html_e( 'Latest Insights', 'people-planet-thrive' ); ?></h2>
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none">
					<?php esc_html_e( 'View All →', 'people-planet-thrive' ); ?>
				</a>
			</div>
			
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,320px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php while ( $recent_query->have_posts() ) : $recent_query->the_post(); ?>
					<article class="ppt-article-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;overflow:hidden;background-color:var(--wp--preset--color--white);transition:transform 0.2s ease,box-shadow 0.2s ease">
						
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:200px;object-fit:cover' ) ); ?>
							</a>
						<?php endif; ?>

						<div style="padding:var(--wp--preset--spacing--20)">
							
							<!-- Categories -->
							<div style="margin-bottom:var(--wp--preset--spacing--10)">
								<?php
								$categories = get_the_category();
								if ( $categories ) :
									foreach ( $categories as $category ) :
										?>
										<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);color:var(--wp--preset--color--text);text-decoration:none;margin-right:var(--wp--preset--spacing--10)">
											<?php echo esc_html( $category->name ); ?>
										</a>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>

							<h3 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
								<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
							</h3>

							<!-- Author and Date -->
							<div style="font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
								<?php esc_html_e( 'By', 'people-planet-thrive' ); ?> 
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" style="color:var(--wp--preset--color--primary);text-decoration:none">
									<?php the_author(); ?>
								</a>
								<span style="margin:0 var(--wp--preset--spacing--10)">·</span>
								<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
							</div>

							<!-- Excerpt -->
							<div style="font-size:var(--wp--preset--font-size--14);line-height:1.6;color:var(--wp--preset--color--text-light)">
								<?php echo esc_html( wp_trim_words( get_the_excerpt(), 20 ) ); ?>
							</div>

						</div>

					</article>
				<?php endwhile; wp_reset_postdata(); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Page Content -->
	<?php if ( have_posts() ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
				<?php
				while ( have_posts() ) :
					the_post();
					the_content();
				endwhile;
				?>
			</div>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
