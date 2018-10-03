<?php
    require "Models/Item.php";

    class ItemDao{

        // Escrita //
        function insert($item){
            $itemJSON = json_encode($item);
            $ArquivoJSON = file_get_contents("Arquivos/itens.json");
            if(!strcmp($ArquivoJSON, "[]")){ // Nenhum usuario cadastrado
                $ArquivoJSON = str_replace("[", "[".$itemJSON, $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace("[", "[".$itemJSON.",", $ArquivoJSON);
            }

            $file = fopen("Arquivos/itens.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file);
        }

        function delete($item){
            $ArquivoJSON = file_get_contents("Arquivos/itens.json");
            $itemJSON = json_encode($item);

            if (strpos($ArquivoJSON, "[".$itemJSON."]") !== false){ // Nenhum item cadastrado
                $ArquivoJSON = str_replace($itemJSON, "", $ArquivoJSON);
            }else if(strpos($ArquivoJSON, "[".$itemJSON) !== false){ // É o primeiro item
                $ArquivoJSON = str_replace($itemJSON . ",", "", $ArquivoJSON);
            }else{
                $ArquivoJSON = str_replace(",".$itemJSON, "", $ArquivoJSON);
            }

            $file = fopen("Arquivos/itens.json", "w");
            fwrite($file, $ArquivoJSON);
            fclose($file);
        }


        // Leitura //
        function read_all(){
            return json_decode(file_get_contents("Arquivos/itens.json"));
        }


        function read_by_tipo($tipo){
            $itens = null;
            $todos_itens = json_decode(file_get_contents("Arquivos/itens.json"));
            foreach ( $todos_itens as $i ) {
                if ($i->tipo == $tipo){
                    $itens[] = new Item($i->nome, $i->tipo);
                }
            }
            return $itens;
        }
    }
?>
