<?php session_start(); ?>
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
        <script src="scripts/jquery.min.js"></script>

        <style>
            .button{
                margin-bottom: 10px !important;
            }
        </style>

  </head>

  <body>
        <!-- Menu navbar -->
        <?php
        if (!isset($_SESSION["root"])){
            header("location:index.php");
        }else{
            include "Includes/menu.inc";
            include "Includes/reserva.inc";

            /*if (isset($_POST["addCat"]) && $_POST["nome"] != ""){ // Adicionou categoria
                $cat = new Categoria($_POST["nome"]);
                $dao_c->insert($cat);
            */
            if(isset($_POST["delCat"]) && isset($_POST["delCatPos"])){ // Deletou categoria
                $cats = $dao_c->read_all();
                unlink($cats[$_POST["delCatPos"]]->imagem);
                $dao_c->delete($cats[$_POST["delCatPos"]]);

            }else if (isset($_POST["addItem"]) && $_POST["nome"] != ""){ // Adicionou Item
                $categoria = $dao_c->read_by_name($_POST["tipo_item"]);
                $item = new Item($_POST["nome"], $categoria->id);
                $dao_i->insert($item);

            }else if (isset($_POST["delItem"]) && isset($_POST["delItemPos"])){ // Deletou Item
                $itens = $dao_i->read_all();
                $dao_i->delete($itens[$_POST["delItemPos"]]);

            }else if (isset($_POST["delReserva"]) && isset($_POST["reserva"])){ // Deletou Reserva
                $reservas = $dao_r->read_all();
                $dao_r->delete($reservas[$_POST["reserva"]]);

            }else if(isset($_POST["addAdm"]) && isset($_POST["user"])){ // Adicionou admim
                $usuarios = $dao_u->read_non_admin();
                $pos = $_POST["user"];
                $dao_u->give_adm($usuarios[$pos]);
            }
        ?>

        <section class="section">
          <div class="container">
            <h1 class="title"> Funções de administrador </h1>
            <span class="control" style="margin-left: 5px">

            <button class="button is-link" id="modal-trigger-cat" data-target="modalCat">
                <span>
                    Adicionar Categoria
                </span>
            </button>
            <button class="button is-link" id="modal-trigger-delcat" data-target="modalDelCat">
                <span>
                    Deletar Categoria
                </span>
            </button>

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

              <button class="button is-link" id="modal-trigger-caduser" data-target="modalGiveAdm">
                  <span>
                      Cadastrar Usuário
                  </span>
              </button>
          </span>
          </div>
        </section>


        <!-- Modal para adicionar categoria -->
        <form action="upload.php" method="post" enctype="multipart/form-data">

        <div class="modal" id="modalCat">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Adicionar Categoria</p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="nome" placeholder="Nome da categoria">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Imagem</label>
                    <div class="control">
                        <input type="file" name="fileToUpload" id="fileToUpload">
                    </div>
                </div>
            </section>
            <footer class="modal-card-foot">
                <input type="hidden" id="addCat" name="addCat" value="true">
                <input class="button is-success" type="submit" value="Adicionar">
            </footer>
            </div>
        </div>

        </form>

        <!-- Modal deletar categoria -->
        <form action="admin.php" method="post">
        <div class="modal" id="modalDelCat">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Deletar categorias</p>
                <button class="delete" aria-label="close"></button>
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
                $categorias = $dao_c->read_all();
                if ($categorias != null){
                    $i = 0;
                    foreach ( $categorias as $c ) {
                        echo '<tr>';
                        echo '<td>'. $c->nome .'</div>';
                        echo '<td class="has-text-centered"><button type="submit" name="delCatPos" value="'. $i . '" class="delete has-background-danger"></button></td>';
                        echo '</tr>';
                        $i++;
                    }
                }
                echo '</tbody></table>';

                ?>
                <input type="hidden" id="delCat" name="delCat" value="true">
            </section>
            </div>
        </div>

        </form>

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
                            <?php
                                $categorias = $dao_c->read_all();
                                foreach ($categorias as $c){
                                    echo "<option>". $c->nome ."</option>";
                                }
                            ?>
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
                <button class="delete" aria-label="close"></button>
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
                $itens = $dao_i->read_all();
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
                <button class="delete" aria-label="close"></button>
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
                if ($reservas != null){
                    $i = 0;
                    foreach ( $reservas as $r ) {
                        $item = $dao_i->read_by_id($r->item_id);
                        echo '<tr>';
                        echo '<td>'. $item->nome .'</td>';

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
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
            <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Matrícula</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $usuarios = $dao_u->read_non_admin();
                    $i=0;
                    if ($usuarios != null){
                        foreach ($usuarios as $user) {
                                echo '<tr>';
                                echo '<td>'. $user->nome .'</td>';
                                echo '<td>'. $user->matricula .'</td>';
                                echo '<td class="has-text-centered"><button type="submit" name="user" value="'. $i . '" class="button is-link">Dar adm</button></td>';
                                echo '</tr>';
                            $i++;
                        }
                    }
                    echo '</tbody></table>';
                ?>
                <input type="hidden" name="addAdm" value="true">
            </section>
            </div>
        </div>
    </form>

        <!-- Modal para cadastro de usuário -->
        <form method="post" action="autentica_cadastro.php">
          <div class="modal" id="modalCadUser">
            <div class="modal-background"></div>
          <div class="modal-card">
            <header class="modal-card-head">
              <p class="modal-card-title">Cadastro de usuários</p>
             <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
              <div class="field">
                  <label class="label">Nome Completo</label>
                  <div class="control has-icons-left">
                      <input class="input" type="text" name="EntradaNome" placeholder="Digite o nome completo" required>
                      <span class="icon is-small is-left">
                          <i class="fas fa-user"></i>
                      </span>
                  </div>
              </div>

              <div class="field">
                  <label class="label">Número de Matrícula</label>
                  <div class="control has-icons-left">
                      <input class="input" type="number" name="EntradaMatricula" placeholder="Digite o número de matrícula" required>
                      <span class="icon is-small is-left">
                          <i class="fas fa-id-card"></i>
                      </span>
                  </div>
              </div>

              <div class="field">
                  <label class="label">Senha</label>
                  <div class="control has-icons-left">
                      <input class="input" type="password" placeholder="Digite a senha" name="EntradaSenha" required>
                      <span class="icon is-small is-left">
                          <i class="fas fa-key"></i>
                      </span>
                  </div>
              </div>

            </section>
            <footer class="modal-card-foot">
              <button class="button is-success" type="submit">Finalizar cadastro</button>
            </footer>
          </div>
        </div>
      </form>
    <?php } ?>

    <?php include "Includes/footer.inc"; ?>
    <!-- Importando os scripts -->
    <script src="scripts/main_script.js"></script>
  </body>
</html>
