<?php
$titre = $args['titre'];
$experts = $args['experts'];
?>

<section class="bloc-experts bg-blue pt-15 pb-20 xl:py-30 overflow-hidden">
	<div class="wrapper">
		<div class="experts xl:w-14/16 xl:mx-auto">
			<?php if ($titre): ?>
				<h2 class="titre-h1 text-white mb-15 xl:mb-30 text-center"><?= $titre ?></h2>
			<?php endif; ?>

			<?php if ($experts): ?>
				<div class="experts-carousel relative w-full xl:min-h-[470px]">

					<!-- Navigation Buttons -->
					<!-- Navigation Buttons -->
					<button
						class="expert-prev absolute  z-40 w-12 h-12 xl:w-14 xl:h-14 rounded-full border border-white flex items-center justify-center text-white hover:bg-white hover:text-blue transition-colors duration-300 xl:top-1/2 xl:-left-20 xl:-translate-y-1/2 max-xl:bottom-0 max-xl:left-[calc(50%-44px-16px)]">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round" />
						</svg>
					</button>
					<button
						class="expert-next absolute z-40 w-12 h-12 xl:w-14 xl:h-14 rounded-full border border-white flex items-center justify-center text-white hover:bg-white hover:text-blue transition-colors duration-300 xl:top-1/2 xl:-right-20 xl:-translate-y-1/2 max-xl:bottom-0 max-xl:right-[calc(50%-44px-16px)]">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round"
								stroke-linejoin="round" />
						</svg>
					</button>

					<div class="experts-list relative w-full h-full xl:w-11/14 1440:w-9/14 xl:mx-auto max-xl:mb-10">
						<?php foreach ($experts as $i => $expert): ?>
							<div
								class="expert-card w-full bg-white flex flex-col xl:flex-row rounded-[30px] max-h-[70vh] xl:max-h-[500px] xl:h-[500px] xl:overflow-hidden max-xl:overflow-y-auto max-xl:no-scrollbar transition-all duration-500 ease-out origin-bottom-right shadow-lg absolute top-0 left-0 max-xl:max-w-[780px] max-xl:left-[50%] max-xl:ml-[-390px] max-md:max-w-full max-md:left-0 max-md:ml-0 <?= $i === 0 ? 'is-active' : ($i === 1 ? 'is-next' : ($i === 2 ? 'is-next-2' : 'is-hidden-stack')) ?>"
								data-index="<?= $i ?>">

								<div class="xl:w-5/11 1440:w-4/9 shrink-0 xl:overflow-y-auto xl:h-full no-scrollbar">
									<?php if ($expert['portrait']): ?>

										<img class="w-full rounded-[30px] max-xl:max-h-[40vh] object-cover object-top"
											src="<?= $expert['portrait']['url'] ?>" alt="<?= $expert['portrait']['alt'] ?>">

									<?php endif; ?>
									<div class="expert-info p-8">
										<h3 class="titre-h3 text-blue expert-name"><?= $expert['nom'] ?></h3>
										<div
											class="expert-position mt-4 [&>p>strong]:font-bold [&>ul>li]:mb-[.5em] [&>ul>li]:ml-[1em] [&>ul>li]:list-disc leading-[1.4]">
											<?= $expert['bio'] ?>
										</div>
									</div>
								</div>

								<div class="xl:w-6/11 1440:w-5/9 relative xl:h-full flex flex-col xl:overflow-hidden">
									<div
										class="expert-scroll-content flex-1 xl:overflow-y-auto no-scrollbar xl:px-20 xl:py-16 max-xl:p-8 max-xl:pt-0">
										<?php if ($expert['presentation']): ?>
											<div class="[&>p>strong]:font-bold [&>ul>li]:ml-[1em] [&>ul>li]:list-disc leading-[1.4] mb-10">
												<?= $expert['presentation'] ?>
											</div>
										<?php endif; ?>

										<?php if ($expert['atouts']): ?>
											<div class="atouts">
												<div class="mb-6">
													<p
														class="bg-blue-dark text-green w-fit titre-h3 py-[4px] pl-12 pr-5 rounded-[8px] relative before:block  before:w-[25px] before:h-[31px] before:absolute before:-left-[12px] before:-top-[12px] before:content-[url('/wp-content/themes/croixdor/assets/img/icon-atouts.svg')]">
														Ses atouts</p>
												</div>
												<div
													class="[&>p>strong]:font-bold [&>ul>li]:ml-[1em] [&>ul>li]:list-disc leading-[1.4] [&>ul]:mb-[1em]">
													<?= $expert['atouts'] ?>
												</div>
											</div>
										<?php endif ?>
									</div>
									<div
										class="expert-scroll-overlay max-xl:hidden absolute bottom-0 left-0 w-full h-16 xl:h-24 bg-gradient-to-t from-white to-transparent pointer-events-none transition-opacity duration-300 opacity-0">
									</div>
								</div>

								<!-- Mobile Overlay (Sticky) -->
								<div
									class="expert-mobile-overlay xl:hidden sticky bottom-0 left-0 w-full h-20 bg-gradient-to-t from-white to-transparent pointer-events-none transition-opacity duration-300 opacity-0 z-10 shrink-0 -mt-20">
								</div>

							</div>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>