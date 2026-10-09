<?php
/**
 * Template: Archive Articles
 *
 * @package PeoplePlanetThrive
 */

get_header();
?>

<main class="wp-block-group site-main">
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		
		<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700"><?php esc_html_e( 'Articles', 'people-planet-thrive' ); ?></h1>
		
		<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Browse scholarly articles across all journals.', 'people-planet-thrive' ); ?></p>

		<!-- Filters -->
		<div class="wp-block-group ppt-article-filters" style="border-top:1px solid var(--wp--preset--color--border);border-bottom:1px solid var(--wp--preset--color--border);margin-top:var(--wp--preset--spacing--30);margin-bottom:var(--wp--preset--spacing--40);padding:var(--wp--preset--spacing--20) 0">
			<p style="font-size:var(--wp--preset--font-size--14);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Filter by:', 'people-planet-thrive' ); ?></p>
			<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--20)">
				<?php
				// Subject areas
				$subject_areas = get_terms( array(
					'taxonomy' => 'ppt_subject_area',
					'hide_empty' => true,
				) );
				if ( ! empty( $subject_areas ) && ! is_wp_error( $subject_areas ) ) :
					?>
					<div>
						<strong style="font-size:var(--wp--preset--font-size--14)"><?php esc_html_e( 'Subject Areas:', 'people-planet-thrive' ); ?></strong>
						<?php foreach ( $subject_areas as $area ) : ?>
							<a href="<?php echo esc_url( get_term_link( $area ) ); ?>" style="font-size:var(--wp--preset--font-size--14);margin-left:var(--wp--preset--spacing--10)"><?php echo esc_html( $area->name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php
				// Article types
				$article_types = get_terms( array(
					'taxonomy' => 'ppt_article_type',
					'hide_empty' => true,
				) );
				if ( ! empty( $article_types ) && ! is_wp_error( $article_types ) ) :
					?>
					<div>
						<strong style="font-size:var(--wp--preset--font-size--14)"><?php esc_html_e( 'Types:', 'people-planet-thrive' ); ?></strong>
						<?php foreach ( $article_types as $type ) : ?>
							<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" style="font-size:var(--wp--preset--font-size--14);margin-left:var(--wp--preset--spacing--10)"><?php echo esc_html( $type->name ); ?></a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>

		<hr style="margin:var(--wp--preset--spacing--50) 0;border:none;border-top:1px solid var(--wp--preset--color--border)">

		<?php if ( have_posts() ) : ?>
			<div style="display:flex;flex-direction:column">
				<?php while ( have_posts() ) : the_post();
					$doi = get_post_meta( get_the_ID(), '_ppt_doi', true );
					$author_ids = get_post_meta( get_the_ID(), '_ppt_authors', true );
					$published_date = get_post_meta( get_the_ID(), '_ppt_published_date', true );
					
					// Get authors
					$authors = array();
					if ( $author_ids ) {
						$author_id_array = array_map( 'intval', explode( ',', $author_ids ) );
						$authors = get_posts( array(
							'post_type' => 'ppt_author',
							'post__in' => $author_id_array,
							'orderby' => 'post__in',
							'posts_per_page' => -1,
						) );
					}
					
					// Format date
					$formatted_date = '';
					if ( $published_date ) {
						$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $published_date ) );
					}
					?>
					<div class="wp-block-group ppt-article-list-item" style="border-bottom:1px solid var(--wp--preset--color--border);padding-bottom:var(--wp--preset--spacing--30);margin-bottom:var(--wp--preset--spacing--30)">
						
						<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--30)">
							<div class="wp-block-column" style="flex-basis:75%">
								
								<!-- Article Type -->
								<?php
								$article_types = get_the_terms( get_the_ID(), 'ppt_article_type' );
								if ( $article_types && ! is_wp_error( $article_types ) ) :
									foreach ( $article_types as $type ) :
										?>
										<span style="font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em"><?php echo esc_html( $type->name ); ?></span>
										<?php
									endforeach;
								endif;
								?>

								<!-- Title -->
								<h2 style="font-size:var(--wp--preset--font-size--24);line-height:1.3;font-weight:600;margin-top:var(--wp--preset--spacing--10);margin-bottom:var(--wp--preset--spacing--10)">
									<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
								</h2>

								<!-- Authors -->
								<?php if ( ! empty( $authors ) ) : ?>
									<div class="wp-block-group ppt-article-authors-list" style="font-size:var(--wp--preset--font-size--14);margin-bottom:var(--wp--preset--spacing--10)">
										<?php
										$author_links = array();
										foreach ( $authors as $author ) {
											$author_links[] = '<a href="' . esc_url( get_permalink( $author->ID ) ) . '">' . esc_html( $author->post_title ) . '</a>';
										}
										echo implode( ', ', $author_links ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- All elements are already escaped above
										?>
									</div>
								<?php endif; ?>

								<!-- Excerpt -->
								<?php if ( has_excerpt() ) : ?>
									<div style="font-size:var(--wp--preset--font-size--16);line-height:1.6">
										<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
									</div>
								<?php endif; ?>

								<!-- Metadata -->
								<div class="wp-block-group ppt-article-meta-brief" style="margin-top:var(--wp--preset--spacing--15);font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light)">
									<?php if ( $formatted_date ) : ?>
										<span class="ppt-date"><?php echo esc_html( $formatted_date ); ?></span>
									<?php endif; ?>
									<?php if ( $doi ) : ?>
										| <strong><?php esc_html_e( 'DOI:', 'people-planet-thrive' ); ?></strong> <a href="https://doi.org/<?php echo esc_attr( $doi ); ?>" class="ppt-doi-brief"><?php echo esc_html( $doi ); ?></a>
									<?php endif; ?>
								</div>

							</div>

							<div class="wp-block-column" style="flex-basis:25%">
								<?php if ( has_post_thumbnail() ) : ?>
									<a href="<?php the_permalink(); ?>">
										<?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:auto;aspect-ratio:4/3;object-fit:cover;border-radius:4px' ) ); ?>
									</a>
								<?php endif; ?>
							</div>
						</div>

					</div>
				<?php endwhile; ?>
			</div>

			<!-- Pagination -->
			<div style="margin-top:var(--wp--preset--spacing--50)">
				<?php
				the_posts_pagination( array(
					'mid_size' => 2,
					'prev_text' => __( '← Previous', 'people-planet-thrive' ),
					'next_text' => __( 'Next →', 'people-planet-thrive' ),
				) );
				?>
			</div>

		<?php else : ?>
			<p style="font-size:var(--wp--preset--font-size--18);text-align:center;padding:var(--wp--preset--spacing--50) 0"><?php esc_html_e( 'New work is being prepared for this programme.', 'people-planet-thrive' ); ?></p>
		<?php endif; ?>

	</div>
</main>

<?php
get_footer();
