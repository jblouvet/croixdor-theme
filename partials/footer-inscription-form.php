<?php
/**
 * Partial: Footer Inscription Form
 */
?>
<div id="inscription-modal"
	class="fixed inset-0 z-[9999] flex items-end justify-center bg-black/50 opacity-0 pointer-events-none transition-opacity duration-300"
	aria-hidden="true">
	<!-- Modal Content: Slide from bottom, rounded top, full width on mobile/tablet (max-w-3xl for larger screens logic can remain or be full width if user really wants full width everywhere, but "pleine largeur" usually implies mobile behavior or full viewport width. User said "pleine largeur", but kept "ressemble au menu mobile" so I'll make it full width at bottom) -->
	<div
		class="inscription-modal-content bg-white w-full mx-auto rounded-t-[30px] p-6 pt-10 pb-10 h-[calc(100vh-106px)] overflow-y-auto relative shadow-xl duration-300">
		<div class="wrapper">
			<div class="xl:w-14/16 mx-auto">
				<!-- Handle bar (decorative) -->
				<div class=" absolute top-4 left-1/2 -translate-x-1/2 w-12 h-1 bg-gray-300 rounded-full"></div>

				<button type="button" class="absolute top-6 right-6 text-gray-400 hover:text-gray-800 focus:outline-none"
					aria-label="Fermer" onclick="document.getElementById('inscription-modal').classList.remove('active');">
					<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
					</svg>
				</button>



				<div class="flex flex-wrap mt-12">
					<div class="w-full lg:w-5/16 mb-12">
						<div class="xl:w-3/5 xl:mx-auto editor-content  type-ok">
							<img class="w-[96px]" src="<?php echo get_template_directory_uri(); ?>/assets/img/croix-or-couronne.svg"
								alt="">
							<p class="titre-h2 !text-[24px] text-blue mt-4 !mb-0">Démarrer mon bilan stratégique</p>
							<p class="mt-4">Exclusivement réservé aux pharmaciens d’officine.</p>
							<ul class="mt-4 max-lg:flex max-lg:flex-wrap gap-4 [&>li]:max-lg:!mt-0">
								<li>100% gratuit</li>
								<li>Confidentiel</li>
								<li>Sans engagements</li>

							</ul>
						</div>
					</div>
					<div class="w-full lg:w-11/16">
						<div class="xl:w-9/11 lg:mx-auto">
							<h2 class="titre-h1 font-display font-bold mb-12 text-primary">Mon espace formation</h2>
							<form id="inscription-form" class="space-y-6 mx-auto">

								<!-- Informations Personnelles -->
								<div>
									<h3 class="titre-h2 !text-[24px] text-primary mt-12 mb-8">Informations Personnelles</h3>
									<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
										<div class="relative">
											<label for="lastname"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Nom
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="lastname" name="lastname" required placeholder="Votre nom"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
										<div class="relative">
											<label for="firstname"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Prénom
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="firstname" name="firstname" required placeholder="Votre prénom"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>

										<div class="relative">
											<label for="mail"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Email
												<span class="text-[#D32F2F]">*</span></label>
											<input type="email" id="mail" name="mail" required placeholder="Votre email"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
										<div class="relative">
											<label for="phone"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Téléphone
												<span class="text-[#D32F2F]">*</span></label>
											<input type="tel" id="phone" name="phone" required placeholder="Votre téléphone"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
									</div>
								</div>

								<!-- Informations Société -->
								<div>
									<h3 class="titre-h2 !text-[24px] text-primary mt-12 mb-8">Informations Société</h3>
									<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
										<div class="md:col-span-2 relative">
											<label for="company_name"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Nom
												de la société
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="company_name" name="company_name" required placeholder="Nom de la société"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
										<div class="md:col-span-2 relative">
											<label for="company_street"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Rue
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="company_street" name="company_street" required
												placeholder="Adresse de la société"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
										<div class="relative">
											<label for="company_postalcode"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Code
												Postal
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="company_postalcode" name="company_postalcode" required
												placeholder="Code postal"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
										<div class="relative">
											<label for="company_city"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Ville
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="company_city" name="company_city" required placeholder="Ville"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
										<div class="md:col-span-2 relative">
											<label for="company_siret"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">SIRET
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="company_siret" name="company_siret" required placeholder="SIRET"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
									</div>
								</div>

								<!-- Représentant Légal -->
								<div>
									<h3 class="titre-h2 !text-[24px] text-primary mt-12 mb-8">Représentant Légal</h3>
									<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
										<div class="relative">
											<label for="company_representative_lastname"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Nom
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="company_representative_lastname" name="company_representative_lastname"
												required placeholder="Nom du représentant"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
										<div class="relative">
											<label for="company_representative_firstname"
												class="absolute top-2.5 left-3.5 !z-1 !text-sm !text-primary !opacity-30 !pointer-events-none font-bold">Prénom
												<span class="text-[#D32F2F]">*</span></label>
											<input type="text" id="company_representative_firstname" name="company_representative_firstname"
												required placeholder="Prénom du représentant"
												class="pt-7 w-full h-[53px] rounded-[15px] border-transparent pb-2 px-3.5 shadow-[0_0_20px_0_rgba(25,36,54,0.07)] focus:border-blue focus:ring-0 text-primary placeholder:text-[#213350] placeholder:opacity-40 leading-[1.3]">
										</div>
									</div>
								</div>

								<div class="mt-12">
									<button type="submit"
										class="w-fit bg-blue text-white font-bold py-3 rounded-[60px] h-[50px] font-display hover:bg-opacity-90 transition duration-150 ease-in-out disabled:opacity-50 disabled:cursor-not-allowed px-7.5">
										M'inscrire à l'espace formation
									</button>
								</div>

								<div id="form-message" class="hidden mt-4 p-4 rounded text-center"></div>

							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
	#inscription-modal.active {
		opacity: 1;
		pointer-events: auto;
	}

	.inscription-modal-content {
		transform: translateY(100%);
		transition: transform 300ms ease-in-out;
	}

	#inscription-modal.active .inscription-modal-content {
		transform: translateY(0);
	}
</style>