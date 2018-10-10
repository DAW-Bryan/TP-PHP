<?php

require "Models/Categoria.php";

class CategoriaDao{

    var $table = "categoria";

   // Escrita //
   function insert($categoria){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "INSERT INTO " . $this->table . "(nome) VALUES (\"". $categoria->nome ."\");");
       close($conexao);
       return $resultado;
   }

   function delete($categoria){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "DELETE FROM " . $this->table . " WHERE nome LIKE '" . $categoria->nome . "';");
       close($conexao);
       return $resultado;
   }


   // Leitura //
   function read_all(){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . ";");
       close($conexao);

       $categorias = null;
       for ($i=0; $i< mysqli_num_rows($resultado); $i++){
           $categorias[$i] = mysqli_fetch_object($resultado);
       }
       return $categorias;
   }

   function read_by_name($nome){
        $conexao = connect();
        $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . " WHERE nome LIKE '" . $nome . "';");
        close($conexao);
        
        return mysqli_fetch_object($resultado);;
    }
}

?>
