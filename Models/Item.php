<?php
    class Item{
        var $nome;
        var $categoria_id;

        function __construct($nome, $categoria_id) {
            $this->nome = $nome;
            $this->categoria_id = $categoria_id;
        }

    }
?>
