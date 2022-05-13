<?php

include_once __DIR__ . "/_core/inc/functions.php";
$conn = conecta();
if(!$conn){
    echo "Não conectou.";
}
$p = isset($_GET['p']) ? $_GET['p'] : "home";
$msg = isset($_GET['msg']) ? $_GET['msg'] : "";
if($p == "logoff"){
    $_SESSION['logado'] = false;
    header("location: index.php");
    exit;
}
if($p != "login"){
    include_once __DIR__ . "/_core/inc/checalogado.php";
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--<link rel="stylesheet" href="style.css">-->
    <link rel="shortcut icon" href="favicon.png">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    echo '<title>'.$config["Title"].'</title>';
    ?>
    
</head>
<body>
    <nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
        
        </div>
        <ul class="nav navbar-nav">
        <li class="active"><a href="./">Home</a></li>
        <li><a href="./">Calendário</a></li>
        <li><a href="./?p=usuarios">Usuários</a></li>
        <li><a href="./?p=grupos">Grupos</a></li>
        <li><a href="./?p=publicacoes">Publicacões</a></li>
        <li><a href="./?p=depoimentos">Depoimentos</a></li>
        <li><a href="./?p=categorias">Categorias</a></li>
        <li><a href="./?p=logoff">Sair</a></li>
        </ul>
    </div>
    </nav>
    <?php

    $fp = __DIR__ . "/_core/pages/{$p}.php";
    if(file_exists($fp)){
        include $fp;
    }else{
        include __DIR__ . "/_core/pages/404.php";
    }

    if($msg != ''){
        switch($msg){
            case 'error-404' : 
                $mensagem = 'Registro nao encontrado';
                $icon = 'error';
                break;
            case 'success-add' : 
                $mensagem = 'Registro adicionado com sucesso';
                $icon = 'success';
                break;
            case 'success-edit' : 
                $mensagem = 'Registro editado com sucesso';
                $icon = 'success';
                break;
            case 'success-del' : 
                $mensagem = 'Registro excluido com sucesso';
                $icon = 'success';
                break;
        }

        if($mensagem != ''){
        ?>
        <script>
            Swal.fire({
            position: 'top-end',
            icon: '<?=$icon?>',
            title: '<?=$mensagem?>',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
        <?php
        }
    }

    ?>
    
</body>
</html>
