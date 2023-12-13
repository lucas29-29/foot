<?php
$token = '1bf86dc9d65746149a26808fdc45a5a1';
$baseURL = 'https://api.football-data.org/v4/';

  $league = 'Liga Nos';
$endpoint = 'competitions/PPL/standings?season=2023';

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

echo '
<style>
    body {
        background-color: #f2f2f2;
        background-image: linear-gradient(45deg, #4158d0, #c850c0, #ffcc70);
        background-size: 400% 400%;
        animation: gradientBackground 10s ease infinite;
    }

    @keyframes gradientBackground {
        0% {
            background-position: 0% 50%;
        }
        50% {
            background-position: 100% 50%;
        }
        100% {
            background-position: 0% 50%;
        }
    }

    .standings-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 20px;
    }

    .standings-table {
        margin-bottom: 30px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        overflow: auto;
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
        padding: 8px;
        min-width: 120px;
        max-width: 200px;
    }

    .league-title {
        text-align: center;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .league-title:hover {
        color: #ff0000;
    }

    .standings-table .position-cell,
    .standings-table .played-games-cell,
    .standings-table .points-cell,
    .standings-table .wins-cell,
    .standings-table .draws-cell,
    .standings-table .losses-cell,
    .standings-table .goals-for-cell,
    .standings-table .goals-against-cell,
    .standings-table .goal-difference-cell {
        font-weight: bold;
        min-width: 50px;
    }

    .squad-modal {
        display: none;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .squad-modal-content {
        background-color: #fefefe;
        margin: 10% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 80%;
        max-width: 600px;
        border-radius: 8px;
    }

    .squad-modal-content h3 {
        margin-top: 0;
    }

    .squad-modal-content ul {
        padding-left: 20px;
    }

    .squad-modal-close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .squad-modal-close:hover,
    .squad-modal-close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .button-effectif {
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        background-color: #222CF9;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-effectif:hover {
        background-color: #366ec6;
    }

    .button-historique {
        padding: 6px 12px;
        font-size: 12px;
        border: none;
        background-color: #222CF9;
        color: #fff;
        border-radius: 4px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .button-historique:hover {
        background-color: #366ec6;
    }
</style>';

include 'menu.php';

echo '
<div class="standings-container">
    <div class="standings-table">
        <h2 class="league-title">' . $league . '</h2>
        <table>
            <thead>
                <tr>
                    <th>Position</th>
                    <th class="logo-cell">Logo</th>
                    <th class="team-cell">Équipe</th>
                    <th title="Matchs Joués">MJ</th>
                    <th title="Points">Pts</th>
                    <th title="Victoires">V</th>
                    <th title="Nuls">N</th>
                    <th title="Défaites">D</th>
                    <th title="Buts marqués">BM</th>
                    <th title="Buts encaissés">BE</th>
                    <th title="Différence de buts">Diff</th>
                    <th>Effectif</th>
                    <th>Historique</th>
                </tr>
            </thead>
            <tbody>';

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
    echo '<td><button class="button-historique" onclick="showMatchHistory(' . $teamId . ')">Historique</button></td>';
    echo '</tr>';
}

echo '</tbody>';
echo '</table>';
echo '</div>';
echo '</div>';

?>

<script>
    function showSquadModal(teamId) {
        // Redirect to the squad page for the selected team
        window.location.href = 'squad.php?teamId=' + teamId;
    }

    function showMatchHistory(teamId) {
        // Redirect to the match history page for the selected team
        window.location.href = 'historique_matchs.php?teamId=' + teamId;
    }
</script>
