<?php

require "Models/Categoria.php";


class CategoriaDao{

    var $DB_USERNAME = 'root';
    var $DB_PASSWORD = 'root';
    var $DB_HOST =  'localhost';
    var $DB_DATABASE = 'my-reservas';

    var $table = "categoria";

   // Conexão //
   private function connect(){

       $conexao = new mysqli($this->DB_HOST, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_DATABASE);

       if (mysqli_connect_error()) {
         die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
       }

       return $conexao;
   }

   private function close($conexao){
       return mysqli_close($conexao);
   }


   // Escrita //
   function insert($categoria){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "INSERT INTO " . $this->table . "(nome) VALUES (\"". $categoria->nome ."\");");
       $this->close($conexao);
       echo $resultado;
       return $resultado;
   }

   function delete($categoria){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "DELETE FROM " . $this->table . " WHERE nome LIKE '" . $categoria->nome . "';");
       $this->close($conexao);
       return $resultado;
   }


   // Leitura //
   function read_all(){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . ";");
       $this->close($conexao);

       $categorias = null;
       for ($i=0; $i< mysqli_num_rows($resultado); $i++){
           $categorias[$i] = mysqli_fetch_object($resultado);
       }
       return $categorias;
   }
}

?>
