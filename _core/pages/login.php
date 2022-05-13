<?php
$erro = "";

if(count($_POST) > 0){
    $login = isset($_POST["login"]) ? $_POST["login"] : "";
    $senha = isset($_POST["senha"]) ? $_POST["senha"] : "";
    $lg = mysqli_query($conn, "select * from usuarios where login = '$login'");
    
    if($lg->num_rows > 0){
        $row = mysqli_fetch_assoc($lg);
        if($row['senha'] == $senha){
            $_SESSION['logado'] = true;
            $_SESSION['name'] = $login;
            header('location: index.php');
            exit;
        }else{
            $erro = "login ou senha incorretos.";

        }
    }else{
        $erro = "login ou senha incorretos.";
    }
}

?>

<div>
    <?=$erro?>
    <form method="POST" action="index.php?p=login">
        <label for="">Login</label>
        <input name="login" type="text"><br>
        <label for="">Senha</label>
        <input name="senha" type="password"><br>
        <button type="submit">Entrar</button>
    </form>
</div>