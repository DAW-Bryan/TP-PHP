<?php
    require "Models/Reserva.php";

    class ReservaDao{
        var $table = "reservas";

        // Escrita //
        function insert($reserva){
            $conexao = connect();

            $resultado = mysqli_query($conexao, "INSERT INTO " . $this->table . "(nome, item_id, tipo_de_reserva, data, inicio, fim, matricula)
            VALUES ('". $reserva->nome ."', ". $reserva->item_id .", '". $reserva->tipo_de_reserva ."', '". $reserva->data ."',
            '". $reserva->inicio ."', '". $reserva->fim ."', '". $reserva->matricula ."');");
            close($conexao);
            return $resultado;
        }

        function deleta_antigas(){
            $todas_reservas = $this->read_all();
            foreach ( $todas_reservas as $r ) {
                if (strtotime($r->data) < strtotime(date('Y-m-d')) && $r->tipo_de_reserva != "Semanal"){
                    $this->delete($r);
                }
            }
        }

        function delete($reserva){
            $conexao = connect();
            $resultado = mysqli_query($conexao, "DELETE FROM " . $this->table . " WHERE nome LIKE '" . $reserva->nome . "';");
            close($conexao);
            return $resultado;
        }


        // Leitura //
        function read_all(){
            $conexao = connect();
            $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . ";");
            close($conexao);

            $reservas = null;
            for ($i=0; $i< mysqli_num_rows($resultado); $i++){
                $reservas[$i] = mysqli_fetch_object($resultado);
            }
            return $reservas;
        }


        function read_by_item($nome_item){
            $conexao = connect();
            $resultado = mysqli_query($conexao, "SELECT r.* FROM " . $this->table . " r JOIN item i ON r.item_id = i.id WHERE i.nome LIKE '" . $nome_item . "' ;");
            close($conexao);

            $reservas = null;
            for ($i=0; $i< mysqli_num_rows($resultado); $i++){
                $reservas[$i] = mysqli_fetch_object($resultado);
            }
            return $reservas;
        }

        function read_by_matricula($matricula){
            $conexao = connect();
            $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . " WHERE matricula LIKE '" . $matricula . "';");
            close($conexao);

            $reservas = null;
            for ($i=0; $i< mysqli_num_rows($resultado); $i++){
                $reservas[$i] = mysqli_fetch_object($resultado);
            }
            return $reservas;
        }

        function read_by_date($data){
            $conexao = connect();
            $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . " WHERE data = '" . $data . "' AND tipo_de_reserva LIKE 'Diaria';");
            close($conexao);

            $reservas = [];
            for ($i=0; $i< mysqli_num_rows($resultado); $i++){
                $reservas[$i] = mysqli_fetch_object($resultado);
            }
            return $reservas;
        }
    }

?>
