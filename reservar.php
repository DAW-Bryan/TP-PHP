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
  </head>

  <body>

    <?php include "Includes/menu.inc"; ?>

    <section class="section">

      <div class="container">

        <?php
            if (!isset($_SESSION["login"])){
                echo "<h1 class='title'> Você não está logado! </h1>";
                echo "<p>Entre na plataforma para realizar uma reserva</p>";
            }else{
                    require "Includes/reserva.inc";

                    date_default_timezone_set('America/Sao_Paulo');

                    if (isset($_POST["item"])) { // Está na parte de Dados da Reserva

                        if (!isset($_POST["declaracao"])){
                            carrega_reserva(1); // Não aceitou os termos

                        }else if($_POST["data"] == "" || $_POST["inicio"] == "" || $_POST["termino"] == "" || $_POST["nome"] == ""){
                            carrega_reserva(2); // Não preencheu todos os campos

                        }else if (verifica_disponibilidade($_POST["nome"], $_POST["item"], $_POST["tipo-de-reserva"], $_POST["data"], $_POST["inicio"], $_POST["termino"], $_POST["prazo"]) == 0){
                            carrega_reserva(3); // Horário indisponível

                        }else if (verifica_disponibilidade($_POST["nome"], $_POST["item"], $_POST["tipo-de-reserva"], $_POST["data"], $_POST["inicio"], $_POST["termino"], $_POST["prazo"]) == -1){
                            carrega_reserva(4);
                        }else{
                            $item = $dao_i->read_by_nome($_POST["item"]);
                            $reserva = new Reserva($_POST["nome"], $_SESSION["matricula"], $item->id, $_POST["tipo-de-reserva"], $_POST["data"], $_POST["inicio"], $_POST["termino"], $_POST["prazo"]);
                    
                            $dao_r->insert($reserva);
                            echo "<section class='section'>
                              <div class='container'>
                                <h1 class='title'> Reserva realizada com sucesso! </h1>
                              </div>
                            </section>";
                        }

                    }else{ // Primeiro acesso ao site
                        carrega_reserva(0);
                    }
                ?>
                <script>

                    /* Passa todas as categorias e seus itens para variáveis do script */
                    <?php 
                        $categorias = $dao_c->read_all();
                        echo "var all_cats = [];\n";
                        foreach($categorias as $c){
                            echo "var cat = [];\n";
                            echo "cat.push(\"".$c->nome."\");\n";
                            $itens = $dao_i->read_by_categoria($c->nome);
                            if ($itens != null){
                                foreach($itens as $i){
                                    echo "cat.push(\"". $i->nome ."\");\n";
                                }
                            }

                            echo 'all_cats.push(cat);';
                        }
                    ?>



                    /* Controle de itens e categorias */
                    var categorias = $("#categoria");
                    var itens = $("#itens");

                        
                    for (let i=0; i<all_cats.length; i++){
                        if (all_cats[i][0] == $("#categoria option:selected").val()){
                            for (let j=1; j<all_cats[i].length; j++){
                                itens.append($("<option></option>").text(all_cats[i][j]));
                            }
                        }
                    }
                    

                    categorias.change(function() {
                        itens.find('option').remove();
                        for (let i=0; i<all_cats.length; i++){
                            if (all_cats[i][0] == $("#categoria option:selected").val()){
                                for (let j=1; j<all_cats[i].length; j++){
                                    itens.append($("<option></option>").text(all_cats[i][j]));
                                }
                            }
                        }
                    
                    });
                    
                    
                    /* Controle de dia e dia da semana */
                    var dia = new Date();
                            var dd = dia.getDate();
                            var mm = dia.getMonth()+1; // Janeiro = 0
                            var yyyy = dia.getFullYear();
                            if(dd<10){
                                dd='0'+dd;
                            }
                            if(mm<10){
                                mm='0'+mm;
                            }
                            dia = yyyy + '-' + mm + '-' + dd;

                    $("#dia").append('<input class="input" type="date" name="data" id="input-dia" value="' + dia + '">');
                    $('#reservas-form .radio').on('change', function() {
                        $("#input-dia").remove();
                        if ($('input[name=tipo-de-reserva]:checked', 'form').val() == "Diaria"){ // Dia único
                            $("#dia").append('<input class="input" type="date" name="data" id="input-dia" value="' + dia + '">');
                            $("#prazo").empty();
                            $("#prazo").append('<input type="hidden" name="prazo" value="0">');
                        }else if ($('input[name=tipo-de-reserva]:checked', 'form').val() == "Semanal"){ // Semanal
                            $("#dia").append('<select name="data" id="input-dia" class="input">'
                                + '<option value="1">Segunda</option>'
                                + '<option value="2">Terça</option>'
                                + '<option value="3">Quarta</option>'
                                + '<option value="4">Quinta</option>'
                                + '<option value="5">Sexta</option>'
                                + '<option value="6">Sábado</option>'
                            + '</select>');

                            $("#prazo").empty();
                            $("#prazo").append('<label for="">Válido até</label>' 
                            + '<select name="prazo" id="input-prazo" class="input">'
                                + '<option value="1">Janeiro</option>'
                                + '<option value="2">Fevereiro</option>'
                                + '<option value="3">Março</option>'
                                + '<option value="4">Abril</option>'
                                + '<option value="5">Maio</option>'
                                + '<option value="6">Junho</option>'
                                + '<option value="7">Julho</option>'
                                + '<option value="8">Agosto</option>'
                                + '<option value="9">Setembro</option>'
                                + '<option value="10">Outrubro</option>'
                                + '<option value="11">Novembro</option>'
                                + '<option value="12">Dezembro</option>'
                            + '</select>'
                            );

                            var children = $("#input-prazo").children();

                            for (i=1; i<mm; i++){
                                children[i-1].remove();
                            }

                            $(children[i-1]).text("Final desse mês");
                        }

                    }); 

                </script>

            <?php } ?>
        </div>
    </section>

            <?php include "Includes/footer.inc"; ?>

            <script src="scripts/main_script.js"></script>
  </body>
</html>
