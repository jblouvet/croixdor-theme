(function () {
	const siteHeader = document.querySelector('.site-header');
	if (!siteHeader) return;

	let lastScrollY = window.scrollY;
	let ticking = false;

	// Classes gérées par ce script (à retirer/ajouter dynamiquement)
	const managedClasses = ['is-top', 'is-not-top', 'is-bottom', 'is-unpinned'];

	function updateHeader() {
		const currentScrollY = window.scrollY;
		const documentHeight = document.documentElement.scrollHeight - window.innerHeight;
		const scrollProgress = currentScrollY / documentHeight;

		// Déterminer la direction du scroll
		const isScrollingDown = currentScrollY > lastScrollY;

		// Retirer toutes les classes gérées
		siteHeader.classList.remove(...managedClasses);

		// Ajouter les classes appropriées
		if (currentScrollY <= 0) {
			siteHeader.classList.add('is-top');
		} else if (scrollProgress >= 0.99) {
			siteHeader.classList.add('is-not-top', 'is-bottom');
		} else {
			siteHeader.classList.add('is-not-top');
			if (isScrollingDown && currentScrollY > 100) {
				siteHeader.classList.add('is-unpinned');
			}
		}

		lastScrollY = currentScrollY;
		ticking = false;
	}

	function requestTick() {
		if (!ticking) {
			requestAnimationFrame(updateHeader);
			ticking = true;
		}
	}

	// Écouter le scroll avec throttling via RAF
	window.addEventListener('scroll', requestTick, { passive: true });

	// Initialisation
	updateHeader();
})();