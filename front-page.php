<?php get_header(); ?>

<div class="site-content flex-1">

	<main class="page-content">

		<?php
		if ($content = get_field('content')) :
			get_template_part('partials/blocs', '', $content);
		endif;
		?>

	</main>

</div>

<?php get_footer(); ?>