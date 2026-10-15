(function () {
 'use strict';
 document.querySelectorAll('.ppt-enquiry').forEach(function(form){
  var select=form.querySelector('[name="ppt_category"]'),hint=form.querySelector('#ppt-pathway-hint'),button=form.querySelector('button[type="submit"]'),status=form.querySelector('.ppt-submit-status');
  if(select&&hint)select.addEventListener('change',function(){hint.textContent=select.options[select.selectedIndex].dataset.hint||'';});
  form.addEventListener('submit',function(event){if(form.dataset.sending==='1'){event.preventDefault();return;}if(!form.checkValidity())return;form.dataset.sending='1';form.setAttribute('aria-busy','true');button.disabled=true;button.textContent='Sending…';status.textContent='Saving your enquiry. Please wait.';});
  window.addEventListener('pageshow',function(){delete form.dataset.sending;form.removeAttribute('aria-busy');button.disabled=false;button.textContent='Send enquiry';status.textContent='';});
 });
 var result=document.querySelector('.ppt-error-summary,.ppt-enquiry-confirmation');if(result)result.focus({preventScroll:false});
}());
