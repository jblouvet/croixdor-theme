<section class="bloc-temoignages py-15 xl:py-22">

	<div class="wrapper">

		<div class="w-full xl:w-14/16 mx-auto">

			<div class="grid gap-5 md:grid-cols-2 xl:grid-cols-14 ">

				<div class="item rounded-[40px] bg-blue text-white w-full col-span-1 xl:col-span-5 xl:row-span-2 py-10 px-7.5 flex flex-col">
					<div class="flex flex-wrap w-full max-xs:max-w-[260px] xs:max-md:max-w-[300px] max-md:mx-auto justify-between items-center gap-5 mb-7.5">
						<h2 class="font-display font-bold text-[18px] max-xs:max-w-[260px] xs:max-md:max-w-[300px] !w-fit">Témoignages</h2>
						<div class="swiper-pagination !static !w-fit [&>.swiper-pagination-bullet]:border [&>.swiper-pagination-bullet]:border-white [&>.swiper-pagination-bullet]:!bg-transparent [&>.swiper-pagination-bullet]:!opacity-100 [&>.swiper-pagination-bullet]:!rounded-[10px] [&>.swiper-pagination-bullet.swiper-pagination-bullet-active]:!bg-white [&>.swiper-pagination-bullet.swiper-pagination-bullet-active]:!w-[16px]"></div>
					</div>
					<div class="swiper testimonials-swiper w-full max-xs:max-w-[260px] xs:max-md:max-w-[300px] mt-auto">
						<div class="swiper-wrapper">
							<?php foreach ($args['temoignages'] as $t) : ?>
								<div class="swiper-slide flex flex-col">
									<p class="mt-auto  text-[16px]"><?= $t['citation'] ?></p>
									<p class="font-display font-bold my-7.5"><?= $t['attribution'] ?></p>
									<div class="bg-white/30 w-fit py-1 px-2 rounded-[60px]">
										⭐ ⭐ ⭐ ⭐ ⭐
									</div>
								</div>
							<?php endforeach ?>
						</div>

					</div>
				</div>

				<div class=" item rounded-[40px] bg-grey xl:col-span-9 p-7.5 xl:p-0">
					<div class="flex flex-wrap xl:flex-row-reverse">
						<img src="<?= $args['image_1']['url'] ?>" alt="" class="rounded-[40px] w-[125px] xl:w-1/3">
						<div class="w-full xl:w-2/3 md:flex md:flex-col">
							<p class="chapo py-5 xl:px-10 xl:pt-10 xl:pb-5 max-w-[28em]"><?= $args['push_action'] ?></p>
							<button class="js-match bg-blue text-white group font-display font-bold text-[14px] md:text-[16px] pt-[16px] pb-[16px] px-[28px] rounded-[60px] cursor-pointer max-md:mx-auto xl:mx-10 w-fit md:mt-auto xl:mb-10">
								<div class="flex items-center justify-center group-hover:-translate-y-[4px] translate-y-0 transition-all">
									<span class="ml-2.5">Alors, on passe à l'acte&nbsp;?</span>
								</div>
							</button>
						</div>
					</div>
				</div>

				<div class="max-md:hidden item rounded-[40px] xl:col-span-5">
					<img src="<?= $args['image_2']['url'] ?>" alt="" class="rounded-[40px] w-full h-full object-cover">
				</div>

				<div class="item rounded-[40px] bg-green xl:col-span-4 p-7.5 relative">
					<div class="max-w-[calc(100%-78px-30px)] h-full flex flex-col [&>h2]:font-bold [&>h2]:text-[18px] [&>h2]:font-display [&>h2]:mb-2.5 [&>p]:text-[16px] [&>p:last-child]:mt-auto [&>p:last-child]:font-bold [&>p_a]:!underline [&>p_a]:tracking-[.03em] mb-12">
						<?= $args['contact'] ?>
					</div>
					<img class="w-[78px] h-[78px] rounded-[18px] absolute max-xl:top-5 right-5 xl:bottom-5 object-cover" src="<?= $args['vignette_contact'] ? $args['vignette_contact']['url'] : get_template_directory_uri() . '/assets/img/photo-lyon-optimised.jpg' ?>" alt="">
				</div>
			</div>
		</div>
	</div>
</section>