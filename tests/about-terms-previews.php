<?php
if(wp_get_environment_type()!=='local'||home_url()!=='http://127.0.0.1:8877')WP_CLI::error('Local only.');
$file=dirname(__DIR__).'/runtime/about-terms/preview-private.json';
if(getenv('PPT_TERMS_MODE')==='cleanup'){$data=json_decode(file_get_contents($file),true);WP_Session_Tokens::get_instance(1)->destroy($data['token']);unlink($file);WP_CLI::success('Preview session removed.');return;}
if(file_exists($file))WP_CLI::error('Existing preview session requires cleanup.');
wp_set_current_user(1);$token=WP_Session_Tokens::get_instance(1)->create(time()+HOUR_IN_SECONDS);
$data=array('token'=>$token,'cookie'=>array('name'=>LOGGED_IN_COOKIE,'value'=>wp_generate_auth_cookie(1,time()+HOUR_IN_SECONDS,'logged_in',$token),'domain'=>'127.0.0.1','path'=>'/','httpOnly'=>true,'secure'=>false,'sameSite'=>'Lax'));
file_put_contents($file,wp_json_encode($data));WP_CLI::success('Private local preview session prepared.');
