<?php
// URL de l'API
$api_url = 'http://api.football-data.org/v4/persons/44';

// Clé d'accès à l'API (remplacez '1bf86dc9d65746149a26808fdc45a5a1' par votre clé réelle)
$api_key = '1bf86dc9d65746149a26808fdc45a5a1';

// Configuration de la requête HTTP
$options = [
    'http' => [
        'header' => "X-Auth-Token: $api_key",
    ],
];

// Créez un context HTTP
$context = stream_context_create($options);

// Effectuez la requête HTTP GET à l'API
$response = file_get_contents($api_url, false, $context);

// Vérifiez si la requête a réussi
if ($response === FALSE) {
    die('Échec de la requête à l\'API.');
}

// Décodez la réponse JSON en un tableau associatif
$data = json_decode($response, true);

// Vérifiez si la décodage JSON a réussi
if ($data === null) {
    die('Impossible de décoder la réponse JSON.');
}

// Maintenant, vous pouvez accéder aux données du joueur
echo 'Nom complet : ' . $data['name'] . ' ' . $data['lastName'] . '<br>';
echo 'Date de naissance : ' . $data['dateOfBirth'] . '<br>';
echo 'Nationalité : ' . $data['nationality'] . '<br>';
echo 'Poste : ' . $data['position'] . '<br>';
echo 'Numéro de maillot : ' . $data['shirtNumber'] . '<br>';
echo 'Équipe actuelle : ' . $data['currentTeam']['name'] . '<br>';
echo 'Contrat jusqu au : ' . $data['currentTeam']['contract']['until'] . '<br>';

// Vous pouvez accéder à d'autres données de la même manière

?>
