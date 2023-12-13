<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" type="text/css" href="tactique.css">
  <style>
      /* Ajout de styles pour les boutons de navigation */
      .nav-buttons {
          position: fixed;
          top: 50%;
          left: 10px;
          transform: translateY(-50%);
          z-index: 999;
      }

      .nav-buttons button {
          display: block;
          margin-bottom: 10px;
          padding: 10px;
          background-color: #FFF;
          border: none;
          border-radius: 5px;
          font-size: 14px;
          cursor: pointer;
      }

      .section {
          margin-bottom: 40px;
          padding: 20px;
          color: #FFF;
          border-radius: 5px;
          transition: background-color 0.3s;
      }

      .section:hover {
          background-color: rgba(0, 0, 0, 0.8);
      }

      .section h1, .section h2, .section p {
          margin: 0;
          padding: 0;
          color: #FFF;
          text-align: center;
      }

      .section h1 {
          font-size: 40px;
          margin-bottom: 20px;
      }

      .section h2 {
          font-size: 24px;
          margin-bottom: 10px;
          text-decoration: underline;
      }

      .section p {
          font-size: 16px;
          line-height: 1.5;
      }

      .section-content {
          display: flex;
          flex-direction: column;
          align-items: center;
      }

      .section-controle {
    background-color: #f39c12;
}

.section-gegenpress {
    background-color: #e74c3c;
}

.section-tikitaka {
    background-color: #3498db;
}

.section-tikitaka-vertical {
    background-color: #1abc9c;
}

.section-ailes {
    background-color: #9b59b6;
}

.section-longs-ballons {
    background-color: #f1c40f;
}

.section-contre-attaques-fluides {
    background-color: #27ae60;
}

.section-catenaccio {
    background-color: #34495e;
}

.section-ultradefensif {
    background-color: #95a5a6;
}

.section-contre-attaques-directes {
    background-color: #d35400;
}

      .gif-container {
          display: flex;
          justify-content: center;
      }

      .gif-container img {
          border-radius: 10px;
          max-width: 70%;
          height: auto;
      }

      .zoomable-gif {
          border-radius: 10px;
          max-width: 100%;
          height: auto;
          transition: transform 0.3s;
          cursor: pointer;
      }

      .zoomable-gif:hover {
          transform: scale(1.2);
      }

      .gif-modal {
          display: flex;
          align-items: center;
          justify-content: center;
          position: fixed;
          top: 0;
          left: 0;
          width: 100%;
          height: 100%;
          background-color: rgba(0, 0, 0, 0.9);
          z-index: 9999;
          opacity: 0;
          pointer-events: none;
          transition: opacity 0.3s;
      }

      .gif-modal.active {
          opacity: 1;
          pointer-events: auto;
      }

      .gif-modal-content {
          max-width: 80%;
          max-height: 80%;
      }

      .gif-modal img {
          border-radius: 10px;
          max-width: 100%;
          max-height: 100%;
      }

      .gif-modal-close {
          position: absolute;
          top: 20px;
          right: 20px;
          font-size: 24px;
          color: #FFF;
          cursor: pointer;
      }
  </style>
</head>
<body>
  <div class="nav-buttons" style="left: 10px; left: unset;">
      <button style="background-color: #f39c12;" onclick="scrollToSection('section-controle')">Contrôle de la possession</button>
      <button style="background-color: #e74c3c;" onclick="scrollToSection('section-gegenpress')">Gegenpress</button>
      <button style="background-color: #3498db;" onclick="scrollToSection('section-tikitaka')">Tiki-taka</button>
      <button style="background-color: #1abc9c;" onclick="scrollToSection('section-tikitaka-vertical')">Tiki-taka vertical</button>
      <button style="background-color: #9b59b6;" onclick="scrollToSection('section-ailes')">Jeu sur les ailes</button>
      </div>
  <div class="nav-buttons" style="right: 10px; left: unset;">

      <!-- Nouveaux boutons -->
      <button style="background-color: #f1c40f;" onclick="scrollToSection('section-longs-ballons')">Longs ballons devant</button>
      <button style="background-color: #27ae60;" onclick="scrollToSection('section-contre-attaques-fluides')">Contre-attaques fluides</button>
      <button style="background-color: #34495e;" onclick="scrollToSection('section-catenaccio')">Catenaccio</button>
      <button style="background-color: #95a5a6;" onclick="scrollToSection('section-ultradefensif')">Jeu ultra-défensif</button>
      <button style="background-color: #d35400;" onclick="scrollToSection('section-contre-attaques-directes')">Contre-attaques directes</button>
  </div>


  <?php
  include 'menu.php';
  ?>
  <div class="content">
      <div class="section section-controle" id="section-controle">
          <h1>Contrôle de la possession</h1>
          <div class="section-content">
              <h2>Histoire</h2>
              <br>
              <p>Le contrôle de la possession est une tactique de football axée sur la maîtrise du ballon et la domination du jeu. Elle a été popularisée par des équipes comme le FC Barcelone et l'équipe nationale d'Espagne. Cette approche vise à maintenir une possession élevée du ballon pour contrôler le tempo du jeu et créer des occasions d'attaque.</p>
              <br>
              <br>
              <h2>Fonctionnement</h2>
              <br>
              <br>
              <div class="gif-container">
                <img src="images/controle-de-la-possession.gif" alt="Tiki-taka GIF" class="zoomable-gif">
              </div>
              <br>
              <p>Le contrôle de la possession repose sur des passes rapides et précises entre les joueurs de l'équipe. Les joueurs cherchent à maintenir la possession en effectuant des passes courtes et en se déplaçant intelligemment pour offrir des solutions de passes. L'objectif est de fatiguer l'adversaire, d'ouvrir des espaces et de créer des opportunités de progression et de marquer des buts.</p>
              <br>
              <br>
              <h2>Clubs et entraîneurs utilisant le contrôle de la possession</h2>
              <ul>
                  <li>FC Barcelone - Pep Guardiola, Luis Enrique</li>
                  <li>Équipe nationale d'Espagne - Vicente del Bosque, Luis Enrique</li>
                  <li>Manchester City - Pep Guardiola</li>
              </ul>
          </div>
      </div>

      <div class="section section-gegenpress"  id="section-gegenpress">
          <h1>Gegenpress</h1>
          <div class="section-content">
              <h2>Histoire</h2>
              <p>Le gegenpress est une tactique de football qui consiste à exercer une pression intense sur l'adversaire immédiatement après la perte de balle. Elle vise à récupérer rapidement le contrôle du ballon en empêchant l'équipe adverse de construire des attaques organisées.</p>
              <h2>Fonctionnement</h2>
              <div class="gif-container">
                <img src="images/gegenpress.gif" alt="Tiki-taka GIF" class="zoomable-gif">
              </div>
              <p>Le gegenpress implique que tous les joueurs de l'équipe se lancent immédiatement dans une pression agressive après la perte de possession. L'objectif est de forcer l'adversaire à commettre des erreurs et à récupérer rapidement le ballon. Cette tactique nécessite une grande intensité physique et une coordination collective élevée.</p>
              <h2>Clubs et entraîneurs utilisant le gegenpress</h2>
              <ul>
                  <li>Liverpool - Jürgen Klopp</li>
                  <li>Borussia Dortmund - Jürgen Klopp</li>
                  <li>RB Leipzig - Julian Nagelsmann</li>
              </ul>
          </div>
      </div>

      <div class="section section-tikitaka" id="section-tikitaka">
          <h1>Tiki-taka</h1>
          <div class="section-content">
              <h2>Histoire</h2>
              <p>Le tiki-taka est un style de jeu de football qui a été popularisé par l'équipe nationale d'Espagne et le FC Barcelone. Il a été développé par l'entraîneur espagnol Pep Guardiola et se caractérise par un jeu de passes rapides et courtes, la possession de balle et le mouvement constant des joueurs sans ballon.</p>
              <h2>Fonctionnement</h2>
              <div class="gif-container">
                <img src="images/tiki-taka.gif" alt="Tiki-taka GIF" class="zoomable-gif">
              </div>
              <p>Le tiki-taka repose sur une philosophie de jeu axée sur la possession de balle. Les joueurs cherchent à maintenir la possession en effectuant des passes rapides et précises entre eux. L'objectif est de créer des espaces et des opportunités de progression en épuisant l'adversaire et en trouvant des brèches dans sa défense.</p>
              <h2>Clubs et entraîneurs utilisant le tiki-taka</h2>
              <ul>
                  <li>FC Barcelone - Pep Guardiola, Luis Enrique</li>
                  <li>Équipe nationale d'Espagne - Vicente del Bosque, Luis Enrique</li>
                  <li>Bayern Munich - Pep Guardiola</li>
              </ul>
          </div>
      </div>

          <div class="section section-tikitaka-vertical" id="section-tikitaka-vertical">
              <h1>Tiki-taka vertical</h1>
              <div class="section-content">
                  <h2>Histoire</h2>
                  <p>Le tiki-taka vertical est une variante du tiki-taka qui met l'accent sur des passes rapides et précises vers l'avant, favorisant ainsi un jeu offensif direct. Il cherche à prendre rapidement l'adversaire de vitesse et à créer des occasions de but en exploitant les espaces entre les lignes.</p>
                  <h2>Fonctionnement</h2>
                  <div class="gif-container">
                    <img src="images/tiki-taka-vertical.gif" alt="Tiki-taka GIF" class="zoomable-gif">
                  </div>
                  <p>Le tiki-taka vertical consiste à effectuer des passes rapides vers l'avant pour déstabiliser la défense adverse. Les joueurs cherchent à se positionner dans des zones avancées du terrain et à combiner rapidement pour créer des opportunités de but. Cette tactique met l'accent sur la rapidité d'exécution et la précision des passes vers l'avant.</p>
                  <h2>Clubs et entraîneurs utilisant le tiki-taka vertical</h2>
                  <ul>
                      <li>Manchester City - Pep Guardiola</li>
                      <li>Liverpool - Jürgen Klopp</li>
                      <li>Leipzig - Julian Nagelsmann</li>
                  </ul>
              </div>
          </div>

          <div class="section section-ailes" id="section-ailes">
              <h1>Jeu sur les ailes</h1>
              <div class="section-content">
                  <h2>Histoire</h2>
                  <p>Le jeu sur les ailes est une tactique de football qui se concentre sur l'utilisation des espaces sur les côtés du terrain. Elle implique de fournir des passes précises et des centres depuis les ailes pour créer des occasions de marquer des buts.</p>
                  <h2>Fonctionnement</h2>
                  <div class="gif-container">
                    <img src="images/jeu-sur-les-ailes.gif" alt="Tiki-taka GIF" class="zoomable-gif">
                  </div>
                  <p>Le jeu sur les ailes repose sur des joueurs rapides et techniques qui peuvent dribbler leurs adversaires et fournir des centres précis. Les joueurs des ailes cherchent à exploiter les espaces et à créer des situations de supériorité numérique en attaquant les flancs du terrain. Cette tactique met l'accent sur la vitesse, la précision des passes et les mouvements des joueurs dans les zones extérieures.</p>
                  <h2>Clubs et entraîneurs utilisant le jeu sur les ailes</h2>
                  <ul>
                      <li>Manchester United - Sir Alex Ferguson, Ole Gunnar Solskjær</li>
                      <li>Chelsea - José Mourinho, Thomas Tuchel</li>
                      <li>Bayern Munich - Jupp Heynckes, Hansi Flick</li>
                  </ul>
              </div>
          </div>

          <div class="section section-longs-ballons" id="section-longs-ballons">
              <h1>Longs ballons devant</h1>
              <div class="section-content">
                  <h2>Histoire</h2>
                  <p>Les longs ballons devant sont une tactique de football qui consiste à envoyer des passes longues en direction des attaquants pour les amener rapidement dans la moitié de terrain adverse. Cette tactique est souvent utilisée pour surprendre la défense adverse et créer des situations de contre-attaque.</p>
                  <h2>Fonctionnement</h2>
                  <div class="gif-container">
                    <img src="images/longs-ballons-devant.gif" alt="Tiki-taka GIF" class="zoomable-gif">
                  </div>
                  <p>Les longs ballons devant impliquent généralement l'utilisation d'un attaquant puissant et rapide qui peut gagner les duels aériens et conserver le contrôle du ballon. L'équipe cherche à envoyer des passes longues vers l'avant pour permettre à l'attaquant de recevoir le ballon dans de bonnes conditions et de créer des occasions de but. Cette tactique met l'accent sur la précision des passes longues et les mouvements des attaquants pour exploiter l'espace.</p>
                  <h2>Clubs et entraîneurs utilisant les longs ballons devant</h2>
                  <ul>
                      <li>Stoke City - Tony Pulis</li>
                      <li>West Ham United - Sam Allardyce</li>
                      <li>Burnley - Sean Dyche</li>
                  </ul>
              </div>
          </div>

          <div class="section section-contre-attaques-fluides" id="section-contre-attaques-fluides">
              <h1>Contre-attaques fluides</h1>
              <div class="section-content">
                  <h2>Histoire</h2>
                  <p>Les contre-attaques fluides sont une tactique de football qui se caractérise par des transitions rapides et efficaces entre la défense et l'attaque. Elle vise à exploiter les espaces laissés par l'équipe adverse après avoir récupéré le ballon pour créer des situations de supériorité numérique et marquer des buts rapidement.</p>
                  <h2>Fonctionnement</h2>
                  <div class="gif-container">
                    <img src="images/contre-attaques-fluides.gif" alt="Tiki-taka GIF" class="zoomable-gif">
                  </div>
                  <p>Les contre-attaques fluides impliquent une organisation rapide de l'équipe après la récupération du ballon. Les joueurs se projettent rapidement vers l'avant, en utilisant des passes rapides et précises pour créer des opportunités d'attaque. Cette tactique met l'accent sur la vitesse, la coordination et les mouvements synchronisés des joueurs pour surprendre la défense adverse.</p>
                  <h2>Clubs et entraîneurs utilisant les contre-attaques fluides</h2>
                  <ul>
                      <li>Real Madrid - Zinédine Zidane</li>
                      <li>Manchester City - Pep Guardiola</li>
                      <li>RB Leipzig - Julian Nagelsmann</li>
                  </ul>
              </div>
          </div>

          <div class="section section-catenaccio" id="section-catenaccio">
              <h1>Catenaccio</h1>
              <div class="section-content">
                  <h2>Histoire</h2>
                  <p>Le catenaccio est une tactique de football défensive développée en Italie. Elle se caractérise par une défense solide et bien organisée, avec un ou plusieurs joueurs occupant un rôle de libéro devant la défense. L'accent est mis sur le marquage serré des adversaires et la recherche de contre-attaques opportunistes.</p>
                  <h2>Fonctionnement</h2>
                  <div class="gif-container">
                    <img src="images/catenaccio.gif" alt="Tiki-taka GIF" class="zoomable-gif">
                  </div>
                  <p>Le catenaccio repose sur une défense compacte et disciplinée. Les joueurs se concentrent sur la couverture de l'espace et le marquage individuel étroit des adversaires. L'équipe cherche à exploiter les erreurs de l'adversaire en récupérant rapidement le ballon et en lançant des contre-attaques rapides et efficaces. Cette tactique met l'accent sur la solidité défensive et l'efficacité en contre-attaque.</p>
                  <h2>Clubs et entraîneurs utilisant le catenaccio</h2>
                  <ul>
                      <li>Inter Milan - Helenio Herrera</li>
                      <li>Juventus - Marcello Lippi</li>
                      <li>AC Milan - Arrigo Sacchi</li>
                  </ul>
              </div>
          </div>

          <div class="section section-ultradefensif" id="section-ultradefensif">
              <h1>Jeu ultra-défensif</h1>
              <div class="section-content">
                  <h2>Histoire</h2>
                  <p>Le jeu ultra-défensif est une tactique de football qui met l'accent sur une défense solide et un jeu très conservateur. L'équipe cherche à minimiser les risques et à empêcher l'adversaire de marquer des buts en se concentrant principalement sur la défense et le jeu défensif.</p>
                  <h2>Fonctionnement</h2>
                  <div class="gif-container">
                    <img src="images/jeu-ultra-défensif.gif" alt="Tiki-taka GIF" class="zoomable-gif">
                  </div>
                  <p>Le jeu ultra-défensif implique un repli massif de l'équipe vers sa propre moitié de terrain. Les joueurs se concentrent sur le marquage étroit, le blocage des espaces et le refus d'accorder des occasions de but à l'adversaire. L'équipe cherche à défendre en nombre et à lancer des contre-attaques opportunistes pour marquer des buts. Cette tactique met l'accent sur la solidité défensive et la discipline tactique.</p>
                  <h2>Clubs et entraîneurs utilisant le jeu ultra-défensif</h2>
                  <ul>
                      <li>Atletico Madrid - Diego Simeone</li>
                      <li>Burnley - Sean Dyche</li>
                      <li>Crystal Palace - Roy Hodgson</li>
                  </ul>
              </div>
          </div>

          <div class="section section-contre-attaques-directes" id="section-contre-attaques-directes">
              <h1>Contre-attaques directes</h1>
              <div class="section-content">
                  <h2>Histoire</h2>
                  <p>Les contre-attaques directes sont une tactique de football qui vise à exploiter rapidement les espaces laissés par l'équipe adverse après avoir récupéré le ballon. Elle se caractérise par des passes rapides vers l'avant et des courses offensives pour créer des situations de supériorité numérique et marquer des buts rapidement.</p>
                  <h2>Fonctionnement</h2>
                  <div class="gif-container">
                    <img src="images/contre-attaques-directes.gif" alt="Tiki-taka GIF" class="zoomable-gif">
                  </div>
                  <p>Les contre-attaques directes impliquent une transition rapide de la défense à l'attaque après la récupération du ballon. Les joueurs cherchent à lancer des passes rapides vers l'avant pour exploiter l'espace laissé par l'équipe adverse. L'objectif est de créer des situations de supériorité numérique et de marquer rapidement des buts. Cette tactique met l'accent sur la vitesse, la précision des passes et les courses offensives.</p>
                  <h2>Clubs et entraîneurs utilisant les contre-attaques directes</h2>
                  <ul>
                      <li>Real Madrid - Zinédine Zidane</li>
                      <li>Borussia Dortmund - Jürgen Klopp</li>
                      <li>Paris Saint-Germain - Mauricio Pochettino</li>
                  </ul>
              </div>
          </div>
      </div>
      <script>
        // Fonction pour gérer le scroll vers la section correspondante
        function scrollToSection(sectionId) {
            const section = document.getElementById(sectionId);
            if (section) {
                section.scrollIntoView({ behavior: 'smooth' });
            }
        }
    </script>
  </body>
  </html>
