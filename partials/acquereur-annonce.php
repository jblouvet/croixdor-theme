	<?php
	$is_match = $acquereur_id = get_query_var('acquereur_id');
	if (!$acquereur_id) {
		$acquereur_id = get_the_ID();
	}
	$titre = get_post_meta($acquereur_id, 'ac_fonction', true);
	$typologie = get_post_meta($acquereur_id, 'typologie', true);
	$apport = get_post_meta($acquereur_id, 'ac_apport_perso', true);
	$annonce = get_post_meta($acquereur_id, 'ac_annonce', true);
	?>

	<div data-id="<?= $acquereur_id ?>" class="acquereur-annonce w-[310px] shrink-0 shadow-[var(--menu-shadow)] rounded-[30px] flex flex-col">

		<div class="px-7.5 pt-5 pb-6 flex flex-1 h-full flex-col">

			<h2 class="titre-h3 lowercase [&:first-letter]:uppercase text-blue"><?= $titre ?></h2>

			<?php
			$terms = get_the_terms($acquereur_id, 'region');
			if (!empty($terms) && !is_wp_error($terms)) {
				if (count($terms) > 1) :
					$term_name = 'Multi-départements';
				else :
					$term_name = preg_replace('/\s*\(/', ' (', $terms[0]->name);
				endif;
			?>
				<p class="mt-3 leading-[20px] flex">
					<?php get_template_part('partials/icon', 'pin.svg') ?>
					<strong class="font-bold ml-2"><?= esc_html($term_name) ?></strong>
				</p>
			<?php } else { ?>
				<p class="mt-3 leading-[20px]">
					<strong class="font-bold">-</strong>
				</p>
			<?php } ?>

			<p class="mt-1 leading-[20px]">
				<strong class="font-bold">Apport personnel : <?= $apport ? number_format($apport, 0, ',', ' ') . '&nbsp;€' : '-'; ?></strong>
			</p>

			<hr class="my-3 bg-[#213350] opacity-30">

			<p class="mt-2 mb-16 leading-[20px] max-h-[300px] overflow-y-auto">
				<?= $annonce ?>
			</p>

			<?php if (!$is_match) : ?>
				<a class="group block font-display font-bold text-[14px] bg-white text-blue mx-auto px-[18px] rounded-[60px] cursor-pointer transition-all:stroke-blue mt-auto -translate-x-5" href="/match-acquereur-direct/?ac_id=<?= get_the_id() ?>">
					<div class=" flex items-center transition-all [&>svg>path]:stroke-blue ">
						<?php get_template_part('partials/icon', 'arrow-right.svg') ?>
						<span class="ml-2.5 group-hover:underline">Découvrez si ça match !</span>
					</div>
				</a>
			<?php endif ?>

		</div>
	</div>