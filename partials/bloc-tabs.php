<?php
$titre = $args['titre'];
$image = $args['image'];
$panels = $args['panels'];
$tabStyle = $args['tabs-style'];
?>
<section class="bloc-tabs relative overflow-hidden py-12 xl:mb-26">

	<img src="<?= $image['url'] ?>" alt="" class="hidden xl:block absolute left-0 top-0 w-full h-full object-cover z-0">

	<div class="wrapper relative z-10">

		<div class="flex flex-wrap xl:w-14/16 xl:mx-auto">

			<?php if ($titre): ?>
				<div class="col-1 w-full xl:w-7/16">
					<h2 class="titre-h1 text-blue xl:text-white mb-12 "><?= $titre ?></h2>
				</div>
			<?php endif ?>

			<div class="col-2 w-full xl:ml-auto xl:w-1/2 bg-white xl:rounded-[50px] xl:py-[3.25%] ">

				<div
					class="tabs-default tabs-container xl:w-6/8 xl:mx-auto  [--tabs-fixedheight:470px] xl:[--tabs-fixedheight:640px]">

					<div class="p-4">
						<div
							class="tabs-buttons flex gap-2 mb-4 xl:mb-8 w-fit bg-white flex-wrap rounded-[70px] p-1 font-medium shadow-[var(--tabs-shadow)]">

							<?php foreach ($panels as $i => $panel): ?>

								<button
									class="tab-button text-blue block transition-all [&.is-active]:bg-blue [&.is-active]:text-white hover:bg-blue hover:text-white cursor-pointer <?= $tabStyle == "number" ? 'flex items-center justify-center aspect-[1/3] px-12 py-6 w-[30px] h-[30px] rounded-full leading-none' : 'py-[15px] px-[20px] rounded-[70px]'; ?>">

									<?php if ($tabStyle == "number"): ?>
										<?= $i + 1 ?>
									<?php else: ?>
										<?= $panel['label'] ?>
									<?php endif; ?>

								</button>

							<?php endforeach; ?>

						</div>
					</div>

					<?php foreach ($panels as $panel): ?>

						<div class="tab-panel p-4">

							<div class="tab-panel-content pb-16">

								<?php if ($title = $panel['titre']): ?>
									<h3 class="titre-h2 mb-[1.5em] text-blue"><?= $title ?></h3>
								<?php endif ?>

								<?php if ($chapo = $panel['chapo']): ?>
									<p class="chapo mb-[1.5em]"><?= $chapo ?></p>
								<?php endif ?>

								<?php if ($contenu = $panel['contenu']): ?>
									<div class="editor-content type-<?= $panel['list_style'] ?>">
										<?= $contenu ?>
									</div>
								<?php endif ?>

								<?php if ($ctas = $panel['cta']): ?>
									<?php get_template_part('partials/bloc', 'cta', $ctas) ?>
								<?php endif ?>
							</div>

						</div>

					<?php endforeach ?>

				</div>
			</div>
		</div>

	</div>

	<img src="<?= $image['url'] ?>" alt="" class="block xl:hidden w-full mt-12">
</section>