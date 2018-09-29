
<div id="cal">
    <table class="table" >
    <thead>
        <tr>
            <th><abbr title="Domingo">D</abbr></th>
            <th><abbr title="Segunda">S</abbr></th>
            <th><abbr title="Terça">T</abbr></th>
            <th><abbr title="Quarta">Q</abbr></th>
            <th><abbr title="Quinta">Q</abbr></th>
            <th><abbr title="Sexta">S</abbr></th>
            <th><abbr title="Sábado">S</abbr></th>
        </tr>
    </thead>

    <tbody>
        
        <?php
            date_default_timezone_set('America/Sao_Paulo');
            $today = getdate();
            $primeiro_dia = getdate(strtotime('01-'.$today['mon'].'-'.$today['year']));

            $num_dias = cal_days_in_month(CAL_GREGORIAN,  intval($today['mon']), intval($today['year']));

            $num_semanas = 0;
            
            if ($primeiro_dia['wday'] == '6' || ($primeiro_dia['wday'] == '5' && $num_dias == 31)) {
                $num_semanas = 6;
            }else if ($num_dias == 28 && $primeiro_dia['wday'] == 0){
                $num_semanas = 4;
            }else{
                $num_semanas = 5;
            }


            $num_tds = 0;
            $dia = 1;
            for ($semana=0; $semana< $num_semanas; $semana++){
                echo "<tr>";
                if ($semana==0){
                    while($num_tds < $primeiro_dia['wday']){
                        echo "<td></td>";
                        $num_tds++;
                    }

                    while ($num_tds <= 6){
                        echo "<td><a href='index.php?data=". $today['year'] . "-" . add_zero($today['mon']) ."-" . add_zero($dia) ."'>".$dia."</a></td>";
                        $dia++;
                        $num_tds++;
                        
                    }
                }else{
                    for ($i=0; $i<7; $i++){
                        if ($dia <= $num_dias){
                            echo "<td><a href='index.php?data=". $today['year'] . "-" . add_zero($today['mon']) ."-" . add_zero($dia) ."'>".$dia."</a></td>";
                            $dia++;
                        }else{
                            echo "<td></td>";
                        }
                        
                        $num_tds++;
                        
                    }
                }
                echo "</tr>";
            }
        ?>

    </tbody>

    </table>
</div>

<?php function add_zero($str_numero){
    if (intval($str_numero) < 10){
        return "0".$str_numero;
    }else{
        return $str_numero;
    }
}
?>