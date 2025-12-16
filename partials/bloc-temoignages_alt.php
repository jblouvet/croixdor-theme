<?php
$titre = $args['titre'];
$temoignages = $args['temoignages'];
?>

<section class="bloc-temoignages_alt bg-white">

	<div class="wrapper">

		<div class="w-full xl:w-14/16 xl:mx-auto">

			<div class="editor-content pt-12 xl:pt-14 text-white">

				<?php if ($titre): ?>
					<h2 class="titre-h1 !mb-4.5 !xl:mb-7 !text-blue"><?= $titre ?></h2>
				<?php endif; ?>

			</div>

		</div>
	</div>

	<div class="w-full max-xl:pt-16 pb-22.5 xl:pb-33.5 overflow-visible">

		<div class="no-scrollbar flex gap-5 overflow-x-auto xl:pt-13">

			<?php foreach ($temoignages as $temoignage): ?>

				<div class="bg-grey w-[392px] max-w-[80%] shrink-0 rounded-[20px] first:ml-[7.69%] last:mr-[7.69%]">

					<div class="flex flex-col flex-wrap rounded-[20px] h-full py-10 pl-7.5 pr-12">

						<h3 class="titre-h3 text-blue mb-[2em]"><?= $temoignage['titre'] ?></h3>
						<div class="chapo">
							<p><?= $temoignage['citation'] ?></p>
							<p class="font-bold mt-[1em]"><?= $temoignage['attribution'] ?></p>
						</div>
						<img class="w-[100px] h-[27px] mt-[1em]" src="<?= get_template_directory_uri() ?>/assets/img/etoiles.png"
							alt="">
					</div>

				</div>

			<?php endforeach; ?>

		</div>


	</div>
</section>