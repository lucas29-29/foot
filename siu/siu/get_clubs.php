<?php
// Définir l'URL de l'API pour récupérer les données des compétitions
$url = "https://api.football-data.org/v2/competitions";

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
    // Convertir la réponse JSON en tableau associatif
    $data = json_decode($response, true);

    // Récupérer les clubs de la Liga
    $clubs = array();
    foreach ($data["competitions"] as $competition) {
        if ($competition["name"] === "La Liga") {
            $clubs = $competition["teams"];
            break;
        }
    }

    // Envoyer la réponse JSON avec les clubs de la Liga
    header('Content-Type: application/json');
    echo json_encode($clubs);
} else {
    // Envoyer une réponse d'erreur
    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode(array('error' => 'Erreur lors de la récupération des clubs de la Liga.'));
}

// Fermer la session cURL
curl_close($curl);
?>
