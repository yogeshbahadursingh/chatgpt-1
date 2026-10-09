<?php
/**
 * Template: Blog/Insights Archive
 *
 * @package PeoplePlanetThrive
 */

get_header();

// Get current category if on category archive
$current_category = get_queried_object();
$is_category = is_category();
$is_tag = is_tag();
$is_author = is_author();
?>

<main class="wp-block-group site-main ppt-insights-archive">
	
	<!-- Archive Header -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
			
			<?php if ( $is_category && $current_category ) : ?>
				<div style="margin-bottom:var(--wp--preset--spacing--15)">
					<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--primary);text-decoration:none">
						← <?php esc_html_e( 'All Insights', 'people-planet-thrive' ); ?>
					</a>
				</div>
				<h1 style="font-size:var(--wp--preset--font-size--48);font-weight:700;margin-bottom:var(--wp--preset--spacing--15)"><?php echo esc_html( $current_category->name ); ?></h1>
				<?php if ( $current_category->description ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.6;color:var(--wp--preset--color--text-light);max-width:720px">
						<?php echo wp_kses_post( wpautop( $current_category->description ) ); ?>
					</div>
				<?php endif; ?>
			<?php elseif ( $is_tag && $current_category ) : ?>
				<div style="margin-bottom:var(--wp--preset--spacing--15)">
					<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>" style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--primary);text-decoration:none">
						← <?php esc_html_e( 'All Insights', 'people-planet-thrive' ); ?>
					</a>
				</div>
				<h1 style="font-size:var(--wp--preset--font-size--48);font-weight:700;margin-bottom:var(--wp--preset--spacing--15)">
					<?php esc_html_e( 'Tag:', 'people-planet-thrive' ); ?> <?php echo esc_html( $current_category->name ); ?>
				</h1>
			<?php elseif ( $is_author ) : ?>
				<div style="display:flex;gap:var(--wp--preset--spacing--20);align-items:center;margin-bottom:var(--wp--preset--spacing--20)">
					<?php echo get_avatar( get_the_author_meta( 'ID' ), 96, '', '', array( 'class' => array( 'ppt-author-avatar' ) ) ); ?>
					<div>
						<h1 style="font-size:var(--wp--preset--font-size--48);font-weight:700;margin-bottom:var(--wp--preset--spacing--10)"><?php the_author(); ?></h1>
						<?php if ( get_the_author_meta( 'description' ) ) : ?>
							<div style="font-size:var(--wp--preset--font-size--18);line-height:1.6;color:var(--wp--preset--color--text-light);max-width:720px">
								<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			<?php else : ?>
				<h1 style="font-size:var(--wp--preset--font-size--48);font-weight:700;margin-bottom:var(--wp--preset--spacing--15)"><?php esc_html_e( 'Insights', 'people-planet-thrive' ); ?></h1>
				<p style="font-size:var(--wp--preset--font-size--18);line-height:1.6;color:var(--wp--preset--color--text-light);max-width:720px">
					<?php esc_html_e( 'Expert analysis, commentary, and perspectives on the issues shaping our world.', 'people-planet-thrive' ); ?>
				</p>
			<?php endif; ?>

		</div>
	</div>

	<!-- Archive Content -->
	<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<?php if ( have_posts() ) : ?>
			
			<!-- Filter Bar -->
			<?php if ( ! $is_category && ! $is_tag && ! $is_author ) : ?>
				<div style="margin-bottom:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--20);border-bottom:1px solid var(--wp--preset--color--border)">
					<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10);align-items:center">
						<span style="font-size:var(--wp--preset--font-size--14);font-weight:600;color:var(--wp--preset--color--text-light);margin-right:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Filter by:', 'people-planet-thrive' ); ?></span>
						<?php
						$categories = get_categories( array(
							'orderby'    => 'name',
							'order'      => 'ASC',
							'hide_empty' => true,
						) );
						foreach ( $categories as $category ) :
							?>
							<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text);text-decoration:none">
								<?php echo esc_html( $category->name ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<!-- Posts Grid -->
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,320px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php while ( have_posts() ) : the_post(); ?>
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

							<h2 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
								<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
							</h2>

							<!-- Author and Date -->
							<div style="font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
								<?php esc_html_e( 'By', 'people-planet-thrive' ); ?> 
								<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" style="color:var(--wp--preset--color--primary);text-decoration:underline;text-underline-offset:.15em">
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
				<?php endwhile; ?>
			</div>

			<!-- Pagination -->
			<div style="margin-top:var(--wp--preset--spacing--50);display:flex;justify-content:center">
				<?php
				the_posts_pagination( array(
					'mid_size'  => 2,
					'prev_text' => __( '← Previous', 'people-planet-thrive' ),
					'next_text' => __( 'Next →', 'people-planet-thrive' ),
				) );
				?>
			</div>

		<?php else : ?>
			<div style="text-align:center;padding:var(--wp--preset--spacing--60) 0">
				<p style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--text-light)"><?php esc_html_e( 'New work is being prepared for this programme.', 'people-planet-thrive' ); ?></p>
			</div>
		<?php endif; ?>

	</div>

</main>

<?php
get_footer();
