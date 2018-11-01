<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reservas COLTEC</title>

        <link rel="shortcut icon" href="Images/logo.png">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/custom.css">

        <!-- Bulma CSS -->
        <link rel="stylesheet" href="./css/bulma.min.css">
        <link rel="stylesheet" href="./css/bulma-tooltip.min.css">

        <!-- Font Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

        <!-- JQuery -->
        <script src="scripts/jquery.min.js"></script>
  </head>

  <body>

        <!-- Menu navbar -->
        <?php include "Includes/menu.inc"; ?>


        <!-- Reservas -->
        <?php
            include "Includes/reserva.inc";

            if (isset($_GET["tag"])){
                $itens = $dao_i->read_by_categoria($_GET["tag"]);
            }else{
                $itens = $dao_i->read_all();
            }

            if ($itens == null){
                echo "<section class='section'><div class='container'><h2 class='title'>Nenhum item está cadastrado nessa categoria</h2></div></section>";
            }else{
                foreach ($itens as $i){
                  echo '<section class="section">';
                  echo '<div class="container">';
                    echo '<h2 class="title">'. $i->nome .'</h2>';
                    $reservas = $dao_r->read_by_item($i->nome);
                    print_reservas_por_item($reservas);
                  echo '</div>';
                  echo '</section>';
                }
            }
        ?>

        <?php include "Includes/footer.inc"; ?>
    <!-- Importando os scripts -->
    <script src="scripts/main_script.js"></script>

  </body>
</html>
