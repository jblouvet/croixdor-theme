<?php
$col_text = $args['col_txt'];
$col_text_2 = $args['col_txt_2'];
?>

<section class="bloc-text_text py-18 xl:py-30 bg-grey">

	<div class="wrapper">

		<div class="w-full mx-auto xl:w-14/16 flex flex-wrap items-center">

			<?php if ($col_text) : ?>

				<div class="w-full xl:w-1/2">

					<div class="w-full xl:w-6/7">

						<?php if ($content = $col_text['contenu_1']) : ?>
							<div class="editor-content type-<?= $col_text['list_style'] ?>">
								<div class="xl:w-5/6 max-xl:mb-11">
									<?= $content ?>
								</div>
							</div>
						<?php endif ?>

						<?php if ($cta = $col_text['cta']) : ?>
							<?php get_template_part('partials/bloc', 'cta', $cta) ?>
						<?php endif ?>
					</div>
				</div>

			<?php endif ?>

			<?php if ($col_text_2) : ?>

				<div class="w-full xl:w-1/2">

					<div class="w-full xl:w-6/7 xl:ml-auto">

						<?php if ($content = $col_text_2['contenu_1']) : ?>
							<div class="editor-content type-<?= $col_text_2['list_style'] ?>">
								<div class="xl:w-5/6 max-xl:mb-11">
									<?= $content ?>
								</div>
							</div>
						<?php endif ?>

						<?php if ($cta = $col_text_2['cta']) : ?>
							<?php get_template_part('partials/bloc', 'cta', $cta) ?>
						<?php endif ?>
					</div>
				</div>

			<?php endif ?>
		</div>
	</div>

</section>