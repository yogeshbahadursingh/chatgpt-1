const fs=require('fs'),path=require('path'),crypto=require('crypto');const {execFileSync}=require('child_process');const {chromium}=require('playwright');
const runtime=path.resolve('ppt-wordpress/runtime'),token=crypto.randomBytes(12).toString('hex'),muFile=path.join(runtime,`reinstall/wordpress/wp-content/mu-plugins/qa-collections-${token}.php`);const checks=[];let settings;
const check=(name,pass,details={})=>checks.push({name,status:pass?'PASS':'FAIL',...details});
function fixtures(mode){return JSON.parse(execFileSync('C:/xampp/php/php.exe',[path.join(runtime,'wp-cli.phar'),'--path='+path.join(runtime,'reinstall/wordpress'),'eval-file',path.resolve('ppt-wordpress/tests/collection-visibility-fixtures.php')],{encoding:'utf8',timeout:120000,env:{...process.env,PPT_QA_COLLECTION_TOKEN:token,PPT_QA_COLLECTION_MODE:mode}}));}
const same=(actual,expected)=>actual.length===new Set(actual).size&&JSON.stringify([...actual].sort())===JSON.stringify([...expected].sort());
(async()=>{let browser;try{
 const fixture=fixtures('create');settings=fixture.settings;
 fs.writeFileSync(muFile,`<?php
if(isset($_SERVER['HTTP_X_PPT_QA_COLLECTIONS']) && isset($_SERVER['REMOTE_ADDR']) && in_array($_SERVER['REMOTE_ADDR'],array('127.0.0.1','::1'),true)){
 $parts=explode(':',(string)$_SERVER['HTTP_X_PPT_QA_COLLECTIONS'],2);$mode=$parts[1]??'';
 if(($parts[0]??'')==='${token}' && in_array($mode,array('store','live-hide-stock','live-show-stock'),true)){
  add_filter('pre_option_woocommerce_coming_soon',function()use($mode){return $mode==='store'?'yes':'no';});add_filter('pre_option_woocommerce_store_pages_only',function(){return 'yes';});add_filter('pre_option_woocommerce_private_link',function(){return 'no';});
  add_filter('pre_option_woocommerce_hide_out_of_stock_items',function()use($mode){return $mode==='live-show-stock'?'no':'yes';});
  add_action('template_redirect',function(){global $wp_query;header('X-PPT-QA-Found: '.$wp_query->found_posts);if(isset($_GET['ppt_qa_collections']))wp_send_json(array('directory'=>ppt_directory(array('type'=>'post,product','topic'=>${fixture.topic},'limit'=>24)),'products'=>ppt_directory(array('type'=>'product','topic'=>${fixture.topic},'limit'=>24)),'auto'=>ppt_related(${fixture.posts.auto.id}),'explicit'=>ppt_related(${fixture.posts.explicit.id})));},1);
 }
}
`,{flag:'wx'});
 browser=await chromium.launch({headless:true});const context=await browser.newContext({javaScriptEnabled:false});await context.route('**/*',r=>r.abort());const page=await context.newPage();
 for(const mode of ['store','live-hide-stock','live-show-stock']){
  const headers={'X-PPT-QA-Collections':`${token}:${mode}`};const probe=new URL(fixture.home);probe.searchParams.set('ppt_qa_collections','1');const response=await fetch(probe,{headers,signal:AbortSignal.timeout(60000)});const data=await response.json();
  const catalogProducts=mode==='store'?[]:[fixture.products.visible.url,fixture.products.catalog.url,...(mode==='live-show-stock'?[fixture.products.outofstock.url]:[])];const editorial=Object.values(fixture.posts).map(p=>p.url);
  for(const [name,html]of Object.entries(data)){
   await page.setContent(html,{waitUntil:'domcontentloaded'});const selector=['auto','explicit'].includes(name)?'li>a':'.ppt-pub-card h3>a';const urls=await page.locator(selector).evaluateAll(nodes=>nodes.map(a=>a.getAttribute('href')));
   const expected=name==='products'?catalogProducts:name==='directory'?[...editorial,...catalogProducts]:[fixture.posts[name==='auto'?'explicit':'auto'].url,...catalogProducts];check(`${mode} ${name} exact visible membership`,same(urls,expected),{expected:expected.length,actual:urls.length});
  }
  const searchUrl=new URL(fixture.home);searchUrl.searchParams.set('s',fixture.search);const searchResponse=await fetch(searchUrl,{headers,signal:AbortSignal.timeout(60000)});const html=await searchResponse.text();await page.setContent(html,{waitUntil:'domcontentloaded'});const found=await page.locator('main .wp-block-post-title a').evaluateAll(nodes=>nodes.map(a=>a.getAttribute('href')));
  const searchProducts=mode==='store'?[]:[fixture.products.visible.url,fixture.products.search.url,...(mode==='live-show-stock'?[fixture.products.outofstock.url]:[])];const expected=[...editorial,...searchProducts];
  check(`${mode} main search exact visible membership`,searchResponse.status===200&&!/Fatal error|Warning:|Parse error/.test(html)&&same(found,expected),{expected:expected.length,actual:found.length});check(`${mode} search count excludes invisible products`,Number(searchResponse.headers.get('x-ppt-qa-found'))===expected.length);
 }
}finally{if(browser)await browser.close();if(fs.existsSync(muFile))fs.unlinkSync(muFile);const cleanup=fixtures('cleanup');check('all owned collection fixtures removed',cleanup.deleted===7&&cleanup.remaining===0&&cleanup.term_removed,{deleted:cleanup.deleted});check('global store settings unchanged',JSON.stringify(cleanup.settings)===JSON.stringify(settings));fs.writeFileSync(path.join(runtime,'collection-visibility-results.json'),JSON.stringify({checks,cleanup:{deleted:cleanup.deleted,remaining:cleanup.remaining,term_removed:cleanup.term_removed,request_override_removed:!fs.existsSync(muFile)}},null,2));}
console.log(JSON.stringify(checks,null,2));if(checks.some(c=>c.status==='FAIL'))process.exitCode=1;})().catch(error=>{console.error(error);process.exitCode=1;});
