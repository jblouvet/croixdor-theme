<?php
$argsV = [
	'post_type'      => 'pharmacies',
	'posts_per_page' => 8,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
];
$queryV = new WP_Query($argsV);
$argsA = [
	'post_type'      => 'acquereur',
	'posts_per_page' => 8,
	'post_status'    => 'publish',
	'orderby'        => 'date',
	'order'          => 'DESC',
];
$queryA = new WP_Query($argsA);
?>

<section class="bloc-annonces bg-grey pt-8.5 pb-20">

	<div class="container w-full xl:w-14/16 xl:pt-13.5 flex justify-between mx-auto max-xl:flex-wrap">
	</div>

	<div class="tabs-annonces tabs-container w-full [--tabs-fixedheight:820px]">

		<div class="wrapper">

			<div class="xl:w-14/16 xl:mx-auto flex flex-wrap justify-between items-center gap-x-16 pt-4">

				<h2 class="titre-h2 text-blue mb-4">Nos annonces</h2>

				<div class="tabs-buttons flex mb-2 lg:mb-4 gap-2 bg-white flex-wrap w-fit rounded-[70px] p-1 font-medium shadow-[var(--menu-shadow)]">
					<button class="tab-button text-blue block transition-all bg-white [&.is-active]:bg-blue [&.is-active]:text-white hover:bg-blue hover:text-white cursor-pointer uppercase flex-1 py-[15px] px-[20px] rounded-[70px] tracking-[0.1em] xxs:tracking-[0.2em]">Vendeurs</button>
					<button class="tab-button text-blue block transition-all bg-white [&.is-active]:bg-blue [&.is-active]:text-white hover:bg-blue hover:text-white cursor-pointer uppercase flex-1 py-[15px] px-[20px] rounded-[70px] tracking-[0.1em] xxs:tracking-[0.2em]">Acquéreurs</button>
				</div>
			</div>
		</div>

		<?php if ($queryV->have_posts()) : ?>

			<div class="tab-panel w-full max-xl:pt-12 overflow-visible">

				<div class="no-scrollbar flex gap-5 overflow-x-auto pt-4 xl:pt-13 pb-4 mb-16">

					<?php while ($queryV->have_posts()) : $queryV->the_post(); ?>

						<?php get_template_part('partials/pharmacie', 'annonce'); ?>

					<?php endwhile; ?>

				</div>

				<?php
				$btns = array(
					'wrapperStyle' => 'justify-center max-sm:pb-15',
					'btns' => array(
						0 => array(
							'style' => 'alt',
							'hide_icon' => true,
							'action' => 'link',
							'lien' => array(
								'url' => '/pharmacies/',
								'title' => 'Voir tous les appels d\'offre',
								'target' => '_self'
							)
						),
						1 => array(
							'style' => 'default',
							'hide_icon' => true,
							'action' => 'link',
							'lien' => array(
								'url' => '/deposer-votre-annonce/',
								'title' => 'Déposer une annonce',
								'target' => '_self'
							)
						)
					)
				);
				?>
				<?= get_template_part('partials/bloc', 'cta', $btns) ?>

			</div>

		<?php endif ?>

		<?php if ($queryA->have_posts()) : ?>

			<div class="tab-panel w-full max-xl:pt-12 overflow-visible">

				<div class="no-scrollbar flex gap-5 overflow-x-auto xl:pt-13 pb-4 mb-16">

					<?php while ($queryA->have_posts()) : $queryA->the_post(); ?>

						<?php get_template_part('partials/acquereur', 'annonce'); ?>

					<?php endwhile; ?>

				</div>

				<?php
				$btns = array(
					'wrapperStyle' => 'justify-center max-sm:pb-15',
					'btns' => array(
						0 => array(
							'style' => 'alt',
							'hide_icon' => true,
							'action' => 'link',
							'lien' => array(
								'url' => '/acquereur/',
								'title' => 'Voir tous les acquéreurs',
								'target' => '_self'
							)
						),
						1 => array(
							'style' => 'default',
							'hide_icon' => true,
							'action' => 'link',
							'lien' => array(
								'url' => '/acheter/',
								'title' => 'Déposer une annonce',
								'target' => '_self'
							)
						)
					)
				);
				?>
				<?= get_template_part('partials/bloc', 'cta', $btns) ?>

			</div>

		<?php endif ?>

	</div>

</section>