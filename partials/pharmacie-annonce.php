<div class="pharmacie-annonce w-[310px] shrink-0 shadow-[var(--menu-shadow)] rounded-[30px] flex flex-col">
	<?php
	setlocale(LC_TIME, 'fr_FR.UTF-8');
	$titre = get_post_meta(get_the_id(), 'titre_annonce', true);
	$typologie = get_post_meta(get_the_id(), 'typologie', true);
	$marge = get_post_meta(get_the_id(), 'marge_bilan', true);
	$ebe = get_post_meta(get_the_id(), 'ebe_bilan', true);
	$montant_offre = get_post_meta(get_the_ID(), 'montant_offre', true);
	$date_raw = get_post_meta(get_the_ID(), 'fin_offre', true);
	$afficher_appel_offre = false;
	$date_affiche = false;
	if ($date_raw) {
		$date = DateTime::createFromFormat('Y-m-d', $date_raw);
		if ($date) {
			$today = new DateTime('today');
			if ($date >= $today) {
				$afficher_appel_offre = true;
			}
			$fmt = new IntlDateFormatter(
				'fr_FR',
				IntlDateFormatter::LONG,
				IntlDateFormatter::NONE,
				null,
				null,
				'dd MMMM yyyy'
			);
			$date_affiche = $fmt->format($date);
		}
	}
	/*
	- Centre-ville
	- Centre-commercial
	- Zone semi-rurale
	- Zone rurale
	- Quartier
	*/
	$ca = get_post_meta(get_the_id(), 'chiffre_daffaires', true);
	switch ($typologie) {
		case 'Centre-ville':
			// centre-ville
			$icon_filename = 'centre-ville.svg';
			$img_filename = 'centre-ville.jpeg';
			break;
		case 'Centre-commercial':
			// centre-commercial
			$icon_filename = 'centre-commercial.svg';
			$img_filename = 'centre-commercial.jpeg';
			break;
		case 'Zone semi-rurale':
			// semi-rurale
			$icon_filename = 'semi-rurale.svg';
			$img_filename = 'semi-rurale.jpeg';
			break;
		case 'Zone rurale':
			// rurale
			$icon_filename = 'rurale.svg';
			$img_filename = 'rurale.jpeg';
			break;
		case 'Quartier':
			// quartier
			$icon_filename = 'quartier.svg';
			$img_filename = 'quartier.jpeg';
			break;
		case 'Zone urbaine':
			// quartier
			$icon_filename = 'zone-urbaine.svg';
			$img_filename = 'retail-dynamique.jpeg';
			break;
		default:
			// retail dynamique
			$icon_filename = 'retail-dynamique.svg';
			$img_filename = 'retail-dynamique.jpeg';
			break;
	}
	/*
	centre commercial OK
	centre ville OK
	zone urbaine ?
	zone rurale OK
	zone semi-rurale OK
	pharmacie de quartier OK
	*/
	?>

	<figure class="aspect-[31/10] h-[98px] relative z-1">
		<img src="<?= get_template_directory_uri() ?>/assets/img/<?= $img_filename ?>" alt="" class="w-full h-full object-cover rounded-t-[30px] backdrop-blur-xl">
		<div class="absolute inset-0 rounded-t-[30px] bg-white/5 backdrop-blur-[1px] pointer-events-none z-10"></div>
		<?php if ($afficher_appel_offre) : ?>
			<span class="absolute rounded-[40px] top-[15px] left-[28px] bg-white/70 py-2.5 px-3 flex items-center flex-wrap z-20">
				<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.1562 6.375H14.3438V3.1875" stroke="#213350" stroke-linecap="round" stroke-linejoin="round" />
					<path d="M14.3438 6.37489L12.4658 4.49692C11.3782 3.40938 9.90573 2.79445 8.36771 2.7855C6.8297 2.77655 5.35016 3.3743 4.25 4.44911" stroke="#213350" stroke-linecap="round" stroke-linejoin="round" />
					<path d="M5.84375 10.625H2.65625V13.8125" stroke="#213350" stroke-linecap="round" stroke-linejoin="round" />
					<path d="M2.65625 10.625L4.53422 12.503C5.6218 13.5905 7.09427 14.2054 8.63229 14.2144C10.1703 14.2233 11.6498 13.6256 12.75 12.5508" stroke="#213350" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
				<span class="pl-1">Appel d'offre en cours</span>
			</span>
		<?php endif ?>
	</figure>

	<div class="px-7.5 pt-6 pb-6 flex flex-1 h-full flex-col relative">

		<div class="annonce-icon absolute right-4 top-0 -translate-y-[40px] z-2">
			<?= get_template_part('partials/icon', $icon_filename); ?>
		</div>

		<h2 class="titre-h3 lowercase [&:first-letter]:uppercase text-blue pr-5"><?= $titre ?></h2>

		<?php
		$terms = get_the_terms(get_the_ID(), 'region');
		if (!empty($terms) && !is_wp_error($terms)) {
			$term_name = preg_replace('/\s*\(/', ' (', $terms[0]->name);
			echo '<p class="mt-1 text-blue">' . esc_html($term_name) . '</p>';
		} else {
			echo '<p class="mt-1 text-blue">-</p>';
		}
		?>

		<p class="mt-7 leading-[20px]">
			CA HT : <strong class="font-bold"><?= $ca ? number_format($ca, 0, ',', ' ') . '&nbsp;€' : '-'; ?>
				<?php if ($ca) {
					get_template_part('partials/icon', 'croissance.svg');
				} ?></strong>
		</p>

		<p class="leading-[20px]">Marge brute : <strong class="font-bold"><?= $marge ? number_format($marge, 0, ',', ' ') . '&nbsp;€' : '-'; ?></strong></p>

		<p class="leading-[20px]">EBE reconstitué : <strong class="font-bold"><?= $ebe ? number_format($ebe, 0, ',', ' ') . '&nbsp;€' : 'non renseigné'; ?></strong></p>

		<hr class="my-3 bg-[#213350] opacity-30">

		<p>Prix de la première offre possible&nbsp;:<br><strong class="font-bold"><?= $montant_offre ? number_format($montant_offre, 0, ',', ' ') . '&nbsp;€' : '-'; ?></strong></p>

		<p class="mt-2 mb-16">Date de fin de la remise des offres&nbsp;<br><strong class="inline-flex mt-[.4em] font-bold px-3 py-2 bg-grey rounded-[5px]"><?= $date_affiche ? $date_affiche : '-'; ?></strong></p>

		<?php if ($afficher_appel_offre) : ?>
			<a class="js-appel-offre group block font-display font-bold text-[14px] bg-white text-blue mx-auto mt-auto -translate-x-5 px-[18px] rounded-[60px] cursor-pointer transition-all:stroke-blue" href="/participer-a-lappel-doffre/?ph_id=<?= get_the_id() ?>">
				<div class=" flex items-center transition-all [&>svg>path]:stroke-blue ">
					<?php get_template_part('partials/icon', 'arrow-right.svg') ?>
					<span class="ml-2.5 group-hover:underline">Participer à l'appel d'offres</span>
				</div>
			</a>
		<?php endif ?>
	</div>
</div>