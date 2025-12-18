<?php
$noms = ['Martin', 'Bernard', 'Thomas', 'Petit', 'Robert', 'Richard', 'Durand', 'Dubois', 'Moreau', 'Laurent', 'Simon', 'Michel', 'Lefebvre', 'Leroy', 'Roux', 'David', 'Bertrand', 'Morel', 'Fournier', 'Girard', 'Bonnet', 'Dupont', 'Lambert', 'Fontaine', 'Rousseau', 'Vincent', 'Muller', 'Lefevre', 'Faure', 'Andre', 'Mercier', 'Blanc', 'Guerin', 'Boyer', 'Garnier', 'Chevalier', 'Francois', 'Legrand', 'Gauthier', 'Garcia', 'Perrin', 'Robin', 'Clement', 'Morin', 'Nicolas', 'Henry', 'Roussel', 'Mathieu', 'Gautier', 'Masson', 'Marchand', 'Duval', 'Denis', 'Dumont', 'Marie', 'Lemaire', 'Noel', 'Meyer', 'Dufour', 'Meunier', 'Brun', 'Blanchard', 'Giraud', 'Joly', 'Riviere', 'Lucas', 'Brunet', 'Gaillard', 'Barbier', 'Arnaud', 'Martinez', 'Gerard', 'Roche', 'Renard', 'Schmitt', 'Roy', 'Leroux', 'Colin', 'Vidal', 'Caron', 'Picard', 'Roger', 'Fabre', 'Aubert', 'Lemoine', 'Renaud', 'Dumas', 'Lacroix', 'Olivier', 'Philippe', 'Bourgeois', 'Pierre', 'Benoit', 'Rey', 'Leclerc', 'Payet', 'Rolland', 'Leclercq', 'Guillaume', 'Lecomte', 'Lopez', 'Jean', 'Dupuy', 'Guillot', 'Hubert', 'Berger', 'Carpentier', 'Sanchez', 'Deschamps', 'Moulin', 'Louis', 'Vasseur', 'Perez', 'Huet', 'Boucher', 'Fleury', 'Royer', 'Kleim', 'Adam', 'Gregoire', 'Millet', 'Delmas', 'Lamy'];
$prenoms = ['Jean', 'Marie', 'Philippe', 'Nathalie', 'Michel', 'Isabelle', 'Alain', 'Sylvie', 'Patrick', 'Catherine', 'Nicolas', 'Martine', 'Christophe', 'Christine', 'Pierre', 'Francoise', 'Christian', 'Valerie', 'Eric', 'Sandrine', 'Stephane', 'Stephanie', 'Laurent', 'Veronique', 'Pascal', 'Sophie', 'David', 'Celine', 'Daniel', 'Chantal', 'Didier', 'Joelle', 'Frederic', 'Renee', 'Olivier', 'Virginie', 'Mickael', 'Aurelie', 'Claude', 'Elodie', 'Jeremy', 'Laetitia', 'Antoine', 'Caroline', 'Marc', 'Sarah', 'Sebastien', 'Camille', 'Guillaume', 'Julie', 'Julien', 'Emilie', 'Thierry', 'Lea', 'Jerome', 'Manon', 'Bruno', 'Chloe', 'Maxime', 'Laura', 'Vincent', 'Pauline', 'Alexandre', 'Audrey', 'Mathieu', 'Marion', 'Romain', 'Anais', 'Benjamin', 'Lucie', 'Anthony', 'Marine', 'Clement', 'Morgane', 'Florian', 'Justine', 'Lucas', 'Charlotte', 'Thomas', 'Mathilde', 'Kevin', 'Alice', 'Arnaud', 'Clemence', 'Adrien', 'Amandine', 'Alexis', 'Melanie', 'Hugo', 'Noemie', 'Fabien', 'Juliette', 'Ludovic', 'Elise', 'Paul', 'Coralie', 'Damien', 'Fanny'];

$data = [];
// Generate 100 rows
for ($i = 0; $i < 100; $i++) {
	$nom = $noms[array_rand($noms)];
	$prenom = $prenoms[array_rand($prenoms)];
	$points = rand(247, 329);
	$data[] = [
		'nom' => $nom,
		'prenom' => $prenom,
		'points' => $points
	];
}

// Sort by points desc
usort($data, function ($a, $b) {
	return $b['points'] <=> $a['points'];
});

// Calculate rank (Standard Competition Ranking: 1, 1, 1, 4...)
foreach ($data as $i => &$row) {
	if ($i > 0 && $row['points'] === $data[$i - 1]['points']) {
		// Same points as previous, same rank
		$row['ordre'] = $data[$i - 1]['ordre'];
	} else {
		// New points value, rank is position strictly (1-based index)
		$row['ordre'] = $i + 1;
	}

	$row['medaille'] = ($row['points'] > 279) ? 'or' : 'argent';
}
unset($row);

// Output CSV
$filename = 'pharmaciens_generated.csv';
$fp = fopen($filename, 'w');
// Write headers
fputcsv($fp, ['nom', 'prenom', 'points', 'ordre', 'medaille'], ',');

foreach ($data as $row) {
	fputcsv($fp, $row, ',');
}
fclose($fp);

echo "CSV Generated: " . realpath($filename);
