<?php
    require "Models/Reserva.php";

    class ReservaDao{
        var $table = "reservas";

        // Escrita //
        function insert($reserva){
            $conexao = connect();

            $resultado = mysqli_query($conexao, "INSERT INTO " . $this->table . "(nome, item_id, tipo_de_reserva, data, prazo, inicio, fim, matricula)
            VALUES ('". $reserva->nome ."', ". $reserva->item_id .", '". $reserva->tipo_de_reserva ."', '". $reserva->data ."', '". $reserva->prazo ."',
            '". $reserva->inicio ."', '". $reserva->fim ."', '". $reserva->matricula ."');");
            close($conexao);
            return $resultado;
        }

        function deleta_antigas(){
            $todas_reservas = $this->read_all();
            if ($todas_reservas != null){
                foreach ( $todas_reservas as $r ) {
                    if (strtotime($r->data) < strtotime(date('Y-m-d')) && $r->tipo_de_reserva != "Semanal"){
                        $this->delete($r);
                    }else if ($r->prazo < date('n') && $r->tipo_de_reserva == "Semanal"){
                        $this->delete($r);
                    }
                }
            }
        }

        function delete($reserva){
            $conexao = connect();
            $resultado = mysqli_query($conexao, "DELETE FROM " . $this->table . " WHERE item_id LIKE '" . $reserva->item_id . "' AND data LIKE '" . $reserva->data . "' AND inicio LIKE '" . $reserva->inicio . "';");
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
            $dia_da_semana = date('w', strtotime($data));
            $resultado = mysqli_query($conexao, "SELECT * FROM " . $this->table . " WHERE data = '" . $data . "' OR data = '". $dia_da_semana . "';");
            close($conexao);

            $reservas = [];
            for ($i=0; $i< mysqli_num_rows($resultado); $i++){
                $reservas[$i] = mysqli_fetch_object($resultado);
            }
            return $reservas;
        }

        function read_veiculos($nome_item){

            $conexao = connect();
            if (mysqli_query($conexao, "SELECT * FROM item JOIN categoria ON item.categoria_id = categoria.id WHERE item.nome LIKE '" . $nome_item . "' AND categoria.nome LIKE 'Veículos';") != null){
                $resultado = mysqli_query($conexao, "SELECT reservas.* FROM " . $this->table . " JOIN item ON item.id = reservas.item_id
                    JOIN categoria ON item.categoria_id = categoria.id WHERE categoria.nome LIKE 'Veículos';");

                $reservas = [];
                for ($i=0; $i< mysqli_num_rows($resultado); $i++){
                    $reservas[$i] = mysqli_fetch_object($resultado);
                }
                return $reservas;
            }else{
                return false;
            }
        }
    }

    $dao_r = new ReservaDao();

?>
