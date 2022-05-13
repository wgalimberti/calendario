<?php

$title = 'Usuários';
$table = 'usuarios';
$fields = [
    ['field'=> 'login', 'size'=> 3, 'name'=>'Login'],
    ['field'=> 'senha', 'size'=> 3, 'name'=>'Senha'],
    ['field'=> 'nome', 'size'=> 3, 'name'=>'Nome'],
    ['field'=> 'email', 'size'=> 3, 'name'=>'Email'],
    ];

$search = "1=1";
$busca = isset($_GET['busca']) ? $_GET['busca']: "";

if($busca!= ""){
    $search = "nome like '%{$busca}%' or email like '%{$busca}%' or login like '%{$busca}%'";
}

function showForm($dados){
    echo '
    <div class="col-sm-6">

        <label>Login</label>
        <input type="text" name="login" class="form-control" value="'.(isset($dados['login']) ? $dados['login']. '" disabled' : '').'"/>

        <label>Senha</label>
        <input type="text" name="senha" class="form-control" value="'.(isset($dados['senha']) ? $dados['senha']: "").'" />

        <label>Nome</label>
        <input type="text" name="nome" class="form-control" value="'.(isset($dados['nome']) ? $dados['nome']: "").'" />

        <label>Email</label>
        <input type="text" name="email" class="form-control" value="'.(isset($dados['email']) ? $dados['email']: "").'" />
    </div>';
}

function saveForm($acao, $id){
    global $table;
    $login = isset($_POST['login']) ? $_POST['login'] : "";
    $senha = isset($_POST['senha']) ? $_POST['senha'] : "";
    $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
    $email = isset($_POST['email']) ? $_POST['email'] : "";
    
    $fields = ['senha'=> $senha, 'nome'=> $nome, 'email'=> $email];

    if($acao == 'add'){
        $fields += ['login' => $login];
        tableInsert($table, $fields);
        redirect('usuarios', 'success-add');
    }else{
        tableUpdate($table, $fields, $id);
        redirect('usuarios', 'success-edit');
    }
}

require __DIR__.'/../inc/crud.php';
