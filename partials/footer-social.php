							<ul class="social-links">
								<?php if ($facebook = get_field('facebook', 'options')) : ?>
									<li>
										<a href="<?= $facebook ?>" target="_blank" class="opacity-100 hover:opacity-80 transition-all">Facebook</a>
									</li>
								<?php endif ?>
								<?php if ($instagram = get_field('instagram', 'options')) : ?>
									<li>
										<a href="<?= $instagram ?>" target="_blank" class="opacity-100 hover:opacity-80 transition-all">Instagram</a>
									</li>
								<?php endif ?>
								<?php if ($linkedin = get_field('linkedin', 'options')) : ?>
									<li>
										<a href="<?= $linkedin ?>" target="_blank" class="opacity-100 hover:opacity-80 transition-all">Linkedin</a>
									</li>
								<?php endif ?>
							</ul>