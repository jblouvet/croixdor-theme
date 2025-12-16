<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<!-- Google Tag Manager -->

	<!-- End Google Tag Manager -->

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta http-equiv="x-ua-compatible" content="ie=edge">

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,100..1000;1,9..40,100..1000&display=swap"
		rel="stylesheet">

	<!-- favicon -->

	<link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96" />
	<link rel="icon" type="image/svg+xml" href="/favicon.svg" />
	<link rel="shortcut icon" href="/favicon.ico" />
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png" />
	<meta name="apple-mobile-web-app-title" content="Pharmaplace" />
	<link rel="manifest" href="/site.webmanifest" />

	<!-- / favicon -->

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

	<div class="flex flex-col min-h-screen site">

		<header
			class="site-header header py-[21px] xl:py[40px] fixed top-0 left-0 right-0 bg-transparent z-50 transition-transform translate-y-0 will-change-transform backface-hidden [&.is-unpinned]:-translate-y-full [&.is-not-top]:bg-blue-dark"
			id="header">

			<div class="wrapper h-full flex items-center justify-between w-full">

				<!-- Logo -->
				<a href="/" class="logo mr-auto xl:w-3/16" id="logo">
					<img class="w-[166px] xl:w-[240px]" src="<?= get_template_directory_uri() ?>/assets/img/croixdor-logo.png"
						alt="Croix Dor">
				</a>

				<!-- Desktop Navigation -->

				<nav
					class="site-nav font-display max-xl:absolute max-xl:top-0 max-xl:left-0 max-xl:right-0 max-xl:h-[100vh] max-xl:pt-[106px] max-xl:bg-black/50 max-xl:w-full font-medium text-[16px] xl:text-[14px] text-center xl:text-left xl:w-full"
					role="navigation">

					<div
						class="max-xl:rounded-t-[30px] flex max-xl:items-start flex-wrap max-xl:bg-blue-dark max-xl:h-full xl:w-full">

						<span
							class="hidden max-xl:block w-[112px] h-[5px] mx-auto mt-[20px] mb-[36px] bg-[#EDF0F5] rounded-[2px]"></span>

						<div
							class="flex xl:items-center max-xl:flex-col max-xl:items-center max-xl:justify-start max-xl:flex-wrap w-full">
							<div class="max-xl:mb-[48px] xl:hidden">
								<img class="w-[240px]" src="<?= get_template_directory_uri() ?>/assets/img/croixdor-logo.png"
									alt="Croix Dor">
							</div>

							<div class="max-xl:flex-1 max-xl:grow-0 max-xs:mb-[24px] xs:max-xl:mb-[48px] xl:ml-auto">
								<?php wp_nav_menu([
									"theme_location" => "header",
									"menu_id" => "",
									"menu_class" => "max-xl:w-full xl:flex xl:gap-x-[20px] [&>li:last-child>a]:xl:border [&>li:last-child>a]:xl:!border-white [&>li:last-child>a]:xl:hover:bg-white [&>li:last-child>a]:xl:hover:!text-blue-dark [&>li:last-child>a]:xl:px-[12px] [&>li:last-child>a]:1440:px-[30px] [&>li:last-child>a]:xl:!rounded-[120px]",
									"container" => "",
								]); ?>
							</div>

							<?php get_template_part('partials/header', 'social') ?>

						</div>

					</div>

				</nav>

				<!-- Mobile Menu Button -->
				<?php get_template_part('partials/header', 'hamburger') ?>

			</div>
		</header>