<?php
    class Categoria{
        var $nome;
        var $imagem;
        
        function __construct($nome, $imagem) {
            $this->nome = $nome;
            $this->imagem = "Images/". $imagem;
        }
    }
?>
