<?php
wp_set_current_user(1);$original=get_post(1,ARRAY_A);$results=array();
foreach(array('plain'=>'Welcome to WordPress. This is your first post. Edit or delete it, then start writing!','blocks'=>"<!-- wp:paragraph -->\n<p>Welcome to WordPress. This is your first post. Edit or delete it, then start writing!</p>\n<!-- /wp:paragraph -->",'genuine'=>'This is an original editorial welcome with a similar title.') as $kind=>$content){
 wp_update_post(array('ID'=>1,'post_name'=>'hello-world','post_title'=>'Hello world!','post_content'=>$content,'post_status'=>'publish','post_date'=>current_time('mysql')));
 // This fixture simulates an untouched core insert, rather than an editor revision.
 foreach(wp_get_post_revisions(1) as $revision)wp_delete_post_revision($revision->ID);
 PPT_Site_Setup::run();$results[]=array('test'=>$kind.' starter handling','pass'=>get_post_status(1)===($kind==='genuine'?'publish':'draft'));
}
wp_update_post($original);file_put_contents(dirname(ABSPATH,3).'/runtime/setup-repair-results.json',wp_json_encode($results));echo wp_json_encode($results);
