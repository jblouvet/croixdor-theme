const jQuery = window.jQuery;
const $ = window.jQuery;

jQuery(document).on('frmFormComplete', function (event, form, response) {
	// Vérifie que c'est le formulaire acquéreur (ID 6)
	const formIdInput = form.querySelector('input[name="form_id"]');
	if (!formIdInput || formIdInput.value !== '6') {
		return;
	}

	// Nettoie l'URL et masque le message natif Formidable
	const cleanUrl = window.location.pathname;
	window.history.replaceState({}, '', cleanUrl);

	// Récupère les valeurs des champs Région (145) et Typologie (154)
	const regionValues = [];
	const regionInputs = form.querySelectorAll('input[name^="item_meta[145]"][type="hidden"]');
	regionInputs.forEach(input => {
		if (input.value) regionValues.push(input.value);
	});

	const typologieValues = [];
	const typologieInputs = form.querySelectorAll('input[name^="item_meta[154]"][type="hidden"]');
	typologieInputs.forEach(input => {
		if (input.value) typologieValues.push(input.value);
	});

	let allVendeurIds = [];

	// Prépare les données pour la requête AJAX
	const params = new URLSearchParams();
	params.append('action', 'match_acquirer_search');
	regionValues.forEach(val => params.append('region[]', val));
	typologieValues.forEach(val => params.append('typologie[]', val));

	// Envoie la requête AJAX pour obtenir le nombre de matches
	fetch(window.location.origin + '/wp-admin/admin-ajax.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded',
		},
		body: params
	})
		.then(response => response.json())
		.then(data => {
			console.log('Réponse:', data);

			// Sélectionne les blocs de résultats
			const resultsContainer = document.querySelector('#match-tunnel-acheteur .results');
			const hasResultsDiv = resultsContainer.querySelector('.has-results');
			const noResultsDiv = resultsContainer.querySelector('.no-results');

			// Cache les blocs avant la requête AJAX
			hasResultsDiv.classList.add('hidden');
			noResultsDiv.classList.add('hidden');

			// Affiche le bon bloc selon le nombre de matches
			if (data.success && data.data.matches_count > 0) {
				hasResultsDiv.classList.remove('hidden');
				noResultsDiv.classList.add('hidden');
			} else {
				hasResultsDiv.classList.add('hidden');
				noResultsDiv.classList.remove('hidden');
			}
		})
		.catch(error => {
			console.error('Erreur:', error);
		});
});