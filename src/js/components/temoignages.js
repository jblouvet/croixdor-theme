import Swiper from 'swiper';
import { Pagination, Autoplay } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/pagination';

export function initTestimonialsCarousel() {
	new Swiper('.testimonials-swiper', {
		modules: [Pagination, Autoplay],
		loop: true,
		// autoplay: {
		// 	delay: 5000,
		// 	disableOnInteraction: false,
		// },
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
	});
}