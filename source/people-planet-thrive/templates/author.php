<?php
/**
 * Template: Author Archive
 *
 * @package PeoplePlanetThrive
 */

get_header();

$author = get_queried_object();
$author_id = $author->ID;
$author_bio = get_the_author_meta( 'description', $author_id );
$author_website = get_the_author_meta( 'url', $author_id );
$author_posts_count = count_user_posts( $author_id );
?>

<main class="wp-block-group site-main">
	
	<!-- Author Header -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
			
			<div style="display:grid;grid-template-columns:auto 1fr;gap:var(--wp--preset--spacing--40);align-items:center">
				
				<!-- Author Avatar -->
				<div>
					<?php echo get_avatar( $author_id, 160, '', '', array( 'class' => array( 'ppt-author-avatar-large' ) ) ); ?>
				</div>

				<!-- Author Info -->
				<div>
					<h1 style="font-size:var(--wp--preset--font-size--48);font-weight:700;margin-bottom:var(--wp--preset--spacing--15)"><?php echo esc_html( get_the_author_meta( 'display_name', $author_id ) ); ?></h1>
					
					<?php if ( get_the_author_meta( 'job_title', $author_id ) ) : ?>
						<div style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
							<?php echo esc_html( get_the_author_meta( 'job_title', $author_id ) ); ?>
						</div>
					<?php endif; ?>

					<?php if ( $author_bio ) : ?>
						<div style="font-size:var(--wp--preset--font-size--16);line-height:1.7;color:var(--wp--preset--color--text);margin-bottom:var(--wp--preset--spacing--20);max-width:720px">
							<?php echo wp_kses_post( wpautop( $author_bio ) ); ?>
						</div>
					<?php endif; ?>

					<!-- Author Meta -->
					<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20);font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
						<div>
							<strong><?php echo esc_html( $author_posts_count ); ?></strong> <?php esc_html_e( 'articles', 'people-planet-thrive' ); ?>
						</div>
						<?php if ( $author_website ) : ?>
							<div>
								<a href="<?php echo esc_url( $author_website ); ?>" target="_blank" rel="noopener" style="color:var(--wp--preset--color--primary);text-decoration:none">
									<?php esc_html_e( 'Website', 'people-planet-thrive' ); ?> →
								</a>
							</div>
						<?php endif; ?>
					</div>

				</div>

			</div>

		</div>
	</div>

	<!-- Author Posts -->
	<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		
		<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Articles', 'people-planet-thrive' ); ?></h2>

		<?php if ( have_posts() ) : ?>
			
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

							<h3 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
								<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
							</h3>

							<!-- Date -->
							<div style="font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
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
