<?php
/**
 * Meta Boxes for Scholarly Content
 *
 * @package PPTCore
 * @since 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class PPT_Meta_Boxes
 *
 * Handles meta box registration and rendering for scholarly content types.
 */
class PPT_Meta_Boxes {

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'add_meta_boxes', array( $this, 'register_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'save_meta_boxes' ) );
	}

	/**
	 * Register meta boxes.
	 */
	public function register_meta_boxes(): void {
		// Journal meta box.
		add_meta_box(
			'ppt_journal_details',
			esc_html__( 'Journal Details', 'ppt-core' ),
			array( $this, 'render_journal_meta_box' ),
			'ppt_journal',
			'normal',
			'high'
		);

		// Journal Issue meta box.
		add_meta_box(
			'ppt_issue_details',
			esc_html__( 'Issue Details', 'ppt-core' ),
			array( $this, 'render_issue_meta_box' ),
			'ppt_journal_issue',
			'normal',
			'high'
		);

		// Article meta box.
		add_meta_box(
			'ppt_article_details',
			esc_html__( 'Article Details', 'ppt-core' ),
			array( $this, 'render_article_meta_box' ),
			'ppt_article',
			'normal',
			'high'
		);

		// Author meta box.
		add_meta_box(
			'ppt_author_details',
			esc_html__( 'Author Details', 'ppt-core' ),
			array( $this, 'render_author_meta_box' ),
			'ppt_author',
			'normal',
			'high'
		);

		// Research Area meta box.
		add_meta_box(
			'ppt_research_area_details',
			esc_html__( 'Research Area Details', 'ppt-core' ),
			array( $this, 'render_research_area_meta_box' ),
			'ppt_research_area',
			'normal',
			'high'
		);

		// Research Project meta box.
		add_meta_box(
			'ppt_research_project_details',
			esc_html__( 'Project Details', 'ppt-core' ),
			array( $this, 'render_research_project_meta_box' ),
			'ppt_research_project',
			'normal',
			'high'
		);

		// Researcher meta box.
		add_meta_box(
			'ppt_researcher_details',
			esc_html__( 'Researcher Details', 'ppt-core' ),
			array( $this, 'render_researcher_meta_box' ),
			'ppt_researcher',
			'normal',
			'high'
		);

		// Publication meta box.
		add_meta_box(
			'ppt_publication_details',
			esc_html__( 'Publication Details', 'ppt-core' ),
			array( $this, 'render_publication_meta_box' ),
			'ppt_publication',
			'normal',
			'high'
		);

		// Training meta box.
		add_meta_box(
			'ppt_training_details',
			esc_html__( 'Training Details', 'ppt-core' ),
			array( $this, 'render_training_meta_box' ),
			'ppt_training',
			'normal',
			'high'
		);

		// Event meta box.
		add_meta_box(
			'ppt_event_details',
			esc_html__( 'Event Details', 'ppt-core' ),
			array( $this, 'render_event_meta_box' ),
			'ppt_event',
			'normal',
			'high'
		);

		// Team Member meta box.
		add_meta_box(
			'ppt_team_member_details',
			esc_html__( 'Team Member Details', 'ppt-core' ),
			array( $this, 'render_team_member_meta_box' ),
			'ppt_team_member',
			'normal',
			'high'
		);

		// Partner meta box.
		add_meta_box(
			'ppt_partner_details',
			esc_html__( 'Partner Details', 'ppt-core' ),
			array( $this, 'render_partner_meta_box' ),
			'ppt_partner',
			'normal',
			'high'
		);
	}

	/**
	 * Render journal meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_journal_meta_box( $post ): void {
		wp_nonce_field( 'ppt_journal_meta_box', 'ppt_journal_meta_box_nonce' );

		$issn              = get_post_meta( $post->ID, '_ppt_issn', true );
		$eissn             = get_post_meta( $post->ID, '_ppt_eissn', true );
		$frequency         = get_post_meta( $post->ID, '_ppt_frequency', true );
		$editor_name       = get_post_meta( $post->ID, '_ppt_editor_name', true );
		$aims_scope        = get_post_meta( $post->ID, '_ppt_aims_scope', true );
		$editorial_board   = get_post_meta( $post->ID, '_ppt_editorial_board', true );
		$policies          = get_post_meta( $post->ID, '_ppt_policies', true );
		$author_guidelines = get_post_meta( $post->ID, '_ppt_author_guidelines', true );
		$submission_info   = get_post_meta( $post->ID, '_ppt_submission_info', true );
		$current_issue_id  = get_post_meta( $post->ID, '_ppt_current_issue_id', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_issn"><?php esc_html_e( 'ISSN', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_issn" name="_ppt_issn" value="<?php echo esc_attr( $issn ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_eissn"><?php esc_html_e( 'eISSN', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_eissn" name="_ppt_eissn" value="<?php echo esc_attr( $eissn ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_frequency"><?php esc_html_e( 'Publication Frequency', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_frequency" name="_ppt_frequency" value="<?php echo esc_attr( $frequency ); ?>" class="regular-text" placeholder="e.g., Quarterly, Biannual" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_editor_name"><?php esc_html_e( 'Editor-in-Chief', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_editor_name" name="_ppt_editor_name" value="<?php echo esc_attr( $editor_name ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_current_issue_id"><?php esc_html_e( 'Current Issue ID', 'ppt-core' ); ?></label></th>
				<td><input type="number" id="_ppt_current_issue_id" name="_ppt_current_issue_id" value="<?php echo esc_attr( $current_issue_id ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_aims_scope"><?php esc_html_e( 'Aims & Scope', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_aims_scope" name="_ppt_aims_scope" rows="4" class="large-text"><?php echo esc_textarea( $aims_scope ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_editorial_board"><?php esc_html_e( 'Editorial Board', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_editorial_board" name="_ppt_editorial_board" rows="4" class="large-text" placeholder="List editorial board members"><?php echo esc_textarea( $editorial_board ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_policies"><?php esc_html_e( 'Policies', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_policies" name="_ppt_policies" rows="4" class="large-text"><?php echo esc_textarea( $policies ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_author_guidelines"><?php esc_html_e( 'Author Guidelines', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_author_guidelines" name="_ppt_author_guidelines" rows="4" class="large-text"><?php echo esc_textarea( $author_guidelines ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_submission_info"><?php esc_html_e( 'Submission Information', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_submission_info" name="_ppt_submission_info" rows="4" class="large-text"><?php echo esc_textarea( $submission_info ); ?></textarea></td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render publication meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_publication_meta_box( $post ): void {
		wp_nonce_field( 'ppt_publication_meta_box', 'ppt_publication_meta_box_nonce' );

		$isbn       = get_post_meta( $post->ID, '_ppt_publication_isbn', true );
		$format     = get_post_meta( $post->ID, '_ppt_publication_format', true );
		$pages      = get_post_meta( $post->ID, '_ppt_publication_pages', true );
		$date       = get_post_meta( $post->ID, '_ppt_publication_date', true );
		$publisher  = get_post_meta( $post->ID, '_ppt_publication_publisher', true );
		$editors    = get_post_meta( $post->ID, '_ppt_publication_editors', true );
		$price      = get_post_meta( $post->ID, '_ppt_publication_price', true );
		$is_free    = get_post_meta( $post->ID, '_ppt_publication_is_free', true );
		$file_url   = get_post_meta( $post->ID, '_ppt_publication_file_url', true );
		$product_id = get_post_meta( $post->ID, '_ppt_publication_product_id', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_publication_isbn"><?php esc_html_e( 'ISBN', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_publication_isbn" name="_ppt_publication_isbn" value="<?php echo esc_attr( $isbn ); ?>" class="regular-text" placeholder="e.g., 978-3-16-148410-0" />
					<p class="description"><?php esc_html_e( 'International Standard Book Number', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_format"><?php esc_html_e( 'Format', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_publication_format" name="_ppt_publication_format">
						<option value=""><?php esc_html_e( '— Select Format —', 'ppt-core' ); ?></option>
						<option value="book" <?php selected( $format, 'book' ); ?>><?php esc_html_e( 'Book', 'ppt-core' ); ?></option>
						<option value="ebook" <?php selected( $format, 'ebook' ); ?>><?php esc_html_e( 'E-book', 'ppt-core' ); ?></option>
						<option value="report" <?php selected( $format, 'report' ); ?>><?php esc_html_e( 'Report', 'ppt-core' ); ?></option>
						<option value="policy-brief" <?php selected( $format, 'policy-brief' ); ?>><?php esc_html_e( 'Policy Brief', 'ppt-core' ); ?></option>
						<option value="monograph" <?php selected( $format, 'monograph' ); ?>><?php esc_html_e( 'Monograph', 'ppt-core' ); ?></option>
						<option value="journal-issue" <?php selected( $format, 'journal-issue' ); ?>><?php esc_html_e( 'Journal Issue', 'ppt-core' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_pages"><?php esc_html_e( 'Pages', 'ppt-core' ); ?></label></th>
				<td><input type="number" id="_ppt_publication_pages" name="_ppt_publication_pages" value="<?php echo esc_attr( $pages ); ?>" class="small-text" min="0" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_date"><?php esc_html_e( 'Publication Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_publication_date" name="_ppt_publication_date" value="<?php echo esc_attr( $date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_publisher"><?php esc_html_e( 'Publisher', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_publication_publisher" name="_ppt_publication_publisher" value="<?php echo esc_attr( $publisher ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_editors"><?php esc_html_e( 'Authors/Editors', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_publication_editors" name="_ppt_publication_editors" value="<?php echo esc_attr( $editors ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Comma-separated names', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_is_free"><?php esc_html_e( 'Free Publication', 'ppt-core' ); ?></label></th>
				<td>
					<label>
						<input type="checkbox" id="_ppt_publication_is_free" name="_ppt_publication_is_free" value="1" <?php checked( $is_free, '1' ); ?> />
						<?php esc_html_e( 'This publication is free to download', 'ppt-core' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_price"><?php esc_html_e( 'Price', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_publication_price" name="_ppt_publication_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text" placeholder="e.g., 29.99" />
					<p class="description"><?php esc_html_e( 'Price in your currency (if not free)', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_file_url"><?php esc_html_e( 'Download File URL', 'ppt-core' ); ?></label></th>
				<td>
					<input type="url" id="_ppt_publication_file_url" name="_ppt_publication_file_url" value="<?php echo esc_attr( $file_url ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'URL to downloadable file (for free publications)', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<tr>
				<th><label for="_ppt_publication_product_id"><?php esc_html_e( 'WooCommerce Product', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_publication_product_id" name="_ppt_publication_product_id">
						<option value=""><?php esc_html_e( '— Select Product —', 'ppt-core' ); ?></option>
						<?php
						$products = get_posts( array(
							'post_type'      => 'product',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
						) );
						foreach ( $products as $product ) {
							printf(
								'<option value="%s" %s>%s</option>',
								esc_attr( $product->ID ),
								selected( $product_id, $product->ID, false ),
								esc_html( $product->post_title )
							);
						}
						?>
					</select>
					<p class="description"><?php esc_html_e( 'Link to WooCommerce product for paid publications', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		<?php
	}

	/**
	 * Render training meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_training_meta_box( $post ): void {
		wp_nonce_field( 'ppt_training_meta_box', 'ppt_training_meta_box_nonce' );

		$instructor        = get_post_meta( $post->ID, '_ppt_training_instructor', true );
		$learning_outcomes = get_post_meta( $post->ID, '_ppt_training_learning_outcomes', true );
		$audience          = get_post_meta( $post->ID, '_ppt_training_audience', true );
		$level             = get_post_meta( $post->ID, '_ppt_training_level', true );
		$duration          = get_post_meta( $post->ID, '_ppt_training_duration', true );
		$delivery_mode     = get_post_meta( $post->ID, '_ppt_training_delivery_mode', true );
		$start_date        = get_post_meta( $post->ID, '_ppt_training_start_date', true );
		$end_date          = get_post_meta( $post->ID, '_ppt_training_end_date', true );
		$location          = get_post_meta( $post->ID, '_ppt_training_location', true );
		$capacity          = get_post_meta( $post->ID, '_ppt_training_capacity', true );
		$price             = get_post_meta( $post->ID, '_ppt_training_price', true );
		$is_free           = get_post_meta( $post->ID, '_ppt_training_is_free', true );
		$registration_url  = get_post_meta( $post->ID, '_ppt_training_registration_url', true );
		$product_id        = get_post_meta( $post->ID, '_ppt_training_product_id', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_training_instructor"><?php esc_html_e( 'Instructor/Facilitator', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_training_instructor" name="_ppt_training_instructor" value="<?php echo esc_attr( $instructor ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_training_learning_outcomes"><?php esc_html_e( 'Learning Outcomes', 'ppt-core' ); ?></label></th>
				<td>
					<textarea id="_ppt_training_learning_outcomes" name="_ppt_training_learning_outcomes" rows="4" class="large-text"><?php echo esc_textarea( $learning_outcomes ); ?></textarea>
					<p class="description"><?php esc_html_e( 'One outcome per line', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_training_audience"><?php esc_html_e( 'Target Audience', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_training_audience" name="_ppt_training_audience" value="<?php echo esc_attr( $audience ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_training_level"><?php esc_html_e( 'Level', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_training_level" name="_ppt_training_level">
						<option value=""><?php esc_html_e( '— Select Level —', 'ppt-core' ); ?></option>
						<option value="beginner" <?php selected( $level, 'beginner' ); ?>><?php esc_html_e( 'Beginner', 'ppt-core' ); ?></option>
						<option value="intermediate" <?php selected( $level, 'intermediate' ); ?>><?php esc_html_e( 'Intermediate', 'ppt-core' ); ?></option>
						<option value="advanced" <?php selected( $level, 'advanced' ); ?>><?php esc_html_e( 'Advanced', 'ppt-core' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_training_duration"><?php esc_html_e( 'Duration', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_training_duration" name="_ppt_training_duration" value="<?php echo esc_attr( $duration ); ?>" class="regular-text" placeholder="e.g., 4 weeks, 2 days, 8 hours" />
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_training_delivery_mode"><?php esc_html_e( 'Delivery Mode', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_training_delivery_mode" name="_ppt_training_delivery_mode">
						<option value=""><?php esc_html_e( '— Select Mode —', 'ppt-core' ); ?></option>
						<option value="online" <?php selected( $delivery_mode, 'online' ); ?>><?php esc_html_e( 'Online', 'ppt-core' ); ?></option>
						<option value="in-person" <?php selected( $delivery_mode, 'in-person' ); ?>><?php esc_html_e( 'In-Person', 'ppt-core' ); ?></option>
						<option value="hybrid" <?php selected( $delivery_mode, 'hybrid' ); ?>><?php esc_html_e( 'Hybrid', 'ppt-core' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_training_start_date"><?php esc_html_e( 'Start Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_training_start_date" name="_ppt_training_start_date" value="<?php echo esc_attr( $start_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_training_end_date"><?php esc_html_e( 'End Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_training_end_date" name="_ppt_training_end_date" value="<?php echo esc_attr( $end_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_training_location"><?php esc_html_e( 'Location', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_training_location" name="_ppt_training_location" value="<?php echo esc_attr( $location ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Physical location or online platform', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_training_capacity"><?php esc_html_e( 'Capacity', 'ppt-core' ); ?></label></th>
				<td><input type="number" id="_ppt_training_capacity" name="_ppt_training_capacity" value="<?php echo esc_attr( $capacity ); ?>" class="small-text" min="0" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_training_is_free"><?php esc_html_e( 'Free Training', 'ppt-core' ); ?></label></th>
				<td>
					<label>
						<input type="checkbox" id="_ppt_training_is_free" name="_ppt_training_is_free" value="1" <?php checked( $is_free, '1' ); ?> />
						<?php esc_html_e( 'This training is free', 'ppt-core' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_training_price"><?php esc_html_e( 'Price', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_training_price" name="_ppt_training_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text" placeholder="e.g., 299.00" />
					<p class="description"><?php esc_html_e( 'Price in your currency (if not free)', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_training_registration_url"><?php esc_html_e( 'Registration URL', 'ppt-core' ); ?></label></th>
				<td>
					<input type="url" id="_ppt_training_registration_url" name="_ppt_training_registration_url" value="<?php echo esc_attr( $registration_url ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'External registration link (if not using WooCommerce)', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<tr>
				<th><label for="_ppt_training_product_id"><?php esc_html_e( 'WooCommerce Product', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_training_product_id" name="_ppt_training_product_id">
						<option value=""><?php esc_html_e( '— Select Product —', 'ppt-core' ); ?></option>
						<?php
						$products = get_posts( array(
							'post_type'      => 'product',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
						) );
						foreach ( $products as $product ) {
							printf(
								'<option value="%s" %s>%s</option>',
								esc_attr( $product->ID ),
								selected( $product_id, $product->ID, false ),
								esc_html( $product->post_title )
							);
						}
						?>
					</select>
					<p class="description"><?php esc_html_e( 'Link to WooCommerce product for paid training', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		<?php
	}

	/**
	 * Render event meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_event_meta_box( $post ): void {
		wp_nonce_field( 'ppt_event_meta_box', 'ppt_event_meta_box_nonce' );

		$organizer        = get_post_meta( $post->ID, '_ppt_event_organizer', true );
		$start_date       = get_post_meta( $post->ID, '_ppt_event_start_date', true );
		$end_date         = get_post_meta( $post->ID, '_ppt_event_end_date', true );
		$start_time       = get_post_meta( $post->ID, '_ppt_event_start_time', true );
		$end_time         = get_post_meta( $post->ID, '_ppt_event_end_time', true );
		$location         = get_post_meta( $post->ID, '_ppt_event_location', true );
		$is_virtual       = get_post_meta( $post->ID, '_ppt_event_is_virtual', true );
		$virtual_url      = get_post_meta( $post->ID, '_ppt_event_virtual_url', true );
		$capacity         = get_post_meta( $post->ID, '_ppt_event_capacity', true );
		$price            = get_post_meta( $post->ID, '_ppt_event_price', true );
		$is_free          = get_post_meta( $post->ID, '_ppt_event_is_free', true );
		$registration_url = get_post_meta( $post->ID, '_ppt_event_registration_url', true );
		$product_id       = get_post_meta( $post->ID, '_ppt_event_product_id', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_event_organizer"><?php esc_html_e( 'Organizer', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_event_organizer" name="_ppt_event_organizer" value="<?php echo esc_attr( $organizer ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_event_start_date"><?php esc_html_e( 'Start Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_event_start_date" name="_ppt_event_start_date" value="<?php echo esc_attr( $start_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_event_end_date"><?php esc_html_e( 'End Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_event_end_date" name="_ppt_event_end_date" value="<?php echo esc_attr( $end_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_event_start_time"><?php esc_html_e( 'Start Time', 'ppt-core' ); ?></label></th>
				<td><input type="time" id="_ppt_event_start_time" name="_ppt_event_start_time" value="<?php echo esc_attr( $start_time ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_event_end_time"><?php esc_html_e( 'End Time', 'ppt-core' ); ?></label></th>
				<td><input type="time" id="_ppt_event_end_time" name="_ppt_event_end_time" value="<?php echo esc_attr( $end_time ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_event_location"><?php esc_html_e( 'Location', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_event_location" name="_ppt_event_location" value="<?php echo esc_attr( $location ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Physical venue or address', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_event_is_virtual"><?php esc_html_e( 'Virtual Event', 'ppt-core' ); ?></label></th>
				<td>
					<label>
						<input type="checkbox" id="_ppt_event_is_virtual" name="_ppt_event_is_virtual" value="1" <?php checked( $is_virtual, '1' ); ?> />
						<?php esc_html_e( 'This is a virtual/online event', 'ppt-core' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_event_virtual_url"><?php esc_html_e( 'Virtual Event URL', 'ppt-core' ); ?></label></th>
				<td>
					<input type="url" id="_ppt_event_virtual_url" name="_ppt_event_virtual_url" value="<?php echo esc_attr( $virtual_url ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Link to virtual event platform (Zoom, Teams, etc.)', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_event_capacity"><?php esc_html_e( 'Capacity', 'ppt-core' ); ?></label></th>
				<td><input type="number" id="_ppt_event_capacity" name="_ppt_event_capacity" value="<?php echo esc_attr( $capacity ); ?>" class="small-text" min="0" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_event_is_free"><?php esc_html_e( 'Free Event', 'ppt-core' ); ?></label></th>
				<td>
					<label>
						<input type="checkbox" id="_ppt_event_is_free" name="_ppt_event_is_free" value="1" <?php checked( $is_free, '1' ); ?> />
						<?php esc_html_e( 'This event is free', 'ppt-core' ); ?>
					</label>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_event_price"><?php esc_html_e( 'Price', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_event_price" name="_ppt_event_price" value="<?php echo esc_attr( $price ); ?>" class="regular-text" placeholder="e.g., 50.00" />
					<p class="description"><?php esc_html_e( 'Price in your currency (if not free)', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_event_registration_url"><?php esc_html_e( 'Registration URL', 'ppt-core' ); ?></label></th>
				<td>
					<input type="url" id="_ppt_event_registration_url" name="_ppt_event_registration_url" value="<?php echo esc_attr( $registration_url ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'External registration link (if not using WooCommerce)', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<?php if ( class_exists( 'WooCommerce' ) ) : ?>
			<tr>
				<th><label for="_ppt_event_product_id"><?php esc_html_e( 'WooCommerce Product', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_event_product_id" name="_ppt_event_product_id">
						<option value=""><?php esc_html_e( '— Select Product —', 'ppt-core' ); ?></option>
						<?php
						$products = get_posts( array(
							'post_type'      => 'product',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
						) );
						foreach ( $products as $product ) {
							printf(
								'<option value="%s" %s>%s</option>',
								esc_attr( $product->ID ),
								selected( $product_id, $product->ID, false ),
								esc_html( $product->post_title )
							);
						}
						?>
					</select>
					<p class="description"><?php esc_html_e( 'Link to WooCommerce product for paid events', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<?php endif; ?>
		</table>
		<?php
	}

	/**
	 * Render team member meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_team_member_meta_box( $post ): void {
		wp_nonce_field( 'ppt_team_member_meta_box', 'ppt_team_member_meta_box_nonce' );

		$role         = get_post_meta( $post->ID, '_ppt_team_role', true );
		$department   = get_post_meta( $post->ID, '_ppt_team_department', true );
		$email        = get_post_meta( $post->ID, '_ppt_team_email', true );
		$linkedin     = get_post_meta( $post->ID, '_ppt_team_linkedin', true );
		$is_leadership = get_post_meta( $post->ID, '_ppt_team_is_leadership', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_team_role"><?php esc_html_e( 'Role/Title', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_team_role" name="_ppt_team_role" value="<?php echo esc_attr( $role ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_team_department"><?php esc_html_e( 'Department', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_team_department" name="_ppt_team_department" value="<?php echo esc_attr( $department ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_team_email"><?php esc_html_e( 'Email', 'ppt-core' ); ?></label></th>
				<td><input type="email" id="_ppt_team_email" name="_ppt_team_email" value="<?php echo esc_attr( $email ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_team_linkedin"><?php esc_html_e( 'LinkedIn URL', 'ppt-core' ); ?></label></th>
				<td><input type="url" id="_ppt_team_linkedin" name="_ppt_team_linkedin" value="<?php echo esc_attr( $linkedin ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_team_is_leadership"><?php esc_html_e( 'Leadership', 'ppt-core' ); ?></label></th>
				<td>
					<label>
						<input type="checkbox" id="_ppt_team_is_leadership" name="_ppt_team_is_leadership" value="1" <?php checked( $is_leadership, '1' ); ?> />
						<?php esc_html_e( 'This team member is part of leadership', 'ppt-core' ); ?>
					</label>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render partner meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_partner_meta_box( $post ): void {
		wp_nonce_field( 'ppt_partner_meta_box', 'ppt_partner_meta_box_nonce' );

		$partner_type = get_post_meta( $post->ID, '_ppt_partner_type', true );
		$website      = get_post_meta( $post->ID, '_ppt_partner_website', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_partner_type"><?php esc_html_e( 'Partner Type', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_partner_type" name="_ppt_partner_type" value="<?php echo esc_attr( $partner_type ); ?>" class="regular-text" placeholder="e.g., Academic, Corporate, NGO" />
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_partner_website"><?php esc_html_e( 'Website URL', 'ppt-core' ); ?></label></th>
				<td><input type="url" id="_ppt_partner_website" name="_ppt_partner_website" value="<?php echo esc_attr( $website ); ?>" class="regular-text" /></td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render issue meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_issue_meta_box( $post ): void {
		wp_nonce_field( 'ppt_issue_meta_box', 'ppt_issue_meta_box_nonce' );

		$volume           = get_post_meta( $post->ID, '_ppt_volume', true );
		$issue_number     = get_post_meta( $post->ID, '_ppt_issue_number', true );
		$publication_date = get_post_meta( $post->ID, '_ppt_publication_date', true );
		$journal_id       = get_post_meta( $post->ID, '_ppt_journal_id', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_journal_id"><?php esc_html_e( 'Journal', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_journal_id" name="_ppt_journal_id" class="regular-text">
						<option value=""><?php esc_html_e( '— Select Journal —', 'ppt-core' ); ?></option>
						<?php
						$journals = get_posts( array(
							'post_type'      => 'ppt_journal',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
						) );
						foreach ( $journals as $journal ) {
							printf(
								'<option value="%s" %s>%s</option>',
								esc_attr( $journal->ID ),
								selected( $journal_id, $journal->ID, false ),
								esc_html( $journal->post_title )
							);
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_volume"><?php esc_html_e( 'Volume', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_volume" name="_ppt_volume" value="<?php echo esc_attr( $volume ); ?>" class="regular-text" placeholder="e.g., 12" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_issue_number"><?php esc_html_e( 'Issue Number', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_issue_number" name="_ppt_issue_number" value="<?php echo esc_attr( $issue_number ); ?>" class="regular-text" placeholder="e.g., 2" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_publication_date"><?php esc_html_e( 'Publication Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_publication_date" name="_ppt_publication_date" value="<?php echo esc_attr( $publication_date ); ?>" class="regular-text" /></td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render article meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_article_meta_box( $post ): void {
		wp_nonce_field( 'ppt_article_meta_box', 'ppt_article_meta_box_nonce' );

		$doi             = get_post_meta( $post->ID, '_ppt_doi', true );
		$abstract        = get_post_meta( $post->ID, '_ppt_abstract', true );
		$keywords        = get_post_meta( $post->ID, '_ppt_keywords', true );
		$volume          = get_post_meta( $post->ID, '_ppt_volume', true );
		$issue_number    = get_post_meta( $post->ID, '_ppt_issue_number', true );
		$page_start      = get_post_meta( $post->ID, '_ppt_page_start', true );
		$page_end        = get_post_meta( $post->ID, '_ppt_page_end', true );
		$received_date   = get_post_meta( $post->ID, '_ppt_received_date', true );
		$accepted_date   = get_post_meta( $post->ID, '_ppt_accepted_date', true );
		$published_date  = get_post_meta( $post->ID, '_ppt_published_date', true );
		$journal_id      = get_post_meta( $post->ID, '_ppt_journal_id', true );
		$issue_id        = get_post_meta( $post->ID, '_ppt_issue_id', true );
		$authors         = get_post_meta( $post->ID, '_ppt_authors', true );
		$pdf_url         = get_post_meta( $post->ID, '_ppt_pdf_url', true );
		$fulltext_url    = get_post_meta( $post->ID, '_ppt_fulltext_url', true );
		$references      = get_post_meta( $post->ID, '_ppt_references', true );
		$supplementary   = get_post_meta( $post->ID, '_ppt_supplementary', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_doi"><?php esc_html_e( 'DOI', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_doi" name="_ppt_doi" value="<?php echo esc_attr( $doi ); ?>" class="regular-text" placeholder="e.g., 10.1234/example" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_journal_id"><?php esc_html_e( 'Journal', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_journal_id" name="_ppt_journal_id" class="regular-text">
						<option value=""><?php esc_html_e( '— Select Journal —', 'ppt-core' ); ?></option>
						<?php
						$journals = get_posts( array(
							'post_type'      => 'ppt_journal',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
						) );
						foreach ( $journals as $journal ) {
							printf(
								'<option value="%s" %s>%s</option>',
								esc_attr( $journal->ID ),
								selected( $journal_id, $journal->ID, false ),
								esc_html( $journal->post_title )
							);
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_issue_id"><?php esc_html_e( 'Issue', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_issue_id" name="_ppt_issue_id" class="regular-text">
						<option value=""><?php esc_html_e( '— Select Issue —', 'ppt-core' ); ?></option>
						<?php
						$issues = get_posts( array(
							'post_type'      => 'ppt_journal_issue',
							'posts_per_page' => -1,
							'orderby'        => 'date',
							'order'          => 'DESC',
						) );
						foreach ( $issues as $issue ) {
							$issue_volume  = get_post_meta( $issue->ID, '_ppt_volume', true );
							$issue_number  = get_post_meta( $issue->ID, '_ppt_issue_number', true );
							$issue_journal = get_post_meta( $issue->ID, '_ppt_journal_id', true );
							$journal_title = $issue_journal ? get_the_title( $issue_journal ) : '';
							$issue_label   = sprintf( '%s Vol. %s, Issue %s', $journal_title, $issue_volume, $issue_number );
							printf(
								'<option value="%s" %s>%s</option>',
								esc_attr( $issue->ID ),
								selected( $issue_id, $issue->ID, false ),
								esc_html( $issue_label )
							);
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_volume"><?php esc_html_e( 'Volume', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_volume" name="_ppt_volume" value="<?php echo esc_attr( $volume ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_issue_number"><?php esc_html_e( 'Issue Number', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_issue_number" name="_ppt_issue_number" value="<?php echo esc_attr( $issue_number ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_page_start"><?php esc_html_e( 'Page Start', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_page_start" name="_ppt_page_start" value="<?php echo esc_attr( $page_start ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_page_end"><?php esc_html_e( 'Page End', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_page_end" name="_ppt_page_end" value="<?php echo esc_attr( $page_end ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_authors"><?php esc_html_e( 'Authors (IDs)', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_authors" name="_ppt_authors" value="<?php echo esc_attr( $authors ); ?>" class="regular-text" placeholder="e.g., 123,456,789" />
					<p class="description"><?php esc_html_e( 'Comma-separated list of author post IDs', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_abstract"><?php esc_html_e( 'Abstract', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_abstract" name="_ppt_abstract" rows="6" class="large-text"><?php echo esc_textarea( $abstract ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_keywords"><?php esc_html_e( 'Keywords', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_keywords" name="_ppt_keywords" value="<?php echo esc_attr( $keywords ); ?>" class="regular-text" placeholder="e.g., climate change, sustainability" />
					<p class="description"><?php esc_html_e( 'Comma-separated list of keywords', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_received_date"><?php esc_html_e( 'Received Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_received_date" name="_ppt_received_date" value="<?php echo esc_attr( $received_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_accepted_date"><?php esc_html_e( 'Accepted Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_accepted_date" name="_ppt_accepted_date" value="<?php echo esc_attr( $accepted_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_published_date"><?php esc_html_e( 'Published Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_published_date" name="_ppt_published_date" value="<?php echo esc_attr( $published_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_pdf_url"><?php esc_html_e( 'PDF URL', 'ppt-core' ); ?></label></th>
				<td><input type="url" id="_ppt_pdf_url" name="_ppt_pdf_url" value="<?php echo esc_attr( $pdf_url ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_fulltext_url"><?php esc_html_e( 'Full Text URL', 'ppt-core' ); ?></label></th>
				<td><input type="url" id="_ppt_fulltext_url" name="_ppt_fulltext_url" value="<?php echo esc_attr( $fulltext_url ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_references"><?php esc_html_e( 'References', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_references" name="_ppt_references" rows="6" class="large-text"><?php echo esc_textarea( $references ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_supplementary"><?php esc_html_e( 'Supplementary Material', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_supplementary" name="_ppt_supplementary" rows="4" class="large-text"><?php echo esc_textarea( $supplementary ); ?></textarea></td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render author meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_author_meta_box( $post ): void {
		wp_nonce_field( 'ppt_author_meta_box', 'ppt_author_meta_box_nonce' );

		$orcid          = get_post_meta( $post->ID, '_ppt_orcid', true );
		$affiliation    = get_post_meta( $post->ID, '_ppt_affiliation', true );
		$position       = get_post_meta( $post->ID, '_ppt_position', true );
		$google_scholar = get_post_meta( $post->ID, '_ppt_google_scholar', true );
		$research_gate  = get_post_meta( $post->ID, '_ppt_research_gate', true );
		$website        = get_post_meta( $post->ID, '_ppt_website', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_orcid"><?php esc_html_e( 'ORCID', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_orcid" name="_ppt_orcid" value="<?php echo esc_attr( $orcid ); ?>" class="regular-text" placeholder="e.g., 0000-0000-0000-0000" />
					<p class="description"><?php esc_html_e( 'ORCID identifier (e.g., 0000-0000-0000-0000)', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_position"><?php esc_html_e( 'Position/Title', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_position" name="_ppt_position" value="<?php echo esc_attr( $position ); ?>" class="regular-text" placeholder="e.g., Professor, Researcher" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_affiliation"><?php esc_html_e( 'Affiliation', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_affiliation" name="_ppt_affiliation" value="<?php echo esc_attr( $affiliation ); ?>" class="regular-text" placeholder="e.g., University of Example" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_website"><?php esc_html_e( 'Website', 'ppt-core' ); ?></label></th>
				<td><input type="url" id="_ppt_website" name="_ppt_website" value="<?php echo esc_attr( $website ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_google_scholar"><?php esc_html_e( 'Google Scholar URL', 'ppt-core' ); ?></label></th>
				<td><input type="url" id="_ppt_google_scholar" name="_ppt_google_scholar" value="<?php echo esc_attr( $google_scholar ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_research_gate"><?php esc_html_e( 'ResearchGate URL', 'ppt-core' ); ?></label></th>
				<td><input type="url" id="_ppt_research_gate" name="_ppt_research_gate" value="<?php echo esc_attr( $research_gate ); ?>" class="regular-text" /></td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render research area meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_research_area_meta_box( $post ): void {
		wp_nonce_field( 'ppt_research_area_meta_box', 'ppt_research_area_meta_box_nonce' );

		$description = get_post_meta( $post->ID, '_ppt_area_description', true );
		$keywords    = get_post_meta( $post->ID, '_ppt_area_keywords', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_area_description"><?php esc_html_e( 'Description', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_area_description" name="_ppt_area_description" rows="4" class="large-text"><?php echo esc_textarea( $description ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_area_keywords"><?php esc_html_e( 'Keywords', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_area_keywords" name="_ppt_area_keywords" value="<?php echo esc_attr( $keywords ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Comma-separated keywords', 'ppt-core' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render research project meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_research_project_meta_box( $post ): void {
		wp_nonce_field( 'ppt_research_project_meta_box', 'ppt_research_project_meta_box_nonce' );

		$status        = get_post_meta( $post->ID, '_ppt_project_status', true );
		if ( 'planned' === $status ) {
			$status = 'planning';
		}
		$start_date    = get_post_meta( $post->ID, '_ppt_project_start_date', true );
		$end_date      = get_post_meta( $post->ID, '_ppt_project_end_date', true );
		$lead_id       = get_post_meta( $post->ID, '_ppt_project_lead_id', true );
		$team          = get_post_meta( $post->ID, '_ppt_project_team', true );
		$collaborators = get_post_meta( $post->ID, '_ppt_project_collaborators', true );
		$funding       = get_post_meta( $post->ID, '_ppt_project_funding', true );
		$methodology   = get_post_meta( $post->ID, '_ppt_project_methodology', true );
		$timeline      = get_post_meta( $post->ID, '_ppt_project_timeline', true );
		$area_id       = get_post_meta( $post->ID, '_ppt_project_area_id', true );
		$outputs       = get_post_meta( $post->ID, '_ppt_project_outputs', true );
		$reports       = get_post_meta( $post->ID, '_ppt_project_reports', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_project_status"><?php esc_html_e( 'Status', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_project_status" name="_ppt_project_status">
						<option value=""><?php esc_html_e( '— Select Status —', 'ppt-core' ); ?></option>
						<option value="planning" <?php selected( $status, 'planning' ); ?>><?php esc_html_e( 'Planning', 'ppt-core' ); ?></option>
						<option value="active" <?php selected( $status, 'active' ); ?>><?php esc_html_e( 'Active', 'ppt-core' ); ?></option>
						<option value="completed" <?php selected( $status, 'completed' ); ?>><?php esc_html_e( 'Completed', 'ppt-core' ); ?></option>
						<option value="on-hold" <?php selected( $status, 'on-hold' ); ?>><?php esc_html_e( 'On Hold', 'ppt-core' ); ?></option>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_project_area_id"><?php esc_html_e( 'Research Area', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_project_area_id" name="_ppt_project_area_id">
						<option value=""><?php esc_html_e( '— Select Area —', 'ppt-core' ); ?></option>
						<?php
						$areas = get_posts( array(
							'post_type'      => 'ppt_research_area',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
						) );
						foreach ( $areas as $area ) {
							printf(
								'<option value="%s" %s>%s</option>',
								esc_attr( $area->ID ),
								selected( $area_id, $area->ID, false ),
								esc_html( $area->post_title )
							);
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_project_start_date"><?php esc_html_e( 'Start Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_project_start_date" name="_ppt_project_start_date" value="<?php echo esc_attr( $start_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_project_end_date"><?php esc_html_e( 'End Date', 'ppt-core' ); ?></label></th>
				<td><input type="date" id="_ppt_project_end_date" name="_ppt_project_end_date" value="<?php echo esc_attr( $end_date ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_project_lead_id"><?php esc_html_e( 'Project Lead', 'ppt-core' ); ?></label></th>
				<td>
					<select id="_ppt_project_lead_id" name="_ppt_project_lead_id">
						<option value=""><?php esc_html_e( '— Select Lead —', 'ppt-core' ); ?></option>
						<?php
						$researchers = get_posts( array(
							'post_type'      => 'ppt_researcher',
							'posts_per_page' => -1,
							'orderby'        => 'title',
							'order'          => 'ASC',
						) );
						foreach ( $researchers as $researcher ) {
							printf(
								'<option value="%s" %s>%s</option>',
								esc_attr( $researcher->ID ),
								selected( $lead_id, $researcher->ID, false ),
								esc_html( $researcher->post_title )
							);
						}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_project_team"><?php esc_html_e( 'Team Members', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_project_team" name="_ppt_project_team" value="<?php echo esc_attr( $team ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Comma-separated researcher IDs', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_project_collaborators"><?php esc_html_e( 'Collaborators', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_project_collaborators" name="_ppt_project_collaborators" rows="3" class="large-text"><?php echo esc_textarea( $collaborators ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_project_funding"><?php esc_html_e( 'Funding Information', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_project_funding" name="_ppt_project_funding" rows="3" class="large-text"><?php echo esc_textarea( $funding ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_project_methodology"><?php esc_html_e( 'Methodology', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_project_methodology" name="_ppt_project_methodology" rows="4" class="large-text"><?php echo esc_textarea( $methodology ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_project_timeline"><?php esc_html_e( 'Timeline', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_project_timeline" name="_ppt_project_timeline" rows="4" class="large-text"><?php echo esc_textarea( $timeline ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_project_outputs"><?php esc_html_e( 'Outputs', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_project_outputs" name="_ppt_project_outputs" rows="4" class="large-text"><?php echo esc_textarea( $outputs ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_project_reports"><?php esc_html_e( 'Reports (URLs)', 'ppt-core' ); ?></label></th>
				<td>
					<textarea id="_ppt_project_reports" name="_ppt_project_reports" rows="3" class="large-text"><?php echo esc_textarea( $reports ); ?></textarea>
					<p class="description"><?php esc_html_e( 'One URL per line', 'ppt-core' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Render researcher meta box.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_researcher_meta_box( $post ): void {
		wp_nonce_field( 'ppt_researcher_meta_box', 'ppt_researcher_meta_box_nonce' );

		$orcid         = get_post_meta( $post->ID, '_ppt_researcher_orcid', true );
		$role          = get_post_meta( $post->ID, '_ppt_researcher_role', true );
		$expertise     = get_post_meta( $post->ID, '_ppt_researcher_expertise', true );
		$bio           = get_post_meta( $post->ID, '_ppt_researcher_bio', true );
		$selected_work = get_post_meta( $post->ID, '_ppt_researcher_selected_work', true );
		$projects      = get_post_meta( $post->ID, '_ppt_researcher_projects', true );
		?>
		<table class="form-table">
			<tr>
				<th><label for="_ppt_researcher_orcid"><?php esc_html_e( 'ORCID', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_researcher_orcid" name="_ppt_researcher_orcid" value="<?php echo esc_attr( $orcid ); ?>" class="regular-text" placeholder="e.g., 0000-0000-0000-0000" />
					<p class="description"><?php esc_html_e( 'ORCID identifier', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_researcher_role"><?php esc_html_e( 'Role/Title', 'ppt-core' ); ?></label></th>
				<td><input type="text" id="_ppt_researcher_role" name="_ppt_researcher_role" value="<?php echo esc_attr( $role ); ?>" class="regular-text" /></td>
			</tr>
			<tr>
				<th><label for="_ppt_researcher_expertise"><?php esc_html_e( 'Expertise', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_researcher_expertise" name="_ppt_researcher_expertise" value="<?php echo esc_attr( $expertise ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Comma-separated areas of expertise', 'ppt-core' ); ?></p>
				</td>
			</tr>
			<tr>
				<th><label for="_ppt_researcher_bio"><?php esc_html_e( 'Biography', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_researcher_bio" name="_ppt_researcher_bio" rows="5" class="large-text"><?php echo esc_textarea( $bio ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_researcher_selected_work"><?php esc_html_e( 'Selected Work', 'ppt-core' ); ?></label></th>
				<td><textarea id="_ppt_researcher_selected_work" name="_ppt_researcher_selected_work" rows="5" class="large-text"><?php echo esc_textarea( $selected_work ); ?></textarea></td>
			</tr>
			<tr>
				<th><label for="_ppt_researcher_projects"><?php esc_html_e( 'Related Projects', 'ppt-core' ); ?></label></th>
				<td>
					<input type="text" id="_ppt_researcher_projects" name="_ppt_researcher_projects" value="<?php echo esc_attr( $projects ); ?>" class="regular-text" />
					<p class="description"><?php esc_html_e( 'Comma-separated project IDs', 'ppt-core' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Save meta box data.
	 *
	 * @param int $post_id The post ID.
	 */
	public function save_meta_boxes( $post_id ): void {
		// Check if this is an autosave.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return;
		}

		// Check post type.
		$post_type = get_post_type( $post_id );
		if ( ! in_array( $post_type, array( 'ppt_journal', 'ppt_journal_issue', 'ppt_article', 'ppt_author', 'ppt_research_area', 'ppt_research_project', 'ppt_researcher', 'ppt_publication', 'ppt_training', 'ppt_event', 'ppt_team_member', 'ppt_partner' ), true ) ) {
			return;
		}

		// Check user permissions.
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}

		// Save journal meta.
		if ( 'ppt_journal' === $post_type && isset( $_POST['ppt_journal_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_journal_meta_box_nonce'] ) ), 'ppt_journal_meta_box' ) ) {
				return;
			}

			$fields = array(
				'_ppt_issn', '_ppt_eissn', '_ppt_frequency', '_ppt_editor_name',
				'_ppt_aims_scope', '_ppt_editorial_board', '_ppt_policies',
				'_ppt_author_guidelines', '_ppt_submission_info',
			);

			foreach ( $fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			if ( isset( $_POST['_ppt_current_issue_id'] ) ) {
				update_post_meta( $post_id, '_ppt_current_issue_id', absint( $_POST['_ppt_current_issue_id'] ) );
			}
		}

		// Save issue meta.
		if ( 'ppt_journal_issue' === $post_type && isset( $_POST['ppt_issue_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_issue_meta_box_nonce'] ) ), 'ppt_issue_meta_box' ) ) {
				return;
			}

			$fields = array( '_ppt_volume', '_ppt_issue_number', '_ppt_publication_date' );
			foreach ( $fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			if ( isset( $_POST['_ppt_journal_id'] ) ) {
				update_post_meta( $post_id, '_ppt_journal_id', absint( $_POST['_ppt_journal_id'] ) );
			}
		}

		// Save article meta.
		if ( 'ppt_article' === $post_type && isset( $_POST['ppt_article_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_article_meta_box_nonce'] ) ), 'ppt_article_meta_box' ) ) {
				return;
			}

			$text_fields = array(
				'_ppt_doi', '_ppt_abstract', '_ppt_keywords', '_ppt_volume',
				'_ppt_issue_number', '_ppt_page_start', '_ppt_page_end',
				'_ppt_received_date', '_ppt_accepted_date', '_ppt_published_date',
				'_ppt_authors', '_ppt_references', '_ppt_supplementary',
			);

			foreach ( $text_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			$url_fields = array( '_ppt_pdf_url', '_ppt_fulltext_url' );
			foreach ( $url_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, esc_url_raw( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			$int_fields = array( '_ppt_journal_id', '_ppt_issue_id' );
			foreach ( $int_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, absint( $_POST[ $field ] ) );
				}
			}
		}

		// Save author meta.
		if ( 'ppt_author' === $post_type && isset( $_POST['ppt_author_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_author_meta_box_nonce'] ) ), 'ppt_author_meta_box' ) ) {
				return;
			}

			$fields = array(
				'_ppt_orcid', '_ppt_affiliation', '_ppt_position',
				'_ppt_google_scholar', '_ppt_research_gate',
			);

			foreach ( $fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			if ( isset( $_POST['_ppt_website'] ) ) {
				update_post_meta( $post_id, '_ppt_website', esc_url_raw( wp_unslash( $_POST['_ppt_website'] ) ) );
			}
		}

		// Save research area meta.
		if ( 'ppt_research_area' === $post_type && isset( $_POST['ppt_research_area_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_research_area_meta_box_nonce'] ) ), 'ppt_research_area_meta_box' ) ) {
				return;
			}

			$fields = array( '_ppt_area_description', '_ppt_area_keywords' );
			foreach ( $fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}
		}

		// Save research project meta.
		if ( 'ppt_research_project' === $post_type && isset( $_POST['ppt_research_project_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_research_project_meta_box_nonce'] ) ), 'ppt_research_project_meta_box' ) ) {
				return;
			}

			$text_fields = array(
				'_ppt_project_status', '_ppt_project_start_date', '_ppt_project_end_date',
				'_ppt_project_team', '_ppt_project_collaborators', '_ppt_project_funding',
				'_ppt_project_methodology', '_ppt_project_timeline', '_ppt_project_outputs',
				'_ppt_project_reports',
			);

			foreach ( $text_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			$int_fields = array( '_ppt_project_lead_id', '_ppt_project_area_id' );
			foreach ( $int_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, absint( $_POST[ $field ] ) );
				}
			}
		}

		// Save researcher meta.
		if ( 'ppt_researcher' === $post_type && isset( $_POST['ppt_researcher_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_researcher_meta_box_nonce'] ) ), 'ppt_researcher_meta_box' ) ) {
				return;
			}

			$text_fields = array(
				'_ppt_researcher_orcid', '_ppt_researcher_role', '_ppt_researcher_expertise',
				'_ppt_researcher_bio', '_ppt_researcher_selected_work', '_ppt_researcher_projects',
			);

			foreach ( $text_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_textarea_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}
		}

		// Save publication meta.
		if ( 'ppt_publication' === $post_type && isset( $_POST['ppt_publication_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_publication_meta_box_nonce'] ) ), 'ppt_publication_meta_box' ) ) {
				return;
			}

			$text_fields = array(
				'_ppt_publication_isbn', '_ppt_publication_format', '_ppt_publication_date',
				'_ppt_publication_publisher', '_ppt_publication_editors', '_ppt_publication_price',
				'_ppt_publication_file_url',
			);

			foreach ( $text_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			// Handle integer fields.
			$int_fields = array( '_ppt_publication_pages', '_ppt_publication_product_id' );
			foreach ( $int_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, absint( $_POST[ $field ] ) );
				}
			}

			// Handle checkbox (boolean).
			$is_free = isset( $_POST['_ppt_publication_is_free'] ) ? '1' : '0';
			update_post_meta( $post_id, '_ppt_publication_is_free', $is_free );
		}

		// Save training meta.
		if ( 'ppt_training' === $post_type && isset( $_POST['ppt_training_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_training_meta_box_nonce'] ) ), 'ppt_training_meta_box' ) ) {
				return;
			}

			$text_fields = array(
				'_ppt_training_instructor', '_ppt_training_learning_outcomes', '_ppt_training_audience',
				'_ppt_training_level', '_ppt_training_duration', '_ppt_training_delivery_mode',
				'_ppt_training_start_date', '_ppt_training_end_date', '_ppt_training_location',
				'_ppt_training_price', '_ppt_training_registration_url',
			);

			foreach ( $text_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			// Handle integer fields.
			$int_fields = array( '_ppt_training_capacity', '_ppt_training_product_id' );
			foreach ( $int_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, absint( $_POST[ $field ] ) );
				}
			}

			// Handle checkbox (boolean).
			$is_free = isset( $_POST['_ppt_training_is_free'] ) ? '1' : '0';
			update_post_meta( $post_id, '_ppt_training_is_free', $is_free );
		}

		// Save event meta.
		if ( 'ppt_event' === $post_type && isset( $_POST['ppt_event_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_event_meta_box_nonce'] ) ), 'ppt_event_meta_box' ) ) {
				return;
			}

			$text_fields = array(
				'_ppt_event_organizer', '_ppt_event_start_date', '_ppt_event_end_date',
				'_ppt_event_start_time', '_ppt_event_end_time', '_ppt_event_location',
				'_ppt_event_virtual_url', '_ppt_event_price', '_ppt_event_registration_url',
			);

			foreach ( $text_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			// Handle integer fields.
			$int_fields = array( '_ppt_event_capacity', '_ppt_event_product_id' );
			foreach ( $int_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, absint( $_POST[ $field ] ) );
				}
			}

			// Handle checkboxes (boolean).
			$is_virtual = isset( $_POST['_ppt_event_is_virtual'] ) ? '1' : '0';
			update_post_meta( $post_id, '_ppt_event_is_virtual', $is_virtual );

			$is_free = isset( $_POST['_ppt_event_is_free'] ) ? '1' : '0';
			update_post_meta( $post_id, '_ppt_event_is_free', $is_free );
		}

		// Save team member meta.
		if ( 'ppt_team_member' === $post_type && isset( $_POST['ppt_team_member_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_team_member_meta_box_nonce'] ) ), 'ppt_team_member_meta_box' ) ) {
				return;
			}

			$text_fields = array(
				'_ppt_team_role', '_ppt_team_department', '_ppt_team_email', '_ppt_team_linkedin',
			);

			foreach ( $text_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}

			// Handle checkbox (boolean).
			$is_leadership = isset( $_POST['_ppt_team_is_leadership'] ) ? '1' : '0';
			update_post_meta( $post_id, '_ppt_team_is_leadership', $is_leadership );
		}

		// Save partner meta.
		if ( 'ppt_partner' === $post_type && isset( $_POST['ppt_partner_meta_box_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ppt_partner_meta_box_nonce'] ) ), 'ppt_partner_meta_box' ) ) {
				return;
			}

			$text_fields = array( '_ppt_partner_type', '_ppt_partner_website' );

			foreach ( $text_fields as $field ) {
				if ( isset( $_POST[ $field ] ) ) {
					update_post_meta( $post_id, $field, sanitize_text_field( wp_unslash( $_POST[ $field ] ) ) );
				}
			}
		}
	}
}

// Initialize meta boxes.
new PPT_Meta_Boxes();
