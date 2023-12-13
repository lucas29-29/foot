<!DOCTYPE html>
<html>
<head>
  <title>Menu en haut de page</title>
  <link rel="stylesheet" type="text/css" href="menus.css">
  <style>
    .sticky {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 100;
    }

    body {
      margin-top: 40px;
    }

    nav.sticky {
      opacity: 1;
      transform: translateY(0);
      animation: none;
    }
  </style>
</head>
<body>
  <header>
    <nav class="sticky">
      <ul class="menu">
        <li><a href="accueil.php">Accueil</a></li>
        <li><a href="jeu.php">Compo (beta)</a></li>
        <li><a href="championnats.php">Championnats</a></li>
        <li><a href="tactique.php">Tactiques</a></li>
        <li><a href="contacts.html">Contacts</a></li>
      </ul>
    </nav>
  </header>

  <!-- Le reste du contenu de votre page -->

  <script>
    window.onscroll = function() { myFunction() };

    var navbar = document.querySelector('.sticky');
    var sticky = navbar.offsetTop;

    function myFunction() {
      if (window.pageYOffset >= sticky) {
        navbar.classList.add('sticky');
      } else {
        navbar.classList.remove('sticky');
      }
    }
  </script>
</body>
</html>
