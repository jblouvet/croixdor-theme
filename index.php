<?php get_header() ?>

<div class="site-content flex-1">

  <main class="page-content">

    <section
      class="bg-gradient-to-r from-[#111825] to-[#213350] xl:pb-18 w-full max-h-[300px] min-h-[300px] md:max-h-[510px] md:min-h-[510px] xl:pt-[calc(92px+70px)] relative flex flex-col">

      <figure class="absolute z-1 bottom-0 left-0 w-full">
        <img src="<?= get_template_directory_uri() . '/assets/img/podium_alt-optimised.png' ?>" alt=""
          class="w-[326px] h-[171px] md:w-[726px] md:h-[358px] mx-auto max-w-full">
      </figure>

      <div class="relative z-2 flex-1 w-full flex flex-col">

        <div class="w-[326px] h-[171px] md:w-[726px] md:h-[358px] max-w-full mx-auto mt-auto flex flex-wrap items-end">
          <?php
          $top_query = new WP_Query([
            'post_type' => 'pharmacien',
            'posts_per_page' => 3,
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'fields' => 'ids'
          ]);

          if ($top_query->have_posts()):
            $rank_counter = 0;
            while ($top_query->have_posts()):
              $top_query->the_post();
              $id = get_the_ID();
              $order_class = 'order-3 pb-2.5 md:pb-5';
              $title_class = '!text-xs md:!text-[23px]'; // Default to 3rd pos
              if ($rank_counter === 0) {
                $order_class = 'order-2  pb-3 md:pb-7'; // 1st place -> middle
                $title_class = '!text-sm md:!text-[26px]';
              }
              if ($rank_counter === 1)
                $order_class = 'order-1 pb-2.5 md:pb-5'; // 2nd place -> left
          
              ?>
              <div class="flex flex-col items-center mx-auto text-center w-1/3 z-10 relative <?= $order_class ?>">
                <h3 class="text-white font-bold text-lg mb-1 leading-tight <?= $title_class ?>">
                  <?php echo get_field('prenom', $id); ?><br>
                  <?php echo get_field('nom', $id); ?>
                </h3>
                <span class="text-green text-[8px] md:text-[17px]"><span
                    class="font-bold text-[12px] md:text-[23px]"><?php echo get_field('points', $id); ?></span>
                  pts</span>
              </div>
              <?php
              $rank_counter++;
            endwhile;
            wp_reset_postdata();
          endif;
          ?>
        </div>

      </div>

    </section>

    <div class="wrapper">

      <div class="xl:w-14/16 1440:w-12/16 xl:mx-auto pb-13 py-12 xl:py-19">

        <?php if (have_posts()): ?>

          <h1 class="titre-h1 text-center text-blue mb-4.5">Nos pharmaciens<br> certifiés Croix d'Or</h1>

          <div class="text-center">
            <p>Les titulaires ayant obtenu au moins 75 % de bonnes réponses,<br class="max-sm:hidden"> soit un score
              minimum de 247 points sur
              330.</p>
          </div>

          <div class="all-posts mt-11.5 xl: mt-17">
            <?php $i = 1; ?>
            <?php while (have_posts()):
              the_post(); ?>

              <div class="flex w-full bg-grey even:bg-white rounded-[12px] h-[86px] items-center">
                <div class="w-[46px] mdw-[124px] text-center font-bold text-[14px] md:text-[16px]">
                  <?php if ($ordre = get_field('ordre')): ?>
                    <?php if ($ordre <= 3): ?>
                      <img class="mx-auto" src="<?= get_template_directory_uri() . '/assets/img/croix-' . $ordre . '.svg' ?>"
                        alt="<?= $ordre ?>">
                    <?php else: ?>
                      <?= $ordre ?>
                    <?php endif ?>
                  <?php endif ?>
                </div>
                <div class="flex-1 font-bold text-[14px] md:text-[16px] pl-2.5">
                  <?= get_field('prenom') ?>     <?= get_field('nom') ?>
                </div>
                <div class="mx-5">
                  <?php if ($medaille = get_field('medaille')): ?>
                    <img class="max-md:w-[32px]"
                      src="<?= get_template_directory_uri() . '/assets/img/croix-' . $medaille . '-couronne.svg' ?>"
                      alt="<?= $medaille ?>">
                  <?php endif ?>
                </div>
                <div class="mr-6">
                  <?php
                  $points = get_field('points');
                  if ($points > 297) {
                    $style = 'podium text-white bg-gold';
                  } elseif ($points > 279) {
                    $style = 'or text-gold bg-gold/20';
                  } else {
                    $style = 'argent text-argent bg-[#F3F2F3]';
                  }
                  ?>
                  <div class="cartouche <?= $style ?>  text-[14px] md:text-[16px] font-medium px-3 py-1 rounded-[30px]">
                    <?= get_field('points') ?> <span class="text-[10px] md:text-xs">pts</span>
                  </div>
                </div>
              </div>

              <?php $i++; endwhile ?>

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