<?php
/** Shared presentation components; editorial content and commercial data remain native. */
defined('ABSPATH') || exit;
add_action('wp_enqueue_scripts',function(){wp_enqueue_style('ppt-experience',PPT_THEME_URI.'/assets/css/customer-experience.css',array('ppt-branding'),PPT_THEME_VERSION);},50);
add_action('after_setup_theme',function(){add_editor_style('assets/css/customer-experience.css');});
add_action('init',function(){add_shortcode('ppt_page_breadcrumb',function(){return '<nav class="ppt-breadcrumb" aria-label="Breadcrumb"><a href="'.esc_url(home_url('/')).'">Home</a><span aria-hidden="true"> / </span><span aria-current="page">'.esc_html(get_the_title()).'</span></nav>';});});
add_filter('body_class',function($classes){$classes[]='ppt-experience';return $classes;});
// Useful next actions on institutional and research pages; no duplicated editorial content.
add_filter('the_content',function($content){
 if(is_admin()||!in_the_loop()||!is_main_query()||!function_exists('ppt_enquiry_url'))return $content;
 if(is_page(array('about','mission-vision','our-approach','leadership','for-authors','accessibility'))){$category=is_page('for-authors')?'Publishing':'General';$content.='<aside class="ppt-cx-next"><h2>Take the next step</h2><p><a href="'.esc_url(is_page('for-authors')?ppt_enquiry_url($category):home_url('/work-with-us/')).'">'.(is_page('for-authors')?'Discuss a publication proposal':'Explore ways to work with us').'</a></p></aside>';}
 if(is_singular(array('ppt_research_project','ppt_research_area','ppt_researcher')))$content.='<aside class="ppt-cx-next"><h2>Develop a question together</h2><p><a href="'.esc_url(ppt_enquiry_url('Research',get_the_ID())).'">Discuss a related research project</a></p></aside>';
 return $content;
},30);
// Show entry status before a visitor follows a demonstration into a detail page.
function ppt_content_access_label($id){
 if(get_post_meta($id,'_ppt_demo_content',true))return 'Demonstration — preview';
 if(get_post_type($id)==='product'&&function_exists('wc_get_product')){$p=wc_get_product($id);if($p)return $p->is_downloadable()?((float)$p->get_price()===0?'Free digital resource':'Digital edition'):'Print edition';}
 return '';
}
function ppt_catalog_meta($id){
 $product=get_post_type($id)==='product';$author=get_post_meta($id,$product?'_ppt_book_author':'_ppt_publication_editors',true);$format=get_post_meta($id,$product?'_ppt_book_format':'_ppt_publication_format',true);$label=ppt_content_access_label($id);$html='';
 if($label)$html.='<p class="ppt-status-label">'.esc_html($label).'</p>';
 if($author)$html.='<p class="ppt-catalog-meta">'.esc_html(($product?'By ':'Authors / editors: ').$author).'</p>';
 if($format)$html.='<p class="ppt-catalog-meta">'.esc_html($format).'</p>';
 return $html;
}
add_action('woocommerce_single_product_summary',function(){global $product;if(!$product)return;echo '<div class="ppt-cx-next"><p>'.esc_html($product->is_downloadable()?'Digital edition. Eligible orders receive a protected download link on the order confirmation and in the order email. Check the stated licence and download limits.':($product->is_virtual()?'This is a service or virtual item. Check the description and participation terms before ordering.':'Physical edition. Available delivery methods and charges are calculated at checkout for your address.')).'</p>';if(function_exists('ppt_enquiry_url'))echo '<a href="'.esc_url(ppt_enquiry_url('Books & Orders',$product->get_id())).'">Ask about this title or an order</a>';echo '</div>';},35);
add_action('woocommerce_thankyou',function($order_id){$order=wc_get_order($order_id);if($order&&function_exists('ppt_enquiry_url'))echo '<p class="ppt-cx-next">Need help with your order? <a href="'.esc_url(ppt_enquiry_url('Books & Orders')).'">Contact order support</a> and include your order reference.</p>';});
add_filter('render_block_core/post-excerpt',function($html,$block){if(is_search()&&get_post_meta(get_the_ID(),'_ppt_demo_content',true))$html='<p class="ppt-status-label">Demonstration — preview</p>'.$html;return $html;},10,2);
