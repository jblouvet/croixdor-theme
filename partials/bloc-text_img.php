<?php
$col_text = $args['col_txt'];
$col_img = $args['col_img'];
$ordre = $args['ordre'];
$img_first = $ordre === "image et texte";

$bg_dark = $args['bg'];
?>

<section
	class="bloc-text_img <?= $bg_dark ? 'is-dark bg-gradient-to-r from-[#111825] to-[#213350] pt-18' : 'pb-9 xl:pb-18' ?>">

	<div class="wrapper">

		<div class="w-full mx-auto xl:w-14/16 flex flex-wrap items-center">

			<?php if ($col_text): ?>

				<div class="col-text w-full xl:w-1/2 <?= $img_first ? 'order-2' : ''; ?> <?= $bg_dark ? 'pb-9 xl:pb-18' : '' ?>">
					<div class="w-full xl:w-6/7 <?= $img_first ? 'ml-auto' : 'mr-auto'; ?>">
						<?php if ($title = $col_text['titre']): ?>
							<h2 class="titre-h1 <?= $bg_dark ? 'text-white' : 'text-blue' ?> mb-10"><?= $title ?></h2>
						<?php endif ?>

						<?php if ($chapo = $col_text['chapo']): ?>
							<div class="chapo [&>p]:mb-[1.5em] [&>p>strong]:font-bold <?= $bg_dark ? 'text-white' : '' ?>"><?= $chapo ?>
							</div>
						<?php endif ?>

						<?php if ($content = $col_text['contenu_1']): ?>
							<div class="editor-content type-<?= $col_text['list_style'] ?>">
								<div class="xl:w-5/6 max-xl:mb-11">
									<?= $content ?>
								</div>
							</div>
						<?php endif ?>

						<?php if ($cta = $col_text['cta']): ?>
							<?php get_template_part('partials/bloc', 'cta', $cta) ?>
						<?php endif ?>
					</div>
				</div>

			<?php endif ?>

			<?php if ($col_img): ?>

				<div class="col-img w-full xl:w-1/2 <?= $img_first ? 'order-1' : ''; ?> <?= $bg_dark ? 'mt-auto' : '' ?>">

					<div
						class="max-xl:w-full max-xl:max-w-[480px] max-xl:mx-auto xl:w-6/7 relative <?= $img_first ? 'max-xl:mb-10' : 'xl:ml-auto'; ?>">

						<?php if ($col_img['image']): ?>

							<?php if ($img_sup = $col_img['image_sup']):

								$src = '';
								$mime = '';
								$att_id = null;

								if (is_array($img_sup)) {
									$src = $img_sup['url'] ?? ($img_sup['sizes']['full'] ?? '');
									$mime = $img_sup['mime_type'] ?? '';
									$att_id = $img_sup['ID'] ?? null;
								} else {
									$src = $img_sup;
								}
								$is_svg = ($mime === 'image/svg+xml') || preg_match('/\.svg(\?.*)?$/i', $src);
							endif; ?>

							<img src="<?= $col_img['image']['url'] ?>" alt=""
								class="w-full <?= $img_sup && $is_svg ? 'opacity-0 transition-opacity duration-500 ease-out' : ''; ?>">

						<?php endif ?>

						<?php if ($img_sup):

							if ($is_svg) {
								$svg = '';

								// 1) si on a l'ID d'attachement, récupérer le fichier local
								if ($att_id && function_exists('get_attached_file')) {
									$file = get_attached_file($att_id);
									if ($file && file_exists($file)) {
										$svg = file_get_contents($file);
									}
								}

								// 2) mapper l'URL d'uploads vers le système de fichiers
								if (empty($svg) && function_exists('wp_get_upload_dir')) {
									$uploads = wp_get_upload_dir();
									if (strpos($src, $uploads['baseurl']) === 0) {
										$path = str_replace($uploads['baseurl'], $uploads['basedir'], $src);
										if (file_exists($path)) {
											$svg = file_get_contents($path);
										}
									}
								}

								// 3) fallback : récupérer à distance
								if (empty($svg) && function_exists('wp_remote_get')) {
									$response = wp_remote_get($src);
									if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
										$svg = wp_remote_retrieve_body($response);
									}
								}

								// Afficher le SVG inline si possible, sinon fallback <img>
								if (!empty($svg)) {
									$classes = 'absolute top-0 left-0 h-full w-auto max-w-[200%]';

									// si le SVG a déjà un attribut class, concaténer, sinon l'ajouter
									if (preg_match('/<svg[^>]*class=[\'"]([^\'"]*)[\'"]/i', $svg, $m)) {
										$existing = $m[1];
										$new = trim($existing . ' ' . $classes);
										$svg = preg_replace('/(<svg[^>]*class=[\'"])[^\'"]*([\'"])/i', '$1' . $new . '$2', $svg, 1);
									} else {
										$svg = preg_replace('/<svg(\s+)/i', '<svg class="' . $classes . '" $1', $svg, 1);
									}

									// Afficher le SVG brut (si nécessaire, ajouter une sanitation supplémentaire)
									echo '<div class="anim-svg [&>svg>*]:opacity-0 [&>svg>*]:-translate-y-2 [&>svg>*]:transform [&>svg>*]:transition-all [&>svg>*]:duration-300 [&>svg>*]:ease-out">';
									echo $svg;
									echo '</div>';
									?>

									<script>
										document.addEventListener("DOMContentLoaded", () => {
											const animSvgs = document.querySelectorAll('.anim-svg');

											if (!animSvgs || animSvgs.length === 0) return;

											animSvgs.forEach((el) => {
												// chercher le conteneur relatif parent puis l'image "jpg" principale
												const container = el.closest('.relative') || el.parentElement;
												const jpg = container ? container.querySelector('img.w-full') : null;

												// préparer le jpg pour un fade (si présent)
												if (jpg) {
													jpg.style.transition = 'opacity 600ms ease';
													// forcer état initial invisible pour l'animation
													jpg.style.opacity = 0;
												}

												// récupérer le <svg> inline
												const svg = el.querySelector('svg');
												if (!svg) {
													// si pas de svg inline, afficher directement le jpg
													if (jpg) setTimeout(() => (jpg.style.opacity = 1), 80);
													return;
												}

												// sélectionner les éléments animables (exclure defs)
												const selector = 'g, path, circle, rect, polygon, line, polyline, text';
												let nodes = Array.from(svg.querySelectorAll(selector))
													.filter(n => n.closest('defs') === null);

												// si aucun nœud, on fait juste apparaître le jpg
												if (nodes.length === 0) {
													if (jpg) setTimeout(() => (jpg.style.opacity = 1), 80);
													return;
												}

												// initialiser styles des noeuds SVG
												nodes.forEach(node => {
													node.style.transition = 'opacity 400ms ease, transform 400ms ease';
													node.style.opacity = 0;
													node.style.transform = 'translateY(8px)';
													node.style.transformOrigin = 'center';
												});

												// orchestration : fade jpg puis stagger les éléments du svg
												const jpgFadeDelay = 100; // délai avant de déclencher le fade du jpg
												const svgStartAfter = 200; // délai après le début du fade jpg pour démarrer svg
												const stagger = 80; // temps entre chaque élément svg

												setTimeout(() => {
													if (jpg) jpg.style.opacity = 1;

													// lancer les animations SVG en cascade
													nodes.forEach((node, i) => {
														setTimeout(() => {
															node.style.opacity = 1;
															node.style.transform = 'translateY(0)';
														}, svgStartAfter + i * stagger);
													});
												}, jpgFadeDelay);
											});
										});
									</script>

									<?php
								} else {
									?>
									<img class="absolute top-0 left-0 h-full w-auto max-w-[200%]" src="<?= esc_url($src) ?>" alt="">
									<?php
								}
							} else {
								?>
								<img class="absolute top-0 left-0 h-full w-auto max-w-[200%]" src="<?= esc_url($src) ?>" alt="">
								<?php
							}
							?>
						<?php endif ?>

					</div>
				</div>
			<?php endif ?>

		</div>
	</div>

</section>