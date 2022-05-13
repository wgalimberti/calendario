<?php

$year = isset($_REQUEST["year"]) ? $_REQUEST["year"] : date('Y');
$arrayWeek = $config["arrayWeek"];
$arrayMonth = $config["arrayMonth"];
$ldates = loadDates();
$acao = isset($_GET["acao"]) ? $_GET["acao"] : "";
if(count($_POST) > 0 && $acao == "grava"){
    $dia = str_pad($_POST['dia'],2,"0", STR_PAD_LEFT); // tratar a entrada do dado
    $mes = str_pad($_POST['mes'],2,"0", STR_PAD_LEFT);
    $nome = $_POST['nome'];
    $data = [
        'data' => $dia . $mes,
        'name' => $nome,
    ];
    saveDates($data);
    $ldates[] = $data;
}

echo '<thead>';

                    
                    echo '<a href="./index.php?year='.($year - 1).'"> < Calendário de '.($year - 1).'</a>';
                    echo '<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">Novo BD</button>';
                    echo '<a href="./index.php?year='.($year + 1).'">Calendário de '.($year + 1).' > </a>';
                    echo '</div>
                </thead>';
                
        echo '<h1>'."Calendário de $year".'</h1>';
        for ($i = 0; $i < 12 ; $i++) { 
            echo '<h3>'.$arrayMonth[$i].'</h3>';
            $firstDayMonth = mktime(0,0,0,$i + 1,1,$year);
            $lastDayMonth = date('t', $firstDayMonth);
            $startWeekDay = date('w', $firstDayMonth);
            $x = 0;

        echo '
        <table width="100%" class="table-striped table-bordered table">
            <thead>
                <tr><th>'.implode('</th><th>', $arrayWeek).'</th></tr>
            </thead>
            <tbody>
            <tr>';
        for ($cont=0; $cont < $startWeekDay; $cont++) { 
            echo '<td>&nbsp;</td>'.PHP_EOL;
            $x++;
        }
            for ($cont = 1; $cont <= $lastDayMonth; $cont++) {
                if ($x++ == 7) {
                    $x = 1;

                    echo '</tr><tr>'.PHP_EOL;
                }
                $name = hasBday($cont, $i+1, $ldates);
                if ($name != ""){
                    echo '<td class="bg-danger"><b><a href="#" data-toggle="tooltip" title="'.$name.'">'.$cont.'</a></b></td>'.PHP_EOL;
                }
                else{
                    echo '<td>'.$cont.'</td>'.PHP_EOL;
                }
            };

        echo '
            </tr>
            </tbody>
        </table>';
    }
    ?>
    
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <form method="POST" action="index.php?acao=grava" class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-4">
                <label for="">Nome</label>
                <input name="nome" type="text" class="form-control" />
            </div>
            <div class="col-sm-4">
                <label for="">Dia</label>
                <input name="dia" type="text" class="form-control" />
            </div>
            <div class="col-sm-4">
                <label for="">Mes</label>
                <input name="mes" type="text" class="form-control" />
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
  </div>
</div>
<script> 
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>