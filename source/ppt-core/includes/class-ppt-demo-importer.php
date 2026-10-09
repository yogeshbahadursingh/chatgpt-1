<?php
/** Keyed demo records; removal trashes only unchanged records owned by this importer. */
defined('ABSPATH') || exit;
class PPT_Demo_Importer {
 const DEMO_META_KEY='_ppt_demo_content';
 public function __construct(){add_action('admin_menu',array($this,'menu'));add_action('admin_post_ppt_demo',array($this,'handle'));}
 public function menu(){add_management_page('PPT Demo Content','PPT Demo Content','manage_options','ppt-demo-importer',array($this,'screen'));}
 public function screen(){
  if(!current_user_can('manage_options')) return;
  echo '<div class="wrap"><h1>PPT Demo Content</h1><p>Demonstration concepts and test prices only. Importing again preserves existing records. Removal moves unchanged importer-owned records to Trash; edited or adopted records are preserved. Restore from Trash if needed. No genuine people, partnerships or academic identifiers are invented.</p><form method="post" action="'.esc_url(admin_url('admin-post.php')).'">';wp_nonce_field('ppt_demo');echo '<input type="hidden" name="action" value="ppt_demo">';submit_button('Import PPT Demo Content','primary','import',false);echo ' ';submit_button('Remove PPT Demo Content','secondary','remove',false);echo '</form></div>';
 }
 public function handle(){if(!current_user_can('manage_options')) wp_die('Permission denied.');check_admin_referer('ppt_demo');if(isset($_POST['import']))self::import_all();elseif(isset($_POST['remove']))self::remove_all();wp_safe_redirect(admin_url('tools.php?page=ppt-demo-importer'));exit;}
 public static function fingerprint($id){
  $p=get_post($id);$meta=get_post_meta($id);
  // Ignore caches, counters and trash bookkeeping; retain editorial and product configuration.
  $product_keys=array('_thumbnail_id','_regular_price','_sale_price','_sku','_virtual','_downloadable','_downloadable_files','_download_limit','_download_expiry','_weight','_length','_width','_height','_manage_stock');
  foreach(array_keys($meta) as $key) if($key==='_ppt_demo_fingerprint' || (strpos($key,'_ppt_')!==0 && !in_array($key,$product_keys,true))) unset($meta[$key]);
  ksort($meta);
  $taxonomies=array_values(array_intersect(get_object_taxonomies($p->post_type),array('ppt_subject_area','ppt_publication_type','ppt_article_type','ppt_training_type','ppt_event_type','category','post_tag','product_cat','product_tag')));
  $terms=wp_get_object_terms($id,$taxonomies,array('fields'=>'ids'));if(is_wp_error($terms))$terms=array();sort($terms);
  return hash('sha256',serialize(array($p->post_title,$p->post_content,$p->post_excerpt,$p->post_status,$meta,$terms)));
 }
 private static function record($key,$type,$title,$summary,$meta=array(),$topic=''){
  $found=get_posts(array('post_type'=>$type,'post_status'=>array('publish','draft','pending','private','future','trash'),'meta_key'=>'_ppt_demo_key','meta_value'=>$key,'posts_per_page'=>1));
  if($found)return $found[0]->ID;
  $body='<p><strong>Demonstration concept — not an actual publication, event or completed research claim.</strong></p><p>'.esc_html($summary).'</p><h2>Questions to explore</h2><p>Who is affected, which forms of evidence are useful, and how could different perspectives change the question? This example invites readers to identify assumptions and discuss what would be needed before practical decisions could be made.</p><h2>From knowledge to practice</h2><p>A useful starting point is to define a manageable question, identify the people who should be involved, and agree how information will be gathered and interpreted. Responsible work makes uncertainty visible and separates proposed methods from established findings.</p><h2>Reflect and discuss</h2><p>Consider the local context, accessibility needs and possible unintended consequences. Document decisions and plan how participants could review the process. This demonstration does not report empirical findings or claim external validation.</p>';
  $id=wp_insert_post(array('post_type'=>$type,'post_status'=>'publish','post_title'=>$title,'post_name'=>'demo-'.sanitize_title($title),'post_excerpt'=>'Demonstration: '.$summary,'post_content'=>$body,'meta_input'=>array_merge($meta,array('_ppt_demo_content'=>'1','_ppt_demo_key'=>$key))),true);
  if(is_wp_error($id))return 0;
  if($topic)wp_set_object_terms($id,$topic,'ppt_subject_area');
  update_post_meta($id,'_ppt_demo_fingerprint',self::fingerprint($id));return $id;
 }
 public static function import_all(){
  if(!current_user_can('manage_options'))return new WP_Error('forbidden','Administrator access required.');
  if(!add_option('ppt_demo_import_lock',time(),'','no')){if((int)get_option('ppt_demo_import_lock')<time()-600)delete_option('ppt_demo_import_lock');return new WP_Error('busy','Another import is running. Retry shortly.');}
  try{
  $topics=array('Climate & Sustainability','Health & Wellbeing','Education & Human Development','Communities & Society','Technology & Responsible Innovation','Policy & Governance');
  $journal_titles=array('People & Planet Review','Journal of Sustainable Communities','Global Health & Human Development Review');$journals=array();$issues=array();
  $authors=array();$researchers=array();
  foreach(array('A','B','C') as $i=>$letter){
   $authors[$i]=self::record('author-'.$i,'ppt_author','Demonstration Author '.$letter,'A fictional profile used to demonstrate authorship relationships. This does not identify a real person.',array('_ppt_affiliation'=>'Demonstration profile — no institutional affiliation claimed','_ppt_author_bio'=>'A fictional contributor profile for testing the publishing workflow.'),$topics[$i]);
   $researchers[$i]=self::record('researcher-'.$i,'ppt_researcher','Demonstration Researcher '.$letter,'A fictional profile showing how expertise and project relationships are presented.',array('_ppt_researcher_role'=>'Demonstration profile','_ppt_researcher_expertise'=>$topics[$i]),$topics[$i]);
  }
  foreach($journal_titles as $i=>$title){
   $journals[$i]=self::record('journal-'.$i,'ppt_journal',$title,'A demonstration journal concept exploring the relationship between evidence, human wellbeing and sustainable development.',array('_ppt_aims_scope'=>'This concept welcomes interdisciplinary discussion of methods, community priorities and responsible applications of knowledge. No submissions are currently invited under this demonstration title.','_ppt_author_guidelines'=>'Contact the publishing team with an outline and intended audience.','_ppt_policies'=>'Demonstration only. Active journal policies must be confirmed before launch.'),$topics[$i]);
   $issues[$i]=self::record('issue-'.$i,'ppt_journal_issue',$title.' — Demonstration Issue 1','A sample issue structure containing three demonstration article concepts.',array('_ppt_journal_id'=>$journals[$i],'_ppt_volume'=>'1','_ppt_issue_number'=>'1'),$topics[$i]);
   if(get_post_meta($journals[$i],'_ppt_demo_fingerprint',true)===self::fingerprint($journals[$i])){update_post_meta($journals[$i],'_ppt_current_issue_id',$issues[$i]);update_post_meta($journals[$i],'_ppt_demo_fingerprint',self::fingerprint($journals[$i]));}
  }
  $articles=array('Community priorities in climate resilience planning','Public health communication across unequal information environments','Education as a foundation for sustainable futures','Co-designing neighbourhood research with residents','Policy learning when evidence is incomplete','Local adaptation and the language of risk','Digital inclusion beyond access to devices','Responsible technology in community decision-making','Human wellbeing as a shared research question');
  foreach($articles as $i=>$title){$j=intdiv($i,3);$summary='A conceptual exploration of '.lcfirst($title).', outlining questions, methodological choices and practical considerations without claiming original empirical results.';$id=self::record('article-'.$i,'ppt_article',$title,$summary,array('_ppt_authors'=>(string)$authors[$j],'_ppt_abstract'=>$summary,'_ppt_keywords'=>strtolower($topics[$i%6]).', methods, practice','_ppt_journal_id'=>$journals[$j],'_ppt_issue_id'=>$issues[$j],'_ppt_volume'=>'1','_ppt_issue_number'=>'1'),$topics[$i%6]);self::seed_term($id,'Concept article','ppt_article_type');}
  foreach($topics as $i=>$topic){
   $area=self::record('area-'.$i,'ppt_research_area',$topic,'An emerging area for questions that connect '.$topic.' with inclusive knowledge and practical decisions.',array(),$topic);
   self::record('project-'.$i,'ppt_research_project',array('Community climate resilience pathways','Understanding everyday wellbeing','Learning across the life course','Community knowledge partnerships','Responsible digital participation','Evidence in local policy decisions')[$i],'A proposed demonstration research concept. The design would bring participants into question-setting and explore methods suited to the local context.',array('_ppt_project_area_id'=>$area,'_ppt_project_status'=>'planned','_ppt_project_lead_id'=>$researchers[$i%3],'_ppt_project_methodology'=>'Proposed methods: participatory question-setting, literature mapping and discussion of appropriate evaluation. No fieldwork or findings are claimed.','_ppt_project_timeline'=>'Concept stage; dates and partners are not confirmed.','_ppt_featured'=>$i===0?'1':'0'),$topic);
  }
  $books=array(
   array('People, Planet & Progress','paperback','Books','24.00'),array('Building Resilient Communities','hardback','Books','32.00'),array('Sustainable Futures','paperback','Books','22.00'),
   array('Knowledge Into Action','pdf','E-books','9.00'),array('Research for Real-World Impact','pdf','E-books','12.00'),array('Learning Across Boundaries','pdf','E-books','8.00'),
   array('Community Evidence: A Research Framework','pdf','Research Reports','6.00'),array('Inclusive Knowledge Systems','pdf','Research Reports','6.00'),
   array('Evidence to Action','pdf','Policy Briefs','3.00'),array('Designing Accessible Public Dialogue','pdf','Policy Briefs','3.00'),array('A Practical Question-Setting Workbook','pdf','Free Resources','0')
  );
  foreach($books as $i=>$b){
   $summary='A demonstration '.$b[2].' title examining how questions, evidence and reflection can support better practice. Test price only; the sample file contains demonstration material.';
   $pub=self::record('publication-'.$i,'ppt_publication',$b[0],$summary,array('_ppt_publication_format'=>$b[1],'_ppt_publication_is_free'=>$b[3]==='0'?'1':'0','_ppt_featured'=>$i<3?'1':'0'),$topics[$i%6]);self::seed_term($pub,$b[2],'ppt_publication_type');
   if(class_exists('WC_Product_Simple')) self::product($i,$b,$pub,$summary,$topics[$i%6]);
  }
  $training=array('Research Methods for Real-World Impact','Academic Writing & Publishing','Sustainability Leadership','Evidence-Based Policy Development','Community Research & Engagement','Responsible AI for Research');
  foreach($training as $i=>$title){$id=self::record('training-'.$i,'ppt_training',$title,'A demonstration learning programme designed around discussion, reflective exercises and a practical planning activity.',array('_ppt_training_learning_outcomes'=>'Frame an actionable question; assess the limits of evidence; draft a practical plan.','_ppt_training_audience'=>'Researchers, practitioners and professional teams','_ppt_training_level'=>'introductory','_ppt_training_delivery_mode'=>$i%2?'in-person':'online','_ppt_training_duration'=>'Two half-day sessions','_ppt_training_registration_url'=>add_query_arg('enquiry','Training',home_url('/contact/'))),$topics[$i]);self::seed_term($id,$i%2?'Workshop':'Course','ppt_training_type');}
  foreach(array('Knowledge into Practice Forum','Community Research Exchange','Sustainable Learning Roundtable','Responsible Innovation Dialogue') as $i=>$title)self::record('event-'.$i,'ppt_event',$title,'A future demonstration event concept. Dates are illustrative, attendance is not open and speakers or partners are not confirmed.',array('_ppt_event_start_date'=>wp_date('Y-m-d',strtotime('+'.(2+$i).' months')),'_ppt_event_is_virtual'=>'1','_ppt_event_registration_url'=>add_query_arg('enquiry','Training',home_url('/contact/'))),$topics[$i]);
  $insights=array('Why Knowledge Must Move Beyond Publication','From Evidence to Action','What Makes Research Truly Impactful?','Building Research Communities That Last','The Future of Scholarly Publishing','Learning for a Sustainable Future','Why Interdisciplinary Research Matters','Making Research Accessible','Knowledge as Infrastructure for Change');
  foreach($insights as $i=>$title){$id=self::record('insight-'.$i,'post',$title,'An editorial demonstration reflecting on '.lcfirst(rtrim($title,'?')).'. The starting point is to ask who can use the knowledge and what support makes meaningful participation possible.',array(),$topics[$i%6]);self::seed_term($id,array('Research','Policy','Commentary','Society','Publishing','Learning','Sustainability','News','Interviews')[$i],'category');}
  return true;
  }finally{delete_option('ppt_demo_import_lock');}
 }
 private static function seed_term($id,$term,$taxonomy){
  if(!$id || get_post_meta($id,'_ppt_demo_fingerprint',true)!==self::fingerprint($id))return;
  wp_set_object_terms($id,$term,$taxonomy,true);update_post_meta($id,'_ppt_demo_fingerprint',self::fingerprint($id));
 }
 private static function product($i,$data,$pub,$summary,$topic){
  $existing=get_posts(array('post_type'=>'product','post_status'=>array('publish','draft','trash','private'),'meta_key'=>'_ppt_demo_key','meta_value'=>'product-'.$i,'posts_per_page'=>1));if($existing)return;
  $product=new WC_Product_Simple();$product->set_name($data[0].' — Demo');$product->set_slug('demo-product-'.sanitize_title($data[0]));$product->set_status('publish');$product->set_description('<p><strong>Demonstration product. Test price; not a live commercial publication.</strong></p><p>'.esc_html($summary).'</p>');$product->set_short_description($summary);$product->set_regular_price($data[3]);$product->set_sku('PPT-DEMO-'.($i+1));
  if($data[1]==='pdf'){
   $product->set_virtual(true);$product->set_downloadable(true);$product->set_download_limit(5);
   $upload=wp_upload_dir();$dir=$upload['basedir'].'/woocommerce_uploads';wp_mkdir_p($dir);
   if(!file_exists($dir.'/.htaccess'))file_put_contents($dir.'/.htaccess',"Deny from all\n");
   if(!file_exists($dir.'/index.html'))file_put_contents($dir.'/index.html','');
   $name='ppt-demo-'.wp_generate_password(24,false).'.pdf';file_put_contents($dir.'/'.$name,self::pdf());
   $download=new WC_Product_Download();$download->set_id(wp_generate_uuid4());$download->set_name('Demonstration sample (PDF)');$download->set_file($upload['baseurl'].'/woocommerce_uploads/'.$name);$product->set_downloads(array($download));
  }else{$product->set_manage_stock(true);$product->set_stock_quantity(12);$product->set_weight('0.4');$product->set_length('21');$product->set_width('14.8');$product->set_height('1.5');}
  $product->update_meta_data('_ppt_book_author','Demonstration Author '.array('A','B','C')[$i%3]);$product->update_meta_data('_ppt_book_format',$data[1]);$product->update_meta_data('_ppt_book_contents',"1. Framing the question\n2. Choosing evidence\n3. Planning practical action");$product->update_meta_data('_ppt_book_author_bio','Fictional contributor profile used only for demonstration.');$product->update_meta_data('_ppt_book_licence','Demonstration sample for local testing. This is not the finished commercial title.');$product->update_meta_data('_ppt_demo_content','1');$product->update_meta_data('_ppt_demo_key','product-'.$i);$product->update_meta_data('_ppt_publication_id',$pub);$id=$product->save();
  wp_set_object_terms($id,$topic,'ppt_subject_area');wp_set_object_terms($id,$data[2],'ppt_publication_type');wp_set_object_terms($id,$data[2],'product_cat');
  update_post_meta($id,'_ppt_demo_fingerprint',self::fingerprint($id));
  if(get_post_meta($pub,'_ppt_demo_fingerprint',true)===self::fingerprint($pub)){update_post_meta($pub,'_ppt_publication_product_id',$id);update_post_meta($pub,'_ppt_demo_fingerprint',self::fingerprint($pub));}
 }
 private static function pdf(){
  $stream="BT /F1 20 Tf 50 750 Td (People & Planet Thrive) Tj 0 -35 Td /F1 12 Tf (DEMONSTRATION SAMPLE - NOT A COMMERCIAL PUBLICATION) Tj 0 -30 Td (Use this file to test WooCommerce download permissions.) Tj 0 -25 Td (No research findings, identifiers or credentials are claimed.) Tj ET";
  $objects=array('<< /Type /Catalog /Pages 2 0 R >>','<< /Type /Pages /Kids [3 0 R] /Count 1 >>','<< /Type /Page /Parent 2 0 R /MediaBox [0 0 595 842] /Resources << /Font << /F1 4 0 R >> >> /Contents 5 0 R >>','<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>','<< /Length '.strlen($stream)." >>\nstream\n".$stream."\nendstream");
  $pdf="%PDF-1.4\n";$offsets=array(0);foreach($objects as $i=>$object){$offsets[]=strlen($pdf);$pdf.=($i+1)." 0 obj\n".$object."\nendobj\n";}$xref=strlen($pdf);$pdf.="xref\n0 6\n0000000000 65535 f \n";foreach(array_slice($offsets,1)as $offset)$pdf.=sprintf('%010d 00000 n ',$offset)."\n";return $pdf."trailer\n<< /Size 6 /Root 1 0 R >>\nstartxref\n".$xref."\n%%EOF";
 }
 public static function remove_all(){
  if(!current_user_can('manage_options'))return new WP_Error('forbidden','Administrator access required.');
  $result=array('trashed'=>0,'preserved'=>0);
  $posts=get_posts(array('post_type'=>ppt_content_types(),'post_status'=>array('publish','draft','pending','private','future'),'posts_per_page'=>-1,'meta_key'=>self::DEMO_META_KEY,'meta_value'=>'1'));
  foreach($posts as $p){$saved=get_post_meta($p->ID,'_ppt_demo_fingerprint',true);if($saved && hash_equals($saved,self::fingerprint($p->ID))){wp_trash_post($p->ID);$result['trashed']++;}else{$result['preserved']++;}}
  return $result;
 }
}
new PPT_Demo_Importer();
