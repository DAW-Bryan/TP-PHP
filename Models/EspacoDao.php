<?php
    class EspacoDao{

        // Escrita //
        function insert($espaco){
            $espacoJSON = json_encode($espaco);
            $ArquivoJSON = file_get_contents("Arquivos/espacos.json");
            if($ArquivoJSON == "[]"){ // Nenhum usuario cadastrado
                $ArquivoJSON = str_replace("[", "[".$espacoJSON, $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace("[", "[".$espacoJSON.",", $ArquivoJSON);
            }

            $file = fopen("Arquivos/espacos.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file); 
        }
        
        function delete($espaco){
            $ArquivoJSON = file_get_contents("Arquivos/espacos.json");
            $espacoJSON = json_encode($espaco);
            
            if (strpos($ArquivoJSON, "[".$reservaJSON."]") !== false){ // Nenhum usuario cadastrado
                $ArquivoJSON = str_replace($espacoJSON, "", $ArquivoJSON);
            }else if(strpos($ArquivoJSON, "[".$espacoJSON) !== false){ // É a primeira reserva
                $ArquivoJSON = str_replace($espacoJSON . ",", "", $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace(",".$espacoJSON, "", $ArquivoJSON);
            }

            $file = fopen("Arquivos/espacos.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file); 
        }


        // Leitura //
        function read_all(){
            return json_decode(file_get_contents("Arquivos/reservas.json"));            
        }


        function read_by_tipo($tipo){
            $espacos = null;
            $todas_espacos = json_decode(file_get_contents("Arquivos/reservas.json"));
            foreach ( $todas_espacos as $e ) {
                if ($e->tipo == $tipo){
                    $espacos[] = new Espaco($e->nome, $e->tipo);
                }
            }
            return $espacos;
        }
    }
?>