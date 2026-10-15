/** One scoped controller: native SVG path travel, CSS ambient motion and settling-only pointer rAF. */
(function () {
  'use strict';
  document.querySelectorAll('.ppt-hero-art').forEach(function (art) {
    var orb = art.querySelector('.ppt-planet-orb');
    var svg = art.querySelector('.ppt-orb-paths');
    var button = art.querySelector('.ppt-orb-motion-control');
    if (!orb || !svg || !button || art.dataset.orbitInitialized || !svg.pauseAnimations || !window.IntersectionObserver) return;
    art.dataset.orbitInitialized = 'true';
    var reduced = window.matchMedia('(prefers-reduced-motion: reduce)');
    var fine = window.matchMedia('(hover: hover) and (pointer: fine)');
    var manualPause = false, visible = false, running = false, hovered = false;
    var frame = 0, lastTime = 0, x = 0, y = 0, targetX = 0, targetY = 0;
    svg.pauseAnimations();
    svg.setCurrentTime(0);
    svg.querySelectorAll('.ppt-orbit-traveller').forEach(function (traveller) {
      // Identical geometry drives the visible ring and its travelling dot.
      var path = traveller.parentElement.querySelector('.ppt-orbit-path');
      var motion = document.createElementNS('http://www.w3.org/2000/svg', 'animateMotion');
      motion.setAttribute('path', path.getAttribute('d'));
      motion.setAttribute('dur', traveller.dataset.duration + 's');
      motion.setAttribute('repeatCount', 'indefinite');
      motion.setAttribute('calcMode', 'paced');
      motion.setAttribute('begin', '0s');
      traveller.removeAttribute('transform');
      traveller.appendChild(motion);
    });
    svg.setCurrentTime(0);
    art.classList.add('is-motion-ready');
    button.hidden = false;
    function cancelFrame() {
      if (frame) window.cancelAnimationFrame(frame);
      frame = 0; lastTime = 0;
    }
    function paint() {
      orb.style.setProperty('--ppt-depth-x', x.toFixed(3) + 'px');
      orb.style.setProperty('--ppt-depth-y', y.toFixed(3) + 'px');
    }
    function tick(time) {
      frame = 0;
      if (!running || !fine.matches) return;
      var dt = lastTime ? Math.min(64, time - lastTime) : 16;
      lastTime = time;
      var ease = 1 - Math.exp(-dt / 160);
      x += (targetX - x) * ease; y += (targetY - y) * ease;
      if (Math.abs(targetX - x) + Math.abs(targetY - y) < .015) {
        x = targetX; y = targetY; lastTime = 0;
      } else frame = window.requestAnimationFrame(tick);
      paint();
    }
    function requestFrame() {
      if (!frame && running && fine.matches) frame = window.requestAnimationFrame(tick);
    }
    function sync() {
      running = !manualPause && !reduced.matches && visible && !document.hidden;
      art.dataset.motion = running ? 'running' : 'paused';
      art.dataset.manualPause = String(manualPause);
      button.disabled = reduced.matches;
      button.textContent = reduced.matches ? 'Animation off' : (manualPause ? 'Resume animation' : 'Pause animation');
      button.title = reduced.matches ? 'Animation is off to respect your reduced-motion preference.' : '';
      if (running) {
        svg.unpauseAnimations();
        if (!hovered) { targetX = 0; targetY = 0; }
        if (x !== targetX || y !== targetY) requestFrame();
      } else {
        svg.pauseAnimations(); cancelFrame();
      }
      if (reduced.matches) {
        svg.setCurrentTime(0); targetX = targetY = x = y = 0; paint();
      }
    }
    button.addEventListener('click', function () { manualPause = !manualPause; sync(); });
    orb.addEventListener('pointermove', function (event) {
      if (!running || !fine.matches || event.pointerType === 'touch') return;
      hovered = true;
      var rect = orb.getBoundingClientRect();
      var nx = (event.clientX - rect.left) / rect.width * 2 - 1;
      var ny = (event.clientY - rect.top) / rect.height * 2 - 1;
      var length = Math.max(1, Math.hypot(nx, ny));
      targetX = nx / length * 8; targetY = ny / length * 8; requestFrame();
    }, { passive: true });
    orb.addEventListener('pointerleave', function () {
      hovered = false; targetX = targetY = 0; requestFrame();
    }, { passive: true });
    new IntersectionObserver(function (entries) {
      visible = entries[0].isIntersecting;
      if (!visible) hovered = false;
      sync();
    }, { threshold: 0 }).observe(orb);
    document.addEventListener('visibilitychange', function () {
      if (document.hidden) hovered = false;
      sync();
    });
    reduced.addEventListener('change', sync);
    fine.addEventListener('change', function () {
      if (!fine.matches) { cancelFrame(); targetX = targetY = x = y = 0; paint(); }
    });
    sync();
  });
}());
