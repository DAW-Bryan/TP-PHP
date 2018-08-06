<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Autenticação</title>
</head>
<body>
    <?php

        //essa função evita cadastros com mesmo usuario
        function verificaCadastro($matricula, $email){
            $arquivo_str = file_get_contents("Arquivos/usuarios.json");

            $usuarios = json_decode($arquivo_str);

            foreach ($usuarios as $valor) {
                if (($valor->matricula == $matricula) || ($valor->email == $emaill)) { //dando errado **************
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
            echo "certo";
        }
        elseif ($resultadoVerificacao == false) {
            //header("location:cadastrar.php");
            echo "erro";
        }

    ?>
</body>
</html>