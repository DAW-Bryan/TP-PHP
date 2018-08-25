<!DOCTYPE html>
<html>
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reservas Coltec</title>

        <link rel="shortcut icon" href="Images/logo.png">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/custom.css">

        <!-- Bulma CSS -->
        <link rel="stylesheet" href="./css/bulma.min.css">

        <!-- Font Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

        <!-- JQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>

        <!-- Menu navbar -->
        <?php include "Includes/menu.inc"; ?>

        <section class="section">
            <nav class="columns">

                <a class="column has-text-centered" href="espacos.php?tag=quadras">
                    <p class="title is-4"> Quadras esportivas </p>
                    <p class="subtitle is-6"> Jogue seu futebol! </p>

                    <figure class="bd-focus-icon">
                      <img src="Images/ic_quadra.png" width="200px">
                    </figure>
                </a>

                <a class="column has-text-centered" href="espacos.php?tag=lab">
                    <p class="title is-4"> Laboratórios </p>
                    <p class="subtitle is-6"> Informática, Química, entre outros </p>

                    <figure class="bd-focus-icon">
                      <img src="Images/ic_lab.jpg" width="200px">
                    </figure>
                </a>

                <a class="column has-text-centered" href="espacos.php?tag=salas">
                    <p class="title is-4"> Salas de aula </p>
                    <p class="subtitle is-6"> Auditório, Sala de dança, etc </p>

                    <figure class="bd-focus-icon">
                      <img src="Images/ic_auditorio.jpg" width="200px">
                    </figure>
                </a>

            </nav>
        </section>


        <section class="hero is-light">
            <div class="hero-body">

                <div class="container">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>

            </div>
        </section>

        <section class="hero is-medium">
            <div class="hero-body">

                <div class="container">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>

            </div>
        </section>

  </body>


  <script>
        $(document).ready(function() {
            $(".navbar-burger").click(function() {
                $(".navbar-burger").toggleClass("is-active");
                $(".navbar-menu").toggleClass("is-active");
            });
        });
  </script>
</html>
