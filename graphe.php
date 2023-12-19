<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques de l'Équipe</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
    body {
font-family: Arial, sans-serif;
margin: 0;
padding: 0;
animation: changeBackgroundColor 5s infinite alternate;
}

@keyframes changeBackgroundColor {
0% {
    background-color: #000; /* Noir */
}
100% {
    background-color: #00f; /* Bleu */
}
0% {
    background-color: #00f; /* Bleu */
}
100% {
    background-color: #000; /* Noir */
}
}


        #container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        canvas {
            max-width: 100%;
            width: 1200px;
            height: auto;
            display: block;
            margin: 20px auto;
        }
    </style>
</head>
<body>
  <?php include 'menu.php'; ?>
  <br>
<?php
// Récupération des paramètres depuis l'URL
$teamId = isset($_GET['teamId']) ? $_GET['teamId'] : null;
$wins = isset($_GET['wins']) ? $_GET['wins'] : null;
$losses = isset($_GET['losses']) ? $_GET['losses'] : null;
$draws = isset($_GET['draws']) ? $_GET['draws'] : null;
$goalsFor = isset($_GET['goalsFor']) ? $_GET['goalsFor'] : null;
$goalsAgainst = isset($_GET['goalsAgainst']) ? $_GET['goalsAgainst'] : null;
$goalDifference = isset($_GET['goalDifference']) ? $_GET['goalDifference'] : null;
$playedGames = isset($_GET['playedGames']) ? $_GET['playedGames'] : null;
$name = isset($_GET['name']) ? $_GET['name'] : null;
$logo = isset($_GET['logo']) ? $_GET['logo'] : null;

// Vérification des paramètres
if ($logo !== null && $name !== null && $playedGames !== null && $wins !== null && $losses !== null && $draws !== null && $goalsFor !== null && $goalsAgainst !== null && $goalDifference !== null) {
    ?>
    <div id="container">
        <h1>Statistiques de l'Équipe - <?php echo $name; ?> <img src="<?php echo $logo; ?>" alt="Logo" height="70"></h1>

        <table>
            <tr>
                <th>Statistique</th>
                <th>Valeur</th>
            </tr>
            <tr>
                <td>Nombre de matchs joués</td>
                <td><?= htmlspecialchars($playedGames, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td>Nombre de victoires</td>
                <td><?= htmlspecialchars($wins, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td>Nombre de défaites</td>
                <td><?= htmlspecialchars($losses, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td>Nombre de matchs nuls</td>
                <td><?= htmlspecialchars($draws, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td>Buts marqués</td>
                <td><?= htmlspecialchars($goalsFor, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td>Buts encaissés</td>
                <td><?= htmlspecialchars($goalsAgainst, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td>Différence de buts</td>
                <td><?= htmlspecialchars($goalDifference, ENT_QUOTES, 'UTF-8') ?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <!-- Graphique en radar -->
                    <canvas id="team-radar-chart"></canvas>
                    <script>
    var ctx = document.getElementById("team-radar-chart").getContext("2d");
    var myChart = new Chart(ctx, {
        type: "radar",
        data: {
            labels: ["Victoires", "Défaites", "Matchs nuls", "Buts marqués", "Buts encaissés", "Différence de buts"],
            datasets: [{
                label: "Statistiques de l'Équipe",
                data: [<?= $wins ?>, <?= $losses ?>, <?= $draws ?>, <?= $goalsFor ?>, <?= $goalsAgainst ?>, <?= $goalDifference ?>],
                backgroundColor: "rgba(75, 192, 192, 0.2)",
                borderColor: "rgba(75, 192, 192, 1)",
                borderWidth: 2
            }]
        },
        options: {
            scales: {
                r: {
                    suggestedMin: 0,
                    suggestedMax: 50,
                    pointLabels: {
                        font: {
                            weight: 'bold' // Met en gras le texte des éléments du graphique
                        }
                    }
                }
            }
        }
    });

    // Ajout du nom de l'équipe à la fonction showGraphModal
    function showGraphModal(teamId, wins, losses, draws, goalsFor, goalsAgainst, goalDifference, playedGames, teamName) {
        // Redirect to the graph page with all team statistics
        window.location.href = "graphe.php?teamId=" + teamId +
            "&wins=" + wins +
            "&losses=" + losses +
            "&draws=" + draws +
            "&goalsFor=" + goalsFor +
            "&goalsAgainst=" + goalsAgainst +
            "&goalDifference=" + goalDifference +
            "&playedGames=" + playedGames +
            "&name=" + encodeURIComponent(teamName);
    }
</script>

                </td>
            </tr>
        </table>
    </div>
    <?php
} else {
    echo '<p>Paramètres invalides. Veuillez vérifier les données fournies.</p>';
}
?>
</body>
</html>
