<?php
// Récupérer l'ID du club depuis les paramètres GET
$clubId = $_GET['clubId'];

// Définir l'URL de l'API
$url = "https://api.football-data.org/v2/teams/" . $clubId;

// Ajouter le token d'authentification dans les en-têtes de la requête
$headers = array(
    "X-Auth-Token: 1bf86dc9d65746149a26808fdc45a5a1"
);

// Initialiser une session cURL
$curl = curl_init();

// Configuration de la requête cURL
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headers
));

// Exécution de la requête cURL
$response = curl_exec($curl);

// Vérifier si la requête a réussi
if (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200) {
    // Envoyer la réponse JSON
    header('Content-Type: application/json');
    echo $response;
} else {
    // Envoyer une réponse d'erreur
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(array('error' => 'Erreur lors de la récupération des données des joueurs.'));
}

// Fermer la session cURL
curl_close($curl);
?>
