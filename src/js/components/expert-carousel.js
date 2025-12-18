export class ExpertCarousel {
	constructor(selector) {
		this.container = document.querySelector(selector);
		if (!this.container) return;

		this.cards = Array.from(this.container.querySelectorAll('.expert-card'));

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

		window.addEventListener('resize', this.debounce(() => {
			this.updateClasses();
		}, 200));
	}

	debounce(func, wait) {
		let timeout;
		return function (...args) {
			const later = () => {
				clearTimeout(timeout);
				func.apply(this, args);
			};
			clearTimeout(timeout);
			timeout = setTimeout(later, wait);
		};
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
			const position = (index - this.currentIndex + this.total) % this.total;

			card.classList.remove('is-active', 'is-next', 'is-next-2', 'is-hidden-stack');

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

			card.setAttribute('aria-hidden', position === 0 ? 'false' : 'true');
		});
	}

	updateHeight(activeCard) {
		if (!activeCard) return;

		this.checkScroll(activeCard);

		const h = activeCard.offsetHeight;
		const list = this.container.querySelector('.experts-list');
		if (list) {
			list.style.transition = 'height 0.3s ease';
			if (window.innerWidth < 1280) {
				const extraSpace = 80;
				list.style.height = h + 'px';
				this.container.style.height = (h + extraSpace) + 'px';
			} else {
				list.style.height = '';
				this.container.style.height = '';
			}
		}
	}

	checkScroll(card) {
		const isMobile = window.innerWidth < 1280;
		const scrollTarget = isMobile ? card : card.querySelector('.expert-scroll-content');
		const overlay = isMobile ? card.querySelector('.expert-mobile-overlay') : card.querySelector('.expert-scroll-overlay');

		if (!scrollTarget || !overlay) return;

		const check = () => {
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
			const content = card.querySelector('.expert-scroll-content');
			if (content) {
				content.addEventListener('scroll', () => {
					if (window.innerWidth >= 1280) this.checkScroll(card);
				});
			}

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

			if (Math.abs(distanceX) > Math.abs(distanceY) && Math.abs(distanceX) > minSwipeDistance) {
				if (distanceX > 0) {
					this.prev();
				} else {
					this.next();
				}
			}
		};
	}
}
