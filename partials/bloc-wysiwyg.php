<?php
$wysiwyg = $args['wysiwyg'];
?>

<section class="bloc-wysiwyg">
	<?php if (!is_singular('post')) : ?>
		<div class="wrapper">

			<div class="w-full xl:w-14/16 mx-auto">

				<div class="editor-content lg:w-6/8 mx-auto py-12 lg:py-14 px-10 xl:px-20 max-lg:pb-0">
				<?php endif ?>

				<?php if (!is_singular('post')) : ?>
					<h1 class="titre-h1 text-blue mb-4.5 lg:mb-7 w-full"><?php the_title() ?></h1>
				<?php endif; ?>

				<?= $wysiwyg ?>

				<?php if (!is_singular('post')) : ?>
				</div>

			</div>
		</div>
	<?php endif ?>
</section>