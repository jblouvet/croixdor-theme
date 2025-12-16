<?php /* Template Name: Formulaire */ ?>

<?php
$ph_id = isset($_GET['ph_id']) ? intval($_GET['ph_id']) : 0;
$pharmacy_exists = false;
$ac_id = isset($_GET['ac_id']) ? intval($_GET['ac_id']) : 0;

$is_ph = $is_ac = NULL;

if ($ph_id) {
	$ph = get_post($ph_id);
	$is_ph = $ph && $ph->post_type === 'pharmacies';
}

if ($ac_id) {
	$ac = get_post($ac_id);
	$is_ac = $ac && $ac->post_type === 'acquereur';
}

?>

<?php get_header(); ?>

<div class="site-content flex-1">

	<main class="page-content">

		<article class="article-formulaire">

			<div class="wrapper">

				<?php if ($is_ph || $is_ac) : ?>

					<?php if ($is_ph) : ?>
						<div class="xl:flex xl:flex-wrap xl:justify-center xl:w-14/16 xl:mx-auto">
							<div class="col w-full xl:w-6/14 pb-12">
								<div class="xl:w-4/6 xl:relative xl:after:absolute xl:after:-right-[20%] xl:after:block xl:after:h-full xl:after:top-0 xl:after:w-[1px] xl:after:bg-grey">
									<svg class=" mb-6 block max-xl:mx-auto" width="93" height="93" viewBox="0 0 93 93" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M46.5 8.71875C39.0276 8.71875 31.723 10.9346 25.5099 15.086C19.2968 19.2375 14.4543 25.1381 11.5947 32.0417C8.73512 38.9454 7.98693 46.5419 9.44472 53.8708C10.9025 61.1996 14.5008 67.9316 19.7846 73.2154C25.0684 78.4992 31.8004 82.0975 39.1293 83.5553C46.4581 85.0131 54.0547 84.2649 60.9583 81.4053C67.8619 78.5457 73.7625 73.7032 77.914 67.4901C82.0654 61.277 84.2813 53.9724 84.2813 46.5C84.2707 36.483 80.2868 26.8794 73.2037 19.7963C66.1206 12.7132 56.517 8.72933 46.5 8.71875ZM63.0874 39.8374L42.7437 60.1812C42.4738 60.4514 42.1533 60.6657 41.8004 60.812C41.4476 60.9583 41.0694 61.0335 40.6875 61.0335C40.3056 61.0335 39.9274 60.9583 39.5746 60.812C39.2218 60.6657 38.9013 60.4514 38.6313 60.1812L29.9126 51.4624C29.3673 50.9171 29.0609 50.1775 29.0609 49.4062C29.0609 48.635 29.3673 47.8954 29.9126 47.3501C30.4579 46.8047 31.1976 46.4984 31.9688 46.4984C32.74 46.4984 33.4796 46.8047 34.0249 47.3501L40.6875 54.0163L58.9751 35.7251C59.2451 35.4551 59.5657 35.2409 59.9185 35.0947C60.2713 34.9486 60.6494 34.8734 61.0313 34.8734C61.4131 34.8734 61.7913 34.9486 62.1441 35.0947C62.4969 35.2409 62.8174 35.4551 63.0874 35.7251C63.3575 35.9951 63.5716 36.3157 63.7178 36.6685C63.8639 37.0213 63.9391 37.3994 63.9391 37.7812C63.9391 38.1631 63.8639 38.5412 63.7178 38.894C63.5716 39.2468 63.3575 39.5674 63.0874 39.8374Z" fill="#50DDA4" />
									</svg>
									<h1 class="titre-h2 text-blue mb-4 max-xl:text-center">Vous avez choisi de participer à l'appel d'offre pour</h1>
									<p class="mb-8 max-xl:text-center">
										<strong class="font-bold"><?= get_field('titre_annonce', $ph_id) ? get_field('titre_annonce', $ph_id) : '-' ?></strong><br>
										<?php
										$terms = get_the_terms($ph_id, 'region');
										if (!empty($terms) && !is_wp_error($terms)) {
											$term_name = preg_replace('/\s*\(/', ' (', $terms[0]->name);
											echo '<span class="mt-1 text-blue">' . esc_html($term_name) . '</span>';
										} else {
											echo '<span class="mt-1 text-blue">-</span>';
										}
										?>
									</p>
									<p class=" max-xl:text-center">
										Renseignez vos coordonnées pour finaliser votre participation.
									</p>
								</div>
							</div>

							<div class="col w-full xl:w-7/14">
								<div class="editor-content mx-auto pb-12 lg:pb-14">
									<?php if ($shortcode = get_field('frm_shortcode')) : ?>
										<?= do_shortcode($shortcode); ?>
									<?php endif ?>
								</div>
							</div>
						</div>
					<?php else : ?>
						<div class="xl:flex xl:flex-wrap xl:justify-center xl:w-14/16 xl:mx-auto">
							<div class="col w-full xl:w-6/14 pb-12">
								<div class="xl:w-4/6 xl:relative xl:after:absolute xl:after:-right-[20%] xl:after:block xl:after:h-full xl:after:top-0 xl:after:w-[1px] xl:after:bg-grey">
									<svg class=" mb-6 block max-xl:mx-auto" width="93" height="93" viewBox="0 0 93 93" fill="none" xmlns="http://www.w3.org/2000/svg">
										<path d="M46.5 8.71875C39.0276 8.71875 31.723 10.9346 25.5099 15.086C19.2968 19.2375 14.4543 25.1381 11.5947 32.0417C8.73512 38.9454 7.98693 46.5419 9.44472 53.8708C10.9025 61.1996 14.5008 67.9316 19.7846 73.2154C25.0684 78.4992 31.8004 82.0975 39.1293 83.5553C46.4581 85.0131 54.0547 84.2649 60.9583 81.4053C67.8619 78.5457 73.7625 73.7032 77.914 67.4901C82.0654 61.277 84.2813 53.9724 84.2813 46.5C84.2707 36.483 80.2868 26.8794 73.2037 19.7963C66.1206 12.7132 56.517 8.72933 46.5 8.71875ZM63.0874 39.8374L42.7437 60.1812C42.4738 60.4514 42.1533 60.6657 41.8004 60.812C41.4476 60.9583 41.0694 61.0335 40.6875 61.0335C40.3056 61.0335 39.9274 60.9583 39.5746 60.812C39.2218 60.6657 38.9013 60.4514 38.6313 60.1812L29.9126 51.4624C29.3673 50.9171 29.0609 50.1775 29.0609 49.4062C29.0609 48.635 29.3673 47.8954 29.9126 47.3501C30.4579 46.8047 31.1976 46.4984 31.9688 46.4984C32.74 46.4984 33.4796 46.8047 34.0249 47.3501L40.6875 54.0163L58.9751 35.7251C59.2451 35.4551 59.5657 35.2409 59.9185 35.0947C60.2713 34.9486 60.6494 34.8734 61.0313 34.8734C61.4131 34.8734 61.7913 34.9486 62.1441 35.0947C62.4969 35.2409 62.8174 35.4551 63.0874 35.7251C63.3575 35.9951 63.5716 36.3157 63.7178 36.6685C63.8639 37.0213 63.9391 37.3994 63.9391 37.7812C63.9391 38.1631 63.8639 38.5412 63.7178 38.894C63.5716 39.2468 63.3575 39.5674 63.0874 39.8374Z" fill="#50DDA4" />
									</svg>
									<h1 class="titre-h2 text-blue mb-4 max-xl:text-center">Vous avez sélectionné un pharmacien</h1>
									<p class="chapo max-xl:text-center">Renseignez vos coordonnées pour finaliser la mise en relation.</p>
								</div>
							</div>

							<div class="col w-full xl:w-7/14">
								<div class="editor-content mx-auto pb-12 lg:pb-14">
									<?php if ($shortcode = get_field('frm_shortcode')) : ?>
										<?= do_shortcode($shortcode); ?>
									<?php endif ?>
								</div>
							</div>
						</div>
					<?php endif ?>
				<?php else : ?>
					<div class="editor-content lg:w-6/8 mx-auto py-12 lg:py-14">
						<h1 class="titre-h1 text-blue mb-4.5 lg:mb-7 w-full"><?php the_title() ?></h1>
						<?php if ($shortcode = get_field('frm_shortcode')) : ?>
							<?= do_shortcode($shortcode); ?>
						<?php endif ?>
					</div>
				<?php endif ?>

			</div>
</div>
</article>

</main>

</div>

<?php get_footer(); ?>