<?php
$title = $args['titre'];
$chapo = $args['chapo'];
$col_1 = $args['col_1'];
$col_2 = $args['col_2'];
$illustration = $args['col_2']['illustration'];
if ($illustration) :
	$w = $illustration['width'];
	$h = $illustration['height'];
	$ratioStr = $w . '/' . $h;
	$ratio = $w / $h;
	$isLandscape =  $ratio > 1;
	$isPortrait = $ratio < 1;
	$landscapeSpacing = $h / 6;
	$illustrationColVerticalSpacing = $isLandscape ? $landscapeSpacing : '';
endif;
?>

<section class="bloc-featured xl:pb-20">

	<div class="wrapper">

		<div class="w-full mx-auto xl:w-14/16 flex flex-wrap">

			<div style="--marginTop: <?= $illustrationColVerticalSpacing ?>px" class="w-full xl:w-1/2 <?= $illustrationColVerticalSpacing ? 'xl:mt-[var(--marginTop)]' : '' ?>">
				<?php if ($title) : ?>
					<h2 class="titre-h1 text-blue mb-10 xl:mb-16 max-w-[13em]"><?= $title ?></h2>
				<?php endif ?>

				<div class="xl:w-5/7 xl:max-w-[554px]">
					<?php if ($chapo) : ?>
						<p class="chapo mb-[1.5em]"><?= $chapo ?></p>
					<?php endif ?>

					<?php if ($col_1) : ?>

						<?php if ($content_1 = $col_1['contenu_1']) : ?>
							<div class="editor-content type-<?= $col_1['list_style'] ?>">
								<div class="xl:w-5/6 max-xl:mb-11">
									<?= $content_1 ?>
								</div>
							</div>
						<?php endif ?>

						<?php get_template_part('partials/bloc', 'cta', $col_1['cta']) ?>
					<?php endif ?>
				</div>
			</div>

			<div class="w-full max-xl:mt-12 xl:w-1/2 flex flex-wrap justify-center xl:relative">
				<?php if ($col_2) : ?>

					<?php if ($content_2 = $col_2['contenu_2']) : ?>

						<?php if ($illustration) : ?>

							<figure class="relative z-20 flex <?= $isLandscape ? 'w-full' : 'w-1/2 2xl:w-1/3 ml-auto'; ?>">
								<img src="<?= $illustration['url'] ?>" alt="" class="w-full object-contain">
							</figure>
						<?php endif ?>

						<div class="w-full xl:w-6/7 bg-grey flex justify-center self-end rounded-[50px] mb-[20] <?= $isLandscape ? '-translate-y-[10vw] 1580:-translate-y-[5vw]' : '-translate-y-[20vw] xl:-translate-y-[10vw]'; ?> relative z-10">

							<div class="editor-content type-<?= $col_2['list_style'] ?> pt-5 ">
								<div class="w-4/5 mx-auto py-[10%] 2xl:max-w-[60%]">
									<?= $content_2 ?>
								</div>
							</div>
						</div>
					<?php endif ?>

				<?php endif ?>
			</div>
		</div>

</section>