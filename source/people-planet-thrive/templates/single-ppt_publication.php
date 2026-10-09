<?php
/**
 * Template: Single Publication
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

// Get all meta fields
$isbn       = get_post_meta( get_the_ID(), '_ppt_publication_isbn', true );
$format     = get_post_meta( get_the_ID(), '_ppt_publication_format', true );
$ppt_display_pages      = get_post_meta( get_the_ID(), '_ppt_publication_pages', true );
$date       = get_post_meta( get_the_ID(), '_ppt_publication_date', true );
$publisher  = get_post_meta( get_the_ID(), '_ppt_publication_publisher', true );
$editors    = get_post_meta( get_the_ID(), '_ppt_publication_editors', true );
$price      = get_post_meta( get_the_ID(), '_ppt_publication_price', true );
$is_free    = get_post_meta( get_the_ID(), '_ppt_publication_is_free', true );
$file_url   = get_post_meta( get_the_ID(), '_ppt_publication_file_url', true );
$product_id = get_post_meta( get_the_ID(), '_ppt_publication_product_id', true );

// Format date
$formatted_date = '';
if ( $date ) {
	$formatted_date = date_i18n( get_option( 'date_format' ), strtotime( $date ) );
}

// Get publication type terms
$pub_types = get_the_terms( get_the_ID(), 'ppt_publication_type' );
?>

<main class="wp-block-group site-main">
	
	<!-- Breadcrumb -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--30) var(--wp--preset--spacing--30) 0">
		<div class="wp-block-group ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14)">
			<p>
				<a href="<?php echo esc_url( get_post_type_archive_link( 'ppt_publication' ) ); ?>"><?php esc_html_e( 'Publications', 'people-planet-thrive' ); ?></a>
				/ <span class="ppt-current"><?php the_title(); ?></span>
			</p>
		</div>
	</div>

	<!-- Publication Header -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div class="wp-block-columns" style="gap:var(--wp--preset--spacing--50)">
			
			<!-- Cover Image -->
			<div class="wp-block-column" style="flex-basis:33.33%">
				<?php if ( has_post_thumbnail() ) : ?>
					<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:4px;box-shadow:0 4px 12px rgba(0,0,0,0.1)' ) ); ?>
				<?php else : ?>
					<div style="width:100%;aspect-ratio:3/4;background-color:var(--wp--preset--color--surface-alt);border-radius:4px;display:flex;align-items:center;justify-content:center">
						<span style="font-size:var(--wp--preset--font-size--60);color:var(--wp--preset--color--text-light)">📚</span>
					</div>
				<?php endif; ?>
			</div>

			<!-- Publication Info -->
			<div class="wp-block-column" style="flex-basis:66.66%">
				
				<?php if ( $format ) : ?>
					<span style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
						<?php echo esc_html( ucfirst( str_replace( '-', ' ', $format ) ) ); ?>
					</span>
				<?php endif; ?>

				<h1 style="font-size:var(--wp--preset--font-size--48);line-height:1.2;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

				<?php if ( $editors ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--20)">
						<?php echo esc_html( $editors ); ?>
					</div>
				<?php endif; ?>

				<!-- Metadata Grid -->
				<div class="wp-block-group" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(min(100%,150px),1fr));gap:var(--wp--preset--spacing--20);margin-bottom:var(--wp--preset--spacing--30);padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
					
					<?php if ( $isbn ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'ISBN', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $isbn ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $formatted_date ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Published', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $formatted_date ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $publisher ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Publisher', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $publisher ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $ppt_display_pages ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Pages', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--14)"><?php echo esc_html( $ppt_display_pages ); ?></span>
						</div>
					<?php endif; ?>

					<?php if ( $is_free === '1' ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Price', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--16);font-weight:600;color:var(--wp--preset--color--success)"><?php esc_html_e( 'Free', 'people-planet-thrive' ); ?></span>
						</div>
					<?php elseif ( $price ) : ?>
						<div>
							<strong style="display:block;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Price', 'people-planet-thrive' ); ?></strong>
							<span style="font-size:var(--wp--preset--font-size--16);font-weight:600;color:var(--wp--preset--color--primary)">$<?php echo esc_html( $price ); ?></span>
						</div>
					<?php endif; ?>

				</div>

				<!-- Excerpt -->
				<?php if ( has_excerpt() ) : ?>
					<div style="font-size:var(--wp--preset--font-size--18);line-height:1.7;margin-bottom:var(--wp--preset--spacing--30);color:var(--wp--preset--color--text-light)">
						<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
					</div>
				<?php endif; ?>

				<!-- Action Buttons -->
				<div class="wp-block-group" style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--15)">
					<?php if ( $is_free === '1' && $file_url ) : ?>
						<a href="<?php echo esc_url( $file_url ); ?>" class="wp-block-button__link wp-element-button" download><?php esc_html_e( 'Download Free', 'people-planet-thrive' ); ?></a>
					<?php elseif ( $product_id && class_exists( 'WooCommerce' ) ) : ?>
						<a href="<?php echo esc_url( get_permalink( $product_id ) ); ?>" class="wp-block-button__link wp-element-button"><?php esc_html_e( 'Purchase', 'people-planet-thrive' ); ?></a>
					<?php elseif ( $price ) : ?>
						<span class="wp-block-button__link wp-element-button" style="opacity:0.6;cursor:not-allowed"><?php esc_html_e( 'Coming Soon', 'people-planet-thrive' ); ?></span>
					<?php endif; ?>
				</div>

			</div>

		</div>
	</div>

	<!-- Publication Content -->
	<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
		<div class="entry-content" style="font-size:var(--wp--preset--font-size--18);line-height:1.7">
			<?php the_content(); ?>
		</div>
	</div>

	<!-- Publication Types -->
	<?php if ( ! empty( $pub_types ) && ! is_wp_error( $pub_types ) ) : ?>
		<div class="wp-block-group" style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--40) var(--wp--preset--spacing--30)">
			<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10)">
				<?php foreach ( $pub_types as $type ) : ?>
					<a href="<?php echo esc_url( get_term_link( $type ) ); ?>" style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text);text-decoration:none">
						<?php echo esc_html( $type->name ); ?>
					</a>
				<?php endforeach; ?>
			</div>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
