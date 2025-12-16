export class ExpertScroll {
	constructor(selector = '.expert-annonce') {
		this.selector = selector;
		this.init();
	}

	init() {
		// Écouter les changements du DOM
		const observer = new MutationObserver(() => {
			this.bindEvents();
		});

		observer.observe(document.body, {
			childList: true,
			subtree: true
		});

		// Initialiser aussi au démarrage
		this.bindEvents();
	}

	bindEvents() {
		const expertEls = document.querySelectorAll(this.selector);

		expertEls.forEach((expert) => {
			const makeScroll = expert.querySelector('.js-make-expert-scroll');
			const more = expert.querySelector('#more');

			if (!makeScroll || !more) return;

			// Éviter d'ajouter plusieurs listeners
			if (makeScroll.dataset.bound) return;
			makeScroll.dataset.bound = 'true';

			makeScroll.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();

				const scrollDistance = more.offsetTop - expert.offsetTop;
				expert.scrollTo({
					top: scrollDistance,
					behavior: 'smooth'
				});
			});
		});
	}
}