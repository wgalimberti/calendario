<?php

session_start();

$config = [
    'DefaultPath' => __DIR__ . "/../../",
    'Title' => "Calendario",
    'Filepath' => __DIR__ . "/../db/datas.txt",
    'User' => __DIR__ . "/../db/login.txt",
    'Grup' => __DIR__ . "/../db/grupo.txt",
    'Cats' => __DIR__ . "/../db/categorias.txt",
    'arrayMonth' => ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    'arrayWeek' => ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sab'],

];
