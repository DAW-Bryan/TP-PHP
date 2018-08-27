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

    <!-- Menu navbar -->
    <?php include "Includes/menu.inc"; ?>

      <?php

          //essa função evita cadastros com mesmo usuario
          function verificaCadastro($matricula, $email){
              $arquivo_str = file_get_contents("Arquivos/usuarios.json");

              $usuarios = json_decode($arquivo_str);

              foreach ($usuarios as $valor) {
                  if (($valor->matricula == $matricula) and (strcmp($valor->email, $emaill) == 0)) { //dando errado **************
                      return false;
                  }
              }
              return true;
          }

          //adiciona o usuario no arquivo .json
          function adicionaUsuario($matricula, $senha, $nome, $email) {
              $usuarioAtual = array(
                  "matricula"=>$matricula,
                  "senha"=>$senha,
                  "nome"=>$nome,
                  "email"=>$email
              );

              $usuarioAtual_str = json_encode($usuarioAtual);

              //retira o colchete e coloca a vírgula no arquivo
              $arquivo_str = file_get_contents("Arquivos/usuarios.json");
              $arquivo_str_novo = str_replace("]", ",", $arquivo_str);

              //abre o arquivo
              $usuarios = fopen("Arquivos/usuarios.json", "w"); //sobreescreve
              fwrite($usuarios, $arquivo_str_novo . $usuarioAtual_str . "]");
              fclose($usuarios);
          }

          $matricula = $_POST["EntradaMatricula"];
          $senha = $_POST["EntradaSenha"];
          $nome = $_POST["EntradaNome"];
          $email = $_POST["EntradaEmail"];

          $resultadoVerificacao = verificaCadastro($matricula, $senha);

          if ($resultadoVerificacao == true) {
              adicionaUsuario($matricula, $senha, $nome, $email);
              //header("location:index.php");
              echo "
                <section class='section'>
                  <div class='container'>
                    <h1 class='title'> Cadastro realizado com sucesso! </h1>
                    <h2 class='subtitle'> Faça o login para fazer uma reserva </h2>
                  </div>
                </section>
              ";
          }
          elseif ($resultadoVerificacao == false) {
              //header("location:cadastrar.php");
              echo "
                <section class='section'>
                  <div class='container'>
                    <h1 class='title'> Usuário ja cadastrado! Faça o login pelo Menu</h1>
                  </div>
                </section>
              ";
          }

          include "Includes/scripts.inc";
      ?>
  </body>
</html>
