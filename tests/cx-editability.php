<?php
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Local QA required.');
$file=dirname(ABSPATH,3).'/runtime/cx/editorial-private.json';$mode=getenv('PPT_CX_EDIT_MODE')?:'apply';wp_set_current_user(1);
if($mode==='apply'){
 if(file_exists($file))WP_CLI::error('Restore earlier editorial test first.');
 $nav=get_post(27);$pub=get_posts(array('post_type'=>'ppt_publication','numberposts'=>1))[0];$backup=array('nav'=>$nav->post_content,'pub'=>$pub->ID,'title'=>$pub->post_title,'author'=>get_post_meta($pub->ID,'_ppt_publication_editors',true),'url'=>get_permalink($pub));file_put_contents($file,wp_json_encode($backup));
 $edited=str_replace('"label":"Home"','"label":"Home editorial verification"',$nav->post_content);if($edited===$nav->post_content)WP_CLI::error('Expected native navigation label missing.');wp_update_post(array('ID'=>$nav->ID,'post_content'=>$edited));wp_update_post(array('ID'=>$pub->ID,'post_title'=>'Local publication editorial verification'));update_post_meta($pub->ID,'_ppt_publication_editors','Local author field verification');
 echo wp_json_encode(array('url'=>$backup['url']));
}else{$b=json_decode(file_get_contents($file),true);wp_update_post(array('ID'=>27,'post_content'=>$b['nav']));wp_update_post(array('ID'=>$b['pub'],'post_title'=>$b['title']));if($b['author']==='')delete_post_meta($b['pub'],'_ppt_publication_editors');else update_post_meta($b['pub'],'_ppt_publication_editors',$b['author']);$ok=get_post(27)->post_content===$b['nav']&&get_post($b['pub'])->post_title===$b['title'];unlink($file);echo wp_json_encode(array('restored'=>$ok));}
