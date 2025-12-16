export class Accordion {
	constructor(selector, options = {}) {
		this.accordions = document.querySelectorAll(selector);
		if (!this.accordions.length) return;

		// Default options
		this.options = {
			collapseInactive: true, // Collapse inactive items by default
			...options, // Merge user options
		};

		this.init();
	}

	init() {

		this.accordions.forEach((accordion) => {
			const items = accordion.querySelectorAll('.accordion-item');

			items.forEach((item) => {

				const header = item.querySelector('.accordion-header');
				const body = item.querySelector('.accordion-body');

				if (header && body) {

					// Add click event listener to the header
					header.addEventListener('click', () => {

						this.toggleItem(item, items);
					});
				}
			});
		});
	}

	toggleItem(item, items) {

		const isActive = item.classList.contains('is-active');

		// Collapse other items if collapseInactive is true
		if (this.options.collapseInactive) {
			items.forEach((otherItem) => {
				if (otherItem !== item) {
					otherItem.classList.remove('is-active');
					otherItem.classList.add('is-collapsed');
				}
			});
		}

		// Toggle the clicked item
		if (isActive) {
			item.classList.remove('is-active');
			item.classList.add('is-collapsed');
		} else {
			item.classList.add('is-active');
			item.classList.remove('is-collapsed');
			setTimeout(function () { item.scrollIntoView({ behavior: 'smooth' }) }, 300);
		}
	}
}