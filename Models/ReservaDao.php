<?php
    class ReservaDao{

        // Escrita //
        function insert($reserva){
            $reservaJSON = json_encode($reserva);
            $ArquivoJSON = file_get_contents("Arquivos/reservas.json");
            if(!strcmp($ArquivoJSON, "[]")){ // Nenhuma reserva cadastrada
                $ArquivoJSON = str_replace("[", "[".$reservaJSON, $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace("[", "[".$reservaJSON.",", $ArquivoJSON);
            }

            $file = fopen("Arquivos/reservas.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file);
        }

        function deleta_antigas(){
            $reservas = null;
            $todas_reservas = json_decode(file_get_contents("Arquivos/reservas.json"));
            foreach ( $todas_reservas as $r ) {
                if (strtotime($r->data) < strtotime(date('Y-m-d')) && $r->tipo_de_reserva != "Semanal"){
                    $this->delete($r);
                }
            }
        }

        function delete($reserva){
            $ArquivoJSON = file_get_contents("Arquivos/reservas.json");
            $reservaJSON = json_encode($reserva);

            if (strpos($ArquivoJSON, "[".$reservaJSON."]") !== false){ // Nenhuma reserva cadastrada
                $ArquivoJSON = str_replace($reservaJSON, "", $ArquivoJSON);
            }else if(strpos($ArquivoJSON, "[".$reservaJSON) !== false){ // É a primeira reserva
                $ArquivoJSON = str_replace($reservaJSON . ",", "", $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace(",".$reservaJSON, "", $ArquivoJSON);
            }

            $file = fopen("Arquivos/reservas.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file);
        }


        // Leitura //
        function read_all(){
            return json_decode(file_get_contents("Arquivos/reservas.json"));
        }


        function read_by_place($espaco){
            $reservas = null;
            $todas_reservas = json_decode(file_get_contents("Arquivos/reservas.json"));
            foreach ( $todas_reservas as $r ) {
                if ($r->espaco == $espaco){
                    $reservas[] = new Reserva($r->nome, $r->matricula, $r->espaco, $r->tipo_de_reserva, $r->data, $r->inicio, $r->fim);
                }
            }
            return $reservas;
        }

        function read_by_matricula($matricula){
            $reservas = null;
            $todas_reservas = json_decode(file_get_contents("Arquivos/reservas.json"));
            foreach ( $todas_reservas as $r ) {
                if ($r->matricula == $matricula){
                    $reservas[] = new Reserva($r->nome, $r->matricula, $r->espaco, $r->tipo_de_reserva, $r->data, $r->inicio, $r->fim);
                }
            }
            return $reservas;
        }

        function read_by_date($data){
            $reservas = [];
            $todas_reservas = json_decode(file_get_contents("Arquivos/reservas.json"));
            foreach ( $todas_reservas as $r ) {
                if ($r->tipo_de_reserva == "Diária"){
                    if ($data == $r->data){
                        $reservas[] = new Reserva($r->nome, $r->matricula, $r->espaco, $r->tipo_de_reserva, $r->data, $r->inicio, $r->fim);
                    }
                }else{ // tipo_de_reserva == semanal
                    if (date('w', strtotime($data)) == $r->data){
                        $reservas[] = new Reserva($r->nome, $r->matricula, $r->espaco, $r->tipo_de_reserva, $r->data, $r->inicio, $r->fim);
                    }
                }
            }
            return $reservas;
        }
    }

?>
