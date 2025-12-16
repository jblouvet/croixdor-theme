<?php
$titre = $args['titre'];
$chapo = $args['chapo'];
$img = $args['image'];
$cta = $args['cta'];
?>

<section class="bloc-relance py-15 lg:py-25">

	<div class="wrapper">

		<div class="container w-full xl:w-14/16 flex flex-wrap mx-auto bg-grey rounded-[50px] items-stretch">

			<div class="w-full lg:w-8/14 xl:w-8/14 flex items-center justify-center">

				<div class="editor-content lg:w-7/8 mx-auto py-12 lg:py-14 px-10 xl:px-20">

					<?php if ($titre): ?>
						<h2 class="titre-h1 text-blue !mb-4.5 !lg:mb-7"><?= $titre ?></h2>
					<?php endif; ?>

					<?php if ($chapo): ?>
						<div class="chapo mb-5 lg:mb-20 max-w-[20.5em]">
							<?= $chapo ?>
						</div>
					<?php endif; ?>

					<?php get_template_part('partials/bloc', 'cta', $cta) ?>

				</div>

			</div>

			<div class="w-full lg:w-6/14 xl:w-6/14">

				<?php if ($img): ?>
					<img src="<?= $img['url'] ?>" alt="" class="rounded-[50px] w-full h-full object-cover">
				<?php endif ?>

			</div>
		</div>
	</div>
</section>