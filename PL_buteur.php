<?php
$api_url = 'https://api.football-data.org/v4/competitions/PL/scorers?season=2022';
$api_key = '1bf86dc9d65746149a26808fdc45a5a1';

$ch = curl_init($api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Auth-Token: ' . $api_key));

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Erreur lors de l\'appel à l\'API : ' . curl_error($ch);
} else {
    $data = json_decode($response, true);

    if (isset($data['scorers'])) {
        $scorers = $data['scorers'];

        echo '<h1>Top Buteurs de la Premier League 2022</h1>';
        echo '<table border="1">';
        echo '<tr><th>Nom du joueur</th><th>Équipe</th><th>Buts marqués</th><th>Assists</th><th>Penalties</th><th>Nationalité</th><th>Position</th><th>Site Web de l\'équipe</th></tr>';

        foreach ($scorers as $scorer) {
            echo '<tr>';
            echo '<td>' . $scorer['player']['name'] . '</td>';
            echo '<td>' . $scorer['team']['name'] . '</td>';
            echo '<td>' . $scorer['goals'] . '</td>';
            echo '<td>' . $scorer['assists'] . '</td>';
            echo '<td>' . $scorer['penalties'] . '</td>';
            echo '<td>' . $scorer['player']['nationality'] . '</td>';
            echo '<td>' . $scorer['player']['position'] . '</td>';
            echo '<td><a href="' . $scorer['team']['website'] . '" target="_blank">Site de l\'équipe</a></td>';
            echo '</tr>';
        }

        echo '</table>';
    } else {
        echo "Aucun buteur trouvé pour la saison 2022.";
    }
}

curl_close($ch);
?>
