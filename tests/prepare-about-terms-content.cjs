// Explicit local authoring step. Source notes/comments are never copied into page HTML.
const fs=require('fs'),path=require('path');
const base=path.resolve(__dirname,'..'),dest=path.join(base,'content/about-terms');fs.mkdirSync(dest,{recursive:true});
const esc=s=>s.replaceAll('&','&amp;').replaceAll('<','&lt;').replaceAll('>','&gt;').replaceAll('"','&quot;');
const inline=s=>esc(s).replace(/\*\*(.*?)\*\*/g,'<strong>$1</strong>').replace(/  \n/g,'<br>').replace(/\n/g,' ');
const block=(name,attrs,html)=>`<!-- wp:${name}${Object.keys(attrs).length?' '+JSON.stringify(attrs):''} -->${html}<!-- /wp:${name} -->\n`;
const group=(cls,content)=>block('group',{className:cls},`<div class="wp-block-group ${cls}">${content}</div>`);
const p=(s,cls='')=>block('paragraph',cls?{className:cls}:{},`<p${cls?' class="'+cls+'"':''}>${inline(s)}</p>`);
const heading=(text,level,id)=>block('heading',{level,anchor:id},`<h${level} class="wp-block-heading" id="${id}">${inline(text)}</h${level}>`);
const manifest={sources:[],placeholders:{}};
for(const type of ['about','terms']){
 const name=type==='about'?'01-about-us.md':'02-terms-and-conditions.md',raw=fs.readFileSync('C:/Users/acer/Downloads/'+name,'utf8');
 const clean=raw.replace(/<!--[\s\S]*?-->/g,'').trim();manifest.sources.push({file:name,sha256:require('crypto').createHash('sha256').update(raw).digest('hex')});
 const chunks=clean.split(/\r?\n\s*\r?\n/),sections=[];let html='',title='';
 for(const chunk of chunks){const h=chunk.match(/^(#{1,3}) (.*)$/);if(h){if(h[1].length===1){title=h[2];continue;}const id=(type==='terms'?'terms-':'about-')+h[2].toLowerCase().replace(/[^a-z0-9]+/g,'-').replace(/-$/,'');if(h[1].length===2)sections.push({title:h[2],id});html+=heading(h[2],h[1].length,id);}else{html+=p(chunk.replace(/\r/g,''));}}
 if(type==='about'){
  html=html.replace('<strong>Work With Us</strong>','<a href="/work-with-us/">Work With Us</a>').replace('<strong>Contact</strong>','<a href="/contact/">Contact</a>');
  // Retain the existing, valid explanation of purpose.
  const legacy=heading('Why we exist',2,'about-why-we-exist')+p('Useful knowledge needs more than a place to be published. It needs context, open discussion and pathways into decisions. Our launch programme brings scholarly journals, books, practical resources and professional learning into one connected platform.');
  const at=html.indexOf('<!-- wp:heading {"level":2,"anchor":"about-our-foundation"}');html=html.slice(0,at)+legacy+html.slice(at);
  const start=html.indexOf('<!-- wp:heading {"level":2,"anchor":"about-company-information"}'),end=html.indexOf('<!-- wp:heading {"level":2,"anchor":"about-start-a-conversation"}');
  html=html.slice(0,start)+group('ppt-company-details',html.slice(start,end))+html.slice(end);
 }else{
  const items=sections.map(s=>block('list-item',{},`<li><a href="#${s.id}">${esc(s.title)}</a></li>`)).join('');
  const toc=group('ppt-terms-contents',heading('On this page',2,'terms-contents')+block('list',{},`<ul class="wp-block-list">${items}</ul>`));
  html=p('Review draft — not approved for purchases or publication.','ppt-policy-review')+toc+html;
  html=html.replace('Our separate Privacy Policy','Our separate <a href="/privacy-policy/">Privacy Policy</a>');
  for(const key of clean.match(/\{\{[^}]+\}\}/g)||[])manifest.placeholders[key]=(manifest.placeholders[key]||0)+1;
 }
 fs.writeFileSync(path.join(dest,type+'.html'),group(type==='terms'?'ppt-terms-document':'ppt-about-document',html));
 manifest[type]={title,sections:sections.length};
}
fs.writeFileSync(path.join(dest,'source-manifest.json'),JSON.stringify(manifest,null,2));
console.log('Native block content generated; unresolved fields:',Object.keys(manifest.placeholders).length);
