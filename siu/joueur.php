<?php
// Configuration des en-têtes avec votre clé d'API
$headers = [
    'X-Auth-Token: 1bf86dc9d65746149a26808fdc45a5a1' // Remplacez cette clé par la vôtre
];

// Fonction pour effectuer une requête à l'API pour un ID donné
function fetchTeamData($teamId, $headers) {
    $url = 'http://api.football-data.org/v4/teams/' . $teamId;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);

    if ($response === false) {
        return false; // Erreur cURL
    }

    curl_close($ch);

    $teamData = json_decode($response, true);

    return $teamData;
}

// Boucle pour rechercher les IDs d'équipes de 1 à 1000
for ($teamId = 1; $teamId <= 10; $teamId++) {
    $teamData = fetchTeamData($teamId, $headers);

    if ($teamData !== false && isset($teamData['name'])) {
        echo 'ID : ' . $teamId . ', Nom de l\'équipe : ' . $teamData['name'] . '<br>';
    }
}
?>
