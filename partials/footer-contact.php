<?php if ($adresse = get_field('contact_adresse', 'options')): ?>
	<p><?= $adresse ?></p>
<?php endif ?>

<?php if ($tel = get_field('contact_telephone', 'options')): ?>
	<p><?= $tel ?></p>
<?php endif ?>

<p class="mt-[2.5em]"><a href="<?= !is_front_page() ? '/' : ''; ?>#contact">Nous contacter</a></p>