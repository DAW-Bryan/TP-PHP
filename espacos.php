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

            if (isset($_GET["tag"])){

                $dao_e = new EspacoDao();
                $dao_r = new ReservaDao();

                $espacos = $dao->read_by_tipo($_GET["tag"]);
                
                echo '<section class="section">';
                foreach ($espacos as $e){
                    echo '<h2 class="title is-2">'. $e->nome .'</h2>';
                    $reservas = $dao_r->read_by_place($e->nome);
                    print_reservas_por_espaco($reservas);
                }

                echo '</section>';
            }

            /*
            if ($_GET["tag"] == "quadras"){
                $reservas = $dao->read_by_place("Quadra maior");
                echo '<h1 class="title is-2">Quadra maior</h1>';
                print_reservas_por_espaco($reservas);

                $reservas = $dao->read_by_place("Quadra menor");
                echo '<h1 class="title is-2">Quadra menor</h1>';
                print_reservas_por_espaco($reservas);                
            }else if ($_GET["tag"] =="lab"){
                $reservas = $dao->read_by_place("Laboratório de Informática");
                echo '<h1 class="title is-2">Laboratório de Informática</h1>';
                print_reservas_por_espaco($reservas);

                $reservas = $dao->read_by_place("Laboratório de Química");
                echo '<h1 class="title is-2">Laboratório de Química</h1>';
                print_reservas_por_espaco($reservas);                
            }else if ($_GET["tag"] == "salas"){
                $reservas = $dao->read_by_place("Auditório");
                echo '<h1 class="title is-2">Auditório</h1>';
                print_reservas_por_espaco($reservas);
            }
              */  
        ?>

        <p class="control" style="margin-left: 5px">
            <button class="button is-link" id="modal-trigger-e" data-target="modalEspaco">
                <span>
                    Adicionar Espaço
                </span>
            </button>
        </p>

        <!-- Modal para adicionar espaco -->
        <div class="modal" id="modalEspaco">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">Cadastro de usuários</p>
                <button class="delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                <div class="field">
                    <label class="label">Nome</label>
                    <div class="control">
                        <input class="input" type="text" name="EntradaNome" placeholder="Nome do espaço">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Tipo</label>
                    <div class="control">
                        <div class="select">
                            <select name="espaco">
                                <option>Quadras</option>
                                <option>Laboratórios</option>
                                <option>Salas de aula</option>
                            </select>
                        </div>
                    </div>
                </div>

            </section>
            <footer class="modal-card-foot">
                <button class="button is-success">Adicionar</button>
            </footer>
            </div>
        </div>
        
    <!-- Importando os scripts -->
    <?php require "Includes/scripts.inc"; ?>
    <script>
    // modal Espaco
    var modal = document.querySelector('#modalEspaco');
    var trigger = document.querySelector('#modal-trigger-e');
    trigger.addEventListener('click', function(event){
        modal.classList.toggle('is-active');
    });
    
    // Delete Modal
    var del = $(".delete");
    del.click(function() {
        modal.classList.remove("is-active");
    })


    
    </script>


  </body>  
</html>
