<!DOCTYPE html>
<html>
  <head>

        <?php

        session_start();

        if((($_SESSION['login']) == true) and (($_SESSION['matricula']) == true) and (($_SESSION['senha']) == true)) {
          $logado = $_SESSION['login'];
          $matricula = $_SESSION["matricula"];
        }

        if (($_GET['logout'])) {
          unset($_SESSION['login']);
          unset($_SESSION['matricula']);
          unset($_SESSION['senha']);
          header("location:index.php");
        }

        ?>


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


        <!-- Deleta reservas antigas -->
        <?php
            include "Models/Reserva.php";
            include "Models/ReservaDao.php";
            include "Includes/reserva.inc";
            date_default_timezone_set('America/Sao_Paulo');

            $dao = new ReservaDao();
            $dao->deleta_antigas();

            if (isset($_GET["reserva"])){ // Usuário deletou reserva
                $reservas_da_pessoa = $dao->read_by_matricula($_SESSION["matricula"]);
                $dao->delete($reservas_da_pessoa[$_GET["reserva"]]);
            }

        ?>

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


        <!-- TODO: Nessa section, pensei em fazer uma parte voltada para o usuários
         Como assim? Vamos trabalhar com sessões:
         Se a pessoa tiver logada, aparece como "Bem vindo de volta, Usuário", e embaixo as reservas feitas e um botão caso queira fazer outra
         Se a pessoa não estiver logada, aparece um mini form para o cadastro, ou para o login, e um botão para ver todas as Reservas-->
        <section class="hero is-light">
            <div class="hero-body">

              <?php if (!($logado)) { ?>
                <div class="container">
                  <h1 class="title"> Veja as reservas dos próximos dias </h1>
                      <div class="content">
                        <?php
                            $dao = new ReservaDao();
                            $data = date('Y-m-d');
                            $reservas = [];

                            for ($i=0; $i < 7 /*- intval(date("w"))*/; $i++){
                                if ($i==0){
                                    $reservas = $dao->read_by_date($data);
                                }else{
                                    $reservas = array_merge($reservas, $dao->read_by_date($data));
                                }
                                $data = date('Y-m-d', strtotime('+1 day', strtotime($data)));
                            }

                            print_todas_as_reservas($reservas);


                            if (isset($_POST["data"])){
                                echo '<h1 class="title"> Dia pesquisado: </h1>';
                                $reservas = $dao->read_by_date($_POST["data"]);
                                print_todas_as_reservas($reservas);
                            }
                        ?>

                        <br>
                        <form action="index.php" method="post">
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

                    $reservas = $dao->read_by_matricula($matricula);

                    print_reservas_da_pessoa($reservas);

                  ?>
                  </section>

                  <section class="section">
                    <a class="button is-link is-outlined" href="reservar.php"> Fazer outra reserva </a>
                  </section
                </div>

              <?php } ?>

            </div>
        </section>

  </body>

  <!-- Importando os scripts -->
  <?php require "Includes/scripts.inc"; ?>

</html>
