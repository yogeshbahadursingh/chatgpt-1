<?php
/**
 * Template: Single Post (Article)
 *
 * Optimized for long-form reading experience
 *
 * @package PeoplePlanetThrive
 */

if ( have_posts() ) { the_post(); }
get_header();

// Calculate reading time
$content = get_post_field( 'post_content', get_the_ID() );
$word_count = str_word_count( wp_strip_all_tags( $content ) );
$reading_time = ceil( $word_count / 200 ); // Average 200 words per minute

// Get related posts
$categories = get_the_category();
$category_ids = array();
foreach ( $categories as $category ) {
	$category_ids[] = $category->term_id;
}

$related_args = array(
	'category__in'   => $category_ids,
	'post__not_in'   => array( get_the_ID() ),
	'posts_per_page' => 3,
	'orderby'        => 'rand',
);
$related_query = new WP_Query( $related_args );
?>

<main class="wp-block-group site-main ppt-article-single">
	
	<!-- Article Header -->
	<div class="wp-block-group" style="background-color:var(--wp--preset--color--surface-alt);padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div style="max-width:720px;margin-left:auto;margin-right:auto">
			
			<!-- Breadcrumb -->
			<div class="ppt-breadcrumb" style="font-size:var(--wp--preset--font-size--14);margin-bottom:var(--wp--preset--spacing--20)">
				<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"><?php esc_html_e( 'Insights', 'people-planet-thrive' ); ?></a>
				<?php if ( $categories ) : ?>
					<span style="margin:0 var(--wp--preset--spacing--10)">/</span>
					<a href="<?php echo esc_url( get_category_link( $categories[0]->term_id ) ); ?>"><?php echo esc_html( $categories[0]->name ); ?></a>
				<?php endif; ?>
			</div>

			<!-- Categories -->
			<div style="margin-bottom:var(--wp--preset--spacing--15)">
				<?php if ( $categories ) : ?>
					<?php foreach ( $categories as $category ) : ?>
						<a href="<?php echo esc_url( get_category_link( $category->term_id ) ); ?>" style="display:inline-block;padding:0.2em 0.6em;background-color:var(--wp--preset--color--white);border-radius:20px;font-size:var(--wp--preset--font-size--12);color:var(--wp--preset--color--text);text-decoration:none;margin-right:var(--wp--preset--spacing--10)">
							<?php echo esc_html( $category->name ); ?>
						</a>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>

			<!-- Title -->
			<h1 style="font-size:var(--wp--preset--font-size--50);line-height:1.15;font-weight:700;margin-bottom:var(--wp--preset--spacing--20)"><?php the_title(); ?></h1>

			<!-- Excerpt -->
			<?php if ( has_excerpt() ) : ?>
				<div style="font-size:var(--wp--preset--font-size--20);line-height:1.6;margin-bottom:var(--wp--preset--spacing--25);color:var(--wp--preset--color--text-light)">
					<?php echo wp_kses_post( wpautop( get_the_excerpt() ) ); ?>
				</div>
			<?php endif; ?>

			<!-- Author and Meta -->
			<div style="display:flex;align-items:center;gap:var(--wp--preset--spacing--15);margin-bottom:var(--wp--preset--spacing--25)">
				
				<!-- Author Avatar -->
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 48, '', '', array( 'class' => array( 'ppt-author-avatar' ) ) ); ?>

				<div>
					<!-- Author Name -->
					<div style="font-size:var(--wp--preset--font-size--16);font-weight:600">
						<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none">
							<?php the_author(); ?>
						</a>
					</div>

					<!-- Meta Info -->
					<div style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light)">
						<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
						<?php if ( get_the_modified_date() !== get_the_date() ) : ?>
							<span style="margin:0 var(--wp--preset--spacing--10)">·</span>
							<span><?php esc_html_e( 'Updated', 'people-planet-thrive' ); ?> <time datetime="<?php echo esc_attr( get_the_modified_date( 'c' ) ); ?>"><?php echo esc_html( get_the_modified_date() ); ?></time></span>
						<?php endif; ?>
						<span style="margin:0 var(--wp--preset--spacing--10)">·</span>
						<span><?php echo esc_html( $reading_time ); ?> <?php esc_html_e( 'min read', 'people-planet-thrive' ); ?></span>
					</div>
				</div>

			</div>

		</div>
	</div>

	<!-- Featured Image -->
	<?php if ( has_post_thumbnail() ) : ?>
		<div style="max-width:1280px;margin-left:auto;margin-right:auto;padding:0 var(--wp--preset--spacing--30)">
			<figure style="margin:0">
				<?php the_post_thumbnail( 'large', array( 'style' => 'width:100%;height:auto;border-radius:4px' ) ); ?>
				<?php if ( has_excerpt() ) : ?>
					<figcaption style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text-light);margin-top:var(--wp--preset--spacing--10);text-align:center">
						<?php echo wp_kses_post( get_the_post_thumbnail_caption() ); ?>
					</figcaption>
				<?php endif; ?>
			</figure>
		</div>
	<?php endif; ?>

	<!-- Article Content with Sidebar -->
	<div style="max-width:var(--wp--style--global--wide-size);margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
		<div style="display:grid;grid-template-columns:1fr 280px;gap:var(--wp--preset--spacing--50);align-items:start">
			
			<!-- Main Content -->
			<article class="ppt-article-content" style="max-width:720px">
				
				<!-- Share Tools (Top) -->
				<div class="ppt-share-tools" style="display:flex;gap:var(--wp--preset--spacing--10);margin-bottom:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--20);border-bottom:1px solid var(--wp--preset--color--border)">
					<span style="font-size:var(--wp--preset--font-size--14);font-weight:600;color:var(--wp--preset--color--text-light);margin-right:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Share:', 'people-planet-thrive' ); ?></span>
					<a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;text-decoration:none;color:var(--wp--preset--color--text);transition:background-color 0.2s ease" title="<?php esc_attr_e( 'Share on Twitter', 'people-planet-thrive' ); ?>">
						<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
					</a>
					<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;text-decoration:none;color:var(--wp--preset--color--text);transition:background-color 0.2s ease" title="<?php esc_attr_e( 'Share on LinkedIn', 'people-planet-thrive' ); ?>">
						<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
					</a>
					<a href="mailto:?subject=<?php echo esc_attr( get_the_title() ); ?>&body=<?php echo esc_url( get_permalink() ); ?>" style="display:inline-flex;align-items:center;justify-content:center;width:32px;height:32px;background-color:var(--wp--preset--color--surface-alt);border-radius:50%;text-decoration:none;color:var(--wp--preset--color--text);transition:background-color 0.2s ease" title="<?php esc_attr_e( 'Share via Email', 'people-planet-thrive' ); ?>">
						<svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
					</a>
				</div>

				<!-- Main Content -->
				<div class="entry-content">
					<?php the_content(); ?>
				</div>

				<!-- Tags -->
				<?php
				$tags = get_the_tags();
				if ( $tags ) :
					?>
					<div style="margin-top:var(--wp--preset--spacing--40);padding-top:var(--wp--preset--spacing--30);border-top:1px solid var(--wp--preset--color--border)">
						<h3 style="font-size:var(--wp--preset--font-size--16);font-weight:600;margin-bottom:var(--wp--preset--spacing--15)"><?php esc_html_e( 'Tags', 'people-planet-thrive' ); ?></h3>
						<div style="display:flex;flex-wrap:wrap;gap:var(--wp--preset--spacing--10)">
							<?php foreach ( $tags as $tag ) : ?>
								<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" style="display:inline-block;padding:0.3em 0.8em;background-color:var(--wp--preset--color--surface-alt);border-radius:20px;font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--text);text-decoration:none">
									#<?php echo esc_html( $tag->name ); ?>
								</a>
							<?php endforeach; ?>
						</div>
					</div>
				<?php endif; ?>

				<!-- Author Bio -->
				<div style="margin-top:var(--wp--preset--spacing--40);padding:var(--wp--preset--spacing--30);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
					<div style="display:flex;gap:var(--wp--preset--spacing--20);align-items:start">
						<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', array( 'class' => array( 'ppt-author-avatar' ) ) ); ?>
						<div>
							<h3 style="font-size:var(--wp--preset--font-size--18);font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
								<?php the_author(); ?>
							</h3>
							<?php if ( get_the_author_meta( 'description' ) ) : ?>
								<div style="font-size:var(--wp--preset--font-size--14);line-height:1.6;color:var(--wp--preset--color--text-light);margin-bottom:var(--wp--preset--spacing--15)">
									<?php echo wp_kses_post( wpautop( get_the_author_meta( 'description' ) ) ); ?>
								</div>
							<?php endif; ?>
							<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" style="font-size:var(--wp--preset--font-size--14);color:var(--wp--preset--color--primary);text-decoration:none">
								<?php esc_html_e( 'View all posts by this author →', 'people-planet-thrive' ); ?>
							</a>
						</div>
					</div>
				</div>

				<!-- Share Tools (Bottom) -->
				<div class="ppt-share-tools" style="display:flex;gap:var(--wp--preset--spacing--10);margin-top:var(--wp--preset--spacing--30);padding-top:var(--wp--preset--spacing--30);border-top:1px solid var(--wp--preset--color--border)">
					<span style="font-size:var(--wp--preset--font-size--14);font-weight:600;color:var(--wp--preset--color--text-light);margin-right:var(--wp--preset--spacing--10)"><?php esc_html_e( 'Share this article:', 'people-planet-thrive' ); ?></span>
					<a href="https://twitter.com/intent/tweet?url=<?php echo esc_url( get_permalink() ); ?>&text=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener" class="wp-block-button__link wp-element-button" style="padding:0.5em 1em;font-size:var(--wp--preset--font-size--14)"><?php esc_html_e( 'Twitter', 'people-planet-thrive' ); ?></a>
					<a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php echo esc_url( get_permalink() ); ?>&title=<?php echo esc_attr( get_the_title() ); ?>" target="_blank" rel="noopener" class="wp-block-button__link wp-element-button" style="padding:0.5em 1em;font-size:var(--wp--preset--font-size--14)"><?php esc_html_e( 'LinkedIn', 'people-planet-thrive' ); ?></a>
					<a href="mailto:?subject=<?php echo esc_attr( get_the_title() ); ?>&body=<?php echo esc_url( get_permalink() ); ?>" class="wp-block-button__link wp-element-button" style="padding:0.5em 1em;font-size:var(--wp--preset--font-size--14)"><?php esc_html_e( 'Email', 'people-planet-thrive' ); ?></a>
				</div>

			</article>

			<!-- Sidebar -->
			<aside style="position:sticky;top:var(--wp--preset--spacing--30)">
				
				<!-- Table of Contents -->
				<div class="ppt-toc" style="margin-bottom:var(--wp--preset--spacing--30);padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
					<h3 style="font-size:var(--wp--preset--font-size--14);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--15)"><?php esc_html_e( 'Contents', 'people-planet-thrive' ); ?></h3>
					<div id="ppt-toc-content" style="font-size:var(--wp--preset--font-size--14);line-height:1.6">
						<!-- TOC will be populated by JavaScript -->
						<p style="color:var(--wp--preset--color--text-light);font-style:italic"><?php esc_html_e( 'Loading...', 'people-planet-thrive' ); ?></p>
					</div>
				</div>

				<!-- Related Articles -->
				<?php if ( $related_query->have_posts() ) : ?>
					<div style="padding:var(--wp--preset--spacing--20);background-color:var(--wp--preset--color--surface-alt);border-radius:4px">
						<h3 style="font-size:var(--wp--preset--font-size--14);font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:var(--wp--preset--spacing--15)"><?php esc_html_e( 'Related Articles', 'people-planet-thrive' ); ?></h3>
						<div style="display:flex;flex-direction:column;gap:var(--wp--preset--spacing--15)">
							<?php while ( $related_query->have_posts() ) : $related_query->the_post(); ?>
								<article style="padding-bottom:var(--wp--preset--spacing--15);border-bottom:1px solid var(--wp--preset--color--border)">
									<h4 style="font-size:var(--wp--preset--font-size--16);line-height:1.3;font-weight:600;margin-bottom:var(--wp--preset--spacing--10)">
										<a href="<?php the_permalink(); ?>" style="color:var(--wp--preset--color--heading);text-decoration:none"><?php the_title(); ?></a>
									</h4>
									<div style="font-size:var(--wp--preset--font-size--13);color:var(--wp--preset--color--text-light)">
										<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
									</div>
								</article>
							<?php endwhile; wp_reset_postdata(); ?>
						</div>
					</div>
				<?php endif; ?>

			</aside>

		</div>
	</div>

	<!-- Comments -->
	<?php if ( comments_open() || get_comments_number() ) : ?>
		<div style="max-width:720px;margin-left:auto;margin-right:auto;padding:var(--wp--preset--spacing--50) var(--wp--preset--spacing--30)">
			<?php comments_template(); ?>
		</div>
	<?php endif; ?>

</main>

<?php
get_footer();
