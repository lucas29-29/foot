<?php
$api_url = 'http://api.football-data.org/v4/persons/44/matches';
$api_key = '1bf86dc9d65746149a26808fdc45a5a1'; // Remplacez par votre propre jeton d'API

$curl = curl_init();

curl_setopt($curl, CURLOPT_URL, $api_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'X-Unfold-Goals: true',
    'Authorization: Bearer ' . $api_key
));

$response = curl_exec($curl);

if (curl_errno($curl)) {
    echo 'Erreur cURL : ' . curl_error($curl);
}

curl_close($curl);

// Afficher la réponse (peut être traitée ou analysée selon les besoins)
echo $response;
?>
