<?php
/**
 * Template: Publications Landing Page
 *
 * Template Name: Publications Landing
 *
 * @package PeoplePlanetThrive
 */

get_header();

// Get recent publications
$recent_publications = get_posts( array(
	'post_type'      => 'ppt_publication',
	'posts_per_page' => 6,
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

// Get free publications
$free_publications = get_posts( array(
	'post_type'      => 'ppt_publication',
	'posts_per_page' => 4,
	'meta_key'       => '_ppt_publication_is_free',
	'meta_value'     => '1',
	'orderby'        => 'date',
	'order'          => 'DESC',
) );

// Get publication types
$publication_types = get_terms( array(
	'taxonomy'   => 'ppt_publication_type',
	'hide_empty' => true,
	'number'     => 6,
) );
?>

<main class="wp-block-group site-main">
	
	<!-- Hero Section -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--deep-forest);color:white;padding:var(--wp--preset--spacing--60) var(--wp--preset--spacing--30)">
		<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;text-align:center">
			<h1 style="font-size:var(--wp--preset--font-size--60);font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php esc_html_e( 'Publications', 'people-planet-thrive' ); ?></h1>
			<p style="font-size:var(--wp--preset--font-size--20);line-height:1.6;max-width:720px;margin:0 auto;opacity:0.9">
				<?php esc_html_e( 'Discover our collection of books, reports, and research publications advancing knowledge for people and planet.', 'people-planet-thrive' ); ?>
			</p>
		</div>
	</div>

	<!-- Publication Types -->
	<?php if ( ! empty( $publication_types ) && ! is_wp_error( $publication_types ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Browse by Type', 'people-planet-thrive' ); ?></h2>
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,200px),1fr));gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $publication_types as $type ) : ?>
					<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" style="display:block;padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--surface-alt);border-radius:4px;text-decoration:none;color:var(--wp--preset--color--heading);text-align:center;transition:transform 0.2s ease,box-shadow 0.2s ease">
						<h3 style="font-size:var(--wp--preset--font-size--20);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)"><?php echo esc_html( $type->name ); ?></h3>
						<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
							<?php echo esc_html( $type->count ); ?> <?php esc_html_e( 'publications', 'people-planet-thrive' ); ?>
						</div>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Recent Publications -->
	<?php if ( ! empty( $recent_publications ) ) : ?>
		<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto">
				<div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--wp--preset--spacing--30)">
					<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin:0"><?php esc_html_e( 'Recent Publications', 'people-planet-thrive' ); ?></h2>
					<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_publication' ) ); ?>" style="font-size:var(--wp--preset--font-size--16);color:var(--wp--preset--color--primary);text-decoration:none">
						<?php esc_html_e( 'View All →', 'people-planet-thrive' ); ?>
					</a>
				</div>
				
				<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,280px),1fr));gap:var(--wp--preset--spacing--30)">
					<?php foreach ( $recent_publications as $publication ) : 
						$pub_format = get_post_meta( $publication->ID, '_ppt_publication_format', true );
						$pub_editors = get_post_meta( $publication->ID, '_ppt_publication_editors', true );
						$pub_price = get_post_meta( $publication->ID, '_ppt_publication_price', true );
						$pub_is_free = get_post_meta( $publication->ID, '_ppt_publication_is_free', true );
						?>
						<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;overflow:hidden;background-color:var(--wp--preset--color--white)">
							
							<?php if ( has_post_thumbnail( $publication->ID ) ) : ?>
								<a href="<?php echo esc_url( get_permalink( $publication->ID ) ); ?>">
									<?php echo get_the_post_thumbnail( $publication->ID, 'medium', array( 'style' => 'width:100%;height:300px;object-fit:cover' ) ); ?>
								</a>
							<?php else : ?>
								<div style="width:100%;height:300px;background-color:var(--wp--preset--color--surface-alt);display:flex;align-items:center;justify-content:center">
									<span style="font-size:var(--wp--preset--font-size--48);color:var(--wp--preset--color--text-light)">📚</span>
								</div>
							<?php endif; ?>

							<div style="padding:var(--wp--preset--spacing--20)">
								
								<?php if ( $pub_format ) : ?>
									<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
										<?php echo esc_html( ucfirst( str_replace( '-', ' ', $pub_format ) ) ); ?>
									</span>
								<?php endif; ?>

								<h3 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
									<a href="<?php echo esc_url( get_permalink( $publication->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $publication->post_title ); ?></a>
								</h3>

								<?php if ( $pub_editors ) : ?>
									<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
										<?php echo esc_html( $pub_editors ); ?>
									</div>
								<?php endif; ?>

								<div style="font-size:var(--wp--preset--font-size--14);font-weight:600">
									<?php if ( $pub_is_free === '1' ) : ?>
										<span style="color:var(--wp--preset--color--success)"><?php esc_html_e( 'Free', 'people-planet-thrive' ); ?></span>
									<?php elseif ( $pub_price ) : ?>
										<span style="color:var(--wp--preset--color--primary)">$<?php echo esc_html( $pub_price ); ?></span>
									<?php endif; ?>
								</div>

							</div>

						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<!-- Free Publications -->
	<?php if ( ! empty( $free_publications ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<h2 style="font-size:var(--wp--preset--font-size--32);font-weight:700;margin-bottom:var(--wp--preset--spacing--30)"><?php esc_html_e( 'Free Downloads', 'people-planet-thrive' ); ?></h2>
			
			<div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(min(100%,250px),1fr));gap:var(--wp--preset--spacing--20)">
				<?php foreach ( $free_publications as $publication ) : 
					$pub_format = get_post_meta( $publication->ID, '_ppt_publication_format', true );
					?>
					<div class="wp-block-group" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--white)">
						
						<?php if ( $pub_format ) : ?>
							<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
								<?php echo esc_html( ucfirst( str_replace( '-', ' ', $pub_format ) ) ); ?>
							</span>
						<?php endif; ?>

						<h3 style="font-size:var(--wp--preset--font-size--18);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
							<a href="<?php echo esc_url( get_permalink( $publication->ID ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php echo esc_html( $publication->post_title ); ?></a>
						</h3>

						<div style="font-size:var(--wp--preset--font-size--14);font-weight:600;color:var(--wp--preset--color--success)">
							<?php esc_html_e( 'Free Download', 'people-planet-thrive' ); ?>
						</div>

					</div>
				<?php endforeach; ?>
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
