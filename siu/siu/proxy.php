<?php
// Récupérer l'URL de l'API depuis les paramètres GET
$url = $_GET['url'];

// Initialiser une session cURL
$curl = curl_init();

// Configuration de la requête cURL
curl_setopt_array($curl, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true
));

// Exécution de la requête cURL
$response = curl_exec($curl);

// Vérifier si la requête a réussi
if (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200) {
    // Envoyer les données de réponse
    echo $response;
} else {
    // Envoyer un message d'erreur
    echo "Erreur lors de la récupération des données de l'API.";
}

// Fermer la session cURL
curl_close($curl);
?>
