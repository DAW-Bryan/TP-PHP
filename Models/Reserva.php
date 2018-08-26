<?php
    class Reserva{
        var $nome;
        var $matricula;
        var $espaco;
        var $tipo_de_reserva;
        var $data;
        var $inicio;
        var $fim;
        
        function __construct($nome, $matricula, $espaco, $tipo_de_reserva, $data, $inicio, $fim) {
            $this->nome = $nome;
            $this->matricula = $matricula;
            $this->espaco = $espaco;
            $this->tipo_de_reserva = $tipo_de_reserva;
            $this->data = $data;
            $this->inicio = $inicio;
            $this->fim = $fim;
        }

    }
?>