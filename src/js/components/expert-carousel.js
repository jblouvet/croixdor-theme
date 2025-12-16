export class ExpertCarousel {
	constructor(selector) {
		this.container = document.querySelector(selector);
		if (!this.container) return;

		this.cards = Array.from(this.container.querySelectorAll('.expert-card'));
		this.nextBtn = this.container.querySelector('.expert-next');
		this.prevBtn = this.container.querySelector('.expert-prev');

		// Also grab mobile buttons if they are outside the container scope or duplicates
		// Update: The PHP structure has two sets of buttons, one for desktop/tablet inside container (absolute), one for mobile (flex order).
		// We select them by class, which returns the first found if we use querySelector.
		// We probably want to bind ALL buttons with those classes within the section.
		const section = this.container.closest('.bloc-experts');
		this.nextBtns = section ? section.querySelectorAll('.expert-next') : document.querySelectorAll('.expert-next');
		this.prevBtns = section ? section.querySelectorAll('.expert-prev') : document.querySelectorAll('.expert-prev');

		this.total = this.cards.length;
		this.currentIndex = 0;

		this.init();
	}

	init() {
		if (this.total === 0) return;

		this.initScrollListeners();
		this.initSwipeListeners();
		this.updateClasses();

		this.nextBtns.forEach(btn => {
			btn.addEventListener('click', (e) => {
				e.preventDefault();
				this.next();
			});
		});

		this.prevBtns.forEach(btn => {
			btn.addEventListener('click', (e) => {
				e.preventDefault();
				this.prev();
			});
		});

		// Recalculate on load to ensure images are ready
		window.addEventListener('load', () => {
			this.updateClasses();
		});

		// Fallback timeout
		setTimeout(() => {
			this.updateClasses();
		}, 500);

		window.addEventListener('resize', () => {
			this.updateClasses();
		});
	}

	next() {
		this.currentIndex = (this.currentIndex + 1) % this.total;
		this.updateClasses();
	}

	prev() {
		this.currentIndex = (this.currentIndex - 1 + this.total) % this.total;
		this.updateClasses();
	}

	updateClasses() {
		this.cards.forEach((card, index) => {
			// Calculate relative position based on currentIndex
			// Position 0 is active, 1 is next, 2 is next-2, etc.
			const position = (index - this.currentIndex + this.total) % this.total;

			// Reset classes
			card.classList.remove('is-active', 'is-next', 'is-next-2', 'is-hidden-stack');

			// Apply new class
			if (position === 0) {
				card.classList.add('is-active');
				this.updateHeight(card);
			} else if (position === 1) {
				card.classList.add('is-next');
			} else if (position === 2) {
				card.classList.add('is-next-2');
			} else {
				card.classList.add('is-hidden-stack');
			}

			// For accessibility
			card.setAttribute('aria-hidden', position === 0 ? 'false' : 'true');
		});
	}

	updateHeight(activeCard) {
		if (!activeCard) return;

		// Update scroll status for the active card
		this.checkScroll(activeCard);

		const h = activeCard.offsetHeight;
		const list = this.container.querySelector('.experts-list');
		if (list) {
			list.style.transition = 'height 0.3s ease';
			if (window.innerWidth < 1280) {
				const extraSpace = 80; // Space for nav buttons at bottom
				list.style.height = h + 'px';
				this.container.style.height = (h + extraSpace) + 'px'; // update main container too if needed
			} else {
				list.style.height = '';
				this.container.style.height = '';
			}
		}
	}

	checkScroll(card) {
		const isMobile = window.innerWidth < 1280;
		// On mobile, the card itself scrolls. On desktop, the inner content scrolls.
		const scrollTarget = isMobile ? card : card.querySelector('.expert-scroll-content');
		const overlay = isMobile ? card.querySelector('.expert-mobile-overlay') : card.querySelector('.expert-scroll-overlay');

		if (!scrollTarget || !overlay) return;

		const check = () => {
			// Tolerance of 1px
			const isScrollable = scrollTarget.scrollHeight > scrollTarget.clientHeight + 1;
			const isAtBottom = scrollTarget.scrollTop + scrollTarget.clientHeight >= scrollTarget.scrollHeight - 1;

			if (isScrollable && !isAtBottom) {
				overlay.style.opacity = '1';
			} else {
				overlay.style.opacity = '0';
			}
		};
		check();
	}

	initScrollListeners() {
		this.cards.forEach(card => {
			// Desktop scroll area
			const content = card.querySelector('.expert-scroll-content');
			if (content) {
				content.addEventListener('scroll', () => {
					if (window.innerWidth >= 1280) this.checkScroll(card);
				});
			}

			// Mobile scroll area (the card itself)
			card.addEventListener('scroll', () => {
				if (window.innerWidth < 1280) this.checkScroll(card);
			});
		});
	}

	initSwipeListeners() {
		let touchStartX = 0;
		let touchStartY = 0;
		let touchEndX = 0;
		let touchEndY = 0;

		const minSwipeDistance = 50;

		this.container.addEventListener('touchstart', (e) => {
			touchStartX = e.changedTouches[0].screenX;
			touchStartY = e.changedTouches[0].screenY;
		}, { passive: true });

		this.container.addEventListener('touchend', (e) => {
			touchEndX = e.changedTouches[0].screenX;
			touchEndY = e.changedTouches[0].screenY;
			handleSwipe();
		}, { passive: true });

		const handleSwipe = () => {
			const distanceX = touchEndX - touchStartX;
			const distanceY = touchEndY - touchStartY;

			// Check if horizontal swipe is dominant and long enough
			if (Math.abs(distanceX) > Math.abs(distanceY) && Math.abs(distanceX) > minSwipeDistance) {
				if (distanceX > 0) {
					this.prev(); // Swipe Right -> Prev
				} else {
					this.next(); // Swipe Left -> Next
				}
			}
		};
	}
}
