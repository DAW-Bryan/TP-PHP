
<?php
    require "Controllers/ReservaDao.php";
    require "Controllers/ItemDao.php";
    require "Controllers/CategoriaDao.php";
    require "Controllers/UserDao.php";
    require "Controllers/Database.php";

    // Funções para realizar reservas //

    function carrega_reserva($erro){
        $dao_i = new ItemDao();
        ?>

        <form action="reservar.php" class="container" method="POST" id="reservas-form">
            <h1 class="title">Dados da Reserva</h1>

            <div class="field">
                <label class="label">Nome da Reserva</label>
                <input type="text" name="nome" placeholder="Digite o nome da sua reserva" class="input">
            </div>

            <div class="field">
                <label class="label">Itens</label>
                <div class="control">
                    <div class="select">
                    <select name="item">
                    <?php
                        $itens = $dao_i->read_all();
                        foreach ($itens as $i){
                            echo '<option>' . $i->nome . '</option>';
                        }
                    ?>
                    </select>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label for="" class="label">Tipo de reserva</label>
                    <label class="radio"><input type="radio" name="tipo-de-reserva" value="Diaria" checked> Dia único</label>
                    <label class="radio"><input type="radio" name="tipo-de-reserva" value="Semanal"> Semanal</label>
                </div>
            </div>

            <label class="label">Data e Horário</label>
            <div class="field is-grouped">
                <div class="control" id="dia">
                    <label for="">Dia</label>
                </div>

                <div class="control">
                    <label for="">Inicio</label>
                    <input class="input" type="time" name="inicio">
                </div>

                <div class="control">
                    <label for="">Término</label>
                    <input class="input" type="time" name="termino">
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label class="checkbox">
                    <input type="checkbox" name="declaracao">
                    Eu declaro que aceito os <a href="#">termos e condições</a>
                    </label>
                </div>
            </div>
            <div class="field">
            <div class="control">
                <button class="button is-link">Próximo</button>
            </div>
            <?php
                if ($erro == 1){
                    echo '<span class="msg-erro">Você precisa aceitar os termos e condições</span>';
                }else if ($erro == 2){
                    echo '<span class="msg-erro">Preencha todos os campos</span>';
                }else if ($erro == 3){
                    echo '<span class="msg-erro">Horário indisponível</span>';
                }
            ?>
            </div>
        </form>
        <?php
    }


    function converte_horario_minutos($horario){
        list ($horas, $minutos) = explode (':', $horario);
        return ($horas*60)+$minutos;
    }

    function verifica_disponibilidade($item, $tipo, $data, $inicio, $fim){
        $dao_r = new ReservaDao();


        $inicio = converte_horario_minutos($inicio);
        $fim = converte_horario_minutos($fim);

        if ($inicio >= $fim){
            return 0;
        }

        $reservas = $dao_r->read_by_item($item);

        if ($reservas != null){
            foreach ( $reservas as $r ) {
                if ($r->tipo_de_reserva == $tipo){ // Mesmo tipo
                    if ($r->data == $data){
                        $r->inicio = converte_horario_minutos($r->inicio);
                        $r->fim = converte_horario_minutos($r->fim);
                        if (($inicio >= $r->inicio && $inicio < $r->fim) || ($fim > $r->inicio && $fim <= $r->fim) || ($r->inicio >= $inicio && $r->inicio < $fim) || ($r->fim > $inicio && $r->fim <= $fim)){
                            return 0; // Indisponível
                        }
                    }
                }else if ($r->tipo_de_reserva == "Diaria"){ // Diária x Semanal
                    if (date('w', strtotime($r->data)) == $data){
                        $r->inicio = converte_horario_minutos($r->inicio);
                        $r->fim = converte_horario_minutos($r->fim);
                        if (($inicio >= $r->inicio && $inicio < $r->fim) || ($fim > $r->inicio && $fim <= $r->fim) || ($r->inicio >= $inicio && $r->inicio < $fim) || ($r->fim > $inicio && $r->fim <= $fim) ){
                            return 0; // Indisponível
                        }
                    }
                }else{ // Reserva Semanal x Diária
                    if (date('w', strtotime($data)) == $r->data){
                        $r->inicio = converte_horario_minutos($r->inicio);
                        $r->fim = converte_horario_minutos($r->fim);
                        if (($inicio >= $r->inicio && $inicio < $r->fim) || ($fim > $r->inicio && $fim <= $r->fim) || ($r->inicio >= $inicio && $r->inicio < $fim) || ($r->fim > $inicio && $r->fim <= $fim)){
                            return 0; // Indisponível
                        }

                    }
                }
            }
        }


        $reservas = $dao_r->read_veiculos($item);
        if ($reservas != false){
            foreach ( $reservas as $r ) {
                if ($r->tipo_de_reserva == $tipo){ // Mesmo tipo
                    if ($r->data == $data){
                        $r->inicio = converte_horario_minutos($r->inicio);
                        $r->fim = converte_horario_minutos($r->fim);
                        if (($inicio >= $r->inicio && $inicio < $r->fim) || ($fim > $r->inicio && $fim <= $r->fim) || ($r->inicio >= $inicio && $r->inicio < $fim) || ($r->fim > $inicio && $r->fim <= $fim)){
                            return 0; // Indisponível
                        }
                    }
                }else if ($r->tipo_de_reserva == "Diaria"){ // Diária x Semanal
                    if (date('w', strtotime($r->data)) == $data){
                        $r->inicio = converte_horario_minutos($r->inicio);
                        $r->fim = converte_horario_minutos($r->fim);
                        if (($inicio >= $r->inicio && $inicio < $r->fim) || ($fim > $r->inicio && $fim <= $r->fim) || ($r->inicio >= $inicio && $r->inicio < $fim) || ($r->fim > $inicio && $r->fim <= $fim) ){
                            return 0; // Indisponível
                        }
                    }
                }else{ // Reserva Semanal x Diária
                    if (date('w', strtotime($data)) == $r->data){
                        $r->inicio = converte_horario_minutos($r->inicio);
                        $r->fim = converte_horario_minutos($r->fim);
                        if (($inicio >= $r->inicio && $inicio < $r->fim) || ($fim > $r->inicio && $fim <= $r->fim) || ($r->inicio >= $inicio && $r->inicio < $fim) || ($r->fim > $inicio && $r->fim <= $fim)){
                            return 0; // Indisponível
                        }

                    }
                }
            }
        }



        return 1; // Disponível
    }


 // Funções para Listar Reservas //

function convert_num_to_weekday($num){
    if ($num == "1"){
        return "Segunda";
    }else if ($num == "2"){
        return "Terça";
    }else if ($num == "3"){
        return "Quarta";
    }else if ($num == "4"){
        return "Quinta";
    }else if ($num == "5"){
        return "Sexta";
    }else if ($num == "6"){
        return "Sábado";
    }else {
        return "Domingo";
    }
}


 function print_reservas_da_pessoa($reservas){
     $dao_i = new ItemDao();

    if ($reservas != null){
        ?>
        <form action="index.php" method="GET">
          <h2 class='subtitle'> Reservas realizadas </h2>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Tipo de Reserva</th>
                    <th>Data/Dia</th>
                    <th>Início</th>
                    <th>Término</th>
                    <th class="has-text-centered">Deletar</th>
                </tr>
            </thead>
            <tbody>
        <?php
        $i = 0;
        foreach ( $reservas as $r ) {
            $item = $dao_i->read_by_id($r->item_id);
            echo '<tr>';
            echo '<td>'. $item->nome .'</div>';
            echo '<td>'. $r->tipo_de_reserva .'</div>';

            if ($r->tipo_de_reserva == "Semanal"){
                $r->data = convert_num_to_weekday($r->data);
            }

            echo '<td>'. $r->data .'</div>';
            echo '<td>'. $r->inicio .'</div>';
            echo '<td>'. $r->fim .'</div>';
            echo '<td class="has-text-centered"><button type="submit" name="reserva" value="'. $i . '" class="delete has-background-danger"></button></td>';
            echo '</tr>';
            $i++;
        }
        echo '</tbody></table></form>';
    }else{
        echo '<h2>Nenhuma reserva cadastrada</h2>';
    }
}

function print_reservas_por_item($reservas) {
    $dao_u = new UserDao();
    if ($reservas != null){
        ?>
        <div class="card is-horizontal">
        <div class="card-content" style="overflow-y: scroll">
          <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Usuário</th>
                    <th>Tipo de Reserva</th>
                    <th>Data/Dia</th>
                    <th>Início</th>
                    <th>Término</th>
                </tr>
            </thead>
            <tbody>
        <?php
        $i = 0;
        foreach ( $reservas as $r ) {
            $usuario = $dao_u->read_by_id($r->matricula);
            echo '<tr>';
            echo '<td>'. $usuario->nome .'</div>';
            echo '<td>'. $r->tipo_de_reserva .'</div>';

            if ($r->tipo_de_reserva == "Semanal"){
                $r->data = convert_num_to_weekday($r->data);
            }

            echo '<td>'. $r->data .'</div>';
            echo '<td>'. $r->inicio .'</div>';
            echo '<td>'. $r->fim .'</div>';
            echo '</tr>';
            $i++;
        }
        echo '</tbody></table> </div> </div>';
    }else{
        echo '<div class="card is-horizontal">
                <div class="card-content">
                  <span class="icon">
                    <i class="fas fa-exclamation-triangle"></i>
                  </span>
                  <span class="title is-5"> Nenhuma reserva cadastrada para esse item </span>
                </div>
              </div>';
    }
}

function print_reservas_semana($reservas){
    $dao_i = new ItemDao();
    $dao_u = new UserDao();
    if ($reservas != null){
        ?>
        <table class="table is-hoverable is-fullwidth">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Usuário</th>
                    <th>Tipo de Reserva</th>
                    <th>Dia</th>
                    <th>Início</th>
                    <th>Término</th>
                </tr>
            </thead>
            <tbody>
        <?php
        $i = 0;
        foreach ( $reservas as $r ) {
            $item = $dao_i->read_by_id($r->item_id);
            $usuario = $dao_u->read_by_id($r->matricula);
            echo '<tr>';
            echo '<td>'. $item->nome .'</div>';
            echo '<td>'. $usuario->nome .'</div>';
            echo '<td>'. $r->tipo_de_reserva .'</div>';

            if ($r->tipo_de_reserva == "Semanal"){
                $r->data = convert_num_to_weekday($r->data);
            }else{
                $r->data = convert_num_to_weekday(date('w', strtotime($r->data)));
            }

            echo '<td>'. $r->data .'</div>';
            echo '<td>'. $r->inicio .'</div>';
            echo '<td>'. $r->fim .'</div>';
            echo '</tr>';
            $i++;
        }
        echo '</tbody></table>';
    }else{
        echo 'Nenhuma reserva';
    }
}

function print_todas_as_reservas($reservas) {
    $dao_i = new ItemDao;
    $dao_u = new UserDao();
  if ($reservas) {
      ?>
      <table class="table is-hoverable is-fullwidth">
          <thead>
              <tr>
                  <th>Nome</th>
                  <th>Item</th>
                  <th>Usuário</th>
                  <th>Tipo de Reserva</th>
                  <th>Dia</th>
                  <th>Início</th>
                  <th>Término</th>
              </tr>
          </thead>
          <tbody>
      <?php
      $i = 0;
      foreach ( $reservas as $r ) {
          $item = $dao_i->read_by_id($r->item_id);
          $usuario = $dao_u->read_by_id($r->matricula);
          echo '<tr>';
          echo '<td>'. $r->nome . '</div>';
          echo '<td>'. $item->nome .'</div>';
          echo '<td>'. $usuario->nome .'</div>';
          echo '<td>'. $r->tipo_de_reserva .'</div>';

          if ($r->tipo_de_reserva == "Semanal"){
              $r->data = convert_num_to_weekday($r->data);
          }else{
              $r->data = convert_num_to_weekday(date('w', strtotime($r->data)));
          }

          echo '<td>'. $r->data .'</div>';
          echo '<td>'. $r->inicio .'</div>';
          echo '<td>'. $r->fim .'</div>';
          echo '</tr>';
          $i++;
      }
      echo '</tbody></table>';
  }else{
      echo '<p>Nenhuma reserva realizada</p>
            <a class="button is-info is-outlined" href="reservar.php"> Fazer uma reserva</a> <br>';
  }
}


?>
