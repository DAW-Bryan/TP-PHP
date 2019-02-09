<?php
    class Reserva{
        var $nome;
        var $matricula;
        var $item_id;
        var $tipo_de_reserva;
        var $data;
        var $inicio;
        var $fim;

        function __construct($nome, $matricula, $item_id, $tipo_de_reserva, $data, $inicio, $fim) {
            $this->nome = $nome;
            $this->matricula = $matricula;
            $this->item_id = $item_id;
            $this->tipo_de_reserva = $tipo_de_reserva;
            $this->data = $data;
            $this->inicio = $inicio;
            $this->fim = $fim;
        }

    }
?>
