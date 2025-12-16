import noUiSlider from 'nouislider';

document.addEventListener('DOMContentLoaded', function () {
	const wrapper = document.getElementById('annonces-pharmacies');
	if (!wrapper) return;

	const regionInput = document.getElementById('region-search');
	const regionList = document.getElementById('region-list');
	const caSlider = document.getElementById('ca-slider');
	const caSliderValues = document.getElementById('ca-slider-values');
	let caMin = 0;
	let caMax = 15000000;
	let page = 1;
	let regionTimeout;
	let selectedRegions = [];
	let hasUserInteracted = false;

	let regionListIndex = -1; // Index de sélection dans la liste

	function highlightRegionListItem(index) {
		const items = Array.from(regionList.children);
		items.forEach((li, i) => {
			li.style.background = (i === index) ? '#b3e0ff' : '';
		});
		if (index >= 0 && items[index]) {
			items[index].scrollIntoView({ block: 'nearest' });
		}
	}

	function addRegionTag(term) {
		selectedRegions.push({ slug: term.slug, name: term.name });
		renderTags(false);
		updateAnnonces();
		regionList.style.display = 'none'; // Ferme la liste après sélection
		regionInput.value = ''; // Vide l'input
	}

	// Gestion navigation clavier dans l'input
	regionInput.addEventListener('keydown', function (e) {
		const items = Array.from(regionList.children);
		if (!items.length || regionList.style.display !== 'block') return;

		if (e.key === 'ArrowDown') {
			e.preventDefault();
			regionListIndex = (regionListIndex + 1) % items.length;
			highlightRegionListItem(regionListIndex);
		} else if (e.key === 'ArrowUp') {
			e.preventDefault();
			regionListIndex = (regionListIndex - 1 + items.length) % items.length;
			highlightRegionListItem(regionListIndex);
		} else if (e.key === 'Enter') {
			if (regionListIndex >= 0 && regionListIndex < items.length) {
				e.preventDefault();
				const li = items[regionListIndex];
				const term = { slug: li.dataset.slug, name: li.textContent };
				addRegionTag(term);
				regionListIndex = -1;
				highlightRegionListItem(regionListIndex);
			}
		} else {
			regionListIndex = -1;
			highlightRegionListItem(regionListIndex);
		}
	});

	// Remet à zéro l'index de sélection à chaque affichage de la liste
	function showRegionList() {
		fetch(window.ajaxurl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: 'action=search_region_terms&query=' + encodeURIComponent(regionInput.value.trim())
		})
			.then(res => res.json())
			.then(data => {
				regionList.innerHTML = '';
				if (data.length) {
					data.forEach(term => {
						if (selectedRegions.some(r => r.slug === term.slug)) return;
						const li = document.createElement('li');
						li.textContent = term.name;
						li.dataset.slug = term.slug;
						li.style.padding = '8px';
						li.style.cursor = 'pointer';
						li.onmouseenter = function () {
							regionListIndex = Array.from(regionList.children).indexOf(li);
							highlightRegionListItem(regionListIndex);
						};
						li.onmouseleave = function () {
							regionListIndex = -1;
							highlightRegionListItem(regionListIndex);
						};
						li.onclick = function () {
							addRegionTag({ slug: term.slug, name: term.name });
						};
						regionList.appendChild(li);
					});
					regionList.style.display = 'block';
					regionListIndex = -1;
					highlightRegionListItem(regionListIndex);
				} else {
					regionList.style.display = 'none';
				}
			});
	}

	// Création du conteneur de tags
	const tagContainer = document.createElement('div');
	tagContainer.className = 'region-tag-container';
	tagContainer.style.display = 'flex';
	tagContainer.style.flexWrap = 'wrap';
	tagContainer.style.gap = '4px';
	regionInput.parentNode.insertBefore(tagContainer, regionInput);
	regionInput.style.flex = '1 1 auto';
	regionInput.style.minWidth = '120px';
	regionInput.style.border = 'none';
	regionInput.style.outline = 'none';

	// Place l'input dans le flux des tags
	tagContainer.appendChild(regionInput);

	function renderTags(shouldFocus = true) {
		// Supprime tous les tags sauf l'input
		Array.from(tagContainer.children).forEach(child => {
			if (child !== regionInput) tagContainer.removeChild(child);
		});
		// Ajoute les tags APRÈS l'input
		selectedRegions.forEach(region => {
			const tag = document.createElement('span');
			tag.className = 'region-tag';
			tag.style.display = 'inline-flex';
			tag.style.alignItems = 'center';
			tag.style.background = '#e0f0ff';
			tag.style.borderRadius = '12px';
			tag.style.padding = '2px 8px 2px 6px';
			tag.style.margin = '2px 0';
			tag.style.fontSize = '0.95em';
			tag.style.cursor = 'default';
			tag.textContent = region.name;
			const close = document.createElement('span');
			close.textContent = '×';
			close.style.marginLeft = '6px';
			close.style.cursor = 'pointer';
			close.style.fontWeight = 'bold';
			close.onclick = function (e) {
				e.stopPropagation();
				selectedRegions = selectedRegions.filter(r => r.slug !== region.slug);
				renderTags(false);
				updateAnnonces();
				regionInput.dispatchEvent(new Event('input'));
				// regionInput.focus();
			};
			tag.appendChild(close);
			tagContainer.appendChild(tag); // <-- appendChild au lieu de insertBefore
		});
		regionInput.value = '';
		if (hasUserInteracted && shouldFocus) {
			regionInput.focus();
		}
	}

	// Initialisation du slider double poignée
	noUiSlider.create(caSlider, {
		start: [caMin, caMax],
		connect: true,
		step: 100000,
		range: { 'min': caMin, 'max': caMax },
		format: { to: v => Math.round(v), from: v => Math.round(v) }
	});
	caSlider.noUiSlider.on('update', function (values) {
		caMin = values[0];
		caMax = values[1];
		caSliderValues.textContent = Number(caMin).toLocaleString() + ' € – ' + Number(caMax).toLocaleString() + ' €';
	});
	caSlider.noUiSlider.on('change', function () {
		page = 1;
		updateAnnonces();
	});

	regionInput.addEventListener('input', function () {
		hasUserInteracted = true;
		clearTimeout(regionTimeout);
		const query = regionInput.value.trim();
		if (query.length < 1) {
			regionList.style.display = 'none';
			return;
		}
		regionTimeout = setTimeout(function () {
			showRegionList();
		}, 200);
	});

	// Affiche la liste au focus si l'input n'est pas vide
	regionInput.addEventListener('focus', function () {
		if (hasUserInteracted) {
			showRegionList();
		}
	});

	regionInput.addEventListener('mousedown', function (e) {
		hasUserInteracted = true;
		showRegionList();
	});

	// Fermer la liste si clic ailleurs
	document.addEventListener('click', function (e) {
		if (!regionInput.contains(e.target) && !regionList.contains(e.target)) {
			regionList.style.display = 'none';
		}
	});

	// Empêche la perte de focus sur l'input quand on clique sur un tag
	tagContainer.addEventListener('mousedown', function (e) {
		if (e.target.classList.contains('region-tag') || e.target.textContent === '×') {
			e.preventDefault();
		}
	});

	function showLoader() {
		wrapper.classList.add('loading');
		document.getElementById('annonces-loader').style.display = 'block';
	}
	function hideLoader() {
		wrapper.classList.remove('loading');
		document.getElementById('annonces-loader').style.display = 'none';
	}

	function updateAnnonces() {
		showLoader();
		const params = new URLSearchParams();
		params.append('action', 'filter_pharmacies');
		params.append('region', selectedRegions.map(r => r.slug).join(','));
		params.append('ca_min', caMin);
		params.append('ca_max', caMax);
		params.append('paged', page);

		fetch(window.ajaxurl, {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
			body: params.toString()
		})
			.then(res => res.text())
			.then(html => {
				hideLoader();
				wrapper.innerHTML = html;
			})
			.catch(() => {
				hideLoader();
			});
	}

	// Initial render
	renderTags();
});