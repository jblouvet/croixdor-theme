export class Tabs {
	constructor(selector, options = {}) {
		this.tabsContainers = document.querySelectorAll(selector);
		if (!this.tabsContainers.length) return;

		this.options = {
			animation: 'fade',
			autoHeight: true,
			autoHeightMode: 'fixed',
			fixedHeight: 400,
			fixedBreakpoint: 1024,
			transitionDuration: 300, // ms pour les animations
			scrollToPanel: true, // scroll automatique vers le panel actif
			showShadow: true,
			...options,
		};

		this.resizeTimeout = null;
		this.isTransitioning = false;

		this.init();
		this.setupResizeHandler();
	}

	init() {
		this.tabsContainers.forEach((container) => {
			container.classList.add(`tabs-anim-${this.options.animation}`);
			if (this.options.autoHeight) {
				container.classList.add('tabs-autoheight');
			} else {
				container.classList.remove('tabs-autoheight');
			}

			if (this.options.showShadow) {
				container.classList.add('tabs-shadow');
			} else {
				container.classList.remove('tabs-shadow');
			}

			const tabButtons = container.querySelectorAll('.tab-button');
			const tabPanels = container.querySelectorAll('.tab-panel');

			// Configuration ARIA pour l'accessibilité
			this.setupAccessibility(container, tabButtons, tabPanels);

			// Activation initiale et calcul de hauteur dès le départ
			if (tabButtons.length && tabPanels.length) {
				this.activateTab(0, tabButtons, tabPanels, container, false);
			}

			// Gestion des clics
			tabButtons.forEach((button, idx) => {
				button.addEventListener('click', () => {
					if (!this.isTransitioning) {
						this.activateTab(idx, tabButtons, tabPanels, container, true);
					}
				});
			});

			// Gestion du clavier
			this.setupKeyboardNavigation(container, tabButtons, tabPanels);
		});
	}

	setupAccessibility(container, tabButtons, tabPanels) {
		const tablistId = `tablist-${Math.random().toString(36).substr(2, 9)}`;

		// Configuration du tablist
		const tabsButtonsWrapper = container.querySelector('.tabs-buttons');
		if (tabsButtonsWrapper) {
			tabsButtonsWrapper.setAttribute('role', 'tablist');
			tabsButtonsWrapper.setAttribute('id', tablistId);
		}

		// Configuration des tabs et panels
		tabButtons.forEach((button, idx) => {
			const tabId = `tab-${tablistId}-${idx}`;
			const panelId = `panel-${tablistId}-${idx}`;

			button.setAttribute('role', 'tab');
			button.setAttribute('id', tabId);
			button.setAttribute('aria-controls', panelId);
			button.setAttribute('tabindex', idx === 0 ? '0' : '-1');

			if (tabPanels[idx]) {
				tabPanels[idx].setAttribute('role', 'tabpanel');
				tabPanels[idx].setAttribute('id', panelId);
				tabPanels[idx].setAttribute('aria-labelledby', tabId);
				tabPanels[idx].setAttribute('tabindex', '0');
			}
		});
	}

	setupKeyboardNavigation(container, tabButtons, tabPanels) {
		tabButtons.forEach((button, idx) => {
			button.addEventListener('keydown', (e) => {
				let targetIdx = idx;

				switch (e.key) {
					case 'ArrowLeft':
					case 'ArrowUp':
						e.preventDefault();
						targetIdx = idx > 0 ? idx - 1 : tabButtons.length - 1;
						break;
					case 'ArrowRight':
					case 'ArrowDown':
						e.preventDefault();
						targetIdx = idx < tabButtons.length - 1 ? idx + 1 : 0;
						break;
					case 'Home':
						e.preventDefault();
						targetIdx = 0;
						break;
					case 'End':
						e.preventDefault();
						targetIdx = tabButtons.length - 1;
						break;
					default:
						return;
				}

				this.activateTab(targetIdx, tabButtons, tabPanels, container, true);
				tabButtons[targetIdx].focus();
			});
		});
	}

	setupResizeHandler() {
		window.addEventListener('resize', () => {
			clearTimeout(this.resizeTimeout);
			this.resizeTimeout = setTimeout(() => {
				this.tabsContainers.forEach((container) => {
					const tabButtons = container.querySelectorAll('.tab-button');
					const tabPanels = container.querySelectorAll('.tab-panel');
					const activeIndex = Array.from(tabButtons).findIndex(btn => btn.classList.contains('is-active'));

					if (activeIndex !== -1) {
						this.activateTab(activeIndex, tabButtons, tabPanels, container, false);
					}
				});
			}, 150); // Debounce de 150ms
		});
	}

	activateTab(index, tabButtons, tabPanels, container, animated = true) {
		// Bloquer les interactions pendant la transition
		if (animated) {
			this.isTransitioning = true;
			setTimeout(() => {
				this.isTransitioning = false;
			}, this.options.transitionDuration);
		}

		// Mise à jour des attributs ARIA
		tabButtons.forEach((btn, i) => {
			btn.classList.toggle('is-active', i === index);
			btn.setAttribute('aria-selected', i === index ? 'true' : 'false');
			btn.setAttribute('tabindex', i === index ? '0' : '-1');
		});

		tabPanels.forEach((panel, i) => {
			panel.classList.toggle('is-active', i === index);
			panel.classList.toggle('is-hidden', i !== index);

			if (this.options.autoHeight && (this.options.autoHeightMode === 'active' || (this.options.autoHeightMode === 'fixed' && window.innerWidth < this.options.fixedBreakpoint))) {
				panel.classList.toggle('is-removed', i !== index);
			} else {
				panel.classList.remove('is-removed');
			}
		});

		// Scroll vers le panel actif en mode fixed avec scroll
		if (this.options.scrollToPanel && animated) {
			const activePanel = tabPanels[index];
			if (activePanel && activePanel.classList.contains('tabs-scrollable')) {
				// Petit délai pour laisser le DOM se mettre à jour
				setTimeout(() => {
					activePanel.scrollTop = 0;
				}, 50);
			}
		}

		// Gestion autoHeight
		this.updateHeight(index, tabButtons, tabPanels, container);
	}

	updateHeight(index, tabButtons, tabPanels, container) {
		if (!this.options.autoHeight || !container) {
			container.style.height = '';
			container.classList.remove('tabs-fixedheight');
			tabPanels.forEach(panel => panel.classList.remove('tabs-scrollable'));
			return;
		}

		if (this.options.autoHeightMode === 'fixed') {
			if (window.innerWidth >= this.options.fixedBreakpoint) {
				const currentHeight = container.style.getPropertyValue('--tabs-fixedheight');
				const computedHeight = getComputedStyle(container).getPropertyValue('--tabs-fixedheight');
				if (!currentHeight && !computedHeight) {
					container.style.setProperty('--tabs-fixedheight', this.options.fixedHeight + 'px');
				}
				container.classList.add('tabs-fixedheight');
				tabPanels.forEach(panel => panel.classList.add('tabs-scrollable'));
			} else {
				this.setActiveHeight(index, tabButtons, tabPanels, container);
			}
		} else if (this.options.autoHeightMode === 'max') {
			this.setMaxHeight(tabPanels, container);
		} else {
			this.setActiveHeight(index, tabButtons, tabPanels, container);
		}
	}

	setActiveHeight(index, tabButtons, tabPanels, container) {
		const activePanel = tabPanels[index];
		const tabButtonsWrapper = container.querySelector('.tabs-buttons');
		let buttonsHeight = 0;

		if (tabButtonsWrapper) {
			buttonsHeight = tabButtonsWrapper.getBoundingClientRect().height;
		}

		if (activePanel && activePanel.classList.contains('is-active')) {
			// Force un reflow pour avoir la vraie hauteur
			activePanel.style.position = 'relative';
			activePanel.style.visibility = 'visible';

			// Attendre un frame pour que le DOM se mette à jour
			requestAnimationFrame(() => {
				const panelHeight = activePanel.scrollHeight; // scrollHeight au lieu de offsetHeight
				const extraHeight = parseInt(getComputedStyle(container).getPropertyValue('--tabs-extra-height')) || 0;
				const totalHeight = panelHeight + buttonsHeight + extraHeight;

				container.style.height = totalHeight + 'px';
			});
		} else {
			container.style.height = 'auto';
		}

		container.classList.remove('tabs-fixedheight');
		tabPanels.forEach(panel => panel.classList.remove('tabs-scrollable'));
	}

	setMaxHeight(tabPanels, container) {
		let maxHeight = 0;
		tabPanels.forEach(panel => {
			maxHeight = Math.max(maxHeight, panel.offsetHeight);
		});
		container.style.height = maxHeight + 'px';
		container.classList.remove('tabs-fixedheight');
		tabPanels.forEach(panel => panel.classList.remove('tabs-scrollable'));
	}
}