<?php
    DEFINE('DB_USERNAME', 'sys-reservas');
    DEFINE('DB_PASSWORD', '@c0lteCReserv@s');
    DEFINE('DB_HOST', 'localhost');
    DEFINE('DB_DATABASE', 'my-reservas');
/*
    DEFINE('DB_USERNAME', 'root');
    DEFINE('DB_PASSWORD', '');
    DEFINE('DB_HOST', 'localhost:3306');
    DEFINE('DB_DATABASE', 'my-reservas');
*/
    function connect(){

        $conexao = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

        if (mysqli_connect_error()) {
            die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
        }

        return $conexao;
    }

    function close($conexao){
        return mysqli_close($conexao);
    }

?>
