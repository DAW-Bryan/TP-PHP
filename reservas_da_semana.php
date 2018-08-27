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
                require "Models/Reserva.php";
                require "Models/ReservaDao.php";
                require "Includes/reserva.inc";

                date_default_timezone_set('America/Sao_Paulo');
                $dao = new ReservaDao();
                $data = date('Y-m-d');
                $reservas = [];

                if (isset($_POST["data"])){
                    echo '<h2 class="title is-2">Dia Pesquisado</h2>';
                    $reservas = $dao->read_by_date($_POST["data"]);
                    print_reservas_semana($reservas);
                }

                echo '<h2 class="title is-2">Reservas da semana</h2>';

                for ($i=0; $i < 7 - intval(date("w")); $i++){
                    if ($i==0){
                        $reservas = $dao->read_by_date($data);
                    }else{
                        $reservas = array_merge($reservas, $dao->read_by_date($data));
                    }
                    $data = date('Y-m-d', strtotime('+1 day', strtotime($data)));
                }

                print_reservas_semana($reservas);

                ?>

            <br>
            <form action="reservas_da_semana.php" method="post">
                <div class="label">Busca por data</div>
                <div class="field has-addons">
                    <div class="control">
                        <input type="date" name="data" id="data" class="input">
                    </div>
                    <div class="control">
                        <input type="submit" value="Buscar" class="button is-link">
                    </div>
                </div>
            </form>

        </section>
  </body>

  <?php require "Includes/scripts.inc"; ?>

</html>
