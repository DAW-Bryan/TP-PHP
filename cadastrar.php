<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="./css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <title>Cadastro</title>
</head>
<body>

    <?php include "Includes/menu.inc"; ?>

    <form action="autentica_cadastro.php" class="container" method="POST">            
        <h1 class="title">Dados Pessoais</h1>

        <div class="field">
            <label class="label">Nome Completo</label>
            <div class="control">
                <input class="input" type="text" name="EntradaNome" placeholder="Seu nome completo">
            </div>
        </div>
          
        <div class="field">
            <label class="label">Email</label>
            <div class="control has-icons-left">
                <input class="input" type="email"  name="EntradaEmail"placeholder="Seu email">
                <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                </span>
            </div>
        </div>
          
        <div class="field">
            <label class="label">Número de Matrícula</label>
            <div class="control">
                <input class="input" type="number" name="EntradaMatricula" placeholder="Sua Matrícula">
            </div>
        </div>

        <div class="field">
            <label class="label">Senha</label>
            <div class="control">
                <input class="input" type="password" id="senha1" placeholder="Digite a senha" name="EntradaSenha" onchange="validaSenha()">
            </div>
        </div>

        <div class="field">
            <label class="label">Repita a senha</label>
            <div class="control">
                <input class="input" type="password" id="senha2" placeholder="Digite a senha" onchange="validaSenha()">
            </div>
        </div>
          
        <div class="field is-grouped">
            <div class="label">
                <button class="button is-link" id="botaoCadastro" disabled>Cadastrar</button>
            </div>
        </div>
    </form>

    <script>
        function validaSenha() {
            var senha1 = document.getElementById("senha1").value;
            var senha2 = document.getElementById("senha2").value;

            console.log(senha1);

            if ((senha1 === senha2) && (senha1 != ""))  {
                $("#botaoCadastro").prop("disabled", false);
            }
            else{
                $("#botaoCadastro").prop("disabled", true);
            }
        }
    </script>

</body>
</html>