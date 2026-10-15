<?php
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Local QA required.');
$file=dirname(ABSPATH,3).'/runtime/cx/contents-private.json';
if(getenv('PPT_CX_CONTENTS_MODE')==='cleanup'){$ids=json_decode(file_get_contents($file),true);foreach($ids as $id)wp_delete_post($id,true);unlink($file);return;}
if(file_exists($file))WP_CLI::error('Clean up earlier contents fixtures first.');
$ids=array();foreach(array('short'=>15,'long'=>65)as $kind=>$count){$content='';foreach(array('existing-section','', '')as $i=>$anchor)$content.='<h2'.($anchor?' id="'.$anchor.'"':'').'>Section '.($i+1).'</h2><p>'.str_repeat('This local editorial fixture verifies reading and section navigation. ',$count).'</p>';$ids[$kind]=wp_insert_post(array('post_type'=>'post','post_status'=>'publish','post_title'=>'Local CX '.$kind.' reading verification','post_content'=>$content));}file_put_contents($file,wp_json_encode($ids));echo wp_json_encode(array_map('get_permalink',$ids));
