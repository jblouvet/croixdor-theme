<div id="match-tunnel" class="fixed left-0 bottom-0 w-full h-0 min-h-0 overflow-hidden z-50 opacity-0 pointer-events-none [&.is-active]:h-[100vh] [&.is-active]:min-h-[100vh] [&.is-active]:opacity-100 [&.is-active]:pointer-events-auto pt-[106px]" style="transition: height 0.6s cubic-bezier(.77,0,.18,1), min-height 0.6s cubic-bezier(.77,0,.18,1), background-color 0.1s linear;">

	<div class="bg-white rounded-t-[30px] min-h-[calc(100vh-106px)] h-full overflow-y-auto">

		<button class="js-close-match absolute right-[2em] rounded-full top-[126px] opacity-30 hover:opacity-100 transition-opacity cursor-pointer z-1000">
			<svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">

				<path d="M19.5312 5.46875L5.46875 19.5312" stroke="#213350" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
				<path d="M19.5312 19.5312L5.46875 5.46875" stroke="#213350" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />

			</svg>
		</button>

		<?php get_template_part('partials/match', 'choix') ?>

		<?php get_template_part('partials/match', 'vendeur') ?>

		<?php get_template_part('partials/match', 'acquereur') ?>

		<?php get_template_part('partials/match', 'expert') ?>

	</div>
</div>