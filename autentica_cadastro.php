<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Autenticação</title>

    <link rel="shortcut icon" href="Images/logo.png">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/custom.css">

    <!-- Bulma CSS -->
    <link rel="stylesheet" href="./css/bulma.min.css">

    <!-- Font Awesome -->
    <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

    <!-- JQuery -->
    <script src="scripts/jquery.min.js"></script>
  </head>

  <body>

    <!-- Menu navbar -->
    <?php include "Includes/menu.inc";

          include "Includes/reserva.inc";

          $matricula = $_POST["EntradaMatricula"];
          $senha = $_POST["EntradaSenha"];
          $nome = $_POST["EntradaNome"];

          if ($dao_u->read_by_id($matricula) == null){ // Usuário não cadastrado
              $user = new User($nome, $matricula, $senha);
              $dao_u->insert($user);
              echo "
                <section class='section'>
                  <div class='container'>
                    <h1 class='title'> Cadastro realizado com sucesso! </h1>
                  </div>
                </section>
              ";
          }else{
              echo "
                <section class='section'>
                  <div class='container'>
                    <h1 class='title'> Usuário ja cadastrado! Faça o login pelo Menu</h1>
                  </div>
                </section>
              ";
          }
      ?>
      <script src="scripts/main_script.js"></script>
  </body>
</html>
