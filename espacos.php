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

        <!-- Reservas -->
        <?php
            require "Models/Reserva.php";
            require "Models/ReservaDao.php";
            include "Includes/reserva.inc";
        
           $dao = new ReservaDao();

           echo '<section class="section">';
            if ($_GET["tag"] == "quadras"){
                $reservas = $dao->read_by_place("Quadra maior");
                echo '<h1 class="title is-2">Quadra maior</h1>';
                print_reservas_por_espaco($reservas);

                $reservas = $dao->read_by_place("Quadra menor");
                echo '<h1 class="title is-2">Quadra menor</h1>';
                print_reservas_por_espaco($reservas);                
            }else if ($_GET["tag"] =="lab"){
                $reservas = $dao->read_by_place("Laboratório de Informática");
                echo '<h1 class="title is-2">Laboratório de Informática</h1>';
                print_reservas_por_espaco($reservas);

                $reservas = $dao->read_by_place("Laboratório de Química");
                echo '<h1 class="title is-2">Laboratório de Química</h1>';
                print_reservas_por_espaco($reservas);                
            }else if ($_GET["tag"] == "salas"){
                $reservas = $dao->read_by_place("Auditório");
                echo '<h1 class="title is-2">Auditório</h1>';
                print_reservas_por_espaco($reservas);
            }
            echo '</section>';
                
        ?>

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
