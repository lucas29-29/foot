<!DOCTYPE html>
<html>
<head>
    <title>Clubs de la Liga</title>
    <style>
        /* Ajoutez votre CSS personnalisé ici */
        .club-button {
            margin: 5px;
        }

        .players-container {
            position: relative;
            height: 500px;
            border: 1px solid #ccc;
            margin-top: 20px;
            display: flex;
        }

        .player-card {
            position: absolute;
            cursor: move;
            padding: 5px;
            border: 1px solid #ccc;
            background-color: #eaeaea;
        }

        .image-container {
            flex: 1;
            text-align: right;
        }

        .terrain-image {
            max-height: calc(100% - 10px);
            margin-top: 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Clubs de la Liga</h1>

    <div>
        <?php
        // Définir l'URL de l'API
        $url = "https://api.football-data.org/v2/competitions/2014/teams";

        // Ajouter le token d'authentification dans les en-têtes de la requête
        $headers = array(
            "X-Auth-Token: 1bf86dc9d65746149a26808fdc45a5a1"
        );

        // Initialiser une session cURL
        $curl = curl_init();

        // Configuration de la requête cURL
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => $headers
        ));

        // Exécution de la requête cURL
        $response = curl_exec($curl);

        // Vérifier si la requête a réussi
        if (curl_getinfo($curl, CURLINFO_HTTP_CODE) === 200) {
            // Convertir la réponse JSON en tableau associatif
            $data = json_decode($response, true);

            // Afficher les clubs de la Liga
            echo "<div>";
            foreach ($data["teams"] as $team) {
                $club_name = $team["name"];
                $club_id = $team["id"];
                echo "<button class='club-button' onclick='showPlayers($club_id)'>$club_name</button>";
            }
            echo "</div>";
        } else {
            echo "Erreur lors de la récupération des clubs de la Liga.";
        }

        // Fermer la session cURL
        curl_close($curl);
        ?>
    </div>

    <div class="players-container" id="players-container"></div>
    <div class="image-container">
        <img src="images/terrain.png" alt="Terrain" class="terrain-image">
    </div>

    <script>
        function showPlayers(clubId) {
            var squadUrl = "https://api.football-data.org/v2/teams/" + clubId;

            // Ajouter les en-têtes CORS à la requête AJAX
            var headers = {
                "X-Auth-Token": "1bf86dc9d65746149a26808fdc45a5a1"
            };

            // Faire une requête AJAX à l'API
            $.ajax({
                url: squadUrl,
                headers: headers,
                dataType: "json",
                success: function(response) {
                    var squadData = response;
                    var playersContainer = document.getElementById("players-container");
                    playersContainer.innerHTML = "";
                    var topPosition = 10;
                    squadData.squad.forEach(function(player) {
                        var playerName = player.name;
                        var playerCard = document.createElement("div");
                        playerCard.className = "player-card";
                        playerCard.style.top = topPosition + "px";
                        playerCard.style.left = "10px";
                        playerCard.innerText = playerName;
                        playersContainer.appendChild(playerCard);
                        topPosition += 60; // Réduit l'écart entre les joueurs à 60 pixels
                    });

                    // Rendre les joueurs déplaçables
                    makePlayersDraggable();
                },
                error: function() {
                    console.log("Erreur lors de la récupération des joueurs du club.");
                }
            });
        }

        function makePlayersDraggable() {
            var players = document.getElementsByClassName("player-card");

            for (var i = 0; i < players.length; i++) {
                var player = players[i];
                dragElement(player);
            }

            function dragElement(element) {
                var pos1 = 0,
                    pos2 = 0,
                    pos3 = 0,
                    pos4 = 0;
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
        }
    </script>
</body>
</html>
