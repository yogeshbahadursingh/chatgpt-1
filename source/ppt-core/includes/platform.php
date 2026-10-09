<?php
/** Shared relationships, directories and enquiry handling. */
defined('ABSPATH') || exit;
function ppt_content_types(){ return array('ppt_journal','ppt_journal_issue','ppt_article','ppt_author','ppt_research_area','ppt_research_project','ppt_researcher','ppt_publication','ppt_training','ppt_event','ppt_team_member','ppt_partner','post','product'); }
add_action('init',function(){
 foreach(ppt_content_types() as $type) if(post_type_exists($type)) register_taxonomy_for_object_type('ppt_subject_area',$type);
 if(post_type_exists('product')) register_taxonomy_for_object_type('ppt_publication_type','product');
 add_shortcode('ppt_directory','ppt_directory'); add_shortcode('ppt_enquiry','ppt_enquiry');
},20);
function ppt_directory($attrs){
 $a=shortcode_atts(array('type'=>'ppt_research_project','limit'=>12,'topic'=>0),$attrs);
 $types=array_values(array_intersect(explode(',',$a['type']),ppt_content_types())); if(!$types) return '';
 $args=array('post_type'=>$types,'post_status'=>'publish','posts_per_page'=>min(24,max(1,(int)$a['limit'])),'no_found_rows'=>true);
 if($a['topic']) $args['tax_query']=array(array('taxonomy'=>'ppt_subject_area','field'=>'term_id','terms'=>absint($a['topic'])));
 $posts=get_posts(ppt_visible_content_query_args($args)); if(!$posts) return '<p class="ppt-empty">New work is being prepared for this programme. Please check back for updates.</p>';
 $html='<div class="ppt-directory">';
 foreach($posts as $p){
  $obj=get_post_type_object($p->post_type); $url=get_permalink($p);
  $html.='<article class="ppt-pub-card"><a href="'.esc_url($url).'">';
  $html.=has_post_thumbnail($p)?get_the_post_thumbnail($p,'medium',array('loading'=>'lazy')):'<span class="ppt-cover ppt-cover-one">'.esc_html($p->post_title).'</span>';
  $html.='</a><p class="ppt-kicker">'.esc_html($obj->labels->singular_name).'</p><h3><a href="'.esc_url($url).'">'.esc_html($p->post_title).'</a></h3><p>'.esc_html(wp_trim_words(get_the_excerpt($p),28)).'</p>';
  if($p->post_type==='product' && function_exists('wc_get_product')){ $product=wc_get_product($p->ID); if($product) $html.=$product->get_price_html(); }
  $html.='</article>';
 }
 return $html.'</div>';
}
add_action('pre_get_posts',function($q){
 if(is_admin() || !$q->is_main_query()) return;
 if($q->is_search()) $q->set('post_type',array_merge(array('page'),array_filter(ppt_content_types(),'post_type_exists')));
 if(($q->is_archive() || $q->is_home() || $q->is_search()) && !empty($_GET['ppt_topic'])) $q->set('tax_query',array(array('taxonomy'=>'ppt_subject_area','field'=>'term_id','terms'=>absint($_GET['ppt_topic']))));
});
add_action('add_meta_boxes',function(){
 foreach(ppt_content_types() as $type) add_meta_box('ppt-connections','PPT: featuring and related content',function($post){
  wp_nonce_field('ppt_connections','ppt_connections_nonce');
  echo '<p><label><input type="checkbox" name="ppt_featured" value="1" '.checked(get_post_meta($post->ID,'_ppt_featured',true),'1',false).'> Feature on homepage</label></p><p><label for="ppt-related">Related content IDs (comma separated)</label><input class="widefat" id="ppt-related" name="ppt_related" value="'.esc_attr(get_post_meta($post->ID,'_ppt_related',true)).'"></p><p>Shared Subject Areas also connect content automatically.</p>';
  if(get_post_meta($post->ID,'_ppt_demo_content',true)) echo '<p><label><input type="checkbox" name="ppt_keep_demo" value="1"> Keep this record as genuine content (exclude from demo removal)</label></p>';
 },$type,'side');
});
add_action('save_post',function($id){
 if(wp_is_post_revision($id) || !isset($_POST['ppt_connections_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ppt_connections_nonce'])),'ppt_connections') || !current_user_can('edit_post',$id)) return;
 update_post_meta($id,'_ppt_featured',isset($_POST['ppt_featured'])?'1':'0');
 $ids=wp_parse_id_list(wp_unslash($_POST['ppt_related']??'')); update_post_meta($id,'_ppt_related',implode(',',$ids));
 if(!empty($_POST['ppt_keep_demo'])){ delete_post_meta($id,'_ppt_demo_content'); delete_post_meta($id,'_ppt_demo_fingerprint'); }
});
function ppt_related($id){
 $ids=wp_parse_id_list(get_post_meta($id,'_ppt_related',true));
 $args=array('post_type'=>ppt_content_types(),'post_status'=>'publish','posts_per_page'=>6,'post__not_in'=>array($id));
 if($ids) $args['post__in']=$ids;
 else { $terms=wp_get_object_terms($id,'ppt_subject_area',array('fields'=>'ids')); if(is_wp_error($terms)||!$terms) return ''; $args['tax_query']=array(array('taxonomy'=>'ppt_subject_area','terms'=>$terms)); }
 $posts=get_posts(ppt_visible_content_query_args($args)); if(!$posts) return ''; $html='<section class="ppt-related"><h2>Explore connected knowledge</h2><ul>';
 foreach($posts as $p) $html.='<li><a href="'.esc_url(get_permalink($p)).'">'.esc_html($p->post_title).'</a> <span>'.esc_html(get_post_type_object($p->post_type)->labels->singular_name).'</span></li>';
 return $html.'</ul></section>';
}
add_filter('the_content',function($content){
 if(is_singular() && in_the_loop() && is_main_query() && !is_page()){
  if(get_post_meta(get_the_ID(),'_ppt_demo_content',true)) $content='<p class="ppt-demo-notice"><strong>Demonstration content.</strong> This concept is for testing; it is not a claim of completed work or an available programme.</p>'.$content;
  $content.=ppt_related(get_the_ID());
 }
 return $content;
},25);
function ppt_enquiry_categories(){ return array('General','Publishing','Research','Training','Partnership','Books & Orders','Media','Careers'); }
add_action('admin_menu',function(){ add_options_page('PPT Platform','PPT Platform','manage_options','ppt-platform',function(){
 if(!current_user_can('manage_options')) return;
 echo '<div class="wrap"><h1>PPT Platform</h1><form method="post" action="options.php">'; settings_fields('ppt-platform');
 foreach(array('ppt_enquiry_email'=>'Enquiry recipient email','ppt_contact_address'=>'Public contact address','ppt_newsletter_url'=>'Newsletter signup URL','ppt_social_url'=>'Public social profile URL') as $key=>$label) echo '<p><label for="'.esc_attr($key).'">'.esc_html($label).'</label><br><input class="regular-text" id="'.esc_attr($key).'" name="'.esc_attr($key).'" value="'.esc_attr(get_option($key,'')).'"></p>';
 echo '<p><label><input type="checkbox" name="ppt_enquiries_enabled" value="1" '.checked(get_option('ppt_enquiries_enabled'),'1',false).'> Enable enquiries after configuring mail and approving privacy information</label></p>'; submit_button(); echo '</form></div>';
 }); });
add_action('admin_init',function(){
 foreach(array('ppt_enquiry_email'=>'sanitize_email','ppt_contact_address'=>'sanitize_textarea_field','ppt_newsletter_url'=>'esc_url_raw','ppt_social_url'=>'esc_url_raw','ppt_enquiries_enabled'=>'absint') as $key=>$sanitize) register_setting('ppt-platform',$key,array('sanitize_callback'=>$sanitize,'type'=>'string'));
});
function ppt_enquiry(){
 if(!get_option('ppt_enquiries_enabled') || !is_email(get_option('ppt_enquiry_email'))) return '<p class="ppt-empty">Our enquiry service is being prepared. Contact details will appear here when confirmed.</p>';
 $selected=sanitize_text_field(wp_unslash($_GET['enquiry']??'General'));
 $status=sanitize_key($_GET['ppt_message']??'');
 $messages=array('sent'=>'Your enquiry has been accepted for delivery.','failed'=>'We could not send your message. Please try again later.','invalid'=>'Please check the required fields and try again.','limited'=>'Please wait a few minutes before sending another enquiry.');
 ob_start();
 if(isset($messages[$status])) echo '<p role="status">'.esc_html($messages[$status]).'</p>';
 ?>
 <form class="ppt-enquiry" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
 <?php wp_nonce_field('ppt_enquiry','ppt_enquiry_nonce'); ?>
 <input type="hidden" name="action" value="ppt_enquiry"><input type="hidden" name="started" value="<?php echo esc_attr(time()); ?>">
 <p><label for="ppt-name">Your name</label><input required maxlength="120" id="ppt-name" name="name" autocomplete="name"></p>
 <p><label for="ppt-email">Email</label><input required type="email" maxlength="254" id="ppt-email" name="email" autocomplete="email"></p>
 <p><label for="ppt-category">Enquiry category</label><select id="ppt-category" name="category"><?php foreach(ppt_enquiry_categories() as $category) echo '<option '.selected($selected,$category,false).'>'.esc_html($category).'</option>'; ?></select></p>
 <p><label for="ppt-message">Message</label><textarea required minlength="20" maxlength="5000" rows="7" id="ppt-message" name="message"></textarea></p>
 <p class="ppt-honeypot" aria-hidden="true"><label>Leave empty<input name="website" tabindex="-1" autocomplete="off"></label></p>
 <p><label><input required type="checkbox" name="consent" value="1"> I agree to the use of these details to respond to this enquiry.</label> <a href="<?php echo esc_url(home_url('/privacy-policy/')); ?>">Privacy information</a></p>
 <button type="submit">Send enquiry</button></form>
 <?php return ob_get_clean();
}
function ppt_handle_enquiry(){
 $redirect=function($status){wp_safe_redirect(add_query_arg('ppt_message',$status,home_url('/contact/')));exit;};
 if(!isset($_POST['ppt_enquiry_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ppt_enquiry_nonce'])),'ppt_enquiry')) $redirect('invalid');
 $email=sanitize_email(wp_unslash($_POST['email']??'')); $name=sanitize_text_field(wp_unslash($_POST['name']??'')); $message=sanitize_textarea_field(wp_unslash($_POST['message']??'')); $category=sanitize_text_field(wp_unslash($_POST['category']??''));
 if(!get_option('ppt_enquiries_enabled') || !is_email(get_option('ppt_enquiry_email'))) $redirect('failed');
 if(!is_email($email)||!$name||strlen($name)>120||strlen($message)<20||strlen($message)>5000||!in_array($category,ppt_enquiry_categories(),true)||empty($_POST['consent'])||!empty($_POST['website'])||time()-absint($_POST['started']??0)<3) $redirect('invalid');
 $key='ppt_rate_'.hash_hmac('sha256',$_SERVER['REMOTE_ADDR']??'unknown',wp_salt());
 if(get_transient($key)) $redirect('limited'); set_transient($key,1,MINUTE_IN_SECONDS*3);
 $sent=wp_mail(get_option('ppt_enquiry_email'),'PPT enquiry: '.$category,"Name: $name\nEmail: $email\nCategory: $category\n\n$message",array('Reply-To: '.$email));
 $redirect($sent?'sent':'failed');
}
add_action('admin_post_ppt_enquiry','ppt_handle_enquiry'); add_action('admin_post_nopriv_ppt_enquiry','ppt_handle_enquiry');
// Publication file metadata is never a paid-download transport. WooCommerce owns access.
add_filter('get_post_metadata',function($value,$id,$key,$single){
 if($key==='_ppt_publication_file_url' && !is_admin() && (get_post_meta($id,'_ppt_publication_product_id',true) || !get_post_meta($id,'_ppt_publication_is_free',true))) return $single?'':array();
 return $value;
},10,4);
// Additional publication details live in editable metadata; commerce remains native.
add_action('add_meta_boxes',function(){add_meta_box('ppt-book-details','Publication details',function($p){wp_nonce_field('ppt_book_details','ppt_book_nonce');foreach(array('subtitle','author','isbn','publication_date','edition','pages','language','format','contents','author_bio','licence','sample_url')as $field){echo '<p><label for="ppt-book-'.esc_attr($field).'">'.esc_html(ucwords(str_replace('_',' ',$field))).'</label><textarea class="widefat" id="ppt-book-'.esc_attr($field).'" name="ppt_book['.esc_attr($field).']">'.esc_textarea(get_post_meta($p->ID,'_ppt_book_'.$field,true)).'</textarea></p>';}} ,'product','normal');});
add_action('save_post_product',function($id){if(wp_is_post_revision($id)||!current_user_can('edit_post',$id)||empty($_POST['ppt_book_nonce'])||!wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['ppt_book_nonce'])),'ppt_book_details'))return;foreach(array('subtitle','author','isbn','publication_date','edition','pages','language','format','contents','author_bio','licence','sample_url')as $field){$value=wp_unslash($_POST['ppt_book'][$field]??'');update_post_meta($id,'_ppt_book_'.$field,$field==='sample_url'?esc_url_raw($value):sanitize_textarea_field($value));}});
add_action('woocommerce_single_product_summary',function(){global $product;$id=$product->get_id();foreach(array('subtitle','author','format')as $field){$value=get_post_meta($id,'_ppt_book_'.$field,true);if($value)echo '<p>'.esc_html($value).'</p>';}if(ppt_is_demo_product($product))echo '<p class="ppt-demo-notice">'.esc_html(ppt_demo_purchases_allowed()?'Demonstration product — test price and sample content only. Test purchases are enabled in this non-production environment.':'Demonstration product — preview only. Purchases are disabled.').'</p>';},6);
add_filter('woocommerce_product_tabs',function($tabs){global $product;if(!$product)return $tabs;$id=$product->get_id();foreach(array('contents'=>'Contents','author_bio'=>'Author','licence'=>'Licence & downloads')as $field=>$title){if(get_post_meta($id,'_ppt_book_'.$field,true))$tabs['ppt_'.$field]=array('title'=>$title,'priority'=>25,'callback'=>function()use($id,$field){echo wpautop(esc_html(get_post_meta($id,'_ppt_book_'.$field,true)));});}$tabs['ppt_details']=array('title'=>'Publication details','priority'=>30,'callback'=>function()use($id){echo '<dl>';foreach(array('isbn','publication_date','edition','pages','language','format')as $field){$value=get_post_meta($id,'_ppt_book_'.$field,true);if($value)echo '<dt>'.esc_html(ucwords(str_replace('_',' ',$field))).'</dt><dd>'.esc_html($value).'</dd>';}echo '</dl>';$sample=get_post_meta($id,'_ppt_book_sample_url',true);if($sample)echo '<p><a href="'.esc_url($sample).'">Read a public sample</a></p>';});return $tabs;});
add_action('woocommerce_after_single_product_summary',function(){echo ppt_related(get_the_ID());},25);
add_filter('woocommerce_product_single_add_to_cart_text',function($text,$product){return $product->is_type('simple')&&$product->is_downloadable()?'Buy e-book':$text;},10,2);
add_action('admin_notices',function(){if(current_user_can('manage_woocommerce') && class_exists('WooCommerce') && get_option('woocommerce_file_download_method')==='redirect')echo '<div class="notice notice-error"><p>PPT: Redirect-only downloads do not protect paid files. Configure Force downloads or X-Accel-Redirect/X-Sendfile and verify server protection before selling downloads.</p></div>';});

add_filter('woocommerce_product_get_image',function($html,$product){
 if(!$product->get_image_id() && get_post_meta($product->get_id(),'_ppt_demo_content',true)) return '<div class="ppt-cover ppt-demo-cover" role="img" aria-label="'.esc_attr('Demonstration cover: '.$product->get_name()).'"><small>PEOPLE &amp; PLANET THRIVE · DEMONSTRATION</small><strong>'.esc_html($product->get_name()).'</strong></div>';
 return $html;
},10,2);
add_filter('woocommerce_single_product_image_thumbnail_html',function($html){global $product;if($product && !$product->get_image_id() && get_post_meta($product->get_id(),'_ppt_demo_content',true))return $product->get_image('large');return $html;});
