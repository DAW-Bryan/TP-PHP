<?php

require "Models/Item.php";


class ItemDao{
   var $SERVER = "150.164.102.161";
   var $_USER = "sys-reservas";
   var $_PWD = "@c0lteCReserv@s";
   var $_DB = "my-reservas";
   var $table = "item";

   // Conexão //
   private function connect(){
       return mysqli_connect($SERVER, $_USER, $_PWD, $_DB);
   }

   private function close($conexao){
       return mysqli_close($conexao);
   }


   // Escrita //
   function insert($nome, $tipo){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "INSERT INTO " . $table . "(nome, tipo) VALUES (". $nome .", ". $tipo .");");
       $this->close($conexao);
       return $resultado;
   }

   function delete($item){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "DELETE FROM " . $table . " WHERE nome LIKE '" . $item->nome . "';");
       $this->close($conexao);
       return $resultado;
   }


   // Leitura //
   function read_all(){
       $conexao = $this->connect();
       $resultado = mysqli_query($conexao, "SELECT * FROM " . $table . ";");
       $this->close($conexao);

       $itens;
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
