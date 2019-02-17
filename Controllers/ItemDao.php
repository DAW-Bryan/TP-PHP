<?php

require "Models/Item.php";

class ItemDao{

    var $table = "item";

   // Escrita //
   function insert($item){
       $conexao = connect();

       $resultado = mysqli_query($conexao, "INSERT INTO " . $this->table . "(nome, descricao, categoria_id) VALUES (\"". $item->nome ."\", \"$item->descricao\", \"". $item->categoria_id ."\");");
       close($conexao);
       return $resultado;
   }

   function delete($item){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "DELETE FROM " . $this->table . " WHERE nome LIKE '" . $item->nome . "';");
       close($conexao);
       return $resultado;
   }

   function editDesc($item){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "UPDATE " . $this->table . " SET descricao = '" . $item->descricao . "' WHERE nome LIKE '" . $item->nome . "';");
       close($conexao);
       return $resultado;
   }


   // Leitura //
   function read_all(){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "SELECT nome, descricao FROM " . $this->table . ";");
       close($conexao);

       $itens = null;
       for ($i=0; $i< mysqli_num_rows($resultado); $i++){
           $itens[$i] = mysqli_fetch_object($resultado);
       }
       return $itens;
   }

   function read_by_nome($nome){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "SELECT nome, descricao FROM " . $this->table . " WHERE nome LIKE '" . $nome . "';");
       close($conexao);

       return mysqli_fetch_object($resultado);
   }

   function read_by_id($id){
        $conexao = connect();
        $resultado = mysqli_query($conexao, "SELECT nome, descricao FROM " . $this->table . " WHERE id =" . $id . ";");
        close($conexao);

        return mysqli_fetch_object($resultado);
    }

    function read_by_categoria($nome_categoria){
        $conexao = connect();
        $resultado = mysqli_query($conexao, "SELECT item.nome, item.descricao FROM " . $this->table . " JOIN categoria ON  item.categoria_id = categoria.id WHERE categoria.nome LIKE '" . $nome_categoria . "';");
        close($conexao);
        $itens = null;
        for ($i=0; $i< mysqli_num_rows($resultado); $i++){
            $itens[$i] = mysqli_fetch_object($resultado);
        }
        return $itens;
    }

}

$dao_i = new ItemDao();
?>
