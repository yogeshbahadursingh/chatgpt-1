<?php
/** Editable collaboration blocks and conservative, explicit upgrade tools. */
defined('ABSPATH') || exit;
function ppt_cx_paragraph($text,$class=''){return '<!-- wp:paragraph '.wp_json_encode(array('className'=>$class)).' --><p'.($class?' class="'.esc_attr($class).'"':'').'>'.$text.'</p><!-- /wp:paragraph -->';}
function ppt_cx_heading($text,$level=2){return '<!-- wp:heading '.wp_json_encode(array('level'=>$level)).' --><h'.$level.' class="wp-block-heading">'.esc_html($text).'</h'.$level.'><!-- /wp:heading -->';}
function ppt_cx_group($content,$class,$align=''){return '<!-- wp:group '.wp_json_encode(array_filter(array('className'=>$class,'align'=>$align))).' --><div class="wp-block-group '.($align?'align'.esc_attr($align).' ':'').esc_attr($class).'">'.$content.'</div><!-- /wp:group -->';}
function ppt_collaboration_content(){
 $intro=ppt_cx_paragraph('Publish meaningful work, build research partnerships and create learning opportunities. Choose how you would like to get involved.','ppt-big-copy');
 $intro.=ppt_cx_paragraph('<a class="ppt-action" href="#pathways">Find your pathway <span aria-hidden="true">↗</span></a> <a href="'.esc_url(add_query_arg('enquiry','General',home_url('/work-with-us/'))).'#ppt-enquiry">Not sure which route?</a>','ppt-cx-actions');
 $paths=array(
  array('Publish with us','Publishing','Authors and editors','Develop a journal article, book or practical resource.','Prepare an audience, working title and outline.','Propose a publication'),
  array('Research with us','Research','Researchers and practitioners','Develop a question or method around a shared challenge.','Prepare the research question, context and kind of collaboration.','Discuss a research project'),
  array('Partner with us','Partnership','Organisations and communities','Explore a shared programme or knowledge exchange.','Prepare the purpose, participants and resources you could contribute.','Explore a partnership'),
  array('Train with us','Training','Trainers and organisations','Propose a course, workshop or professional learning programme.','Prepare your expertise, audience and preferred delivery mode.','Propose a training programme'),
  array('Learn with us','Learning','Learners and professional teams','Explore learning opportunities that fit your interests.','Check the audience, dates, format and participation details.','Find learning opportunities'),
  array('Write & contribute','Editorial','Writers and subject specialists','Propose a concise, evidence-informed insight.','Prepare a short pitch, intended readers and supporting sources.','Pitch an insight')
 );$cards='';
 foreach($paths as $i=>$p){$url=$p[1]==='Learning'?(get_post_type_archive_link('ppt_training')?:home_url('/training/')):add_query_arg('enquiry',$p[1],home_url('/work-with-us/')).'#ppt-enquiry';$card=ppt_cx_paragraph(sprintf('%02d',$i+1).' / '.esc_html($p[2]),'ppt-kicker').ppt_cx_heading($p[0],3).ppt_cx_paragraph(esc_html($p[3])).ppt_cx_paragraph('<strong>What to prepare</strong><br>'.esc_html($p[4]),'ppt-pathway-prepare').ppt_cx_paragraph('<a href="'.esc_url($url).'">'.esc_html($p[5]).' <span aria-hidden="true">→</span></a>','ppt-pathway-action');$cards.=ppt_cx_group($card,'ppt-pathway');}
 $section='<!-- wp:group {"anchor":"pathways","className":"ppt-pathways-section"} --><div id="pathways" class="wp-block-group ppt-pathways-section">'.ppt_cx_paragraph('Six routes. A shared purpose.','ppt-kicker').ppt_cx_heading('Find your way to contribute').ppt_cx_group($cards,'ppt-pathways').'</div><!-- /wp:group -->';
 $next=ppt_cx_heading('What happens next').ppt_cx_group(ppt_cx_group(ppt_cx_heading('01 / Tell us your idea',3).ppt_cx_paragraph('Choose a pathway and send a short introduction. There is no need to create an account or upload a manuscript.'),'ppt-next-step').ppt_cx_group(ppt_cx_heading('02 / Keep your reference',3).ppt_cx_paragraph('After your enquiry is saved, you will see a reference on screen. Keep it if you need to follow up.'),'ppt-next-step').ppt_cx_group(ppt_cx_heading('03 / Explore the fit',3).ppt_cx_paragraph('The team can use your email to request more information and discuss a suitable next step. An enquiry is not acceptance, a booking or a contract.'),'ppt-next-step'),'ppt-next-steps');
 $faq=ppt_cx_heading('Before you get in touch');foreach(array('Can I send a full manuscript?'=>'Start with a short publishing enquiry. Please do not paste confidential research or participant data. The team can discuss an appropriate route for any further material.','Is an enquiry a commitment?'=>'No. A proposal or expression of interest does not confirm acceptance, fees, a partnership or a place on a programme. Check the relevant offering for confirmed terms.','What if there is no suitable training?'=>'Use the Learning pathway to describe your interests and availability. This is an expression of interest, not a booking.')as $q=>$a)$faq.='<!-- wp:details --><details class="wp-block-details"><summary>'.esc_html($q).'</summary>'.ppt_cx_paragraph(esc_html($a)).'</details><!-- /wp:details -->';
 return ppt_cx_group($intro.$section.ppt_cx_group($next,'ppt-next-panel').$faq.'<!-- wp:shortcode -->[ppt_enquiry]<!-- /wp:shortcode -->'.ppt_cx_paragraph('Not sure where to begin? <a href="'.esc_url(ppt_enquiry_url()).'">Send a general enquiry</a>.','ppt-general-enquiry'),'ppt-collaboration','wide');
}
add_action('init',function(){register_block_pattern_category('ppt-journeys',array('label'=>'PPT visitor journeys'));register_block_pattern('ppt/collaboration',array('title'=>'PPT collaboration pathways and enquiry','categories'=>array('ppt-journeys'),'content'=>ppt_collaboration_content()));});
function ppt_upgrade_customer_experience($apply=false){
 if(!current_user_can('manage_options'))return new WP_Error('forbidden','Administrator access required.');
 $page=get_page_by_path('work-with-us');if(!$page)return array('status'=>'missing','message'=>'Run PPT Site Setup to create the missing page.');
 if($page->post_content===ppt_collaboration_content())return array('status'=>'current','message'=>'The current collaboration pattern is already present.');
 if(get_post_meta($page->ID,'_ppt_cx_version',true)==='2.4.0')return array('status'=>'current','message'=>'The collaboration journey has already been applied. Later editorial changes are preserved.');
 $hash=hash('sha256',str_replace(home_url(),'{{home}}',$page->post_content));
 if($hash!=='d84b51b294ccf32795404d2d046c29d7a855656875d0534663f481b945aef31d'||$page->post_title!=='Work With Us')return array('status'=>'manual','message'=>'This page differs from the unedited setup copy. Preserve it and merge the PPT collaboration pattern in the page editor.');
 if(!$apply)return array('status'=>'ready','message'=>'The unedited Work With Us starter can be upgraded. Its current content will be saved as a revision and backup metadata.');
 wp_save_post_revision($page->ID);update_post_meta($page->ID,'_ppt_cx_backup',array('title'=>$page->post_title,'content'=>$page->post_content));
 $id=wp_update_post(array('ID'=>$page->ID,'post_title'=>'Work with People & Planet Thrive','post_content'=>ppt_collaboration_content()),true);if(is_wp_error($id))return $id;
 update_post_meta($id,'_ppt_cx_version','2.4.0');return array('status'=>'updated','message'=>'Work With Us upgraded. Review its copy, privacy notice, enquiry settings and mail delivery on staging.');
}
add_action('admin_menu',function(){add_management_page('PPT Experience Update','PPT Experience Update','manage_options','ppt-experience',function(){if(!current_user_can('manage_options'))return;$result=ppt_upgrade_customer_experience(false);if(isset($_POST['ppt_apply_cx'])){check_admin_referer('ppt_apply_cx');$result=ppt_upgrade_customer_experience(true);}echo '<div class="wrap"><h1>PPT Experience Update</h1><p>'.esc_html(is_wp_error($result)?$result->get_error_message():$result['message']).'</p><p>This tool never resets saved templates, global styles, navigation, users, orders or edited pages. Export Site Editor customisations and compare them with the updated theme before merging.</p>';if(!is_wp_error($result)&&$result['status']==='ready'){echo '<form method="post">';wp_nonce_field('ppt_apply_cx');submit_button('Upgrade the unedited collaboration page','primary','ppt_apply_cx');echo '</form>';}echo '<p>Review private submissions under Enquiries. Configure delivery and enable the service in Settings → PPT Platform only after approving the storage/privacy notice.</p></div>';});});

/** Existing fields remain authoritative; a registration link is not proof of an open booking. */
function ppt_opportunity_state($id){
 $prefix=get_post_type($id)==='ppt_event'?'_ppt_event_':'_ppt_training_';$end=get_post_meta($id,$prefix.'end_date',true)?:get_post_meta($id,$prefix.'start_date',true);
 if(get_post_meta($id,'_ppt_demo_content',true))return 'Demonstration — not open for booking';
 if($end&&strtotime($end.' 23:59:59')<current_time('timestamp'))return 'This session has ended';
 if(!get_post_meta($id,$prefix.'start_date',true))return 'Dates to be confirmed';
 return 'Check participation details';
}
function ppt_opportunity_action($id){
 $prefix=get_post_type($id)==='ppt_event'?'_ppt_event_':'_ppt_training_';$state=ppt_opportunity_state($id);$url='';$label='Ask about future opportunities';
 if($state==='Check participation details'){
  $product_id=(int)get_post_meta($id,$prefix.'product_id',true);$product=function_exists('wc_get_product')?wc_get_product($product_id):false;
  if($product&&$product->is_visible()&&$product->is_purchasable()&&$product->is_in_stock()&&!(function_exists('ppt_store_prelaunch_for_visitor')&&ppt_store_prelaunch_for_visitor())){$url=$product->get_permalink();$label='View booking options';}
  if(!$url){$url=get_post_meta($id,$prefix.'registration_url',true);if($url)$label='View registration details';}
 }
 if(!$url)$url=ppt_enquiry_url('Learning',$id);
 return '<div class="ppt-opportunity-status"><p><strong>'.esc_html($state).'</strong></p><a class="wp-block-button__link wp-element-button" href="'.esc_url($url).'">'.esc_html($label).'</a><p class="ppt-field-hint">Participation is confirmed only through the stated booking or registration process.</p></div>';
}
function ppt_opportunity_fee($id){$prefix=get_post_type($id)==='ppt_event'?'_ppt_event_':'_ppt_training_';if(get_post_meta($id,'_ppt_demo_content',true))return 'Illustrative programme';if(get_post_meta($id,$prefix.'is_free',true)==='1')return 'Free';$price=get_post_meta($id,$prefix.'price',true);return $price?('Fee: '.$price.' — confirm currency and terms with the organiser'):'Fee details to be confirmed';}

// Demo indexing is an explicit operator choice; never infer it from a slug.
add_action('admin_init',function(){register_setting('ppt-platform','ppt_exclude_demo_indexing',array('type'=>'boolean','sanitize_callback'=>'rest_sanitize_boolean'));});
add_filter('wp_robots',function($robots){if(get_option('ppt_exclude_demo_indexing')&&is_singular()&&get_post_meta(get_queried_object_id(),'_ppt_demo_content',true)){$robots['noindex']=true;unset($robots['index']);}return $robots;});
add_filter('wp_sitemaps_posts_query_args',function($args,$type){if(get_option('ppt_exclude_demo_indexing')&&in_array($type,ppt_content_types(),true))$args['meta_query']=array('relation'=>'AND',$args['meta_query']??array(),array('relation'=>'OR',array('key'=>'_ppt_demo_content','compare'=>'NOT EXISTS'),array('key'=>'_ppt_demo_content','value'=>'1','compare'=>'!=')));return $args;},10,2);
// Demonstration records are examples, not real scholarly works or sale offers.
add_filter('ppt_schema_output',function($schema){if(is_singular()&&get_post_meta(get_queried_object_id(),'_ppt_demo_content',true))$schema=array_values(array_filter($schema,function($entry){return in_array($entry['@type']??'',array('Organization','BreadcrumbList'),true);}));return $schema;});
add_filter('woocommerce_structured_data_product',function($schema,$product){return get_post_meta($product->get_id(),'_ppt_demo_content',true)?array():$schema;},20,2);
