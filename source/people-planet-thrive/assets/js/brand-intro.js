(function () {
  'use strict';
  var intro = document.getElementById('ppt-brand-intro');
  if (!intro) return;

  var reduced = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var seen = false;
  try { seen = sessionStorage.getItem('pptBrandIntroSeen') === '1'; } catch (e) {}

  if (seen || reduced) {
    intro.remove();
    document.documentElement.classList.remove('ppt-intro-first');
    document.documentElement.classList.add('ppt-intro-seen');
    return;
  }

  document.documentElement.classList.add('ppt-intro-playing');
  document.body.classList.add('ppt-intro-lock');

  // Mark as seen immediately so refresh/navigation never traps the visitor in the intro.
  try { sessionStorage.setItem('pptBrandIntroSeen', '1'); } catch (e) {}

  window.setTimeout(function () {
    intro.classList.add('is-leaving');
    document.body.classList.remove('ppt-intro-lock');
  }, 1900);

  window.setTimeout(function () {
    if (intro && intro.parentNode) intro.parentNode.removeChild(intro);
    document.documentElement.classList.remove('ppt-intro-playing', 'ppt-intro-first');
    document.documentElement.classList.add('ppt-intro-seen');
  }, 2550);
}());
