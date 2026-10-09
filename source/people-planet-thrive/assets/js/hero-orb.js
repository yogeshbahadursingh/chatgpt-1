/**
 * People & Planet Thrive — premium hero orb parallax.
 * Tiny, dependency-free pointer interaction. Ambient rotation remains CSS-only.
 */
(function () {
  'use strict';

  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

  var hero = document.querySelector('.ppt-lux-hero');
  var orb = document.querySelector('.ppt-planet-orb');
  if (!hero || !orb) return;

  // Keep touch devices on the CSS-only ambient animation.
  if (!window.matchMedia('(hover: hover) and (pointer: fine)').matches) return;

  var raf = 0;
  var targetX = 0;
  var targetY = 0;

  function render() {
    orb.style.setProperty('--ppt-orb-x', targetX.toFixed(2) + 'px');
    orb.style.setProperty('--ppt-orb-y', targetY.toFixed(2) + 'px');
    raf = 0;
  }

  hero.addEventListener('pointermove', function (event) {
    var rect = hero.getBoundingClientRect();
    var nx = ((event.clientX - rect.left) / rect.width) - 0.5;
    var ny = ((event.clientY - rect.top) / rect.height) - 0.5;
    targetX = nx * 12;
    targetY = ny * 9;
    if (!raf) raf = window.requestAnimationFrame(render);
  }, { passive: true });

  hero.addEventListener('pointerleave', function () {
    targetX = 0;
    targetY = 0;
    if (!raf) raf = window.requestAnimationFrame(render);
  }, { passive: true });
}());
