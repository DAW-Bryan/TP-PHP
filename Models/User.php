<?php
    class User{
        var $nome;
        var $matricula;
        var $senha;

        function __construct($nome, $matricula, $senha) {
            $this->nome = $nome;
            $this->matricula = $matricula;
            $this->senha = $senha;
        }

    }
?>
