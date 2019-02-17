<?php session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Reservas COLTEC</title>

        <link rel="shortcut icon" href="Images/logo.png">

        <!-- Bulma CSS -->
        <link rel="stylesheet" href="./css/bulma.min.css">
        <link rel="stylesheet" href="./css/bulma-tooltip.min.css">

        <!-- Custom CSS -->
        <link rel="stylesheet" href="css/custom.css">

        <!-- Font Awesome -->
        <script defer src="https://use.fontawesome.com/releases/v5.1.0/js/all.js"></script>

        <!-- JQuery -->
        <script src="scripts/jquery.min.js"></script>
  </head>

  <body>

        <!-- Menu navbar -->
        <?php include "Includes/menu.inc"; ?>

        <!-- Enviar email -->
        <?php require "sendEmail.php"; 
            if (isset($_POST["item"]) && isset($_POST["rating"]) && isset($_POST["descricao"]) && isset($_POST["date"]) && isset($_SESSION["login"])){
                $res = sendEmail($_POST["item"], $_POST["descricao"], $_POST["rating"], $_SESSION["login"], $_POST["date"]);

                if(strpos($res, 'sucesso') !== false){
                    echo "<div class='notification is-success'>
                    <h2 class='title'> $res </h1>
                    </div>";
                }else{
                    echo "<div class='notification is-danger'>
                    <h2 class='title'> $res </h1>
                    </div>";
                }
            }
        ?>


        <!-- Reservas -->
        <?php
            include "Includes/reserva.inc";

            if (isset($_GET["tag"])){
                $itens = $dao_i->read_by_categoria($_GET["tag"]);
            }else{
                $itens = $dao_i->read_all();
            }

            if ($itens == null){
                echo "<section class='section'><div class='container'><h2 class='title'>Nenhum item está cadastrado nessa categoria</h2></div></section>";
            }else{
                $count = 0;
                foreach ($itens as $i){

                    echo '<section class="section">';
                    echo '<div class="container">';

                    if (isset($_SESSION["login"])){
                        echo '<h2 class="title"><abbr title="Ver descrição" id="open-details'.$count.'">'. $i->nome .'</abbr>';
                        echo '<a class="button is-link is-pulled-right" id="rating'.$count.'">Avaliar</a>';
                        echo '<div class="control" id="details'.$count.'" style="display: none; margin-top: 10px"><textarea class="textarea custom-textarea" readonly>'.$i->descricao.'</textarea></div></h2>';
                    }else{
                        echo '<h2 class="title">'. $i->nome .'</h2>';
                    }

                    $reservas = $dao_r->read_by_item($i->nome);
                    print_reservas_por_item($reservas);
                    echo '</div>';
                    echo '</section>';
                    $count++;
                }
            }
        ?>
        
        <!-- Modal enviar email -->
        <form action="itens.php" method="post">
        <div class="modal" id="modalDetails">
          <div class="modal-background"></div>
            <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title"></p>
                <button class="deleteDetails delete" aria-label="close"></button>
            </header>
            <section class="modal-card-body">
                
            <div class="field">
                <label class="label">Avaliação</label>
                <div class="control">
                    <label class="radio">
                        <input type="radio" name="rating" value="1">
                        Péssimo
                    </label>
                    <label class="radio">
                        <input type="radio" name="rating" value="2">
                        Ruim
                    </label>
                    <label class="radio">
                        <input type="radio" name="rating" value="3">
                        Bom
                    </label>
                    <label class="radio">
                        <input type="radio" name="rating" value="4">
                        Muito Bom
                    </label>
                    <label class="radio">
                        <input type="radio" name="rating" value="5">
                        Excelente
                    </label>                                   
                </div>
            </div>

            <div class="field">
                <label class="label">Mensagem</label>
                <div class="control">
                    <textarea name="descricao" id="descricao" placeholder="Use este espaço para descrever melhor as condições do item" class="textarea"></textarea>
                </div>
            </div>

            <div class="field">
                <label class="label">Data da reserva</label>
                <div class="control">
                    <input type="date" name="date" id="date" class="input">
                </div>
            </div>
            </section>

            <footer class="modal-card-foot">
                <input type="hidden" id="item" name="item">
                <button type="submit" class="button is-success is-pulled-right">Enviar</a>
            </footer>
            </div>
        </div>
        </form>


        <?php include "Includes/footer.inc"; ?>
    
    <!-- Importando os scripts -->
    <script src="scripts/main_script.js"></script>

    <?php if (isset($_SESSION["login"])){?>
        <script>
        $(document).ready(function(){
            
            // Close Modal
            var del = $(".delete");
            del.click(function() {
                $("#modalDetails").removeClass("is-active");
            });

            <?php 
            if ($itens != null){
                for ($i=0; $i<count($itens); $i++){
                    // Open Modal
                    echo "$('#rating$i').click(function () {
                            $('#modalDetails').addClass('is-active');
                            $('.modal-card-title').text('".$itens[$i]->nome."');
                            $('#item').val('".$itens[$i]->nome."');
                        });";

                    // Dropdown Details
                    echo "$('#open-details$i').click(function (){
                            $('#details$i').toggle();
                        });";
                }
            } ?>
                
        });   
        </script>

    <?php } ?>
  </body>
</html>
