<?php
/**
 * Template: Archive Journals
 *
 * @package PeoplePlanetThrive
 */

get_header();
?>

<main class="wp-block-group site-main">
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		
		<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700"><?php esc_html_e( 'Journals', 'people-planet-thrive' ); ?></h1>
		
		<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-top:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Peer-reviewed scholarly journals advancing research across disciplines.', 'people-planet-thrive' ); ?></p>

		<hr style="margin:var(--wp--preset--spacing--50) 0;border:none;border-top:1px solid var(--wp--preset--color--border)">

		<?php if ( have_posts() ) : ?>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,300px),1fr));gap:var(--wp--preset--spacing--30)">
				<?php while ( have_posts() ) : the_post();
					$issn = get_post_meta( get_the_ID(), '_ppt_issn', true );
					?>
					<div class="wp-block-group ppt-journal-card" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--white)">
						
						<?php if ( has_post_thumbnail() ) : ?>
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium', array( 'style' => 'width:100%;height:auto;aspect-ratio:3/4;object-fit:cover;border-radius:4px;margin-bottom:var(--wp--preset--spacing--20)' ) ); ?>
							</a>
						<?php endif; ?>

						<h3 style="font-size:var(--wp--preset--font-size--24);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
						</h3>

						<?php if ( has_excerpt() ) : ?>
							<div style="font-size:var(--wp--preset--font-size--16);line-height:1.6;margin-bottom:var(--wp--preset--spacing--20)">
								<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $issn ) : ?>
							<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
								<strong><?php esc_html_e( 'ISSN:', 'people-planet-thrive' ); ?></strong> <?php echo esc_html( $issn ); ?>
							</div>
						<?php endif; ?>

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
