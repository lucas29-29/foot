<!DOCTYPE html>
<html>
<head>
    <title>Effectif du club</title>
    <style>
        /* Ajoutez votre CSS personnalisé ici */
        .player-card {
            margin: 5px;
            padding: 5px;
            border: 1px solid #ccc;
            background-color: #eaeaea;
            position: absolute;
            cursor: move;
        }
    </style>
</head>
<body>
    <h1>Effectif du club</h1>

    <?php
    if (isset($_GET['clubId'])) {
        $clubId = $_GET['clubId'];

        // Utilisez l'API Football Data pour obtenir les données des joueurs pour le club spécifié
        $url = "https://api.football-data.org/v2/teams/" . $clubId;
        $headers = array(
            "X-Auth-Token: 1bf86dc9d65746149a26808fdc45a5a1"
        );

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ));
        $response = curl_exec($curl);
        $data = json_decode($response, true);

        // Vérifiez si la requête a réussi et si des joueurs ont été trouvés
        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200 && isset($data['squad']) && count($data['squad']) > 0) {
            $players = $data['squad'];

            // Afficher les joueurs du club
            foreach ($players as $player) {
                $playerName = $player['name'];
                echo "<div class='player-card' style='top: 10px; left: 10px;'>$playerName</div>";
            }
        } else {
            echo "Aucun joueur trouvé pour ce club.";
        }

        curl_close($curl);
    } else {
        echo "Paramètre de club manquant.";
    }
    ?>

    <script>
        var players = document.getElementsByClassName('player-card');

        for (var i = 0; i < players.length; i++) {
            var player = players[i];
            dragElement(player);
        }

        function dragElement(element) {
            var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
            element.onmousedown = dragMouseDown;

            function dragMouseDown(e) {
                e = e || window.event;
                e.preventDefault();
                pos3 = e.clientX;
                pos4 = e.clientY;
                document.onmouseup = closeDragElement;
                document.onmousemove = elementDrag;
            }

            function elementDrag(e) {
                e = e || window.event;
                e.preventDefault();
                pos1 = pos3 - e.clientX;
                pos2 = pos4 - e.clientY;
                pos3 = e.clientX;
                pos4 = e.clientY;
                element.style.top = (element.offsetTop - pos2) + "px";
                element.style.left = (element.offsetLeft - pos1) + "px";
            }

            function closeDragElement() {
                document.onmouseup = null;
                document.onmousemove = null;
            }
        }
    </script>
</body>
</html>
