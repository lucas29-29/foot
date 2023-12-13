<?php

$token = '1bf86dc9d65746149a26808fdc45a5a1';
$baseURL = 'https://api.football-data.org/v4/';

// Array of leagues and their respective endpoints for the 2022 season
$leagues = [
    'Premier League' => 'competitions/PL/standings?season=2022',
    'La Liga' => 'competitions/PD/standings?season=2022',
    'Liga NOS' => 'competitions/PPL/standings?season=2022',
    'Ligue 1' => 'competitions/FL1/standings?season=2022',
    'Bundesliga' => 'competitions/BL1/standings?season=2022',
    'Serie A' => 'competitions/SA/standings?season=2022'
];

echo '<style>

hero {
        background-color: #0040C1;
        position: relative;
        height: 100vh;
        overflow: hidden;
        font-family: \'Montserrat\', sans-serif;
    }

    .hero__title {
        color: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 50px;
        z-index: 1;
    }

    .cube {
        position: absolute;
        top: 80vh;
        left: 45vw;
        width: 10px;
        height: 10px;
        border: solid 1px rgba(0, 64, 193, 0.92);
        transform-origin: top left;
        transform: scale(0) rotate(0deg) translate(-50%, -50%);
        animation: cube 12s ease-in forwards infinite;
    }

    .cube:nth-child(2n) {
        border-color: rgba(0, 64, 193, 0.82);
    }

    .cube:nth-child(2) {
        animation-delay: 2s;
        left: 25vw;
        top: 40vh;
    }

    .cube:nth-child(3) {
        animation-delay: 4s;
        left: 75vw;
        top: 50vh;
    }

    .cube:nth-child(4) {
        animation-delay: 6s;
        left: 90vw;
        top: 10vh;
    }

    .cube:nth-child(5) {
        animation-delay: 8s;
        left: 10vw;
        top: 85vh;
    }

    .cube:nth-child(6) {
        animation-delay: 10s;
        left: 50vw;
        top: 10vh;
    }

    @keyframes cube {
        from {
            transform: scale(0) rotate(0deg) translate(-50%, -50%);
            opacity: 1;
        }
        to {
            transform: scale(20) rotate(960deg) translate(-50%, -50%);
            opacity: 0;
        }
    }

    .standings-container {
        max-width: 1200px;
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
        padding: 10px;
        min-width: 200px;
        max-width: 400px;
    }
    /* Ajoutez ceci dans la section <style> */
    .league-title {
        text-align: center;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .league-title:hover {
        color: #ff0000; /* Changez cette valeur pour la couleur souhaitée lors du survol */
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
        min-width: 100px;
    }
</style>';

include 'menu.php';

echo '<div class="standings-container">';
foreach ($leagues as $league => $endpoint) {
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

    echo '<div class="standings-table">';
    echo '<h2 class="league-title">' . $league . '</h2>';
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Position</th>';
    echo '<th class="logo-cell">Logo</th>';
    echo '<th class="team-cell">Équipe</th>';
    echo '<th title="Matchs Joués">MJ</th>';
    echo '<th title="Points">Pts</th>';
    echo '<th title="Victoires">V</th>';
    echo '<th title="Nuls">N</th>';
    echo '<th title="Défaites">D</th>';
    echo '<th title="Buts marqués">BM</th>';
    echo '<th title="Buts encaissés">BE</th>';
    echo '<th title="Différence de buts">Diff</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($standings as $index => $team) {
    $position = $index + 1;
    $logo = isset($team['team']['crest']) ? $team['team']['crest'] : ''; // Check if crest key exists
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
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
echo '</div>';

?>
<?php

$token = '1bf86dc9d65746149a26808fdc45a5a1';
$baseURL = 'https://api.football-data.org/v4/';

// Array of leagues and their respective endpoints for the 2022 season
$leagues = [
    'Premier League' => 'competitions/PL/standings?season=2022',
    'La Liga' => 'competitions/PD/standings?season=2022',
    'Liga NOS' => 'competitions/PPL/standings?season=2022',
    'Ligue 1' => 'competitions/FL1/standings?season=2022',
    'Bundesliga' => 'competitions/BL1/standings?season=2022',
    'Serie A' => 'competitions/SA/standings?season=2022'
];

echo '<style>

hero {
        background-color: #0040C1;
        position: relative;
        height: 100vh;
        overflow: hidden;
        font-family: \'Montserrat\', sans-serif;
    }

    .hero__title {
        color: #fff;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 50px;
        z-index: 1;
    }

    .cube {
        position: absolute;
        top: 80vh;
        left: 45vw;
        width: 10px;
        height: 10px;
        border: solid 1px rgba(0, 64, 193, 0.92);
        transform-origin: top left;
        transform: scale(0) rotate(0deg) translate(-50%, -50%);
        animation: cube 12s ease-in forwards infinite;
    }

    .cube:nth-child(2n) {
        border-color: rgba(0, 64, 193, 0.82);
    }

    .cube:nth-child(2) {
        animation-delay: 2s;
        left: 25vw;
        top: 40vh;
    }

    .cube:nth-child(3) {
        animation-delay: 4s;
        left: 75vw;
        top: 50vh;
    }

    .cube:nth-child(4) {
        animation-delay: 6s;
        left: 90vw;
        top: 10vh;
    }

    .cube:nth-child(5) {
        animation-delay: 8s;
        left: 10vw;
        top: 85vh;
    }

    .cube:nth-child(6) {
        animation-delay: 10s;
        left: 50vw;
        top: 10vh;
    }

    @keyframes cube {
        from {
            transform: scale(0) rotate(0deg) translate(-50%, -50%);
            opacity: 1;
        }
        to {
            transform: scale(20) rotate(960deg) translate(-50%, -50%);
            opacity: 0;
        }
    }

    .standings-container {
        max-width: 1200px;
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
        padding: 10px;
        min-width: 200px;
        max-width: 400px;
    }
    /* Ajoutez ceci dans la section <style> */
    .league-title {
        text-align: center;
        transition: color 0.3s ease;
        cursor: pointer;
    }

    .league-title:hover {
        color: #ff0000; /* Changez cette valeur pour la couleur souhaitée lors du survol */
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
        min-width: 100px;
    }
</style>';

include 'menu.php';

echo '<div class="standings-container">';
foreach ($leagues as $league => $endpoint) {
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

    echo '<div class="standings-table">';
    echo '<h2 class="league-title">' . $league . '</h2>';
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Position</th>';
    echo '<th class="logo-cell">Logo</th>';
    echo '<th class="team-cell">Équipe</th>';
    echo '<th title="Matchs Joués">MJ</th>';
    echo '<th title="Points">Pts</th>';
    echo '<th title="Victoires">V</th>';
    echo '<th title="Nuls">N</th>';
    echo '<th title="Défaites">D</th>';
    echo '<th title="Buts marqués">BM</th>';
    echo '<th title="Buts encaissés">BE</th>';
    echo '<th title="Différence de buts">Diff</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    foreach ($standings as $index => $team) {
    $position = $index + 1;
    $logo = isset($team['team']['crest']) ? $team['team']['crest'] : ''; // Check if crest key exists
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
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
    echo '</div>';
}
echo '</div>';

?>
