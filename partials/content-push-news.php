<?php

$cat = get_queried_object();
if (empty($cat) || $cat->taxonomy !== 'product_cat' || !in_array($cat->term_id, [18, 19])) {
	return;
}

$news_cat_id = ($cat->term_id === 18) ? 39 : 40;
$news_cat = get_category($news_cat_id);
$cat_link = get_category_link($news_cat_id);

$query = new WP_Query([
	'posts_per_page' => 3,
	'cat' => $news_cat_id,
	'post_type' => 'post',
	'post_status' => 'publish',
]);

if ($query->have_posts()) :

?>
	<section class="pt-[58px] lg:pt-[72px] pb-[64px] lg:pb-[92px]">

		<div class="wrapper flex items-center justify-between">
			<h2 class="titre-h2 text-accent w-full mb-5">Tout savoir sur les <span class="lowercase"><?php echo esc_html($news_cat->name); ?></span></h2>
			<a href="<?= $cat_link ?>" class="inline-flex items-center uppercase hover:text-accent before:content-[''] before:w-[24px] before:mr-[16px] before:h-[1px] before:inline-flex before:bg-primary hover:before:bg-accent max-lg:hidden">Voir&nbsp;plus</a>
		</div>
		<div class="flex flex-nowrap lg:w-9/10 lg:mx-auto lg:flex-wrap gap-[2rem] overflow-x-auto [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
			<?php while ($query->have_posts()) : $query->the_post(); ?>
				<a class="group w-full max-lg:min-w-[260px]! lg:w-[calc((100%/3)-(2rem/1.5))] max-lg:first:ml-[5vw] max-lg:last:mr-[5vw]" href="<?php the_permalink(); ?>">
					<figure class="relative aspect-[4/5] overflow-hidden">
						<?php if (has_post_thumbnail()) {
							the_post_thumbnail('medium', array('class' => 'w-full! h-full! object-cover'));
						} ?>
						<div class="bg-white text-primary absolute top-2 right-2 w-fit uppercase tracking-[.1em] text-[12px] px-2 py-1 leading-none">
							<?php echo esc_html($news_cat->name); ?>
						</div>
						<button class="absolute left-1/2 -translate-x-1/2 w-[calc(100%-24px)] bottom-2.5 opacity-0 group-hover:opacity-100 rounded-none py-[18px] text-[12px] tracking-[.1em] bg-accent text-white uppercase">
							lire l'article
						</button>
					</figure>
					<h3 class="titre-h3 mt-2.5"><?php the_title(); ?></h3>
					<div class="mt-2"><?php the_excerpt(); ?></div>
				</a>
			<?php endwhile;
			wp_reset_postdata(); ?>
		</div>
		<div class="wrapper lg:hidden">
			<div class="w-full text-center lg:hidden mt-[68px]">
				<a href="<?= $cat_link ?>" class="inline-flex p-4 items-center mx-auto uppercase hover:text-accent before:content-[''] before:w-[24px] before:mr-[16px] before:h-[1px] before:inline-flex before:bg-primary hover:before:bg-accent">Voir plus</a>
			</div>

		</div>
	</section>
<?php endif; ?>