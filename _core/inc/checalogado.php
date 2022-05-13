<?php

include_once __DIR__ . "/functions.php";

//middleware

if(!isset ($_SESSION['logado']) || !$_SESSION['logado']){
    header('location: index.php?p=login');
    exit;
}

?>
