import "../css/style.css";
import "./components/toggle-nav";
import "./components/headroom";
import { HorizontalScroll } from "./components/horizontal-scroll";
import { Accordion } from "./components/accordion";
import { Tabs } from "./components/tabs";
import "./components/filter-annonces-vendeurs";
import "./components/filter-annonces-acquereurs";
import "./components/matcher";
import "./components/toc";
import { ExpertScroll } from "./components/expert-scroll";
import { ExpertCarousel } from "./components/expert-carousel";
import { initTestimonialsCarousel } from './components/temoignages';

document.addEventListener('DOMContentLoaded', () => {
	new ExpertCarousel('.experts-carousel');
	initTestimonialsCarousel();
});

// document.addEventListener('scroll', function () {
// 	const header = document.querySelector('#header');
// 	if (!header) return;
// 	if (window.scrollY > 100) {
// 		header.classList.add('scrolled');
// 	} else {
// 		header.classList.remove('scrolled');
// 	}
// });

document.addEventListener("DOMContentLoaded", () => {

	new HorizontalScroll('.no-scrollbar');

	new Accordion('.accordion');

	new Tabs('.tabs-default', { showShadow: false });

	new Tabs('.tabs-annonces', { showShadow: false, fixedHeight: 820 });

	new ExpertScroll('.expert-annonce');

	const closeMatchFormsEls = document.querySelectorAll('.js-close-match');

	if (closeMatchFormsEls) {
		closeMatchFormsEls.forEach(btn => {
			btn.addEventListener('click', function () {
				const url = window.location.origin + window.location.pathname;
				const params = new URLSearchParams(window.location.search);

				if (params.has('frm_page')) {
					params.delete('frm_page');
					const newSearch = params.toString();
					if (newSearch) {
						window.location.replace(url + '?' + newSearch);
					} else {
						window.location.replace(url);
					}
				} else {
					window.location.replace(url + window.location.search);
				}
			});
		});
	}

	function initFormButtons(root = document) {
		const nextButtons = root.querySelectorAll('.with_frm_style .frm_submit.frm_flex button.frm_button_submit:not(.frm_prev_page)');
		nextButtons.forEach(el => {
			if (!el.querySelector('.frm-next-span')) {
				const span = document.createElement('span');
				if (el.textContent == 'Découvrez si ça match !') {
					span.className = 'frm-next-span frm-match-span';
					el.prepend(span);
				} else {
					span.className = 'frm-next-span';
					el.appendChild(span);
				}

			}
		});

		const prevButtons = root.querySelectorAll('.with_frm_style .frm_submit.frm_flex button.frm_button_submit ~ .frm_prev_page');
		prevButtons.forEach(el => {
			if (!el.querySelector('.frm-prev-span')) {
				const span = document.createElement('span');
				span.className = 'frm-prev-span';
				el.appendChild(span);
			}
		});
	}

	function debounce(fn, wait = 150) {
		let t;
		return (...args) => {
			clearTimeout(t);
			t = setTimeout(() => fn(...args), wait);
		};
	}

	initFormButtons();

	const observer = new MutationObserver(debounce(() => {
		// on ré-applique globalement, ou on peut cibler uniquement les conteneurs forms
		initFormButtons();
	}, 200));

	observer.observe(document.body, { childList: true, subtree: true });

});