<button class="js-match <?= $args[0] ?> group font-display font-bold text-[16px] pt-[16px] pb-[16px] px-[28px] rounded-[60px] cursor-pointer">
	<div class="flex items-center justify-center group-hover:-translate-y-[4px] translate-y-0 transition-all">
		<?php get_template_part('partials/icon', 'heart.svg') ?>
		<span class="ml-2.5"><?= $args[1] ? $args[1] : 'Découvrez si ça match&nbsp;!' ?></span>
	</div>
</button>