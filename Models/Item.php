<?php
    class Item{
        var $nome;
        var $descricao;
        var $categoria_id;

        function __construct($nome, $descricao, $categoria_id) {
            $this->nome = $nome;
            $this->descricao = $descricao;
            $this->categoria_id = $categoria_id;
        }

    }
?>
