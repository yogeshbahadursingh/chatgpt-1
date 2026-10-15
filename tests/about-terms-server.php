<?php
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Isolated local site only.');
$root=dirname(__DIR__);$ids=json_decode(file_get_contents($root.'/runtime/about-terms/pages.json'),true);$backup=json_decode(file_get_contents($root.'/checkpoint/pre-about-terms-20261015/pages.json'),true);$results=array();
$check=function($test,$pass,$detail=null)use(&$results){$results[]=array('test'=>$test,'pass'=>(bool)$pass,'detail'=>$detail);};
$terms=get_post($ids['terms_draft']);$about=get_post($ids['about']);
$check('Established About URL preserved',get_permalink($about)==='http://127.0.0.1:8877/about/');
$check('Public Terms launch notice preserved exactly',get_post($ids['terms_target'])->post_content===$backup['pages']['terms']['post']['post_content']);
$check('Checkout block content preserved exactly',get_post($ids['checkout'])->post_content===$backup['pages']['checkout']['post']['post_content']&&has_block('woocommerce/checkout',get_post($ids['checkout'])));
$check('Privacy notice preserved; separate operational review still required',get_post($backup['pages']['privacy-policy']['post']['ID'])->post_content===$backup['pages']['privacy-policy']['post']['post_content']);
foreach(array('woocommerce_terms_page_id','wp_page_for_privacy_policy','woocommerce_checkout_page_id','woocommerce_currency','ppt_terms_acceptance')as $key)$check('Setting restored: '.$key,get_option($key)===$backup['options'][$key]);
foreach(array(27=>'b94135acb881fe0c0123dc1e2a1ec1a9dd17a6b394e633300209c7c09c98d932',28=>'0a480c5982b3beb90dfbdee4a35281452446d380d7dd1eb2fe1f637baedf033f')as $id=>$hash)$check('Approved navigation/header preserved: '.$id,hash('sha256',get_post_field('post_content',$id))===$hash);
$check('Unapproved Terms remain draft',get_post_status($terms)==='draft');
wp_update_post(array('ID'=>$terms->ID,'post_status'=>'publish'));$check('Accidental publish is forced back to review',get_post_status($terms->ID)==='draft');
preg_match_all('/\{\{[^}]+\}\}/',$terms->post_content,$matches);$manifest=json_decode(file_get_contents($root.'/content/about-terms/source-manifest.json'),true);
$check('All 12 occurrences / 10 unresolved fields retained',count($matches[0])===12&&array_count_values($matches[0])===$manifest['placeholders']);
$normal=function($s){$s=preg_replace('/<br\s*\/?>/i',' ',$s);return preg_replace('/\s+/u',' ',trim(html_entity_decode(wp_strip_all_tags($s),ENT_QUOTES|ENT_HTML5,'UTF-8')));};
$source=file_get_contents('C:/Users/acer/Downloads/02-terms-and-conditions.md');$source=preg_replace('/<!--[\s\S]*?-->/','',$source);$paragraphs=preg_split('/\r?\n\s*\r?\n/',trim($source));$missing=array();$actual=$normal($terms->post_content);
foreach($paragraphs as $para){$plain=$normal(preg_replace('/^#{1,3} /','',str_replace('**','',$para)));if($plain==='Terms and Conditions')continue;if(strpos($actual,$plain)===false)$missing[]=$plain;}
$check('Every supplied Terms paragraph retained (including safeguards)',!$missing,array('paragraphs'=>count($paragraphs),'missing'=>$missing));
$check('No private source comments copied',!preg_match('/EDITOR NOTE|REVIEW DRAFT:|03-owner-review|Ward 29/',$terms->post_content.$about->post_content));
$check('Native revisions available',count(wp_get_post_revisions($about->ID))>0&&count(wp_get_post_revisions($ids['terms_target']))>0);
$check('No test policy or private browser session left',!get_page_by_path('local-terms-acceptance-fixture')&&!file_exists($root.'/runtime/about-terms/private.json'));
$check('Default acceptance module inactive',ppt_terms_approval()===null);
file_put_contents($root.'/runtime/about-terms/server-results.json',wp_json_encode($results,JSON_PRETTY_PRINT));
WP_CLI::line(wp_json_encode(array('checks'=>count($results),'failures'=>array_values(array_filter($results,function($r){return !$r['pass'];}))),JSON_PRETTY_PRINT));if(array_filter($results,function($r){return !$r['pass'];}))WP_CLI::halt(1);
