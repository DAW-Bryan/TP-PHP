<?php

require "Models/Item.php";


class ItemDao{

    var $DB_USERNAME = 'root';
    var $DB_PASSWORD = 'root';
    var $DB_HOST =  'localhost';
    var $DB_DATABASE = 'my-reservas';

    var $table = "item";

   // Conexão //
   private function connect(){

       $mysqli = new mysqli($this->DB_HOST, $this->DB_USERNAME, $this->DB_PASSWORD, $this->DB_DATABASE);

       if (mysqli_connect_error()) {
           die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
       }

       return $mysqli;
   }

   private function close($conexao){
       return $conexao->close();
   }


   // Escrita //
   function insert($item){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "INSERT INTO " . $this->table . "(nome, tipo) VALUES (". $item->nome .", ". $item->tipo .");");
       $this->close($conexao);
       return $resultado;
   }

   function delete($item){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "DELETE FROM " . $this->table . " WHERE nome LIKE '" . $item->nome . "';");
       $this->close($conexao);
       return $resultado;
   }


   // Leitura //
   function read_all(){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . ";");
       $this->close($conexao);

       $itens = null;
       for ($i=0; $i< mysqli_num_rows($resultado); $i++){
           $itens[$i] = mysqli_fetch_object($resultado);
       }
       return $itens;
   }

   function read_by_tipo($tipo){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "SELECT * FROM " . $table . " WHERE tipo LIKE '" . $tipo . "';");
       $this->close($conexao);

       $itens;
       for ($i=0; $i< mysqli_num_rows($resultado); $i++){
           $itens[$i] = mysqli_fetch_object($resultado);
       }
       return $itens;
   }

}

?>
