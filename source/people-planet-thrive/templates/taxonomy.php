<?php
/** Mixed scholarly, research and product taxonomy results. */
defined('ABSPATH') || exit;
get_header(); ?>
<main class="site-main ppt-section"><div class="alignwide">
<p class="ppt-kicker">Explore connected knowledge</p>
<h1><?php single_term_title(); ?></h1>
<?php echo wp_kses_post(term_description()); ?>
<?php if(have_posts()): ?><div class="ppt-directory">
<?php while(have_posts()): the_post(); $ppt_type=get_post_type_object(get_post_type()); ?>
<article class="ppt-pub-card">
<p class="ppt-kicker"><?php echo esc_html($ppt_type->labels->singular_name); ?></p>
<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
<?php if(has_post_thumbnail()) the_post_thumbnail('medium',array('loading'=>'lazy')); ?>
<p><?php echo esc_html(wp_trim_words(get_the_excerpt(),30)); ?></p>
</article>
<?php endwhile; ?></div><?php the_posts_pagination(); ?>
<?php else: ?><p class="ppt-empty">New work is being prepared for this subject.</p><?php endif; ?>
</div></main><?php get_footer(); ?>
