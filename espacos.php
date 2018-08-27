<!DOCTYPE html>
<html>
  <head>
        <?php session_start(); ?>
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
            include "Models/Reserva.php";
            include "Models/ReservaDao.php";
            include "Includes/reserva.inc";

            include "Models/Espaco.php";
            include "Models/EspacoDao.php";

            $dao_e = new EspacoDao();
            $dao_r = new ReservaDao();

            if (isset($_GET["tag"])){
                $espacos = $dao_e->read_by_tipo($_GET["tag"]);
            }else{
                $espacos = $dao_e->read_all();
            }

            foreach ($espacos as $e){
              echo '<section class="section">';
              echo '<div class="container">';
                echo '<h2 class="title">'. $e->nome .'</h2>';
                $reservas = $dao_r->read_by_place($e->nome);
                print_reservas_por_espaco($reservas);
              echo '</div>';
              echo '</section>';
            }
        ?>



    <!-- Importando os scripts -->
    <?php require "Includes/scripts.inc"; ?>

  </body>
</html>
