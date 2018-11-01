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

                <?php
                    $cats = $dao_c->read_all();
                    if ($cats != null){
                        foreach($cats as $c){
                            echo '<a class="column has-text-centered" href="itens.php?tag='. $c->nome .'">';
                            echo '<p class="title is-4">'. $c->nome .'</p>';
                            echo '<figure class="bd-focus-icon"><img src="'. $c->imagem .'" width="200px"></figure></a>';
                        }
                    }
                ?>
            </nav>
        </section>


        <!-- Section voltada para o usuário / Ou para as reservas dos próximos dias -->
        <section class="hero is-light">
            <div class="hero-body">

              <?php if (isset($logado)) { ?>
                  <div class="container">
                    <section class="section">
                    <?php echo '<h1 class="title"> Bem vindo, ' . $logado . '</h1>';

                      $reservas = $dao_r->read_by_matricula($matricula);
                      print_reservas_da_pessoa($reservas);

                    ?>
                      <br><a class="button is-link is-outlined" href="reservar.php"> Fazer uma reserva </a>
                    </section>
                  </div>
              <?php } ?>

                <div class="container">
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

                        if (count($reservas) > 0){
                            echo '<h1 class="title"> Veja as reservas dos próximos dias </h1>';
                            print_todas_as_reservas($reservas);
                        }    

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
            </div>
        </section>

        <?php include "Includes/footer.inc"; ?>

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
                    if ($reservas != null){
                        foreach ($reservas as $r) {
                            $item = $dao_i->read_by_id($r->item_id);
                            $i++;

                            if ($r->tipo_de_reserva == "Semanal"){
                                if ($i == count($reservas)){
                                    echo "{title  : '". $item->nome . " - ". $r->nome ."', start  : '" .$r->inicio. "', end  : '". $r->fim ."', dow: [ ". $r->data ."]}";
                                }else{
                                    echo "{title  : '". $item->nome . " - ". $r->nome ."', start  : '" .$r->inicio. "', end  : '". $r->fim ."', dow: [ ". $r->data ."]},";
                                }

                            }else{
                                if ($i == count($reservas)){
                                    echo "{title  : '". $item->nome . " - ". $r->nome ."', start  : '" . $r->data . "T" . $r->inicio. "', end  : '". $r->data . "T" . $r->fim. "'}";
                                }else{
                                    echo "{title  : '". $item->nome . " - ". $r->nome ."', start  : '" . $r->data . "T" . $r->inicio. "', end  : '". $r->data . "T" . $r->fim. "'},";
                                }
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
