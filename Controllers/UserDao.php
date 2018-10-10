<?php

require "Models/User.php";

class UserDao{

    var $table = "usuarios";

   // Escrita //
   function insert($user){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "INSERT INTO " . $this->table . "(nome, matricula, senha, admin) VALUES ('". $user->nome ."', '". $user->matricula ."', '" . $user->senha . "', false);");
       close($conexao);
       return $resultado;
   }

   function delete($user){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "DELETE FROM " . $this->table . " WHERE matricula LIKE '" . $user->matricula . "';");
       close($conexao);
       return $resultado;
   }

   function give_adm($user){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "UPDATE " . $this->table . " SET admin=true WHERE matricula LIKE '" . $user->matricula . "';");
       close($conexao);
       return $resultado;
   }


   // Leitura //
   function read_all(){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . ";");
       close($conexao);

       $users = null;
       for ($i=0; $i< mysqli_num_rows($resultado); $i++){
           $users[$i] = mysqli_fetch_object($resultado);
       }
       return $users;
   }

   function read_by_nome($user_nome){
       $conexao = connect();
       $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . " WHERE nome LIKE '" . $user_nome . "';");
       close($conexao);

       return mysqli_fetch_object($resultado);
   }

   function read_by_id($matricula){
        $conexao = connect();
        $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . " WHERE matricula LIKE '" . $matricula . "';");
        close($conexao);
        return mysqli_fetch_object($resultado);
    }

    function read_non_admin(){
         $conexao = connect();
         $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . " WHERE admin = false;");
         close($conexao);

         $users = null;
         for ($i=0; $i< mysqli_num_rows($resultado); $i++){
             $users[$i] = mysqli_fetch_object($resultado);
         }
         return $users;
     }

}

?>
