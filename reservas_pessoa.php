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

        <section class="section">
            <?php

            include "Includes/reserva.inc";
            include "Models/ReservaDao.php";
            include "Models/Reserva.php";

            $dao = new ReservaDao();
            $reservas = $dao->read_by_matricula("123");
            if (isset($_GET["reserva"])){
                $dao->delete($reservas[$_GET["reserva"]]);
                header("Location: reservas_pessoa.php");
            }else{
                print_reservas_da_pessoa($reservas);
            }

            ?>

        </section>

  </body>

  <?php require "Includes/scripts.inc"; ?>
  
</html>
