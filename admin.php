<?php session_start(); ?>
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  </head>

  <body>

        <!-- Menu navbar -->
        <?php
        if (!isset($_SESSION["root"])){
            header("location:index.php");
        }else{
            include "Includes/menu.inc";
            include "Includes/reserva.inc";
            include "Controllers/ItemDao.php";

            $dao_e = new ItemDao();
            $dao_r = new ReservaDao();

            if (isset($_POST["addItem"]) && $_POST["nome"] != ""){ // Adicionou Item
                $tipo = null;
                if ($_POST["tipo_item"] == "Quadras"){
                    $tipo = "quadras";
                } else if ($_POST["tipo_item"] == "Salas de aula"){
                    $tipo = "salas";
                } else {
                    $tipo = "lab";
                }

                $item = new Item($_POST["nome"], $tipo);
                $dao_e->insert($item);
            }else if (isset($_POST["delItem"])){ // Deletou Item
                $itens = $dao_e->read_all();
                $dao_e->delete($itens[$_POST["delItemPos"]]);
            }else if (isset($_POST["delReserva"])){ // Deletou Reserva
                $reservas = $dao_r->read_all();
                $dao_r->delete($reservas[$_POST["reserva"]]);
            }else if(isset($_POST["addAdm"])){
                $usuarios = json_decode(file_get_contents("Arquivos/usuarios.json"));
                $pos = $_POST["user"];
                $usuarioAtual = array(
                    "matricula"=>$usuarios[$pos]->matricula,
                    "senha"=>$usuarios[$pos]->senha,
                    "nome"=>$usuarios[$pos]->nome,
                    "tipo"=>"root",
                    "email"=>$usuarios[$pos]->email
                );

                $usuarioSemAdm_str = json_encode($usuarios[$pos]);
                $usuarioAtual_str = json_encode($usuarioAtual);

                //retira o colchete e coloca a vírgula no arquivo
                $ArquivoJSON = file_get_contents("Arquivos/usuarios.json");
                $ArquivoJSON = str_replace($usuarioSemAdm_str, $usuarioAtual_str, $ArquivoJSON); //Substitui User antigo por User com adm

                //abre o arquivo
                $usuarios = fopen("Arquivos/usuarios.json", "w"); //sobreescreve
                fwrite($usuarios, $ArquivoJSON);
                fclose($usuarios);
            }
        ?>

        <section class="section">
          <div class="container">
            <h1 class="title"> Funções de administrador </h1>
            <p class="control" style="margin-left: 5px">
              <button class="button is-link" id="modal-trigger-e" data-target="modalItem">
                  <span>
                      Adicionar Item
                  </span>
              </button>
              <button class="button is-link" id="modal-trigger-del" data-target="modalDelItem">
                  <span>
                      Deletar Item
                  </span>
              </button>
              <a href="reservar.php" class="button is-link">
                  <span>
                      Adicionar Reserva
                  </span>
              </a>
              <button class="button is-link" id="modal-trigger-del-reserva" data-target="modalDelReserva">
                  <span>
                      Deletar Reserva
                  </span>
              </button>

              <button class="button is-link" id="modal-trigger-adm" data-target="modalGiveAdm">
                  <span>
                      Adicionar Administrador
                  </span>
              </button>
            </p>
          </div>
        </section>



        <!-- Modal para adicionar item -->
        <form action="admin.php" method="post">

        <div class="modal" id="modalItem">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Adicionar Item</p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="nome" placeholder="Nome do item">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Tipo</label>
                    <div class="control">
                        <div class="select">
                            <select name="tipo_item">
                                <option>Quadras</option>
                                <option>Laboratórios</option>
                                <option>Salas de aula</option>
                            </select>
                        </div>
                    </div>
                </div>

            </section>
            <footer class="modal-card-foot">
                <input type="hidden" id="addItem" name="addItem" value="true">
                <input class="button is-success" type="submit" value="Adicionar">
            </footer>
            </div>
        </div>

        </form>

        <!-- Modal deletar item -->

        <form action="admin.php" method="post">
        <div class="modal" id="modalDelItem">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Deletar itens</p>
                <button class="delete deleteModal" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <table class="table is-hoverable is-fullwidth">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th class="has-text-centered">Deletar</th>
                        </tr>
                    </thead>
                    <tbody>
                <?php
                $itens = $dao_e->read_all();
                if ($itens != null){
                    $i = 0;
                    foreach ( $itens as $e ) {
                        echo '<tr>';
                        echo '<td>'. $e->nome .'</div>';
                        echo '<td class="has-text-centered"><button type="submit" name="delItemPos" value="'. $i . '" class="delete has-background-danger"></button></td>';
                        echo '</tr>';
                        $i++;
                    }
                }
                echo '</tbody></table>';

                ?>
                <input type="hidden" id="delItem" name="delItem" value="true">
            </section>
            </div>
        </div>

        </form>

    <!-- Modal para deletar Reserva -->

    <form action="admin.php" method="post">
        <div class="modal" id="modalDelReserva">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Deletar reserva</p>
                <button class="delete deleteModalReseva" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
            <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Data/Dia</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th class="has-text-centered">Deletar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reservas = $dao_r->read_all();
                $i = 0;
                foreach ( $reservas as $r ) {
                    echo '<tr>';
                    echo '<td>'. $r->item .'</td>';

                    if ($r->tipo_de_reserva == "Semanal"){
                        $r->data = convert_num_to_weekday($r->data);
                    }

                    echo '<td>'. $r->data .'</td>';
                    echo '<td>'. $r->inicio .'</td>';
                    echo '<td>'. $r->fim .'</td>';
                    echo '<td class="has-text-centered"><button type="submit" name="reserva" value="'. $i . '" class="delete has-background-danger"></button></td>';
                    echo '</tr>';
                    $i++;
                }
                echo '</tbody></table>';

                ?>
                <input type="hidden" id="delReserva" name="delReserva" value="true">
            </section>
            </div>
        </div>
    </form>


    <!-- Modal para dar adm -->

    <form action="admin.php" method="post">
        <div class="modal" id="modalGiveAdm">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Adicionar administrador</p>
                <button class="delete deleteModalAdm" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
            <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matrícula</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $arquivo_str = file_get_contents("Arquivos/usuarios.json");
                    $usuarios = json_decode($arquivo_str);
                    $i=0;
                    foreach ($usuarios as $user) {
                        if (!isset($user->tipo)) {
                            echo '<tr>';
                            echo '<td>'. $user->nome .'</td>';
                            echo '<td>'. $user->matricula .'</td>';
                            echo '<td>'. $user->email .'</td>';
                            echo '<td class="has-text-centered"><button type="submit" name="user" value="'. $i . '" class="button is-link">Dar adm</button></td>';
                            echo '</tr>';
                        }
                        $i++;
                    }
                    echo '</tbody></table>';
                ?>
                <input type="hidden" name="addAdm" value="true">
            </section>
            </div>
        </div>
    </form>

    <script>
        // modal Adiciona Item
        var modal = document.querySelector('#modalItem');
        var trigger = document.querySelector('#modal-trigger-e');
        trigger.addEventListener('click', function(event){
            modal.classList.toggle('is-active');
        });

        // modal Deleta Item

        var modalDel = document.querySelector('#modalDelItem');
        var triggerDel = document.querySelector('#modal-trigger-del');
        triggerDel.addEventListener('click', function(event){
            modalDel.classList.toggle('is-active');
        });


        // modal Deleta Reserva

        var modalDelReserva = document.querySelector('#modalDelReserva');
        var triggerDelReserva = document.querySelector('#modal-trigger-del-reserva');
        triggerDelReserva.addEventListener('click', function(event){
            modalDelReserva.classList.toggle('is-active');
        });


        // modal Adiciona Adm

        var modalGiveAdm = document.querySelector('#modalGiveAdm');
        var triggerAdm = document.querySelector('#modal-trigger-adm');
        triggerAdm.addEventListener('click', function(event){
            modalGiveAdm.classList.toggle('is-active');
        });



        // Delete Modal
        var del = $(".delete");
        del.click(function() {
            modal.classList.remove("is-active");
        })

        var delModal = $(".deleteModal");
        delModal.click(function() {
            modalDel.classList.remove("is-active");
        })

        var delModalReserva = $(".deleteModal");
        delModalReserva.click(function() {
            modalDelReserva.classList.remove("is-active");
        })


        var delModalAdm = $(".deleteModalAdm");
        delModalAdm.click(function() {
            modalGiveAdm.classList.remove("is-active");
        })
        </script>

    <!-- Importando os scripts -->
    <?php
        }
        require "Includes/scripts.inc";
    ?>
  </body>
</html>
