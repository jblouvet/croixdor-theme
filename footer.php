<footer class="site-footer bg-blue text-white py-[74px]">

	<div class="wrapper lg:flex">

		<div class="footer-logo pb-[60px] lg:w-4/16">
			<a href="/">
				<img class="w-[240px]" src="<?= get_template_directory_uri() ?>/assets/img/croixdor-logo.png" alt="Croix Dor">
			</a>
		</div>

		<div class="footer-menu-wrapper lg:flex-1">
			<nav id="menu" data-mode="final" class="footer-menu flex flex-wrap max-lg:gap-y-[50px]">

				<div class="w-1/2 md:w-1/4">
					<span class="font-display font-bold text-[16px]">Liens rapides</span>
					<?php wp_nav_menu([
						"theme_location" => "header",
						"menu_id" => "",
						"menu_class" => "[&>li:last-child]:!mt-[1em] [&>li.menu-item-133]:!hidden",
						"container" => "",
					]); ?>
				</div>

				<div class="w-1/2 md:w-1/4">

					<span class="font-display font-bold text-[16px]">Contact</span>
					<?php get_template_part('partials/footer', 'contact') ?>
				</div>

				<div class="w-1/2 md:w-1/4">
					<span class="font-display font-bold text-[16px]">Réseaux</span>
					<?php get_template_part('partials/footer', 'social') ?>
				</div>

				<div class="w-1/2 md:w-1/4">
					<span class="font-display font-bold text-[16px]">Légal</span>
					<?php wp_nav_menu([
						"theme_location" => "footer",
						"menu_id" => "",
						"menu_class" => "",
						"container" => "",
					]); ?>
				</div>

			</nav>
		</div>

	</div>
</footer>


<?php get_template_part('partials/footer', 'inscription-form'); ?>

<?php wp_footer(); ?>