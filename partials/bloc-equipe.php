<?php
$titre = $args['titre'];
$chapo = $args['chapo'];
$membres = $args['membres'];
?>

<section class="bloc-equipe bg-blue">

	<div class="wrapper">

		<div class="container w-full xl:w-14/16 xl:pt-13.5 flex justify-between mx-auto max-xl:flex-wrap">

			<div class="w-full xl:w-4/14">

				<div class="editor-content pt-12 xl:pt-14 text-white">

					<?php if ($titre) : ?>
						<h2 class="titre-h1 !mb-4.5 !xl:mb-7 !text-white"><?= $titre ?></h2>
					<?php endif; ?>

					<?php if ($chapo) : ?>
						<div class="chapo mb-5 xl:mb-15 max-w-[20.5em]">
							<?= $chapo ?>
						</div>
					<?php endif; ?>

				</div>

			</div>

			<div class="w-full xl:w-9/14 max-xl:pt-16 pb-22.5 xl:pb-33.5 overflow-visible">

				<div class="no-scrollbar flex gap-5 overflow-x-auto xl:w-[calc(100vw-((100vw-90.28vw)/2)-((90.28vw-0.875*90.28vw)/2)-(4/14*0.875*90.28vw))] xl:pr-[calc((100vw-90.28vw))] max-xl:-ml-[7.69%] max-xl:w-[calc(100%+(7.69%*2))] xl:pt-13">

					<?php foreach ($membres as $membre) : ?>

						<div class="bg-white w-[228px] shrink-0 rounded-[20px] max-xl:first:ml-[7.69%] max-xl:last:mr-[7.69%]">
							<div class="flex flex-col flex-wrap rounded-[20px] h-full">
								<img src="<?= $membre['portrait']['url'] ?>" alt="" class="h-[172px] object-cover w-full rounded-[20px]">
								<h3 class="titre-h3 text-blue px-5 pt-5"><?= $membre['prenom'] ?></h3>
								<p class="pb-5 px-5"><?= $membre['fonction'] ?></p>
								<ul class="flex gap-2 px-5 pb-5 mt-auto">
									<?php if ($mel = $membre['email']) : ?>
										<li><a href="mailto:<?= $mel ?>"><?php get_template_part('partials/icon', 'mel.svg') ?></a></li>
									<?php endif ?>
									<?php if ($tel = $membre['telephone']) : ?>
										<li><a href="tel:<?= $tel ?>"><?php get_template_part('partials/icon', 'tel.svg') ?></a></li>
									<?php endif ?>
								</ul>

							</div>

						</div>

					<?php endforeach; ?>

				</div>
			</div>
		</div>
	</div>
</section>