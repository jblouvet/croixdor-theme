const jQuery = window.jQuery;
const $ = window.jQuery;

function getFrmPageFromUrl() {
	const urlParams = new URLSearchParams(window.location.search);
	return urlParams.get('frm_page');
}

document.addEventListener('DOMContentLoaded', function () {

	document.addEventListener('submit', function (e) {

		let allExpertsIds = [];
		let selectedExpertsIds = [];

		// Return early si mauvais formulaire
		const form = e.target;
		const formIdInput = form.querySelector('input[name="form_id"]');
		if (!formIdInput || formIdInput.value !== '10') return;

		// Récupérer le numéro de page réel
		const currentPage = getFrmPageFromUrl();

		// Return early si pas la dernière page avant match
		if (currentPage !== '3') return;

		// Stopper le submit
		e.preventDefault();

		// Récupérer région(s)
		// const regionValues = [];
		// const regionInputs = form.querySelectorAll('input[name^="item_meta[234]"][type="hidden"]');
		// regionInputs.forEach(input => {
		// 	if (input.value) regionValues.push(input.value);
		// });

		// Récupérer type d'expert
		const typeValues = [];
		const typeSelect = form.querySelector('input[name="item_meta[254]"]');
		if (typeSelect && typeSelect.value) {
			typeValues.push(typeSelect.value);
			console.log(typeValues);
		}

		// ID du champ besoins correspondant au type
		const checkboxFieldMapping = {
			'Expert-comptable': '257',
			'Avocat': '267',
			'Groupement': '268',
			'formateur': '269',
			'Prestataire de service': '270',
			'Banque': '271'
		};

		// Récupérer les valeurs cochées selon le type sélectionné
		const besoinValues = [];
		if (typeValues.length > 0) {
			const selectedType = typeValues[0];
			const checkboxFieldId = checkboxFieldMapping[selectedType];

			if (checkboxFieldId) {
				const besoinInputs = form.querySelectorAll(
					`input[name^="item_meta[${checkboxFieldId}]"][type="hidden"]`
				);
				besoinInputs.forEach(input => {
					if (input.value) besoinValues.push(input.value);
				});
				console.log(besoinValues);
			}
		}

		// Construire la requête
		const params = new URLSearchParams();
		params.append('action', 'match_expert_search');
		// regionValues.forEach(val => params.append('region[]', val));
		typeValues.forEach(val => params.append('exp_type[]', val));
		besoinValues.forEach(val => params.append('exp_values[]', val));

		// Récupérer les résultats de la requête
		fetch(window.location.origin + '/wp-admin/admin-ajax.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
			body: params
		})
			.then(response => response.json())
			.then(data => {
				// Stocker les éléments pour le matching
				const resultsDiv = document.querySelector('#match-tunnel-expert .results');
				const matchItemsDiv = resultsDiv.querySelector('.match-items');
				// const matchesNbr = resultsDiv.querySelector('.js-count-matches');
				const btnYes = resultsDiv.querySelector('.btn-match-yes');
				const btnNo = resultsDiv.querySelector('.btn-match-no');

				// Si on a bien récupéré les données et qu'il y a match
				if (data.success && data.data.matches_count > 0) {

					// Afficher le matching
					resultsDiv.classList.add('is-active');

					// Stocker tous les IDs reçus
					allExpertsIds = data.data.expert_ids;

					// if (data.data.matches_count > 1) {
					// 	matchesNbr.textContent = `${data.data.matches_count} acquéreurs correspondent à vos critères`;
					// } else {
					// 	matchesNbr.textContent = "1 acquéreur correspond à vos critères";
					// }

					// Vider les matchs au cas où (useless i think)
					matchItemsDiv.innerHTML = '';

					matchItemsDiv.classList.add('is-stack');

					// Récupérer les acquéreurs retournées par la requête
					// Créer une carte pour chacun
					const fetchPromises = data.data.expert_ids.map(id => {
						fetch(`/wp-admin/admin-ajax.php?action=get_expert_template&id=${id}`)
							.then(res => res.text())
							.then(html => {
								const stackWrapper = document.createElement('div');
								stackWrapper.innerHTML = html;
								const card = stackWrapper.firstElementChild;
								matchItemsDiv.appendChild(card);
							});
					});

					// Une fois toutes les cartes récupérées et affichées
					Promise.all(fetchPromises).then(() => {

						// Gestion du clic sur Yes
						btnYes.addEventListener('click', function () {

							// Récupérer la 1è carte de la liste
							const topCard = matchItemsDiv.querySelector('.expert-annonce:nth-child(1)');

							// Stop si plus de carte
							if (!topCard) return;

							// Récupérer l'id de l'expert...
							const expertId = topCard.dataset.id;

							// ... et le stocker
							if (expertId) {
								selectedExpertsIds.push(expertId);
							}

							// Supprimer toutes les cartes restantes
							matchItemsDiv.innerHTML = '';

							// Remplir l'input caché 217 avec la liste des IDs
							const inputAllMatches = document.querySelector('input[name="item_meta[231]"]');
							if (inputAllMatches) {
								inputAllMatches.value = allExpertsIds.join(',');
							}

							// Mettre à jour le champ caché 218 avec les IDs sélectionnés
							const inputSelectedMatches = document.querySelector('input[name="item_meta[232]"]');
							if (inputSelectedMatches) {
								inputSelectedMatches.value = selectedExpertsIds.join(',');
							}

							// Remplir l'affichage du décompte final
							const selectedCount = selectedExpertsIds.length;
							const finalCount = document.querySelector('.final-results-count');
							const finalStep = document.querySelector('.final-results-step');
							if (finalCount) {
								if (selectedCount === 0) {
									finalCount.textContent = "On y est presque";
								} else {
									finalCount.textContent = `Vous êtes intéressé par ces experts`;
								}
							}
							if (finalStep) {
								if (selectedCount === 0) {
									finalStep.textContent = "Renseignez vos coordonnées pour finaliser votre recherche."
								} else {
									finalStep.textContent = "Renseignez vos coordonnées pour finaliser la mise en relation."
								}
							}

							// Masquer le conteneur des résultats pour afficher la dernière page du formulaire
							resultsDiv.classList.remove('is-active');
							resultsDiv.classList.add('hidden');

						});

						// Gestion du clic sur No
						btnNo.addEventListener('click', function () {

							// Récupérer la 1è carte de la liste
							const topCard = matchItemsDiv.querySelector('.expert-annonce:nth-child(1)');

							// Stop si plus de carte
							if (!topCard) return;

							// Supprimer la carte
							removeTopCard('left');
						});
					});

					// Fonction pour retirer la première carte avec animation
					function removeTopCard(direction) {

						const topCard = matchItemsDiv.querySelector('.expert-annonce:nth-child(1)');

						if (!topCard) return;

						// Retire les classes d'animation si présentes
						topCard.classList.remove('swipe-right', 'swipe-left');

						// Force le reflow avant d'ajouter la classe
						topCard.offsetHeight;

						requestAnimationFrame(() => {

							if (direction === 'right') {
								topCard.classList.add('swipe-right');
							} else {
								topCard.classList.add('swipe-left');
							}

						});

						// Après l'animation, retire la carte du DOM et adapte la pile
						topCard.addEventListener('transitionend', function handler(e) {

							topCard.removeEventListener('transitionend', handler);

							topCard.remove();

							// Réorganise la pile (les classes CSS s'adaptent automatiquement avec nth-child)
							updateAfterCardRemove();
						});
					}

					// Fonction appelée après chaque suppression de carte
					function updateAfterCardRemove() {

						const remainingCards = matchItemsDiv.querySelectorAll('.expert-annonce');

						if (remainingCards.length === 0) {

							// Remplir l'input caché 217 avec la liste des IDs
							const inputAllMatches = document.querySelector('input[name="item_meta[231]"]');
							if (inputAllMatches) {
								inputAllMatches.value = allExpertsIds.join(',');
							}

							// Mettre à jour le champ caché 218 avec les IDs sélectionnés
							const inputSelectedMatches = document.querySelector('input[name="item_meta[232]"]');
							if (inputSelectedMatches) {
								inputSelectedMatches.value = selectedExpertsIds.join(',');
							}

							// Remplir l'affichage du décompte final
							const selectedCount = selectedExpertsIds.length;
							const finalCount = document.querySelector('.final-results-count');
							const finalStep = document.querySelector('.final-results-step');
							if (finalCount) {
								if (selectedCount === 0) {
									finalCount.textContent = "Vos critères ont bien été enregistrés";
								} else if (selectedCount === 1) {
									finalCount.textContent = "Vous avez sélectionné 1 expert";
								} else {
									finalCount.textContent = `Vous avez sélectionné ${selectedCount} experts`;
								}
							}
							if (finalStep) {
								if (selectedCount === 0) {
									finalStep.textContent = "Renseignez vos coordonnées afin que nous revenions vers vous pour vous aider dans votre recherche d'un expert."
								} else {
									finalStep.textContent = "Renseignez vos coordonnées pour finaliser la mise en relation."
								}
							}

							// Masquer le conteneur des résultats pour afficher la dernière page du formulaire
							resultsDiv.classList.remove('is-active');
							resultsDiv.classList.add('hidden');

						}
					}

					// Sinon pas de données / pas de match
					// La dernière page s'affiche
				} else {
					console.log('problem');
				}

			})
			.catch(error => {
				console.error('Erreur:', error);
			});
	});

});