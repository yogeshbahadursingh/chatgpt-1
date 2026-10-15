<?php
/** Private enquiries with progressive-enhancement, durable acceptance and staff-only access. */
defined('ABSPATH') || exit;

function ppt_enquiry_paths() {
 return array(
  'General'=>array('General enquiry — help me choose','Tell us what you want to achieve and where you need guidance.'),
  'Publishing'=>array('Propose a publication','Include the intended audience, format, working title and a short outline.'),
  'Research'=>array('Discuss a research project','Describe the research question, context and collaboration you seek.'),
  'Partnership'=>array('Explore a partnership','Describe the purpose, participants and resources you could contribute.'),
  'Training'=>array('Propose a training programme','Share your expertise, intended audience and preferred delivery mode.'),
  'Learning'=>array('Find learning opportunities','Tell us your interests, experience, availability and access needs.'),
  'Editorial'=>array('Pitch an insight','Include a short pitch, intended readers and the sources you plan to use.'),
  'Books & Orders'=>array('Books and order support','Include a title or order reference if relevant. Never send payment-card details.'),
  'Media'=>array('Media enquiry','Describe the topic and the information you need.'),
  'Careers'=>array('Careers interest','Describe your field, potential contribution and availability. This is not a job application to an advertised vacancy.')
 );
}
function ppt_enquiry_categories(){return array_keys(ppt_enquiry_paths());}
function ppt_enquiry_url($category='General',$context=0) {
 $page=get_page_by_path('contact'); $url=$page?get_permalink($page):home_url('/contact/');
 return add_query_arg(array_filter(array('enquiry'=>$category,'context'=>absint($context))),$url).'#ppt-enquiry';
}
function ppt_enquiry_value($data,$key){return isset($data[$key])&&is_scalar($data[$key])?sanitize_text_field(wp_unslash((string)$data[$key])):'';}
function ppt_enquiry_ticket(){ $issued=time();$id=wp_generate_password(32,false,false);return $issued.'.'.$id.'.'.hash_hmac('sha256',$issued.'.'.$id,wp_salt('nonce')); }
function ppt_enquiry_ticket_valid($ticket){$p=explode('.',$ticket);return count($p)===3&&ctype_digit($p[0])&&time()-(int)$p[0]>=1&&time()-(int)$p[0]<7200&&hash_equals(hash_hmac('sha256',$p[0].'.'.$p[1],wp_salt('nonce')),$p[2]);}
function ppt_enquiry_context($id){$p=get_post(absint($id));return $p&&$p->post_status==='publish'&&in_array($p->post_type,array('ppt_training','ppt_event','ppt_journal','ppt_research_project','ppt_research_area','ppt_researcher','ppt_publication','product'),true)?$p:null;}

add_action('init',function(){
 $caps=array_fill_keys(array('edit_post','read_post','delete_post','edit_posts','edit_others_posts','publish_posts','read_private_posts','delete_posts','delete_private_posts','delete_published_posts','delete_others_posts','edit_private_posts','edit_published_posts'),'manage_ppt_enquiries');$caps['create_posts']='do_not_allow';
 register_post_type('ppt_enquiry_record',array('labels'=>array('name'=>'Enquiries','singular_name'=>'Enquiry'),'public'=>false,'publicly_queryable'=>false,'exclude_from_search'=>true,'show_ui'=>true,'show_in_rest'=>false,'rewrite'=>false,'query_var'=>false,'supports'=>array(),'capabilities'=>$caps,'map_meta_cap'=>false,'menu_icon'=>'dashicons-email-alt'));
 if(!get_option('ppt_enquiry_cap_installed')){ $role=get_role('administrator');if($role){$role->add_cap('manage_ppt_enquiries');update_option('ppt_enquiry_cap_installed',1,false);} }
 if(!wp_next_scheduled('ppt_enquiry_cleanup'))wp_schedule_event(time()+DAY_IN_SECONDS,'daily','ppt_enquiry_cleanup');
});
add_filter('wp_insert_post_data',function($data){if($data['post_type']==='ppt_enquiry_record'&&$data['post_status']!=='trash')$data['post_status']='private';return $data;});
add_action('ppt_enquiry_cleanup',function(){global $wpdb;$keys=$wpdb->get_col($wpdb->prepare("SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s",$wpdb->esc_like('ppt_enq_lock_').'%'));foreach($keys as $key){$lock=get_option($key);if((int)($lock['created']??0)<time()-DAY_IN_SECONDS)delete_option($key);}});

function ppt_notify_enquiry($id){
 $p=get_post($id);if(!$p||$p->post_type!=='ppt_enquiry_record')return false;
 $email=get_post_meta($id,'_ppt_email',true);$category=get_post_meta($id,'_ppt_category',true);
 $body='Reference: PPT-'.$id."\nPathway: ".$category."\nName: ".get_post_meta($id,'_ppt_name',true)."\nEmail: ".$email."\nOrganisation: ".get_post_meta($id,'_ppt_organisation',true)."\nContext: ".get_post_meta($id,'_ppt_context',true)."\n\n".$p->post_content."\n\nReview securely: ".admin_url('post.php?post='.$id.'&action=edit');
 $sent=wp_mail(get_option('ppt_enquiry_email'),'PPT enquiry '.$id.': '.$category,$body,array('Reply-To: '.$email));
 update_post_meta($id,'_ppt_notification',$sent?'accepted_by_mail_transport':'failed');return $sent;
}
function ppt_process_enquiry($input,$ip){
 // Prefix public form fields so WordPress does not interpret them as route query variables.
 foreach(array('name','email','organisation','category','message','consent','context','ticket','website')as $field)if(isset($input['ppt_'.$field]))$input[$field]=$input['ppt_'.$field];
 $v=array();foreach(array('name','email','organisation','category','consent','context')as $key)$v[$key]=ppt_enquiry_value($input,$key);
 $v['message']=isset($input['message'])&&is_scalar($input['message'])?sanitize_textarea_field(wp_unslash((string)$input['message'])):'';
 $errors=array();$length=function($s){return function_exists('mb_strlen')?mb_strlen($s):strlen($s);};
 if(!wp_verify_nonce(ppt_enquiry_value($input,'ppt_enquiry_nonce'),'ppt_enquiry'))$errors['form']='This form expired. Your details are retained; please review them and send again.';
 if(!get_option('ppt_enquiries_enabled')||!is_email(get_option('ppt_enquiry_email')))$errors['form']='Enquiries are not available at the moment. Your details have not been saved; please try again later.';
 if(!$v['name']||$length($v['name'])>120)$errors['name']='Enter your name (up to 120 characters).';
 if(!is_email($v['email'])||strlen($v['email'])>254)$errors['email']='Enter a valid email address.';
 if($length($v['organisation'])>160)$errors['organisation']='Use up to 160 characters for the organisation.';
 if(!in_array($v['category'],ppt_enquiry_categories(),true))$errors['category']='Choose a pathway from the list.';
 if($length($v['message'])<20||$length($v['message'])>5000)$errors['message']='Enter between 20 and 5,000 characters.';
 if($v['consent']!=='1')$errors['consent']='Confirm that we may use these details to respond.';
 if(ppt_enquiry_value($input,'website')||!ppt_enquiry_ticket_valid(ppt_enquiry_value($input,'ticket')))$errors['form']='Please review your details and send the form again.';
 $rate='ppt_enq_rate_'.hash_hmac('sha256',$ip,wp_salt());$attempts=(int)get_transient($rate);
 if($attempts>=12)$errors['form']='Too many attempts. Please wait 15 minutes before trying again. Your details are retained.';
 if(!isset($errors['form']))set_transient($rate,$attempts+1,15*MINUTE_IN_SECONDS);
 if($errors)return array('ok'=>false,'errors'=>$errors,'values'=>$v);
 // Atomic fingerprint lock prevents double-clicks/retries from creating duplicate records.
 $key='ppt_enq_lock_'.hash_hmac('sha256',wp_json_encode(array(strtolower($v['email']),$v['category'],$v['message'],$v['organisation'],$v['context'])),wp_salt());
 $old=get_option($key);if($old&&($old['created']??0)<time()-DAY_IN_SECONDS){delete_option($key);$old=false;}
 if($old&&!empty($old['id'])&&get_post_type($old['id'])==='ppt_enquiry_record'&&get_post_status($old['id'])==='private')return array('ok'=>true,'id'=>(int)$old['id'],'duplicate'=>true);
 if($old&&!empty($old['id']))delete_option($key);
 if(!add_option($key,array('created'=>time(),'id'=>0),'',false))return array('ok'=>false,'errors'=>array('form'=>'Your previous submission is still being processed. Please wait a moment and try again.'),'values'=>$v);
 $id=wp_insert_post(array('post_type'=>'ppt_enquiry_record','post_status'=>'private','post_title'=>$v['category'].' enquiry — '.current_time('Y-m-d H:i'),'post_content'=>$v['message']),true);
 if(is_wp_error($id)||!$id){delete_option($key);return array('ok'=>false,'errors'=>array('form'=>'We could not save your enquiry. Your details are retained. Please try again.'),'values'=>$v);}
 foreach(array('name','email','organisation','category')as $field)update_post_meta($id,'_ppt_'.$field,$v[$field]);
 $context=ppt_enquiry_context($v['context']);update_post_meta($id,'_ppt_context',$context?get_permalink($context):'');
 update_post_meta($id,'_ppt_consent_at',current_time('mysql',true));update_post_meta($id,'_ppt_notification','pending');
 update_option($key,array('created'=>time(),'id'=>$id),false);ppt_notify_enquiry($id);
 return array('ok'=>true,'id'=>$id,'duplicate'=>false);
}
function ppt_enquiry_receipt($id){$token=wp_generate_password(40,false,false);set_transient('ppt_receipt_'.hash('sha256',$token),array('reference'=>'PPT-'.absint($id)),30*MINUTE_IN_SECONDS);return $token;}
add_action('template_redirect',function(){
 $has_form=is_page()&&(has_shortcode(get_post()->post_content,'ppt_enquiry')||in_array(get_post()->post_name,array('contact','work-with-us','submit-manuscript','careers'),true));
 if($has_form||(function_exists('is_account_page')&&(is_account_page()||is_cart()||is_checkout()))){if(!defined('DONOTCACHEPAGE'))define('DONOTCACHEPAGE',true);nocache_headers();header('Cache-Control: private, no-store, max-age=0');}
 if(($_SERVER['REQUEST_METHOD']??'GET')==='POST'&&ppt_enquiry_value($_POST,'action')==='ppt_enquiry'&&$has_form){
  $result=ppt_process_enquiry($_POST,$_SERVER['REMOTE_ADDR']??'unknown');
  if($result['ok']){wp_safe_redirect(add_query_arg('ppt_receipt',ppt_enquiry_receipt($result['id']),get_permalink()).'#ppt-enquiry',303);exit;}
  $GLOBALS['ppt_enquiry_result']=$result;status_header(422);
 }
});
// Old cached forms remain usable; failures show retained fields, never a misleading redirect toast.
function ppt_handle_enquiry(){
 $result=ppt_process_enquiry($_POST,$_SERVER['REMOTE_ADDR']??'unknown');
 if($result['ok']){wp_safe_redirect(add_query_arg('ppt_receipt',ppt_enquiry_receipt($result['id']),home_url('/contact/')).'#ppt-enquiry',303);exit;}
 $GLOBALS['ppt_enquiry_result']=$result;wp_die(ppt_enquiry(),'Review your enquiry',array('response'=>422,'back_link'=>false));
}
add_action('admin_post_ppt_enquiry','ppt_handle_enquiry');add_action('admin_post_nopriv_ppt_enquiry','ppt_handle_enquiry');

function ppt_enquiry(){
 $result=$GLOBALS['ppt_enquiry_result']??array();$errors=$result['errors']??array();
 $receipt=ppt_enquiry_value($_GET,'ppt_receipt');$saved=$receipt?get_transient('ppt_receipt_'.hash('sha256',$receipt)):false;
 if($saved)return '<section id="ppt-enquiry" class="ppt-enquiry-confirmation" tabindex="-1" role="status"><h2>Enquiry received</h2><p>Your enquiry has been saved for the team to review. Your reference is <strong>'.esc_html($saved['reference']).'</strong>.</p><p>We will use the email address you supplied if we need more information. This confirmation does not imply acceptance of a proposal, a booking or a purchase.</p><p><a href="'.esc_url(home_url('/contact/')).'">Start another enquiry</a> · <a href="'.esc_url(home_url('/work-with-us/')).'">Explore collaboration routes</a></p></section>';
 if(!$errors&&(!get_option('ppt_enquiries_enabled')||!is_email(get_option('ppt_enquiry_email'))))return '<section id="ppt-enquiry" class="ppt-empty"><h2>Enquiries are not open yet</h2><p>We are preparing our enquiry service. Please explore the published guidance and return when contact arrangements are confirmed.</p><p><a href="'.esc_url(home_url('/for-authors/')).'">Read author guidance</a> · <a href="'.esc_url(get_post_type_archive_link('ppt_training')).'">Explore learning</a></p></section>';
 $selected=ppt_enquiry_value($_GET,'enquiry');if(!$selected){$selected=is_page('submit-manuscript')?'Publishing':(is_page('careers')?'Careers':'General');}
 $v=array_merge(array('name'=>'','email'=>'','organisation'=>'','message'=>'','category'=>in_array($selected,ppt_enquiry_categories(),true)?$selected:'General','consent'=>'','context'=>ppt_enquiry_value($_GET,'context')),$result['values']??array());
 $context=ppt_enquiry_context($v['context']);$paths=ppt_enquiry_paths();
 $field_attrs=function($field)use($errors){return isset($errors[$field])?' aria-invalid="true" aria-describedby="ppt-'.$field.'-error"':'';};
 $error=function($field)use($errors){if(isset($errors[$field]))echo '<span class="ppt-field-error" id="ppt-'.esc_attr($field).'-error">'.esc_html($errors[$field]).'</span>';};
 ob_start(); ?>
 <section id="ppt-enquiry" class="ppt-enquiry-panel"><p class="ppt-kicker">Start a conversation</p><h2>Your enquiry</h2><p>Choose a pathway and share a short introduction. No account or document upload is needed.</p>
 <?php if($context)echo '<p class="ppt-enquiry-context">About: <a href="'.esc_url(get_permalink($context)).'">'.esc_html($context->post_title).'</a></p>'; ?>
 <?php if($errors){echo '<div class="ppt-error-summary" role="alert" tabindex="-1"><h3>Please check your enquiry</h3><ul>';foreach($errors as $field=>$message)echo '<li>'.($field==='form'?esc_html($message):'<a href="#ppt-'.esc_attr($field).'">'.esc_html($message).'</a>').'</li>';echo '</ul></div>';} ?>
 <form class="ppt-enquiry" method="post" action="<?php echo esc_url(is_page()?get_permalink():home_url('/contact/')); ?>#ppt-enquiry">
 <?php wp_nonce_field('ppt_enquiry','ppt_enquiry_nonce',false); ?>
 <input type="hidden" name="action" value="ppt_enquiry"><input type="hidden" name="ppt_ticket" value="<?php echo esc_attr(ppt_enquiry_ticket()); ?>"><input type="hidden" name="ppt_context" value="<?php echo $context?absint($context->ID):0; ?>">
 <div class="ppt-form-pair"><p><label for="ppt-name">Name <span>(required)</span></label><input required maxlength="120" id="ppt-name" name="ppt_name" autocomplete="name" value="<?php echo esc_attr($v['name']); ?>"<?php echo $field_attrs('name'); ?>><?php $error('name'); ?></p>
 <p><label for="ppt-email">Email <span>(required)</span></label><input required type="email" maxlength="254" id="ppt-email" name="ppt_email" autocomplete="email" value="<?php echo esc_attr($v['email']); ?>"<?php echo $field_attrs('email'); ?>><?php $error('email'); ?></p></div>
 <p><label for="ppt-category">Pathway <span>(required)</span></label><select id="ppt-category" name="ppt_category" aria-describedby="ppt-pathway-hint<?php echo isset($errors['category'])?' ppt-category-error':''; ?>"<?php echo isset($errors['category'])?' aria-invalid="true"':''; ?>><?php foreach($paths as $key=>$path)echo '<option value="'.esc_attr($key).'" data-hint="'.esc_attr($path[1]).'" '.selected($v['category'],$key,false).'>'.esc_html($path[0]).'</option>'; ?></select><span class="ppt-field-hint" id="ppt-pathway-hint"><?php echo esc_html(($paths[$v['category']]??$paths['General'])[1]); ?></span><?php $error('category'); ?></p>
 <p><label for="ppt-organisation">Organisation <span>(optional)</span></label><input id="ppt-organisation" name="ppt_organisation" autocomplete="organization" maxlength="160" value="<?php echo esc_attr($v['organisation']); ?>"<?php echo $field_attrs('organisation'); ?>><?php $error('organisation'); ?></p>
 <p><label for="ppt-message">Brief message <span>(required)</span></label><textarea required minlength="20" maxlength="5000" rows="6" id="ppt-message" name="ppt_message" aria-describedby="ppt-message-hint<?php echo isset($errors['message'])?' ppt-message-error':''; ?>"<?php echo isset($errors['message'])?' aria-invalid="true"':''; ?>><?php echo esc_textarea($v['message']); ?></textarea><span id="ppt-message-hint" class="ppt-field-hint">20–5,000 characters. Please leave out confidential research data, sensitive personal information and payment details.</span><?php $error('message'); ?></p>
 <p class="ppt-honeypot" hidden aria-hidden="true"><label>Leave empty<input name="ppt_website" tabindex="-1" autocomplete="off"></label></p>
 <p class="ppt-consent"><input required type="checkbox" id="ppt-consent" name="ppt_consent" value="1" <?php checked($v['consent'],'1'); ?><?php echo $field_attrs('consent'); ?>><label for="ppt-consent">I agree to the use of these details to respond to this enquiry. <a href="<?php echo esc_url(get_privacy_policy_url()?:home_url('/privacy-policy/')); ?>">Privacy information</a></label><?php $error('consent'); ?></p>
 <p class="ppt-field-hint">Your message is stored privately for authorised staff and a notification is sent to the configured team inbox. It does not subscribe you to marketing.</p>
 <button type="submit">Send enquiry</button><span class="ppt-submit-status" role="status" aria-live="polite"></span>
 </form></section>
 <?php return ob_get_clean();
}
add_action('wp_enqueue_scripts',function(){wp_enqueue_script('ppt-enquiries',PPT_CORE_URL.'assets/js/enquiries.js',array(),PPT_CORE_VERSION,true);});
add_action('add_meta_boxes_ppt_enquiry_record',function(){add_meta_box('ppt-enquiry-details','Private enquiry',function($p){if(!current_user_can('manage_ppt_enquiries'))return;echo '<dl>';foreach(array('name','email','organisation','category','context','consent_at','notification')as $field)echo '<dt><strong>'.esc_html(ucwords(str_replace('_',' ',$field))).'</strong></dt><dd>'.esc_html(get_post_meta($p->ID,'_ppt_'.$field,true)).'</dd>';echo '</dl><h3>Message</h3>'.wpautop(esc_html($p->post_content));if(get_post_meta($p->ID,'_ppt_notification',true)==='failed')echo '<p>Saved successfully; notification failed. Check mail configuration.</p><a class="button" href="'.esc_url(wp_nonce_url(admin_url('admin-post.php?action=ppt_retry_enquiry&id='.$p->ID),'ppt_retry_'.$p->ID)).'">Retry staff notification</a>';},'ppt_enquiry_record','normal');});
add_action('admin_post_ppt_retry_enquiry',function(){$id=absint($_GET['id']??0);if(!current_user_can('manage_ppt_enquiries')||get_post_type($id)!=='ppt_enquiry_record')wp_die('Permission denied','',array('response'=>403));check_admin_referer('ppt_retry_'.$id);if(get_post_meta($id,'_ppt_notification',true)==='failed')ppt_notify_enquiry($id);wp_safe_redirect(admin_url('post.php?post='.$id.'&action=edit'));exit;});
// WordPress's verified privacy-request workflow owns authorization for export/erasure.
add_filter('wp_privacy_personal_data_exporters',function($exporters){$exporters['ppt-enquiries']=array('exporter_friendly_name'=>'PPT enquiries','callback'=>function($email,$page=1){$items=get_posts(array('post_type'=>'ppt_enquiry_record','post_status'=>array('private','trash'),'posts_per_page'=>50,'paged'=>max(1,(int)$page),'meta_key'=>'_ppt_email','meta_value'=>$email));$data=array();foreach($items as $p){$fields=array(array('name'=>'Message','value'=>$p->post_content));foreach(array('name','email','organisation','category','context','consent_at','notification')as $key)$fields[]=array('name'=>$key,'value'=>get_post_meta($p->ID,'_ppt_'.$key,true));$data[]=array('group_id'=>'ppt-enquiries','group_label'=>'PPT enquiries','item_id'=>'ppt-enquiry-'.$p->ID,'data'=>$fields);}return array('data'=>$data,'done'=>count($items)<50);});return $exporters;});
add_filter('wp_privacy_personal_data_erasers',function($erasers){$erasers['ppt-enquiries']=array('eraser_friendly_name'=>'PPT enquiries','callback'=>function($email,$page=1){$items=get_posts(array('post_type'=>'ppt_enquiry_record','post_status'=>array('private','trash'),'posts_per_page'=>50,'meta_key'=>'_ppt_email','meta_value'=>$email));$removed=false;$retained=false;foreach($items as $p){if(wp_delete_post($p->ID,true))$removed=true;else $retained=true;}return array('items_removed'=>$removed,'items_retained'=>$retained,'messages'=>$retained?array('An enquiry could not be erased; an administrator must review it.'):array(),'done'=>count($items)<50||$retained);});return $erasers;});
