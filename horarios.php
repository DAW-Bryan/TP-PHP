
<?php /*
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

    <?php 
        include "Includes/menu.inc";
        include "Includes/reserva.inc";
    
        $salas = $dao_i->read_by_categoria("Salas de Aula");

        if ($salas != null){
            $i = 0;
            foreach($salas as $s){
                $reservas = $dao_r->read_by_item($s->nome);
                if ($reservas != null){
                    echo '<a class="button is-link sala download" download="'. $s->nome .'.csv">'. $s->nome .'</a>'; 
                    
                    echo "<script>let csvContent = \"data:text/csv;charset=utf-8,\uFEFF\";\n";
                    
                    // Adiciona primeira row //
                    echo "var row = '$s->nome, Segunda, Terça, Quarta, Quinta, Sexta, Sábado';";
                    echo 'csvContent += row.toString() + "\r\n";';

                    usort($reservas, function($a, $b)
                    {
                        return strcmp($a->inicio, $b->inicio);
                    });

                    // Adiciona uma row por reserva //
                    foreach($reservas as $r){
                        if ($r->tipo_de_reserva == "Semanal"){
                            $ini = substr($r->inicio, 0, 5);
                            $fim = substr($r->fim, 0, 5);
                            echo "row = []; row[0] = \"$ini-$fim\";\n";
                            echo "row[$r->data] = \"$r->nome\";\n";
                            echo 'csvContent += row.toString() + "\r\n";';
                            echo "var encodedUri = encodeURI(csvContent);\n";
                            
                            echo "$(\".download\")[0].setAttribute(\"href\", encodedUri);";
                        }
                    }

                    echo '</script>';
                }
                $i++;
            }
        }
    ?>

    <?php include "Includes/footer.inc"; ?>
    

    
    <script>
    const salas = $(".sala").toArray();


        const rows = [["13:30:00-17:10:00", "Bernardo"]]; //[["name1", "city1", "some other info"], ["name2", "city2", "more info"]];
        csvContent = "data:text/csv;charset=utf-8,";
        rows.forEach(function(rowArray){
            let row = rowArray.join(",");
            csvContent += row + "\r\n";
        }); 

        encodedUri = encodeURI(csvContent);
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "my_data.csv");
        document.body.appendChild(link); // Required for FF
        //link.click();
    
    </script>

    <!-- Importando os scripts -->
    <script src="scripts/main_script.js"></script>

  </body>
</html>
*/ ?>