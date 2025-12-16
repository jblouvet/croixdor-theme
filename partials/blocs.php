<?php

if ($blocs = $args['blocs']):

	foreach ($blocs as $bloc):

		/**
		 * BLOC RELANCE
		 */

		if ($bloc['acf_fc_layout'] == 'relance'):
			get_template_part('partials/bloc', 'relance', $bloc);
		endif;

		/**
		 * BLOC ÉQUIPE
		 */

		if ($bloc['acf_fc_layout'] == 'equipe'):
			get_template_part('partials/bloc', 'equipe', $bloc);
		endif;

		/**
		 * BLOC ACCORDÉON
		 */

		if ($bloc['acf_fc_layout'] == 'accordeon'):
			get_template_part('partials/bloc', 'accordeon', $bloc);
		endif;

		/**
		 * BLOC FEATURED (2 cols)
		 */

		if ($bloc['acf_fc_layout'] == 'featured'):
			get_template_part('partials/bloc', 'featured', $bloc);
		endif;

		/**
		 * BLOC TXT IMG (2 cols)
		 */

		if ($bloc['acf_fc_layout'] == 'text_img'):
			get_template_part('partials/bloc', 'text_img', $bloc);
		endif;

		/**
		 * BLOC HERO
		 */

		if ($bloc['acf_fc_layout'] == 'hero'):
			get_template_part('partials/bloc', 'hero', $bloc);
		endif;

		/**
		 * BLOC TXT TXT (2 cols)
		 */

		if ($bloc['acf_fc_layout'] == 'text_text'):
			get_template_part('partials/bloc', 'text_text', $bloc);
		endif;

		/**
		 * BLOC TABS
		 */

		if ($bloc['acf_fc_layout'] == 'onglets'):
			get_template_part('partials/bloc', 'tabs', $bloc);
		endif;

		/**
		 * BLOC WYSIWYG
		 */

		if ($bloc['acf_fc_layout'] == 'wysiwyg'):
			get_template_part('partials/bloc', 'wysiwyg', $bloc);
		endif;

		/**
		 * BLOC BTN / CTA
		 */

		if ($bloc['acf_fc_layout'] == 'btn_cta'):
			get_template_part('partials/bloc', 'cta', $bloc);
		endif;

		/**
		 * BLOC CONTACT FORM
		 */

		if ($bloc['acf_fc_layout'] == 'contact_form'):
			get_template_part('partials/bloc', 'contact_form', $bloc);
		endif;

		/**
		 * BLOC ANNONCES
		 */

		if ($bloc['acf_fc_layout'] == 'annonces'):
			get_template_part('partials/bloc', 'annonces', $bloc);
		endif;

		/**
		 * BLOC TEMOIGNAGES / CONTACT
		 */

		if ($bloc['acf_fc_layout'] == 'temoignages'):
			get_template_part('partials/bloc', 'temoignages', $bloc);
		endif;

		/**
		 * BLOC TEMOIGNAGES
		 */

		if ($bloc['acf_fc_layout'] == 'temoignages_alt'):
			get_template_part('partials/bloc', 'temoignages_alt', $bloc);
		endif;

		/**
		 * BLOC EXPERTS
		 */

		if ($bloc['acf_fc_layout'] == 'experts'):
			get_template_part('partials/bloc', 'experts', $bloc);
		endif;

	endforeach;

endif;
