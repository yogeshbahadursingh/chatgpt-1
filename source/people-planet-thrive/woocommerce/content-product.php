<?php
/**
 * The template for displaying product content within a loop
 *
 * @package PeoplePlanetThrive
 */

defined( 'ABSPATH' ) || exit;

global $product;

// Check if product is a publication (linked to ppt_publication)
$publication_id = get_post_meta( $product->get_id(), '_ppt_publication_id', true );
$publication = null;
if ( $publication_id ) {
	$publication = get_post( $publication_id );
}

// Get publication meta if available
$pub_format = '';
$pub_editors = '';
if ( $publication ) {
	$pub_format = get_post_meta( $publication->ID, '_ppt_publication_format', true );
	$pub_editors = get_post_meta( $publication->ID, '_ppt_publication_editors', true );
}
?>

<li class="wp-block-group ppt-product-card product" style="border:1px solid var(--wp--preset--color--border);border-radius:4px;overflow:hidden;background-color:var(--wp--preset--color--white);transition:transform 0.2s ease,box-shadow 0.2s ease">

	<div style="position:relative">
		<a href="<?php echo esc_url( get_permalink() ); ?>">
			<?php echo $product->get_image( 'medium', array( 'style' => 'width:100%;height:300px;object-fit:cover' ) ); ?>
		</a>

		<?php if ( $product->is_on_sale() ) : ?>
			<span style="position:absolute;top:var(--wp--preset--spacing--15);right:var(--wp--preset--spacing--15);background-color:var(--wp--preset--color--error);color:white;padding:0.3em 0.8em;border-radius:20px;font-size:var(--wp--preset--font-size--12);font-weight:600;text-transform:uppercase">
				<?php esc_html_e( 'Sale', 'people-planet-thrive' ); ?>
			</span>
		<?php endif; ?>
	</div>

	<div style="padding:var(--wp--preset--spacing--20)">

		<?php if ( $pub_format ) : ?>
			<span style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--12);text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--10)">
				<?php echo esc_html( ucfirst( str_replace( '-', ' ', $pub_format ) ) ); ?>
			</span>
		<?php endif; ?>

		<h3 style="font-size:var(--wp--preset--font-size--20);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
			<a href="<?php echo esc_url( get_permalink() ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none">
				<?php the_title(); ?>
			</a>
		</h3>

		<?php if ( $pub_editors ) : ?>
			<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--10)">
				<?php echo esc_html( $pub_editors ); ?>
			</div>
		<?php endif; ?>

		<?php if ( $product->get_short_description() ) : ?>
			<div style="font-size:var(--wp--preset--font-size--14);line-height:1.5;margin-bottom:var(--wp--preset--spacing--15);color:var(--wp--preset--color--text-light)">
				<?php echo esc_html( wp_trim_words( $product->get_short_description(), 15 ) ); ?>
			</div>
		<?php endif; ?>

		<div style="display:flex;justify-content:space-between;align-items:center">
			<div style="font-size:var(--wp--preset--font-size--18);font-weight:600;color:var(--wp--preset--color--primary)">
				<?php echo $product->get_price_html(); ?>
			</div>

			<?php if ( $product->is_purchasable() && $product->is_in_stock() ) : ?>
				<a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" data-product_id="<?php echo esc_attr( $product->get_id() ); ?>" class="wp-block-button__link wp-element-button add_to_cart_button" style="padding:0.5em 1em;font-size:var(--wp--preset--font-size--14)">
					<?php echo esc_html( $product->add_to_cart_text() ); ?>
				</a>
			<?php endif; ?>
		</div>

	</div>

</li>
