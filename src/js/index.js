
import "../css/style.css";
import "./components/toggle-nav";
import "./components/headroom";
import { HorizontalScroll } from "./components/horizontal-scroll";
import { Accordion } from "./components/accordion";
import { Tabs } from "./components/tabs";
import { ExpertCarousel } from "./components/expert-carousel";
import { initTestimonialsCarousel } from './components/temoignages';
import { InscriptionForm } from "./components/inscription";

document.addEventListener('DOMContentLoaded', () => {

	new ExpertCarousel('.experts-carousel');
	initTestimonialsCarousel();
});

document.addEventListener("DOMContentLoaded", () => {

	new HorizontalScroll('.no-scrollbar');

	new Accordion('.accordion');

	new Tabs('.tabs-default', { showShadow: false });

	new Tabs('.tabs-annonces', { showShadow: false, fixedHeight: 820 });

	new InscriptionForm();
});