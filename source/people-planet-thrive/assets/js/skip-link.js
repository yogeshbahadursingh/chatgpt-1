/**
 * Skip Link Focus Fix
 * People & Planet Thrive Theme
 *
 * Ensures the skip link target receives focus properly across browsers.
 *
 * @package PeoplePlanetThrive
 */

(function () {
	'use strict';

	var isWebkit = navigator.userAgent.indexOf('AppleWebKit') !== -1;
	var isIE = navigator.userAgent.indexOf('Trident') !== -1;

	if (!isWebkit && !isIE) {
		return;
	}

	var skipLink = document.querySelector('.skip-link');
	if (!skipLink) {
		return;
	}

	skipLink.addEventListener('click', function (e) {
		var targetId = this.getAttribute('href');
		var target = document.querySelector(targetId);

		if (target) {
			// Make target focusable.
			if (!target.hasAttribute('tabindex')) {
				target.setAttribute('tabindex', '-1');
			}
			target.focus();
		}
	});
})();
