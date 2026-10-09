<?php
wp_set_current_user(1);
$routes=array();
foreach(get_posts(array('post_type'=>array_merge(array('page'),ppt_content_types()),'post_status'=>'publish','numberposts'=>-1))as $p)$routes[]=array('route'=>get_permalink($p),'type'=>$p->post_type,'id'=>$p->ID,'title'=>$p->post_title);
foreach(ppt_content_types()as $type){$obj=get_post_type_object($type);if($obj && $obj->has_archive)$routes[]=array('route'=>get_post_type_archive_link($type),'type'=>$type,'id'=>'archive','title'=>$obj->labels->name);}
// Follow public taxonomy destinations emitted by archive filters and content tags.
foreach(get_taxonomies(array('public'=>true),'objects') as $taxonomy){
 if(!array_intersect($taxonomy->object_type,ppt_content_types())) continue;
 $terms=get_terms(array('taxonomy'=>$taxonomy->name,'hide_empty'=>true));
 if(is_wp_error($terms)) continue;
 foreach($terms as $term){$url=get_term_link($term);if(!is_wp_error($url))$routes[]=array('route'=>$url,'type'=>'taxonomy:'.$taxonomy->name,'id'=>$term->term_id,'title'=>$term->name);}
}
$routes[]=array('route'=>home_url('/privacy-policy/'),'type'=>'page','id'=>'required','title'=>'Privacy Policy');
file_put_contents(dirname(ABSPATH,3).'/runtime/routes.json',wp_json_encode($routes));
echo count($routes).' routes';

