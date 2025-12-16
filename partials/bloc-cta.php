<div class="bloc-cta">

	<?php
	$hasArgsCta = isset($args['cta']);
	$wrapperStyle = isset($args['wrapperStyle']) ? $args['wrapperStyle'] : '';

	$args = isset($args['cta']) ? $args['cta']['btns'] : $args['btns'];

	$openWrap = ($hasArgsCta && !is_singular('post')) ? '<div class="wrapper"><div class="w-full xl:w-14/16 mx-auto"><div class="lg:w-6/8 mx-auto pb-12 lg:pb-14 px-10 xl:px-20 max-lg:pb-0">' : '';
	$closeWrap = ($hasArgsCta && !is_singular('post')) ? '</div></div></div>' : '';
	?>

	<?= $openWrap ?>

	<div class="buttons flex gap-5 flex-wrap <?= $wrapperStyle ?>">

		<?php foreach ($args as $btn): ?>

			<?php $show_icon = isset($btn['hide_icon']) ? false : true; ?>

			<?php if (isset($btn['action']) && $action = $btn['action']): ?>

				<?php if ($action == 'none')
					continue; ?>

				<?php
				$btnStyle = 'bg-blue text-white';

				if (isset($btn['style'])):
					if ($btn['style'] === 'default'):
						$btnStyle = 'bg-blue text-white';
					endif;
					if ($btn['style'] === 'alt'):
						$btnStyle = 'text-blue border-blue border-[1px] bg-white';
					endif;
					if ($btn['style'] === 'vert'):
						$btnStyle = 'text-blue-dark bg-green';
					endif;
					if ($btn['style'] === 'noir'):
						$btnStyle = 'text-white bg-transparent border border-white';
					endif;
				endif;
				?>

				<?php if ($action == 'link' && $btn['lien']): ?>
					<?php
					$show_icon = false;
					$link = $btn['lien'];
					if (is_array($link)) {
						$link_url = $link['url'];
						$link_title = $link['title'] != '' ? $link['title'] : 'Découvrir';
						$link_target = $link['target'] ? $link['target'] : '_self';
					} else {
						$link_url = $link;
						$link_title = isset($btn['label_lien']) ? $btn['label_lien'] : 'Découvrir';
						$link_target = '_self';
					}
					?>
					<a class="<?= $btnStyle ?> group w-fit block font-display font-bold text-[16px] pt-[16px] pb-[16px] px-[28px] rounded-[60px] cursor-pointer"
						href="<?php echo esc_url($link_url); ?>" target="<?php echo esc_attr($link_target); ?>">
						<div class="flex items-center justify-center group-hover:-translate-y-[4px] translate-y-0 transition-all">
							<?php if ($show_icon): ?>
								<?php get_template_part('partials/icon', 'heart.svg') ?>
							<?php endif ?>
							<span <?php if ($show_icon): ?>class="ml-2.5" <?php endif ?>><?php echo esc_html($link_title); ?></span>
						</div>
					</a>
				<?php endif; ?>

			<?php endif; ?>
		<?php endforeach ?>
	</div>

	<?= $closeWrap ?>

</div>