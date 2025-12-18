<?php

$max_num_pages = get_query_var('max_num_pages');
$current_page = get_query_var('current_page');
if (!isset($max_num_pages) || $max_num_pages < 2)
	return;

$current = isset($current_page) ? intval($current_page) : 1;
?>
<div class="pagination w-full flex justify-center items-center mt-12 xl:mt-25 mb-5 xl:mb-10">
	<a href="<?php echo $current > 1 ? esc_url(get_pagenum_link($current - 1)) : '#'; ?>" data-page="<?= $current - 1 ?>"
		class="p-2 sm:p-3 xl:p-5 <?= $current <= 1 ? 'pointer-events-none opacity-40' : '' ?>" aria-label="Page précédente">
		<?php get_template_part('partials/icon', 'arrow-left.svg') ?>
	</a>
	<?php for ($i = 1; $i <= $max_num_pages; $i++): ?>
		<a href="<?php echo esc_url(get_pagenum_link($i)); ?>" data-page="<?= $i ?>"
			class="p-2 sm:p-3 xl:p-5 hover:opacity-100 <?= $i == $current ? 'opacity-100 font-bold' : 'opacity-40' ?>">
			<?= $i ?>
		</a>
	<?php endfor; ?>
	<a href="<?php echo $current < $max_num_pages ? esc_url(get_pagenum_link($current + 1)) : '#'; ?>"
		data-page="<?= $current + 1 ?>"
		class="p-2 sm:p-3 xl:p-5 <?= $current >= $max_num_pages ? 'pointer-events-none opacity-40' : '' ?>"
		aria-label="Page suivante">
		<?php get_template_part('partials/icon', 'arrow-right.svg') ?>
	</a>
</div>