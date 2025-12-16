const jQuery = window.jQuery;
const $ = window.jQuery;

function getFrmPageFromUrl() {
	const urlParams = new URLSearchParams(window.location.search);
	return urlParams.get('frm_page');
}

document.addEventListener('DOMContentLoaded', function () {

	document.addEventListener('submit', function (e) {

		let allAcquereurIds = [];
		let selectedAcquereurIds = [];

		// Return early si mauvais formulaire
		const form = e.target;
		const formIdInput = form.querySelector('input[name="form_id"]');
		if (!formIdInput || formIdInput.value !== '7') return;

		// Récupérer le numéro de page réel
		const currentPage = getFrmPageFromUrl();

		// Return early si pas la dernière page avant match
		if (currentPage !== '3') return;

		// Stopper le submit
		e.preventDefault();

		// Récupérer région(s)
		const regionValues = [];
		const regionInputs = form.querySelectorAll('input[name^="item_meta[175]"][type="hidden"]');
		regionInputs.forEach(input => {
			if (input.value) regionValues.push(input.value);
		});

		// Récupérer typologie(s)
		const typologieValues = [];
		const typologieRadio = form.querySelector('input[name="item_meta[184]"]:checked');
		if (typologieRadio && typologieRadio.value) {
			typologieValues.push(typologieRadio.value);
		}

		// Construire la requête
		const params = new URLSearchParams();
		params.append('action', 'match_vendor_search');
		regionValues.forEach(val => params.append('region[]', val));
		typologieValues.forEach(val => params.append('typologie[]', val));

		console.log(regionValues);
		console.log(typologieValues);

		// Récupérer les résultats de la requête
		fetch(window.location.origin + '/wp-admin/admin-ajax.php', {
			method: 'POST',
			headers: { 'Content-Type': 'application/x-www-form-urlencoded', },
			body: params
		})
			.then(response => {
				console.log(response);
				return response.json()
			}
			)
			.then(data => {
				// Stocker les éléments pour le matching
				const resultsDiv = document.querySelector('#match-tunnel-vendeur .results');
				const matchItemsDiv = resultsDiv.querySelector('.match-items');
				const matchesNbr = resultsDiv.querySelector('.js-count-matches');
				const btnYes = resultsDiv.querySelector('.btn-match-yes');
				const btnNo = resultsDiv.querySelector('.btn-match-no');

				// Si on a bien récupéré les données et qu'il y a match
				if (data.success && data.data.matches_count > 0) {

					console.log('yes match');

					// Afficher le matching
					resultsDiv.classList.add('is-active');

					// Stocker tous les IDs reçus
					allAcquereurIds = data.data.acquereur_ids;

					if (data.data.matches_count > 1) {
						matchesNbr.textContent = `${data.data.matches_count} acquéreurs correspondent à vos critères`;
					} else {
						matchesNbr.textContent = "1 acquéreur correspond à vos critères";
					}

					// Vider les matchs au cas où (useless i think)
					matchItemsDiv.innerHTML = '';

					matchItemsDiv.classList.add('is-stack');

					// Récupérer les acquéreurs retournées par la requête
					// Créer une carte pour chacun
					const fetchPromises = data.data.acquereur_ids.map(id => {
						fetch(`/wp-admin/admin-ajax.php?action=get_acquereur_template&id=${id}`)
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
							const topCard = matchItemsDiv.querySelector('.acquereur-annonce:nth-child(1)');

							// Stop si plus de carte
							if (!topCard) return;

							// Récupérer l'id de l'acquereur...
							const acquereurId = topCard.dataset.id;

							// ... et le stocker
							if (acquereurId) {
								selectedAcquereurIds.push(acquereurId);
							}

							// On supprime toutes les cartes restantes (on arrête le matching ici)
							matchItemsDiv.innerHTML = '';

							// On remplit l'input caché 217 avec la liste de tous les IDs proposés
							const inputAllMatches = document.querySelector('input[name="item_meta[217]"]');
							if (inputAllMatches) {
								inputAllMatches.value = allAcquereurIds.join(',');
							}

							// On met à jour l'input caché 218 avec les IDs sélectionnés (ici, un seul)
							const inputSelectedMatches = document.querySelector('input[name="item_meta[218]"]');
							if (inputSelectedMatches) {
								inputSelectedMatches.value = selectedAcquereurIds.join(',');
							}

							updateFinalResults(selectedAcquereurIds.length);

							// On masque le conteneur des résultats pour afficher la dernière page du formulaire
							resultsDiv.classList.remove('is-active');
							resultsDiv.classList.add('hidden');
						});

						// Gestion du clic sur No
						btnNo.addEventListener('click', function () {

							// Récupérer la 1è carte de la liste
							const topCard = matchItemsDiv.querySelector('.acquereur-annonce:nth-child(1)');

							// Stop si plus de carte
							if (!topCard) return;

							// Supprimer la carte
							removeTopCard('left');
						});
					});

					// Fonction pour retirer la première carte avec animation
					function removeTopCard(direction) {

						const topCard = matchItemsDiv.querySelector('.acquereur-annonce:nth-child(1)');

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

						const remainingCards = matchItemsDiv.querySelectorAll('.acquereur-annonce');

						if (remainingCards.length === 0) {

							// Remplir l'input caché 217 avec la liste des IDs
							const inputAllMatches = document.querySelector('input[name="item_meta[217]"]');
							if (inputAllMatches) {
								inputAllMatches.value = allAcquereurIds.join(',');
							}

							// Mettre à jour le champ caché 218 avec les IDs sélectionnés
							const inputSelectedMatches = document.querySelector('input[name="item_meta[218]"]');
							if (inputSelectedMatches) {
								inputSelectedMatches.value = selectedAcquereurIds.join(',');
							}

							updateFinalResults(selectedAcquereurIds.length);

							// Masquer le conteneur des résultats pour afficher la dernière page du formulaire
							resultsDiv.classList.remove('is-active');
							resultsDiv.classList.add('hidden');

						}
					}

					function updateFinalResults(selectedCount) {
						const finalCount = document.querySelector('.final-results-count');
						const finalStep = document.querySelector('.final-results-step');

						if (finalCount) {
							if (selectedCount === 0) {
								finalCount.textContent = "On y est presque !";
							} else {
								finalCount.textContent = "Vous êtes intéressé par ces acquéreurs";
							}
						}

						if (finalStep) {
							if (selectedCount === 0) {
								finalStep.textContent = "Renseignez vos coordonnées pour finaliser votre recherche.";
							} else {
								finalStep.textContent = "Renseignez vos coordonnées pour finaliser la mise en relation.";
							}
						}
					}

					// Sinon pas de données / pas de match
					// La dernière page s'affiche
				} else {
					console.log('no match')
				}

			})
			.catch(error => {
				console.error('Erreur:', error);
			});
	});

});