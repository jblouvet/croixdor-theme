<?php /* Template Name: Résultats de matchs */ ?>

<?php get_header(); ?>

<?php
// Récupération des paramètres d'URL
$has_match = isset($_GET['has_match']) ? sanitize_text_field($_GET['has_match']) : '';
$no_match = isset($_GET['no_match']) ? sanitize_text_field($_GET['no_match']) : '';
$form_id = isset($_GET['form_id']) ? intval($_GET['form_id']) : 0;
?>

<div class="site-content flex-1">

	<main class="page-content">

		<article>

			<section class="bloc-wysiwyg">
				<div class="wrapper">

					<div class="w-full xl:w-14/16 mx-auto">

						<div class="editor-content lg:w-6/8 mx-auto py-12 lg:py-14 px-10 xl:px-20 max-lg:pb-0">

							<svg class="mx-auto mb-5" width="93" height="93" viewBox="0 0 93 93" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M46.5 8.71875C39.0276 8.71875 31.723 10.9346 25.5099 15.086C19.2968 19.2375 14.4543 25.1381 11.5947 32.0417C8.73512 38.9454 7.98693 46.5419 9.44472 53.8708C10.9025 61.1996 14.5008 67.9316 19.7846 73.2154C25.0684 78.4992 31.8004 82.0975 39.1293 83.5553C46.4581 85.0131 54.0547 84.2649 60.9583 81.4053C67.8619 78.5457 73.7625 73.7032 77.914 67.4901C82.0654 61.277 84.2813 53.9724 84.2813 46.5C84.2707 36.483 80.2868 26.8794 73.2037 19.7963C66.1206 12.7132 56.517 8.72933 46.5 8.71875ZM63.0874 39.8374L42.7437 60.1812C42.4738 60.4514 42.1533 60.6657 41.8004 60.812C41.4476 60.9583 41.0694 61.0335 40.6875 61.0335C40.3056 61.0335 39.9274 60.9583 39.5746 60.812C39.2218 60.6657 38.9013 60.4514 38.6313 60.1812L29.9126 51.4624C29.3673 50.9171 29.0609 50.1775 29.0609 49.4062C29.0609 48.635 29.3673 47.8954 29.9126 47.3501C30.4579 46.8047 31.1976 46.4984 31.9688 46.4984C32.74 46.4984 33.4796 46.8047 34.0249 47.3501L40.6875 54.0163L58.9751 35.7251C59.2451 35.4551 59.5657 35.2409 59.9185 35.0947C60.2713 34.9486 60.6494 34.8734 61.0313 34.8734C61.4131 34.8734 61.7913 34.9486 62.1441 35.0947C62.4969 35.2409 62.8174 35.4551 63.0874 35.7251C63.3575 35.9951 63.5716 36.3157 63.7178 36.6685C63.8639 37.0213 63.9391 37.3994 63.9391 37.7812C63.9391 38.1631 63.8639 38.5412 63.7178 38.894C63.5716 39.2468 63.3575 39.5674 63.0874 39.8374Z" fill="#50DDA4" />
							</svg>

							<h1 class="titre-h1 text-center text-blue mb-4.5 lg:mb-7 w-full max-w-[15em] mx-auto">
								<?php if ($form_id === 7) : ?>

									<?php if ($has_match) : ?>
										Nous avons bien enregistré vos coordonnées.
									<?php elseif ($no_match): ?>
										Aucun acquéreur ne semble correspondre à vos critères de recherche.
									<?php endif; ?>
								<?php elseif ($form_id === 10) : ?>
									<?php if ($has_match) : ?>
										Nous avons bien enregistré vos coordonnées.
									<?php elseif ($no_match): ?>
										Aucun expert ne semble correspondre à vos critères de recherche.
									<?php endif; ?>
								<?php else : ?>
									<?php the_title() ?>
								<?php endif ?>
							</h1>

							<p class="chapo !my-5 xl:!mt-15 xl:!mb-20 text-center max-w-[24em] mx-auto">
								<?php if ($form_id === 7) : ?>
									<?php if ($has_match) : ?>
										Notre équipe vous contactera très prochainement pour vous mettre en relation avec les acquéreurs correspondants à vos critères.
									<?php elseif ($no_match): ?>
										Notre équipe vous contactera très prochainement pour affiner votre besoin et vous mettre en relation avec des acquéreurs qui vous correspondent.
									<?php endif; ?>
								<?php elseif ($form_id === 10) : ?>
									<?php if ($has_match) : ?>
										Notre équipe vous contactera très prochainement pour vous mettre en relation avec les experts correspondants à vos critères.
									<?php elseif ($no_match): ?>
										Notre équipe vous contactera très prochainement pour affiner votre besoin et vous mettre en relation avec des experts qui vous correspondent.
									<?php endif; ?>
								<?php else : ?>
									<?php the_title() ?>
								<?php endif ?>
							</p>

							<a class="group block font-display font-bold text-[16px] bg-blue text-white max-w-[20em] mx-auto pt-[16px] pb-[16px] px-[28px] rounded-[60px] cursor-pointer max-xl:mb-[48px]" href="/">
								<div class="flex items-center justify-center group-hover:-translate-y-[4px] translate-y-0 transition-all">
									<span>Retour à l'accueil</span>
								</div>
							</a>

						</div>

					</div>
				</div>
			</section>

		</article>

	</main>

</div>

<?php get_footer(); ?>