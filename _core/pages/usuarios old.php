<?php

$logins = loadUser();
$login = isset($_GET['login']) ? $_GET['login']: "";
$acao = isset($_GET['acao']) ? $_GET['acao'] : "list";

$search = "1=1";
$busca = isset($_GET['busca']) ? $_GET['busca']: "";

if($busca!= ""){
    $search = "nome like '%{$busca}%' or email like '%{$busca}%' or login like '%{$busca}%'";
}

echo '<h2>Usuários '.
    (
        $acao == 'list' 
        ? '<a class="btn btn-success" href="./?p='.$p.'&acao=add">Adicionar</a>'
        : '<a class="btn btn-default" href="./?p='.$p.'">Voltar</a>'
    ).'</h2>';

if($acao == 'del'){
    $us = mysqli_query($conn, "delete from usuarios where id = $id");
    redirect($p, 'success-del');    

    if($us->num_rows == 0){
        redirect($p, 'error-404');
    }
    
}elseif( in_array($acao,['edit','add'])){

    $arrLogin = [
        'nome' => '',
        'login' => '',
        'senha' => '',
        'email' => '',
    ];
    
    if( $acao == 'edit' ) {
        if(isset($logins[$login])){
            $arrLogin = $logins[$login];
        }else{
            redirect($p, 'error-404');
        }
    
    }

    if(count($_POST) > 0){
        $senha = $_POST['senha'];
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        if($acao == 'edit'){
            $logins[$login] = [
                'senha' => $senha,
                'email' => $email,
                'nome' => $nome,
            ];
        }else{
            $login = $_POST['login'];
            $logins += [
                $login => [
                    'senha' => $senha,
                    'email' => $email,
                    'nome' => $nome,
                ]
            ];
        }

        saveLogins( $logins );

        redirect($p, 'success-'.$acao);

    }else{
        $nome = $arrLogin['nome'];
        $email = $arrLogin['email'];
        $senha = $arrLogin['senha'];
    ?>
   
    <form method="post" action="index.php?p=<?=$p?>&acao=<?=$acao?>&login=<?=$login?>">
        <fieldset>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3">
                    <h2>Usuário</h2>
                    <div class="col-sm-6">
                        <label>Nome</label>
                        <input type="text" class="form-control" value="<?=$nome?>" name="nome" />
                    </div>
                    <div class="col-sm-6">
                        <label>E-mail</label>
                        <input type="email" class="form-control" value="<?=$email?>" name="email" />
                    </div>
                    <div class="col-sm-6">
                        <label>Login</label>
                        <input type="text" <?=($acao == 'edit' ? 'disabled' : '')?> class="form-control" value="<?=$login?>" name="login" />
                    </div>
                    <div class="col-sm-6">
                        <label>Senha</label>
                        <input type="text" class="form-control" value="<?=$senha?>" name="senha" />
                    </div>
                    <div class="col-sm-12 text-center" style="margin-top: 20px;"><button class="btn btn-primary btn-lg">Salvar</button></div>
                </div>
            </div>
        </fieldset>
        <label></label>
    </form>
    
    <?php
    }



}else{
    echo '<table class="table table-striped">';
    foreach ($logins as $key => $v) {
        echo '
        <tr>
            <td><a class="btn btn-primary" href="./?p='.$p.'&acao=edit&login='.$key.'">Editar</a></td>
            <td>'.($v['nome'] == '' ? $key : $v['nome']).'</td>
            <td>'.$v['email'].'</td>
            <td><a class="btn btn-danger" href="javascript:;" onclick="if(confirm(\'Deseja realmente excluir o Usuário?\')){location=\'index.php?p='.$p.'&acao=del&login='.$key.'\';}">Excluir</a></td>
        </tr>    
        ';
    }
    echo '</table>';
}
