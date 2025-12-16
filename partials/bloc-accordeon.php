<?php if ($items = $args['items']): ?>

	<?php
	$title = $args['titre'];
	$chapo = $args['chapo'];
	$more = $args['more'];
	$cta = $args['cta'];
	?>

	<section class="bloc-accordeon pt-10 pb-20 xl:pb-30 xl:pt-15">

		<div class="wrapper">

			<div class="container w-full max-w-full mx-auto xl:w-14/16">

				<div class="flex flex-wrap bloc-accordeon-header mb-15">

					<div class="xl:w-9/14">
						<?php if ($title): ?>
							<h2 class="titre-h1 text-blue mb-10"><?= $title ?></h2>
						<?php endif ?>

						<?php if ($chapo): ?>
							<div class="chapo type-ok type-inline"><?= $chapo ?></div>
						<?php endif ?>
					</div>
					<div class="xl:w-5/14">
						<?php if ($cta): ?>
							<?php get_template_part('partials/bloc', 'cta', $cta) ?>
						<?php endif ?>
					</div>
				</div>

				<div class="accordion mt-10">

					<?php $i = 1;
					foreach ($items as $item): ?>

						<?php
						$surtitre = $item['surtitre'];
						$titre = $item['titre'];
						$contenu = $item['contenu'];
						$cta = $item['cta'];
						$image = $item['image'];
						?>

						<div
							class="accordion-item w-full <?= $i == 1 ? 'is-active' : 'is-collapsed' ?> group bg-grey rounded-[25px] mb-5 [&.is-active]:scroll-m-[120px]">

							<div class="accordion-header px-[calc(100%/14)] pt-5 group cursor-pointer">
								<div class="flex justify-between items-center">
									<div class="title">
										<?php if ($surtitre): ?>
											<span class="surtitre text-blue"><?= $surtitre ?></span>
										<?php endif ?>

										<?php if ($titre): ?>
											<h3 class="titre-h2"><?= $item['titre'] ?></h3>
										<?php endif ?>
									</div>
									<div class="icon">
										<?php get_template_part('partials/icon', 'accordeon.svg') ?>
									</div>
								</div>
							</div>

							<div
								class="accordion-body max-h-0 overflow-hidden transition-all group-[.is-active]:max-h-[1000px] px-[calc(100%/14)] duration-300 pt-5 group-[.is-active]:mb-10">

								<div class="flex flex-wrap">

									<div class="w-full xl:w-9/14 pt-2.5 pb-10">
										<div class="max-xl:mx-auto max-xl:mb-11">
											<div class="chapo">
												<?= $contenu ?>
											</div>
										</div>
										<?php if ($cta): ?>
											<?php get_template_part('partials/bloc', 'cta', $cta) ?>
										<?php endif ?>
									</div>

									<figure class="xl:w-5/14">
										<img src="<?= $image['url'] ?>" alt=""
											class="w-full xl:max-w-6/7 xl:ml-auto ratio-[7/5] rounded-[35px] object-cover mb-10">
									</figure>

								</div>
							</div>

						</div>

						<?php $i++; endforeach; ?>

				</div>

			</div>

	</section>

<?php endif ?>