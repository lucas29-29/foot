<?php

$token = '1bf86dc9d65746149a26808fdc45a5a1';
$baseURL = 'https://api.football-data.org/v4/';

$league = 'Liga';
$selectedYear = isset($_GET['year']) ? $_GET['year'] : date('Y'); // Default to the current year if not specified
$endpoint = "competitions/PD/standings?season={$selectedYear}";

// Construction of the complete URL
$url = $baseURL . $endpoint;

// Configuration of the request options
$options = [
    'http' => [
        'header' => "X-Auth-Token: $token",
        'method' => 'GET'
    ]
];

// Creation of the request context
$context = stream_context_create($options);

// Delay between API calls (in seconds)
$delay = 2;

// Execution of the request and retrieval of the response with rate limiting
usleep($delay * 1000000);
$response = file_get_contents($url, false, $context);

// Verification if the request was successful
if ($response === false) {
    die('Error while making the API request.');
}

// Processing the response
$data = json_decode($response, true);

// Retrieving the information about the teams
$standings = $data['standings'][0]['table'];

// Sorting the teams by points
usort($standings, function ($a, $b) {
    return $b['points'] - $a['points'];
});
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Classement <?php echo $league; ?></title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        color: #000000;
        margin: 0;
        padding: 0;
        background: linear-gradient(45deg, #FFB6C1, #87CEFA);
    }


        .standings-container {
            max-width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .year-filter-form {
            margin-bottom: 20px;
        }

        .buttons-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .button-effectif,
        .button-graphe,
        .button-historique {
            padding: 10px 8px;
            font-size: 16px;
            border: none;
            background-color: #4287f5;
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .button-effectif:hover,
        .button-graphe:hover,
        .button-historique:hover {
            background-color: #2a5cbf;
        }

        .standings-table {
            margin-bottom: 30px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: auto;
            max-width: 100%;
        }

        .standings-table h2 {
            margin: 0;
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            text-transform: uppercase;
            background-color: #f2f2f2;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .standings-table table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .standings-table th,
        .standings-table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .standings-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .standings-table tr.champion {
            background-color: #4287f5;
            color: #fff;
        }

        .standings-table tr.champions-league {
            background-color: #a0d468;
        }

        .standings-table tr.europa-league {
            background-color: #5cb85c;
        }

        .standings-table tr.europa-conference {
            background-color: #f9a752;
        }

        .standings-table tr.relegation {
            background-color: #ff4d4d;
            color: #fff;
        }

        .standings-table .logo-cell {
            width: 60px;
        }

        .standings-table .team-cell {
            text-align: left;
            font-weight: bold;
            white-space: normal;
            padding: 10px;
            min-width: 200px;
            max-width: 400px;
        }

        .chart-container {
            max-width: 800px;
            margin: 20px auto;
        }
    </style>
</head>

<body>
    <?php include 'menu.php'; ?>
    <div class="standings-container">
        <form action="" method="get" class="year-filter-form">
            <div class="form-group">
              <label for="year">Sélectionnez une année :</label>

                <select name="year" id="year" class="form-control" onchange="this.form.submit()">
                    <option value="2023" <?php echo ($selectedYear == '2023' ? 'selected' : ''); ?>>2023-2024</option>
                    <option value="2022" <?php echo ($selectedYear == '2022' ? 'selected' : ''); ?>>2022-2023</option>
                    <option value="2021" <?php echo ($selectedYear == '2021' ? 'selected' : ''); ?>>2021-2022</option>
                    <option value="2020" <?php echo ($selectedYear == '2020' ? 'selected' : ''); ?>>2020-2021</option>
                    <!-- Ajoutez les autres années au besoin -->
                </select>
            </div>
        </form>
        <div class="buttons-container">

            <button class="button-effectif" onclick="showStandings()">Classement</button>
            <button class="button-graphe" onclick="showGraph()">Graphe</button>
        </div>
        <div id="standings-table" class="standings-table">
              <center>  <h2 class="league-title"><?php echo $league; ?></h2>  </center>
            <table>
                <thead>
                    <tr>
                        <th>Position</th>
                        <th>Logo</th>
                        <th>Équipe</th>
                        <th>MJ</th>
                        <th>Pts</th>
                        <th>V</th>
                        <th>N</th>
                        <th>D</th>
                        <th>BM</th>
                        <th>BE</th>
                        <th>Diff</th>
                        <th>Effectif</th>
                        <th>Graphe</th>
                        <th>Historique</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($standings as $index => $team) {
                        $position = $index + 1;
                        $teamId = $team['team']['id'];
                        $logo = isset($team['team']['crest']) ? $team['team']['crest'] : '';
                        $name = isset($team['team']['shortName']) ? $team['team']['shortName'] : $team['team']['name'];
                        $playedGames = $team['playedGames'];
                        $points = $team['points'];
                        $wins = $team['won'];
                        $draws = $team['draw'];
                        $losses = $team['lost'];
                        $goalsFor = $team['goalsFor'];
                        $goalsAgainst = $team['goalsAgainst'];
                        $goalDifference = $team['goalDifference'];

                        $rowClass = '';
                        if ($position === 1) {
                            $rowClass = 'champion';
                        } elseif ($position <= 4) {
                            $rowClass = 'champions-league';
                        } elseif ($position <= 6) {
                            $rowClass = 'europa-league';
                        } elseif ($position <= 16) {
                            $rowClass = 'europa-conference';
                        } else {
                            $rowClass = 'relegation';
                        }

                        echo '<tr class="' . $rowClass . '">';
                        echo '<td class="position-cell">' . $position . '</td>';
                        echo '<td class="logo-cell"><img src="' . $logo . '" alt="Logo" height="30"></td>';
                        echo '<td class="team-cell">' . $name . '</td>';
                        echo '<td class="played-games-cell">' . $playedGames . '</td>';
                        echo '<td class="points-cell">' . $points . '</td>';
                        echo '<td class="wins-cell">' . $wins . '</td>';
                        echo '<td class="draws-cell">' . $draws . '</td>';
                        echo '<td class="losses-cell">' . $losses . '</td>';
                        echo '<td class="goals-for-cell">' . $goalsFor . '</td>';
                        echo '<td class="goals-against-cell">' . $goalsAgainst . '</td>';
                        echo '<td class="goal-difference-cell">' . $goalDifference . '</td>';
                        echo '<td><button class="button-effectif" onclick="showSquadModal(' . $teamId . ')">Effectif</button></td>';
                        echo '<td><button class="button-graphe" onclick="showGraphModal(' . $teamId . ',' . $wins . ',' . $losses . ',' . $draws . ',' . $goalsFor . ',' . $goalsAgainst . ',' . $goalDifference . ',' . $playedGames . ',\'' . $name . '\',\'' . $logo . '\')">Graphe</button></td>';
                        echo '<td><button class="button-effectif" onclick="showHistoriqueModal(' . $teamId . ')">Historique</button></td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Chart.js script for displaying a simple bar chart -->
        <div id="chart-container" class="chart-container" style="display: none;">
            <canvas id="league-chart"></canvas>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            function showSquadModal(teamId) {
                // Redirect to the squad page for the selected team
                window.location.href = "squad.php?teamId=" + teamId;
            }

            function showGraphModal(teamId, wins, losses, draws, goalsFor, goalsAgainst, goalDifference, playedGames, teamName, teamLogo) {
    // Redirect to the graph page with all team statistics
    window.location.href = "graphe.php?teamId=" + teamId +
        "&wins=" + wins +
        "&losses=" + losses +
        "&draws=" + draws +
        "&goalsFor=" + goalsFor +
        "&goalsAgainst=" + goalsAgainst +
        "&goalDifference=" + goalDifference +
        "&playedGames=" + playedGames +
        "&name=" + encodeURIComponent(teamName) +
        "&logo=" + encodeURIComponent(teamLogo);
}

            function showHistoriqueModal(teamId) {
                // Redirect to the historique page for the selected team
                window.location.href = "historique_matchs.php?teamId=" + teamId;
            }

            function showStandings() {
                document.getElementById("standings-table").style.display = "block";
                document.getElementById("chart-container").style.display = "none";
            }

            function showGraph() {
                document.getElementById("standings-table").style.display = "none";
                document.getElementById("chart-container").style.display = "block";
                renderChart();
            }

            function renderChart() {
                var teams = <?php echo json_encode(array_column($standings, 'team'), JSON_UNESCAPED_UNICODE); ?>;
                var points = <?php echo json_encode(array_column($standings, 'points')); ?>;

                // Extraction des noms d'équipe
                var teamNames = teams.map(function (team) {
                    return team.name;
                });

                var ctx = document.getElementById("league-chart").getContext("2d");
                var myChart = new Chart(ctx, {
      type: "bar",
      data: {
          labels: teamNames,
          datasets: [{
              label: "Points",
              data: points,
              backgroundColor: "#4287f5",
          }]
      },
      options: {
          scales: {
              y: {
                  beginAtZero: true
              },
              x: {
                  ticks: {
                      font: {
                          weight: 'bold' // Mettre en gras le texte des labels sur l'axe X
                      }
                  }
              }
          }
      }
  });

            }
        </script>
    </div>
</body>

</html>
