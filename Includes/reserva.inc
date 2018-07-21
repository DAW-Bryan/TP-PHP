<style>
.msg-erro{
    color: red !important;
    font-size: 16px;
}

.input-erro{
    border: 1px solid red !important;
}

.input-erro::placeholder {
    color: red !important;
    opacity: 0.6 !important;
}
</style>


<?php
    function carrega_dados_pessoais($erro){
        ?>

        <form action="reservar.php" class="container" method="POST">            
            <h1 class="title">Dados Pessoais</h1>
            <progress class="progress is-info" value="0" max="100"></progress>
            <div class="field">
                <label class="label">Nome Completo</label>
                <div class="control">
                  <input class="input" type="text" placeholder="Seu nome completo" name="nome">
                </div>
              </div>
              
              <div class="field">
                <label class="label">Email</label>
                <div class="control has-icons-left">
                  <input class="input" type="email" placeholder="Seu email" name="email">
                  <span class="icon is-small is-left">
                    <i class="fas fa-envelope"></i>
                  </span>
                </div>
              </div>
              
              <div class="field">
                  <label class="label">Número de Matrícula</label>
                  <div class="control">
                      <input class="input" type="number" name="matricula" placeholder="Sua Matrícula">
                  </div>
              </div>

              <div class="field is-grouped">
                <div class="control">
                  <button class="button is-link">Próximo</button>
                </div>
                <?php
                    if ($erro){
                        echo '<span class="msg-erro">Todos os campos devem estar preenchidos<span>';
                    }
                ?>
              </div>
            </form>
        <?php
    }

    function carrega_dados_reserva($erro){
        ?>
        
        <form action="reservar.php" class="container" method="POST">            
            <h1 class="title">Dados da Reserva</h1>
            <progress class="progress is-info" value="50" max="100"></progress>
        
            <div class="field">
                <label class="label">Espaço</label>
                <div class="control">
                    <div class="select">
                    <select name="espaco">
                        <option>Auditório</option>
                        <option>Laboratório</option>                        
                        <option>Quadra maior</option>
                        <option>Quadra menor</option>                        
                    </select>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="control">
                    <label for="" class="label">Tipo de reserva</label>
                    <label class="radio"><input type="radio" name="tipo-de-reserva"> Dia único</label>
                    <label class="radio"><input type="radio" name="tipo-de-reserva"> Semanal</label>
                    <label class="radio"><input type="radio" name="tipo-de-reserva"> Mensal</label>
                </div>
            </div>
        
            <label class="label">Data e Horário</label>
            <div class="field is-grouped">
                <div class="control">
                    <label for="">Dia</label>
                    <?php
                        date_default_timezone_set('America/Sao_Paulo');
                        echo '<input class="input" type="date" name="data" value="'.date('Y-m-d', time()).'">';
                    ?>
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
    
    function verifica_disponibilidade($espaco, $data, $inicio, $fim){
        $dao = new ReservaDao();
        $reservas = $dao->read_by_place($espaco);
        if ($reservas != null){
            $inicio = converte_horario_minutos($inicio);
            $fim = converte_horario_minutos($fim);
            foreach ( $reservas as $r ) {
                if ($r->data == $data){
                    $r->inicio = converte_horario_minutos($r->inicio);
                    $r->fim = converte_horario_minutos($r->fim);
                    if (($r->inicio >= $inicio && $r->inicio < $fim) || ($r->fim > $inicio && $r->fim <= $fim)){
                        return 0; // Indisponível
                    }
                }
            }
        }
        return 1; // Disponível
    }
?>