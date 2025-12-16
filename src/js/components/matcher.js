import "../components/acquirer-matcher";
import "../components/vendor-matcher";
import "../components/expert-matcher";

document.addEventListener("DOMContentLoaded", () => {

	const tunnel = document.getElementById('match-tunnel');
	const start = document.getElementById('match-tunnel-start');
	const vendeur = document.getElementById('match-tunnel-vendeur');
	const acheteur = document.getElementById('match-tunnel-acheteur');
	const expert = document.getElementById('match-tunnel-expert');

	// Au clic sur .js-match, on affiche le tunnel
	document.querySelectorAll('.js-match').forEach(el => {
		el.addEventListener('click', function (e) {
			e.preventDefault();
			tunnel.classList.add('is-active');
			start.classList.add('is-visible');

			document.body.classList.add('no-scroll');

			// Ajoute le fond après la transition
			tunnel.addEventListener('transitionend', function handler(event) {
				if (event.propertyName === 'height' || event.propertyName === 'min-height') {
					tunnel.classList.add('bg-black/50');
					tunnel.removeEventListener('transitionend', handler);
				}
			});
		});
	});

	// Au clic sur une entrée, on affiche la bonne section
	document.querySelectorAll('.js-tunnel-choice').forEach(btn => {
		btn.addEventListener('click', function () {
			// start.style.opacity = 0;
			setTimeout(() => {
				// start.style.display = 'none';
				[start, vendeur, acheteur, expert].forEach(el => {
					el.classList.remove('is-visible');
				});
				let target;
				if (btn.dataset.target === 'vendeur') target = vendeur;
				if (btn.dataset.target === 'acheteur') target = acheteur;
				if (btn.dataset.target === 'expert') target = expert;
				if (target) {
					target.classList.add('is-visible');
				}
			}, 400);
		});
	});
});