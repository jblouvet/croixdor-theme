export class HorizontalScroll {
	constructor(containerSelector) {
		this.scrollContainers = document.querySelectorAll(containerSelector);

		if (!this.scrollContainers.length) return;

		this.init();
	}

	init() {
		this.scrollContainers.forEach((scrollContainer) => {
			scrollContainer.addEventListener('wheel', (event) => this.handleScroll(event, scrollContainer));
		});
	}

	handleScroll(event, scrollContainer) {
		if (event.deltaY === 0) return;

		// Check if the target element or its parent has vertical scroll
		const target = event.target;
		const hasVerticalScroll = this.hasVerticalScrollableParent(target, scrollContainer);

		if (hasVerticalScroll) {
			// Allow native vertical scrolling
			return;
		}

		const atStart = scrollContainer.scrollLeft === 0;
		const atEnd = scrollContainer.scrollLeft + scrollContainer.clientWidth >= scrollContainer.scrollWidth;

		// Allow horizontal scrolling only if not at the boundaries
		if (!atStart && !atEnd) {
			event.preventDefault();
			scrollContainer.scrollLeft += event.deltaY;
		} else if (atStart && event.deltaY < 0) {
			// Allow vertical scrolling when at the start and scrolling up
			return;
		} else if (atEnd && event.deltaY > 0) {
			// Allow vertical scrolling when at the end and scrolling down
			return;
		} else {
			event.preventDefault();
			scrollContainer.scrollLeft += event.deltaY;
		}
	}

	hasVerticalScrollableParent(element, stopElement) {
		let current = element;

		while (current && current !== stopElement) {
			const overflowY = window.getComputedStyle(current).overflowY;
			const isScrollable = overflowY === 'auto' || overflowY === 'scroll';

			if (isScrollable && current.scrollHeight > current.clientHeight) {
				return true;
			}

			current = current.parentElement;
		}

		return false;
	}
}