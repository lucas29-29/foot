<!DOCTYPE html>
<html>
<head>
    <title>Clubs des championnats</title>
    <style>
        /* Ajoutez votre CSS personnalisé ici */
        .league-button {
            margin: 5px;
        }

        .clubs-container {
            margin-top: 20px;
        }

        .club {
            margin: 5px;
            padding: 5px;
            border: 1px solid #ccc;
            background-color: #eaeaea;
        }
    </style>
</head>
<body>
    <h1>Clubs des championnats</h1>

    <div>
        <button class="league-button" onclick="getClubs('PL')">Championnat anglais</button>
        <button class="league-button" onclick="getClubs('PD')">Championnat espagnol</button>
        <button class="league-button" onclick="getClubs('FL1')">Championnat français</button>
        <button class="league-button" onclick="getClubs('PPL')">Championnat portugais</button>
        <button class="league-button" onclick="getClubs('SA')">Championnat italien</button>
        <button class="league-button" onclick="getClubs('BL1')">Championnat allemand</button>
    </div>

    <div class="clubs-container" id="clubs-container"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function getClubs(leagueCode) {
            var clubsContainer = document.getElementById("clubs-container");
            clubsContainer.innerHTML = "Chargement des clubs...";

            $.ajax({
                url: "https://api.football-data.org/v2/competitions/" + leagueCode + "/teams",
                headers: {
                    "X-Auth-Token": "1bf86dc9d65746149a26808fdc45a5a1"
                },
                dataType: "json",
                success: function(response) {
                    clubsContainer.innerHTML = "";

                    if (response && response.teams && response.teams.length > 0) {
                        response.teams.forEach(function(club) {
                            var clubName = club.name;
                            var clubElement = document.createElement("div");
                            clubElement.className = "club";
                            clubElement.innerHTML = '<a href="test3.php?clubId=' + club.id + '">' + clubName + '</a>';
                            clubsContainer.appendChild(clubElement);
                        });
                    } else {
                        clubsContainer.innerText = "Aucun club trouvé pour ce championnat.";
                    }
                },
                error: function() {
                    clubsContainer.innerText = "Erreur lors de la récupération des clubs.";
                }
            });
        }
    </script>
</body>
</html>
