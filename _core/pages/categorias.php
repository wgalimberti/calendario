<?php

$title = 'Categorias';
$table = 'categorias';
$fields = [['field'=> 'nome', 'size'=> 11, 'name'=>'Nome'],];

$search = "1=1";
$busca = isset($_GET['busca']) ? $_GET['busca']: "";

if($busca!= ""){
    $search = "nome like '%{$busca}%'";
}

function showForm($dados){
    echo '
    <div class="col-sm-6">
        <label>Nome</label>
        <input type="text" class="form-control" value="'.(isset($dados['nome']) ? $dados['nome']: "").'" name="nome" />
    </div>';
}

function saveForm($acao, $id){
    global $table;
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $fields = ['nome'=> $nome];
    if($acao == 'add'){
        tableInsert($table, $fields);
        redirect('categorias', 'success-add');
    }else{
        tableUpdate($table, $fields, $id);
        redirect('categorias', 'success-edit');
    }
}

require __DIR__.'/../inc/crud.php';
