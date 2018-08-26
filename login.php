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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>

    <?php

    session_start();

    $matricula  = $_POST["matricula"];
    $senha      = $_POST["senha"];

    // Lendo os dados do arquivo json
    $arquivo_str = file_get_contents("Arquivos/usuarios.json");
    $usuarios = json_decode($arquivo_str);

    // Verificando se existe o usuário
    foreach ($usuarios as $user) {

        if (strcmp($user->matricula, $matricula) == 0) {

            // Verifica se a senha está correta
            if (strcmp($user->senha, $senha) == 0) {

              $_SESSION["login"] = $user->nome;
              $_SESSION["matricula"] = $matricula;
              $_SESSION["senha"] = $senha;

              // Redireciona para a homepage logado
              header("location:index.php");

            }

            // Senha incorreta
            else {
              echo "<div class='container'> <h1 class='title'> Senha incorreta! </h1> </div>";
              break;
            }
        }
    }

    include "Includes/menu.inc";
    echo "<section class='section'>
            <div class='container'>
              <h1 class='title'> Usuário não cadastrado! </h1>
            </div>
          </section>";

    ?>
  </body>
</html>
