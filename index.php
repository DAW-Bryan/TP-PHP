<?php
session_start();
require "Includes/reserva.inc";

if( (isset($_SESSION["login"]) == true) and (isset($_SESSION["matricula"]) == true) and (isset($_SESSION["senha"]) == true) ) {
  $logado = $_SESSION['login'];
  $matricula = $_SESSION["matricula"];

  if(isset($_POST["atual"]) && isset($_POST["senha1"])){ //Usuário mudou de senha
      $changePsw =  $dao_u->changePsw($matricula, $_POST["senha1"], $_POST["atual"]);
  }
}

if (isset($_GET['logout'])) {
  session_destroy();
  header("location:index.php");
}
?>

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
        <script src='scripts/jquery.min.js'></script>

        <!-- Moment.js -->
        <script src='scripts/moment-with-locales.js'></script>

        <!-- FullCalendar -->
        <link rel='stylesheet' href='css/fullcalendar.css' />
        <script src='scripts/fullcalendar.js'></script>

  </head>

  <body>
        <!-- Menu navbar -->
        <?php include "Includes/menu.inc"; ?>


        <!-- Deleta reservas antigas -->
        <?php
            date_default_timezone_set('America/Sao_Paulo');;
            $dao_r->deleta_antigas();

            if (isset($_GET["reserva"])){ // Usuário deletou reserva
              echo " <div class='notification is-success'>
                        <h2 class='title'> Reserva deletada com sucesso! </h1>
                     </div>";;
                $reservas_da_pessoa = $dao_r->read_by_matricula($_SESSION["matricula"]);
                $dao_r->delete($reservas_da_pessoa[$_GET["reserva"]]);
            }

            if (isset($changePsw)){ // Usuário mudou de senha
                if ($changePsw){
                    echo " <div class='notification is-success'>
                              <h2 class='title'> Senha alterada com sucesso! </h1>
                           </div>";
                }else{
                    echo " <div class='notification is-danger'>
                              <h2 class='title'> Senha não foi alterada, verifique se digitou a senha atual corretamente </h1>
                           </div>";
                }
            }

        ?>

        <section class="section">
            <nav class="columns">

                <a class="column has-text-centered" href="itens.php?tag=Quadras">
                    <p class="title is-4"> Quadras esportivas </p>
                    <p class="subtitle is-6"> Jogue seu futebol! </p>

                    <figure class="bd-focus-icon">
                      <img src="Images/ic_quadra.png" width="200px">
                    </figure>
                </a>

                <a class="column has-text-centered" href="itens.php?tag=Veículos">
                    <p class="title is-4"> Veículos </p>
                    <p class="subtitle is-6"> Ônibus e van </p>

                    <figure class="bd-focus-icon">
                      <img src="Images/ic_veiculo.jpg" width="200px">
                    </figure>
                </a>


                <a class="column has-text-centered" href="itens.php?tag=Laboratórios">
                    <p class="title is-4"> Laboratórios </p>
                    <p class="subtitle is-6"> Informática, Química, entre outros </p>

                    <figure class="bd-focus-icon">
                      <img src="Images/ic_lab.jpg" width="200px">
                    </figure>
                </a>

                <a class="column has-text-centered" href="itens.php?tag=Salas de aula">
                    <p class="title is-4"> Salas de aula </p>
                    <p class="subtitle is-6"> Auditório, Sala de dança, etc </p>

                    <figure class="bd-focus-icon">
                      <img src="Images/ic_auditorio.jpg" width="200px">
                    </figure>
                </a>

            </nav>
        </section>


        <!-- Section voltada para o usuário / Ou para as reservas dos próximos dias -->
        <section class="hero is-light">
            <div class="hero-body">

              <?php if (!isset($logado)) { ?>
                <div class="container">

                  <h1 class="title"> Veja as reservas dos próximos dias </h1>
                      <div class="content">
                        <?php

                            $data = date('Y-m-d');
                            $reservas = [];
                            for ($i=0; $i < 7; $i++){
                                if ($i==0){
                                    $reservas = $dao_r->read_by_date($data);
                                }else{
                                    $reservas = array_merge($reservas, $dao_r->read_by_date($data));
                                }
                                $data = date('Y-m-d', strtotime('+1 day', strtotime($data)));
                            }
                            print_todas_as_reservas($reservas);


                            if (isset($_GET["data"])){
                                echo '<h1 class="title"> Dia pesquisado: </h1>';
                                $reservas = $dao_r->read_by_date($_GET["data"]);
                                print_todas_as_reservas($reservas);
                            }
                        ?>

                        <!-- FullCalendar -->
                        <div id="calendar" class="container"></div>

                        <br><br>
                        <form action="index.php" method="get">
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

                      </div>
                </div>
              <?php } else { ?>


                <div class="container">
                  <section class="section">
                  <?php echo '<h1 class="title"> Bem vindo, ' . $logado . '</h1>';

                    $reservas = $dao_r->read_by_matricula($matricula);
                    print_reservas_da_pessoa($reservas);

                  ?>
                  </section>

                  <section class="section">
                    <a class="button is-link is-outlined" href="reservar.php"> Fazer outra reserva </a>
                  </section>
                </div>

                <!-- FullCalendar -->
                <div id="calendar" class="container"></div>
              <?php } ?>
            </div>
        </section>


        <script>
            $(document).ready(function() {

              $('#calendar').fullCalendar({
                  header: {
                    left: 'today, prev, next',
                    center: 'title',
                    right: 'month, basicWeek, basicDay'
                  },

                views: {
                  month: { // name of view
                    titleFormat: 'MMMM, YYYY'
                    }
                },

                navLinks: true,
                eventLimit: true,

                events: [<?php
                    $reservas = $dao_r->read_all();
                    $i = 0;
                    foreach ($reservas as $r) {
                        $item = $dao_i->read_by_id($r->item_id);
                        $i++;

                        if ($r->tipo_de_reserva == "Semanal"){
                            if ($i == count($reservas)){
                                echo "{title  : '". $r->nome . " - ". $item->nome ."', start  : '" .$r->inicio. "', end  : '". $r->fim ."', dow: [ ". $r->data ."]}";
                            }else{
                                echo "{title  : '". $r->nome . " - ". $item->nome ."', start  : '" .$r->inicio. "', end  : '". $r->fim ."', dow: [ ". $r->data ."]},";
                            }

                        }else{
                            if ($i == count($reservas)){
                                echo "{title  : '". $r->nome . " - ". $item->nome ."', start  : '" . $r->data . "T" . $r->inicio. "', end  : '". $r->data . "T" . $r->fim. "'}";
                            }else{
                                echo "{title  : '". $r->nome . " - ". $item->nome ."', start  : '" . $r->data . "T" . $r->inicio. "', end  : '". $r->data . "T" . $r->fim. "'},";
                            }
                        }
                    }
                    ?>]
            })
        });
        </script>

        <!-- Importando os scripts -->
        <script src="scripts/main_script.js"></script>

  </body>
</html>
