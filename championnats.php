<!DOCTYPE html>
<html>
<head>
    <title>Page avec fond animé et boutons</title>
    <style>
        body {
            background: linear-gradient(45deg, #FFD700, #FF8C00, #FF4500, #FF1493, #8A2BE2, #1E90FF);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
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

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }

        .title {
            font-size: 24px;
            color: white;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

        .buttons {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            max-width: 600px;
            width: 100%;
          
        }

        .button {
            margin: 10px;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 5px;
            cursor: pointer;
            color: white;
              text-decoration: none;
        }

        .button:nth-child(1) {
            background-color: #E74C3C;
        }

        .button:nth-child(2) {
            background-color: #3498DB;
        }

        .button:nth-child(3) {
            background-color: #2ECC71;
        }

        .button:nth-child(4) {
            background-color: #F1C40F;
        }

        .button:nth-child(5) {
            background-color: #9B59B6;
        }

        .button:nth-child(6) {
            background-color: #E67E22;
        }
    </style>
</head>
<?php
include 'menu.php';
?>
<body>
    <div class="container">
        <h1 class="title">Choisissez un championnat :</h1>
        <div class="buttons">
    <a href="PL.php" class="button">Premier League</a>
    <a href="PD.php" class="button">Liga</a>
    <a href="SA.php" class="button">Serie A</a>
    <a href="BL1.php" class="button">Bundesliga</a>
    <a href="FL1.php" class="button">Ligue 1</a>
    <a href="PPL.php" class="button">Liga NOS</a>
</div>

    </div>
</body>
</html>
