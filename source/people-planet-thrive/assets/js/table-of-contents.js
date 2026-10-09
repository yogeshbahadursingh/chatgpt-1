/**
 * Table of Contents Generator
 *
 * Automatically generates a table of contents from article headings
 *
 * @package PeoplePlanetThrive
 * @since 1.0.0
 */

(function() {
	'use strict';

	/**
	 * Generate Table of Contents
	 */
	function generateTOC() {
		const tocContainer = document.getElementById('ppt-toc-content');
		if (!tocContainer) return;

		const articleContent = document.querySelector('.ppt-article-content .entry-content');
		if (!articleContent) return;

		// Get all headings (h2, h3, h4)
		const headings = articleContent.querySelectorAll('h2, h3, h4');
		
		if (headings.length === 0) {
			tocContainer.innerHTML = '<p style="color:var(--wp--preset--color--text-light);font-style:italic;font-size:var(--wp--preset--font-size--14)">No sections found.</p>';
			return;
		}

		// Create TOC list
		const tocList = document.createElement('ul');
		tocList.style.listStyle = 'none';
		tocList.style.padding = '0';
		tocList.style.margin = '0';

		headings.forEach(function(heading, index) {
			// Generate unique ID for heading
			const headingId = 'heading-' + index;
			heading.id = headingId;

			// Create list item
			const listItem = document.createElement('li');
			listItem.style.marginBottom = 'var(--wp--preset--spacing--10)';

			// Add indentation based on heading level
			if (heading.tagName === 'H3') {
				listItem.style.paddingLeft = 'var(--wp--preset--spacing--15)';
			} else if (heading.tagName === 'H4') {
				listItem.style.paddingLeft = 'var(--wp--preset--spacing--25)';
			}

			// Create link
			const link = document.createElement('a');
			link.href = '#' + headingId;
			link.textContent = heading.textContent;
			link.style.color = 'var(--wp--preset--color--text)';
			link.style.textDecoration = 'none';
			link.style.fontSize = 'var(--wp--preset--font-size--14)';
			link.style.lineHeight = '1.5';
			link.style.transition = 'color 0.2s ease';

			// Add hover effect
			link.addEventListener('mouseenter', function() {
				this.style.color = 'var(--wp--preset--color--primary)';
			});

			link.addEventListener('mouseleave', function() {
				this.style.color = 'var(--wp--preset--color--text)';
			});

			// Smooth scroll
			link.addEventListener('click', function(e) {
				e.preventDefault();
				const target = document.getElementById(headingId);
				if (target) {
					const headerOffset = 100;
					const elementPosition = target.getBoundingClientRect().top;
					const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

					window.scrollTo({
						top: offsetPosition,
						behavior: 'smooth'
					});
				}
			});

			listItem.appendChild(link);
			tocList.appendChild(listItem);
		});

		// Replace loading text with TOC
		tocContainer.innerHTML = '';
		tocContainer.appendChild(tocList);
	}

	/**
	 * Highlight active section in TOC
	 */
	function highlightActiveSection() {
		const tocContainer = document.getElementById('ppt-toc-content');
		if (!tocContainer) return;

		const headings = document.querySelectorAll('.ppt-article-content .entry-content h2, .ppt-article-content .entry-content h3, .ppt-article-content .entry-content h4');
		const tocLinks = tocContainer.querySelectorAll('a');

		if (headings.length === 0 || tocLinks.length === 0) return;

		let currentHeading = null;

		headings.forEach(function(heading) {
			const rect = heading.getBoundingClientRect();
			if (rect.top <= 150) {
				currentHeading = heading;
			}
		});

		// Remove active class from all links
		tocLinks.forEach(function(link) {
			link.style.fontWeight = '400';
			link.style.color = 'var(--wp--preset--color--text)';
		});

		// Add active class to current link
		if (currentHeading) {
			const activeLink = tocContainer.querySelector('a[href="#' + currentHeading.id + '"]');
			if (activeLink) {
				activeLink.style.fontWeight = '600';
				activeLink.style.color = 'var(--wp--preset--color--primary)';
			}
		}
	}

	/**
	 * Initialize
	 */
	function init() {
		// Generate TOC on page load
		generateTOC();

		// Highlight active section on scroll
		let scrollTimeout;
		window.addEventListener('scroll', function() {
			clearTimeout(scrollTimeout);
			scrollTimeout = setTimeout(highlightActiveSection, 100);
		}, { passive: true });

		// Initial highlight
		highlightActiveSection();
	}

	// Initialize when DOM is ready
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', init);
	} else {
		init();
	}

})();
