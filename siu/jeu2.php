<!DOCTYPE html>
<html>
<head>
    <title>Filtre des clubs de la Liga</title>
    <style>
        /* Styles CSS pour la barre de filtres */

        .filter-bar {
            padding: 10px;
            background-color: #f0f0f0;
        }

        .filter-bar select, .filter-bar button {
            padding: 5px;
            font-size: 16px;
        }

        .filter-bar button {
            margin-left: 10px;
        }

        .selected-club {
            background-color: yellow;
        }

        /* Styles CSS pour la liste des joueurs */
        .players-container {
            display: flex;
            justify-content: space-between;
        }

        .players-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .player-item {
            margin-bottom: 10px;
            cursor: move;
            background-color: #f0f0f0;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 120px;
            position: relative;
        }

        .player-item::after {
            content: "";
            position: absolute;
            top: 0;
            right: -5px;
            width: 5px;
            height: 100%;
            background-color: blue;
        }

        /* Styles CSS pour l'effet de déplacement des joueurs */
        .dragging {
            opacity: 0.5;
            transform: scale(1.2);
        }

        /* Styles CSS pour la zone de l'image */
        .image-zone {
            position: relative;
            width: 800px;
            height: 600px;
            border: 1px solid #ccc;
            background-image: url('images/terrain.png');
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            margin-top: 10px;
        }

        /* Styles CSS pour les cases des joueurs */
        .player-box {
            position: absolute;
            background-color: #f0f0f0;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: move;
            width: 120px;
            z-index: 100;
        }

        /* Styles CSS pour la croix rouge */
        .delete-cross {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 15px;
            height: 15px;
            background-color: red;
            border-radius: 50%;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
    </style>
</head>
<?php include 'menu.php'; ?>
<body>
    <div class="filter-bar">
        <label for="club-select">Sélectionner un club :</label>
        <select id="club-select">
            <option value="">Tous les clubs</option>
            <?php
            // Votre token d'accès
            $token = '1bf86dc9d65746149a26808fdc45a5a1';

            // Récupérer la liste des clubs de la Liga
            $url = 'https://api.football-data.org/v2/competitions/PD/teams';
            $options = array(
                'http' => array(
                    'header'  => "X-Auth-Token: $token"
                )
            );
            $context = stream_context_create($options);
            $response = file_get_contents($url, false, $context);
            $data = json_decode($response, true);

            // Vérifier si la requête a réussi
            if ($data && isset($data['teams'])) {
                $clubs = $data['teams'];

                foreach ($clubs as $club) {
                    echo '<option value="' . $club['id'] . '">' . $club['name'] . '</option>';
                }
            } else {
                echo '<option value="">Aucun club trouvé</option>';
            }
            ?>
        </select>
    </div>

    <div class="players-container">
        <ul class="players-list" id="players-list">
            <!-- Les joueurs seront affichés ici -->
        </ul>

        <div class="image-zone" id="image-zone">
            <!-- Les joueurs seront affichés ici -->
        </div>


    </div>

    <script>
        var selectedClub = "";

        // Fonction pour effectuer une requête à l'API pour obtenir l'effectif de l'équipe sélectionnée
        function obtenirEffectif(clubId) {
            // Votre token d'accès
            var token = "1bf86dc9d65746149a26808fdc45a5a1";

            // URL de base de l'API
            var url = "https://api.football-data.org/v2/";

            // Endpoint pour obtenir l'effectif de l'équipe
            var endpoint = "teams/" + clubId;

            // Construction de l'URL de la requête avec l'ID du club
            var requeteUrl = url + endpoint;

            // Configuration de la requête AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("GET", requeteUrl, true);
            xhr.setRequestHeader("X-Auth-Token", token);

            // Gestion de la réponse
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var reponse = JSON.parse(xhr.responseText);
                    afficherEffectif(reponse);
                } else {
                    console.error("Erreur lors de la requête : " + xhr.status);
                }
            };

            // Envoi de la requête
            xhr.send();
        }

        // Fonction pour afficher l'effectif de l'équipe sélectionnée
        function afficherEffectif(reponse) {
            var playersList = document.getElementById("players-list");
            playersList.innerHTML = ""; // Réinitialisation de la liste des joueurs

            // Boucle sur les joueurs
            for (var i = 0; i < reponse.squad.length; i++) {
                var joueur = reponse.squad[i];

                // Création d'un élément de liste pour afficher le nom du joueur
                var playerItem = document.createElement("li");
                playerItem.className = "player-item";
                playerItem.textContent = joueur.name;
                playerItem.draggable = true;

                // Ajout d'un identifiant unique à chaque élément de la liste des joueurs
                var joueurId = "player-" + i;
                playerItem.id = joueurId;

                // Ajout d'un gestionnaire d'événement pour permettre le déplacement des joueurs
                playerItem.addEventListener("dragstart", function(event) {
                    var joueurOrigineId = event.target.id + "-origine";
                    var joueurOrigine = document.getElementById(joueurOrigineId);
                    if (joueurOrigine) {
                        joueurOrigine.classList.remove("dragging");
                    }
                    event.dataTransfer.setData("text/plain", event.target.id);
                    event.target.classList.add("dragging");
                });

                // Ajout d'un gestionnaire d'événement pour terminer le déplacement des joueurs
                playerItem.addEventListener("dragend", function(event) {
                    event.target.classList.remove("dragging");
                });

                // Ajout d'un gestionnaire d'événement pour la sélection des joueurs
                playerItem.addEventListener("click", function(event) {
                    var playerId = event.target.id;
                    var selectedPlayer = document.getElementById(playerId + "-selected");
                    if (!selectedPlayer) {
                        var playerName = event.target.textContent;
                        var selectedPlayerItem = document.createElement("tr");
                        selectedPlayerItem.id = playerId + "-selected";
                        selectedPlayerItem.innerHTML = `
                            <td>${playerName}</td>
                            <td>
                                <div class="player-box" draggable="true" ondragstart="startDragging(event)">
                                    ${playerName}
                                    <span class="delete-cross" onclick="removePlayer(event)">&#10060;</span>
                                </div>
                            </td>
                        `;

                        var selectedPlayers = document.getElementById("selected-players");
                        selectedPlayers.appendChild(selectedPlayerItem);
                    }
                });

                // Ajout de l'élément de liste à la liste des joueurs
                playersList.appendChild(playerItem);
            }
        }

        // Fonction pour commencer le déplacement d'une case de joueur
        function startDragging(event) {
            event.dataTransfer.setData("text/plain", event.target.id);
        }

        // Fonction pour supprimer un joueur sélectionné
        function removePlayer(event) {
            var playerId = event.target.parentNode.parentNode.parentNode.id.replace("-selected", "");
            var playerItem = document.getElementById(playerId);
            var selectedPlayerItem = document.getElementById(playerId + "-selected");

            if (playerItem) {
                playerItem.classList.remove("selected");
            }

            if (selectedPlayerItem) {
                selectedPlayerItem.parentNode.removeChild(selectedPlayerItem);
            }
        }

        // Gestionnaire d'événement pour la sélection du club
        var selectClub = document.getElementById("club-select");
        selectClub.addEventListener("change", function() {
            var clubId = selectClub.value;
            selectedClub = clubId;
            obtenirEffectif(clubId);
        });

        // Gestionnaire d'événement pour le placement des cases des joueurs sur l'image du terrain
        var imageZone = document.getElementById("image-zone");

        imageZone.addEventListener("dragover", function(event) {
            event.preventDefault();
        });

        imageZone.addEventListener("drop", function(event) {
            event.preventDefault();
            var posX = event.clientX - imageZone.getBoundingClientRect().left;
            var posY = event.clientY - imageZone.getBoundingClientRect().top;

            var playerId = event.dataTransfer.getData("text/plain");
            var playerItem = document.getElementById(playerId);

            if (playerItem) {
                var playerName = playerItem.textContent;
                var playerBox = document.createElement("div");
                playerBox.className = "player-box";
                playerBox.textContent = playerName;
                playerBox.style.left = posX - (playerBox.offsetWidth / 2) + "px";
                playerBox.style.top = posY - (playerBox.offsetHeight / 2) + "px";
                playerBox.draggable = true;
                playerBox.addEventListener("dragstart", function(event) {
                    event.dataTransfer.setData("text/plain", event.target.id);
                    event.target.classList.add("dragging");
                });
                playerBox.addEventListener("dragend", function(event) {
                    event.target.classList.remove("dragging");
                });
                imageZone.appendChild(playerBox);
            }
        });

        // Gestionnaire d'événement pour le déplacement des joueurs sélectionnés dans la zone d'image
        var selectedPlayers = document.getElementById("selected-players");

        selectedPlayers.addEventListener("dragover", function(event) {
            event.preventDefault();
        });

        selectedPlayers.addEventListener("drop", function(event) {
            event.preventDefault();
            var playerId = event.dataTransfer.getData("text/plain");
            var playerBox = document.getElementById(playerId);
            var selectedPlayerItem = document.getElementById(playerId + "-selected");

            if (playerBox && selectedPlayerItem) {
                var posX = event.clientX - selectedPlayers.getBoundingClientRect().left;
                var posY = event.clientY - selectedPlayers.getBoundingClientRect().top;

                playerBox.style.left = posX - (playerBox.offsetWidth / 2) + "px";
                playerBox.style.top = posY - (playerBox.offsetHeight / 2) + "px";
                imageZone.appendChild(playerBox);
            }
        });

        // Effectuer la requête initiale pour obtenir l'effectif de tous les clubs
        obtenirEffectif("");
    </script>
</body>
</html>
