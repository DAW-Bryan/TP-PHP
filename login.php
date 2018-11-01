<?php
    session_start();
    $matricula  = $_POST["matricula"];
    $senha      = $_POST["senha"];

    // Lendo os dados do banco
    include 'Includes/reserva.inc';

    $user = $dao_u->read_by_id($matricula); // Verificando se existe o usuário

    if ($user != null){
        if (strcmp($user->senha, $senha) == 0) { // Verifica se a senha está correta

          $_SESSION["login"] = $user->nome;
          $_SESSION["matricula"] = $matricula;
          $_SESSION["senha"] = $senha;

          if ($user->admin){
            $_SESSION["root"] = "true";
          }

          // Redireciona para a homepage logado
          header("location:index.php");

        }

        // Senha incorreta
        else {
          $user_nao_existe = false;
        }
    }
?>
    <!DOCTYPE html>
    <html lang="en">
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
            <?php
                include "Includes/menu.inc";

                if (!isset($user_nao_existe)) {
                    echo " <div class='notification is-danger'>
                            <h1 class='title'> Usuário não cadastrado! </h1>
                           </div>";
                }else{

                    echo " <div class='notification is-danger'>
                              <h1 class='title'> Senha incorreta! </h1>
                           </div>";
                }
            ?>

            <?php include "Includes/footer.inc"; ?>
            <!-- Importando os scripts -->
            <script src="scripts/main_script.js"></script>
    </body>
</html>
