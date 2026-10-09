/* Native navigation owns opening, focus management and keyboard controls. */
(function () {
	'use strict';
	var header = document.querySelector('.ppt-premium-header');
	if (!header) return;
	// The outer template part is the sticky element so its containing block does
	// not end at the bottom of the header itself. No layout-changing shrink effect.
	var shell = header.closest('header');
	if (shell) shell.classList.add('ppt-navigation-shell');
	var scheduled = false;
	function update() {
		header.classList.toggle('is-scrolled', window.scrollY > 24);
		scheduled = false;
	}
	window.addEventListener('scroll', function () {
		if (!scheduled) {
			scheduled = true;
			window.requestAnimationFrame(update);
		}
	}, { passive: true });
	update();
}());
