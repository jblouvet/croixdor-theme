/**
 *
 *
 * OFF NAVIGATION MENU
 *
 *
 */

const $nav = document.querySelector('.site-nav');
const $btn = document.querySelector('.menu-btn');
const $body = document.body;
// const $site = document.querySelector('.site-content');

$btn.addEventListener('click', function () {
	navToggle();
});

// $site.addEventListener('click', () => {
// 	if ($body.classList.contains('has-menu-open')) {
// 		$body.classList.remove('has-overflow-hidden');
// 		$body.classList.remove('has-menu-open');
// 		$btn.classList.remove('is-open');
// 		$nav.classList.remove('is-open');
// 	}
// });

function navToggle() {
	$body.classList.toggle('has-overflow-hidden');
	$body.classList.toggle('has-menu-open');
	$btn.classList.toggle('is-open');
	$nav.classList.toggle('is-open');
}