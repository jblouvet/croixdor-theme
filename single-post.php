<?php get_header() ?>

<div class="site-content flex-1">

	<main class="page-content">

		<article>

			<div class="wrapper">

				<div class="xl:flex xl:flew-wrap xl:align-items-start xl:justify-center xl:14/16 xl:mx-auto">

					<div class="column -tdm w-full xl:w-5/14 max-xl:hidden xl:pr-[5%] xl:mr-[5%] 1440:pr-[10%] 1440:mr-[10%] xl:border-r-[1px] xl:border-grey xl:h-auto  mb-24">
						<div class="post-tdm sticky top-[160px]"></div>
					</div>

					<div class="column -post w-full xl:w-10/14  mb-24">

						<ul class="meta mb-[7px] flex gap-2.5">
							<li class="rounded-[40px] bg-pink py-1.5 px-3">
								<?php echo 'Publié le ' . get_the_date('d/m/Y'); ?>
							</li>
							<?php
							$categories = get_the_category();
							if ($categories) {
								foreach ($categories as $cat) {
									echo '<li class="rounded-[40px] border-blue border-[1px] text-blue py-1.5 px-3">' . esc_html($cat->name) . '</li>';
								}
							}
							?>
						</ul>

						<h1 class="titre-h1 text-blue mb-8">
							<?php the_title() ?>
						</h1>

						<?php if (has_excerpt()) : ?>
							<div class="chapo mb-9">
								<?php the_excerpt() ?>
							</div>
						<?php endif ?>

						<?php
						if (has_post_thumbnail()) :
							$image_id = get_post_thumbnail_id();
							$image = wp_get_attachment_image_src($image_id, 'actualite');
							$image_url = $image[0];
						?>
							<img
								class="mb-16 rounded-[30px]"
								src="<?php echo $image_url; ?>"
								alt="">
						<?php endif; ?>

						<div class="post-content">
							<?php
							if ($content = get_field('content')) :
								get_template_part('partials/blocs', '', $content);
							endif;
							?>
						</div>

					</div>

				</div>

			</div>
		</article>

		<?php
		$args = array(
			'post_type' => 'post',
			'post_status' => 'publish',
			'orderby' => 'date',
			'order' => 'DESC',
			'posts_per_page' => 3,
			'fields' => 'ids',
			// 'post__not_in' => array($post->ID)
		);

		$other_posts = get_posts($args);
		if (count($other_posts) > 0) :
		?>

			<section class="other-posts bg-grey pt-15 pb-13">

				<div class="wrapper">

					<div class="xl:w-14/16 1440:w-12/16 xl:mx-auto">

						<h2 class="titre-h2 text-blue mb-8">Nos derniers articles</h2>

						<div class="flex flex-wrap gap-10">

							<?php foreach ($other_posts as $actu) : ?>

								<div class="w-full lg:w-[calc((100%/3)-(80px/2))] text-blue mb-8 xl:mb-0 bg-white rounded-[30px] shadow-[var(--menu-shadow)]">

									<figure class="relative">
										<?php
										if (has_post_thumbnail($actu)) :
											$image_id = get_post_thumbnail_id($actu);
											$image = wp_get_attachment_image_src($image_id, 'actualite_extrait');
											$image_url = $image[0];

										else :
											$image_url = get_template_directory_uri() . '/assets/img/actualite-placeholder.svg';
										endif;
										?>
										<div class="date absolute top-3.5 right-3.5 bg-white/70 rounded-[40px] text-primary py-1.5 px-3 leading-[1]">
											<?php echo get_the_date('d/m/y', $actu); ?>
										</div>
										<img
											class=" rounded-t-[30px]"
											src="<?php echo $image_url; ?>"
											alt="">
									</figure>

									<h3 class="titre-h3 bg-white px-7.5 mt-5 mb-3">
										<a
											class="hover:underline"
											href="<?php echo get_the_permalink($actu); ?>"><?php echo get_the_title($actu); ?></a>
									</h3>

									<div class="content bg-white rounded-b-[30px] pb-5.5 px-7.5">
										<div class="excerpt text-primary">
											<?php the_excerpt() ?>
										</div>
										<a
											class="block font-bold pt-4 mt-4  underline border-t-[1px] border-[#bcc2ca] flex items-center"
											href="<?php echo get_the_permalink($actu); ?>">
											<svg width="17" height="17" viewBox="0 0 17 17" fill="none" xmlns="http://www.w3.org/2000/svg">
												<path d="M2.65625 8.5H14.3438" stroke="#054BB4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
												<path d="M9.5625 3.71875L14.3438 8.5L9.5625 13.2812" stroke="#054BB4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
											</svg>
											<span class="block ml-1">Lire la suite</span></a>
									</div>
								</div>

							<?php endforeach; ?>

						</div>

						<footer class="mt-16 pb-8">

							<a href="<?php echo get_permalink(get_option('page_for_actualites')); ?>"></a>
							<a class="group block font-display font-bold text-[16px] bg-blue text-white max-xl:mx-auto pt-[16px] pb-[16px] px-[28px] rounded-[60px] cursor-pointer max-xl:mb-[48px] w-fit mx-auto" href="/nos-conseils-dexpert/" target="<?php echo esc_attr($link_target); ?>">

								Voir tous les articles
							</a>
						</footer>
					</div>
				</div>

			</section>
		<?php endif; ?>
	</main>

</div>

<?php get_footer() ?>