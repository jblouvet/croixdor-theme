document.addEventListener('DOMContentLoaded', function () {
	const postContent = document.querySelector('.post-content');
	const tocContainer = document.querySelector('.post-tdm');
	if (!postContent || !tocContainer) return;

	const headings = postContent.querySelectorAll('h2');
	if (headings.length === 0) return;

	// Crée la liste des ancres
	const ul = document.createElement('ul');
	ul.className = 'toc-list';

	let isManualScroll = false;

	headings.forEach((h2, idx) => {
		// Ajoute un id unique si absent
		if (!h2.id) h2.id = 'section-' + (idx + 1);

		const li = document.createElement('li');
		li.classList.add('toc-item', 'opacity-40', 'mb-[1em]', 'leading-[1.4]', 'hover:opacity-100', '[&.is-active]:opacity-100', 'before:block', 'before:rounded-full', 'before:content[""]', 'before:bg-transparent', 'before:w-[9px]', 'before:h-[9px]', '[&.is-active]:before:bg-green', 'flex', 'items-start', 'gap-[7px]', 'before:mt-[5px]');
		const a = document.createElement('a');
		a.textContent = h2.textContent;
		a.href = '#' + h2.id;
		a.addEventListener('click', function (e) {
			e.preventDefault();
			isManualScroll = true;
			document.getElementById(h2.id).scrollIntoView({ behavior: 'smooth', block: 'start' });
			tocItems.forEach(item => item.classList.remove('is-active'));
			li.classList.add('is-active');
			setTimeout(() => { isManualScroll = false; }, 800);
		});
		li.appendChild(a);
		ul.appendChild(li);
	});

	tocContainer.appendChild(ul);

	// Highlight au scroll
	const tocItems = ul.querySelectorAll('li');
	function onScroll() {
		if (isManualScroll) return;
		let activeIdx = 0;
		const offset = 100; // Décalage haut pour l'activation
		headings.forEach((h2, idx) => {
			const rect = h2.getBoundingClientRect();
			if (rect.top - offset < window.innerHeight / 2) {
				activeIdx = idx;
			}
		});
		tocItems.forEach((li, idx) => {
			if (idx === activeIdx) {
				li.classList.add('is-active');
			} else {
				li.classList.remove('is-active');
			}
		});
	}
	window.addEventListener('scroll', onScroll);
	onScroll();
});