/**
 * Navigation Script
 * People & Planet Thrive Theme
 *
 * Handles mobile menu toggle and keyboard navigation.
 *
 * @package PeoplePlanetThrive
 */

(function () {
	'use strict';

	/**
	 * Mobile menu toggle.
	 */
	function initMobileMenu() {
		const toggle = document.querySelector('.wp-block-navigation__responsive-container-open');
		const container = document.querySelector('.wp-block-navigation__responsive-container');

		if (!toggle || !container) return;

		toggle.addEventListener('click', function () {
			const isOpen = container.classList.contains('is-menu-open');
			toggle.setAttribute('aria-expanded', !isOpen);
		});

		// Close menu on Escape key.
		document.addEventListener('keydown', function (e) {
			if (e.key === 'Escape' && container.classList.contains('is-menu-open')) {
				toggle.click();
				toggle.focus();
			}
		});
	}

	/**
	 * Keyboard navigation for menus.
	 */
	function initKeyboardNav() {
		const menus = document.querySelectorAll('.wp-block-navigation .wp-block-navigation__container');

		menus.forEach(function (menu) {
			const items = menu.querySelectorAll('.wp-block-navigation-item > a');

			items.forEach(function (item, index) {
				item.addEventListener('keydown', function (e) {
					let target;

					switch (e.key) {
						case 'ArrowRight':
						case 'ArrowDown':
							e.preventDefault();
							target = items[(index + 1) % items.length];
							target.focus();
							break;

						case 'ArrowLeft':
						case 'ArrowUp':
							e.preventDefault();
							target = items[(index - 1 + items.length) % items.length];
							target.focus();
							break;

						case 'Home':
							e.preventDefault();
							items[0].focus();
							break;

						case 'End':
							e.preventDefault();
							items[items.length - 1].focus();
							break;
					}
				});
			});
		});
	}

	/**
	 * Add aria-expanded to submenus.
	 */
	function initSubmenuAccessibility() {
		const submenuToggles = document.querySelectorAll('.wp-block-navigation-item__content[aria-haspopup]');

		submenuToggles.forEach(function (toggle) {
			toggle.setAttribute('aria-expanded', 'false');

			toggle.addEventListener('click', function () {
				const expanded = this.getAttribute('aria-expanded') === 'true';
				this.setAttribute('aria-expanded', !expanded);
			});
		});
	}

	// Initialize when DOM is ready.
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', function () {
			initMobileMenu();
			initKeyboardNav();
			initSubmenuAccessibility();
		});
	} else {
		initMobileMenu();
		initKeyboardNav();
		initSubmenuAccessibility();
	}
})();
