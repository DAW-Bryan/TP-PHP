<?php
    class Item{
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
