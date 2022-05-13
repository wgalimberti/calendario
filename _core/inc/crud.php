<?php

echo '<h2>'.$title.'<a class="btn btn-success" href="./?p='.$p.'&acao=add">Adicionar</a></h2>';

echo '<form method="get" action="./">
<div class="row">
<input name="p" value="'.$p.'" type="hidden">
    <div class="col-sm-9">
        <input class="form-control" name="busca" type="text" value="'.$busca.'">
    </div>
    <div class="col-sm-3">
        <button class="btn btn-primary btn-block" type="submit">Buscar</button>
    </div>
</div>
</form>';


$id = isset($_GET['id']) ? $_GET['id']: "";
$acao = isset($_GET['acao']) ? $_GET['acao'] : "list";

if(in_array($acao, ['edit', 'add'])){
    $dados = [];
    if($acao=='edit'){
        $sql = "SELECT * FROM {$table} WHERE id={$id}";
        $conn = conecta();
        $rs = mysqli_query($conn, $sql);
        if($row=mysqli_fetch_assoc($rs)) {
            $dados = $row;
        }else{
            redirect($p,'erro-404');
        }
    }
    if(count($_POST) > 0){
        saveForm($acao, $id);
    }else{
        echo '
        <form method="post" enctype="multipart/form-data" action="index.php?p='.$p.'&acao='.$acao.'&id='.$id.'">
            <fieldset>
                <div class="row">
                    <div class="col-sm-6 col-sm-offset-3">';
                    showForm($dados);
        echo '
                        <div class="col-sm-12 text-center" style="margin-top: 20px;"><button class="btn btn-primary btn-lg" type="submit">Salvar</button></div>
                    </div>
                </div>
            </fieldset>
        </form>';
    }
    
    
}elseif($acao=='del'){
    tableDel($table, $id, isset($imgField) ? $imgField: "");
    
    redirect($p, 'success-del');
}else{
    tableList($table, $fields, $search);
}
