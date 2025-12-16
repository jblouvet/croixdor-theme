<?php get_header() ?>

<div class="site-content flex-1">

	<main class="page-content">

		<?php $space = get_field('bandeau', 'options') ? 'pt-32' : 'pt-16'; ?>

		<header class="container <?= $space ?> pb-8 mx-auto max-w-4xl">

			<h1 class="titre-h1 text-blue">Page non trouvée</h1>

		</header>

		<article>

			<div class="container mx-auto max-w-4xl pb-12">

				<div class="editor-content">

					<p>Nous n'avons pas trouvé la page que vous cherchez.<br> Elle a peut-être été déplacée, supprimée ou temporairement désactivée.</p>

				</div>

				<a class="group block font-display font-bold text-[16px] bg-blue text-white max-xl:mx-auto pt-[16px] pb-[16px] px-[28px] rounded-[60px] cursor-pointer max-xl:mb-[48px] w-fit" href="/" target="<?php echo esc_attr($link_target); ?>">

					Revenir à l'accueil
				</a>

			</div>

		</article>

</div>

<?php get_footer() ?>