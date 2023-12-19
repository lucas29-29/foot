<!DOCTYPE html>
<html>
<head>
    <style>
    body {
        font-family: Arial, sans-serif;
        color: #000000;
        margin: 0;
        padding: 0;
        background: linear-gradient(45deg, #FFB6C1, #87CEFA);
    }

    .table-container {
        max-width: 1000px;
        margin: 20px auto;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #F5F5F5;
        border-radius: 10px;
        overflow: hidden;
    }

    .custom-table th,
    .custom-table td {
        padding: 10px;
        text-align: center;
        border: 1px solid #CCCCCC;
    }

    .custom-table th {
        background-color: #F9F9F9;
        font-weight: bold;
    }

    .custom-table tbody tr:nth-child(even) {
        background-color: #FFFFFF;
    }

    .custom-table img {
        vertical-align: middle;
        max-height: 30px;
        max-width: 30px;
    }

    .filter-container {
        text-align: center;
        margin-bottom: 20px;
    }

    .filter-container label {
        font-weight: bold;
    }

    .filter-container select {
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 5px;
        outline: none;
    }

    .filter-container button {
        padding: 5px 10px;
        font-size: 16px;
        border-radius: 5px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
        margin-left: 10px;
    }
</style>
</head>
<?php include 'menu.php'; ?>
<body>
<div class="table-container">
    <?php
    $token = '1bf86dc9d65746149a26808fdc45a5a1';
    $baseURL = 'https://api.football-data.org/v4/';
    $teamId = isset($_GET['teamId']) ? $_GET['teamId'] : '';

    if (empty($teamId)) {
        echo 'Identifiant d\'équipe manquant.';
        exit();
    }

    $endpoint = 'teams/' . $teamId . '/matches';

    // Construction de l'URL complète
    $url = $baseURL . $endpoint;

    // Configuration des options de requête
    $options = [
        'http' => [
            'header' => "X-Auth-Token: $token",
            'method' => 'GET'
        ]
    ];

    // Création du contexte de requête
    $context = stream_context_create($options);

    // Délai entre les appels à l'API (en secondes)
    $delay = 2;

    // Exécution de la requête et récupération de la réponse avec limitation du débit
    usleep($delay * 1000000);
    $response = file_get_contents($url, false, $context);

    // Vérification si la requête a réussi
    if ($response !== false) {
        $matchHistoryData = json_decode($response, true);

        // Récupération des informations sur les matchs de l'historique
        $matches = $matchHistoryData['matches'];

        // Récupération des compétitions
        $competitions = [];
        foreach ($matches as $match) {
            $competitionName = $match['competition']['name'];
            $competitionLogo = $match['competition']['emblem'];
            $competitions[$competitionName] = $competitionLogo;
        }

        // Affichage du filtre de compétitions
        echo '<div class="filter-container">';
        echo '<br>';
        echo '<label for="competition-filter">Filtrer par compétition:</label>';
        echo '<select id="competition-filter" onchange="filterTable(this.value)">';
        echo '<option value="">Toutes les compétitions</option>';
        foreach ($competitions as $competitionName => $competitionLogo) {
            echo '<option value="' . $competitionName . '">' . $competitionName . '</option>';
        }
        echo '</select>';
        echo '<button onclick="resetFilter()">Réinitialiser</button>';
        echo '</div>';

        // Affichage des détails des matchs
        echo '<table class="custom-table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Date</th>';
        echo '<th>Compétition</th>';
        echo '<th>Logo Compétition</th>';
        echo '<th>Adversaire</th>';
        echo '<th>Résultat</th>';
        echo '<th>Statut</th>';
        echo '<th>Journée</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        foreach ($matches as $match) {
            $date = $match['utcDate'];
            $competition = $match['competition']['name'];
            $competitionLogo = $match['competition']['emblem'];
            $status = $match['status'];
            $matchday = isset($match['matchday']) ? $match['matchday'] : '';

            // Informations sur les équipes
            $homeTeam = isset($match['homeTeam']) ? $match['homeTeam'] : null;
            $awayTeam = isset($match['awayTeam']) ? $match['awayTeam'] : null;

            // Résultat et score détaillé
            $result = '';
            if (isset($match['score']['fullTime']['home']) && isset($match['score']['fullTime']['away'])) {
                $homeTeamScore = $match['score']['fullTime']['home'];
                $awayTeamScore = $match['score']['fullTime']['away'];
                $result = $homeTeamScore . ' - ' . $awayTeamScore;
            }

            echo '<tr>';
            echo '<td>' . $date . '</td>';
            echo '<td>' . $competition . '</td>';
            echo '<td><img src="' . $competitionLogo . '" alt="' . $competition . ' Logo"></td>';
            echo '<td><img src="' . $homeTeam['crest'] . '" alt="' . $homeTeam['name'] . ' Logo"> VS <img src="' . $awayTeam['crest'] . '" alt="' . $awayTeam['name'] . ' Logo"></td>';
            echo '<td>' . $result . '</td>';
            echo '<td>' . $status . '</td>';
            echo '<td>' . $matchday . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
    } else {
        echo 'Erreur lors de la récupération de l\'historique des matchs.';
    }

    ?>

    <script>
        function filterTable(competition) {
            var rows = document.querySelectorAll('.custom-table tbody tr');
            for (var i = 0; i < rows.length; i++) {
                var competitionCell = rows[i].getElementsByTagName('td')[1];
                if (competition === '' || competitionCell.textContent === competition) {
                    rows[i].style.display = '';
                } else {
                    rows[i].style.display = 'none';
                }
            }
        }

        function resetFilter() {
            var select = document.getElementById('competition-filter');
            select.value = '';
            filterTable('');
        }
    </script>
</div>
</body>
</html>
