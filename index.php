<?php get_header() ?>

<div class="site-content flex-1">

  <main class="page-content">

    <div class="wrapper">

      <div class="xl:w-14/16 1440:w-12/16 xl:mx-auto pb-13">

        <?php if (have_posts()) : ?>

          <h1 class="titre-h1 text-center text-blue mb-4.5">Nos articles conseils d'experts</h1>

          <?php if ($categories = get_categories(['hide_empty' => true])) : ?>
            <ul class="categories-list mb-12 lg:mb-27 flex justify-center items-center gap-2.5">
              <?php
              $is_all_active = (!is_category()) ? 'is-active' : '';
              ?>
              <li>
                <a href="<?php echo get_permalink(get_option('page_for_posts')); ?>" class="text-blue border-[1px] border-blue rounded-[40px] px-4 py-1.5 leading-[1] <?php echo $is_all_active; ?> opacity-70 [&.is-active]:opacity-100">
                  Tous les articles
                </a>
              </li>
              <?php foreach ($categories as $cat) : ?>
                <?php
                $is_active = (is_category() && get_queried_object_id() === $cat->term_id) ? 'is-active' : '';
                ?>
                <li>
                  <a href="<?php echo get_category_link($cat->term_id); ?>" class="text-blue border-[1px] border-blue rounded-[40px] px-4 py-1.5 leading-[1] <?php echo $is_active; ?> opacity-70 [&.is-active]:opacity-100">
                    <?php echo esc_html($cat->name); ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>

          <div class=" all-posts flex flex-wrap gap-10">

            <?php while (have_posts()) : the_post(); ?>

              <div class="flex flex-col w-full lg:w-[calc((100%/3)-(80px/2))] text-blue mb-8 xl:mb-0 bg-white rounded-[30px] shadow-[var(--menu-shadow)]">

                <figure class="relative">
                  <?php
                  if (has_post_thumbnail($actu)) :
                    $image_id = get_post_thumbnail_id($actu);
                    $image = wp_get_attachment_image_src($image_id, 'actualite_extrait');
                    $image_url = $image[0];
                  else :
                    $image_url = get_template_directory_uri() . '/assets/img/actualite-placeholder.svg';
                  endif;
                  $cats = get_the_category($actu);
                  $first_cat = (!empty($cats) && !is_wp_error($cats)) ? esc_html($cats[0]->name) : '';
                  ?>
                  <div class="absolute top-3.5 right-3.5 flex gap-2.5">
                    <?php if ($first_cat) : ?>
                      <div class="date bg-white/70 rounded-[40px] text-primary py-1.5 px-3 leading-[1]">
                        <?php echo $first_cat; ?>
                      </div>
                    <?php endif; ?>

                    <div class="date bg-white/70 rounded-[40px] text-primary py-1.5 px-3 leading-[1]">
                      <?php echo get_the_date('d/m/y', $actu); ?>
                    </div>
                  </div>

                  <img
                    class=" rounded-t-[30px]"
                    src="<?php echo $image_url; ?>"
                    alt="">

                </figure>

                <div class="flex flex-col h-full flex-1 px-7.5 pb-5.5">

                  <h3 class="titre-h3 bg-white mt-5 mb-3">
                    <a
                      class="hover:underline"
                      href="<?php echo get_the_permalink($actu); ?>"><?php echo get_the_title($actu); ?></a>
                  </h3>

                  <div class="excerpt flex-1 text-primary mb-4">
                    <?php the_excerpt() ?>
                  </div>

                  <div class="mt-auto">
                    <hr class="my-3 bg-[#213350] opacity-30">

                    <a class="group block font-display font-bold text-[14px] bg-white text-blue -translate-x-5 px-[18px] rounded-[60px] cursor-pointer transition-all:stroke-blue" href="<?php echo get_the_permalink($actu); ?>">
                      <div class=" flex items-center transition-all [&>svg>path]:stroke-blue ">
                        <?php get_template_part('partials/icon', 'arrow-right.svg') ?>
                        <span class="ml-2.5 group-hover:underline">Lire la suite</span>
                      </div>
                    </a>
                  </div>

                </div>
              </div>

            <?php endwhile ?>

            <?php
            $max_num_pages = $wp_query->max_num_pages;
            $current_page = max(1, get_query_var('paged'));
            set_query_var('max_num_pages', $max_num_pages); // <-- Ajoute cette ligne
            set_query_var('current_page', $current_page);   // <-- Ajoute cette ligne
            get_template_part('partials/pagination');
            ?>

          </div>

        <?php endif ?>

      </div>

    </div>

  </main>

</div>

<?php get_footer() ?>