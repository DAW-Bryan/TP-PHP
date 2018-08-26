<?php
    class Espaco{
        var $nome;
        var $tipo;
        var $imagem;
        
        function __construct($nome, $tipo) {
            $this->nome = $nome;
            $this->tipo = $tipo;
            $this->imagem = "Images/".$tipo;
        }

    }
?>