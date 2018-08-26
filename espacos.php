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
        <?php include "Includes/menu.inc"; ?>


        <!-- Reservas -->
        <?php
            include "Models/Reserva.php";
            include "Models/ReservaDao.php";
            include "Includes/reserva.inc";
        
            include "Models/Espaco.php";
            include "Models/EspacoDao.php";

            $dao_e = new EspacoDao();

            if (isset($_POST["addEspaco"]) && $_POST["nome"] != ""){
                $tipo = null;
                if ($_POST["tipo_espaco"] == "Quadras"){
                    $tipo = "quadras";
                } else if ($_POST["tipo_espaco"] == "Salas de aula"){
                    $tipo = "salas";   
                } else {
                    $tipo = "lab";
                }

                $espaco = new Espaco($_POST["nome"], $tipo);
                $dao_e->insert($espaco);
            }else if (isset($_POST["delEspaco"])){
                $espacos = $dao_e->read_all();
                $dao_e->delete($espacos[$_POST["delEspacoPos"]]);
            }


            if (isset($_GET["tag"])){

                $dao_r = new ReservaDao();

                $espacos = $dao_e->read_by_tipo($_GET["tag"]);
                
                echo '<section class="section">';
                foreach ($espacos as $e){
                    echo '<h2 class="title is-2">'. $e->nome .'</h2>';
                    $reservas = $dao_r->read_by_place($e->nome);
                    print_reservas_por_espaco($reservas);
                }

                echo '</section>';
            }
        ?>

        <p class="control" style="margin-left: 5px">
            <button class="button is-link" id="modal-trigger-e" data-target="modalEspaco">
                <span>
                    Adicionar Espaço
                </span>
            </button>
            <button class="button is-link" id="modal-trigger-del" data-target="modalDelEspaco">
                <span>
                    Deletar Espaço
                </span>
            </button>
        </p>

        

        <!-- Modal para adicionar espaco -->
        <form action="espacos.php" method="post">

        <div class="modal" id="modalEspaco">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Adicionar Espaço</p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="nome" placeholder="Nome do espaço">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Tipo</label>
                    <div class="control">
                        <div class="select">
                            <select name="tipo_espaco">
                                <option>Quadras</option>
                                <option>Laboratórios</option>
                                <option>Salas de aula</option>
                            </select>
                        </div>
                    </div>
                </div>

            </section>
            <footer class="modal-card-foot">
                <input type="hidden" id="addEspaco" name="addEspaco" value="true">
                <input class="button is-success" type="submit" value="Adicionar">
            </footer>
            </div>
        </div>

        </form>


        <form action="espacos.php" method="post">
        <!-- Modal deletar espaco -->
        <div class="modal" id="modalDelEspaco">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Deletar espaços</p>
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
                $espacos = $dao_e->read_all();
                if ($espacos != null){
                    $i = 0;
                    foreach ( $espacos as $e ) {
                        echo '<tr>';
                        echo '<td>'. $e->nome .'</div>';
                        echo '<td class="has-text-centered"><button type="submit" name="delEspacoPos" value="'. $i . '" class="delete has-background-danger"></button></td>"';
                        echo '</tr>';
                        $i++;
                    }
                }
                echo '</tbody></table>';
                
                ?>
                <input type="hidden" id="delEspaco" name="delEspaco" value="true">
            </section>
            </div>
        </div>

        </form>
        
        
    <!-- Importando os scripts -->
    <?php require "Includes/scripts.inc"; ?>
    <script>
    // modal Adiciona Espaco
    var modal = document.querySelector('#modalEspaco');
    var trigger = document.querySelector('#modal-trigger-e');
    trigger.addEventListener('click', function(event){
        modal.classList.toggle('is-active');
    });
    
    // modal Deleta Espaco

    var modalDel = document.querySelector('#modalDelEspaco');
    var triggerDel = document.querySelector('#modal-trigger-del');
    triggerDel.addEventListener('click', function(event){
        modalDel.classList.toggle('is-active');
    });

    // Delete Modal
    var del = $(".delete");
    del.click(function() {
        modal.classList.remove("is-active");
    })

    var delModal = $(".deleteModal");
    del.click(function() {
        modalDel.classList.remove("is-active");
    })
    </script>
  </body> 
</html>