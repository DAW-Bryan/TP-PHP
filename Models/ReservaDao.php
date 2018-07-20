<?php
    class ReservaDao{

        function read_by_place($espaco){
            $reservas;
            $todas_reservas = json_decode(file_get_contents("Arquivos/reservas.json"));
            foreach ( $todas_reservas as $r ) {
                if ($r->espaco == $espaco){
                    $reservas[] = new Reserva($r->matricula, $r->espaco, $r->tipo_de_reserva, $r->data, $r->inicio, $r->fim);
                }
            }
            return $reservas;
        }

        function insert($reserva){
            $reservaJSON = json_encode($reserva);
            $ArquivoJSON = file_get_contents("Arquivos/reservas.json");
            if($ArquivoJSON == "[]"){ // Nenhum usuario cadastrado
                $ArquivoJSON = str_replace("[", "[".$reservaJSON, $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace("[", "[".$reservaJSON.",", $ArquivoJSON);
            }

            $file = fopen("Arquivos/reservas.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file); 
        }

    }

?>