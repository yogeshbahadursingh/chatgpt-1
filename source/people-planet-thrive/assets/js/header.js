/**
 * Header Interactions
 * Sticky header, mobile menu, search toggle, keyboard navigation
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

(function() {
	'use strict';

	/**
	 * Sticky Header
	 */
	function initStickyHeader() {
		const header = document.querySelector('.site-header');
		if (!header) return;

		let lastScroll = 0;
		const stickyClass = 'is-sticky';

		window.addEventListener('scroll', function() {
			const currentScroll = window.pageYOffset;

			if (currentScroll > 100) {
				header.classList.add(stickyClass);
			} else {
				header.classList.remove(stickyClass);
			}

			lastScroll = currentScroll;
		}, { passive: true });
	}

	/**
	 * Transparent Header Mode
	 */
	function initTransparentHeader() {
		const header = document.querySelector('.site-header');
		if (!header) return;

		// Check if page has transparent header class
		if (document.body.classList.contains('header-transparent')) {
			header.classList.add('is-transparent');

			// Remove transparent mode on scroll
			window.addEventListener('scroll', function() {
				if (window.pageYOffset > 50) {
					header.classList.remove('is-transparent');
				} else {
					header.classList.add('is-transparent');
				}
			}, { passive: true });
		}
	}

	/**
	 * Mobile Menu Toggle
	 */
	function initMobileMenu() {
		const toggle = document.querySelector('.mobile-menu-button');
		const panel = document.querySelector('.mobile-nav-panel');
		const close = document.querySelector('.mobile-nav-close');

		if (!toggle || !panel) return;

		function openMenu() {
			panel.style.display = 'block';
			panel.classList.add('is-open');
			toggle.setAttribute('aria-expanded', 'true');
			document.body.style.overflow = 'hidden';

			// Focus first link
			const firstLink = panel.querySelector('a');
			if (firstLink) {
				setTimeout(() => firstLink.focus(), 100);
			}
		}

		function closeMenu() {
			panel.classList.remove('is-open');
			toggle.setAttribute('aria-expanded', 'false');
			document.body.style.overflow = '';

			setTimeout(() => {
				panel.style.display = 'none';
			}, 300);

			toggle.focus();
		}

		toggle.addEventListener('click', function() {
			const isExpanded = this.getAttribute('aria-expanded') === 'true';
			if (isExpanded) {
				closeMenu();
			} else {
				openMenu();
			}
		});

		if (close) {
			close.addEventListener('click', closeMenu);
		}

		// Close on Escape
		document.addEventListener('keydown', function(e) {
			if (e.key === 'Escape' && panel.classList.contains('is-open')) {
				closeMenu();
			}
		});

		// Trap focus within mobile menu
		panel.addEventListener('keydown', function(e) {
			if (e.key !== 'Tab') return;

			const focusable = panel.querySelectorAll('a, button, input, textarea, select, [tabindex]:not([tabindex="-1"])');
			const first = focusable[0];
			const last = focusable[focusable.length - 1];

			if (e.shiftKey) {
				if (document.activeElement === first) {
					e.preventDefault();
					last.focus();
				}
			} else {
				if (document.activeElement === last) {
					e.preventDefault();
					first.focus();
				}
			}
		});
	}

	/**
	 * Search Toggle
	 */
	function initSearchToggle() {
		const searchBlocks = document.querySelectorAll('.header-search');

		searchBlocks.forEach(function(searchBlock) {
			const button = searchBlock.querySelector('.wp-block-search__button');
			const input = searchBlock.querySelector('.wp-block-search__input');

			if (!button || !input) return;

			button.addEventListener('click', function(e) {
				e.preventDefault();
				searchBlock.classList.toggle('is-open');

				if (searchBlock.classList.contains('is-open')) {
					input.focus();
				}
			});

			// Close on click outside
			document.addEventListener('click', function(e) {
				if (!searchBlock.contains(e.target)) {
					searchBlock.classList.remove('is-open');
				}
			});

			// Close on Escape
			input.addEventListener('keydown', function(e) {
				if (e.key === 'Escape') {
					searchBlock.classList.remove('is-open');
					button.focus();
				}
			});
		});
	}

	/**
	 * Keyboard Navigation for Dropdowns
	 */
	function initKeyboardNavigation() {
		const navItems = document.querySelectorAll('.main-navigation .wp-block-navigation-item.has-child');

		navItems.forEach(function(item) {
			const link = item.querySelector(':scope > a');
			const submenu = item.querySelector('.wp-block-navigation-item__submenu');

			if (!link || !submenu) return;

			// Open on Enter or Space
			link.addEventListener('keydown', function(e) {
				if (e.key === 'Enter' || e.key === ' ') {
					e.preventDefault();
					const firstSubLink = submenu.querySelector('a');
					if (firstSubLink) {
						firstSubLink.focus();
					}
				}
			});

			// Navigate within submenu
			const subLinks = submenu.querySelectorAll('a');
			subLinks.forEach(function(subLink, index) {
				subLink.addEventListener('keydown', function(e) {
					if (e.key === 'ArrowDown') {
						e.preventDefault();
						const next = subLinks[index + 1] || subLinks[0];
						next.focus();
					} else if (e.key === 'ArrowUp') {
						e.preventDefault();
						const prev = subLinks[index - 1] || subLinks[subLinks.length - 1];
						prev.focus();
					} else if (e.key === 'Escape') {
						e.preventDefault();
						link.focus();
					} else if (e.key === 'Tab' && !e.shiftKey && index === subLinks.length - 1) {
						// Let focus move naturally to next item
					}
				});
			});
		});
	}

	/**
	 * Newsletter Form
	 */
	function initNewsletterForm() {
		const forms = document.querySelectorAll('.ppt-newsletter-form');

		forms.forEach(function(form) {
			form.addEventListener('submit', function(e) {
				e.preventDefault();

				const email = form.querySelector('input[type="email"]');
				if (!email || !email.value) return;

				// Basic email validation
				const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
				if (!emailRegex.test(email.value)) {
					alert('Please enter a valid email address.');
					return;
				}

				// Here you would typically send to your newsletter service
				// For now, just show success message
				alert('Thank you for subscribing!');
				email.value = '';
			});
		});
	}

	/**
	 * Update dynamic content from Customizer
	 */
	function initDynamicContent() {
		// Update copyright year dynamically
		const copyrightElement = document.querySelector('.footer-legal p');
		if (copyrightElement) {
			const currentYear = new Date().getFullYear();
			const copyrightText = copyrightElement.textContent;
			// Replace any 4-digit year with current year
			const updatedText = copyrightText.replace(/\b\d{4}\b/, currentYear);
			copyrightElement.textContent = updatedText;
		}

		if (typeof pptThemeData === 'undefined') {
			return;
		}

		// Update utility bar contact info
		const utilityEmail = document.querySelector('.utility-bar__contact-item--email');
		if (utilityEmail && pptThemeData.contactEmail) {
			utilityEmail.href = 'mailto:' + pptThemeData.contactEmail;
			utilityEmail.textContent = pptThemeData.contactEmail;
		}

		const utilityPhone = document.querySelector('.utility-bar__contact-item--phone');
		if (utilityPhone && pptThemeData.contactPhone) {
			const phoneClean = pptThemeData.contactPhone.replace(/[^0-9+]/g, '');
			utilityPhone.href = 'tel:' + phoneClean;
			utilityPhone.textContent = pptThemeData.contactPhone;
		}

		// Update header CTA button
		const headerCta = document.querySelector('.header__cta-button');
		if (headerCta && pptThemeData.ctaText && pptThemeData.ctaUrl) {
			headerCta.href = pptThemeData.ctaUrl;
			headerCta.textContent = pptThemeData.ctaText;
		}

		// Update mobile nav CTA button
		const mobileCta = document.querySelector('.mobile-nav__cta-button');
		if (mobileCta && pptThemeData.ctaText && pptThemeData.ctaUrl) {
			mobileCta.href = pptThemeData.ctaUrl;
			mobileCta.textContent = pptThemeData.ctaText;
		}

		// Update footer contact info
		const footerEmail = document.querySelector('.footer__contact-link[href^="mailto:"]');
		if (footerEmail && pptThemeData.contactEmail) {
			footerEmail.href = 'mailto:' + pptThemeData.contactEmail;
			footerEmail.textContent = pptThemeData.contactEmail;
		}

		const footerPhone = document.querySelector('.footer__contact-link[href^="tel:"]');
		if (footerPhone && pptThemeData.contactPhone) {
			const phoneClean = pptThemeData.contactPhone.replace(/[^0-9+]/g, '');
			footerPhone.href = 'tel:' + phoneClean;
			footerPhone.textContent = pptThemeData.contactPhone;
		}
	}

	/**
	 * Initialize all header features
	 */
	function init() {
		initStickyHeader();
		initTransparentHeader();
		initMobileMenu();
		initSearchToggle();
		initKeyboardNavigation();
		initNewsletterForm();
		initDynamicContent();
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

})();
