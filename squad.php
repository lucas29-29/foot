<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Effectif de l'équipe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f1f1f1;
            background-image: linear-gradient(45deg, #6F80E8, #6F80E8, #F93222);
            background-size: 400% 400%;
            animation: gradientAnimation 10s ease infinite;
        }

        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        h2, h3 {
            text-align: center;
            text-transform: uppercase;
            font-weight: bold;
            color: #333;
        }

        .logo {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .logo img {
            max-height: 200px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
            color: #333;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-transform: uppercase;
        }

        .info-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .info-container p {
            margin: 0;
            color: #555;
        }

        .info-container .left-info {
            text-align: left;
        }

        .effectif {
            margin-top: 40px;
        }
    </style>
</head>
<body>
  <?php include 'menu.php'; ?>
  <br>
    <?php
    // Vérifier si le paramètre teamId est présent dans l'URL
    if (isset($_GET['teamId'])) {
        $teamId = $_GET['teamId'];

        // Utiliser l'API pour obtenir les détails de l'équipe
        $token = '1bf86dc9d65746149a26808fdc45a5a1';
        $baseURL = 'https://api.football-data.org/v4/';
        $endpoint = 'teams/' . $teamId;

        // Construction de l'URL complète
        $url = $baseURL . $endpoint;

        // Configuration des options de la requête
        $options = [
            'http' => [
                'header' => "X-Auth-Token: $token",
                'method' => 'GET'
            ]
        ];

        // Création du contexte de requête
        $context = stream_context_create($options);

        // Exécution de la requête et récupération de la réponse
        $response = file_get_contents($url, false, $context);

        // Vérification si la requête a réussi
        if ($response === false) {
            die('Erreur lors de la requête API.');
        }

        // Traitement de la réponse
        $teamData = json_decode($response, true);

        // Vérifier si les données de l'équipe ont été récupérées avec succès
        if (isset($teamData['squad'])) {
            $squad = $teamData['squad'];

            echo '<div class="container">';

            echo '<div class="info-container">
                <div class="left-info">
                    <h2>' . $teamData['name'] . '</h2>
                    <p>Stade: ' . $teamData['venue'] . '</p>
                    <p>Fondé en ' . $teamData['founded'] . '</p>
                    <h3>Entraîneur</h3>
                    <p>' . $teamData['coach']['name'] . ' (' . $teamData['coach']['nationality'] . ')</p>
                </div>
                <div class="logo">
                    <img src="' . $teamData['crest'] . '" alt="Logo">
                </div>
            </div>';

            echo '<hr>';

            // Affichage des détails de l'effectif de l'équipe
            echo '<div class="effectif">';
            echo '<h3>Effectif de ' . $teamData['name'] . '</h3>';
            echo '<table>';
            echo '<tr><th>Joueur</th><th>Poste</th><th>Nationalité</th><th>Date de naissance</th><th>Âge</th></tr>';

            foreach ($squad as $player) {
                $id = $player['id'];
                $name = $player['name'];
                $position = $player['position'];
                $nationality = $player['nationality'];
                $dateOfBirth = $player['dateOfBirth'];
                $age = date_diff(date_create($dateOfBirth), date_create('today'))->y;

                // Récupérer la valeur marchande du joueur s'il est disponible


                // Créer un lien vers player.php avec l'ID du joueur en tant que paramètre
                echo '<tr>';

                echo '<td>' . $name . '</a></td>';
                echo '<td>' . $position . '</td>';
                echo '<td>' . $nationality . '</td>';
                echo '<td>' . $dateOfBirth . '</td>';
                echo '<td>' . $age . '</td>';

                echo '</tr>';
            }

            echo '</table>';
            echo '</div>';

            echo '</div>';
        } else {
            echo 'Aucune donnée d\'effectif disponible pour cette équipe.';
        }
    } else {
        echo 'Aucun identifiant d\'équipe fourni.';
    }
    ?>
</body>
</html>
